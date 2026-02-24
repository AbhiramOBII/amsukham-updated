<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SeoSetting;

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

        $seo = SeoSetting::getForPage('home');

        return view('pages.home', compact('featuredProducts', 'latestProducts', 'categories', 'seo'));
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
