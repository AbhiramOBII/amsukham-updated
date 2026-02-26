@extends('layouts.app')

@section('title', 'Return & Refund Policy - Amsukham by Ram')

@section('content')
    <!-- Page Header -->
    <section class="relative bg-soft-cream py-16">
        <div class="absolute inset-0 brand-pattern-header opacity-10 pointer-events-none"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="font-serif text-4xl md:text-5xl text-deep-maroon mb-4">Return & Refund Policy</h1>
                <p class="text-deep-maroon/70">Last updated: {{ date('F Y') }}</p>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                
                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Our Commitment</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        At Amsukham by Ram, we take great pride in the quality of our handwoven sarees. Each piece is carefully crafted and inspected before shipping. However, we understand that there may be occasions when you need to return or exchange a product.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        Our return policy is designed to be fair and transparent while ensuring the authenticity and quality of our heritage products.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Return Eligibility</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        We accept returns and exchanges under the following conditions:
                    </p>
                    <ul class="list-disc list-inside text-deep-maroon/80 leading-relaxed space-y-2">
                        <li>The return request is initiated within 7 days of delivery</li>
                        <li>The product is unused, unworn, and in its original condition</li>
                        <li>All original tags, packaging, and accessories are intact</li>
                        <li>The product has not been washed, ironed, or altered in any way</li>
                        <li>You have the original invoice or order confirmation</li>
                    </ul>
                    <p class="text-deep-maroon/80 leading-relaxed mt-4">
                        <strong>Note:</strong> Custom-made, personalised, or altered products cannot be returned unless they are defective or damaged.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Non-Returnable Items</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        The following items are not eligible for return or exchange:
                    </p>
                    <ul class="list-disc list-inside text-deep-maroon/80 leading-relaxed space-y-2">
                        <li>Products that have been used, washed, or worn</li>
                        <li>Items with removed or damaged tags</li>
                        <li>Custom orders and personalised sarees</li>
                        <li>Products damaged due to improper care or handling</li>
                        <li>Gift cards and promotional items</li>
                        <li>Items purchased during clearance or final sale events</li>
                    </ul>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">How to Initiate a Return</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        To return a product, please follow these steps:
                    </p>
                    <ol class="list-decimal list-inside text-deep-maroon/80 leading-relaxed space-y-3">
                        <li><strong>Contact Us:</strong> Email us at <a href="mailto:{{ $siteSettings['contact_email'] ?? 'info@amsukham.com' }}" class="text-royal-gold hover:underline">{{ $siteSettings['contact_email'] ?? 'info@amsukham.com' }}</a> or call {{ $siteSettings['contact_phone'] ?? '+91 98765 43210' }} within 7 days of receiving your order.</li>
                        <li><strong>Provide Details:</strong> Share your order number, reason for return, and supporting photos if applicable.</li>
                        <li><strong>Approval:</strong> Our team will review your request and respond within 2 business days with return instructions.</li>
                        <li><strong>Ship the Product:</strong> Pack the product securely in its original packaging and ship it to the address provided by our team.</li>
                        <li><strong>Inspection:</strong> Once received, we will inspect the product to ensure it meets our return criteria.</li>
                    </ol>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Refund Process</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        Once your return is received and inspected, we will notify you of the approval or rejection of your refund:
                    </p>
                    <ul class="list-disc list-inside text-deep-maroon/80 leading-relaxed space-y-2">
                        <li><strong>Approved Returns:</strong> Refunds will be processed to the original payment method within 7-10 business days after approval</li>
                        <li><strong>Store Credit:</strong> You may choose to receive store credit instead, which can be used for future purchases</li>
                        <li><strong>Exchange:</strong> If you prefer an exchange, we will ship the replacement product once the returned item is received</li>
                    </ul>
                    <p class="text-deep-maroon/80 leading-relaxed mt-4">
                        Please note that shipping costs for the original order are non-refundable unless the return is due to a defective or incorrect product.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Damaged or Defective Products</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        We take utmost care in packaging and shipping our products. However, if you receive a damaged or defective item:
                    </p>
                    <ul class="list-disc list-inside text-deep-maroon/80 leading-relaxed space-y-2">
                        <li>Contact us within 48 hours of delivery with photos of the damage</li>
                        <li>We will arrange a free return pickup for damaged/defective items</li>
                        <li>You may choose a full refund, store credit, or replacement (subject to availability)</li>
                        <li>We will cover all shipping costs for damaged or incorrect items</li>
                    </ul>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Exchange Policy</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        We offer exchanges under the following terms:
                    </p>
                    <ul class="list-disc list-inside text-deep-maroon/80 leading-relaxed space-y-2">
                        <li>Exchanges are allowed for size, colour, or style variations (subject to availability)</li>
                        <li>The exchange request must be made within 7 days of delivery</li>
                        <li>The product must meet all return eligibility criteria</li>
                        <li>Shipping costs for exchanges are borne by the customer unless the exchange is due to our error</li>
                        <li>If the requested replacement is of higher value, the price difference must be paid</li>
                    </ul>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Shipping Costs</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        <strong>For Returns:</strong> The customer is responsible for return shipping costs unless the item is defective, damaged, or incorrect. We recommend using a trackable shipping service or purchasing shipping insurance for items over INR 5,000.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        <strong>For Exchanges:</strong> The customer pays for shipping the original item back to us. We cover the shipping cost for sending the replacement item.
                    </p>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg mb-8">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Cancellations</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        Order cancellations are subject to the following conditions:
                    </p>
                    <ul class="list-disc list-inside text-deep-maroon/80 leading-relaxed space-y-2">
                        <li>Orders can be cancelled within 24 hours of placement or before shipping (whichever comes first)</li>
                        <li>Custom or personalised orders cannot be cancelled once production has begun</li>
                        <li>For cancelled orders, full refunds will be processed within 5-7 business days</li>
                    </ul>
                </div>

                <div class="bg-soft-cream p-8 md:p-12 shadow-lg">
                    <h2 class="font-serif text-2xl text-deep-maroon mb-4">Contact Us</h2>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        For any questions or concerns regarding returns, refunds, or exchanges, please contact our customer support team:
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        <strong>Email:</strong> <a href="mailto:{{ $siteSettings['contact_email'] ?? 'info@amsukham.com' }}" class="text-royal-gold hover:underline">{{ $siteSettings['contact_email'] ?? 'info@amsukham.com' }}</a><br>
                        <strong>Phone:</strong> {{ $siteSettings['contact_phone'] ?? '+91 98765 43210' }}<br>
                        <strong>Hours:</strong> Monday to Saturday, 10:00 AM to 6:00 PM IST
                    </p>
                </div>

            </div>
        </div>
    </section>
@endsection
