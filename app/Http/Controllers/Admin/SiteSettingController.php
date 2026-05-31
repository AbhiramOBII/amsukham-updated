<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::getAllGrouped();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            if ($value !== null) {
                $existing = SiteSetting::where('key', $key)->first();
                if ($existing) {
                    $existing->update(['value' => $value]);
                } else {
                    SiteSetting::set($key, $value);
                }
            }
        }

        SiteSetting::clearCache();

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully!');
    }

    public function seed()
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

            // Announcements
            ['key' => 'marquee_enabled', 'value' => '1', 'type' => 'toggle', 'group' => 'announcements', 'label' => 'Enable Announcement Bar'],
            ['key' => 'marquee_text', 'value' => 'Free Shipping on orders above ₹5000 | New Arrivals Every Week | Authentic Handloom Sarees', 'type' => 'textarea', 'group' => 'announcements', 'label' => 'Announcement Text (use | to separate multiple messages)'],

            // Shipping
            ['key' => 'free_shipping_threshold', 'value' => '5000', 'type' => 'number', 'group' => 'shipping', 'label' => 'Free Shipping Threshold (₹)'],
            ['key' => 'shipping_charge', 'value' => '99', 'type' => 'number', 'group' => 'shipping', 'label' => 'Shipping Charge (₹)'],

            // Payment
            ['key' => 'razorpay_key', 'value' => '', 'type' => 'text', 'group' => 'payment', 'label' => 'Razorpay Key ID'],
            ['key' => 'razorpay_secret', 'value' => '', 'type' => 'password', 'group' => 'payment', 'label' => 'Razorpay Secret'],
            ['key' => 'razorpay_mode', 'value' => 'test', 'type' => 'select', 'group' => 'payment', 'label' => 'Razorpay Mode'],
        ];

        foreach ($defaults as $setting) {
            SiteSetting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Default settings created!');
    }
}
