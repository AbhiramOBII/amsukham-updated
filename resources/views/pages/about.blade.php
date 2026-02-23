@extends('layouts.app')

@section('title', 'About Us - Amsukham by Ram')

@section('content')
    <!-- About Hero Section -->
    <section class="relative bg-soft-cream py-24">
        <div class="absolute inset-0 brand-pattern-header opacity-10 pointer-events-none"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <p class="uppercase tracking-[0.3em] text-sm md:text-base text-royal-gold mb-4">Our Story</p>
                <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl text-deep-maroon mb-6 leading-tight">
                    Weaving Heritage
                    <span class="block text-royal-gold">Into Every Saree</span>
                </h1>
                <p class="text-deep-maroon/80 text-lg leading-relaxed mb-4">
                    Amsukham by Ram is a celebration of timeless Indian craftsmanship. For over seven decades, our family has been devoted to preserving the rich traditions of handwoven sarees, curating pieces that honour heritage while embracing contemporary elegance.
                </p>
                <p class="text-deep-maroon/80 text-lg leading-relaxed">
                    From Mysuru silk to intricate Kanchipuram weaves, every saree in our collection carries the stories of the artisans behind it—stories of patience, precision, and passion woven into each thread.
                </p>
            </div>
        </div>
    </section>

    <!-- Heritage & Craftsmanship -->
    <section class="py-24 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-[1.1fr,1.5fr] gap-16 items-start">
                <div>
                    <h2 class="font-serif text-3xl md:text-4xl text-deep-maroon mb-6">A Legacy of Craftsmanship</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mb-8"></div>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        Our journey began in a traditional textile district, where handlooms echoed through narrow streets and every household was touched by the art of weaving. What started as a small family studio has grown into a heritage brand, trusted by generations of patrons across the world.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        We collaborate closely with master weavers and artisan clusters, ensuring that every design respects regional techniques while introducing thoughtful, modern details that make each piece truly timeless.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        By choosing Amsukham, you support a living tradition—sustaining livelihoods, keeping ancient skills alive, and celebrating the soul of Indian textiles.
                    </p>

                    <div class="grid sm:grid-cols-2 gap-6 mt-10">
                        <div class="bg-soft-cream p-6 shadow-lg">
                            <p class="text-xs font-semibold tracking-wide text-royal-gold mb-2 uppercase">70+ Years</p>
                            <p class="font-serif text-2xl text-deep-maroon mb-2">Of Heritage</p>
                            <p class="text-sm text-deep-maroon/80">Three generations dedicated to curating and creating exquisite sarees that honour tradition.</p>
                        </div>
                        <div class="bg-soft-cream p-6 shadow-lg">
                            <p class="text-xs font-semibold tracking-wide text-royal-gold mb-2 uppercase">Artisan Led</p>
                            <p class="font-serif text-2xl text-deep-maroon mb-2">Craft First</p>
                            <p class="text-sm text-deep-maroon/80">We work directly with weavers, ensuring fair practices and uncompromised quality in every piece.</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="overflow-hidden shadow-lg bg-soft-cream h-[380px] md:h-[460px] lg:h-[520px]">
                        <div class="relative w-full h-full grid grid-cols-2 grid-rows-2 gap-2 p-2">
                            <div class="row-span-2 overflow-hidden">
                                <img src="{{ asset('images/best-seller-01.jpg') }}" alt="Silk Saree Collection" class="w-full h-full object-cover">
                            </div>
                            <div class="overflow-hidden">
                                <img src="{{ asset('images/best-seller-02.jpg') }}" alt="Heritage Saree Display" class="w-full h-full object-cover">
                            </div>
                            <div class="overflow-hidden">
                                <img src="{{ asset('images/best-seller-04.jpg') }}" alt="Traditional Saree Collection" class="w-full h-full object-cover">
                            </div>
                            <div class="hidden sm:flex absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-16 h-16 md:w-20 md:h-20 rounded-full bg-heritage-white items-center justify-center shadow-lg border-2 border-royal-gold">
                                <img src="{{ asset('images/amsukham-logo.svg') }}" alt="Amsukham by Ram" class="h-10">
                            </div>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-3 gap-4">
                        <div class="bg-soft-cream p-4 text-center shadow">
                            <p class="font-serif text-3xl text-royal-gold mb-1">70+</p>
                            <p class="text-xs uppercase tracking-wide text-deep-maroon/80">Years of Legacy</p>
                        </div>
                        <div class="bg-soft-cream p-4 text-center shadow">
                            <p class="font-serif text-3xl text-royal-gold mb-1">1000+</p>
                            <p class="text-xs uppercase tracking-wide text-deep-maroon/80">Sarees Crafted</p>
                        </div>
                        <div class="bg-soft-cream p-4 text-center shadow">
                            <p class="font-serif text-3xl text-royal-gold mb-1">Worldwide</p>
                            <p class="text-xs uppercase tracking-wide text-deep-maroon/80">Patrons</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-24 bg-soft-cream">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-serif text-3xl md:text-4xl text-deep-maroon mb-4">What We Stand For</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mx-auto mb-6"></div>
                <p class="text-deep-maroon/80 leading-relaxed">
                    Every collection is guided by three simple principles—authenticity, elegance, and responsibility. We believe that luxury should feel meaningful, rooted in culture, and crafted with conscience.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-heritage-white p-8 shadow-lg">
                    <h3 class="font-serif text-xl text-deep-maroon mb-3">Authentic Textiles</h3>
                    <p class="text-deep-maroon/80 text-sm leading-relaxed">
                        We source pure silks and traditional materials, working with verified weaving clusters to ensure authenticity in every saree.
                    </p>
                </div>
                <div class="bg-heritage-white p-8 shadow-lg">
                    <h3 class="font-serif text-xl text-deep-maroon mb-3">Thoughtful Design</h3>
                    <p class="text-deep-maroon/80 text-sm leading-relaxed">
                        Our designs blend age-old motifs with contemporary aesthetics, creating pieces that feel classic yet effortlessly modern.
                    </p>
                </div>
                <div class="bg-heritage-white p-8 shadow-lg">
                    <h3 class="font-serif text-xl text-deep-maroon mb-3">Conscious Craft</h3>
                    <p class="text-deep-maroon/80 text-sm leading-relaxed">
                        From loom to wardrobe, we prioritise fair practices, respectful collaborations, and long-lasting quality.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-24 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <h2 class="font-serif text-3xl md:text-4xl text-deep-maroon mb-4">Experience Amsukham</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mb-6"></div>
                    <p class="text-deep-maroon/80 leading-relaxed mb-4">
                        Whether you are choosing a saree for a milestone celebration or curating a timeless trousseau, our collections are designed to become cherished heirlooms.
                    </p>
                    <p class="text-deep-maroon/80 leading-relaxed">
                        Visit our showroom or explore our latest collections online to discover pieces that resonate with your story.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('latest-collections') }}" class="inline-block bg-deep-maroon text-heritage-white px-8 py-3 font-medium text-center hover:bg-royal-gold transition-colors shadow-lg">
                        View Latest Collections
                    </a>
                    <a href="{{ route('products') }}" class="inline-block border border-deep-maroon text-deep-maroon px-8 py-3 font-medium text-center hover:bg-deep-maroon hover:text-heritage-white transition-colors">
                        Explore All Products
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
