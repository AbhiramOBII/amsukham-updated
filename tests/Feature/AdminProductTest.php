<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Color;
use App\Models\Fabric;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductFaq;
use App\Models\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->category = Category::create(['name' => 'Sarees', 'slug' => 'sarees', 'is_active' => true]);
    }

    // ── Page Load Tests ──────────────────────────────────────────────

    public function test_products_index_loads(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.products.index'));

        $response->assertStatus(200);
    }

    public function test_product_create_form_loads(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.products.create'));

        $response->assertStatus(200);
    }

    public function test_product_edit_form_loads(): void
    {
        $product = Product::create([
            'name' => 'Edit Me',
            'slug' => 'edit-me',
            'category_id' => $this->category->id,
            'price' => 5000,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.products.edit', $product));

        $response->assertStatus(200);
        $response->assertSee('Edit Me');
    }

    public function test_guest_cannot_access_products(): void
    {
        $response = $this->get(route('admin.products.index'));

        $response->assertRedirect(route('admin.login'));
    }

    // ── Basic Create Tests ───────────────────────────────────────────

    public function test_can_create_product_with_minimum_fields(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Basic Saree',
            'category_id' => $this->category->id,
            'price' => 3000,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('products', [
            'name' => 'Basic Saree',
            'price' => 3000,
            'stock' => 0,
            'discount' => 0,
            'is_active' => false, // checkbox not sent = false
        ]);
    }

    public function test_can_create_product_with_all_fields(): void
    {
        $fabric = Fabric::create(['name' => 'Silk', 'slug' => 'silk', 'is_active' => true]);
        $work = Work::create(['name' => 'Zari', 'slug' => 'zari', 'is_active' => true]);

        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Full Silk Saree',
            'slug' => 'full-silk-saree',
            'sku' => 'FSS-001',
            'category_id' => $this->category->id,
            'fabric_id' => $fabric->id,
            'work_id' => $work->id,
            'length' => '5.5 meters',
            'blouse_length' => '0.8 meters',
            'with_blouse' => 1,
            'short_description' => 'A beautiful silk saree',
            'description' => '<p>Full description here</p>',
            'price' => 6000,
            'discount' => 10,
            'stock' => 50,
            'meta_title' => 'Full Silk Saree - Amsukham',
            'meta_description' => 'Buy silk saree online',
            'meta_keywords' => 'silk, saree',
            'is_featured' => 1,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $product = Product::where('slug', 'full-silk-saree')->first();
        $this->assertNotNull($product);
        $this->assertEquals('FSS-001', $product->sku);
        $this->assertEquals($fabric->id, $product->fabric_id);
        $this->assertEquals($work->id, $product->work_id);
        $this->assertEquals('5.5 meters', $product->length);
        $this->assertTrue($product->with_blouse);
        $this->assertTrue($product->is_featured);
        $this->assertTrue($product->is_active);
        $this->assertEquals(50, $product->stock);
    }

    // ── Slug Auto-generation ─────────────────────────────────────────

    public function test_slug_is_auto_generated_from_name(): void
    {
        $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'My Beautiful Saree',
            'category_id' => $this->category->id,
            'price' => 5000,
        ]);

        $this->assertDatabaseHas('products', ['slug' => 'my-beautiful-saree']);
    }

    public function test_duplicate_name_generates_unique_slug(): void
    {
        $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Dupion Silk',
            'category_id' => $this->category->id,
            'price' => 5000,
        ]);

        $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Dupion Silk',
            'category_id' => $this->category->id,
            'price' => 2350,
            'discount' => 10,
        ]);

        $products = Product::where('name', 'Dupion Silk')->get();
        $this->assertCount(2, $products);
        $this->assertDatabaseHas('products', ['slug' => 'dupion-silk']);
        $this->assertDatabaseHas('products', ['slug' => 'dupion-silk-2']);
    }

    public function test_custom_slug_is_preserved(): void
    {
        $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'My Beautiful Saree',
            'slug' => 'custom-slug-here',
            'category_id' => $this->category->id,
            'price' => 5000,
        ]);

        $this->assertDatabaseHas('products', ['slug' => 'custom-slug-here']);
    }

    // ── Discounted Price Calculation ─────────────────────────────────

    public function test_discounted_price_is_calculated_on_create(): void
    {
        $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Discount Saree',
            'category_id' => $this->category->id,
            'price' => 10000,
            'discount' => 20,
        ]);

        $product = Product::where('name', 'Discount Saree')->first();
        $this->assertEquals(8000, $product->discounted_price);
    }

    public function test_discounted_price_equals_price_when_no_discount(): void
    {
        $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'No Discount Saree',
            'category_id' => $this->category->id,
            'price' => 5000,
            'discount' => 0,
        ]);

        $product = Product::where('name', 'No Discount Saree')->first();
        $this->assertEquals(5000, $product->discounted_price);
    }

    // ── Validation Tests ─────────────────────────────────────────────

    public function test_create_product_requires_name_and_price(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'category_id' => $this->category->id,
        ]);

        $response->assertSessionHasErrors(['name', 'price']);
    }

    public function test_create_product_requires_category(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'No Category Saree',
            'price' => 5000,
        ]);

        $response->assertSessionHasErrors(['category_id']);
    }

    public function test_create_product_rejects_negative_price(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Negative Price',
            'category_id' => $this->category->id,
            'price' => -100,
        ]);

        $response->assertSessionHasErrors(['price']);
    }

    public function test_create_product_rejects_discount_over_100(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Over Discount',
            'category_id' => $this->category->id,
            'price' => 5000,
            'discount' => 150,
        ]);

        $response->assertSessionHasErrors(['discount']);
    }

    public function test_create_product_rejects_duplicate_slug(): void
    {
        Product::create([
            'name' => 'Existing',
            'slug' => 'existing-slug',
            'category_id' => $this->category->id,
            'price' => 5000,
        ]);

        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Another Product',
            'slug' => 'existing-slug',
            'category_id' => $this->category->id,
            'price' => 5000,
        ]);

        $response->assertSessionHasErrors(['slug']);
    }

    public function test_create_product_rejects_duplicate_sku(): void
    {
        Product::create([
            'name' => 'Existing',
            'slug' => 'existing',
            'sku' => 'SKU-001',
            'category_id' => $this->category->id,
            'price' => 5000,
        ]);

        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Another Product',
            'sku' => 'SKU-001',
            'category_id' => $this->category->id,
            'price' => 5000,
        ]);

        $response->assertSessionHasErrors(['sku']);
    }

    public function test_create_product_rejects_invalid_category(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Bad Category',
            'category_id' => 9999,
            'price' => 5000,
        ]);

        $response->assertSessionHasErrors(['category_id']);
    }

    // ── Color Variants Tests ─────────────────────────────────────────

    public function test_can_create_product_with_color_variants(): void
    {
        $color = Color::create(['name' => 'Red', 'slug' => 'red', 'hex_code' => '#FF0000', 'is_active' => true]);

        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Colored Saree',
            'category_id' => $this->category->id,
            'price' => 5000,
            'product_colors' => [
                [
                    'color_id' => $color->id,
                    'stock' => 10,
                    'price_adjustment' => 500,
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $product = Product::where('name', 'Colored Saree')->first();
        $this->assertNotNull($product);
        $this->assertCount(1, $product->productColors);

        $pc = $product->productColors->first();
        $this->assertEquals($color->id, $pc->color_id);
        $this->assertEquals(10, $pc->stock);
        $this->assertEquals(500, $pc->price_adjustment);
        $this->assertNotEmpty($pc->sku);
    }

    public function test_can_create_product_with_multiple_color_variants(): void
    {
        $red = Color::create(['name' => 'Red', 'slug' => 'red', 'hex_code' => '#FF0000', 'is_active' => true]);
        $blue = Color::create(['name' => 'Blue', 'slug' => 'blue', 'hex_code' => '#0000FF', 'is_active' => true]);

        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Multi Color Saree',
            'category_id' => $this->category->id,
            'price' => 5000,
            'product_colors' => [
                ['color_id' => $red->id, 'stock' => 5, 'price_adjustment' => 0],
                ['color_id' => $blue->id, 'stock' => 8, 'price_adjustment' => 200],
            ],
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $product = Product::where('name', 'Multi Color Saree')->first();
        $this->assertCount(2, $product->productColors);
    }

    public function test_color_variant_with_empty_color_id_is_skipped(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Skip Empty Color',
            'category_id' => $this->category->id,
            'price' => 5000,
            'product_colors' => [
                ['color_id' => '', 'stock' => 5, 'price_adjustment' => 0],
            ],
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $product = Product::where('name', 'Skip Empty Color')->first();
        $this->assertCount(0, $product->productColors);
    }

    // ── FAQs Tests ───────────────────────────────────────────────────

    public function test_can_create_product_with_faqs(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'FAQ Saree',
            'category_id' => $this->category->id,
            'price' => 5000,
            'faqs' => [
                ['question' => 'What is the material?', 'answer' => 'Pure silk'],
                ['question' => 'Is blouse included?', 'answer' => 'Yes'],
            ],
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $product = Product::where('name', 'FAQ Saree')->first();
        $this->assertCount(2, $product->faqs);
        $this->assertEquals('What is the material?', $product->faqs[0]->question);
    }

    public function test_empty_faq_entries_are_skipped(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Empty FAQ Saree',
            'category_id' => $this->category->id,
            'price' => 5000,
            'faqs' => [
                ['question' => '', 'answer' => ''],
                ['question' => 'Valid Q?', 'answer' => 'Valid A'],
            ],
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $product = Product::where('name', 'Empty FAQ Saree')->first();
        $this->assertCount(1, $product->faqs);
    }

    // ── Product Images Tests ─────────────────────────────────────────

    public function test_can_create_product_with_gallery_images(): void
    {
        $media1 = Media::create(['name' => 'img1', 'file_name' => 'img1.jpg', 'path' => 'images/img1.jpg', 'disk' => 'public', 'mime_type' => 'image/jpeg', 'size' => 1024]);
        $media2 = Media::create(['name' => 'img2', 'file_name' => 'img2.jpg', 'path' => 'images/img2.jpg', 'disk' => 'public', 'mime_type' => 'image/jpeg', 'size' => 1024]);

        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Gallery Saree',
            'category_id' => $this->category->id,
            'price' => 5000,
            'product_images' => [$media1->id, $media2->id],
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $product = Product::where('name', 'Gallery Saree')->first();
        $this->assertCount(2, $product->images);
        $this->assertTrue($product->images->first()->is_primary);
    }

    public function test_can_create_product_with_thumbnail(): void
    {
        $media = Media::create(['name' => 'thumb', 'file_name' => 'thumb.jpg', 'path' => 'images/thumb.jpg', 'disk' => 'public', 'mime_type' => 'image/jpeg', 'size' => 512]);

        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'Thumb Saree',
            'category_id' => $this->category->id,
            'price' => 5000,
            'thumbnail_id' => $media->id,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $product = Product::where('name', 'Thumb Saree')->first();
        $this->assertEquals($media->id, $product->thumbnail_id);
    }

    // ── Update Tests ─────────────────────────────────────────────────

    public function test_can_update_product(): void
    {
        $product = Product::create([
            'name' => 'Old Name',
            'slug' => 'old-name',
            'category_id' => $this->category->id,
            'price' => 5000,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin, 'admin')->put(route('admin.products.update', $product), [
            'name' => 'Updated Saree',
            'category_id' => $this->category->id,
            'price' => 7000,
            'discount' => 5,
            'is_active' => 1,
        ]);

        $response->assertRedirect();
        $this->assertEquals('Updated Saree', $product->fresh()->name);
        $this->assertEquals(7000, $product->fresh()->price);
    }

    public function test_update_recalculates_discounted_price(): void
    {
        $product = Product::create([
            'name' => 'Recalc',
            'slug' => 'recalc',
            'category_id' => $this->category->id,
            'price' => 10000,
            'discount' => 0,
            'is_active' => true,
        ]);

        $this->assertEquals(10000, $product->discounted_price);

        $this->actingAs($this->admin, 'admin')->put(route('admin.products.update', $product), [
            'name' => 'Recalc',
            'category_id' => $this->category->id,
            'price' => 10000,
            'discount' => 25,
            'is_active' => 1,
        ]);

        $this->assertEquals(7500, $product->fresh()->discounted_price);
    }

    public function test_update_replaces_color_variants(): void
    {
        $red = Color::create(['name' => 'Red', 'slug' => 'red', 'hex_code' => '#FF0000', 'is_active' => true]);
        $blue = Color::create(['name' => 'Blue', 'slug' => 'blue', 'hex_code' => '#0000FF', 'is_active' => true]);

        $product = Product::create([
            'name' => 'Color Update',
            'slug' => 'color-update',
            'category_id' => $this->category->id,
            'price' => 5000,
            'is_active' => true,
        ]);

        ProductColor::create(['product_id' => $product->id, 'color_id' => $red->id, 'sku' => 'SAR-RED-00010', 'stock' => 5, 'price_adjustment' => 0]);

        $this->actingAs($this->admin, 'admin')->put(route('admin.products.update', $product), [
            'name' => 'Color Update',
            'category_id' => $this->category->id,
            'price' => 5000,
            'is_active' => 1,
            'product_colors' => [
                ['color_id' => $blue->id, 'stock' => 10, 'price_adjustment' => 200],
            ],
        ]);

        $product->refresh();
        $this->assertCount(1, $product->productColors);
        $this->assertEquals($blue->id, $product->productColors->first()->color_id);
    }

    // ── Delete Tests ─────────────────────────────────────────────────

    public function test_can_delete_product(): void
    {
        $product = Product::create([
            'name' => 'Delete Me',
            'slug' => 'delete-me',
            'category_id' => $this->category->id,
            'price' => 5000,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin, 'admin')->delete(route('admin.products.destroy', $product));

        $response->assertRedirect();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    // ── Boolean Checkbox Handling ────────────────────────────────────

    public function test_checkboxes_default_false_when_not_sent(): void
    {
        $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'No Checkboxes',
            'category_id' => $this->category->id,
            'price' => 5000,
        ]);

        $product = Product::where('name', 'No Checkboxes')->first();
        $this->assertFalse($product->is_active);
        $this->assertFalse($product->is_featured);
        $this->assertFalse($product->with_blouse);
    }

    public function test_checkboxes_true_when_sent(): void
    {
        $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'All Checkboxes',
            'category_id' => $this->category->id,
            'price' => 5000,
            'is_active' => 1,
            'is_featured' => 1,
            'with_blouse' => 1,
        ]);

        $product = Product::where('name', 'All Checkboxes')->first();
        $this->assertTrue($product->is_active);
        $this->assertTrue($product->is_featured);
        $this->assertTrue($product->with_blouse);
    }

    // ── SKU Auto-generation for Colors ───────────────────────────────

    public function test_color_sku_is_auto_generated(): void
    {
        $color = Color::create(['name' => 'Red', 'slug' => 'red', 'hex_code' => '#FF0000', 'is_active' => true]);

        $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'SKU Test',
            'category_id' => $this->category->id,
            'price' => 5000,
            'product_colors' => [
                ['color_id' => $color->id, 'stock' => 5, 'price_adjustment' => 0],
            ],
        ]);

        $product = Product::where('name', 'SKU Test')->first();
        $pc = $product->productColors->first();
        $this->assertNotEmpty($pc->sku);
        $this->assertStringContainsString('SAR', $pc->sku); // Category prefix
        $this->assertStringContainsString('RED', $pc->sku); // Color prefix
    }
}
