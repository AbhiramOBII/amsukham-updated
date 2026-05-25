<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Fabric;
use App\Models\Media;
use App\Models\Product;
use App\Models\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private function createProduct(array $overrides = []): Product
    {
        $category = Category::firstOrCreate(
            ['slug' => 'sarees'],
            ['name' => 'Sarees', 'is_active' => true]
        );

        return Product::create(array_merge([
            'name' => 'Test Saree',
            'slug' => 'test-saree-' . uniqid(),
            'category_id' => $category->id,
            'price' => 5000,
            'discount' => 0,
            'stock' => 10,
            'is_active' => true,
            'is_featured' => false,
        ], $overrides));
    }

    public function test_product_can_be_created(): void
    {
        $product = $this->createProduct();

        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Test Saree']);
        $this->assertEquals(5000, $product->price);
    }

    public function test_slug_is_auto_generated(): void
    {
        $category = Category::create(['name' => 'Sarees', 'slug' => 'sarees', 'is_active' => true]);
        $product = Product::create([
            'name' => 'Beautiful Kanjivaram Silk',
            'category_id' => $category->id,
            'price' => 8000,
        ]);

        $this->assertEquals('beautiful-kanjivaram-silk', $product->slug);
    }

    public function test_discounted_price_calculated_on_create(): void
    {
        $product = $this->createProduct(['price' => 5000, 'discount' => 10]);

        $this->assertEquals(4500, $product->discounted_price);
    }

    public function test_discounted_price_rounds_to_whole_number(): void
    {
        $product = $this->createProduct(['price' => 4999, 'discount' => 10]);

        // 4999 - (4999 * 10 / 100) = 4999 - 499.9 = 4499.1 → rounds to 4499
        $this->assertEquals(4499, $product->discounted_price);
    }

    public function test_discounted_price_equals_price_when_no_discount(): void
    {
        $product = $this->createProduct(['price' => 5000, 'discount' => 0]);

        $this->assertEquals(5000, $product->discounted_price);
    }

    public function test_discounted_price_recalculated_on_update(): void
    {
        $product = $this->createProduct(['price' => 5000, 'discount' => 0]);
        $this->assertEquals(5000, $product->discounted_price);

        $product->update(['discount' => 20]);
        $this->assertEquals(4000, $product->fresh()->discounted_price);
    }

    public function test_display_price_attribute(): void
    {
        $product = $this->createProduct(['price' => 5000, 'discount' => 10]);

        $this->assertEquals($product->discounted_price, $product->display_price);
    }

    public function test_active_scope(): void
    {
        $this->createProduct(['name' => 'Active', 'slug' => 'active', 'is_active' => true]);
        $this->createProduct(['name' => 'Inactive', 'slug' => 'inactive', 'is_active' => false]);

        $active = Product::active()->get();
        $this->assertCount(1, $active);
        $this->assertEquals('Active', $active->first()->name);
    }

    public function test_featured_scope(): void
    {
        $this->createProduct(['name' => 'Featured', 'slug' => 'featured', 'is_featured' => true]);
        $this->createProduct(['name' => 'Normal', 'slug' => 'normal', 'is_featured' => false]);

        $featured = Product::featured()->get();
        $this->assertCount(1, $featured);
        $this->assertEquals('Featured', $featured->first()->name);
    }

    public function test_category_relationship(): void
    {
        $product = $this->createProduct();

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals('Sarees', $product->category->name);
    }

    public function test_fabric_relationship(): void
    {
        $fabric = Fabric::create(['name' => 'Silk', 'slug' => 'silk', 'is_active' => true]);
        $product = $this->createProduct(['fabric_id' => $fabric->id]);

        $this->assertInstanceOf(Fabric::class, $product->fabric);
        $this->assertEquals('Silk', $product->fabric->name);
    }

    public function test_thumbnail_relationship(): void
    {
        $media = Media::create([
            'name' => 'thumb',
            'file_name' => 'thumb.jpg',
            'path' => 'uploads/thumb.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1024,
            'disk' => 'public',
        ]);
        $product = $this->createProduct(['thumbnail_id' => $media->id]);

        $this->assertInstanceOf(Media::class, $product->thumbnail);
        $this->assertEquals('thumb.jpg', $product->thumbnail->file_name);
    }
}
