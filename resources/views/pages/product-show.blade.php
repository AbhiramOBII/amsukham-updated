@extends('layouts.app')

@section('title', $product->meta_title ?? $product->name . ' - Amsukham by Ram')

@section('content')
    <!-- Product Detail Section -->
    <section class="py-20 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div class="aspect-square bg-soft-cream overflow-hidden shadow-lg">
                        @php
                            $firstColor = $product->productColors->first();
                            $firstColorImage = $firstColor ? $firstColor->images->first() : null;
                            $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                            $defaultMainUrl = $firstColorImage && $firstColorImage->media ? $firstColorImage->media->url : ($primaryImage && $primaryImage->media ? $primaryImage->media->url : null);
                        @endphp
                        @if($defaultMainUrl)
                            <img id="mainProductImage" src="{{ $defaultMainUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div id="mainProductImagePlaceholder" class="w-full h-full bg-gradient-to-br from-deep-maroon/10 to-royal-gold/10 flex items-center justify-center">
                                <svg class="w-24 h-24 text-deep-maroon/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <img id="mainProductImage" src="" alt="{{ $product->name }}" class="w-full h-full object-cover hidden">
                        @endif
                    </div>
                    
                    <!-- Thumbnail Images -->
                    <div id="thumbnailContainer" class="grid grid-cols-4 gap-4">
                        @if($firstColor && $firstColor->images->count() > 0)
                            @foreach($firstColor->images as $index => $cImg)
                            <div class="thumb-item aspect-square bg-soft-cream overflow-hidden shadow-lg cursor-pointer border-2 {{ $index === 0 ? 'border-royal-gold hidden' : 'border-transparent' }} hover:border-deep-maroon transition-colors" onclick="changeMainImage('{{ $cImg->media->url }}', this)">
                                <img src="{{ $cImg->media->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </div>
                            @endforeach
                        @elseif($primaryImage && $primaryImage->media)
                            <div class="thumb-item aspect-square bg-soft-cream overflow-hidden shadow-lg cursor-pointer border-2 border-royal-gold hidden hover:border-deep-maroon transition-colors" onclick="changeMainImage('{{ $primaryImage->media->url }}', this)">
                                <img src="{{ $primaryImage->media->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                    </div>

                    <!-- Color Variants -->
                    @if($product->productColors->count() > 0)
                    <div class="mt-2">
                        <h4 class="font-medium text-deep-maroon mb-3">Available Colors</h4>
                        <div class="flex flex-wrap gap-3" id="colorSwatches">
                            @foreach($product->productColors as $pcIndex => $productColor)
                            <div class="text-center cursor-pointer group color-swatch {{ $pcIndex === 0 ? 'active' : '' }}" data-color-id="{{ $productColor->id }}" onclick="switchColor({{ $productColor->id }})">
                                <div class="w-10 h-10 rounded-full border-2 {{ $pcIndex === 0 ? 'border-royal-gold ring-2 ring-royal-gold/50' : 'border-deep-maroon/20' }} group-hover:border-royal-gold transition-colors" style="background-color: {{ $productColor->color->hex_code ?? '#ccc' }}"></div>
                                <span class="text-xs text-deep-maroon/70 mt-1 block">{{ $productColor->color->name }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <div>
                        <h1 class="font-serif text-4xl text-deep-maroon mb-4">{{ $product->name }}</h1>
                        @if($product->short_description)
                        <p class="text-deep-maroon/70 text-lg mb-6">{{ $product->short_description }}</p>
                        @endif
                        <div class="flex items-center space-x-4 mb-6">
                            <span id="displayPrice" class="font-serif text-3xl text-royal-gold">₹{{ number_format($product->discounted_price) }}</span>
                            @if($product->discount > 0)
                            <span id="displayOriginalPrice" class="text-deep-maroon/50 line-through text-xl">₹{{ number_format($product->price) }}</span>
                            <span class="bg-royal-gold text-deep-maroon px-3 py-1 text-sm font-medium">{{ number_format($product->discount) }}% OFF</span>
                            @endif
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            @if($product->fabric)
                            <div>
                                <span class="text-deep-maroon/70 font-medium">Fabric:</span>
                                <span class="text-deep-maroon ml-2">{{ $product->fabric->name }}</span>
                            </div>
                            @endif
                            @if($product->work)
                            <div>
                                <span class="text-deep-maroon/70 font-medium">Work:</span>
                                <span class="text-deep-maroon ml-2">{{ $product->work->name }}</span>
                            </div>
                            @endif
                            @if($product->length)
                            <div>
                                <span class="text-deep-maroon/70 font-medium">Length:</span>
                                <span class="text-deep-maroon ml-2">{{ $product->length }}</span>
                            </div>
                            @endif
                            @if($product->with_blouse && $product->blouse_length)
                            <div>
                                <span class="text-deep-maroon/70 font-medium">Blouse:</span>
                                <span class="text-deep-maroon ml-2">{{ $product->blouse_length }}</span>
                            </div>
                            @endif
                            @if($product->category)
                            <div>
                                <span class="text-deep-maroon/70 font-medium">Category:</span>
                                <span class="text-deep-maroon ml-2">{{ $product->category->name }}</span>
                            </div>
                            @endif
                            <div>
                                <span class="text-deep-maroon/70 font-medium">Stock:</span>
                                <span class="text-deep-maroon ml-2">{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-4">
                        <!-- Success/Error Message -->
                        <div id="cartMessage" class="hidden px-4 py-3 rounded-lg text-sm font-medium"></div>

                        <input type="hidden" id="product_id" value="{{ $product->id }}">
                        <input type="hidden" id="product_color_id" value="{{ $firstColor ? $firstColor->id : '' }}">
                        <div class="flex flex-wrap sm:flex-nowrap items-center gap-4">
                            <!-- Quantity Selector -->
                            <div class="flex items-center border border-deep-maroon/20 rounded-full shrink-0">
                                <button type="button" id="decreaseQty" class="w-10 h-10 flex items-center justify-center text-deep-maroon hover:bg-soft-cream transition-colors rounded-l-full">
                                    <span class="text-lg font-medium">−</span>
                                </button>
                                <input type="number" id="quantity" value="1" min="1" max="10" class="px-2 py-2 text-deep-maroon font-medium w-12 text-center border-0 focus:ring-0">
                                <button type="button" id="increaseQty" class="w-10 h-10 flex items-center justify-center text-deep-maroon hover:bg-soft-cream transition-colors rounded-r-full">
                                    <span class="text-lg font-medium">+</span>
                                </button>
                            </div>

                            <div class="flex-1 flex items-center gap-3 w-full sm:w-auto mt-2 sm:mt-0">
                                <!-- Add to Cart Button -->
                                <button type="button" id="addToCartBtn" onclick="addToCart()" class="flex-1 bg-deep-maroon text-heritage-white py-2.5 px-4 text-sm font-medium hover:bg-royal-gold transition-colors rounded-full shadow-lg whitespace-nowrap {{ $product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                    {{ $product->stock > 0 ? 'ADD TO CART' : 'OUT OF STOCK' }}
                                </button>

                                <!-- Buy Now Button -->
                                @if($product->stock > 0)
                                <button type="button" id="buyNowBtn" onclick="buyNow()" class="flex-1 bg-royal-gold text-deep-maroon py-2.5 px-4 text-sm font-medium hover:bg-deep-maroon hover:text-heritage-white transition-colors rounded-full shadow-lg whitespace-nowrap">
                                    BUY NOW
                                </button>
                                @endif
                            </div>
                        </div>

                        <!-- Secondary Actions -->
                        <!-- <div class="flex items-center space-x-6 text-deep-maroon">
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
                        </div> -->
                    </div>

                    <!-- Product Description -->
                    @if($product->description)
                    <div class="border-t border-deep-maroon/20 pt-6 mt-6">
                        <h3 class="font-serif text-xl text-deep-maroon mb-4">Product Description</h3>
                        <div class="text-deep-maroon/80 leading-relaxed prose max-w-none">
                            {!! $product->description !!}
                        </div>
                    </div>
                    @endif

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
    @if($product->faqs->count() > 0)
    <section class="py-20 bg-soft-cream">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="font-serif text-4xl text-deep-maroon mb-4 decorative-title">Frequently Asked Questions</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mb-6 mx-auto"></div>
                    <p class="text-deep-maroon/70 text-lg">Everything you need to know about this product</p>
                </div>

                <div class="space-y-4">
                    @foreach($product->faqs as $index => $faq)
                    <div class="bg-heritage-white shadow-lg overflow-hidden">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-soft-cream/50 transition-colors" data-target="faq{{ $index }}">
                            <span class="font-medium text-deep-maroon">{{ $faq->question }}</span>
                            <svg class="w-5 h-5 text-deep-maroon transform transition-transform duration-200 faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="faq{{ $index }}" class="faq-content hidden px-6 pb-4">
                            <p class="text-deep-maroon/80 leading-relaxed">{{ $faq->answer }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Related Products Section -->
    @if($relatedProducts->count() > 0)
    <section class="py-20 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="font-serif text-4xl text-deep-maroon mb-4 decorative-title">You May Also Like</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mb-6 mx-auto"></div>
                <p class="text-deep-maroon/70 text-lg">Discover more from our heritage collection</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($relatedProducts as $relatedProduct)
                <div class="bg-heritage-white overflow-hidden shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="h-64 relative">
                        @if($relatedProduct->primaryImage && $relatedProduct->primaryImage->media)
                            <img src="{{ $relatedProduct->primaryImage->media->url }}" alt="{{ $relatedProduct->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-deep-maroon/10 to-royal-gold/10 flex items-center justify-center">
                                <svg class="w-12 h-12 text-deep-maroon/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        @if($relatedProduct->discount > 0)
                            <span class="absolute top-3 left-3 bg-red-500 text-white px-2 py-1 text-xs font-medium">{{ number_format($relatedProduct->discount) }}% OFF</span>
                        @endif
                    </div>
                    <div class="p-6">
                        <h4 class="font-serif text-lg text-deep-maroon mb-2">{{ $relatedProduct->name }}</h4>
                        <p class="text-deep-maroon/70 text-sm mb-3 line-clamp-1">{{ $relatedProduct->short_description ?? '' }}</p>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                @if($relatedProduct->discount > 0)
                                    <span class="text-deep-maroon/50 line-through text-sm">₹{{ number_format($relatedProduct->price) }}</span>
                                @endif
                                <span class="font-serif text-xl text-royal-gold">₹{{ number_format($relatedProduct->discounted_price) }}</span>
                            </div>
                        </div>
                        <a href="{{ route('product.show', $relatedProduct->slug) }}" class="block w-full bg-deep-maroon text-heritage-white py-2 font-medium hover:bg-royal-gold transition-colors text-center">
                            View Details
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection

@push('scripts')
<script>
    const basePrice = {{ $product->discounted_price }};
    const originalPrice = {{ $product->price }};
    const discount = {{ $product->discount ?? 0 }};
    const colorData = @json($colorData);

    function formatPrice(num) {
        return '₹' + Math.round(num).toLocaleString('en-IN');
    }

    function updatePriceDisplay(adjustment) {
        const currentPrice = basePrice + adjustment;
        const priceEl = document.getElementById('displayPrice');
        if (priceEl) priceEl.textContent = formatPrice(currentPrice);
    }

    function changeMainImage(src, element) {
        const mainImg = document.getElementById('mainProductImage');
        const placeholder = document.getElementById('mainProductImagePlaceholder');
        
        // Get the previous main image src before changing it
        const previousMainSrc = mainImg.src;
        
        // Update main image
        mainImg.src = src;
        mainImg.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');

        // Show all thumbnails first
        document.querySelectorAll('.thumb-item').forEach(thumb => {
            thumb.classList.remove('hidden');
            thumb.classList.remove('border-royal-gold');
            thumb.classList.add('border-transparent');
        });
        
        // Hide the clicked thumbnail (it's now the main image)
        element.classList.add('hidden');
    }

    function switchColor(colorId) {
        const color = colorData.find(c => c.id === colorId);
        if (!color) return;

        // Set selected color
        document.getElementById('product_color_id').value = colorId;

        // Update price
        updatePriceDisplay(color.price_adjustment);

        // Update swatch borders
        document.querySelectorAll('.color-swatch').forEach(s => {
            const circle = s.querySelector('div');
            circle.classList.remove('border-royal-gold', 'ring-2', 'ring-royal-gold/50');
            circle.classList.add('border-deep-maroon/20');
        });
        const activeSwatch = document.querySelector(`.color-swatch[data-color-id="${colorId}"]`);
        if (activeSwatch) {
            const circle = activeSwatch.querySelector('div');
            circle.classList.remove('border-deep-maroon/20');
            circle.classList.add('border-royal-gold', 'ring-2', 'ring-royal-gold/50');
        }

        // Update thumbnails and main image
        const thumbContainer = document.getElementById('thumbnailContainer');
        if (color.images.length > 0) {
            const mainImg = document.getElementById('mainProductImage');
            const placeholder = document.getElementById('mainProductImagePlaceholder');
            mainImg.src = color.images[0].url;
            mainImg.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');

            thumbContainer.innerHTML = color.images.map((img, i) => `
                <div class="thumb-item aspect-square bg-soft-cream overflow-hidden shadow-lg cursor-pointer border-2 ${i === 0 ? 'border-royal-gold hidden' : 'border-transparent'} hover:border-deep-maroon transition-colors" onclick="changeMainImage('${img.url}', this)">
                    <img src="${img.url}" alt="" class="w-full h-full object-cover">
                </div>
            `).join('');
        }
    }

    function showCartMessage(message, isSuccess) {
        const msgEl = document.getElementById('cartMessage');
        msgEl.textContent = message;
        msgEl.className = 'px-4 py-3 rounded-lg text-sm font-medium ' +
            (isSuccess ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300');
        msgEl.classList.remove('hidden');
        setTimeout(() => msgEl.classList.add('hidden'), 4000);
    }

    function updateCartCountBadges(count) {
        document.querySelectorAll('.cart-count-badge').forEach(badge => {
            badge.textContent = count;
        });
    }

    function addToCart() {
        const productId = document.getElementById('product_id').value;
        const colorId = document.getElementById('product_color_id').value;
        const quantity = parseInt(document.getElementById('quantity').value) || 1;
        const btn = document.getElementById('addToCartBtn');
        const originalText = btn.textContent;
        btn.disabled = true;
        btn.textContent = 'ADDING...';

        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                product_id: productId,
                product_color_id: colorId || null,
                quantity: quantity,
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showCartMessage(data.message, true);
                updateCartCountBadges(data.cartCount);
            } else {
                showCartMessage(data.message || 'Failed to add to cart.', false);
            }
        })
        .catch(() => showCartMessage('Something went wrong. Please try again.', false))
        .finally(() => {
            btn.disabled = false;
            btn.textContent = originalText;
        });
    }

    function buyNow() {
        const productId = document.getElementById('product_id').value;
        const colorId = document.getElementById('product_color_id').value;
        const quantity = parseInt(document.getElementById('quantity').value) || 1;
        const btn = document.getElementById('buyNowBtn');
        btn.disabled = true;
        btn.textContent = 'PROCESSING...';

        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                product_id: productId,
                product_color_id: colorId || null,
                quantity: quantity,
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                updateCartCountBadges(data.cartCount);
                window.location.href = '{{ route("checkout.index") }}';
            } else {
                showCartMessage(data.message || 'Failed to add to cart.', false);
                btn.disabled = false;
                btn.textContent = 'BUY NOW';
            }
        })
        .catch(() => {
            showCartMessage('Something went wrong. Please try again.', false);
            btn.disabled = false;
            btn.textContent = 'BUY NOW';
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize price with first color's adjustment if colors exist
        if (colorData && colorData.length > 0) {
            const firstColor = colorData[0];
            updatePriceDisplay(firstColor.price_adjustment);
            document.getElementById('product_color_id').value = firstColor.id;
        }

        // Quantity selector
        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decreaseQty');
        const increaseBtn = document.getElementById('increaseQty');

        if (decreaseBtn) {
            decreaseBtn.addEventListener('click', function() {
                let val = parseInt(quantityInput.value) || 1;
                if (val > 1) quantityInput.value = val - 1;
            });
        }

        if (increaseBtn) {
            increaseBtn.addEventListener('click', function() {
                let val = parseInt(quantityInput.value) || 1;
                if (val < 10) quantityInput.value = val + 1;
            });
        }

        // Load initial cart count
        fetch('{{ route("cart.count") }}', { headers: { 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(data => updateCartCountBadges(data.count))
            .catch(() => {});

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
