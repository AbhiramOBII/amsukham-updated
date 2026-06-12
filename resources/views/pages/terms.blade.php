@extends('layouts.app')

@section('title', 'Terms of Service - Amsukham by Ram')

@section('content')
    <!-- Page Header -->
    <section class="relative bg-soft-cream py-16">
        <div class="absolute inset-0 brand-pattern-header opacity-10 pointer-events-none"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="font-serif text-4xl md:text-5xl text-deep-maroon mb-4">Terms of Service</h1>
                <p class="text-deep-maroon/70">Last updated: {{ date('F Y') }}</p>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                
                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">1. Acceptance of Terms</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        Welcome to Amsukham by Ram. By accessing and using our website (amsukham.com), you agree to comply with and be bound by these Terms of Service. If you do not agree to these terms, please do not use our services.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        We reserve the right to update, change, or replace any part of these Terms of Service at our discretion. It is your responsibility to check this page periodically for changes.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">2. Use of Our Website</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        You agree to use our website for lawful purposes only. You must not use our site in any way that causes damage, interrupts availability, or infringes upon the rights of others.
                    </p>
                    <ul class="list-disc list-inside text-deep-maroon/80 leading-relaxed space-y-2">
                        <li>You must be at least 18 years old to make purchases</li>
                        <li>You are responsible for maintaining the confidentiality of your account information</li>
                        <li>You agree to provide accurate and complete information during registration and checkout</li>
                        <li>We reserve the right to refuse service to anyone for any reason at any time</li>
                    </ul>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">3. Product Information and Pricing</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        We strive to display our products and their colours as accurately as possible. However, actual colours may vary depending on your monitor settings.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        All prices are listed in Indian Rupees (INR) and are inclusive of applicable taxes unless otherwise stated. Shipping costs are calculated at checkout based on your delivery location.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        We reserve the right to modify prices, discontinue products, or correct pricing errors without prior notice.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">4. Orders and Payment</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        When you place an order, you are making an offer to purchase our products. We reserve the right to accept or decline your order at our discretion.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        Payment must be made in full at the time of ordering. We accept various payment methods including credit/debit cards, UPI, and net banking through our secure payment gateway.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        All transactions are processed in Indian Rupees. International orders may be subject to currency conversion by your bank.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">5. Shipping and Delivery</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        We aim to dispatch orders within 2-3 business days. All domestic orders are delivered within <strong>7–10 working days</strong> from the date of dispatch.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        While we make every effort to meet these timeframes, we are not responsible for delays caused by circumstances beyond our control.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">5a. Exchanges</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        We accept exchange requests subject to the following condition:
                    </p>
                    <ul class="list-disc list-inside text-deep-maroon/80 leading-relaxed space-y-2">
                        <li><strong>An unboxing video is mandatory</strong> for all exchange requests. Requests raised without an unboxing video will not be processed.</li>
                        <li>The unboxing video must show the sealed package being opened and must be recorded in a single, unedited take.</li>
                        <li>Exchange requests must be raised within the return window specified in our Return Policy.</li>
                    </ul>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">6. Intellectual Property</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        All content on this website, including text, graphics, logos, images, and designs, is the property of Amsukham by Ram and is protected by copyright and other intellectual property laws.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        You may not reproduce, duplicate, copy, sell, or exploit any portion of our website without express written permission from us.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">7. Limitation of Liability</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        Amsukham by Ram shall not be liable for any direct, indirect, incidental, special, or consequential damages resulting from the use or inability to use our services or products.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        Our total liability in any claim shall not exceed the amount you paid for the specific product giving rise to the claim.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">8. Governing Law</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        These Terms of Service shall be governed by and construed in accordance with the laws of India. Any disputes arising under these terms shall be subject to the exclusive jurisdiction of the courts of Bangalore, Karnataka.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        If you have any questions about these Terms of Service, please contact us at <a href="mailto:{{ $siteSettings['contact_email'] ?? 'info@amsukham.com' }}" class="text-royal-gold hover:underline">{{ $siteSettings['contact_email'] ?? 'info@amsukham.com' }}</a>
                    </p>
                </div>

            </div>
        </div>
    </section>
@endsection
