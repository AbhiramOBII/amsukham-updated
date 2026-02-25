@extends('layouts.app')

@section('title', 'Amsukham by Ram - Heritage Sarees')


@section('content')
    <!-- Hero Slider Section -->
    <section class="relative w-full overflow-hidden" style="height: 600px;">
        @forelse($banners as $index => $banner)
        <div class="hero-slide absolute inset-0 w-full h-full {{ $index > 0 ? 'hidden' : '' }}">
            <div class="absolute inset-0 w-full h-full">
                @if($banner->image)
                    <!-- Desktop Image -->
                    <img src="{{ $banner->image->url }}" alt="{{ $banner->title }}" class="hidden md:block w-full h-full object-cover">
                    <!-- Mobile Image (fallback to desktop if not set) -->
                    <img src="{{ $banner->mobileImage ? $banner->mobileImage->url : $banner->image->url }}" alt="{{ $banner->title }}" class="block md:hidden w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-deep-maroon/20 to-royal-gold/20"></div>
                @endif
            </div>
            
            <div class="relative z-10 h-full flex items-center">
                <div class="container mx-auto px-6">
                    <div class="max-w-2xl ml-0 md:ml-20">
                        <h2 class="font-serif text-4xl md:text-5xl lg:text-6xl text-deep-maroon mb-4 leading-tight">
                            {{ $banner->title }}
                            @if($banner->subtitle)
                            <span class="block text-royal-gold">{{ $banner->subtitle }}</span>
                            @endif
                        </h2>
                        @if($banner->description)
                        <p class="text-lg md:text-xl text-deep-maroon mb-6 leading-relaxed">
                            {{ $banner->description }}
                        </p>
                        @endif
                        @if($banner->button_text && $banner->button_link)
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ $banner->button_link }}" class="bg-royal-gold text-deep-maroon px-8 py-3 font-medium hover:bg-heritage-white transition-colors shadow-lg text-center">
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
        <div class="hero-slide absolute inset-0 w-full h-full">
            <div class="absolute inset-0 w-full h-full">
                <img src="{{ asset('images/slider-02-01.jpg') }}" alt="Heritage Saree Collection" class="w-full h-full object-cover">
            </div>
            <div class="relative z-10 h-full flex items-center">
                <div class="container mx-auto px-6">
                    <div class="max-w-2xl ml-0 md:ml-20">
                        <h2 class="font-serif text-4xl md:text-5xl lg:text-6xl text-deep-maroon mb-4 leading-tight">
                            Timeless Heritage
                            <span class="block text-royal-gold">Woven with Love</span>
                        </h2>
                        <p class="text-lg md:text-xl text-deep-maroon mb-6 leading-relaxed">
                            Exquisite handcrafted sarees where centuries-old traditions meet contemporary elegance.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('latest-collections') }}" class="bg-royal-gold text-deep-maroon px-8 py-3 font-medium hover:bg-heritage-white transition-colors shadow-lg text-center">
                                Explore Collections
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
        
        @if($banners->count() > 1)
        <!-- Arrow Navigation -->
        <button class="absolute left-6 top-1/2 transform -translate-y-1/2 z-20 bg-heritage-white/20 hover:bg-heritage-white/30 text-heritage-white hover:text-royal-gold transition-all p-3 rounded-full backdrop-blur-sm" id="hero-prev">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button class="absolute right-6 top-1/2 transform -translate-y-1/2 z-20 bg-heritage-white/20 hover:bg-heritage-white/30 text-heritage-white hover:text-royal-gold transition-all p-3 rounded-full backdrop-blur-sm" id="hero-next">
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

    <!-- Latest Collections Carousel -->
    <section id="collections" class="py-32 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h3 class="decorative-title font-serif text-5xl md:text-5xl text-deep-maroon mb-4">
                    Latest Collections
                </h3>
                <div class="w-24 h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mx-auto mb-6"></div>
                <p class="text-deep-maroon/70 max-w-2xl mx-auto">
                    Discover our newest arrivals, featuring contemporary designs that honor traditional craftsmanship and celebrate timeless elegance.
                </p>
            </div>
            
            @if($categories->isEmpty())
                <div class="text-center py-12">
                    <p class="text-deep-maroon/70">No categories available yet.</p>
                </div>
            @else
                <!-- Carousel Container -->
                <div class="relative">
                    <div class="overflow-hidden">
                        <div id="collections-carousel" class="py-8 flex transition-transform duration-500 ease-in-out">
                            @foreach($categories as $category)
                                <div class="w-full md:w-1/3 flex-shrink-0 px-4">
                                    <a href="{{ route('products', ['categories' => $category->id]) }}" class="group block bg-heritage-white overflow-hidden shadow-lg hover:-translate-y-1 transition-all duration-300">
                                        <div class="h-64 relative">
                                            @if($category->image)
                                                <img src="{{ $category->image->url }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-deep-maroon/10 to-royal-gold/10 flex items-center justify-center">
                                                    <svg class="w-16 h-16 text-deep-maroon/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                            <div class="absolute bottom-4 left-4 text-white">
                                                <span class="text-sm font-medium bg-royal-gold px-3 py-1 rounded-full text-deep-maroon">NEW</span>
                                            </div>
                                        </div>
                                        <div class="p-6">
                                            <h4 class="font-serif text-xl text-deep-maroon mb-2">{{ $category->name }}</h4>
                                            <p class="text-deep-maroon/70 mb-4 line-clamp-2">{{ $category->description ? strip_tags($category->description) : 'Explore our exquisite collection of handwoven sarees.' }}</p>
                                            <div class="flex justify-between items-center">
                                                <span class="text-royal-gold">{{ $category->products_count }} {{ Str::plural('Product', $category->products_count) }}</span>
                                                <span class="text-deep-maroon font-medium group-hover:text-royal-gold transition-colors">
                                                    View Collection →
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Carousel Navigation -->
                    <button id="collections-prev" class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-4 bg-heritage-white heritage-shadow p-3 rounded-full hover:bg-royal-gold hover:text-heritage-white transition-colors z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button id="collections-next" class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-4 bg-heritage-white heritage-shadow p-3 rounded-full hover:bg-royal-gold hover:text-heritage-white transition-colors z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            @endif
            
            <div class="text-center mt-12">
                <a href="{{ route('latest-collections') }}" class="inline-block bg-deep-maroon text-heritage-white px-8 py-4 font-medium hover:bg-royal-gold transition-colors shadow-lg">
                    View All Collections
                </a>
            </div>
        </div>
    </section>

    <!-- Best Sellers Section -->
    <section id="best-sellers" class="py-32 bg-soft-cream">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h3 class="decorative-title font-serif text-5xl text-deep-maroon mb-4">Best Sellers</h3>
                <div class="w-24 h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mx-auto mb-6"></div>
                <p class="text-deep-maroon/70 max-w-2xl mx-auto">
                    Our most beloved pieces, chosen by discerning connoisseurs who appreciate the art of traditional weaving.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProducts->take(4) as $product)
                <div class="bg-heritage-white overflow-hidden shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="h-64 relative">
                        @if($product->primaryImage && $product->primaryImage->media)
                            <img src="{{ $product->primaryImage->media->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-deep-maroon/10 to-royal-gold/10 flex items-center justify-center">
                                <svg class="w-16 h-16 text-deep-maroon/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        @if($product->discount > 0)
                            <span class="absolute top-3 left-3 bg-red-500 text-white px-2 py-1 text-xs font-medium">{{ number_format($product->discount) }}% OFF</span>
                        @endif
                    </div>
                    <div class="p-6">
                        <h4 class="font-serif text-lg text-deep-maroon mb-2">{{ $product->name }}</h4>
                        <p class="text-deep-maroon/70 text-sm mb-3">{{ $product->short_description ?? $product->category->name ?? '' }}</p>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                @php
                                    $firstColor = $product->productColors->first();
                                    $displayPrice = $product->discounted_price + ($firstColor ? $firstColor->price_adjustment : 0);
                                @endphp
                                @if($product->discount > 0)
                                    <span class="text-deep-maroon/50 line-through text-sm">₹{{ number_format($product->price + ($firstColor ? $firstColor->price_adjustment : 0)) }}</span>
                                @endif
                                <span class="font-serif text-xl text-royal-gold">₹{{ number_format($displayPrice) }}</span>
                            </div>
                            <button class="text-deep-maroon hover:text-royal-gold transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </div>
                        <a href="{{ route('product.show', $product->slug) }}" class="block w-full bg-deep-maroon text-heritage-white py-2 font-medium hover:bg-royal-gold transition-colors text-center">
                            View Details
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('products') }}" class="inline-block bg-deep-maroon text-heritage-white px-8 py-4 font-medium hover:bg-royal-gold transition-colors shadow-lg">
                    Shop All Products
                </a>
            </div>
        </div>
    </section>

    <!-- Heritage Story Section -->
    <section id="about" class="py-32 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <div class="aspect-square bg-soft-cream overflow-hidden shadow-lg">
                        <img src="{{ asset('images/slider-02.jpg') }}" alt="Heritage Craftsmanship" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-8 -right-8 bg-royal-gold p-8 shadow-lg">
                        <p class="font-serif text-4xl text-deep-maroon">70+</p>
                        <p class="text-deep-maroon font-medium">Years of Heritage</p>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-serif text-5xl text-deep-maroon mb-6">Our Heritage Story</h3>
                    <div class="w-24 h-1 gold-accent mb-8"></div>
                    <p class="text-deep-maroon/80 text-lg leading-relaxed mb-6">
                        For three generations, our family has been dedicated to preserving the timeless art of traditional Indian textiles. Each saree we create is a testament to the rich cultural heritage passed down through our artisan community.
                    </p>
                    <p class="text-deep-maroon/80 text-lg leading-relaxed mb-8">
                        From the finest Mysuru silk to the intricate zari work of Kanchipuram, we bring you authentic handcrafted pieces that celebrate India's textile legacy while embracing contemporary elegance.
                    </p>
                    <button class="bg-deep-maroon text-heritage-white px-8 py-4 font-medium hover:bg-royal-gold transition-colors shadow-lg">
                        Discover Our Journey
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Hero Slider Functionality
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
            } else {
                indicator.classList.remove('active');
                indicator.classList.remove('bg-heritage-white');
                indicator.classList.add('bg-heritage-white/50');
            }
        });
    }

    function showSlide(index) {
        if (isTransitioning) return;
        isTransitioning = true;

        slides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.remove('hidden');
            } else {
                slide.classList.add('hidden');
            }
        });

        currentSlide = index;
        updateIndicators();

        setTimeout(() => {
            isTransitioning = false;
        }, 600);
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

    document.addEventListener('DOMContentLoaded', function() {
        const prevButton = document.getElementById('hero-prev');
        const nextButton = document.getElementById('hero-next');
        
        if (prevButton) prevButton.addEventListener('click', prevSlide);
        if (nextButton) nextButton.addEventListener('click', nextSlide);

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => showSlide(index));
        });

        updateIndicators();
        setInterval(nextSlide, 6000);
    });

    // Collections Carousel
    let currentCollectionSlide = 0;
    const collectionsCarousel = document.getElementById('collections-carousel');
    const totalCollectionSlides = {{ $categories->count() }};

    function updateCollectionsCarousel() {
        if (collectionsCarousel && totalCollectionSlides > 0) {
            const translateX = -(currentCollectionSlide * 33.333);
            collectionsCarousel.style.transform = `translateX(${translateX}%)`;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const collectionsNextBtn = document.getElementById('collections-next');
        const collectionsPrevBtn = document.getElementById('collections-prev');
        
        if (collectionsNextBtn && totalCollectionSlides > 0) {
            collectionsNextBtn.addEventListener('click', function() {
                currentCollectionSlide = (currentCollectionSlide + 1) % totalCollectionSlides;
                updateCollectionsCarousel();
            });
        }
        
        if (collectionsPrevBtn && totalCollectionSlides > 0) {
            collectionsPrevBtn.addEventListener('click', function() {
                currentCollectionSlide = (currentCollectionSlide - 1 + totalCollectionSlides) % totalCollectionSlides;
                updateCollectionsCarousel();
            });
        }
    });

</script>
@endpush
