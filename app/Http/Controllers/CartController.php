<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $subtotal = $cartItems->sum(fn($item) => ($item->price ?? $item->product->display_price) * $item->quantity);

        return view('pages.cart', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_color_id' => 'nullable|exists:product_colors,id',
            'quantity' => 'integer|min:1|max:10',
            'with_blouse' => 'boolean',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'This product is not available.'], 422);
            }
            return back()->with('error', 'This product is not available.');
        }

        // Calculate price based on color selection
        $price = $product->discounted_price;
        if ($request->filled('product_color_id')) {
            $productColor = ProductColor::find($request->product_color_id);
            if ($productColor && $productColor->price_adjustment) {
                $price = $product->discounted_price + $productColor->price_adjustment;
            }
        }

        $cartData = [
            'product_id' => $product->id,
            'product_color_id' => $request->product_color_id,
            'quantity' => $request->quantity ?? 1,
            'price' => $price,
            'with_blouse' => $request->has('with_blouse') ? true : $product->with_blouse,
        ];

        $query = Auth::check()
            ? Cart::where('user_id', Auth::id())
            : Cart::where('session_id', session()->getId());

        $existingItem = $query->where('product_id', $product->id)
            ->where('product_color_id', $request->product_color_id)
            ->first();

        if (Auth::check()) {
            $cartData['user_id'] = Auth::id();
        } else {
            $cartData['session_id'] = session()->getId();
        }

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + ($request->quantity ?? 1),
            ]);
        } else {
            Cart::create($cartData);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cartCount' => $this->getCartCount(),
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        if (!$this->ownsCartItem($cart)) {
            abort(403);
        }

        $cart->update(['quantity' => $request->quantity]);

        if ($request->ajax()) {
            $cartItems = $this->getCartItems();
            $subtotal = $cartItems->sum(fn($item) => ($item->price ?? $item->product->display_price) * $item->quantity);
            $unitPrice = $cart->price ?? $cart->product->display_price;

            return response()->json([
                'success' => true,
                'subtotal' => number_format($subtotal, 2),
                'itemTotal' => number_format($unitPrice * $cart->quantity, 2),
            ]);
        }

        return back()->with('success', 'Cart updated!');
    }

    public function remove(Cart $cart)
    {
        if (!$this->ownsCartItem($cart)) {
            abort(403);
        }

        $cart->delete();

        if (request()->ajax()) {
            $cartItems = $this->getCartItems();
            $subtotal = $cartItems->sum(fn($item) => $item->product->display_price * $item->quantity);

            return response()->json([
                'success' => true,
                'subtotal' => number_format($subtotal, 2),
                'cartCount' => $this->getCartCount(),
            ]);
        }

        return back()->with('success', 'Item removed from cart!');
    }

    public function count()
    {
        return response()->json(['count' => $this->getCartCount()]);
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

    private function getCartCount(): int
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->sum('quantity');
        }

        return Cart::where('session_id', session()->getId())->sum('quantity');
    }

    private function ownsCartItem(Cart $cart): bool
    {
        if (Auth::check()) {
            return $cart->user_id === Auth::id();
        }

        return $cart->session_id === session()->getId();
    }
}
