<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $code = strtoupper(trim($request->code));
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid coupon code.'], 422);
        }

        // Get cart subtotal
        $cartItems = $this->getCartItems();
        $subtotal = $cartItems->sum(fn($item) => ($item->price ?? $item->product->display_price) * $item->quantity);

        // Validate coupon
        $userId = Auth::check() ? Auth::id() : null;
        $validation = $coupon->isValid($subtotal, $userId);

        if (!$validation['valid']) {
            return response()->json(['success' => false, 'message' => $validation['message']], 422);
        }

        // Calculate discount
        $discount = $coupon->calculateDiscount($subtotal);

        // Store in session
        session([
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount_type' => $coupon->discount_type,
                'discount_value' => $coupon->discount_value,
                'maximum_discount' => $coupon->maximum_discount,
                'discount_amount' => $discount,
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => $validation['message'],
            'coupon' => [
                'code' => $coupon->code,
                'discount_amount' => $discount,
                'discount_formatted' => '₹' . number_format($discount, 2),
            ]
        ]);
    }

    public function remove(Request $request)
    {
        session()->forget('coupon');

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed.',
        ]);
    }

    private function getCartItems()
    {
        if (Auth::check()) {
            return \App\Models\Cart::where('user_id', Auth::id())
                ->with('product')
                ->get();
        }

        $sessionId = session()->getId();
        return \App\Models\Cart::where('session_id', $sessionId)
            ->with('product')
            ->get();
    }
}
