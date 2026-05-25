<?php

namespace Tests\Unit;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_set_and_get_setting(): void
    {
        SiteSetting::set('test_key', 'test_value');

        $this->assertEquals('test_value', SiteSetting::get('test_key'));
    }

    public function test_get_returns_default_when_not_found(): void
    {
        $this->assertEquals('fallback', SiteSetting::get('nonexistent', 'fallback'));
    }

    public function test_set_updates_existing_setting(): void
    {
        SiteSetting::set('test_key', 'original');
        SiteSetting::set('test_key', 'updated');

        $setting = SiteSetting::where('key', 'test_key')->first();
        $this->assertEquals('updated', $setting->value);
    }

    public function test_get_by_group(): void
    {
        SiteSetting::set('key_a', 'val_a', 'text', 'general', 'Key A');
        SiteSetting::set('key_b', 'val_b', 'text', 'general', 'Key B');
        SiteSetting::set('key_c', 'val_c', 'text', 'payment', 'Key C');

        $general = SiteSetting::getByGroup('general');
        $this->assertCount(2, $general);

        $payment = SiteSetting::getByGroup('payment');
        $this->assertCount(1, $payment);
    }

    public function test_get_all_grouped(): void
    {
        SiteSetting::set('key_a', 'val_a', 'text', 'general', 'Key A');
        SiteSetting::set('key_b', 'val_b', 'text', 'payment', 'Key B');

        $grouped = SiteSetting::getAllGrouped();
        $this->assertArrayHasKey('general', $grouped->toArray());
        $this->assertArrayHasKey('payment', $grouped->toArray());
    }
}
