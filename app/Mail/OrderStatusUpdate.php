<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdate extends Mailable
{
    use SerializesModels;

    public function __construct(public Order $order, public string $oldStatus)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order ' . ucfirst($this->order->status) . ' - ' . $this->order->order_number . ' | Amsukham',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status-update',
            with: ['oldStatus' => $this->oldStatus],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
