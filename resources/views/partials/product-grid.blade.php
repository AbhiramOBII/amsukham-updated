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
                @if($product->discount > 0)
                    <span class="text-deep-maroon/50 line-through text-sm">₹{{ number_format($product->price) }}</span>
                @endif
                <span class="font-serif text-xl text-royal-gold">₹{{ number_format($product->discounted_price) }}</span>
            </div>
            <form action="{{ route('cart.add') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="text-deep-maroon hover:text-royal-gold transition-colors" title="Add to Cart">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </button>
            </form>
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
