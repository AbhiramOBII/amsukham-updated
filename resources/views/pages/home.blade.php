@extends('layouts.app')

@section('title', 'Amsukham by Ram - Heritage Sarees')


@push('styles')
<style>
    .parallax-bg { transform: translateZ(-1px) scale(1.5); will-change: transform; }
    .hero-parallax-img { transition: transform 0.1s ease-out; will-change: transform; }
    .reveal-up { opacity: 0; transform: translateY(60px); transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-up.revealed { opacity: 1; transform: translateY(0); }
    .reveal-left { opacity: 0; transform: translateX(-80px); transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-left.revealed { opacity: 1; transform: translateX(0); }
    .reveal-right { opacity: 0; transform: translateX(80px); transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-right.revealed { opacity: 1; transform: translateX(0); }
    .reveal-scale { opacity: 0; transform: scale(0.9); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-scale.revealed { opacity: 1; transform: scale(1); }
    .stagger-children > * { opacity: 0; transform: translateY(40px); transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
    .stagger-children.revealed > *:nth-child(1) { transition-delay: 0.1s; }
    .stagger-children.revealed > *:nth-child(2) { transition-delay: 0.2s; }
    .stagger-children.revealed > *:nth-child(3) { transition-delay: 0.3s; }
    .stagger-children.revealed > *:nth-child(4) { transition-delay: 0.4s; }
    .stagger-children.revealed > * { opacity: 1; transform: translateY(0); }
    
    /* Premium Marquee Animation */
    .marquee-container { overflow: hidden; white-space: nowrap; }
    .marquee-content { display: inline-flex; animation: marquee 30s linear infinite; }
    .marquee-content:hover { animation-play-state: paused; }
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    
    /* Trust Badge Hover */
    .trust-badge { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    .trust-badge:hover { transform: translateY(-8px); }
    .trust-badge:hover .badge-icon { transform: scale(1.1) rotate(5deg); }
    .badge-icon { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    
    /* Testimonial Card */
    .testimonial-card { transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1); }
    .testimonial-card:hover { transform: translateY(-5px); box-shadow: 0 25px 50px -12px rgba(139, 69, 19, 0.15); }
    
    /* Gallery Grid */
    .gallery-item { transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1); }
    .gallery-item:hover { transform: scale(1.02); z-index: 10; }
    .gallery-item:hover img { transform: scale(1.1); }
    .gallery-item img { transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
    
    /* Newsletter Input */
    .newsletter-input { transition: all 0.3s ease; }
    .newsletter-input:focus { box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.3); }
    
    /* Shimmer Effect */
    .shimmer { position: relative; overflow: hidden; }
    .shimmer::after { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); animation: shimmer 2s infinite; }
    @keyframes shimmer { 100% { left: 100%; } }
    
    /* Stats Counter */
    .stat-number { background: linear-gradient(135deg, #D4AF37, #8B4513); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    
    /* Pulse Ring */
    .pulse-ring { animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite; }
    @keyframes pulse-ring { 0% { transform: scale(0.8); opacity: 1; } 100% { transform: scale(1.3); opacity: 0; } }
    .premium-card { transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1); position: relative; overflow: hidden; }
    .premium-card::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent); transition: left 0.7s ease; z-index: 10; }
    .premium-card:hover::before { left: 100%; }
    .premium-card:hover { transform: translateY(-12px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    .hero-slide { opacity: 0; transition: opacity 1s cubic-bezier(0.4, 0, 0.2, 1), transform 1.2s cubic-bezier(0.4, 0, 0.2, 1); transform: scale(1.05); }
    .hero-slide.active { opacity: 1; transform: scale(1); }
    .hero-slide.hidden { display: block !important; opacity: 0; pointer-events: none; }
    .text-reveal { overflow: hidden; }
    .text-reveal span { display: inline-block; transform: translateY(100%); transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .text-reveal.revealed span { transform: translateY(0); }
    @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
    .float-animation { animation: float 6s ease-in-out infinite; }
    .cta-premium { position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    .cta-premium::after { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: linear-gradient(45deg, transparent, rgba(255,255,255,0.15), transparent); transform: rotate(45deg) translateX(-100%); transition: transform 0.6s ease; }
    .cta-premium:hover::after { transform: rotate(45deg) translateX(100%); }
    .cta-premium:hover { transform: scale(1.05); box-shadow: 0 20px 40px -10px rgba(139, 69, 19, 0.4); }
    .parallax-section { position: relative; overflow: hidden; }
    .parallax-section .parallax-layer { position: absolute; inset: -50px; background-size: cover; background-position: center; background-attachment: fixed; }
    @media (max-width: 768px) { .parallax-section .parallax-layer { background-attachment: scroll; } }
    .gradient-overlay { background: linear-gradient(135deg, rgba(139, 69, 19, 0.85) 0%, rgba(212, 175, 55, 0.7) 100%); }
    .scroll-indicator { animation: bounce 2s infinite; }
    @keyframes bounce { 0%, 20%, 50%, 80%, 100% { transform: translateY(0) translateX(-50%); } 40% { transform: translateY(-20px) translateX(-50%); } 60% { transform: translateY(-10px) translateX(-50%); } }
    .animated-line { width: 0; transition: width 1s cubic-bezier(0.16, 1, 0.3, 1); }
    .animated-line.revealed { width: 6rem; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
    <!-- Hero Slider Section with Parallax -->
    <section class="relative w-full overflow-hidden" style="height: 100vh; min-height: 600px; max-height: 900px;">
        @forelse($banners as $index => $banner)
        <div class="hero-slide absolute inset-0 w-full h-full {{ $index === 0 ? 'active' : 'hidden' }}" data-index="{{ $index }}">
            <div class="absolute inset-0 w-full h-full overflow-hidden">
                @if($banner->image)
                    <img src="{{ $banner->image->url }}" alt="{{ $banner->title }}" class="hidden md:block w-full h-full object-cover hero-parallax-img" style="transform: scale(1.1);">
                    <img src="{{ $banner->mobileImage ? $banner->mobileImage->url : $banner->image->url }}" alt="{{ $banner->title }}" class="block md:hidden w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-deep-maroon/20 to-royal-gold/20"></div>
                @endif
            </div>
            
            <div class="relative z-10 h-full flex items-end md:items-center pb-16 md:pb-0">
                <div class="container mx-auto px-6">
                    <div class="max-w-2xl ml-0 md:ml-20">
                        <div class="text-reveal">
                            <h2 class="font-serif text-4xl md:text-5xl lg:text-7xl text-deep-maroon mb-4 leading-tight">
                                <span>{{ $banner->title }}</span>
                                @if($banner->subtitle)
                                <span class="block text-royal-gold mt-2">{{ $banner->subtitle }}</span>
                                @endif
                            </h2>
                        </div>
                        @if($banner->description)
                        <p class="text-lg md:text-xl text-deep-maroon/90 mb-8 leading-relaxed" style="animation: fadeInUp 0.8s 0.3s both;">
                            {{ $banner->description }}
                        </p>
                        @endif
                        @if($banner->button_text && $banner->button_link)
                        <div class="flex flex-col sm:flex-row gap-4" style="animation: fadeInUp 0.8s 0.5s both;">
                            <a href="{{ $banner->button_link }}" class="cta-premium bg-royal-gold text-deep-maroon px-10 py-4 font-semibold text-center rounded-sm shadow-2xl">
                                {{ $banner->button_text }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <!-- Default banner when no banners in database -->
        <div class="hero-slide absolute inset-0 w-full h-full active" data-index="0">
            <div class="absolute inset-0 w-full h-full overflow-hidden">
                <img src="{{ asset('images/slider-02-01.jpg') }}" alt="Heritage Saree Collection" class="w-full h-full object-cover hero-parallax-img" style="transform: scale(1.1);">
            </div>
            <div class="relative z-10 h-full flex items-end md:items-center pb-16 md:pb-0">
                <div class="container mx-auto px-6">
                    <div class="max-w-2xl ml-0 md:ml-20">
                        <div class="text-reveal revealed">
                            <h2 class="font-serif text-4xl md:text-5xl lg:text-7xl text-deep-maroon mb-4 leading-tight">
                                <span>Timeless Heritage</span>
                                <span class="block text-royal-gold mt-2">Woven with Love</span>
                            </h2>
                        </div>
                        <p class="text-lg md:text-xl text-deep-maroon/90 mb-8 leading-relaxed">
                            Exquisite handcrafted sarees where centuries-old traditions meet contemporary elegance.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('latest-collections') }}" class="cta-premium bg-royal-gold text-deep-maroon px-10 py-4 font-semibold text-center rounded-sm shadow-2xl">
                                Explore Collections
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 scroll-indicator z-20 hidden md:block">
            <div class="w-8 h-12 border-2 border-deep-maroon/50 rounded-full flex justify-center pt-2">
                <div class="w-1 h-3 bg-royal-gold rounded-full animate-pulse"></div>
            </div>
        </div>
        
        @if($banners->count() > 1)
        <!-- Arrow Navigation -->
        <button class="absolute left-6 top-1/2 transform -translate-y-1/2 z-20 bg-heritage-white/20 hover:bg-heritage-white/30 text-heritage-white hover:text-royal-gold transition-all p-3 rounded-full backdrop-blur-sm hidden md:flex" id="hero-prev">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button class="absolute right-6 top-1/2 transform -translate-y-1/2 z-20 bg-heritage-white/20 hover:bg-heritage-white/30 text-heritage-white hover:text-royal-gold transition-all p-3 rounded-full backdrop-blur-sm hidden md:flex" id="hero-next">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
        
        <!-- Slide Indicators -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-20 flex space-x-3">
            @foreach($banners as $index => $banner)
            <button class="w-3 h-3 rounded-full {{ $index === 0 ? 'bg-heritage-white' : 'bg-heritage-white/50' }} transition-colors slide-indicator" data-slide="{{ $index }}"></button>
            @endforeach
        </div>
        @endif
    </section>

    <!-- Premium Marquee Banner -->
    <section class="bg-deep-maroon py-4 overflow-hidden">
        <div class="marquee-container">
            <div class="marquee-content">
                @for($i = 0; $i < 2; $i++)
                <span class="inline-flex items-center px-8 text-heritage-white/90 text-sm tracking-widest uppercase">
                    <svg class="w-4 h-4 text-royal-gold mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Handcrafted Excellence
                </span>
                <span class="inline-flex items-center px-8 text-heritage-white/90 text-sm tracking-widest uppercase">
                    <svg class="w-4 h-4 text-royal-gold mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    70+ Years Heritage
                </span>
                <span class="inline-flex items-center px-8 text-heritage-white/90 text-sm tracking-widest uppercase">
                    <svg class="w-4 h-4 text-royal-gold mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Authentic Silk Sarees
                </span>
                <span class="inline-flex items-center px-8 text-heritage-white/90 text-sm tracking-widest uppercase">
                    <svg class="w-4 h-4 text-royal-gold mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Pan India Delivery
                </span>
                <span class="inline-flex items-center px-8 text-heritage-white/90 text-sm tracking-widest uppercase">
                    <svg class="w-4 h-4 text-royal-gold mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Premium Quality
                </span>
                @endfor
            </div>
        </div>
    </section>

    <!-- Trust Badges Section -->
    <section class="py-16 bg-gradient-to-b from-heritage-white to-soft-cream relative overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <div class="trust-badge text-center p-6 bg-heritage-white rounded-lg shadow-lg border border-royal-gold/10">
                    <div class="badge-icon w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-royal-gold/20 to-royal-gold/5 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h4 class="font-serif text-lg text-deep-maroon mb-1">100% Authentic</h4>
                    <p class="text-deep-maroon/60 text-sm">Certified genuine silk</p>
                </div>
                
                <div class="trust-badge text-center p-6 bg-heritage-white rounded-lg shadow-lg border border-royal-gold/10">
                    <div class="badge-icon w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-royal-gold/20 to-royal-gold/5 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h4 class="font-serif text-lg text-deep-maroon mb-1">Free Shipping</h4>
                    <p class="text-deep-maroon/60 text-sm">On orders above ₹5000</p>
                </div>
                
                <div class="trust-badge text-center p-6 bg-heritage-white rounded-lg shadow-lg border border-royal-gold/10">
                    <div class="badge-icon w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-royal-gold/20 to-royal-gold/5 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <h4 class="font-serif text-lg text-deep-maroon mb-1">Easy Returns</h4>
                    <p class="text-deep-maroon/60 text-sm">7-day return policy</p>
                </div>
                
                <div class="trust-badge text-center p-6 bg-heritage-white rounded-lg shadow-lg border border-royal-gold/10">
                    <div class="badge-icon w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-royal-gold/20 to-royal-gold/5 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h4 class="font-serif text-lg text-deep-maroon mb-1">Expert Support</h4>
                    <p class="text-deep-maroon/60 text-sm">Dedicated assistance</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Collections Carousel -->
    <section id="collections" class="py-24 bg-gradient-to-b from-heritage-white via-white to-heritage-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-royal-gold/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-deep-maroon/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/3"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16 reveal-up">
                <span class="inline-block text-royal-gold text-sm font-semibold tracking-[0.3em] uppercase mb-4">Curated For You</span>
                <h3 class="decorative-title font-serif text-3xl md:text-5xl lg:text-6xl text-deep-maroon mb-4">
                    Latest Collections
                </h3>
                <div class="animated-line h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mx-auto mb-6"></div>
                <p class="text-deep-maroon/70 max-w-2xl mx-auto text-lg leading-relaxed">
                    Discover our newest arrivals, featuring contemporary designs that honor traditional craftsmanship and celebrate timeless elegance.
                </p>
            </div>
            
            @if($categories->isEmpty())
                <div class="text-center py-12 reveal-up">
                    <p class="text-deep-maroon/70">No categories available yet.</p>
                </div>
            @else
                <!-- Carousel Container -->
                <div class="relative reveal-up" style="transition-delay: 0.2s;">
                    <div class="overflow-hidden">
                        <div id="collections-carousel" class="py-4 flex transition-transform duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]">
                            @foreach($categories as $category)
                                <div class="w-full md:w-1/3 flex-shrink-0 px-4">
                                    <a href="{{ route('products', ['categories' => $category->id]) }}" class="premium-card group block bg-heritage-white overflow-hidden shadow-xl rounded-lg border border-gray-100">
                                        <div class="aspect-square relative overflow-hidden">
                                            @if($category->image)
                                                <img src="{{ $category->image->url }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-out">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-deep-maroon/10 to-royal-gold/10 flex items-center justify-center">
                                                    <svg class="w-16 h-16 text-deep-maroon/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-500"></div>
                                            <div class="absolute top-4 left-4">
                                                <span class="text-xs font-semibold bg-royal-gold/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-deep-maroon shadow-lg uppercase tracking-wider">New</span>
                                            </div>
                                            <div class="absolute bottom-4 left-4 right-4 text-white">
                                                <h4 class="font-serif text-2xl mb-1 drop-shadow-lg">{{ $category->name }}</h4>
                                                <span class="text-white/80 text-sm">{{ $category->products_count }} {{ Str::plural('Product', $category->products_count) }}</span>
                                            </div>
                                        </div>
                                        <div class="p-5">
                                            <p class="text-deep-maroon/70 text-sm mb-4 line-clamp-2">{{ $category->description ? strip_tags($category->description) : 'Explore our exquisite collection of handwoven sarees.' }}</p>
                                            <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                                <span class="text-deep-maroon font-medium group-hover:text-royal-gold transition-colors duration-300 flex items-center gap-2">
                                                    Shop Collection
                                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Carousel Navigation -->
                    <button id="collections-prev" class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-4 bg-heritage-white/90 backdrop-blur-sm shadow-xl p-4 rounded-full hover:bg-royal-gold hover:text-heritage-white transition-all duration-300 z-10 hover:scale-110 border border-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button id="collections-next" class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-4 bg-heritage-white/90 backdrop-blur-sm shadow-xl p-4 rounded-full hover:bg-royal-gold hover:text-heritage-white transition-all duration-300 z-10 hover:scale-110 border border-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            @endif
            <div class="text-center mt-14 reveal-up" style="transition-delay: 0.4s;">
                <a href="{{ route('latest-collections') }}" class="cta-premium inline-block bg-deep-maroon text-heritage-white px-12 py-4 font-semibold rounded-sm shadow-xl hover:shadow-2xl">
                    View All Collections
                </a>
            </div>
        </div>
    </section>

    <!-- Best Sellers Carousel Section -->
    <section id="best-sellers" class="pt-24 pb-28 bg-soft-cream relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23000' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16 reveal-up">
                <span class="inline-block text-royal-gold text-sm font-semibold tracking-[0.3em] uppercase mb-4">Most Loved</span>
                <h3 class="decorative-title font-serif text-3xl md:text-5xl lg:text-6xl text-deep-maroon mb-4">Best Sellers</h3>
                <div class="animated-line h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mx-auto mb-6"></div>
                <p class="text-deep-maroon/70 max-w-2xl mx-auto text-lg">
                    Our most beloved pieces, chosen by discerning connoisseurs who appreciate the art of traditional weaving.
                </p>
            </div>
            
            @if($bestsellerProducts->isEmpty())
                <div class="text-center py-12 reveal-up">
                    <p class="text-deep-maroon/70">No bestsellers available yet.</p>
                </div>
            @else
                <!-- Bestsellers Carousel Container -->
                <div class="relative reveal-up" style="transition-delay: 0.2s;">
                    <div class="overflow-hidden">
                        <div id="bestsellers-carousel" class="py-4 flex transition-transform duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]">
                            @foreach($bestsellerProducts as $product)
                                <div class="w-full sm:w-1/2 lg:w-1/4 flex-shrink-0 px-4">
                                    <div class="premium-card bg-heritage-white overflow-hidden shadow-xl rounded-sm h-full">
                                        <a href="{{ route('product.show', $product->slug) }}" class="block">
                                            <div class="h-72 relative overflow-hidden group">
                                                @if($product->thumbnail)
                                                    <img src="{{ $product->thumbnail->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-out">
                                                @elseif($product->primaryImage && $product->primaryImage->media)
                                                    <img src="{{ $product->primaryImage->media->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-out">
                                                @else
                                                    <div class="w-full h-full bg-gradient-to-br from-deep-maroon/10 to-royal-gold/10 flex items-center justify-center">
                                                        <svg class="w-16 h-16 text-deep-maroon/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    </div>
                                                @endif
                                                @if($product->discount > 0)
                                                    <span class="absolute top-3 left-3 bg-gradient-to-r from-red-500 to-red-600 text-white px-3 py-1.5 text-xs font-semibold rounded-full shadow-lg">{{ number_format($product->discount) }}% OFF</span>
                                                @endif
                                                <span class="absolute top-3 right-3 bg-gradient-to-r from-royal-gold to-yellow-500 text-deep-maroon px-3 py-1.5 text-xs font-semibold rounded-full shadow-lg">Bestseller</span>
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                            </div>
                                        </a>
                                        <div class="p-6">
                                            <h4 class="font-serif text-lg text-deep-maroon mb-3 hover:text-royal-gold transition-colors duration-300">
                                                <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                            </h4>
                                            <div class="flex justify-between items-center mb-4">
                                                <div>
                                                    @php
                                                        $firstColor = $product->productColors->first();
                                                        $priceAdjustment = $firstColor ? $firstColor->price_adjustment : 0;
                                                        $totalOriginalPrice = $product->price + $priceAdjustment;
                                                        $totalDiscountedPrice = $product->discount > 0 
                                                            ? $totalOriginalPrice - ($totalOriginalPrice * $product->discount / 100)
                                                            : $totalOriginalPrice;
                                                    @endphp
                                                    @if($product->discount > 0)
                                                        <span class="text-deep-maroon/50 line-through text-sm">₹{{ number_format($totalOriginalPrice) }}</span>
                                                    @endif
                                                    <span class="font-serif text-2xl text-royal-gold">₹{{ number_format(round($totalDiscountedPrice)) }}</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('product.show', $product->slug) }}" class="cta-premium block w-full bg-deep-maroon text-heritage-white py-3 font-semibold text-center rounded-sm">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Carousel Navigation -->
                    <button id="bestsellers-prev" class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-4 bg-heritage-white/90 backdrop-blur-sm shadow-xl p-4 rounded-full hover:bg-royal-gold hover:text-heritage-white transition-all duration-300 z-10 hover:scale-110 border border-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button id="bestsellers-next" class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-4 bg-heritage-white/90 backdrop-blur-sm shadow-xl p-4 rounded-full hover:bg-royal-gold hover:text-heritage-white transition-all duration-300 z-10 hover:scale-110 border border-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            @endif
            
            <div class="text-center mt-14 reveal-up">
                <a href="{{ route('products') }}" class="cta-premium inline-block bg-deep-maroon text-heritage-white px-10 py-4 font-semibold rounded-sm shadow-xl">
                    Shop All Products
                </a>
            </div>
        </div>
    </section>
    
    <!-- Premium CTA Section with Parallax -->
    <section class="parallax-section relative py-32 overflow-hidden">
        <div class="parallax-layer" style="background-image: url('{{ asset('images/slider-02.jpg') }}');"></div>
        <div class="absolute inset-0 gradient-overlay opacity-60"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center reveal-scale">
                <span class="inline-block text-heritage-white/80 text-sm tracking-[0.3em] uppercase mb-4">Exclusive Collection</span>
                <h2 class="font-serif text-4xl md:text-5xl lg:text-6xl text-heritage-white mb-6 leading-tight">
                    Experience the Art of
                    <span class="block text-royal-gold mt-2">Timeless Elegance</span>
                </h2>
                <p class="text-heritage-white/90 text-lg md:text-xl mb-10 leading-relaxed">
                    Each piece is a masterwork of tradition, handcrafted by skilled artisans who have perfected their craft over generations.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('products') }}" class="cta-premium bg-royal-gold text-deep-maroon px-10 py-4 font-semibold rounded-sm shadow-2xl">
                        Explore Collection
                    </a>
                    <a href="{{ route('about') }}" class="cta-premium bg-transparent border-2 border-heritage-white text-heritage-white px-10 py-4 font-semibold rounded-sm hover:bg-heritage-white hover:text-deep-maroon">
                        Our Story
                    </a>
                </div>
            </div>
        </div>
        
        <div class="absolute top-20 left-10 w-20 h-20 border border-royal-gold/30 rounded-full float-animation hidden lg:block"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 border border-heritage-white/20 rounded-full float-animation hidden lg:block" style="animation-delay: -3s;"></div>
    </section>

    <!-- Heritage Story Section -->
    <section id="about" class="py-24 bg-heritage-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-5">
            <div class="absolute top-20 right-20 w-64 h-64 border border-royal-gold rounded-full"></div>
            <div class="absolute bottom-20 left-20 w-48 h-48 border border-deep-maroon rounded-full"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 lg:items-center items-center">
                <div class="relative order-2 lg:order-1 reveal-left">
                    <div class="aspect-square bg-soft-cream overflow-hidden shadow-2xl rounded-sm">
                        <img src="{{ asset('images/heritage-01.jpg') }}" alt="Heritage Craftsmanship" class="w-full h-full object-cover hover:scale-105 transition-transform duration-1000">
                    </div>
                    <div class="absolute -bottom-8 -right-8 bg-royal-gold p-8 shadow-2xl hidden md:block float-animation" style="animation-duration: 4s;">
                        <p class="font-serif text-5xl text-deep-maroon">70+</p>
                        <p class="text-deep-maroon font-semibold">Years of Heritage</p>
                    </div>
                    <div class="absolute -top-4 -left-4 w-24 h-24 border-2 border-royal-gold/30 hidden md:block"></div>
                </div>
                
                <div class="order-1 lg:order-2 lg:pt-8 reveal-right">
                    <span class="inline-block text-royal-gold text-sm tracking-[0.3em] uppercase mb-4">Our Legacy</span>
                    <h3 class="font-serif text-3xl md:text-5xl lg:text-6xl text-deep-maroon mb-6 leading-tight">Our Heritage Story</h3>
                    <div class="animated-line h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mb-8"></div>
                    <p class="text-deep-maroon/80 text-lg leading-relaxed mb-6">
                        For three generations, our family has been dedicated to preserving the timeless art of traditional Indian textiles. Each saree we create is a testament to the rich cultural heritage passed down through our artisan community.
                    </p>
                    <p class="text-deep-maroon/80 text-lg leading-relaxed mb-10">
                        From the finest Mysuru silk to the intricate zari work of Kanchipuram, we bring you authentic handcrafted pieces that celebrate India's textile legacy while embracing contemporary elegance.
                    </p>
                    <a href="{{ route('about') }}" class="cta-premium inline-block bg-deep-maroon text-heritage-white px-10 py-4 font-semibold rounded-sm shadow-xl">
                        Discover Our Journey
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-24 bg-gradient-to-b from-soft-cream to-heritage-white relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-royal-gold/5 rounded-full blur-3xl"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16 reveal-up">
                <span class="inline-block text-royal-gold text-sm tracking-[0.3em] uppercase mb-4">What Our Customers Say</span>
                <h3 class="decorative-title font-serif text-3xl md:text-5xl lg:text-6xl text-deep-maroon mb-4">Loved by Thousands</h3>
                <div class="animated-line h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mx-auto mb-6"></div>
            </div>
            
            <div class="relative">
                <div class="overflow-hidden">
                    <div id="testimonials-carousel" class="flex transition-transform duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]">
                        <!-- Testimonial 1 -->
                        <div class="w-full md:w-1/3 flex-shrink-0 px-4">
                            <div class="testimonial-card bg-heritage-white p-8 rounded-lg shadow-xl border border-royal-gold/10 h-full">
                                <div class="flex items-center gap-1 mb-4">
                                    @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-royal-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <p class="text-deep-maroon/80 text-lg leading-relaxed mb-6 italic">"The quality of the silk is exceptional. I received so many compliments at my daughter's wedding. Truly a masterpiece!"</p>
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-royal-gold to-deep-maroon rounded-full flex items-center justify-center text-heritage-white font-serif text-xl">P</div>
                                    <div>
                                        <h5 class="font-semibold text-deep-maroon">Priya Sharma</h5>
                                        <p class="text-deep-maroon/60 text-sm">Mumbai</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 2 -->
                        <div class="w-full md:w-1/3 flex-shrink-0 px-4">
                            <div class="testimonial-card bg-heritage-white p-8 rounded-lg shadow-xl border border-royal-gold/10 h-full">
                                <div class="flex items-center gap-1 mb-4">
                                    @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-royal-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <p class="text-deep-maroon/80 text-lg leading-relaxed mb-6 italic">"Been buying from Amsukham for years. The craftsmanship and attention to detail is unmatched. Highly recommended!"</p>
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-royal-gold to-deep-maroon rounded-full flex items-center justify-center text-heritage-white font-serif text-xl">R</div>
                                    <div>
                                        <h5 class="font-semibold text-deep-maroon">Radha Krishnan</h5>
                                        <p class="text-deep-maroon/60 text-sm">Chennai</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 3 -->
                        <div class="w-full md:w-1/3 flex-shrink-0 px-4">
                            <div class="testimonial-card bg-heritage-white p-8 rounded-lg shadow-xl border border-royal-gold/10 h-full">
                                <div class="flex items-center gap-1 mb-4">
                                    @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-royal-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <p class="text-deep-maroon/80 text-lg leading-relaxed mb-6 italic">"Excellent customer service and the saree was even more beautiful in person. Perfect for my anniversary celebration."</p>
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-royal-gold to-deep-maroon rounded-full flex items-center justify-center text-heritage-white font-serif text-xl">A</div>
                                    <div>
                                        <h5 class="font-semibold text-deep-maroon">Anjali Menon</h5>
                                        <p class="text-deep-maroon/60 text-sm">Bangalore</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 4 -->
                        <div class="w-full md:w-1/3 flex-shrink-0 px-4">
                            <div class="testimonial-card bg-heritage-white p-8 rounded-lg shadow-xl border border-royal-gold/10 h-full">
                                <div class="flex items-center gap-1 mb-4">
                                    @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-royal-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <p class="text-deep-maroon/80 text-lg leading-relaxed mb-6 italic">"The Kanchipuram silk saree I purchased is absolutely stunning. The zari work is intricate and the colors are vibrant."</p>
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-royal-gold to-deep-maroon rounded-full flex items-center justify-center text-heritage-white font-serif text-xl">S</div>
                                    <div>
                                        <h5 class="font-semibold text-deep-maroon">Sunita Reddy</h5>
                                        <p class="text-deep-maroon/60 text-sm">Hyderabad</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 5 -->
                        <div class="w-full md:w-1/3 flex-shrink-0 px-4">
                            <div class="testimonial-card bg-heritage-white p-8 rounded-lg shadow-xl border border-royal-gold/10 h-full">
                                <div class="flex items-center gap-1 mb-4">
                                    @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-royal-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <p class="text-deep-maroon/80 text-lg leading-relaxed mb-6 italic">"My go-to store for authentic silk sarees. Every piece tells a story of tradition and excellence. Thank you Amsukham!"</p>
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-royal-gold to-deep-maroon rounded-full flex items-center justify-center text-heritage-white font-serif text-xl">M</div>
                                    <div>
                                        <h5 class="font-semibold text-deep-maroon">Meera Iyer</h5>
                                        <p class="text-deep-maroon/60 text-sm">Delhi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Arrows -->
                <button id="testimonials-prev" class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-4 bg-heritage-white shadow-xl p-3 rounded-full hover:bg-royal-gold hover:text-heritage-white transition-all duration-300 z-10 hidden md:block">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button id="testimonials-next" class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-4 bg-heritage-white shadow-xl p-3 rounded-full hover:bg-royal-gold hover:text-heritage-white transition-all duration-300 z-10 hidden md:block">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </section>

    <!-- Instagram Gallery Section -->
    <section class="py-24 bg-heritage-white relative overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12 reveal-up">
                <span class="inline-block text-royal-gold text-sm tracking-[0.3em] uppercase mb-4">Follow Our Journey</span>
                <h3 class="decorative-title font-serif text-3xl md:text-5xl lg:text-6xl text-deep-maroon mb-4">@amsukhambyram</h3>
                <div class="animated-line h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mx-auto mb-6"></div>
                <p class="text-deep-maroon/70 max-w-2xl mx-auto text-lg">Join our community of silk connoisseurs and stay inspired</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3 md:gap-4 reveal-scale">
                @foreach($featuredProducts->take(6) as $index => $product)
                <a href="{{ route('product.show', $product->slug) }}" class="gallery-item relative aspect-square overflow-hidden rounded-sm group {{ $index < 2 ? 'md:col-span-2 md:row-span-2' : '' }}">
                    @if($product->thumbnail)
                        <img src="{{ $product->thumbnail->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @elseif($product->primaryImage && $product->primaryImage->media)
                        <img src="{{ $product->primaryImage->media->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-deep-maroon/10 to-royal-gold/10"></div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-6">
                        <div class="text-center text-heritage-white">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            <span class="text-sm font-medium">View Product</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            
            <div class="text-center mt-10 reveal-up">
                <a href="https://instagram.com/amsukhambyram" target="_blank" class="inline-flex items-center gap-3 text-deep-maroon hover:text-royal-gold transition-colors font-semibold">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    Follow us on Instagram
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    {{-- <section class="py-20 bg-gradient-to-r from-deep-maroon via-deep-maroon to-deep-maroon/95 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-40 h-40 border border-royal-gold rounded-full"></div>
            <div class="absolute bottom-10 right-10 w-60 h-60 border border-royal-gold rounded-full"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 border border-royal-gold/50 rounded-full"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center reveal-up">
                <span class="inline-block text-royal-gold text-sm tracking-[0.3em] uppercase mb-4">Stay Connected</span>
                <h3 class="font-serif text-3xl md:text-5xl text-heritage-white mb-4">Join Our Heritage Circle</h3>
                <p class="text-heritage-white/80 text-lg mb-10">Subscribe to receive exclusive previews, special offers, and stories from our artisan community.</p>
                
                <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                    <input type="email" placeholder="Enter your email address" class="newsletter-input flex-1 px-6 py-4 rounded-sm bg-heritage-white/10 border border-heritage-white/30 text-heritage-white placeholder-heritage-white/50 focus:outline-none focus:border-royal-gold">
                    <button type="submit" class="cta-premium bg-royal-gold text-deep-maroon px-8 py-4 font-semibold rounded-sm shadow-xl whitespace-nowrap">
                        Subscribe
                    </button>
                </form>
                
                <p class="text-heritage-white/50 text-sm mt-6">By subscribing, you agree to our Privacy Policy. Unsubscribe anytime.</p>
            </div>
        </div>
    </section> --}}
@endsection

@push('scripts')
<script>
    // Hero Slider with Premium Transitions
    let currentSlide = 0;
    const slides = document.querySelectorAll('.hero-slide');
    const indicators = document.querySelectorAll('.slide-indicator');
    const totalSlides = slides.length;
    let isTransitioning = false;

    function updateIndicators() {
        indicators.forEach((indicator, index) => {
            if (index === currentSlide) {
                indicator.classList.add('active');
                indicator.classList.remove('bg-heritage-white/50');
                indicator.classList.add('bg-heritage-white');
                indicator.style.transform = 'scale(1.3)';
            } else {
                indicator.classList.remove('active');
                indicator.classList.remove('bg-heritage-white');
                indicator.classList.add('bg-heritage-white/50');
                indicator.style.transform = 'scale(1)';
            }
        });
    }

    function showSlide(index) {
        if (isTransitioning) return;
        isTransitioning = true;

        slides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.remove('hidden');
                slide.classList.add('active');
                const textReveal = slide.querySelector('.text-reveal');
                if (textReveal) textReveal.classList.add('revealed');
            } else {
                slide.classList.remove('active');
                slide.classList.add('hidden');
                const textReveal = slide.querySelector('.text-reveal');
                if (textReveal) textReveal.classList.remove('revealed');
            }
        });

        currentSlide = index;
        updateIndicators();

        setTimeout(() => {
            isTransitioning = false;
        }, 1000);
    }

    function nextSlide() {
        if (isTransitioning) return;
        const nextIndex = (currentSlide + 1) % totalSlides;
        showSlide(nextIndex);
    }

    function prevSlide() {
        if (isTransitioning) return;
        const prevIndex = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(prevIndex);
    }

    // Hero Parallax Effect
    function initHeroParallax() {
        const heroImages = document.querySelectorAll('.hero-parallax-img');
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            heroImages.forEach(img => {
                const rate = scrolled * 0.3;
                img.style.transform = `scale(1.1) translateY(${rate}px)`;
            });
        }, { passive: true });
    }

    // Scroll Reveal Animation
    function initScrollReveal() {
        const revealElements = document.querySelectorAll('.reveal-up, .reveal-left, .reveal-right, .reveal-scale, .stagger-children, .animated-line');
        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -100px 0px',
            threshold: 0.1
        };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        revealElements.forEach(el => observer.observe(el));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const prevButton = document.getElementById('hero-prev');
        const nextButton = document.getElementById('hero-next');
        
        if (prevButton) prevButton.addEventListener('click', prevSlide);
        if (nextButton) nextButton.addEventListener('click', nextSlide);

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => showSlide(index));
        });

        // Initialize first slide
        if (slides.length > 0) {
            slides[0].classList.add('active');
            const textReveal = slides[0].querySelector('.text-reveal');
            if (textReveal) textReveal.classList.add('revealed');
        }

        updateIndicators();
        initHeroParallax();
        initScrollReveal();
        setInterval(nextSlide, 6000);
    });

    // Collections Carousel with Infinite Loop
    let currentCollectionSlide = 0;
    const collectionsCarousel = document.getElementById('collections-carousel');
    const totalCollectionItems = {{ $categories->count() }};
    const visibleItems = window.innerWidth >= 768 ? 3 : 1; // 3 on desktop, 1 on mobile
    const maxSlide = Math.max(0, totalCollectionItems - visibleItems);
    let collectionAutoSlideInterval;

    function updateCollectionsCarousel() {
        if (collectionsCarousel && totalCollectionItems > 0) {
            const itemWidth = window.innerWidth >= 768 ? 33.333 : 100;
            const translateX = -(currentCollectionSlide * itemWidth);
            collectionsCarousel.style.transform = `translateX(${translateX}%)`;
        }
    }

    function nextCollection() {
        if (currentCollectionSlide >= maxSlide) {
            currentCollectionSlide = 0; // Loop back to start
        } else {
            currentCollectionSlide++;
        }
        updateCollectionsCarousel();
    }

    function prevCollection() {
        if (currentCollectionSlide <= 0) {
            currentCollectionSlide = maxSlide; // Loop to end
        } else {
            currentCollectionSlide--;
        }
        updateCollectionsCarousel();
    }

    function startCollectionAutoSlide() {
        collectionAutoSlideInterval = setInterval(nextCollection, 4000);
    }

    function resetCollectionAutoSlide() {
        clearInterval(collectionAutoSlideInterval);
        startCollectionAutoSlide();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const collectionsNextBtn = document.getElementById('collections-next');
        const collectionsPrevBtn = document.getElementById('collections-prev');
        
        if (collectionsNextBtn && totalCollectionItems > 0) {
            collectionsNextBtn.addEventListener('click', function() {
                nextCollection();
                resetCollectionAutoSlide();
            });
        }
        
        if (collectionsPrevBtn && totalCollectionItems > 0) {
            collectionsPrevBtn.addEventListener('click', function() {
                prevCollection();
                resetCollectionAutoSlide();
            });
        }

        // Start auto-slide
        if (totalCollectionItems > visibleItems) {
            startCollectionAutoSlide();
        }

        // Pause on hover
        if (collectionsCarousel) {
            collectionsCarousel.addEventListener('mouseenter', () => clearInterval(collectionAutoSlideInterval));
            collectionsCarousel.addEventListener('mouseleave', startCollectionAutoSlide);
        }
    });

    // Bestsellers Carousel
    let currentBestsellerSlide = 0;
    const bestsellersCarousel = document.getElementById('bestsellers-carousel');
    const totalBestsellerItems = {{ $bestsellerProducts->count() }};
    const visibleBestsellerItems = window.innerWidth >= 1024 ? 4 : (window.innerWidth >= 640 ? 2 : 1);
    const maxBestsellerSlide = Math.max(0, totalBestsellerItems - visibleBestsellerItems);
    let bestsellerAutoSlideInterval;

    function updateBestsellersCarousel() {
        if (bestsellersCarousel && totalBestsellerItems > 0) {
            const itemWidth = window.innerWidth >= 1024 ? 25 : (window.innerWidth >= 640 ? 50 : 100);
            const translateX = -(currentBestsellerSlide * itemWidth);
            bestsellersCarousel.style.transform = `translateX(${translateX}%)`;
        }
    }

    function nextBestseller() {
        if (currentBestsellerSlide >= maxBestsellerSlide) {
            currentBestsellerSlide = 0;
        } else {
            currentBestsellerSlide++;
        }
        updateBestsellersCarousel();
    }

    function prevBestseller() {
        if (currentBestsellerSlide <= 0) {
            currentBestsellerSlide = maxBestsellerSlide;
        } else {
            currentBestsellerSlide--;
        }
        updateBestsellersCarousel();
    }

    function startBestsellerAutoSlide() {
        bestsellerAutoSlideInterval = setInterval(nextBestseller, 4000);
    }

    function resetBestsellerAutoSlide() {
        clearInterval(bestsellerAutoSlideInterval);
        startBestsellerAutoSlide();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const bestsellerNextBtn = document.getElementById('bestsellers-next');
        const bestsellerPrevBtn = document.getElementById('bestsellers-prev');

        if (bestsellerNextBtn && totalBestsellerItems > 0) {
            bestsellerNextBtn.addEventListener('click', function() {
                nextBestseller();
                resetBestsellerAutoSlide();
            });
        }

        if (bestsellerPrevBtn && totalBestsellerItems > 0) {
            bestsellerPrevBtn.addEventListener('click', function() {
                prevBestseller();
                resetBestsellerAutoSlide();
            });
        }

        if (totalBestsellerItems > visibleBestsellerItems) {
            startBestsellerAutoSlide();
        }

        if (bestsellersCarousel) {
            bestsellersCarousel.addEventListener('mouseenter', () => clearInterval(bestsellerAutoSlideInterval));
            bestsellersCarousel.addEventListener('mouseleave', startBestsellerAutoSlide);
        }
    });

    // Testimonials Carousel
    let currentTestimonialSlide = 0;
    const testimonialsCarousel = document.getElementById('testimonials-carousel');
    const totalTestimonials = 5;
    const visibleTestimonials = window.innerWidth >= 768 ? 3 : 1;
    const maxTestimonialSlide = Math.max(0, totalTestimonials - visibleTestimonials);
    let testimonialAutoSlideInterval;

    function updateTestimonialsCarousel() {
        if (testimonialsCarousel) {
            const itemWidth = window.innerWidth >= 768 ? 33.333 : 100;
            const translateX = -(currentTestimonialSlide * itemWidth);
            testimonialsCarousel.style.transform = `translateX(${translateX}%)`;
        }
    }

    function nextTestimonial() {
        if (currentTestimonialSlide >= maxTestimonialSlide) {
            currentTestimonialSlide = 0;
        } else {
            currentTestimonialSlide++;
        }
        updateTestimonialsCarousel();
    }

    function prevTestimonial() {
        if (currentTestimonialSlide <= 0) {
            currentTestimonialSlide = maxTestimonialSlide;
        } else {
            currentTestimonialSlide--;
        }
        updateTestimonialsCarousel();
    }

    function startTestimonialAutoSlide() {
        testimonialAutoSlideInterval = setInterval(nextTestimonial, 5000);
    }

    function resetTestimonialAutoSlide() {
        clearInterval(testimonialAutoSlideInterval);
        startTestimonialAutoSlide();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const testimonialNextBtn = document.getElementById('testimonials-next');
        const testimonialPrevBtn = document.getElementById('testimonials-prev');
        
        if (testimonialNextBtn) {
            testimonialNextBtn.addEventListener('click', function() {
                nextTestimonial();
                resetTestimonialAutoSlide();
            });
        }
        
        if (testimonialPrevBtn) {
            testimonialPrevBtn.addEventListener('click', function() {
                prevTestimonial();
                resetTestimonialAutoSlide();
            });
        }

        // Start auto-slide for testimonials
        if (totalTestimonials > visibleTestimonials) {
            startTestimonialAutoSlide();
        }

        // Pause on hover
        if (testimonialsCarousel) {
            testimonialsCarousel.addEventListener('mouseenter', () => clearInterval(testimonialAutoSlideInterval));
            testimonialsCarousel.addEventListener('mouseleave', startTestimonialAutoSlide);
        }
    });

</script>
@endpush
