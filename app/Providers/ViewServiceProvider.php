<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(['partials.footer', 'partials.header', 'partials.mobile-menu', 'partials.topbar', 'pages.contact', 'pages.about'], function ($view) {
            $footerCategories = Category::active()->withCount('products')->latest()->take(6)->get();
            $view->with('footerCategories', $footerCategories);

            $siteSettings = [
                'site_name' => SiteSetting::get('site_name', 'Amsukham by Ram'),
                'site_tagline' => SiteSetting::get('site_tagline', 'Preserving heritage since 1950'),
                'site_description' => SiteSetting::get('site_description', ''),
                'contact_email' => SiteSetting::get('contact_email', 'info@amsukham.com'),
                'contact_phone' => SiteSetting::get('contact_phone', '+91 98765 43210'),
                'contact_whatsapp' => SiteSetting::get('contact_whatsapp', '+919876543210'),
                'contact_address_line1' => SiteSetting::get('contact_address_line1', 'Heritage Showroom'),
                'contact_address_line2' => SiteSetting::get('contact_address_line2', 'Traditional Textile District'),
                'contact_city' => SiteSetting::get('contact_city', 'Bangalore, India'),
                'social_facebook' => SiteSetting::get('social_facebook', ''),
                'social_instagram' => SiteSetting::get('social_instagram', ''),
                'social_twitter' => SiteSetting::get('social_twitter', ''),
                'social_youtube' => SiteSetting::get('social_youtube', ''),
                'social_pinterest' => SiteSetting::get('social_pinterest', ''),
            ];
            $view->with('siteSettings', $siteSettings);
        });
    }
}
