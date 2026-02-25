<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // General
            ['key' => 'site_name', 'value' => 'Amsukham by Ram', 'type' => 'text', 'group' => 'general', 'label' => 'Site Name'],
            ['key' => 'site_tagline', 'value' => 'Preserving heritage since 1950', 'type' => 'text', 'group' => 'general', 'label' => 'Site Tagline'],
            ['key' => 'site_description', 'value' => 'Preserving the timeless art of traditional Indian textiles through three generations of dedicated craftsmanship and heritage.', 'type' => 'textarea', 'group' => 'general', 'label' => 'Site Description'],
            
            // Contact
            ['key' => 'contact_email', 'value' => 'info@amsukham.com', 'type' => 'text', 'group' => 'contact', 'label' => 'Contact Email'],
            ['key' => 'contact_phone', 'value' => '+91 98765 43210', 'type' => 'text', 'group' => 'contact', 'label' => 'Contact Phone'],
            ['key' => 'contact_whatsapp', 'value' => '+919876543210', 'type' => 'text', 'group' => 'contact', 'label' => 'WhatsApp Number'],
            ['key' => 'contact_address_line1', 'value' => 'Heritage Showroom', 'type' => 'text', 'group' => 'contact', 'label' => 'Address Line 1'],
            ['key' => 'contact_address_line2', 'value' => 'Traditional Textile District', 'type' => 'text', 'group' => 'contact', 'label' => 'Address Line 2'],
            ['key' => 'contact_city', 'value' => 'Bangalore, India', 'type' => 'text', 'group' => 'contact', 'label' => 'City'],
            
            // Social Links
            ['key' => 'social_facebook', 'value' => 'https://www.facebook.com/', 'type' => 'text', 'group' => 'social', 'label' => 'Facebook URL'],
            ['key' => 'social_instagram', 'value' => 'https://www.instagram.com/', 'type' => 'text', 'group' => 'social', 'label' => 'Instagram URL'],
            ['key' => 'social_twitter', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'Twitter/X URL'],
            ['key' => 'social_youtube', 'value' => 'https://www.youtube.com/', 'type' => 'text', 'group' => 'social', 'label' => 'YouTube URL'],
            ['key' => 'social_pinterest', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'Pinterest URL'],
        ];

        foreach ($defaults as $setting) {
            SiteSetting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
