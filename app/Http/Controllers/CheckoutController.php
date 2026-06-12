<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Mail\NewOrderAdmin;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{
    private function getRazorpayApi(): Api
    {
        $key = SiteSetting::get('razorpay_key') ?: config('services.razorpay.key');
        $secret = SiteSetting::get('razorpay_secret') ?: config('services.razorpay.secret');

        if (empty($key) || empty($secret)) {
            throw new \RuntimeException('payment_not_configured');
        }

        return new Api($key, $secret);
    }

    public function index()
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Stock verification before showing checkout
        $stockIssues = $this->checkStockAvailability($cartItems);
        if ($stockIssues->isNotEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Some items in your cart have stock issues: ' . $stockIssues->implode(', '));
        }

        $subtotal = round($cartItems->sum(fn($item) => ($item->price ?? $item->product->display_price) * $item->quantity));
        $freeShippingThreshold = (float) SiteSetting::get('free_shipping_threshold', 5000);
        $shippingCharge = (float) SiteSetting::get('shipping_charge', 99);
        $shipping = $subtotal >= $freeShippingThreshold ? 0 : $shippingCharge;

        // Apply coupon discount
        $couponDiscount = 0;
        $couponData = session('coupon');
        if ($couponData) {
            $coupon = \App\Models\Coupon::find($couponData['id']);
            if ($coupon) {
                $validation = $coupon->isValid($subtotal, Auth::id());
                if ($validation['valid']) {
                    $couponDiscount = $coupon->calculateDiscount($subtotal);
                } else {
                    session()->forget('coupon');
                }
            } else {
                session()->forget('coupon');
            }
        }

        $total = round($subtotal - $couponDiscount + $shipping);

        $addresses = Auth::check() ? Address::where('user_id', Auth::id())->get() : collect();

        return view('pages.checkout', compact('cartItems', 'subtotal', 'shipping', 'total', 'addresses', 'freeShippingThreshold', 'couponDiscount', 'couponData'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|size:10|regex:/^[6-9][0-9]{9}$/',
            'address_line_1' => 'required|string|max:500',
            'address_line_2' => 'nullable|string|max:500',
            'city' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/',
            'state' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/',
            'pincode' => 'required|string|size:6|regex:/^[0-9]{6}$/',
            'save_address' => 'boolean',
            'notes' => 'nullable|string|max:1000',
        ], [
            'name.regex' => 'Name should contain only letters and spaces.',
            // 'phone.regex' => 'Phone number must start with 6,7, 8, or 9 and be 10 digits.',
            'phone.size' => 'Phone number must be exactly 10 digits.',
            'city.regex' => 'City should contain only letters and spaces.',
            'state.regex' => 'State should contain only letters and spaces.',
            'pincode.regex' => 'Pincode must be exactly 6 digits.',
            'pincode.size' => 'Pincode must be exactly 6 digits.',
        ]);

        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = round($cartItems->sum(fn($item) => ($item->price ?? $item->product->display_price) * $item->quantity));
        $freeShippingThreshold = (float) SiteSetting::get('free_shipping_threshold', 5000);
        $shippingCharge = (float) SiteSetting::get('shipping_charge', 99);
        $shipping = $subtotal >= $freeShippingThreshold ? 0 : $shippingCharge;

        // Apply coupon discount
        $couponDiscount = 0;
        $couponData = session('coupon');
        if ($couponData) {
            $coupon = \App\Models\Coupon::find($couponData['id']);
            if ($coupon) {
                $validation = $coupon->isValid($subtotal, Auth::id());
                if ($validation['valid']) {
                    $couponDiscount = $coupon->calculateDiscount($subtotal);
                } else {
                    session()->forget('coupon');
                    $couponData = null;
                }
            } else {
                session()->forget('coupon');
                $couponData = null;
            }
        }

        $total = round($subtotal - $couponDiscount + $shipping);

        if (Auth::check() && $request->save_address) {
            Address::create([
                'user_id' => Auth::id(),
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'address_line_1' => $validated['address_line_1'],
                'address_line_2' => $validated['address_line_2'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'pincode' => $validated['pincode'],
            ]);
        }

        try {
            $api = $this->getRazorpayApi();

            $razorpayOrder = $api->order->create([
                'amount' => $total * 100,
                'currency' => 'INR',
                'receipt' => 'order_' . time(),
            ]);
        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'payment_not_configured') {
                return back()->withInput()->with('error', 'Payment gateway is not configured. Please contact the store administrator.');
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Razorpay Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Payment error: ' . $e->getMessage());
        }

        // Create the order immediately with payment_status = pending
        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'billing_name' => $validated['name'],
                'billing_email' => $validated['email'],
                'billing_phone' => $validated['phone'],
                'billing_address' => $validated['address_line_1'] . (!empty($validated['address_line_2']) ? ', ' . $validated['address_line_2'] : ''),
                'billing_city' => $validated['city'],
                'billing_state' => $validated['state'],
                'billing_pincode' => $validated['pincode'],
                'subtotal' => $subtotal,
                'discount' => $couponDiscount,
                'coupon_code' => $couponData ? $couponData['code'] : null,
                'coupon_id' => $couponData ? $couponData['id'] : null,
                'shipping' => $shipping,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'razorpay',
                'razorpay_order_id' => $razorpayOrder->id,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($cartItems as $item) {
                $product = \App\Models\Product::find($item->product_id);
                $productColor = $item->product_color_id
                    ? \App\Models\ProductColor::find($item->product_color_id)
                    : null;

                $availableStock = $productColor ? $productColor->stock : $product->stock;
                if (!$product->is_preorder && $availableStock < $item->quantity) {
                    DB::rollBack();
                    $colorLabel = $productColor && $productColor->color ? " ({$productColor->color->name})" : '';
                    return redirect()->route('cart.index')->with('error', "{$product->name}{$colorLabel} only has {$availableStock} in stock. Please update your cart.");
                }

                $unitPrice = $item->price ?? $product->display_price;
                $colorName = $productColor && $productColor->color ? $productColor->color->name : null;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_color_id' => $item->product_color_id,
                    'product_name' => $product->name . ($colorName ? ' - ' . $colorName : ''),
                    'product_sku' => $product->sku,
                    'price' => $product->price,
                    'discount' => $product->discount,
                    'discounted_price' => $unitPrice,
                    'quantity' => $item->quantity,
                    'with_blouse' => $item->with_blouse,
                    'total' => $unitPrice * $item->quantity,
                ]);
            }

            // Clear cart
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            } else {
                Cart::where('session_id', session()->getId())->delete();
            }

            // Record coupon usage
            if (!empty($couponData['id'])) {
                $coupon = \App\Models\Coupon::find($couponData['id']);
                if ($coupon) {
                    \App\Models\CouponUsage::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => Auth::id(),
                        'order_id' => $order->id,
                        'discount_amount' => $couponDiscount,
                    ]);
                    $coupon->increment('times_used');
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create order. Please try again.');
        }

        session([
            'checkout_data' => [
                'order_id' => $order->id,
                'razorpay_order_id' => $razorpayOrder->id,
            ],
        ]);

        session()->forget('coupon');

        $razorpayKey = SiteSetting::get('razorpay_key') ?: config('services.razorpay.key');

        return view('pages.payment', [
            'razorpayOrderId' => $razorpayOrder->id,
            'razorpayKey' => $razorpayKey,
            'total' => $total,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'orderNumber' => $order->order_number,
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required',
        ]);

        $checkoutData = session('checkout_data');

        if (!$checkoutData || $checkoutData['razorpay_order_id'] !== $request->razorpay_order_id) {
            return redirect()->route('checkout.index')->with('error', 'Invalid payment session.');
        }

        $order = Order::find($checkoutData['order_id']);

        if (!$order) {
            return redirect()->route('checkout.index')->with('error', 'Order not found. Please contact support.');
        }

        try {
            $api = $this->getRazorpayApi();
        } catch (\Exception $e) {
            return redirect()->route('checkout.index')->with('error', 'Payment gateway is not configured. Please contact the store administrator.');
        }

        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);
        } catch (\Exception $e) {
            $this->deductOrderStock($order);
            $order->update(['payment_status' => 'failed']);
            return redirect()->route('checkout.index')->with('error', 'Payment verification failed. If money was deducted, it will be refunded within 5-7 business days.');
        }

        // Payment confirmed — deduct stock and update order
        $this->deductOrderStock($order);
        $order->update([
            'status' => 'processing',
            'payment_status' => 'paid',
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ]);

        // Send emails (wrapped separately so checkout succeeds even if mail fails)
        try {
            Mail::to($order->billing_email)->send(new OrderConfirmation($order->load('items')));
            Mail::to('amsukham@gmail.com')->send(new NewOrderAdmin($order));
        } catch (\Exception $mailException) {
            \Log::error('Order email failed for ' . $order->order_number . ': ' . $mailException->getMessage());
        }

        session()->forget('checkout_data');

        return redirect()->route('order.success', $order->order_number);
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        return view('pages.order-success', compact('order'));
    }

    public function failure($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        return view('pages.order-failure', compact('order'));
    }

    public function trackOrder(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|string',
            'email' => 'nullable|email',
        ]);

        $query = Order::where('order_number', $validated['order_number']);

        if (!empty($validated['email'])) {
            $query->where('email', $validated['email']);
        }

        $order = $query->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found. Please check your order number and try again.'
            ], 404);
        }

        $statusLabels = [
            'pending' => 'Order Received',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'status_label' => $statusLabels[$order->status] ?? ucfirst($order->status),
                'order_date' => $order->created_at->format('d M Y'),
                'total' => number_format($order->total, 2),
                'tracking_number' => $order->tracking_number ?? null,
            ]
        ]);
    }

    public function viewOrder($id)
    {
        $order = Order::with(['items.product.primaryImage.media'])
            ->findOrFail($id);

        $statusLabels = [
            'pending' => 'Order Received',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];

        return view('pages.order-details', compact('order', 'statusLabels'));
    }

    private function checkStockAvailability($cartItems): \Illuminate\Support\Collection
    {
        $issues = collect();

        foreach ($cartItems as $item) {
            $product = $item->product;
            if (!$product || !$product->is_active) {
                $issues->push("{$product->name} is no longer available");
                continue;
            }

            // Preorder products skip all stock checks
            if ($product->is_preorder) {
                continue;
            }

            $availableStock = $item->product_color_id
                ? (\App\Models\ProductColor::find($item->product_color_id)->stock ?? 0)
                : $product->stock;

            if ($availableStock <= 0) {
                $colorName = $item->productColor && $item->productColor->color ? " ({$item->productColor->color->name})" : '';
                $issues->push("{$product->name}{$colorName} is out of stock");
            } elseif ($item->quantity > $availableStock) {
                $colorName = $item->productColor && $item->productColor->color ? " ({$item->productColor->color->name})" : '';
                $issues->push("{$product->name}{$colorName} only has {$availableStock} in stock");
            }
        }

        return $issues;
    }

    private function getCartItems()
    {
        if (Auth::check()) {
            return Cart::with(['product.primaryImage.media', 'productColor.color'])
                ->where('user_id', Auth::id())
                ->get();
        }

        return Cart::with(['product.primaryImage.media', 'productColor.color'])
            ->where('session_id', session()->getId())
            ->get();
    }

    private function deductOrderStock(Order $order): void
    {
        if ($order->payment_status !== 'pending') {
            return;
        }

        $order->loadMissing('items');

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                Product::where('id', $item->product_id)
                    ->where('stock', '>=', $item->quantity)
                    ->update(['stock' => DB::raw('stock - ' . (int) $item->quantity)]);

                if ($item->product_color_id) {
                    ProductColor::where('id', $item->product_color_id)
                        ->where('stock', '>=', $item->quantity)
                        ->update(['stock' => DB::raw('stock - ' . (int) $item->quantity)]);
                }
            }
        });
    }
}
