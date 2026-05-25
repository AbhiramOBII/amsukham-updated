<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
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

    public function test_can_create_product(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'name' => 'New Silk Saree',
            'category_id' => $this->category->id,
            'price' => 6000,
            'discount' => 10,
            'stock' => 5,
            'is_active' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('products', ['name' => 'New Silk Saree']);
    }

    public function test_create_product_requires_name_and_price(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.products.store'), [
            'category_id' => $this->category->id,
        ]);

        $response->assertSessionHasErrors(['name', 'price']);
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

    public function test_guest_cannot_access_products(): void
    {
        $response = $this->get(route('admin.products.index'));

        $response->assertRedirect(route('admin.login'));
    }
}
