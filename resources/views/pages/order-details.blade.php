@extends('layouts.app')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')
    <!-- Order Details Hero -->
    <section class="relative bg-soft-cream py-12">
        <div class="absolute inset-0 brand-pattern-header opacity-10 pointer-events-none"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="font-serif text-3xl md:text-4xl text-deep-maroon">Order Details</h1>
                    <span class="px-4 py-2 rounded-full text-sm font-medium {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : ($order->status === 'shipped' ? 'bg-purple-100 text-purple-800' : ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'))) }}">
                        {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                    </span>
                </div>
                <p class="text-deep-maroon/70">Order Number: <span class="font-medium text-deep-maroon">{{ $order->order_number }}</span></p>
                <p class="text-deep-maroon/70">Order Date: <span class="font-medium text-deep-maroon">{{ $order->created_at->format('d M Y, h:i A') }}</span></p>
            </div>
        </div>
    </section>

    <!-- Order Content -->
    <section class="py-12 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Order Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-soft-cream p-6 shadow-lg rounded-lg mb-6">
                            <h2 class="font-serif text-2xl text-deep-maroon mb-6">Order Items</h2>
                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                <div class="flex gap-4 pb-4 border-b border-deep-maroon/10 last:border-0">
                                    <div class="w-20 h-20 bg-heritage-white rounded overflow-hidden flex-shrink-0">
                                        @if($item->product && $item->product->primaryImage && $item->product->primaryImage->media)
                                            <img src="{{ $item->product->primaryImage->media->url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-deep-maroon/10 to-royal-gold/10 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-deep-maroon/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-medium text-deep-maroon">{{ $item->product_name }}</h3>
                                        @if($item->product_sku)
                                            <p class="text-sm text-deep-maroon/70">SKU: {{ $item->product_sku }}</p>
                                        @endif
                                        <p class="text-sm text-deep-maroon/70">Quantity: {{ $item->quantity }}</p>
                                        <p class="text-sm text-royal-gold font-medium mt-1">₹{{ number_format($item->price, 2) }} each</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-deep-maroon">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="bg-soft-cream p-6 shadow-lg rounded-lg">
                            <h2 class="font-serif text-2xl text-deep-maroon mb-4">Shipping Address</h2>
                            <div class="text-deep-maroon/80 space-y-1">
                                <p class="font-medium text-deep-maroon">{{ $order->billing_name }}</p>
                                <p>{{ $order->billing_address }}</p>
                                <p>{{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_pincode }}</p>
                                <p class="mt-3">Phone: <span class="text-deep-maroon">{{ $order->billing_phone }}</span></p>
                                <p>Email: <span class="text-deep-maroon">{{ $order->billing_email }}</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-soft-cream p-6 shadow-lg rounded-lg sticky top-24">
                            <h2 class="font-serif text-xl text-deep-maroon mb-4">Order Summary</h2>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-deep-maroon/70">Subtotal</span>
                                    <span class="text-deep-maroon font-medium">₹{{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-deep-maroon/70">Shipping</span>
                                    <span class="text-deep-maroon font-medium">
                                        @if($order->shipping > 0)
                                            ₹{{ number_format($order->shipping, 2) }}
                                        @else
                                            <span class="text-green-600">FREE</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="border-t border-deep-maroon/10 pt-3 flex justify-between">
                                    <span class="font-medium text-deep-maroon">Total</span>
                                    <span class="font-serif text-xl text-royal-gold">₹{{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>

                            @if($order->tracking_number)
                            <div class="mt-6 pt-6 border-t border-deep-maroon/10">
                                <h3 class="font-medium text-deep-maroon mb-2">Tracking Information</h3>
                                <p class="text-sm text-deep-maroon/70 mb-1">Tracking Number:</p>
                                <p class="text-sm font-medium text-deep-maroon">{{ $order->tracking_number }}</p>
                            </div>
                            @endif

                            @if($order->notes)
                            <div class="mt-6 pt-6 border-t border-deep-maroon/10">
                                <h3 class="font-medium text-deep-maroon mb-2">Order Notes</h3>
                                <p class="text-sm text-deep-maroon/70">{{ $order->notes }}</p>
                            </div>
                            @endif

                            <div class="mt-6 pt-6 border-t border-deep-maroon/10">
                                <h3 class="font-medium text-deep-maroon mb-2">Payment Method</h3>
                                <p class="text-sm text-deep-maroon/70">{{ ucfirst($order->payment_method ?? 'Online Payment') }}</p>
                                @if($order->payment_status)
                                <p class="text-sm mt-1">
                                    Status: 
                                    <span class="font-medium {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </p>
                                @endif
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('products') }}" class="block w-full text-center bg-deep-maroon text-heritage-white px-4 py-3 rounded font-medium hover:bg-royal-gold hover:text-deep-maroon transition-colors">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
