@extends('layouts.app')

@section('title', 'Products - Amsukham by Ram')


@section('content')
    <!-- Hero Section -->
    <section class="relative py-32 bg-gradient-to-br from-soft-cream to-heritage-white">
        <div class="brand-pattern-header absolute inset-0 bg-repeat opacity-10 pointer-events-none"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="font-serif text-5xl md:text-6xl lg:text-7xl text-deep-maroon mb-6 leading-tight decorative-title">
                    Heritage Collection
                </h1>
                <div class="w-24 h-1 gold-accent mb-8 mx-auto"></div>
                <p class="text-xl md:text-2xl text-deep-maroon/80 mb-8 leading-relaxed max-w-3xl mx-auto">
                    Discover our exquisite range of handcrafted sarees, where tradition meets contemporary elegance. Each piece is a testament to generations of artisanal mastery and timeless beauty.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button class="bg-deep-maroon text-heritage-white px-10 py-4 font-medium hover:bg-royal-gold transition-colors heritage-shadow text-lg">
                        Shop All Collections
                    </button>
                    <button class="border-2 border-deep-maroon text-deep-maroon px-10 py-4 font-medium hover:bg-deep-maroon hover:text-heritage-white transition-colors text-lg">
                        Filter Products
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Display Section -->
    <section class="py-20 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-4 gap-8">
                <!-- Left Sidebar - Filters -->
                <div class="lg:col-span-1">
                    <div class="bg-heritage-white p-6 shadow-lg sticky top-24">
                        <h3 class="font-serif text-2xl text-deep-maroon mb-6">Filter Products</h3>
                        
                        <!-- Price Range Filter -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-deep-maroon mb-4">Price Range</h4>
                            <div class="space-y-4">
                                <div class="relative">
                                    <div class="relative h-6 bg-soft-cream rounded-lg">
                                        <div id="rangeTrack" class="absolute h-2 bg-royal-gold rounded-lg top-2" style="left: 0%; right: 50%;"></div>
                                        <input type="range" id="priceRangeMin" min="0" max="100000" value="0" step="1000"
                                               class="absolute w-full h-6 bg-transparent appearance-none cursor-pointer z-10">
                                        <input type="range" id="priceRangeMax" min="0" max="100000" value="50000" step="1000"
                                               class="absolute w-full h-6 bg-transparent appearance-none cursor-pointer z-20">
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <div class="text-sm">
                                        <span class="text-deep-maroon/70">Min: </span>
                                        <span id="minPriceDisplay" class="font-semibold text-deep-maroon">₹0</span>
                                    </div>
                                    <div class="text-sm">
                                        <span class="text-deep-maroon/70">Max: </span>
                                        <span id="maxPriceDisplay" class="font-semibold text-deep-maroon">₹50,000</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-deep-maroon mb-4">Categories</h4>
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="category-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="silk" checked>
                                    <span class="ml-3 text-deep-maroon">Silk Sarees</span>
                                    <span class="ml-auto text-deep-maroon/60 text-sm">(24)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="category-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="cotton" checked>
                                    <span class="ml-3 text-deep-maroon">Cotton Sarees</span>
                                    <span class="ml-auto text-deep-maroon/60 text-sm">(18)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="category-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="bridal" checked>
                                    <span class="ml-3 text-deep-maroon">Bridal Collection</span>
                                    <span class="ml-auto text-deep-maroon/60 text-sm">(12)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="category-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="designer">
                                    <span class="ml-3 text-deep-maroon">Designer Sarees</span>
                                    <span class="ml-auto text-deep-maroon/60 text-sm">(8)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="category-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="handloom">
                                    <span class="ml-3 text-deep-maroon">Handloom Sarees</span>
                                    <span class="ml-auto text-deep-maroon/60 text-sm">(15)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Fabric Filter -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-deep-maroon mb-4">Fabric</h4>
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="fabric-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="mysore-silk">
                                    <span class="ml-3 text-deep-maroon">Mysore Silk</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="fabric-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="kanchipuram">
                                    <span class="ml-3 text-deep-maroon">Kanchipuram</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="fabric-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="banarasi">
                                    <span class="ml-3 text-deep-maroon">Banarasi</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="fabric-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="chanderi">
                                    <span class="ml-3 text-deep-maroon">Chanderi</span>
                                </label>
                            </div>
                        </div>

                        <!-- Color Filter -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-deep-maroon mb-4">Colors</h4>
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="color-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="maroon">
                                    <div class="w-6 h-6 rounded-full ml-3 mr-2 border-2 border-deep-maroon/20" style="background-color: #87000D"></div>
                                    <span class="text-deep-maroon">Maroon</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="color-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="gold">
                                    <div class="w-6 h-6 rounded-full ml-3 mr-2 border-2 border-deep-maroon/20" style="background-color: #D79B2F"></div>
                                    <span class="text-deep-maroon">Gold</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="color-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="green">
                                    <div class="w-6 h-6 rounded-full ml-3 mr-2 border-2 border-deep-maroon/20" style="background-color: #006400"></div>
                                    <span class="text-deep-maroon">Green</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="color-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="purple">
                                    <div class="w-6 h-6 rounded-full ml-3 mr-2 border-2 border-deep-maroon/20" style="background-color: #800080"></div>
                                    <span class="text-deep-maroon">Purple</span>
                                </label>
                            </div>
                        </div>

                        <!-- Clear Filters Button -->
                        <button id="clearFilters" class="w-full bg-deep-maroon/10 text-deep-maroon py-3 font-medium hover:bg-deep-maroon hover:text-heritage-white transition-colors">
                            Clear All Filters
                        </button>
                    </div>
                </div>

                <!-- Right Side - Product Grid -->
                <div class="lg:col-span-3">
                    <!-- Sort and Results Header -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                        <div>
                            <h2 class="font-serif text-3xl text-deep-maroon mb-2">Our Collection</h2>
                            <p class="text-deep-maroon/70" id="resultsCount">Showing 12 products</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-deep-maroon/70 font-medium">Sort by:</span>
                            <select id="sortSelect" class="bg-heritage-white border border-deep-maroon/20 text-deep-maroon px-4 py-2 font-medium focus:outline-none focus:border-royal-gold shadow-lg">
                                <option value="featured">Featured</option>
                                <option value="price-low">Price: Low to High</option>
                                <option value="price-high">Price: High to Low</option>
                                <option value="newest">Newest First</option>
                                <option value="popular">Most Popular</option>
                            </select>
                        </div>
                    </div>

                    <!-- Product Grid -->
                    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8" id="productsGrid">
                        <!-- Product 1 -->
                        <div class="bg-heritage-white overflow-hidden shadow-lg hover:-translate-y-1 transition-all duration-300">
                            <div class="h-64 relative">
                                <img src="{{ asset('images/best-seller-01.jpg') }}" alt="Maharani Silk Saree" class="w-full h-full object-cover">
                            </div>
                            <div class="p-6">
                                <h4 class="font-serif text-lg text-deep-maroon mb-2">Maharani Silk</h4>
                                <p class="text-deep-maroon/70 text-sm mb-3">Pure silk with gold zari work</p>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-serif text-xl text-royal-gold">₹25,000</span>
                                    <button class="text-deep-maroon hover:text-royal-gold transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <a href="{{ route('product.show', 1) }}" class="block w-full bg-deep-maroon text-heritage-white py-2 font-medium hover:bg-royal-gold transition-colors text-center">
                                    View Details
                                </a>
                            </div>
                        </div>

                        <!-- Product 2 -->
                        <div class="bg-heritage-white overflow-hidden shadow-lg hover:-translate-y-1 transition-all duration-300">
                            <div class="h-64 relative">
                                <img src="{{ asset('images/best-seller-02.jpg') }}" alt="Heritage Banarasi Saree" class="w-full h-full object-cover">
                            </div>
                            <div class="p-6">
                                <h4 class="font-serif text-lg text-deep-maroon mb-2">Heritage Banarasi</h4>
                                <p class="text-deep-maroon/70 text-sm mb-3">Traditional Banarasi weave</p>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-serif text-xl text-royal-gold">₹18,500</span>
                                    <button class="text-deep-maroon hover:text-royal-gold transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <a href="{{ route('product.show', 2) }}" class="block w-full bg-deep-maroon text-heritage-white py-2 font-medium hover:bg-royal-gold transition-colors text-center">
                                    View Details
                                </a>
                            </div>
                        </div>

                        <!-- Product 3 -->
                        <div class="bg-heritage-white overflow-hidden shadow-lg hover:-translate-y-1 transition-all duration-300">
                            <div class="h-64 relative">
                                <img src="{{ asset('images/best-seller-03.jpg') }}" alt="Royal Kanjivaram Saree" class="w-full h-full object-cover">
                            </div>
                            <div class="p-6">
                                <h4 class="font-serif text-lg text-deep-maroon mb-2">Royal Kanjivaram</h4>
                                <p class="text-deep-maroon/70 text-sm mb-3">Handwoven Kanjivaram silk</p>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-serif text-xl text-royal-gold">₹32,000</span>
                                    <button class="text-deep-maroon hover:text-royal-gold transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <a href="{{ route('product.show', 3) }}" class="block w-full bg-deep-maroon text-heritage-white py-2 font-medium hover:bg-royal-gold transition-colors text-center">
                                    View Details
                                </a>
                            </div>
                        </div>

                        <!-- Product 4 -->
                        <div class="bg-heritage-white overflow-hidden shadow-lg hover:-translate-y-1 transition-all duration-300">
                            <div class="h-64 relative">
                                <img src="{{ asset('images/best-seller-04.jpg') }}" alt="Bridal Lehenga Collection" class="w-full h-full object-cover">
                            </div>
                            <div class="p-6">
                                <h4 class="font-serif text-lg text-deep-maroon mb-2">Bridal Lehenga</h4>
                                <p class="text-deep-maroon/70 text-sm mb-3">Exquisite bridal collection</p>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-serif text-xl text-royal-gold">₹45,000</span>
                                    <button class="text-deep-maroon hover:text-royal-gold transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <a href="{{ route('product.show', 4) }}" class="block w-full bg-deep-maroon text-heritage-white py-2 font-medium hover:bg-royal-gold transition-colors text-center">
                                    View Details
                                </a>
                            </div>
                        </div>

                        <!-- Product 5 -->
                        <div class="bg-heritage-white overflow-hidden shadow-lg hover:-translate-y-1 transition-all duration-300">
                            <div class="h-64 relative">
                                <img src="{{ asset('images/latest-collections.jpg') }}" alt="Mysore Silk" class="w-full h-full object-cover">
                            </div>
                            <div class="p-6">
                                <h4 class="font-serif text-lg text-deep-maroon mb-2">Mysore Silk</h4>
                                <p class="text-deep-maroon/70 text-sm mb-3">Premium Mysore silk weave</p>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-serif text-xl text-royal-gold">₹22,000</span>
                                    <button class="text-deep-maroon hover:text-royal-gold transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <a href="{{ route('product.show', 5) }}" class="block w-full bg-deep-maroon text-heritage-white py-2 font-medium hover:bg-royal-gold transition-colors text-center">
                                    View Details
                                </a>
                            </div>
                        </div>

                        <!-- Product 6 -->
                        <div class="bg-heritage-white overflow-hidden shadow-lg hover:-translate-y-1 transition-all duration-300">
                            <div class="h-64 relative">
                                <img src="{{ asset('images/latest-collections-02.jpg') }}" alt="Chanderi Cotton" class="w-full h-full object-cover">
                            </div>
                            <div class="p-6">
                                <h4 class="font-serif text-lg text-deep-maroon mb-2">Chanderi Cotton</h4>
                                <p class="text-deep-maroon/70 text-sm mb-3">Lightweight Chanderi fabric</p>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-serif text-xl text-royal-gold">₹15,500</span>
                                    <button class="text-deep-maroon hover:text-royal-gold transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <a href="{{ route('product.show', 6) }}" class="block w-full bg-deep-maroon text-heritage-white py-2 font-medium hover:bg-royal-gold transition-colors text-center">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center mt-12">
                        <nav class="flex items-center space-x-2">
                            <button class="px-4 py-2 border border-deep-maroon/20 text-deep-maroon hover:bg-deep-maroon hover:text-heritage-white transition-colors">
                                Previous
                            </button>
                            <button class="px-4 py-2 bg-deep-maroon text-heritage-white">1</button>
                            <button class="px-4 py-2 border border-deep-maroon/20 text-deep-maroon hover:bg-deep-maroon hover:text-heritage-white transition-colors">2</button>
                            <button class="px-4 py-2 border border-deep-maroon/20 text-deep-maroon hover:bg-deep-maroon hover:text-heritage-white transition-colors">3</button>
                            <button class="px-4 py-2 border border-deep-maroon/20 text-deep-maroon hover:bg-deep-maroon hover:text-heritage-white transition-colors">
                                Next
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const priceRangeMin = document.getElementById('priceRangeMin');
        const priceRangeMax = document.getElementById('priceRangeMax');
        const minPriceDisplay = document.getElementById('minPriceDisplay');
        const maxPriceDisplay = document.getElementById('maxPriceDisplay');
        const rangeTrack = document.getElementById('rangeTrack');

        function updatePriceRange() {
            const minVal = parseInt(priceRangeMin.value);
            const maxVal = parseInt(priceRangeMax.value);
            
            if (minVal > maxVal) {
                priceRangeMin.value = maxVal;
            }
            
            minPriceDisplay.textContent = '₹' + parseInt(priceRangeMin.value).toLocaleString('en-IN');
            maxPriceDisplay.textContent = '₹' + parseInt(priceRangeMax.value).toLocaleString('en-IN');
            
            const minPercent = (priceRangeMin.value / 100000) * 100;
            const maxPercent = (priceRangeMax.value / 100000) * 100;
            rangeTrack.style.left = minPercent + '%';
            rangeTrack.style.right = (100 - maxPercent) + '%';
        }

        priceRangeMin.addEventListener('input', updatePriceRange);
        priceRangeMax.addEventListener('input', updatePriceRange);

        document.getElementById('clearFilters').addEventListener('click', function() {
            document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            priceRangeMin.value = 0;
            priceRangeMax.value = 50000;
            updatePriceRange();
        });
    });
</script>
@endpush
