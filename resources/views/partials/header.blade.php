<!-- Header -->
<header class="bg-heritage-white shadow-lg sticky top-0 z-50 relative">
    <div class="brand-pattern-header absolute inset-0 bg-repeat opacity-15 pointer-events-none"></div>
    <div class="container mx-auto px-6 py-4 relative z-10">
        <!-- Desktop Layout -->
        <div class="hidden md:grid md:grid-cols-3 items-center">
            <!-- Navigation Left -->
            <nav class="flex space-x-8 justify-start">
                <a href="{{ route('latest-collections') }}" class="text-deep-maroon hover:text-royal-gold transition-colors font-medium">Latest Collections</a>
                <a href="{{ route('products') }}" class="text-deep-maroon hover:text-royal-gold transition-colors font-medium">Collections</a>
                {{-- <a href="{{ route('products') }}" class="text-deep-maroon hover:text-royal-gold transition-colors font-medium">Best Sellers</a> --}}
                
            </nav>
            
            <!-- Brand Logo Center -->
            <div class="flex justify-center">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo-amsukham-03.webp') }}" alt="Amsukham by Ram" class="h-28">
                </a>
            </div>
            
            <!-- Ecommerce Icons Right -->
            <div class="flex items-center space-x-6 justify-end">
                <!-- Search Icon -->
                <!-- <button class="text-deep-maroon hover:text-royal-gold transition-colors">
                    <img src="{{ asset('images/search-interface-symbol.svg') }}" alt="Search" class="w-6 h-6">
                </button> -->
                
                <!-- Wishlist Icon -->
                <!-- <button class="text-deep-maroon hover:text-royal-gold transition-colors relative">
                    <img src="{{ asset('images/heart.svg') }}" alt="Wishlist" class="w-6 h-6">
                </button> -->


                <a href="{{ route('about') }}" class="text-deep-maroon hover:text-royal-gold transition-colors font-medium">About Us</a>
                <a href="{{ route('contact') }}" class="text-deep-maroon hover:text-royal-gold transition-colors font-medium">Contact</a>
                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}" class="text-deep-maroon hover:text-royal-gold transition-colors relative">
                    <img src="{{ asset('images/shopping-cart.svg') }}" alt="Cart" class="w-6 h-6">
                    <span class="cart-count-badge absolute -top-2 -right-2 bg-royal-gold text-heritage-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium">0</span>
                </a>
            </div>
        </div>
        
        <!-- Mobile Layout -->
        <div class="md:hidden flex items-center justify-between">
            <!-- Brand Logo Left -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/amsukham-logo.svg') }}" alt="Amsukham by Ram" class="h-16">
                </a>
            </div>
            
            <!-- Right Side: Icons + Hamburger -->
            <div class="flex items-center space-x-4">
                <!-- Ecommerce Icons -->
                <div class="flex items-center space-x-4">
                    <!-- Search Icon -->
                    <!-- <button class="text-deep-maroon hover:text-royal-gold transition-colors">
                        <img src="{{ asset('images/search-interface-symbol.svg') }}" alt="Search" class="w-5 h-5">
                    </button> -->
                    
                    <!-- Wishlist Icon -->
                    <!-- <button class="text-deep-maroon hover:text-royal-gold transition-colors relative">
                        <img src="{{ asset('images/heart.svg') }}" alt="Wishlist" class="w-5 h-5">
                    </button> -->
                    
                    <!-- Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="text-deep-maroon hover:text-royal-gold transition-colors relative">
                        <img src="{{ asset('images/shopping-cart.svg') }}" alt="Cart" class="w-5 h-5">
                        <span class="cart-count-badge absolute -top-1 -right-1 bg-royal-gold text-heritage-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-medium text-xs">0</span>
                    </a>
                </div>
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-toggle" class="text-deep-maroon ml-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>
