<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_categories_index_loads(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.categories.index'));

        $response->assertStatus(200);
    }

    public function test_category_create_form_loads(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.categories.create'));

        $response->assertStatus(200);
    }

    public function test_can_create_category(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.categories.store'), [
            'name' => 'Silk Sarees',
            'is_active' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', ['name' => 'Silk Sarees']);
    }

    public function test_create_category_requires_name(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.categories.store'), [
            'is_active' => 1,
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_can_update_category(): void
    {
        $category = Category::create(['name' => 'Old Name', 'slug' => 'old-name', 'is_active' => true]);

        $response = $this->actingAs($this->admin, 'admin')->put(route('admin.categories.update', $category), [
            'name' => 'New Name',
            'is_active' => 1,
        ]);

        $response->assertRedirect();
        $this->assertEquals('New Name', $category->fresh()->name);
    }

    public function test_can_delete_category(): void
    {
        $category = Category::create(['name' => 'Delete Me', 'slug' => 'delete-me', 'is_active' => true]);

        $response = $this->actingAs($this->admin, 'admin')->delete(route('admin.categories.destroy', $category));

        $response->assertRedirect();
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_guest_cannot_access_categories(): void
    {
        $response = $this->get(route('admin.categories.index'));

        $response->assertRedirect(route('admin.login'));
    }
}
