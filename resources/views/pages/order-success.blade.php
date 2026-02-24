@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<section class="py-16 bg-soft-cream min-h-screen">
    <div class="container mx-auto px-6">
        <div class="max-w-2xl mx-auto bg-heritage-white rounded-lg shadow-lg p-8 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="font-serif text-3xl text-deep-maroon mb-4">Order Confirmed!</h1>
            <p class="text-deep-maroon/70 mb-6">Thank you for your purchase. Your order has been placed successfully.</p>

            <div class="bg-soft-cream rounded-lg p-6 mb-6">
                <p class="text-sm text-deep-maroon/60 mb-2">Order Number</p>
                <p class="font-mono text-2xl font-bold text-deep-maroon">{{ $order->order_number }}</p>
            </div>

            <div class="text-left space-y-4 mb-8">
                <div class="flex justify-between py-2 border-b border-deep-maroon/10">
                    <span class="text-deep-maroon/60">Order Total</span>
                    <span class="font-medium text-deep-maroon">₹{{ number_format($order->total, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-deep-maroon/10">
                    <span class="text-deep-maroon/60">Payment Status</span>
                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">{{ ucfirst($order->payment_status) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-deep-maroon/10">
                    <span class="text-deep-maroon/60">Shipping To</span>
                    <span class="text-right text-deep-maroon">
                        {{ $order->billing_name }}<br>
                        <span class="text-sm text-deep-maroon/60">{{ $order->billing_city }}, {{ $order->billing_state }}</span>
                    </span>
                </div>
            </div>

            <p class="text-sm text-deep-maroon/60 mb-6">
                A confirmation email has been sent to <strong>{{ $order->billing_email }}</strong>
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products') }}" class="px-8 py-3 bg-royal-gold text-deep-maroon font-medium hover:bg-deep-maroon hover:text-heritage-white transition-colors">
                    Continue Shopping
                </a>
                <a href="{{ route('home') }}" class="px-8 py-3 border border-deep-maroon text-deep-maroon font-medium hover:bg-deep-maroon hover:text-heritage-white transition-colors">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
