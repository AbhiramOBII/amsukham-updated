<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderTest extends TestCase
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

    private function createOrder(array $overrides = []): Order
    {
        return Order::create(array_merge([
            'billing_name' => 'John Doe',
            'billing_email' => 'john@example.com',
            'billing_phone' => '9876543210',
            'billing_address' => '123 Test St',
            'billing_city' => 'Bangalore',
            'billing_state' => 'Karnataka',
            'billing_pincode' => '560001',
            'subtotal' => 5000,
            'shipping' => 99,
            'total' => 5099,
            'status' => 'pending',
            'payment_status' => 'paid',
            'payment_method' => 'razorpay',
        ], $overrides));
    }

    public function test_orders_index_loads(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.orders.index'));

        $response->assertStatus(200);
    }

    public function test_order_show_loads(): void
    {
        $order = $this->createOrder();

        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.orders.show', $order));

        $response->assertStatus(200);
    }

    public function test_can_update_order_status(): void
    {
        $order = $this->createOrder();

        $response = $this->actingAs($this->admin, 'admin')
            ->patch(route('admin.orders.update-status', $order), [
                'status' => 'processing',
            ]);

        $response->assertRedirect();
        $this->assertEquals('processing', $order->fresh()->status);
    }

    public function test_can_update_payment_status(): void
    {
        $order = $this->createOrder(['payment_status' => 'pending']);

        $response = $this->actingAs($this->admin, 'admin')
            ->patch(route('admin.orders.update-payment-status', $order), [
                'payment_status' => 'paid',
            ]);

        $response->assertRedirect();
        $this->assertEquals('paid', $order->fresh()->payment_status);
    }

    public function test_guest_cannot_access_orders(): void
    {
        $response = $this->get(route('admin.orders.index'));

        $response->assertRedirect(route('admin.login'));
    }
}
