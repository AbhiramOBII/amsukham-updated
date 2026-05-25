<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SiteSetting;
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

        $subtotal = round($cartItems->sum(fn($item) => ($item->price ?? $item->product->display_price) * $item->quantity));
        $shipping = $subtotal >= 5000 ? 0 : 99;
        $total = round($subtotal + $shipping);

        $addresses = Auth::check() ? Address::where('user_id', Auth::id())->get() : collect();

        return view('pages.checkout', compact('cartItems', 'subtotal', 'shipping', 'total', 'addresses'));
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
        $shipping = $subtotal >= 5000 ? 0 : 99;
        $total = round($subtotal + $shipping);

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

        session([
            'checkout_data' => [
                'billing' => $validated,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
                'razorpay_order_id' => $razorpayOrder->id,
            ],
        ]);

        $razorpayKey = SiteSetting::get('razorpay_key') ?: config('services.razorpay.key');

        return view('pages.payment', [
            'razorpayOrderId' => $razorpayOrder->id,
            'razorpayKey' => $razorpayKey,
            'total' => $total,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
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
            return redirect()->route('checkout.index')->with('error', 'Payment verification failed. If money was deducted, it will be refunded within 5-7 business days.');
        }

        $cartItems = $this->getCartItems();
        $billing = $checkoutData['billing'];

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'billing_name' => $billing['name'],
                'billing_email' => $billing['email'],
                'billing_phone' => $billing['phone'],
                'billing_address' => $billing['address_line_1'] . ($billing['address_line_2'] ? ', ' . $billing['address_line_2'] : ''),
                'billing_city' => $billing['city'],
                'billing_state' => $billing['state'],
                'billing_pincode' => $billing['pincode'],
                'subtotal' => $checkoutData['subtotal'],
                'shipping' => $checkoutData['shipping'],
                'total' => $checkoutData['total'],
                'status' => 'processing',
                'payment_status' => 'paid',
                'payment_method' => 'razorpay',
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'notes' => $billing['notes'] ?? null,
            ]);

            foreach ($cartItems as $item) {
                $unitPrice = $item->price ?? $item->product->display_price;
                $colorName = $item->productColor && $item->productColor->color ? $item->productColor->color->name : null;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_color_id' => $item->product_color_id,
                    'product_name' => $item->product->name . ($colorName ? ' - ' . $colorName : ''),
                    'product_sku' => $item->product->sku,
                    'price' => $item->product->price,
                    'discount' => $item->product->discount,
                    'discounted_price' => $unitPrice,
                    'quantity' => $item->quantity,
                    'with_blouse' => $item->with_blouse,
                    'total' => $unitPrice * $item->quantity,
                ]);

                // Reduce stock from the selected color
                if ($item->productColor) {
                    $item->productColor->decrement('stock', $item->quantity);
                }
            }

            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            } else {
                Cart::where('session_id', session()->getId())->delete();
            }

            DB::commit();

            session()->forget('checkout_data');

            return redirect()->route('order.success', $order->order_number);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'Failed to create order. Please contact support.');
        }
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        return view('pages.order-success', compact('order'));
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
}
