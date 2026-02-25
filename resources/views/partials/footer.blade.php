<!-- Footer -->
<footer class="relative bg-deep-maroon text-heritage-white py-20">
    <!-- Brand Pattern Background -->
    <div class="brand-pattern-header absolute inset-0 bg-repeat opacity-5 pointer-events-none"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <!-- Newsletter Section -->
        <div class="text-center mb-16">
            <h3 class="font-serif text-3xl text-heritage-white mb-4">Stay Connected with Heritage</h3>
            <p class="text-heritage-white/80 mb-6 max-w-2xl mx-auto">Subscribe to receive updates on our latest collections, exclusive offers, and stories from our artisan community.</p>
            <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 bg-heritage-white/10 border border-heritage-white/20 text-heritage-white placeholder-heritage-white/60 focus:outline-none focus:border-royal-gold">
                <button class="bg-royal-gold text-deep-maroon px-6 py-3 font-medium hover:bg-heritage-white transition-colors">
                    Subscribe
                </button>
            </div>
        </div>
        
        <div class="grid md:grid-cols-4 gap-8 mb-12">
            <!-- Brand -->
            <div class="md:col-span-2">
                <div class="mb-6">
                    <div class="inline-block bg-heritage-white p-4 rounded-lg shadow-lg">
                        <img src="{{ asset('images/amsukham-logo.svg') }}" alt="Amsukham by Ram" class="h-16">
                    </div>
                </div>
                <p class="text-heritage-white/80 mb-6 leading-relaxed">
                    Preserving the timeless art of traditional Indian textiles through three generations of dedicated craftsmanship and heritage.
                </p>
                <div class="flex space-x-4">
                    @if($siteSettings['contact_whatsapp'] ?? '')
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_whatsapp']) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-heritage-white/10 flex items-center justify-center hover:bg-royal-gold hover:text-deep-maroon transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2a10 10 0 00-8.6 15.1L2 22l5-1.3A10 10 0 1012 2zm0 18a7.9 7.9 0 01-4-1.1l-.3-.2-3 .8.8-2.9-.2-.3A8 8 0 1112 20zm4.4-5.8c-.2-.1-1.3-.6-1.5-.7-.2-.1-.4-.1-.6.1-.2.2-.7.7-.8.8-.2.2-.3.2-.6.1-.2-.1-1-.4-1.9-1.2-.7-.6-1.2-1.4-1.3-1.6-.1-.2 0-.4.1-.5.1-.1.2-.3.3-.4.1-.1.2-.3.3-.4.1-.2.1-.4 0-.6-.1-.1-.6-1.4-.8-1.9-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.5.1-.7.4-.2.2-.9.8-.9 2s.9 2.3 1 2.4c.1.2 1.8 2.8 4.4 3.9.6.3 1.1.5 1.5.6.6.2 1.1.2 1.5.1.5-.1 1.3-.5 1.4-1 .2-.5.2-.9.1-1-.1-.1-.2-.1-.4-.2z"/>
                        </svg>
                    </a>
                    @endif
                    @if($siteSettings['social_facebook'] ?? '')
                    <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-heritage-white/10 flex items-center justify-center hover:bg-royal-gold hover:text-deep-maroon transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12a10 10 0 10-11.5 9.9v-7H8v-2.9h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.2c-1.2 0-1.6.8-1.6 1.5v1.9H18l-.4 2.9h-2.7v7A10 10 0 0022 12z"/>
                        </svg>
                    </a>
                    @endif
                    @if($siteSettings['social_twitter'] ?? '')
                    <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-heritage-white/10 flex items-center justify-center hover:bg-royal-gold hover:text-deep-maroon transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.46 6c-.77.35-1.6.58-2.46.69a4.3 4.3 0 001.88-2.38 8.59 8.59 0 01-2.72 1.04 4.28 4.28 0 00-7.29 3.9A12.14 12.14 0 013 4.79a4.28 4.28 0 001.32 5.71 4.25 4.25 0 01-1.94-.54v.05a4.28 4.28 0 003.44 4.19 4.3 4.3 0 01-1.93.07 4.28 4.28 0 004 2.97A8.6 8.6 0 012 19.54a12.13 12.13 0 006.56 1.92c7.88 0 12.2-6.53 12.2-12.2 0-.19 0-.37-.01-.56A8.7 8.7 0 0022.46 6z"/>
                        </svg>
                    </a>
                    @endif
                    @if($siteSettings['social_instagram'] ?? '')
                    <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-heritage-white/10 flex items-center justify-center hover:bg-royal-gold hover:text-deep-maroon transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 2.163c-3.259 0-3.667.014-4.947.072-2.948.134-4.305 1.493-4.439 4.439-.058 1.279-.072 1.688-.072 4.947 0 3.259.014 3.668.072 4.947.134 2.947 1.491 4.305 4.439 4.439 1.28.058 1.688.072 4.947.072 3.259 0 3.668-.014 4.947-.072 2.947-.134 4.305-1.491 4.439-4.439.058-1.279.072-1.688.072-4.947 0-3.259-.014-3.668-.072-4.947-.134-2.946-1.492-4.305-4.439-4.439-1.279-.058-1.688-.072-4.947-.072zm0 3.675c-2.989 0-5.413 2.424-5.413 5.413s2.424 5.413 5.413 5.413 5.413-2.424 5.413-5.413S14.989 7.838 12 7.838zm0 8.927a3.514 3.514 0 110-7.028 3.514 3.514 0 010 7.028zm5.627-9.949a1.262 1.262 0 11-2.524 0 1.262 1.262 0 012.524 0z"/>
                        </svg>
                    </a>
                    @endif
                    @if($siteSettings['social_youtube'] ?? '')
                    <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-heritage-white/10 flex items-center justify-center hover:bg-royal-gold hover:text-deep-maroon transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    @endif
                    <a href="mailto:{{ $siteSettings['contact_email'] ?? 'info@amsukham.com' }}" class="w-10 h-10 bg-heritage-white/10 flex items-center justify-center hover:bg-royal-gold hover:text-deep-maroon transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['contact_phone'] ?? '+919876543210') }}" class="w-10 h-10 bg-heritage-white/10 flex items-center justify-center hover:bg-royal-gold hover:text-deep-maroon transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h5 class="font-serif text-lg text-heritage-white mb-6">Collections</h5>
                <ul class="space-y-3">
                    @forelse($footerCategories ?? [] as $category)
                        <li><a href="{{ route('products', ['categories' => $category->id]) }}" class="text-heritage-white/80 hover:text-royal-gold transition-colors flex items-center">
                            <span class="w-1 h-1 bg-royal-gold rounded-full mr-3"></span>{{ $category->name }}
                        </a></li>
                    @empty
                        <li><a href="{{ route('products') }}" class="text-heritage-white/80 hover:text-royal-gold transition-colors flex items-center">
                            <span class="w-1 h-1 bg-royal-gold rounded-full mr-3"></span>View All Products
                        </a></li>
                    @endforelse
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h5 class="font-serif text-lg text-heritage-white mb-6">Visit Our Showroom</h5>
                <div class="space-y-3 text-heritage-white/80">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-royal-gold mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <div>
                            <p>{{ $siteSettings['contact_address_line1'] ?? 'Heritage Showroom' }}</p>
                            <p>{{ $siteSettings['contact_address_line2'] ?? 'Traditional Textile District' }}</p>
                            <p>{{ $siteSettings['contact_city'] ?? 'Bangalore, India' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-royal-gold mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <p class="text-royal-gold">{{ $siteSettings['contact_phone'] ?? '+91 98765 43210' }}</p>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-royal-gold mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-royal-gold">{{ $siteSettings['contact_email'] ?? 'info@amsukham.com' }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Trust Badges -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
            <div class="text-center">
                <div class="w-12 h-12 bg-heritage-white/10 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-heritage-white/80 text-sm">Authentic Handwoven</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-heritage-white/10 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-heritage-white/80 text-sm">70+ Years Legacy</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-heritage-white/10 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-heritage-white/80 text-sm">Worldwide Shipping</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-heritage-white/10 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <p class="text-heritage-white/80 text-sm">Crafted with Love</p>
            </div>
        </div>
        
        <div class="border-t border-heritage-white/20 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-heritage-white/60 mb-4 md:mb-0">
                    © {{ date('Y') }} Amsukham by Ram. All rights reserved. | Preserving heritage since 1950
                </p>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="text-heritage-white/60 hover:text-royal-gold transition-colors">Privacy Policy</a>
                    <a href="#" class="text-heritage-white/60 hover:text-royal-gold transition-colors">Terms of Service</a>
                    <a href="#" class="text-heritage-white/60 hover:text-royal-gold transition-colors">Return Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>
