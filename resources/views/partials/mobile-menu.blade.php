<!-- Mobile Menu Overlay -->
<div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden opacity-0 invisible transition-all duration-300"></div>

<!-- Mobile Slide-out Menu -->
<div id="mobile-menu" class="fixed top-0 left-0 h-full w-80 bg-heritage-white z-50 md:hidden -translate-x-full transition-transform duration-300 ease-in-out">
    <!-- Menu Header -->
    <div class="bg-deep-maroon text-heritage-white p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo-amsukham-03.webp') }}" alt="Amsukham by Ram" class="h-12">
                <div>
                    <h3 class="font-serif text-lg text-heritage-white">Amsukham</h3>
                    <p class="text-heritage-white/80 text-sm">by Ram</p>
                </div>
            </div>
            <button id="mobile-menu-close" class="text-heritage-white hover:text-royal-gold transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Menu Content -->
    <div class="p-6">
        <!-- Navigation Links -->
        <nav class="space-y-2 mb-8">
            <a href="{{ route('latest-collections') }}" class="block py-4 px-4 text-deep-maroon hover:text-royal-gold hover:bg-soft-cream transition-colors font-medium border-b border-deep-maroon/10 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span>Latest Collections</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            <a href="{{ route('products') }}" class="block py-4 px-4 text-deep-maroon hover:text-royal-gold hover:bg-soft-cream transition-colors font-medium border-b border-deep-maroon/10 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span>Collections</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            <a href="{{ route('preorder') }}" class="block py-4 px-4 text-deep-maroon hover:text-royal-gold hover:bg-soft-cream transition-colors font-medium border-b border-deep-maroon/10 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-royal-gold animate-pulse"></span>
                        Pre-Booking
                    </span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            {{-- <a href="{{ route('products') }}" class="block py-4 px-4 text-deep-maroon hover:text-royal-gold hover:bg-soft-cream transition-colors font-medium border-b border-deep-maroon/10 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span>Best Sellers</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a> --}}
            <!-- <a href="{{ route('products') }}" class="block py-4 px-4 text-deep-maroon hover:text-royal-gold hover:bg-soft-cream transition-colors font-medium border-b border-deep-maroon/10 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span>All Products</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            <a href="{{ route('latest-collections') }}" class="block py-4 px-4 text-deep-maroon hover:text-royal-gold hover:bg-soft-cream transition-colors font-medium border-b border-deep-maroon/10 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span>Collections Gallery</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a> -->
            <a href="{{ route('about') }}" class="block py-4 px-4 text-deep-maroon hover:text-royal-gold hover:bg-soft-cream transition-colors font-medium border-b border-deep-maroon/10 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span>About Us</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            <a href="{{ route('contact') }}" class="block py-4 px-4 text-deep-maroon hover:text-royal-gold hover:bg-soft-cream transition-colors font-medium border-b border-deep-maroon/10 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span>Contact</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            <button onclick="openTrackOrderModal()" class="w-full text-left block py-4 px-4 text-deep-maroon hover:text-royal-gold hover:bg-soft-cream transition-colors font-medium border-b border-deep-maroon/10 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span>Track Order</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </button>
        </nav>

        <!-- Quick Actions -->
        <div class="space-y-4 mb-8">
            <h4 class="font-serif text-lg text-deep-maroon mb-4">Quick Actions</h4>
            <div class="grid grid-cols-3 gap-3">
                <!-- <button class="flex flex-col items-center p-4 bg-soft-cream hover:bg-royal-gold hover:text-heritage-white transition-colors rounded-lg">
                    <img src="{{ asset('images/search-interface-symbol.svg') }}" alt="Search" class="w-6 h-6 mb-2">
                    <span class="text-xs font-medium">Search</span>
                </button>
                <button class="flex flex-col items-center p-4 bg-soft-cream hover:bg-royal-gold hover:text-heritage-white transition-colors rounded-lg">
                    <img src="{{ asset('images/heart.svg') }}" alt="Wishlist" class="w-6 h-6 mb-2">
                    <span class="text-xs font-medium">Wishlist</span>
                </button> -->
                <a href="{{ route('cart.index') }}" class="flex flex-col items-center p-4 bg-soft-cream hover:bg-royal-gold hover:text-heritage-white transition-colors rounded-lg relative">
                    <img src="{{ asset('images/shopping-cart.svg') }}" alt="Cart" class="w-6 h-6 mb-2">
                    <span class="text-xs font-medium">Cart</span>
                    <span class="cart-count-badge absolute -top-1 -right-1 bg-deep-maroon text-heritage-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                </a>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="bg-soft-cream p-4 rounded-lg">
            <h4 class="font-serif text-lg text-deep-maroon mb-3">Get in Touch</h4>
            <div class="space-y-2 text-sm">
                <div class="flex items-center space-x-2 text-deep-maroon/80">
                    <svg class="w-4 h-4 text-royal-gold" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                    </svg>
                    <span>{{ $siteSettings['contact_phone'] ?? '+91 98765 43210' }}</span>
                </div>
                <div class="flex items-center space-x-2 text-deep-maroon/80">
                    <svg class="w-4 h-4 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ $siteSettings['contact_email'] ?? 'info@amsukham.com' }}</span>
                </div>
            </div>
            
            <!-- Social Media -->
            <div class="flex space-x-3 mt-4">
                @if(!empty($siteSettings['social_youtube']))
                <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" class="w-8 h-8 bg-deep-maroon text-heritage-white flex items-center justify-center rounded-full hover:bg-royal-gold transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </a>
                @endif
                @if(!empty($siteSettings['social_instagram']))
                <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" class="w-8 h-8 bg-deep-maroon text-heritage-white flex items-center justify-center rounded-full hover:bg-royal-gold transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                @endif
                @if(!empty($siteSettings['social_facebook']))
                <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" class="w-8 h-8 bg-deep-maroon text-heritage-white flex items-center justify-center rounded-full hover:bg-royal-gold transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenuClose = document.getElementById('mobile-menu-close');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

        function openMobileMenu() {
            mobileMenu.classList.remove('-translate-x-full');
            mobileMenu.classList.add('translate-x-0');
            mobileMenuOverlay.classList.remove('opacity-0', 'invisible');
            mobileMenuOverlay.classList.add('opacity-100', 'visible');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenu() {
            mobileMenu.classList.add('-translate-x-full');
            mobileMenu.classList.remove('translate-x-0');
            mobileMenuOverlay.classList.add('opacity-0', 'invisible');
            mobileMenuOverlay.classList.remove('opacity-100', 'visible');
            document.body.style.overflow = '';
        }

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', openMobileMenu);
        }

        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', closeMobileMenu);
        }

        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', closeMobileMenu);
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !mobileMenu.classList.contains('-translate-x-full')) {
                closeMobileMenu();
            }
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768 && !mobileMenu.classList.contains('-translate-x-full')) {
                closeMobileMenu();
            }
        });
    });
</script>
@endpush
