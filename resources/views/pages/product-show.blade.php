@extends('layouts.app')

@section('title', 'Maharani Silk - Amsukham by Ram')


@section('content')
    <!-- Product Detail Section -->
    <section class="py-20 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div class="aspect-square bg-soft-cream overflow-hidden shadow-lg">
                        <img id="mainProductImage" src="{{ asset('images/best-seller-01.jpg') }}" alt="Maharani Silk Saree" class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Thumbnail Images -->
                    <div class="grid grid-cols-4 gap-4">
                        <div class="aspect-square bg-soft-cream overflow-hidden shadow-lg cursor-pointer border-3 border-royal-gold hover:border-deep-maroon transition-colors" onclick="changeMainImage('{{ asset('images/best-seller-01.jpg') }}', this)">
                            <img src="{{ asset('images/best-seller-01.jpg') }}" alt="Maharani Silk Saree" class="w-full h-full object-cover">
                        </div>
                        <div class="aspect-square bg-soft-cream overflow-hidden shadow-lg cursor-pointer border-2 border-transparent hover:border-deep-maroon transition-colors" onclick="changeMainImage('{{ asset('images/best-seller-02.jpg') }}', this)">
                            <img src="{{ asset('images/best-seller-02.jpg') }}" alt="Maharani Silk Saree" class="w-full h-full object-cover">
                        </div>
                        <div class="aspect-square bg-soft-cream overflow-hidden heritage-shadow cursor-pointer thumbnail-container" onclick="changeMainImage('{{ asset('images/best-seller-03.jpg') }}', this)">
                            <img src="{{ asset('images/best-seller-03.jpg') }}" alt="Maharani Silk Saree" class="w-full h-full object-cover">
                        </div>
                        <div class="aspect-square bg-soft-cream overflow-hidden heritage-shadow cursor-pointer thumbnail-container" onclick="changeMainImage('{{ asset('images/best-seller-04.jpg') }}', this)">
                            <img src="{{ asset('images/best-seller-04.jpg') }}" alt="Maharani Silk Saree" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <div>
                        <h1 class="font-serif text-4xl text-deep-maroon mb-4">Maharani Silk</h1>
                        <p class="text-deep-maroon/70 text-lg mb-6">Pure silk with gold zari work</p>
                        <div class="flex items-center space-x-4 mb-6">
                            <span class="font-serif text-3xl text-royal-gold">₹25,000</span>
                            <span class="text-deep-maroon/50 line-through text-xl">₹30,000</span>
                            <span class="bg-royal-gold text-deep-maroon px-3 py-1 text-sm font-medium">17% OFF</span>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-deep-maroon/70 font-medium">Fabric:</span>
                                <span class="text-deep-maroon ml-2">Pure Silk</span>
                            </div>
                            <div>
                                <span class="text-deep-maroon/70 font-medium">Work:</span>
                                <span class="text-deep-maroon ml-2">Gold Zari</span>
                            </div>
                            <div>
                                <span class="text-deep-maroon/70 font-medium">Length:</span>
                                <span class="text-deep-maroon ml-2">5.5 meters</span>
                            </div>
                            <div>
                                <span class="text-deep-maroon/70 font-medium">Blouse:</span>
                                <span class="text-deep-maroon ml-2">0.8 meters</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <!-- Quantity Selector -->
                            <div class="flex items-center border border-deep-maroon/20 rounded-full">
                                <button id="decreaseQty" class="w-10 h-10 flex items-center justify-center text-deep-maroon hover:bg-soft-cream transition-colors rounded-l-full">
                                    <span class="text-lg font-medium">−</span>
                                </button>
                                <span id="quantity" class="px-4 py-2 text-deep-maroon font-medium min-w-[3rem] text-center">1</span>
                                <button id="increaseQty" class="w-10 h-10 flex items-center justify-center text-deep-maroon hover:bg-soft-cream transition-colors rounded-r-full">
                                    <span class="text-lg font-medium">+</span>
                                </button>
                            </div>

                            <!-- Add to Cart Button -->
                            <button class="flex-1 bg-deep-maroon text-heritage-white py-3 px-8 font-medium hover:bg-royal-gold transition-colors rounded-full shadow-lg">
                                ADD TO CART
                            </button>
                        </div>

                        <!-- Secondary Actions -->
                        <div class="flex items-center space-x-6 text-deep-maroon">
                            <button class="flex items-center space-x-2 hover:text-royal-gold transition-colors">
                                <img src="{{ asset('images/heart.svg') }}" alt="Wishlist" class="w-5 h-5">
                                <span class="text-sm">Add to Wish List</span>
                            </button>
                            <button class="flex items-center space-x-2 hover:text-royal-gold transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm">FAQ</span>
                            </button>
                        </div>
                    </div>

                    <!-- Product Description -->
                    <div class="border-t border-deep-maroon/20 pt-6 mt-6">
                        <h3 class="font-serif text-xl text-deep-maroon mb-4">Product Description</h3>
                        <p class="text-deep-maroon/80 leading-relaxed">
                            Experience the royal elegance of our Maharani Silk saree, crafted with the finest pure silk and adorned with intricate gold zari work. This timeless piece represents the pinnacle of traditional Indian craftsmanship, perfect for special occasions and celebrations. The rich texture and lustrous finish make it a treasured addition to any wardrobe.
                        </p>
                    </div>

                    <!-- Customer Support -->
                    <div class="border-t border-deep-maroon/20 pt-6 space-y-4">
                        <h4 class="font-medium text-deep-maroon mb-3">Have any Queries?</h4>
                        <p class="text-deep-maroon/70 text-sm mb-4">We're here to help! Feel free to reach out to our customer care executives</p>
                        
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <span class="font-medium text-deep-maroon text-sm">Contact Us</span>
                                <span class="text-deep-maroon/70 text-sm">+91-9852985299</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="font-medium text-deep-maroon text-sm">Email Us</span>
                                <span class="text-deep-maroon/70 text-sm">hello@amsukham.com</span>
                            </div>
                        </div>

                        <!-- Service Features -->
                        <div class="grid grid-cols-2 gap-4 mt-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-deep-maroon/10 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-deep-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-deep-maroon text-sm">FREE DELIVERY</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-deep-maroon/10 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-deep-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-deep-maroon text-sm">PAYMENT SECURED</p>
                                    <p class="text-deep-maroon/60 text-xs">Safe with Our Payment</p>
                                </div>
                            </div>
                        </div>

                        <!-- Share Section -->
                        <div class="mt-6">
                            <div class="flex items-center space-x-4">
                                <span class="font-medium text-deep-maroon text-sm">Share it:</span>
                                <div class="flex items-center space-x-3">
                                    <button class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                        </svg>
                                    </button>
                                    <button class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </button>
                                    <button class="w-8 h-8 bg-blue-700 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-soft-cream">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="font-serif text-4xl text-deep-maroon mb-4 decorative-title">Frequently Asked Questions</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mb-6 mx-auto"></div>
                    <p class="text-deep-maroon/70 text-lg">Everything you need to know about our heritage sarees</p>
                </div>

                <div class="space-y-4">
                    <!-- FAQ Item 1 -->
                    <div class="bg-heritage-white shadow-lg overflow-hidden">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-soft-cream/50 transition-colors" data-target="faq1">
                            <span class="font-medium text-deep-maroon">What is the fabric composition of this saree?</span>
                            <svg class="w-5 h-5 text-deep-maroon transform transition-transform duration-200 faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="faq1" class="faq-content hidden px-6 pb-4">
                            <p class="text-deep-maroon/80 leading-relaxed">Our Maharani Silk saree is crafted from 100% pure mulberry silk with intricate gold zari work. The saree includes 5.5 meters of premium silk fabric and 0.8 meters of matching blouse piece, ensuring authentic traditional quality.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="bg-heritage-white shadow-lg overflow-hidden">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-soft-cream/50 transition-colors" data-target="faq2">
                            <span class="font-medium text-deep-maroon">How should I care for this saree?</span>
                            <svg class="w-5 h-5 text-deep-maroon transform transition-transform duration-200 faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="faq2" class="faq-content hidden px-6 pb-4">
                            <p class="text-deep-maroon/80 leading-relaxed">We recommend dry cleaning only to preserve the silk quality and gold zari work. Store in a cool, dry place wrapped in cotton cloth. Avoid direct sunlight and moisture to maintain the fabric's luster and longevity.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="bg-heritage-white shadow-lg overflow-hidden">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-soft-cream/50 transition-colors" data-target="faq3">
                            <span class="font-medium text-deep-maroon">What is your return policy?</span>
                            <svg class="w-5 h-5 text-deep-maroon transform transition-transform duration-200 faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="faq3" class="faq-content hidden px-6 pb-4">
                            <p class="text-deep-maroon/80 leading-relaxed">We offer a 7-day return policy for unworn items in original condition with tags attached. The saree must be returned in its original packaging. Return shipping costs are borne by the customer unless the item is defective.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="bg-heritage-white shadow-lg overflow-hidden">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-soft-cream/50 transition-colors" data-target="faq4">
                            <span class="font-medium text-deep-maroon">Do you offer international shipping?</span>
                            <svg class="w-5 h-5 text-deep-maroon transform transition-transform duration-200 faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="faq4" class="faq-content hidden px-6 pb-4">
                            <p class="text-deep-maroon/80 leading-relaxed">Yes, we ship worldwide! International shipping takes 7-14 business days depending on the destination. Shipping costs and customs duties vary by location and are calculated at checkout. All international orders are fully insured.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products Section -->
    <section class="py-20 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="font-serif text-4xl text-deep-maroon mb-4 decorative-title">You May Also Like</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mb-6 mx-auto"></div>
                <p class="text-deep-maroon/70 text-lg">Discover more from our heritage collection</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Related Product 1 -->
                <div class="bg-heritage-white overflow-hidden shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="h-64 relative">
                        <img src="{{ asset('images/best-seller-02.jpg') }}" alt="Heritage Banarasi" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h4 class="font-serif text-lg text-deep-maroon mb-2">Heritage Banarasi</h4>
                        <p class="text-deep-maroon/70 text-sm mb-3">Traditional Banarasi weave</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-serif text-xl text-royal-gold">₹18,500</span>
                        </div>
                        <a href="{{ route('product.show', 2) }}" class="block w-full bg-deep-maroon text-heritage-white py-2 font-medium hover:bg-royal-gold transition-colors text-center">
                            View Details
                        </a>
                    </div>
                </div>

                <!-- Related Product 2 -->
                <div class="bg-heritage-white overflow-hidden shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="h-64 relative">
                        <img src="{{ asset('images/best-seller-03.jpg') }}" alt="Royal Kanjivaram" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h4 class="font-serif text-lg text-deep-maroon mb-2">Royal Kanjivaram</h4>
                        <p class="text-deep-maroon/70 text-sm mb-3">Handwoven Kanjivaram silk</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-serif text-xl text-royal-gold">₹32,000</span>
                        </div>
                        <a href="{{ route('product.show', 3) }}" class="block w-full bg-deep-maroon text-heritage-white py-2 font-medium hover:bg-royal-gold transition-colors text-center">
                            View Details
                        </a>
                    </div>
                </div>

                <!-- Related Product 3 -->
                <div class="bg-heritage-white overflow-hidden shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="h-64 relative">
                        <img src="{{ asset('images/best-seller-04.jpg') }}" alt="Bridal Lehenga" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h4 class="font-serif text-lg text-deep-maroon mb-2">Bridal Lehenga</h4>
                        <p class="text-deep-maroon/70 text-sm mb-3">Exquisite bridal collection</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-serif text-xl text-royal-gold">₹45,000</span>
                        </div>
                        <a href="{{ route('product.show', 4) }}" class="block w-full bg-deep-maroon text-heritage-white py-2 font-medium hover:bg-royal-gold transition-colors text-center">
                            View Details
                        </a>
                    </div>
                </div>

                <!-- Related Product 4 -->
                <div class="bg-heritage-white overflow-hidden shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="h-64 relative">
                        <img src="{{ asset('images/latest-collections.jpg') }}" alt="Mysore Silk" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h4 class="font-serif text-lg text-deep-maroon mb-2">Mysore Silk</h4>
                        <p class="text-deep-maroon/70 text-sm mb-3">Premium Mysore silk weave</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-serif text-xl text-royal-gold">₹22,000</span>
                        </div>
                        <a href="{{ route('product.show', 5) }}" class="block w-full bg-deep-maroon text-heritage-white py-2 font-medium hover:bg-royal-gold transition-colors text-center">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function changeMainImage(src, element) {
        document.getElementById('mainProductImage').src = src;
        document.querySelectorAll('[onclick*="changeMainImage"]').forEach(thumb => {
            thumb.classList.remove('border-royal-gold', 'border-3');
            thumb.classList.add('border-transparent', 'border-2');
        });
        element.classList.remove('border-transparent', 'border-2');
        element.classList.add('border-royal-gold', 'border-3');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Quantity selector
        const quantity = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decreaseQty');
        const increaseBtn = document.getElementById('increaseQty');
        let qty = 1;

        decreaseBtn.addEventListener('click', function() {
            if (qty > 1) {
                qty--;
                quantity.textContent = qty;
            }
        });

        increaseBtn.addEventListener('click', function() {
            qty++;
            quantity.textContent = qty;
        });

        // FAQ toggles
        document.querySelectorAll('.faq-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const content = document.getElementById(targetId);
                const icon = this.querySelector('.faq-icon');
                
                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });
    });
</script>
@endpush
