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
            static $footerCategories = null;
            static $siteSettings = null;

            if ($footerCategories === null) {
                $footerCategories = Category::active()->withCount('products')->latest()->take(6)->get();
            }

            if ($siteSettings === null) {
                $defaults = [
                    'site_name' => 'Amsukham by Ram',
                    'site_tagline' => 'Preserving heritage since 1950',
                    'site_description' => '',
                    'contact_email' => 'info@amsukham.com',
                    'contact_phone' => '+91 98765 43210',
                    'contact_whatsapp' => '+919876543210',
                    'contact_address_line1' => 'Heritage Showroom',
                    'contact_address_line2' => 'Traditional Textile District',
                    'contact_city' => 'Bangalore, India',
                    'social_facebook' => '',
                    'social_instagram' => '',
                    'social_twitter' => '',
                    'social_youtube' => '',
                    'social_pinterest' => '',
                ];

                $allSettings = SiteSetting::whereIn('key', array_keys($defaults))->pluck('value', 'key')->toArray();

                $siteSettings = [];
                foreach ($defaults as $key => $default) {
                    $siteSettings[$key] = $allSettings[$key] ?? $default;
                }
            }

            $view->with('footerCategories', $footerCategories);
            $view->with('siteSettings', $siteSettings);
        });
    }
}
