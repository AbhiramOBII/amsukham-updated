@extends('layouts.app')

@section('title', 'Latest Collections - Amsukham by Ram')

@section('content')
    <!-- Hero Section -->
    <section class="py-20 bg-gradient-to-br from-soft-cream to-heritage-white relative overflow-hidden">
        <div class="brand-pattern-header absolute inset-0 bg-repeat opacity-10 pointer-events-none"></div>
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

    <!-- Categories Grid -->
    <section class="py-20 bg-soft-cream">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="font-serif text-4xl text-deep-maroon mb-4">Shop by Category</h2>
                <p class="text-deep-maroon/70 text-lg">Explore our curated collections</p>
            </div>

            @if($categories->isEmpty())
                <div class="text-center py-12">
                    <p class="text-deep-maroon/70">No categories available yet.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($categories as $index => $category)
                        @if($index === 0)
                            <div class="md:col-span-2 lg:row-span-2">
                                <a href="{{ route('products', ['categories' => $category->id]) }}" class="group block relative overflow-hidden shadow-lg bg-heritage-white h-full min-h-[400px] lg:min-h-[500px]">
                                    <div class="absolute inset-0">
                                        @if($category->image)
                                            <img src="{{ $category->image->url }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-deep-maroon/20 to-royal-gold/20"></div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-deep-maroon/80 via-deep-maroon/20 to-transparent"></div>
                                    </div>
                                    <div class="absolute inset-0 p-8 flex flex-col justify-end">
                                        <div class="text-heritage-white">
                                            <span class="inline-block bg-royal-gold text-deep-maroon px-3 py-1 text-sm font-medium mb-4">Featured</span>
                                            <h3 class="font-serif text-3xl lg:text-4xl mb-3">{{ $category->name }}</h3>
                                            @if($category->description)
                                                <p class="text-heritage-white/90 mb-4 text-lg line-clamp-2">{!! strip_tags($category->description) !!}</p>
                                            @endif
                                            <div class="flex items-center justify-between">
                                                <span class="text-royal-gold">{{ $category->products_count }} Products</span>
                                                <span class="bg-heritage-white text-deep-maroon px-6 py-3 font-medium group-hover:bg-royal-gold transition-colors">
                                                    Explore Collection
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @else
                            <div>
                                <a href="{{ route('products', ['categories' => $category->id]) }}" class="group block relative overflow-hidden shadow-lg bg-heritage-white h-80">
                                    <div class="absolute inset-0">
                                        @if($category->image)
                                            <img src="{{ $category->image->url }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-deep-maroon/10 to-royal-gold/10"></div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-deep-maroon/70 to-transparent"></div>
                                    </div>
                                    <div class="absolute inset-0 p-6 flex flex-col justify-end">
                                        <div class="text-heritage-white">
                                            <h4 class="font-serif text-xl mb-2">{{ $category->name }}</h4>
                                            <div class="flex items-center justify-between">
                                                <span class="text-royal-gold text-sm">{{ $category->products_count }} Products</span>
                                                <span class="text-heritage-white group-hover:text-royal-gold transition-colors">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach

                    <div>
                        <a href="{{ route('products') }}" class="group block relative overflow-hidden shadow-lg bg-heritage-white h-80">
                            <div class="absolute inset-0 heritage-gradient"></div>
                            <div class="absolute inset-0 p-6 flex flex-col justify-center items-center text-center">
                                <div class="text-deep-maroon">
                                    <div class="w-16 h-16 bg-royal-gold rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                        <svg class="w-8 h-8 text-deep-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-serif text-xl mb-2">View All</h4>
                                    <p class="text-deep-maroon/70 text-sm mb-4">Browse complete collection</p>
                                    <span class="text-deep-maroon group-hover:text-royal-gold transition-colors font-medium">
                                        Shop Now →
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

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
