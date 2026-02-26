@extends('layouts.app')

@section('title', 'Privacy Policy - Amsukham by Ram')

@section('content')
    <!-- Page Header -->
    <section class="relative bg-soft-cream py-16">
        <div class="absolute inset-0 brand-pattern-header opacity-10 pointer-events-none"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="font-serif text-4xl md:text-5xl text-deep-maroon mb-4">Privacy Policy</h1>
                <p class="text-deep-maroon/70">Last updated: {{ date('F Y') }}</p>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                
                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Introduction</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        At Amsukham by Ram, we respect your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, store, and safeguard your data when you visit our website or make a purchase.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        By using our website, you consent to the practices described in this Privacy Policy. We encourage you to read this policy carefully.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Information We Collect</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        We collect information that you provide directly to us, including:
                    </p>
                    <ul class="list-disc list-inside text-deep-maroon/80 leading-relaxed space-y-2 mb-4">
                        <li><strong>Personal Information:</strong> Name, email address, phone number, billing and shipping addresses</li>
                        <li><strong>Payment Information:</strong> Credit/debit card details, UPI ID, or other payment method details (processed securely through our payment gateway)</li>
                        <li><strong>Order Information:</strong> Products purchased, order history, and preferences</li>
                        <li><strong>Communication:</strong> Messages, feedback, or inquiries you send to us</li>
                    </ul>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        We also automatically collect certain information when you visit our website, such as your IP address, browser type, device information, and browsing patterns through cookies and similar technologies.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">How We Use Your Information</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        We use the information we collect for the following purposes:
                    </p>
                    <ul class="list-disc list-inside text-deep-maroon/80 leading-relaxed space-y-2">
                        <li>Process and fulfill your orders</li>
                        <li>Communicate with you about your orders, shipping updates, and customer service inquiries</li>
                        <li>Send promotional emails and newsletters (with your consent)</li>
                        <li>Improve our website, products, and services</li>
                        <li>Prevent fraud and ensure security</li>
                        <li>Comply with legal obligations</li>
                    </ul>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">How We Protect Your Information</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        Our website uses SSL encryption to secure data transmission. Payment information is processed through PCI-DSS compliant payment gateways and is not stored on our servers.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        However, please note that no method of transmission over the internet or electronic storage is 100% secure. While we strive to protect your data, we cannot guarantee absolute security.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Sharing Your Information</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        We do not sell, trade, or rent your personal information to third parties. We may share your information only in the following circumstances:
                    </p>
                    <ul class="list-disc list-inside text-deep-maroon/80 leading-relaxed space-y-2">
                        <li><strong>Service Providers:</strong> Trusted third parties who help us operate our website, process payments, or deliver orders</li>
                        <li><strong>Legal Requirements:</strong> When required by law, court order, or government regulation</li>
                        <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets</li>
                    </ul>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Cookies and Tracking</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        We use cookies and similar tracking technologies to enhance your browsing experience, analyse website traffic, and understand user preferences.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        Cookies are small text files stored on your device that help us remember your preferences and improve site functionality. You can control cookie settings through your browser preferences.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        We may also use third-party analytics services (such as Google Analytics) to understand how visitors use our website.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Your Rights</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        You have the following rights regarding your personal information:
                    </p>
                    <ul class="list-disc list-inside text-deep-maroon/80 leading-relaxed space-y-2">
                        <li>Access the personal data we hold about you</li>
                        <li>Request correction of inaccurate information</li>
                        <li>Request deletion of your personal data (subject to legal requirements)</li>
                        <li>Opt out of marketing communications</li>
                        <li>Request restriction of processing</li>
                        <li>Data portability where applicable</li>
                    </ul>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Data Retention</h2>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        We retain your personal information for as long as necessary to fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required by law. Order and transaction records are typically retained for 7 years for accounting and legal purposes.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Contact Us</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        If you have any questions, concerns, or requests regarding this Privacy Policy or our data practices, please contact us:
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        <strong>Email:</strong> <a href="mailto:{{ $siteSettings['contact_email'] ?? 'info@amsukham.com' }}" class="text-royal-gold hover:underline">{{ $siteSettings['contact_email'] ?? 'info@amsukham.com' }}</a><br>
                        <strong>Phone:</strong> {{ $siteSettings['contact_phone'] ?? '+91 98765 43210' }}<br>
                        <strong>Address:</strong> {{ $siteSettings['contact_address_line1'] ?? 'Heritage Showroom' }}, {{ $siteSettings['contact_city'] ?? 'Bangalore, India' }}
                    </p>
                </div>

            </div>
        </div>
    </section>
@endsection
