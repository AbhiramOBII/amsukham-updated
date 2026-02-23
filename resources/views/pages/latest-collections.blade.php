@extends('layouts.app')

@section('title', 'Latest Collections - Amsukham by Ram')

@section('content')
    <!-- Hero Section -->
    <section class="py-20 bg-heritage-white relative overflow-hidden">
        <div class="brand-pattern-header opacity-5"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="font-serif text-5xl md:text-6xl text-deep-maroon mb-6 decorative-title">Latest Collections</h1>
                <div class="w-32 h-1 gold-accent mb-8 mx-auto"></div>
                <p class="text-deep-maroon/80 text-xl leading-relaxed mb-8">
                    Discover our newest arrivals featuring exquisite handwoven sarees that blend traditional craftsmanship with contemporary elegance.
                </p>
                <div class="flex flex-wrap justify-center gap-4 text-sm">
                    <span class="bg-soft-cream px-4 py-2 text-deep-maroon font-medium">New Arrivals</span>
                    <span class="bg-soft-cream px-4 py-2 text-deep-maroon font-medium">Handwoven Excellence</span>
                    <span class="bg-soft-cream px-4 py-2 text-deep-maroon font-medium">Heritage Designs</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Collections Grid -->
    <section class="py-20 bg-soft-cream">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="collections-grid">
                
                <!-- Tile 1 - Featured Large -->
                <div class="md:col-span-2 lg:row-span-2">
                    <div class="group relative overflow-hidden shadow-lg bg-heritage-white h-full min-h-[400px] lg:min-h-[500px]">
                        <div class="absolute inset-0">
                            <img src="{{ asset('images/best-seller-01.jpg') }}" alt="Maharani Silk Collection" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-deep-maroon/80 via-deep-maroon/20 to-transparent"></div>
                        </div>
                        <div class="absolute inset-0 p-8 flex flex-col justify-end">
                            <div class="text-heritage-white">
                                <span class="inline-block bg-royal-gold text-deep-maroon px-3 py-1 text-sm font-medium mb-4">Featured Collection</span>
                                <h3 class="font-serif text-3xl lg:text-4xl mb-3">Maharani Silk</h3>
                                <p class="text-heritage-white/90 mb-4 text-lg">Exquisite pure silk sarees with intricate gold zari work</p>
                                <div class="flex items-center justify-between">
                                    <span class="font-serif text-2xl text-royal-gold">From ₹25,000</span>
                                    <a href="{{ route('products') }}" class="bg-heritage-white text-deep-maroon px-6 py-3 font-medium hover:bg-royal-gold transition-colors">
                                        Explore Collection
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tile 2 -->
                <div>
                    <div class="group relative overflow-hidden shadow-lg bg-heritage-white h-80">
                        <div class="absolute inset-0">
                            <img src="{{ asset('images/best-seller-02.jpg') }}" alt="Banarasi Heritage" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-deep-maroon/70 to-transparent"></div>
                        </div>
                        <div class="absolute inset-0 p-6 flex flex-col justify-end">
                            <div class="text-heritage-white">
                                <h4 class="font-serif text-xl mb-2">Banarasi Heritage</h4>
                                <p class="text-heritage-white/90 text-sm mb-3">Traditional Banarasi weave</p>
                                <div class="flex items-center justify-between">
                                    <span class="font-serif text-lg text-royal-gold">₹18,500</span>
                                    <a href="{{ route('product.show', 2) }}" class="text-heritage-white hover:text-royal-gold transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tile 3 -->
                <div>
                    <div class="group relative overflow-hidden shadow-lg bg-heritage-white h-80">
                        <div class="absolute inset-0">
                            <img src="{{ asset('images/best-seller-03.jpg') }}" alt="Royal Kanjivaram" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-deep-maroon/70 to-transparent"></div>
                        </div>
                        <div class="absolute inset-0 p-6 flex flex-col justify-end">
                            <div class="text-heritage-white">
                                <h4 class="font-serif text-xl mb-2">Royal Kanjivaram</h4>
                                <p class="text-heritage-white/90 text-sm mb-3">Handwoven Kanjivaram silk</p>
                                <div class="flex items-center justify-between">
                                    <span class="font-serif text-lg text-royal-gold">₹32,000</span>
                                    <a href="{{ route('product.show', 3) }}" class="text-heritage-white hover:text-royal-gold transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tile 4 -->
                <div>
                    <div class="group relative overflow-hidden shadow-lg bg-heritage-white h-80">
                        <div class="absolute inset-0">
                            <img src="{{ asset('images/best-seller-04.jpg') }}" alt="Bridal Lehenga" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-deep-maroon/70 to-transparent"></div>
                        </div>
                        <div class="absolute inset-0 p-6 flex flex-col justify-end">
                            <div class="text-heritage-white">
                                <h4 class="font-serif text-xl mb-2">Bridal Lehenga</h4>
                                <p class="text-heritage-white/90 text-sm mb-3">Exquisite bridal collection</p>
                                <div class="flex items-center justify-between">
                                    <span class="font-serif text-lg text-royal-gold">₹45,000</span>
                                    <a href="{{ route('product.show', 4) }}" class="text-heritage-white hover:text-royal-gold transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tile 5 -->
                <div>
                    <div class="group relative overflow-hidden shadow-lg bg-heritage-white h-80">
                        <div class="absolute inset-0">
                            <img src="{{ asset('images/latest-collections.jpg') }}" alt="Mysore Silk" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-deep-maroon/70 to-transparent"></div>
                        </div>
                        <div class="absolute inset-0 p-6 flex flex-col justify-end">
                            <div class="text-heritage-white">
                                <h4 class="font-serif text-xl mb-2">Mysore Silk</h4>
                                <p class="text-heritage-white/90 text-sm mb-3">Premium Mysore silk weave</p>
                                <div class="flex items-center justify-between">
                                    <span class="font-serif text-lg text-royal-gold">₹22,000</span>
                                    <a href="{{ route('product.show', 5) }}" class="text-heritage-white hover:text-royal-gold transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tile 6 -->
                <div>
                    <div class="group relative overflow-hidden shadow-lg bg-heritage-white h-80">
                        <div class="absolute inset-0">
                            <img src="{{ asset('images/latest-collections-02.jpg') }}" alt="Chanderi Cotton" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-deep-maroon/70 to-transparent"></div>
                        </div>
                        <div class="absolute inset-0 p-6 flex flex-col justify-end">
                            <div class="text-heritage-white">
                                <h4 class="font-serif text-xl mb-2">Chanderi Cotton</h4>
                                <p class="text-heritage-white/90 text-sm mb-3">Lightweight Chanderi fabric</p>
                                <div class="flex items-center justify-between">
                                    <span class="font-serif text-lg text-royal-gold">₹15,500</span>
                                    <a href="{{ route('product.show', 6) }}" class="text-heritage-white hover:text-royal-gold transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tile 7 - Wide -->
                <div class="md:col-span-2">
                    <div class="group relative overflow-hidden shadow-lg bg-heritage-white h-80">
                        <div class="absolute inset-0">
                            <img src="{{ asset('images/hero-slider-bg.jpg') }}" alt="Festive Collection" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-r from-deep-maroon/80 via-deep-maroon/40 to-transparent"></div>
                        </div>
                        <div class="absolute inset-0 p-8 flex flex-col justify-center">
                            <div class="text-heritage-white max-w-md">
                                <span class="inline-block bg-royal-gold text-deep-maroon px-3 py-1 text-sm font-medium mb-4">Festive Special</span>
                                <h3 class="font-serif text-3xl mb-3">Festival Collection</h3>
                                <p class="text-heritage-white/90 mb-6">Celebrate traditions with our vibrant festive sarees</p>
                                <div class="flex items-center space-x-6">
                                    <span class="font-serif text-xl text-royal-gold">From ₹12,000</span>
                                    <a href="{{ route('products') }}" class="bg-heritage-white text-deep-maroon px-6 py-3 font-medium hover:bg-royal-gold transition-colors">
                                        Shop Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- View All Tile -->
                <div>
                    <div class="group relative overflow-hidden shadow-lg bg-heritage-white h-80">
                        <div class="absolute inset-0 heritage-gradient"></div>
                        <div class="absolute inset-0 p-6 flex flex-col justify-center items-center text-center">
                            <div class="text-deep-maroon">
                                <div class="w-16 h-16 bg-royal-gold rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-deep-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <h4 class="font-serif text-xl mb-2">More Collections</h4>
                                <p class="text-deep-maroon/70 text-sm mb-4">Discover our complete range</p>
                                <a href="{{ route('products') }}" class="text-deep-maroon hover:text-royal-gold transition-colors font-medium">
                                    View All →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-12">
                <a href="{{ route('products') }}" class="inline-block bg-deep-maroon text-heritage-white px-8 py-4 font-medium hover:bg-royal-gold transition-colors heritage-shadow">
                    View All Products
                </a>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-20 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="font-serif text-4xl text-deep-maroon mb-6">Stay Updated with Latest Collections</h2>
                <p class="text-deep-maroon/70 text-lg mb-8">Be the first to know about our new arrivals, exclusive offers, and heritage stories.</p>
                <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                    <input type="email" placeholder="Enter your email" class="flex-1 px-6 py-4 border border-deep-maroon/20 text-deep-maroon placeholder-deep-maroon/60 focus:outline-none focus:border-royal-gold">
                    <button class="bg-deep-maroon text-heritage-white px-8 py-4 font-medium hover:bg-royal-gold transition-colors">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection
