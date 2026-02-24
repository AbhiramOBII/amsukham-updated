@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<section class="py-16 bg-soft-cream min-h-screen">
    <div class="container mx-auto px-6">
        <h1 class="font-serif text-4xl text-deep-maroon mb-8">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="grid lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-heritage-white rounded-lg shadow-lg p-6">
                        <h2 class="font-serif text-xl text-deep-maroon mb-6">Shipping Information</h2>
                        
                        @if($addresses->isNotEmpty())
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-deep-maroon mb-2">Select Saved Address</label>
                                <select id="savedAddress" onchange="fillAddress(this)" class="w-full px-4 py-3 border border-deep-maroon/20 rounded-lg focus:outline-none focus:border-royal-gold">
                                    <option value="">Enter new address</option>
                                    @foreach($addresses as $address)
                                        <option value="{{ $address->id }}" 
                                            data-name="{{ $address->name }}"
                                            data-phone="{{ $address->phone }}"
                                            data-email="{{ $address->email }}"
                                            data-address1="{{ $address->address_line_1 }}"
                                            data-address2="{{ $address->address_line_2 }}"
                                            data-city="{{ $address->city }}"
                                            data-state="{{ $address->state }}"
                                            data-pincode="{{ $address->pincode }}">
                                            {{ $address->name }} - {{ $address->city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-deep-maroon mb-2">Full Name *</label>
                                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name ?? '') }}" required class="w-full px-4 py-3 border border-deep-maroon/20 rounded-lg focus:outline-none focus:border-royal-gold">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-deep-maroon mb-2">Phone Number *</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required class="w-full px-4 py-3 border border-deep-maroon/20 rounded-lg focus:outline-none focus:border-royal-gold">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-deep-maroon mb-2">Email Address *</label>
                            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email ?? '') }}" required class="w-full px-4 py-3 border border-deep-maroon/20 rounded-lg focus:outline-none focus:border-royal-gold">
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-deep-maroon mb-2">Address Line 1 *</label>
                            <input type="text" name="address_line_1" id="address_line_1" value="{{ old('address_line_1') }}" required placeholder="House/Flat No., Building Name" class="w-full px-4 py-3 border border-deep-maroon/20 rounded-lg focus:outline-none focus:border-royal-gold">
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-deep-maroon mb-2">Address Line 2</label>
                            <input type="text" name="address_line_2" id="address_line_2" value="{{ old('address_line_2') }}" placeholder="Street, Landmark (Optional)" class="w-full px-4 py-3 border border-deep-maroon/20 rounded-lg focus:outline-none focus:border-royal-gold">
                        </div>

                        <div class="grid md:grid-cols-3 gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-deep-maroon mb-2">City *</label>
                                <input type="text" name="city" id="city" value="{{ old('city') }}" required class="w-full px-4 py-3 border border-deep-maroon/20 rounded-lg focus:outline-none focus:border-royal-gold">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-deep-maroon mb-2">State *</label>
                                <input type="text" name="state" id="state" value="{{ old('state') }}" required class="w-full px-4 py-3 border border-deep-maroon/20 rounded-lg focus:outline-none focus:border-royal-gold">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-deep-maroon mb-2">Pincode *</label>
                                <input type="text" name="pincode" id="pincode" value="{{ old('pincode') }}" required class="w-full px-4 py-3 border border-deep-maroon/20 rounded-lg focus:outline-none focus:border-royal-gold">
                            </div>
                        </div>

                        @auth
                        <div class="mt-4">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="save_address" value="1" class="rounded border-deep-maroon/30 text-royal-gold focus:ring-royal-gold">
                                <span class="text-sm text-deep-maroon">Save this address for future orders</span>
                            </label>
                        </div>
                        @endauth
                    </div>

                    <div class="bg-heritage-white rounded-lg shadow-lg p-6">
                        <h2 class="font-serif text-xl text-deep-maroon mb-4">Order Notes (Optional)</h2>
                        <textarea name="notes" rows="3" placeholder="Any special instructions for your order..." class="w-full px-4 py-3 border border-deep-maroon/20 rounded-lg focus:outline-none focus:border-royal-gold">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-heritage-white rounded-lg shadow-lg p-6 sticky top-24">
                        <h2 class="font-serif text-xl text-deep-maroon mb-6">Order Summary</h2>
                        
                        <div class="space-y-4 mb-6">
                            @foreach($cartItems as $item)
                                <div class="flex gap-4">
                                    <div class="w-16 h-16 bg-soft-cream rounded overflow-hidden flex-shrink-0">
                                        @if($item->product->primaryImage && $item->product->primaryImage->media)
                                            <img src="{{ $item->product->primaryImage->media->url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-deep-maroon">{{ $item->product->name }}</p>
                                        @if($item->productColor && $item->productColor->color)
                                            <p class="text-xs text-deep-maroon/60 flex items-center gap-1">
                                                <span class="inline-block w-2.5 h-2.5 rounded-full border border-deep-maroon/20" style="background-color: {{ $item->productColor->color->hex_code ?? '#ccc' }}"></span>
                                                {{ $item->productColor->color->name }}
                                            </p>
                                        @endif
                                        <p class="text-sm text-deep-maroon/60">Qty: {{ $item->quantity }}</p>
                                    </div>
                                    @php $unitPrice = $item->price ?? $item->product->display_price; @endphp
                                    <p class="text-sm font-medium text-deep-maroon">₹{{ number_format($unitPrice * $item->quantity, 2) }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-deep-maroon/10 pt-4 space-y-3">
                            <div class="flex justify-between text-deep-maroon/70">
                                <span>Subtotal</span>
                                <span>₹{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-deep-maroon/70">
                                <span>Shipping</span>
                                <span>{{ $shipping == 0 ? 'Free' : '₹' . number_format($shipping, 2) }}</span>
                            </div>
                            <div class="border-t border-deep-maroon/10 pt-3 flex justify-between font-medium text-deep-maroon text-lg">
                                <span>Total</span>
                                <span>₹{{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-6 bg-royal-gold text-deep-maroon py-3 font-medium hover:bg-deep-maroon hover:text-heritage-white transition-colors">
                            Proceed to Payment
                        </button>

                        <div class="mt-4 flex items-center justify-center gap-2 text-sm text-deep-maroon/60">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Secure checkout powered by Razorpay
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function fillAddress(select) {
        const option = select.options[select.selectedIndex];
        if (!option.value) return;
        
        document.getElementById('name').value = option.dataset.name || '';
        document.getElementById('phone').value = option.dataset.phone || '';
        document.getElementById('email').value = option.dataset.email || '';
        document.getElementById('address_line_1').value = option.dataset.address1 || '';
        document.getElementById('address_line_2').value = option.dataset.address2 || '';
        document.getElementById('city').value = option.dataset.city || '';
        document.getElementById('state').value = option.dataset.state || '';
        document.getElementById('pincode').value = option.dataset.pincode || '';
    }
</script>
@endpush
