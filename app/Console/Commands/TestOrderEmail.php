<?php

namespace App\Console\Commands;

use App\Mail\NewOrderAdmin;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestOrderEmail extends Command
{
    protected $signature = 'mail:test-order {--order= : Order number to use (uses latest if not specified)}';
    protected $description = 'Send test order confirmation and admin notification emails';

    public function handle()
    {
        $orderNumber = $this->option('order');

        if ($orderNumber) {
            $order = Order::with('items')->where('order_number', $orderNumber)->first();
        } else {
            $order = Order::with('items')->latest()->first();
        }

        if (!$order) {
            $this->error('No orders found in database.');
            return 1;
        }

        $this->info("Using order: {$order->order_number} (₹" . number_format($order->total, 2) . ")");

        // Send customer confirmation
        $this->info('Sending order confirmation to abhiram.chandramohan@gmail.com...');
        Mail::to('abhiram.chandramohan@gmail.com')->send(new OrderConfirmation($order));
        $this->info('✓ Customer email sent.');

        // Send admin notification
        $this->info('Sending admin notification to amsukham@gmail.com...');
        Mail::to('amsukham@gmail.com')->send(new NewOrderAdmin($order));
        $this->info('✓ Admin email sent.');

        $this->newLine();
        $this->info('Both test emails sent successfully!');

        return 0;
    }
}
