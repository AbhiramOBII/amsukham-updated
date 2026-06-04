@extends('layouts.app')

@section('title', 'Order Pending')

@section('content')
<section class="py-16 bg-soft-cream min-h-screen">
    <div class="container mx-auto px-6">
        <div class="max-w-2xl mx-auto bg-heritage-white rounded-lg shadow-lg p-8 text-center">
            <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.072 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>

            <h1 class="font-serif text-3xl text-deep-maroon mb-4">Order Pending</h1>
            <p class="text-deep-maroon/70 mb-6">Due to a payment gateway issue, we could not confirm your order at this time. If money has been deducted from your account, don't worry — our team will reach out to you and confirm the order.</p>

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
                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
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
                If you have any questions, please contact us at <strong>{{ $siteSettings['contact_email'] ?? 'info@amsukham.com' }}</strong> or call <strong>{{ $siteSettings['contact_phone'] ?? '+91 95915 79771' }}</strong>
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
