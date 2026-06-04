<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderAdmin;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RazorpayWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');

        // Verify webhook signature
        $webhookSecret = config('services.razorpay.webhook_secret');

        if ($webhookSecret) {
            $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);
            if (!hash_equals($expectedSignature, $signature ?? '')) {
                Log::warning('Razorpay webhook: invalid signature');
                return response()->json(['status' => 'invalid_signature'], 400);
            }
        }

        $event = json_decode($payload, true);

        if (!$event || !isset($event['event'])) {
            return response()->json(['status' => 'invalid_payload'], 400);
        }

        Log::info('Razorpay webhook received: ' . $event['event'], [
            'payment_id' => $event['payload']['payment']['entity']['id'] ?? null,
            'order_id' => $event['payload']['payment']['entity']['order_id'] ?? null,
        ]);

        match ($event['event']) {
            'payment.captured' => $this->handlePaymentCaptured($event),
            'payment.failed' => $this->handlePaymentFailed($event),
            default => null,
        };

        return response()->json(['status' => 'ok'], 200);
    }

    protected function handlePaymentCaptured(array $event): void
    {
        $payment = $event['payload']['payment']['entity'];
        $razorpayOrderId = $payment['order_id'] ?? null;
        $razorpayPaymentId = $payment['id'] ?? null;

        if (!$razorpayOrderId) {
            Log::warning('Razorpay webhook payment.captured: missing order_id');
            return;
        }

        $order = Order::where('razorpay_order_id', $razorpayOrderId)->first();

        if (!$order) {
            Log::warning('Razorpay webhook payment.captured: order not found', [
                'razorpay_order_id' => $razorpayOrderId,
            ]);
            return;
        }

        // Already paid — skip
        if ($order->payment_status === 'paid') {
            Log::info('Razorpay webhook: order already paid', ['order' => $order->order_number]);
            return;
        }

        // Update order to paid
        $order->update([
            'status' => 'processing',
            'payment_status' => 'paid',
            'razorpay_payment_id' => $razorpayPaymentId,
        ]);

        Log::info('Razorpay webhook: order reconciled to paid', ['order' => $order->order_number]);

        // Send confirmation emails if not already sent (check if payment_id was blank before)
        try {
            Mail::to($order->billing_email)->send(new OrderConfirmation($order->load('items')));
            Mail::to('amsukham@gmail.com')->send(new NewOrderAdmin($order));
        } catch (\Exception $e) {
            Log::error('Razorpay webhook email failed for ' . $order->order_number . ': ' . $e->getMessage());
        }
    }

    protected function handlePaymentFailed(array $event): void
    {
        $payment = $event['payload']['payment']['entity'];
        $razorpayOrderId = $payment['order_id'] ?? null;

        if (!$razorpayOrderId) {
            return;
        }

        $order = Order::where('razorpay_order_id', $razorpayOrderId)->first();

        if (!$order) {
            Log::warning('Razorpay webhook payment.failed: order not found', [
                'razorpay_order_id' => $razorpayOrderId,
            ]);
            return;
        }

        // Only mark as failed if still pending
        if ($order->payment_status === 'pending') {
            $order->update(['payment_status' => 'failed']);
            Log::info('Razorpay webhook: order marked as failed', ['order' => $order->order_number]);
        }
    }
}
