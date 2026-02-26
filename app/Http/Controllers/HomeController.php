<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\ContactSubmission;
use App\Models\Product;
use App\Models\SeoSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['primaryImage.media', 'category', 'productColors'])
            ->active()
            ->featured()
            ->take(8)
            ->get();

        $latestProducts = Product::with(['primaryImage.media', 'category', 'productColors'])
            ->active()
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::with('image')
            ->active()
            ->withCount('products')
            ->take(6)
            ->get();

        $banners = Banner::with(['image', 'mobileImage'])
            ->active()
            ->ordered()
            ->get();

        $seo = SeoSetting::getForPage('home');

        return view('pages.home', compact('featuredProducts', 'latestProducts', 'categories', 'banners', 'seo'));
    }

    public function about()
    {
        $seo = SeoSetting::getForPage('about');
        return view('pages.about', compact('seo'));
    }

    public function contact()
    {
        $seo = SeoSetting::getForPage('contact');
        return view('pages.contact', compact('seo'));
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactSubmission::create($validated);

        return redirect()->route('contact')->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    public function latestCollections()
    {
        $categories = Category::with('image')
            ->active()
            ->withCount('products')
            ->get();

        $seo = SeoSetting::getForPage('latest-collections');

        return view('pages.latest-collections', compact('categories', 'seo'));
    }

    public function terms()
    {
        $seo = SeoSetting::getForPage('terms');
        return view('pages.terms', compact('seo'));
    }

    public function privacy()
    {
        $seo = SeoSetting::getForPage('privacy');
        return view('pages.privacy', compact('seo'));
    }

    public function returnPolicy()
    {
        $seo = SeoSetting::getForPage('return-policy');
        return view('pages.return-policy', compact('seo'));
    }
}
