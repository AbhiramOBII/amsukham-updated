<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Fabric;
use App\Models\Product;
use App\Models\SeoSetting;
use App\Models\Work;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'fabric', 'work', 'thumbnail', 'primaryImage.media', 'productColors'])
            ->active();

        if ($request->filled('categories')) {
            $query->whereIn('category_id', explode(',', $request->categories));
        } elseif ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('fabrics')) {
            $query->whereIn('fabric_id', explode(',', $request->fabrics));
        } elseif ($request->filled('fabric')) {
            $query->where('fabric_id', $request->fabric);
        }

        if ($request->filled('work')) {
            $query->where('work_id', $request->work);
        }

        if ($request->filled('colors')) {
            $colorIds = explode(',', $request->colors);
            $query->whereHas('productColors', function ($q) use ($colorIds) {
                $q->whereIn('color_id', $colorIds);
            });
        } elseif ($request->filled('color')) {
            $query->whereHas('productColors', function ($q) use ($request) {
                $q->where('color_id', $request->color);
            });
        }

        if ($request->filled('min_price')) {
            $query->where('discounted_price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('discounted_price', '<=', $request->max_price);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price-low': $query->orderBy('discounted_price', 'asc'); break;
                case 'price-high': $query->orderBy('discounted_price', 'desc'); break;
                case 'newest': $query->latest(); break;
                default: $query->orderBy('is_featured', 'desc')->latest(); break;
            }
        } else {
            $query->orderBy('is_featured', 'desc')->latest();
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.product-grid', compact('products'))->render(),
                'total' => $products->total(),
                'pagination' => $products->appends($request->query())->links()->toHtml(),
            ]);
        }

        $categories = Category::active()->withCount('products')->get();
        $fabrics = Fabric::active()->get();
        $works = Work::active()->get();
        $colors = Color::active()->get();
        $seo = SeoSetting::getForPage('products');

        return view('pages.products', compact('products', 'categories', 'fabrics', 'works', 'colors', 'seo'));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'fabric', 'work', 'thumbnail', 'images.media', 'faqs', 'productColors.color', 'productColors.images.media'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $relatedProducts = Product::with(['thumbnail', 'primaryImage.media'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->take(4)
            ->get();

        // Prepare color data for JS
        $colorData = $product->productColors->map(function($pc) {
            return [
                'id' => $pc->id,
                'color_name' => $pc->color->name,
                'price_adjustment' => (float) $pc->price_adjustment,
                'stock' => (int) $pc->stock,
                'images' => $pc->images->map(function($img) {
                    return ['url' => $img->media->url];
                })->toArray()
            ];
        })->values();

        return view('pages.product-show', compact('product', 'relatedProducts', 'colorData'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->active()->firstOrFail();

        $products = Product::with(['thumbnail', 'primaryImage.media'])
            ->where('category_id', $category->id)
            ->active()
            ->paginate(12);

        return view('pages.category', compact('category', 'products'));
    }
}
