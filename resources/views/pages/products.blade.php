@extends('layouts.app')

@section('title', 'Products - Amsukham by Ram')


@section('content')
    <!-- Hero Section -->
    <section class="relative py-8 md:py-16 bg-gradient-to-br from-soft-cream to-heritage-white">
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
                <!-- <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button class="bg-deep-maroon text-heritage-white px-10 py-4 font-medium hover:bg-royal-gold transition-colors heritage-shadow text-lg">
                        Shop All Collections
                    </button>
                    <button class="border-2 border-deep-maroon text-deep-maroon px-10 py-4 font-medium hover:bg-deep-maroon hover:text-heritage-white transition-colors text-lg">
                        Filter Products
                    </button>
                </div> -->
            </div>
        </div>
    </section>

    <!-- Products Display Section -->
    <section class="py-12 md:py-20 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-4 gap-8">
                <!-- Left Sidebar - Filters -->
                <div class="lg:col-span-1">
                    <div id="filtersSidebar" class="bg-heritage-white p-6 shadow-lg sticky top-24 hidden lg:block">
                        <h3 class="font-serif text-2xl text-deep-maroon mb-6">Filter Products</h3>
                        
                        <!-- Price Range Filter -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-deep-maroon mb-4">Price Range</h4>
                            <div class="space-y-4">
                                <div class="relative h-12">
                                    <div class="absolute w-full h-2 bg-soft-cream rounded-lg top-1/2 transform -translate-y-1/2"></div>
                                    <div id="rangeTrack" class="absolute h-2 bg-royal-gold rounded-lg top-1/2 transform -translate-y-1/2" style="left: 0%; right: 50%;"></div>
                                    <input type="range" id="priceRangeMin" min="0" max="100000" value="0" step="1000"
                                           class="range-slider-thumb absolute w-full h-2 bg-transparent appearance-none cursor-pointer pointer-events-none top-1/2 transform -translate-y-1/2"
                                           style="z-index: 3;">
                                    <input type="range" id="priceRangeMax" min="0" max="100000" value="50000" step="1000"
                                           class="range-slider-thumb absolute w-full h-2 bg-transparent appearance-none cursor-pointer pointer-events-none top-1/2 transform -translate-y-1/2"
                                           style="z-index: 4;">
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
                        
                        <style>
                            .range-slider-thumb {
                                pointer-events: all;
                            }
                            .range-slider-thumb::-webkit-slider-thumb {
                                pointer-events: all;
                                width: 18px;
                                height: 18px;
                                border-radius: 50%;
                                background: #8B4513;
                                cursor: pointer;
                                border: 2px solid #D4AF37;
                                appearance: none;
                                -webkit-appearance: none;
                            }
                            .range-slider-thumb::-moz-range-thumb {
                                pointer-events: all;
                                width: 18px;
                                height: 18px;
                                border-radius: 50%;
                                background: #8B4513;
                                cursor: pointer;
                                border: 2px solid #D4AF37;
                            }
                            .range-slider-thumb::-webkit-slider-runnable-track {
                                height: 2px;
                                background: transparent;
                            }
                            .range-slider-thumb::-moz-range-track {
                                height: 2px;
                                background: transparent;
                            }
                        </style>

                        <!-- Category Filter -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-deep-maroon mb-4">Categories</h4>
                            <div class="space-y-3">
                                
                                @foreach($categories as $category)
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="filter-checkbox category-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="{{ $category->id }}">
                                    <span class="ml-3 text-deep-maroon">{{ $category->name }}</span>
                                    <span class="ml-auto text-deep-maroon/60 text-sm">({{ $category->products_count }})</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Fabric Filter -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-deep-maroon mb-4">Fabric</h4>
                            <div class="space-y-3">
                                @foreach($fabrics as $fabric)
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="filter-checkbox fabric-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="{{ $fabric->id }}">
                                    <span class="ml-3 text-deep-maroon">{{ $fabric->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Color Filter -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-deep-maroon mb-4">Colors</h4>
                            <div class="space-y-3">
                                @foreach($colors as $color)
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="filter-checkbox color-filter w-4 h-4 text-royal-gold bg-heritage-white border-deep-maroon/30 rounded focus:ring-royal-gold" value="{{ $color->id }}">
                                    <div class="w-6 h-6 rounded-full ml-3 mr-2 border-2 border-deep-maroon/20" style="background-color: {{ $color->hex_code ?? '#ccc' }}"></div>
                                    <span class="text-deep-maroon">{{ $color->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Clear Filters Button -->
                        <button type="button" id="clearFilters" class="w-full bg-deep-maroon/10 text-deep-maroon py-3 font-medium hover:bg-deep-maroon hover:text-heritage-white transition-colors text-center">
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
                            <p class="text-deep-maroon/70" id="resultsCount">Showing {{ $products->total() }} products</p>
                        </div>
                        <div class="flex gap-2">
                        <div class="items-center gap-4">
                            <span class="text-deep-maroon/70 font-medium">Sort by:</span>
                            <select id="sortSelect" class="bg-heritage-white border border-deep-maroon/20 text-deep-maroon text-sm px-3 py-2 font-medium focus:outline-none focus:border-royal-gold shadow-lg">
                                <option value="featured">Featured</option>
                                <option value="price-low">Price: Low to High</option>
                                <option value="price-high">Price: High to Low</option>
                                <option value="newest">Newest First</option>
                                <option value="popular">Most Popular</option>
                            </select>
                        </div>
                        <button id="mobileFilterToggle" class="sm:hidden inline-flex items-center gap-2 px-2 py-2 border border-deep-maroon/20 bg-soft-cream text-deep-maroon rounded-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18l-7 8v6l-4 2v-8z" />
                            </svg>
                            <span class="text-sm font-medium">Filters</span>
                        </button>
                    </div>
                    </div>

                    <!-- Product Grid -->
                    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8" id="productsGrid">
                        @forelse($products as $product)
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
                                @if($product->is_featured)
                                    <span class="absolute top-3 right-3 bg-royal-gold text-deep-maroon px-2 py-1 text-xs font-medium">Featured</span>
                                @endif
                            </div>
                            <div class="p-6">
                                <h4 class="font-serif text-lg text-deep-maroon mb-2">{{ $product->name }}</h4>
                                <p class="text-deep-maroon/70 text-sm mb-3 line-clamp-2">{{ $product->short_description ?? $product->category->name ?? '' }}</p>
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
                                    <!-- <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="inline-flex p-1 items-center text-deep-maroon hover:text-royal-gold transition-colors" title="Add to Cart">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        </button>
                                    </form> -->
                                </div>
                                <a href="{{ route('product.show', $product->slug) }}" class="block w-full bg-deep-maroon text-heritage-white py-2 font-medium hover:bg-royal-gold transition-colors text-center">
                                    View Details
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-3 text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-deep-maroon/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <h3 class="font-serif text-2xl text-deep-maroon mb-2">No Products Found</h3>
                            <p class="text-deep-maroon/70 mb-4">Try adjusting your filters or browse all products.</p>
                            <a href="{{ route('products') }}" class="inline-block bg-deep-maroon text-heritage-white px-6 py-2 hover:bg-royal-gold transition-colors">View All Products</a>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-container flex justify-center mt-12">
                        @if($products->hasPages())
                            {{ $products->appends(request()->query())->links() }}
                        @endif
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
        const mobileFilterToggle = document.getElementById('mobileFilterToggle');
        const filtersSidebar = document.getElementById('filtersSidebar');
        const productsGrid = document.getElementById('productsGrid');
        const resultsCount = document.getElementById('resultsCount');
        const sortSelect = document.getElementById('sortSelect');
        let priceDebounce = null;

        function updatePriceRange() {
            let minVal = parseInt(priceRangeMin.value);
            let maxVal = parseInt(priceRangeMax.value);
            
            // Prevent min from exceeding max
            if (minVal > maxVal) {
                priceRangeMin.value = maxVal;
                minVal = maxVal;
            }
            
            // Prevent max from going below min
            if (maxVal < minVal) {
                priceRangeMax.value = minVal;
                maxVal = minVal;
            }
            
            minPriceDisplay.textContent = '₹' + minVal.toLocaleString('en-IN');
            maxPriceDisplay.textContent = '₹' + maxVal.toLocaleString('en-IN');
            
            const minPercent = (minVal / 100000) * 100;
            const maxPercent = (maxVal / 100000) * 100;
            rangeTrack.style.left = minPercent + '%';
            rangeTrack.style.right = (100 - maxPercent) + '%';
        }

        function getCheckedValues(selector) {
            return Array.from(document.querySelectorAll(selector + ':checked')).map(cb => cb.value);
        }

        function fetchProducts() {
            const categories = getCheckedValues('.category-filter');
            const fabrics = getCheckedValues('.fabric-filter');
            const colors = getCheckedValues('.color-filter');
            const minPrice = priceRangeMin.value;
            const maxPrice = priceRangeMax.value;
            const sort = sortSelect.value;

            const params = new URLSearchParams();
            if (categories.length) params.set('categories', categories.join(','));
            if (fabrics.length) params.set('fabrics', fabrics.join(','));
            if (colors.length) params.set('colors', colors.join(','));
            if (parseInt(minPrice) > 0) params.set('min_price', minPrice);
            if (parseInt(maxPrice) < 100000) params.set('max_price', maxPrice);
            if (sort && sort !== 'featured') params.set('sort', sort);

            productsGrid.style.opacity = '0.5';

            fetch('{{ route("products") }}?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                productsGrid.innerHTML = data.html;
                resultsCount.textContent = 'Showing ' + data.total + ' products';
                const paginationContainer = document.querySelector('.pagination-container');
                if (paginationContainer) paginationContainer.innerHTML = data.pagination || '';
                productsGrid.style.opacity = '1';
            })
            .catch(() => {
                productsGrid.style.opacity = '1';
            });
        }

        // Checkbox filters
        document.querySelectorAll('.filter-checkbox').forEach(cb => {
            cb.addEventListener('change', fetchProducts);
        });

        // Sort change
        sortSelect.addEventListener('change', fetchProducts);

        // Price range with debounce
        priceRangeMin.addEventListener('input', function() {
            updatePriceRange();
            clearTimeout(priceDebounce);
            priceDebounce = setTimeout(fetchProducts, 400);
        });
        priceRangeMax.addEventListener('input', function() {
            updatePriceRange();
            clearTimeout(priceDebounce);
            priceDebounce = setTimeout(fetchProducts, 400);
        });

        // Clear filters
        document.getElementById('clearFilters').addEventListener('click', function() {
            document.querySelectorAll('.filter-checkbox').forEach(cb => cb.checked = false);
            priceRangeMin.value = 0;
            priceRangeMax.value = 100000;
            sortSelect.value = 'featured';
            updatePriceRange();
            fetchProducts();
        });

        // Mobile filter toggle
        if (mobileFilterToggle && filtersSidebar) {
            mobileFilterToggle.addEventListener('click', function() {
                filtersSidebar.classList.toggle('hidden');
                if (!filtersSidebar.classList.contains('hidden')) {
                    filtersSidebar.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        }
    });
</script>
@endpush
