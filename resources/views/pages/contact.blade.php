@extends('layouts.app')

@section('title', 'Contact Us - Amsukham by Ram')

@section('content')
    <!-- Contact Hero Section -->
    <section class="relative bg-soft-cream py-20">
        <div class="absolute inset-0 brand-pattern-header opacity-10 pointer-events-none"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <p class="uppercase tracking-[0.3em] text-sm md:text-base text-royal-gold mb-4">Contact</p>
                <h1 class="font-serif text-4xl md:text-5xl text-deep-maroon mb-4">We Would Love to Hear From You</h1>
                <p class="text-deep-maroon/80 text-lg leading-relaxed">
                    Whether you're looking for the perfect saree, planning a special occasion, or simply wish to know more about our collections, our team is here to help.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-20 bg-heritage-white">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-start">
                <!-- Contact Form -->
                <div class="bg-soft-cream p-8 shadow-lg">
                    <h2 class="font-serif text-2xl md:text-3xl text-deep-maroon mb-4">Send Us a Message</h2>
                    <p class="text-deep-maroon/80 mb-8">
                        Share your questions and we'll get back to you as soon as possible.
                    </p>

                    <form action="#" method="post" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-deep-maroon mb-2">Full Name</label>
                            <input type="text" class="w-full px-4 py-3 border border-deep-maroon/20 focus:border-royal-gold focus:outline-none bg-heritage-white text-deep-maroon" placeholder="Enter your name">
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-deep-maroon mb-2">Email</label>
                                <input type="email" class="w-full px-4 py-3 border border-deep-maroon/20 focus:border-royal-gold focus:outline-none bg-heritage-white text-deep-maroon" placeholder="you@example.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-deep-maroon mb-2">Phone</label>
                                <input type="tel" class="w-full px-4 py-3 border border-deep-maroon/20 focus:border-royal-gold focus:outline-none bg-heritage-white text-deep-maroon" placeholder="+91 98765 43210">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-deep-maroon mb-2">Message</label>
                            <textarea rows="4" class="w-full px-4 py-3 border border-deep-maroon/20 focus:border-royal-gold focus:outline-none bg-heritage-white text-deep-maroon" placeholder="Tell us how we can help"></textarea>
                        </div>
                        <button type="submit" class="w-full md:w-auto bg-deep-maroon text-heritage-white px-8 py-3 font-medium hover:bg-royal-gold transition-colors shadow-lg">
                            Submit Enquiry
                        </button>
                        
                    </form>
                </div>

                <!-- Contact Details -->
                <div class="space-y-8">
                    <div>
                        <h2 class="font-serif text-2xl md:text-3xl text-deep-maroon mb-4">Visit Our Showroom</h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-royal-gold to-yellow-400 mb-6"></div>
                        <p class="text-deep-maroon/80 mb-4">
                            Experience our sarees in person, feel the textures, and explore curated collections with guidance from our heritage stylists.
                        </p>
                        <div class="space-y-3 text-deep-maroon/80 text-sm">
                            <p class="font-medium text-deep-maroon">Heritage Showroom</p>
                            <p>Traditional Textile District</p>
                            <p>Bangalore, India</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-serif text-xl text-deep-maroon mb-2">Connect with Us</h3>
                        <p class="text-deep-maroon/80 text-sm mb-5">Tap an icon to reach us instantly.</p>

                        <div class="flex flex-wrap items-center gap-6">
                            <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="group inline-flex flex-col items-center">
                                <span class="w-12 h-12 rounded-full bg-gradient-to-tr from-pink-500 via-red-500 to-yellow-400 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 2C4.239 2 2 4.239 2 7v10c0 2.761 2.239 5 5 5h10c2.761 0 5-2.239 5-5V7c0-2.761-2.239-5-5-5H7zm10 2a3 3 0 013 3v10a3 3 0 01-3 3H7a3 3 0 01-3-3V7a3 3 0 013-3h10zm-5 3.5A4.5 4.5 0 007.5 12 4.5 4.5 0 0012 16.5 4.5 4.5 0 0016.5 12 4.5 4.5 0 0012 7.5zm0 7.3A2.8 2.8 0 019.2 12 2.8 2.8 0 0112 9.2 2.8 2.8 0 0114.8 12 2.8 2.8 0 0112 14.8zM17.7 6.1a1.1 1.1 0 10-.001 2.201A1.1 1.1 0 0017.7 6.1z"/>
                                    </svg>
                                </span>
                                <span class="mt-2 text-xs font-medium text-deep-maroon">Instagram</span>
                            </a>

                            <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" class="group inline-flex flex-col items-center">
                                <span class="w-12 h-12 rounded-full bg-[#1877F2] flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22 12a10 10 0 10-11.5 9.9v-7H8v-2.9h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.2c-1.2 0-1.6.8-1.6 1.5v1.9H18l-.4 2.9h-2.7v7A10 10 0 0022 12z"/>
                                    </svg>
                                </span>
                                <span class="mt-2 text-xs font-medium text-deep-maroon">Facebook</span>
                            </a>

                            <a href="mailto:info@amsukham.com" class="group inline-flex flex-col items-center">
                                <span class="w-12 h-12 rounded-full bg-royal-gold flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                                    <svg class="w-6 h-6 text-deep-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </span>
                                <span class="mt-2 text-xs font-medium text-deep-maroon">Email</span>
                            </a>

                            <a href="https://wa.me/919876543210" target="_blank" rel="noopener noreferrer" class="group inline-flex flex-col items-center">
                                <span class="w-12 h-12 rounded-full bg-[#25D366] flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2a10 10 0 00-8.6 15.1L2 22l5-1.3A10 10 0 1012 2zm0 18a7.9 7.9 0 01-4-1.1l-.3-.2-3 .8.8-2.9-.2-.3A8 8 0 1112 20zm4.4-5.8c-.2-.1-1.3-.6-1.5-.7-.2-.1-.4-.1-.6.1-.2.2-.7.7-.8.8-.2.2-.3.2-.6.1-.2-.1-1-.4-1.9-1.2-.7-.6-1.2-1.4-1.3-1.6-.1-.2 0-.4.1-.5.1-.1.2-.3.3-.4.1-.1.2-.3.3-.4.1-.2.1-.4 0-.6-.1-.1-.6-1.4-.8-1.9-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.5.1-.7.4-.2.2-.9.8-.9 2s.9 2.3 1 2.4c.1.2 1.8 2.8 4.4 3.9.6.3 1.1.5 1.5.6.6.2 1.1.2 1.5.1.5-.1 1.3-.5 1.4-1 .2-.5.2-.9.1-1-.1-.1-.2-.1-.4-.2z"/>
                                    </svg>
                                </span>
                                <span class="mt-2 text-xs font-medium text-deep-maroon">WhatsApp</span>
                            </a>

                            <a href="tel:+919876543210" class="group inline-flex flex-col items-center">
                                <span class="w-12 h-12 rounded-full bg-deep-maroon flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                                    <svg class="w-6 h-6 text-heritage-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </span>
                                <span class="mt-2 text-xs font-medium text-deep-maroon">Call</span>
                            </a>
                        </div>
                    </div>

                    <div class="bg-soft-cream p-6 shadow-lg">
                        <h3 class="font-serif text-xl text-deep-maroon mb-2">Store Hours</h3>
                        <div class="text-deep-maroon/80 text-sm space-y-1">
                            <p>Monday - Saturday: 10:00 AM - 8:30 PM</p>
                            <p>Sunday: 11:00 AM - 7:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
