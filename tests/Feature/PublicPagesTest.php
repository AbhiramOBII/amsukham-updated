<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_about_page_loads(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
    }

    public function test_contact_page_loads(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
    }

    public function test_terms_page_loads(): void
    {
        $response = $this->get('/terms-of-service');

        $response->assertStatus(200);
    }

    public function test_privacy_page_loads(): void
    {
        $response = $this->get('/privacy-policy');

        $response->assertStatus(200);
    }

    public function test_return_policy_page_loads(): void
    {
        $response = $this->get('/return-policy');

        $response->assertStatus(200);
    }

    public function test_products_page_loads(): void
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
    }

    public function test_product_show_page_loads(): void
    {
        $category = Category::create(['name' => 'Sarees', 'slug' => 'sarees', 'is_active' => true]);
        $product = Product::create([
            'name' => 'Test Saree',
            'slug' => 'test-saree',
            'category_id' => $category->id,
            'price' => 5000,
            'stock' => 10,
            'is_active' => true,
        ]);

        $response = $this->get('/product/test-saree');

        $response->assertStatus(200);
        $response->assertSee('Test Saree');
    }

    public function test_inactive_product_returns_404(): void
    {
        $category = Category::create(['name' => 'Sarees', 'slug' => 'sarees', 'is_active' => true]);
        Product::create([
            'name' => 'Hidden Saree',
            'slug' => 'hidden-saree',
            'category_id' => $category->id,
            'price' => 5000,
            'is_active' => false,
        ]);

        $response = $this->get('/product/hidden-saree');

        $response->assertStatus(404);
    }

    public function test_latest_collections_page_loads(): void
    {
        $response = $this->get('/latest-collections');

        $response->assertStatus(200);
    }
}
