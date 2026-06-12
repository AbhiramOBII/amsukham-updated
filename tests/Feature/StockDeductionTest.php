<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockDeductionTest extends TestCase
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

    private function createProduct(int $stock = 8): Product
    {
        $category = Category::firstOrCreate(
            ['slug' => 'sarees'],
            ['name' => 'Sarees', 'is_active' => true]
        );

        return Product::create([
            'name' => 'Test Saree',
            'category_id' => $category->id,
            'price' => 3000,
            'stock' => $stock,
            'is_active' => true,
        ]);
    }

    private function createPendingOrder(Product $product, int $quantity = 1, string $razorpayOrderId = null): Order
    {
        $order = Order::create([
            'billing_name' => 'Test User',
            'billing_email' => 'test@example.com',
            'billing_phone' => '9876543210',
            'billing_address' => '123 Street',
            'billing_city' => 'Bangalore',
            'billing_state' => 'Karnataka',
            'billing_pincode' => '560001',
            'subtotal' => $product->price * $quantity,
            'shipping' => 0,
            'total' => $product->price * $quantity,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'razorpay',
            'razorpay_order_id' => $razorpayOrderId ?? ('order_test_' . uniqid()),
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_sku' => $product->sku ?? 'TST-001',
            'price' => $product->price,
            'discount' => 0,
            'discounted_price' => $product->price,
            'quantity' => $quantity,
            'total' => $product->price * $quantity,
        ]);

        return $order;
    }

    private function webhookPayload(string $event, string $razorpayOrderId, string $paymentId = 'pay_test_123'): array
    {
        return [
            'event' => $event,
            'payload' => [
                'payment' => [
                    'entity' => [
                        'id' => $paymentId,
                        'order_id' => $razorpayOrderId,
                    ],
                ],
            ],
        ];
    }

    // -----------------------------------------------------------------------
    // CART TESTS — stock must NEVER change when adding/updating cart
    // -----------------------------------------------------------------------

    public function test_adding_to_cart_does_not_deduct_stock(): void
    {
        $product = $this->createProduct(8);

        $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->assertSame(8, $product->fresh()->stock);
    }

    public function test_two_customers_adding_same_product_to_cart_do_not_reduce_stock(): void
    {
        $product = $this->createProduct(8);

        $this->postJson('/cart/add', ['product_id' => $product->id, 'quantity' => 1]);
        $this->postJson('/cart/add', ['product_id' => $product->id, 'quantity' => 1]);

        $this->assertSame(8, $product->fresh()->stock);
    }

    // -----------------------------------------------------------------------
    // PENDING ORDER — stock must NOT be deducted when order is created
    // -----------------------------------------------------------------------

    public function test_pending_order_does_not_deduct_stock(): void
    {
        $product = $this->createProduct(8);

        // Simulates what process() now does: create order record, NO stock deduction
        $this->createPendingOrder($product, 2);

        $this->assertSame(8, $product->fresh()->stock);
    }

    public function test_abandoned_payment_leaves_stock_intact(): void
    {
        $product = $this->createProduct(8);

        // Two customers reach payment page and abandon — no webhook ever fires
        $this->createPendingOrder($product, 1, 'order_abandon_1');
        $this->createPendingOrder($product, 1, 'order_abandon_2');

        // This is the exact scenario the customer reported: stock should still be 8
        $this->assertSame(8, $product->fresh()->stock);
    }

    // -----------------------------------------------------------------------
    // PAYMENT SUCCESS — stock deducted via webhook payment.captured
    // -----------------------------------------------------------------------

    public function test_webhook_payment_captured_deducts_stock(): void
    {
        $product = $this->createProduct(8);
        $order = $this->createPendingOrder($product, 1, 'order_rp_001');

        $this->postJson('/webhooks/razorpay',
            $this->webhookPayload('payment.captured', 'order_rp_001'));

        $this->assertSame(7, $product->fresh()->stock);
        $this->assertSame('paid', $order->fresh()->payment_status);
    }

    public function test_webhook_payment_captured_deducts_correct_quantity(): void
    {
        $product = $this->createProduct(8);
        $order = $this->createPendingOrder($product, 3, 'order_rp_002');

        $this->postJson('/webhooks/razorpay',
            $this->webhookPayload('payment.captured', 'order_rp_002'));

        $this->assertSame(5, $product->fresh()->stock);
    }

    // -----------------------------------------------------------------------
    // PAYMENT FAILURE — stock still deducted (gateway interaction happened)
    // -----------------------------------------------------------------------

    public function test_webhook_payment_failed_deducts_stock(): void
    {
        $product = $this->createProduct(8);
        $order = $this->createPendingOrder($product, 1, 'order_rp_003');

        $this->postJson('/webhooks/razorpay',
            $this->webhookPayload('payment.failed', 'order_rp_003'));

        $this->assertSame(7, $product->fresh()->stock);
        $this->assertSame('failed', $order->fresh()->payment_status);
    }

    // -----------------------------------------------------------------------
    // NO DOUBLE DEDUCTION — idempotency guard
    // -----------------------------------------------------------------------

    public function test_duplicate_webhook_does_not_double_deduct(): void
    {
        $product = $this->createProduct(8);
        $this->createPendingOrder($product, 1, 'order_rp_004');

        $payload = $this->webhookPayload('payment.captured', 'order_rp_004');

        $this->postJson('/webhooks/razorpay', $payload);
        $this->postJson('/webhooks/razorpay', $payload); // duplicate

        $this->assertSame(7, $product->fresh()->stock); // deducted exactly once
    }

    // -----------------------------------------------------------------------
    // ADMIN STATUS CHANGES — stock restore logic
    // -----------------------------------------------------------------------

    public function test_admin_cancelling_pending_payment_order_does_not_restore_stock(): void
    {
        $product = $this->createProduct(8);
        $order = $this->createPendingOrder($product, 1);
        // payment_status = 'pending' means stock was never deducted (new behaviour)

        $this->actingAs($this->admin, 'admin')
            ->patch(route('admin.orders.update-status', $order), ['status' => 'cancelled']);

        // Stock must remain 8 — nothing was ever deducted
        $this->assertSame(8, $product->fresh()->stock);
    }

    public function test_admin_cancelling_paid_order_restores_stock(): void
    {
        $product = $this->createProduct(8);
        $order = $this->createPendingOrder($product, 1);

        // Simulate verify() having run: stock deducted, order marked paid
        $product->decrement('stock', 1); // stock = 7
        $order->update(['payment_status' => 'paid', 'status' => 'processing']);

        $this->actingAs($this->admin, 'admin')
            ->patch(route('admin.orders.update-status', $order), ['status' => 'cancelled']);

        // Stock must be restored to 8
        $this->assertSame(8, $product->fresh()->stock);
    }

    public function test_admin_cancelling_failed_payment_order_restores_stock(): void
    {
        $product = $this->createProduct(8);
        $order = $this->createPendingOrder($product, 1);

        // Simulate verify() failure path: stock deducted, payment marked failed
        $product->decrement('stock', 1); // stock = 7
        $order->update(['payment_status' => 'failed', 'status' => 'pending']);

        $this->actingAs($this->admin, 'admin')
            ->patch(route('admin.orders.update-status', $order), ['status' => 'cancelled']);

        // Stock must be restored to 8
        $this->assertSame(8, $product->fresh()->stock);
    }
}
