@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<section class="py-16 bg-soft-cream min-h-screen">
    <div class="container mx-auto px-6">
        <h1 class="font-serif text-4xl text-deep-maroon mb-8">Shopping Cart</h1>

        @if($cartItems->isEmpty())
            <div class="bg-heritage-white rounded-lg shadow-lg p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-deep-maroon/30 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h2 class="font-serif text-2xl text-deep-maroon mb-4">Your cart is empty</h2>
                <p class="text-deep-maroon/70 mb-8">Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('products') }}" class="inline-block bg-royal-gold text-deep-maroon px-8 py-3 font-medium hover:bg-deep-maroon hover:text-heritage-white transition-colors">
                    Continue Shopping
                </a>
            </div>
        @else
            @php
                $hasStockIssues = false;
            @endphp
            @foreach($cartItems as $item)
                @php
                    $availStock = $item->product_color_id
                        ? (\App\Models\ProductColor::find($item->product_color_id)->stock ?? 0)
                        : ($item->product->stock ?? 0);
                    if ($availStock <= 0 || $item->quantity > $availStock) $hasStockIssues = true;
                @endphp
            @endforeach

            @if($hasStockIssues)
            <div class="bg-red-50 border border-red-300 text-red-800 px-6 py-4 rounded-lg mb-6">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    <span class="font-medium">Some items in your cart have stock issues. Please update quantities or remove them before checkout.</span>
                </div>
            </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-heritage-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6 border-b border-deep-maroon/10">
                            <h2 class="font-serif text-xl text-deep-maroon">Cart Items ({{ $cartItems->count() }})</h2>
                        </div>
                        
                        <div class="divide-y divide-deep-maroon/10">
                            @foreach($cartItems as $item)
                                <div class="p-6 flex gap-6" id="cart-item-{{ $item->id }}">
                                    <div class="w-24 h-24 bg-soft-cream rounded-lg overflow-hidden flex-shrink-0">
                                        @if($item->product->primaryImage && $item->product->primaryImage->media)
                                            <img src="{{ $item->product->primaryImage->media->url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-deep-maroon/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="flex justify-between">
                                            <div>
                                                <h3 class="font-medium text-deep-maroon">
                                                    <a href="{{ route('product.show', $item->product->slug) }}" class="hover:text-royal-gold">{{ $item->product->name }}</a>
                                                </h3>
                                                @if($item->productColor && $item->productColor->color)
                                                    <p class="text-sm text-deep-maroon/70 flex items-center gap-1">
                                                        <span class="inline-block w-3 h-3 rounded-full border border-deep-maroon/20" style="background-color: {{ $item->productColor->color->hex_code ?? '#ccc' }}"></span>
                                                        {{ $item->productColor->color->name }}
                                                    </p>
                                                @endif
                                                @if($item->with_blouse)
                                                    <p class="text-sm text-green-600">With Blouse</p>
                                                @endif
                                                @php
                                                    $itemStock = $item->product_color_id
                                                        ? (\App\Models\ProductColor::find($item->product_color_id)->stock ?? 0)
                                                        : ($item->product->stock ?? 0);
                                                @endphp
                                                @if($itemStock <= 0)
                                                    <p class="text-sm text-red-600 font-medium">Out of Stock</p>
                                                @elseif($item->quantity > $itemStock)
                                                    <p class="text-sm text-orange-500 font-medium">Only {{ $itemStock }} available</p>
                                                @elseif($itemStock <= 5)
                                                    <p class="text-sm text-orange-500">Only {{ $itemStock }} left</p>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                @php $unitPrice = $item->price ?? $item->product->display_price; @endphp
                                                @if($item->product->discount > 0 && !$item->price)
                                                    <p class="text-sm text-deep-maroon/50 line-through">₹{{ number_format($item->product->price, 2) }}</p>
                                                @endif
                                                <p class="font-medium text-deep-maroon">₹{{ number_format($unitPrice, 2) }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <label class="text-sm text-deep-maroon/70">Qty:</label>
                                                @php $maxQty = min(10, $itemStock); @endphp
                                                <select onchange="updateQuantity({{ $item->id }}, this.value)" class="border border-deep-maroon/20 rounded px-3 py-1 text-sm" {{ $itemStock <= 0 ? 'disabled' : '' }}>
                                                    @for($i = 1; $i <= max($maxQty, $item->quantity); $i++)
                                                        <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }} {{ $i > $itemStock ? 'class=text-red-500' : '' }}>{{ $i }}{{ $i > $itemStock ? ' (exceeds stock)' : '' }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            
                                            <div class="flex items-center gap-4">
                                                <p class="font-medium text-deep-maroon" id="item-total-{{ $item->id }}">₹{{ number_format(($item->price ?? $item->product->display_price) * $item->quantity, 2) }}</p>
                                                <button onclick="removeItem({{ $item->id }})" class="text-red-500 hover:text-red-700">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-heritage-white rounded-lg shadow-lg p-6 sticky top-24">
                        <h2 class="font-serif text-xl text-deep-maroon mb-6">Order Summary</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-deep-maroon/70">
                                <span>Subtotal</span>
                                <span id="cart-subtotal">₹{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-deep-maroon/70">
                                <span>Shipping</span>
                                <span>{{ $subtotal >= $freeShippingThreshold ? 'Free' : '₹' . number_format($shippingCharge, 2) }}</span>
                            </div>
                            <div class="border-t border-deep-maroon/10 pt-3 flex justify-between font-medium text-deep-maroon text-lg">
                                <span>Total</span>
                                <span id="cart-total">₹{{ number_format($subtotal + ($subtotal >= $freeShippingThreshold ? 0 : $shippingCharge), 2) }}</span>
                            </div>
                        </div>

                        <p class="text-sm text-green-600 mb-6">
                            @if($subtotal >= $freeShippingThreshold)
                                ✓ You qualify for free shipping!
                            @else
                                Add ₹{{ number_format($freeShippingThreshold - $subtotal, 2) }} more for free shipping
                            @endif
                        </p>

                        <a href="{{ route('checkout.index') }}" class="block w-full bg-royal-gold text-deep-maroon text-center py-3 font-medium hover:bg-deep-maroon hover:text-heritage-white transition-colors {{ $hasStockIssues ? 'opacity-50 pointer-events-none' : '' }}">
                            Proceed to Checkout
                        </a>
                        
                        <a href="{{ route('products') }}" class="block w-full text-center py-3 text-deep-maroon hover:text-royal-gold mt-2">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    function updateQuantity(cartId, quantity) {
        fetch(`/cart/${cartId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ quantity: parseInt(quantity) })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Failed to update quantity');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById(`item-total-${cartId}`).textContent = '₹' + data.itemTotal;
                document.getElementById('cart-subtotal').textContent = '₹' + data.subtotal;
                const subtotal = parseFloat(data.subtotal.replace(/,/g, ''));
                const shipping = subtotal >= {{ $freeShippingThreshold }} ? 0 : {{ $shippingCharge }};
                document.getElementById('cart-total').textContent = '₹' + (subtotal + shipping).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            }
        })
        .catch(error => {
            alert(error.message);
            location.reload();
        });
    }

    function removeItem(cartId) {
        if (!confirm('Remove this item from cart?')) return;
        
        console.log('Attempting to delete cart item:', cartId);
        
        fetch(`/cart/${cartId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Error response:', text);
                    throw new Error(`HTTP ${response.status}: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to remove item: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Full error:', error);
            alert('Failed to remove item: ' + error.message);
        });
    }
</script>
@endpush
