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
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|size:10|regex:/^[6-9][0-9]{9}$/',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ], [
            'name.regex' => 'Name should contain only letters and spaces.',
            // 'phone.regex' => 'Phone number must start with 6,7, 8, or 9 and be 10 digits..',
            'phone.size' => 'Phone number must be exactly 10 digits.',
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
}
