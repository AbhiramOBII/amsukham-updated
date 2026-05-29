<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Fabric;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductColorImage;
use App\Models\ProductFaq;
use App\Models\ProductImage;
use App\Models\Work;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'fabric', 'work', 'thumbnail', 'primaryImage.media'])
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        $fabrics = Fabric::active()->get();
        $works = Work::active()->get();
        $colors = Color::active()->get();

        return view('admin.products.create', compact('categories', 'fabrics', 'works', 'colors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products',
            'sku' => 'nullable|string|max:255|unique:products',
            'category_id' => 'required|exists:categories,id',
            'fabric_id' => 'nullable|exists:fabrics,id',
            'work_id' => 'nullable|exists:works,id',
            'length' => 'nullable|string|max:255',
            'blouse_length' => 'nullable|string|max:255',
            'with_blouse' => 'boolean',
            'short_description' => 'nullable|string|max:65000',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'discount' => 'nullable|numeric|min:0|max:100',
            'stock' => 'nullable|integer|min:0|max:4294967295',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:65000',
            'meta_keywords' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'thumbnail_id' => 'nullable|exists:media,id',
            'images' => 'nullable|array',
            'images.*' => 'exists:media,id',
            'primary_image' => 'nullable|exists:media,id',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'nullable|string',
            'faqs.*.answer' => 'nullable|string',
        ], [
            'name.required' => 'Product name is required.',
            'name.max' => 'Product name cannot exceed 255 characters.',
            'slug.max' => 'Slug cannot exceed 255 characters.',
            'slug.unique' => 'This slug is already in use by another product.',
            'sku.max' => 'SKU cannot exceed 255 characters.',
            'sku.unique' => 'This SKU is already in use by another product.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category does not exist.',
            'fabric_id.exists' => 'The selected fabric does not exist.',
            'work_id.exists' => 'The selected work type does not exist.',
            'length.max' => 'Length cannot exceed 255 characters.',
            'blouse_length.max' => 'Blouse length cannot exceed 255 characters.',
            'short_description.max' => 'Short description is too long (max 65,000 characters).',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price cannot be negative.',
            'price.max' => 'Price cannot exceed 99,999,999.99.',
            'discount.numeric' => 'Discount must be a valid number.',
            'discount.min' => 'Discount cannot be negative.',
            'discount.max' => 'Discount cannot exceed 100%.',
            'stock.integer' => 'Stock must be a whole number.',
            'stock.min' => 'Stock cannot be negative.',
            'stock.max' => 'Stock value is too large.',
            'meta_title.max' => 'Meta title cannot exceed 255 characters.',
            'meta_description.max' => 'Meta description is too long (max 65,000 characters).',
            'meta_keywords.max' => 'Meta keywords cannot exceed 255 characters.',
            'thumbnail_id.exists' => 'The selected thumbnail image does not exist.',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = $this->generateUniqueSlug($validated['name']);
        }

        $validated['with_blouse'] = $request->has('with_blouse');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['discount'] = $validated['discount'] ?? 0;
        $validated['stock'] = $validated['stock'] ?? 0;
        $validated['thumbnail_id'] = $request->input('thumbnail_id') ?: null;

        try {
            $product = Product::create($validated);

            if ($request->filled('product_images') && is_array($request->product_images)) {
                foreach ($request->product_images as $index => $mediaId) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'media_id' => $mediaId,
                        'is_primary' => $index === 0,
                        'sort_order' => $index,
                    ]);
                }
            }

            if (!empty($request->faqs)) {
                foreach ($request->faqs as $index => $faq) {
                    if (!empty($faq['question']) && !empty($faq['answer'])) {
                        ProductFaq::create([
                            'product_id' => $product->id,
                            'question' => $faq['question'],
                            'answer' => $faq['answer'],
                            'sort_order' => $index,
                        ]);
                    }
                }
            }

            // Handle product colors
            if (!empty($request->product_colors)) {
                foreach ($request->product_colors as $colorData) {
                    if (empty($colorData['color_id'])) continue;

                    $color = Color::find($colorData['color_id']);
                    $sku = $this->generateSku($product, $color);

                    $productColor = ProductColor::create([
                        'product_id' => $product->id,
                        'color_id' => $colorData['color_id'],
                        'sku' => $sku,
                        'stock' => $colorData['stock'] ?? 0,
                        'price_adjustment' => $colorData['price_adjustment'] ?? 0,
                    ]);

                    if (!empty($colorData['images'])) {
                        foreach ($colorData['images'] as $index => $mediaId) {
                            ProductColorImage::create([
                                'product_color_id' => $productColor->id,
                                'media_id' => $mediaId,
                                'is_primary' => $index === 0,
                                'sort_order' => $index,
                            ]);
                        }
                    }
                }
            }
        } catch (UniqueConstraintViolationException $e) {
            return back()->withInput()->with('error', 'A product with this slug or SKU already exists. Please use a different name or SKU.');
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    private function generateSku(Product $product, Color $color): string
    {
        $categoryCode = $product->category ? strtoupper(substr($product->category->name, 0, 3)) : 'PRD';
        $colorCode = strtoupper(substr($color->name, 0, 3));
        $uniqueId = str_pad($product->id, 4, '0', STR_PAD_LEFT);
        $colorId = str_pad($color->id, 2, '0', STR_PAD_LEFT);

        return $categoryCode . '-' . $colorCode . '-' . $uniqueId . $colorId;
    }

    public function edit(Product $product)
    {
        $product->load(['images.media', 'faqs', 'productColors.color', 'productColors.images.media', 'thumbnail']);
        $categories = Category::active()->get();
        $fabrics = Fabric::active()->get();
        $works = Work::active()->get();
        $colors = Color::active()->get();

        // Prepare product images data
        $productImagesData = $product->images->sortBy('sort_order')->map(function ($img) {
            return [
                'id' => $img->media_id,
                'url' => $img->media->url
            ];
        })->values()->toArray();

        // Prepare product colors data
        $productColors = $product->productColors->map(function ($pc) {
            return [
                'color_id' => $pc->color_id,
                'stock' => $pc->stock,
                'price_adjustment' => $pc->price_adjustment,
                'images' => $pc->images->map(function ($img) {
                    return [
                        'id' => $img->media_id,
                        'url' => $img->media->url
                    ];
                })->toArray()
            ];
        });

        return view('admin.products.edit', compact('product', 'categories', 'fabrics', 'works', 'colors', 'productImagesData', 'productColors'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'fabric_id' => 'nullable|exists:fabrics,id',
            'work_id' => 'nullable|exists:works,id',
            'length' => 'nullable|string|max:255',
            'blouse_length' => 'nullable|string|max:255',
            'with_blouse' => 'boolean',
            'short_description' => 'nullable|string|max:65000',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'discount' => 'nullable|numeric|min:0|max:100',
            'stock' => 'nullable|integer|min:0|max:4294967295',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:65000',
            'meta_keywords' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'thumbnail_id' => 'nullable|exists:media,id',
            'product_images' => 'nullable|array',
            'product_images.*' => 'exists:media,id',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'nullable|string',
            'faqs.*.answer' => 'nullable|string',
        ], [
            'name.required' => 'Product name is required.',
            'name.max' => 'Product name cannot exceed 255 characters.',
            'slug.max' => 'Slug cannot exceed 255 characters.',
            'slug.unique' => 'This slug is already in use by another product.',
            'sku.max' => 'SKU cannot exceed 255 characters.',
            'sku.unique' => 'This SKU is already in use by another product.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category does not exist.',
            'fabric_id.exists' => 'The selected fabric does not exist.',
            'work_id.exists' => 'The selected work type does not exist.',
            'length.max' => 'Length cannot exceed 255 characters.',
            'blouse_length.max' => 'Blouse length cannot exceed 255 characters.',
            'short_description.max' => 'Short description is too long (max 65,000 characters).',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price cannot be negative.',
            'price.max' => 'Price cannot exceed 99,999,999.99.',
            'discount.numeric' => 'Discount must be a valid number.',
            'discount.min' => 'Discount cannot be negative.',
            'discount.max' => 'Discount cannot exceed 100%.',
            'stock.integer' => 'Stock must be a whole number.',
            'stock.min' => 'Stock cannot be negative.',
            'stock.max' => 'Stock value is too large.',
            'meta_title.max' => 'Meta title cannot exceed 255 characters.',
            'meta_description.max' => 'Meta description is too long (max 65,000 characters).',
            'meta_keywords.max' => 'Meta keywords cannot exceed 255 characters.',
            'thumbnail_id.exists' => 'The selected thumbnail image does not exist.',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = $this->generateUniqueSlug($validated['name'], $product->id);
        }

        $validated['with_blouse'] = $request->has('with_blouse');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['discount'] = $validated['discount'] ?? 0;
        $validated['stock'] = $validated['stock'] ?? 0;
        $validated['thumbnail_id'] = $request->input('thumbnail_id') ?: null;

        try {
            $product->update($validated);

            $product->images()->delete();
            if ($request->filled('product_images') && is_array($request->product_images)) {
                foreach ($request->product_images as $index => $mediaId) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'media_id' => $mediaId,
                        'is_primary' => $index === 0,
                        'sort_order' => $index,
                    ]);
                }
            }

            $product->faqs()->delete();
            if (!empty($request->faqs)) {
                foreach ($request->faqs as $index => $faq) {
                    if (!empty($faq['question']) && !empty($faq['answer'])) {
                        ProductFaq::create([
                            'product_id' => $product->id,
                            'question' => $faq['question'],
                            'answer' => $faq['answer'],
                            'sort_order' => $index,
                        ]);
                    }
                }
            }

            // Handle product colors
            foreach ($product->productColors as $pc) {
                $pc->images()->delete();
            }
            $product->productColors()->delete();

            if (!empty($request->product_colors)) {
                foreach ($request->product_colors as $colorData) {
                    if (empty($colorData['color_id'])) continue;

                    $color = Color::find($colorData['color_id']);
                    $sku = $this->generateSku($product, $color);

                    $productColor = ProductColor::create([
                        'product_id' => $product->id,
                        'color_id' => $colorData['color_id'],
                        'sku' => $sku,
                        'stock' => $colorData['stock'] ?? 0,
                        'price_adjustment' => $colorData['price_adjustment'] ?? 0,
                    ]);

                    if (!empty($colorData['images'])) {
                        foreach ($colorData['images'] as $index => $mediaId) {
                            ProductColorImage::create([
                                'product_color_id' => $productColor->id,
                                'media_id' => $mediaId,
                                'is_primary' => $index === 0,
                                'sort_order' => $index,
                            ]);
                        }
                    }
                }
            }
        } catch (UniqueConstraintViolationException $e) {
            return back()->withInput()->with('error', 'A product with this slug or SKU already exists. Please use a different name or SKU.');
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    private function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $counter = 2;

        while (Product::where('slug', $slug)->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))->exists()) {
            $slug = $original . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function destroy(Product $product)
    {
        $product->images()->delete();
        $product->faqs()->delete();
        foreach ($product->productColors as $pc) {
            $pc->images()->delete();
        }
        $product->productColors()->delete();
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
