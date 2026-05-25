<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
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

    public function test_settings_page_loads(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.settings.index'));

        $response->assertStatus(200);
    }

    public function test_seed_creates_default_settings(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.settings.seed'));

        $response->assertRedirect(route('admin.settings.index'));
        $this->assertDatabaseHas('site_settings', ['key' => 'site_name']);
        $this->assertDatabaseHas('site_settings', ['key' => 'razorpay_key']);
        $this->assertDatabaseHas('site_settings', ['key' => 'razorpay_mode']);
    }

    public function test_can_update_settings(): void
    {
        SiteSetting::set('site_name', 'Old Name', 'text', 'general', 'Site Name');

        $response = $this->actingAs($this->admin, 'admin')
            ->put(route('admin.settings.update'), [
                'site_name' => 'Amsukham by Ram',
            ]);

        $response->assertRedirect(route('admin.settings.index'));
        $this->assertEquals('Amsukham by Ram', SiteSetting::where('key', 'site_name')->first()->value);
    }

    public function test_guest_cannot_access_settings(): void
    {
        $response = $this->get(route('admin.settings.index'));

        $response->assertRedirect(route('admin.login'));
    }
}
