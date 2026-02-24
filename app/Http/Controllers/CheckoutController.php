<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn($item) => ($item->price ?? $item->product->display_price) * $item->quantity);
        $shipping = $subtotal >= 5000 ? 0 : 99;
        $total = $subtotal + $shipping;

        $addresses = Auth::check() ? Address::where('user_id', Auth::id())->get() : collect();

        return view('pages.checkout', compact('cartItems', 'subtotal', 'shipping', 'total', 'addresses'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:500',
            'address_line_2' => 'nullable|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'save_address' => 'boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn($item) => ($item->price ?? $item->product->display_price) * $item->quantity);
        $shipping = $subtotal >= 5000 ? 0 : 99;
        $total = $subtotal + $shipping;

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

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $razorpayOrder = $api->order->create([
            'amount' => $total * 100,
            'currency' => 'INR',
            'receipt' => 'order_' . time(),
        ]);

        session([
            'checkout_data' => [
                'billing' => $validated,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
                'razorpay_order_id' => $razorpayOrder->id,
            ],
        ]);

        return view('pages.payment', [
            'razorpayOrderId' => $razorpayOrder->id,
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

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);
        } catch (\Exception $e) {
            return redirect()->route('checkout.index')->with('error', 'Payment verification failed.');
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
                    'product_name' => $item->product->name . ($colorName ? ' - ' . $colorName : ''),
                    'product_sku' => $item->product->sku,
                    'price' => $item->product->price,
                    'discount' => $item->product->discount,
                    'discounted_price' => $unitPrice,
                    'quantity' => $item->quantity,
                    'with_blouse' => $item->with_blouse,
                    'total' => $unitPrice * $item->quantity,
                ]);
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
