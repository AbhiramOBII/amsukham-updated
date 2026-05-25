<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_created(): void
    {
        $category = Category::create(['name' => 'Silk Sarees', 'is_active' => true]);

        $this->assertDatabaseHas('categories', ['name' => 'Silk Sarees']);
        $this->assertEquals('silk-sarees', $category->slug);
    }

    public function test_slug_auto_generated(): void
    {
        $category = Category::create(['name' => 'Cotton Sarees', 'is_active' => true]);

        $this->assertEquals('cotton-sarees', $category->slug);
    }

    public function test_active_scope(): void
    {
        Category::create(['name' => 'Active', 'slug' => 'active', 'is_active' => true]);
        Category::create(['name' => 'Inactive', 'slug' => 'inactive', 'is_active' => false]);

        $this->assertCount(1, Category::active()->get());
    }

    public function test_products_relationship(): void
    {
        $category = Category::create(['name' => 'Test', 'slug' => 'test', 'is_active' => true]);

        $this->assertCount(0, $category->products);
    }
}
