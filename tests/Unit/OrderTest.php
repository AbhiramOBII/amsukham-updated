<?php

namespace Tests\Unit;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_number_auto_generated(): void
    {
        $order = Order::create([
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
            'payment_status' => 'pending',
            'payment_method' => 'razorpay',
        ]);

        $this->assertNotNull($order->order_number);
        $this->assertStringStartsWith('ORD-', $order->order_number);
    }

    public function test_status_badge_attribute(): void
    {
        $order = Order::create([
            'billing_name' => 'John',
            'billing_email' => 'j@example.com',
            'billing_phone' => '9876543210',
            'billing_address' => '123 St',
            'billing_city' => 'Bangalore',
            'billing_state' => 'Karnataka',
            'billing_pincode' => '560001',
            'subtotal' => 1000,
            'shipping' => 0,
            'total' => 1000,
            'status' => 'processing',
            'payment_status' => 'paid',
            'payment_method' => 'razorpay',
        ]);

        $this->assertEquals('bg-blue-100 text-blue-800', $order->status_badge);
    }

    public function test_payment_status_badge_attribute(): void
    {
        $order = Order::create([
            'billing_name' => 'John',
            'billing_email' => 'j@example.com',
            'billing_phone' => '9876543210',
            'billing_address' => '123 St',
            'billing_city' => 'Bangalore',
            'billing_state' => 'Karnataka',
            'billing_pincode' => '560001',
            'subtotal' => 1000,
            'shipping' => 0,
            'total' => 1000,
            'status' => 'pending',
            'payment_status' => 'paid',
            'payment_method' => 'razorpay',
        ]);

        $this->assertEquals('bg-green-100 text-green-800', $order->payment_status_badge);
    }

    public function test_items_relationship(): void
    {
        $order = Order::create([
            'billing_name' => 'John',
            'billing_email' => 'j@example.com',
            'billing_phone' => '9876543210',
            'billing_address' => '123 St',
            'billing_city' => 'Bangalore',
            'billing_state' => 'Karnataka',
            'billing_pincode' => '560001',
            'subtotal' => 1000,
            'shipping' => 0,
            'total' => 1000,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'razorpay',
        ]);

        $this->assertCount(0, $order->items);
    }
}
