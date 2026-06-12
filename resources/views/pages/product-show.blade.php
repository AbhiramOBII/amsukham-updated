@extends('layouts.app')

@section('title', $product->meta_title ?? $product->name . ' - Amsukham by Ram')

@section('content')
    <!-- Product Detail Section -->
    <section class="py-20 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div>
                    @php
                        $firstColor = $product->productColors->first();
                        
                        // Build all images: thumbnail first, then gallery
                        $allImages = collect();
                        if ($product->thumbnail) {
                            $allImages->push(['url' => $product->thumbnail->url, 'alt' => $product->name]);
                        }
                        foreach ($product->images->sortBy('sort_order') as $img) {
                            if ($img->media) {
                                $allImages->push(['url' => $img->media->url, 'alt' => $product->name]);
                            }
                        }
                        
                        // Use color images if first color has them, else gallery
                        if ($firstColor && $firstColor->images->count() > 0) {
                            $displayImages = $firstColor->images->map(fn($ci) => ['url' => $ci->media->url, 'alt' => $product->name]);
                        } else {
                            $displayImages = $allImages;
                        }
                        
                        $defaultMainUrl = $displayImages->first()['url'] ?? null;
                    @endphp

                    <!-- Main Image -->
                    <div class="aspect-[4/5] bg-soft-cream overflow-hidden rounded-sm shadow-lg mb-4">
                        @if($defaultMainUrl)
                            <img id="mainProductImage" src="{{ $defaultMainUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div id="mainProductImagePlaceholder" class="w-full h-full bg-gradient-to-br from-deep-maroon/10 to-royal-gold/10 flex items-center justify-center">
                                <svg class="w-24 h-24 text-deep-maroon/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <img id="mainProductImage" src="" alt="{{ $product->name }}" class="w-full h-full object-cover hidden">
                        @endif
                    </div>
                    
                    <!-- Thumbnails -->
                    @if($displayImages->count() > 1)
                    <div id="thumbnailContainer" class="flex gap-2 overflow-x-auto pb-2">
                        @foreach($displayImages as $index => $imgData)
                        <div class="thumb-item w-16 h-16 flex-shrink-0 bg-soft-cream overflow-hidden rounded cursor-pointer border-2 {{ $index === 0 ? 'border-royal-gold opacity-100' : 'border-transparent opacity-70' }} hover:opacity-100 hover:border-deep-maroon/50 transition-all" onclick="changeMainImage('{{ $imgData['url'] }}', this)">
                            <img src="{{ $imgData['url'] }}" alt="{{ $imgData['alt'] }}" class="w-full h-full object-cover">
                        </div>
                        @endforeach
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
                            @php
                                $firstColor = $product->productColors->first();
                                $initialPriceAdj = $firstColor ? $firstColor->price_adjustment : 0;
                                $initialTotalOrig = $product->price + $initialPriceAdj;
                                // Apply discount to total price, not base price
                                $initialTotalDisc = $product->discount > 0 
                                    ? $initialTotalOrig - ($initialTotalOrig * $product->discount / 100)
                                    : $initialTotalOrig;
                            @endphp
                            <span id="displayPrice" class="font-serif text-3xl text-royal-gold">₹{{ number_format($initialTotalDisc) }}</span>
                            @if($product->discount > 0)
                            <span id="displayOriginalPrice" class="text-deep-maroon/50 line-through text-xl">₹{{ number_format($initialTotalOrig) }}</span>
                            <span id="displayDiscountBadge" class="bg-royal-gold text-deep-maroon px-3 py-1 text-sm font-medium">{{ number_format($product->discount) }}% OFF</span>
                            @else
                            <span id="displayOriginalPrice" class="text-deep-maroon/50 line-through text-xl hidden"></span>
                            <span id="displayDiscountBadge" class="bg-royal-gold text-deep-maroon px-3 py-1 text-sm font-medium hidden"></span>
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
                            <div id="stockDisplay">
                                <span class="text-deep-maroon/70 font-medium">Availability:</span>
                                @php
                                    $initialStock = $firstColor ? $firstColor->stock : $product->stock;
                                @endphp
                                @if($product->is_preorder)
                                    <span class="inline-flex items-center gap-1 ml-2 px-2 py-0.5 bg-royal-gold/20 text-deep-maroon text-xs font-semibold rounded-full">Pre-Booking</span>
                                @elseif($initialStock > 10)
                                    <span class="text-green-600 ml-2 font-medium">In Stock</span>
                                @elseif($initialStock > 0)
                                    <span class="text-orange-500 ml-2 font-medium">Only {{ $initialStock }} left</span>
                                @else
                                    <span class="text-red-600 ml-2 font-medium">Out of Stock</span>
                                @endif
                            </div>
                        </div>

                        <!-- Color Variants -->
                        @if($product->productColors->count() > 0)
                        <div class="col-span-2 mt-2">
                            <span class="text-deep-maroon/70 font-medium">Colors:</span>
                            <div class="flex flex-wrap gap-3 mt-2" id="colorSwatches">
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

                    <!-- Actions -->
                    <div class="space-y-4">
                        <!-- Success/Error Message -->
                        <div id="cartMessage" class="hidden px-4 py-3 rounded-lg text-sm font-medium"></div>

                        <input type="hidden" id="product_id" value="{{ $product->id }}">
                        <input type="hidden" id="product_color_id" value="{{ $firstColor ? $firstColor->id : '' }}">
                        <input type="hidden" id="available_stock" value="{{ $initialStock }}">
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
                                @php
                                    $addToCartDisabled = !$product->is_preorder && $initialStock <= 0;
                                @endphp
                                <button type="button" id="addToCartBtn" onclick="addToCart()" class="flex-1 bg-deep-maroon text-heritage-white py-2.5 px-4 text-sm font-medium hover:bg-royal-gold transition-colors rounded-full shadow-lg whitespace-nowrap {{ $addToCartDisabled ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $addToCartDisabled ? 'disabled' : '' }}>
                                    @if($product->is_preorder)
                                        PRE-BOOK
                                    @elseif($initialStock > 0)
                                        ADD TO CART
                                    @else
                                        OUT OF STOCK
                                    @endif
                                </button>

                                <!-- Buy Now Button -->
                                <button type="button" id="buyNowBtn" onclick="buyNow()" class="flex-1 bg-royal-gold text-deep-maroon py-2.5 px-4 text-sm font-medium hover:bg-deep-maroon hover:text-heritage-white transition-colors rounded-full shadow-lg whitespace-nowrap {{ $addToCartDisabled ? 'hidden' : '' }}">
                                    BUY NOW
                                </button>
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
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['contact_phone'] ?? '+919591579771') }}" class="text-deep-maroon/70 text-sm hover:text-deep-maroon">{{ $siteSettings['contact_phone'] ?? '+91 95915 79771' }}</a>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="font-medium text-deep-maroon text-sm">Email Us</span>
                                <a href="mailto:{{ $siteSettings['contact_email'] ?? 'info@amsukham.com' }}" class="text-deep-maroon/70 text-sm hover:text-deep-maroon">{{ $siteSettings['contact_email'] ?? 'info@amsukham.com' }}</a>
                            </div>
                        </div>

                        <!-- Service Features -->
                        <div class="grid grid-cols-2 gap-4 mt-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-deep-maroon/10 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-deep-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-deep-maroon text-sm">FREE SHIPPING</p>
                                    <p class="text-deep-maroon/60 text-xs">above ₹{{ number_format($siteSettings['free_shipping_threshold'] ?? 5000) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-deep-maroon/10 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-deep-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-deep-maroon text-sm">PAYMENT SECURED</p>
                                    <p class="text-deep-maroon/60 text-xs">Safe with Our Payment</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-deep-maroon/10 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-deep-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-deep-maroon text-sm">DELIVERY</p>
                                    <p class="text-deep-maroon/60 text-xs">7–10 working days</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-deep-maroon/10 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-deep-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.868v6.264a1 1 0 01-1.447.894L15 14M3 8a1 1 0 011-1h8a1 1 0 011 1v8a1 1 0 01-1 1H4a1 1 0 01-1-1V8z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-deep-maroon text-sm">EXCHANGES</p>
                                    <p class="text-deep-maroon/60 text-xs">Unboxing video mandatory</p>
                                </div>
                            </div>
                        </div>

                        <!-- Share Section -->
                        <div class="mt-6">
                            <div class="flex items-center space-x-4">
                                <span class="font-medium text-deep-maroon text-sm">Share it:</span>
                                <div class="flex items-center space-x-3">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </a>
                                    <a href="https://www.instagram.com/amsukham/" target="_blank" rel="noopener" class="w-8 h-8 text-white rounded-full flex items-center justify-center transition-colors" style="background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                        </svg>
                                    </a>
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($product->name . ' - ' . request()->url()) }}" target="_blank" rel="noopener" class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                        </svg>
                                    </a>
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
                        @if($relatedProduct->thumbnail)
                            <img src="{{ $relatedProduct->thumbnail->url }}" alt="{{ $relatedProduct->name }}" class="w-full h-full object-cover">
                        @elseif($relatedProduct->primaryImage && $relatedProduct->primaryImage->media)
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
                                @php
                                    $relFirstColorPrice = $relatedProduct->productColors->first();
                                    $relPriceAdjPrice = $relFirstColorPrice ? $relFirstColorPrice->price_adjustment : 0;
                                    $relTotalOrigPrice = $relatedProduct->price + $relPriceAdjPrice;
                                    // Apply discount to total price, not base price
                                    $relTotalDiscPrice = $relatedProduct->discount > 0 
                                        ? $relTotalOrigPrice - ($relTotalOrigPrice * $relatedProduct->discount / 100)
                                        : $relTotalOrigPrice;
                                @endphp
                                @if($relatedProduct->discount > 0)
                                    <span class="text-deep-maroon/50 line-through text-sm">₹{{ number_format($relTotalOrigPrice) }}</span>
                                @endif
                                <span class="font-serif text-xl text-royal-gold">₹{{ number_format($relTotalDiscPrice) }}</span>
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
    const productStock = {{ $product->stock ?? 0 }};
    const isPreorder = {{ $product->is_preorder ? 'true' : 'false' }};
    const colorData = @json($colorData);
    const galleryImages = @json($allImages->values());

    function updateStockDisplay(stock) {
        const stockEl = document.getElementById('stockDisplay');
        const addBtn = document.getElementById('addToCartBtn');
        const buyBtn = document.getElementById('buyNowBtn');
        const stockInput = document.getElementById('available_stock');
        const qtyInput = document.getElementById('quantity');

        stockInput.value = stock;

        let html = '<span class="text-deep-maroon/70 font-medium">Availability:</span> ';
        if (isPreorder) {
            html += '<span class="inline-flex items-center gap-1 ml-2 px-2 py-0.5 bg-royal-gold/20 text-deep-maroon text-xs font-semibold rounded-full">Pre-Booking</span>';
        } else if (stock > 10) {
            html += '<span class="text-green-600 ml-2 font-medium">In Stock</span>';
        } else if (stock > 0) {
            html += '<span class="text-orange-500 ml-2 font-medium">Only ' + stock + ' left</span>';
        } else {
            html += '<span class="text-red-600 ml-2 font-medium">Out of Stock</span>';
        }
        stockEl.innerHTML = html;

        if (!isPreorder && stock <= 0) {
            addBtn.disabled = true;
            addBtn.textContent = 'OUT OF STOCK';
            addBtn.classList.add('opacity-50', 'cursor-not-allowed');
            buyBtn.classList.add('hidden');
        } else {
            addBtn.disabled = false;
            addBtn.textContent = isPreorder ? 'PRE-BOOK' : 'ADD TO CART';
            addBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            buyBtn.classList.remove('hidden');
            if (!isPreorder) {
                // Cap quantity to available stock
                if (parseInt(qtyInput.value) > stock) {
                    qtyInput.value = stock;
                }
                qtyInput.max = Math.min(10, stock);
            }
        }
    }

    function formatPrice(num) {
        return '₹' + Math.round(num).toLocaleString('en-IN');
    }

    function updatePriceDisplay(adjustment) {
        const currentOriginalPrice = originalPrice + adjustment;
        // Apply discount to total price, not base price
        const currentDiscountedPrice = discount > 0 
            ? currentOriginalPrice - (currentOriginalPrice * discount / 100)
            : currentOriginalPrice;
        
        const priceEl = document.getElementById('displayPrice');
        const originalPriceEl = document.getElementById('displayOriginalPrice');
        const discountBadgeEl = document.getElementById('displayDiscountBadge');
        
        if (priceEl) priceEl.textContent = formatPrice(currentDiscountedPrice);
        
        if (originalPriceEl && discountBadgeEl) {
            if (discount > 0) {
                originalPriceEl.textContent = formatPrice(currentOriginalPrice);
                originalPriceEl.classList.remove('hidden');
                discountBadgeEl.textContent = Math.round(discount) + '% OFF';
                discountBadgeEl.classList.remove('hidden');
            } else {
                originalPriceEl.classList.add('hidden');
                discountBadgeEl.classList.add('hidden');
            }
        }
    }

    function changeMainImage(src, element) {
        const mainImg = document.getElementById('mainProductImage');
        const placeholder = document.getElementById('mainProductImagePlaceholder');
        
        mainImg.src = src;
        mainImg.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');

        // Highlight active thumbnail
        document.querySelectorAll('.thumb-item').forEach(thumb => {
            thumb.classList.remove('border-royal-gold', 'opacity-100');
            thumb.classList.add('border-transparent', 'opacity-70');
        });
        element.classList.remove('border-transparent', 'opacity-70');
        element.classList.add('border-royal-gold', 'opacity-100');
    }

    function switchColor(colorId) {
        const color = colorData.find(c => c.id === colorId);
        if (!color) return;

        // Set selected color
        document.getElementById('product_color_id').value = colorId;

        // Update price
        updatePriceDisplay(color.price_adjustment);

        // Update stock display
        updateStockDisplay(color.stock !== undefined ? color.stock : productStock);

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

        // Choose images: color-specific if available, else gallery
        const images = color.images.length > 0 ? color.images : galleryImages;
        
        if (images.length > 0) {
            const mainImg = document.getElementById('mainProductImage');
            const placeholder = document.getElementById('mainProductImagePlaceholder');
            mainImg.src = images[0].url;
            mainImg.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');

            let thumbContainer = document.getElementById('thumbnailContainer');
            if (!thumbContainer) {
                thumbContainer = document.createElement('div');
                thumbContainer.id = 'thumbnailContainer';
                thumbContainer.className = 'flex gap-2 overflow-x-auto pb-2';
                mainImg.closest('.aspect-\\[4\\/5\\]').after(thumbContainer);
            }

            if (images.length > 1) {
                thumbContainer.className = 'flex gap-2 overflow-x-auto pb-2';
                thumbContainer.innerHTML = images.map((img, i) => `
                    <div class="thumb-item w-16 h-16 flex-shrink-0 bg-soft-cream overflow-hidden rounded cursor-pointer border-2 ${i === 0 ? 'border-royal-gold opacity-100' : 'border-transparent opacity-70'} hover:opacity-100 hover:border-deep-maroon/50 transition-all" onclick="changeMainImage('${img.url}', this)">
                        <img src="${img.url}" alt="" class="w-full h-full object-cover">
                    </div>
                `).join('');
            } else {
                thumbContainer.innerHTML = '';
            }
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
                let maxStock = parseInt(document.getElementById('available_stock').value) || 10;
                let maxQty = Math.min(10, maxStock);
                if (val < maxQty) quantityInput.value = val + 1;
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
