<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update</title>
</head>
<body style="margin:0; padding:0; background-color:#f8f5f0; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f5f0; padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 6px rgba(0,0,0,0.07);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color:#4a1c1a; padding:30px 40px; text-align:center;">
                            <h1 style="color:#d4a853; margin:0; font-size:24px; letter-spacing:2px;">AMSUKHAM</h1>
                            <p style="color:#ffffff; margin:8px 0 0; font-size:12px; letter-spacing:3px; text-transform:uppercase;">Heritage Sarees</p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px;">
                            <h2 style="color:#4a1c1a; margin:0 0 8px; font-size:22px;">Order Status Updated</h2>
                            <p style="color:#666; margin:0 0 24px; font-size:15px; line-height:1.6;">
                                Hi {{ $order->billing_name }}, your order <strong>{{ $order->order_number }}</strong> has been updated.
                            </p>

                            <!-- Status Update -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#faf7f2; border-radius:6px; margin-bottom:24px;">
                                <tr>
                                    <td style="padding:24px; text-align:center;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="text-align:center; padding-bottom:16px;">
                                                    @php
                                                        $statusIcons = [
                                                            'pending' => '⏳',
                                                            'processing' => '📦',
                                                            'shipped' => '🚚',
                                                            'delivered' => '✅',
                                                            'cancelled' => '❌',
                                                            'refunded' => '💰',
                                                        ];
                                                        $statusColors = [
                                                            'pending' => '#f59e0b',
                                                            'processing' => '#3b82f6',
                                                            'shipped' => '#8b5cf6',
                                                            'delivered' => '#16a34a',
                                                            'cancelled' => '#dc2626',
                                                            'refunded' => '#6b7280',
                                                        ];
                                                    @endphp
                                                    <span style="font-size:40px;">{{ $statusIcons[$order->status] ?? '📋' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:center;">
                                                    <span style="display:inline-block; background-color:{{ $statusColors[$order->status] ?? '#4a1c1a' }}; color:#ffffff; padding:8px 24px; border-radius:20px; font-size:16px; font-weight:600; text-transform:uppercase; letter-spacing:1px;">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Status Messages -->
                            <p style="color:#555; font-size:14px; line-height:1.7; margin:0 0 24px;">
                                @switch($order->status)
                                    @case('processing')
                                        Your order is being processed and prepared for shipment. We're carefully packing your saree to ensure it reaches you in perfect condition.
                                        @break
                                    @case('shipped')
                                        Great news! Your order has been shipped and is on its way to you. You can expect delivery within 5-7 business days.
                                        @break
                                    @case('delivered')
                                        Your order has been delivered! We hope you love your purchase. If you have any concerns, please don't hesitate to reach out.
                                        @break
                                    @case('cancelled')
                                        Your order has been cancelled. If you did not request this cancellation or have any questions, please contact us immediately.
                                        @break
                                    @case('refunded')
                                        A refund has been initiated for your order. The amount will be credited to your original payment method within 5-7 business days.
                                        @break
                                    @default
                                        Your order status has been updated. Please check below for details.
                                @endswitch
                            </p>

                            <!-- Order Summary -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e5e5; border-radius:6px; overflow:hidden; margin-bottom:24px;">
                                <tr style="background-color:#faf7f2;">
                                    <td style="padding:16px; font-size:13px; color:#666;">Order Number</td>
                                    <td style="padding:16px; font-size:14px; color:#333; text-align:right; font-weight:600;">{{ $order->order_number }}</td>
                                </tr>
                                <tr style="border-top:1px solid #f0f0f0;">
                                    <td style="padding:16px; font-size:13px; color:#666;">Order Date</td>
                                    <td style="padding:16px; font-size:14px; color:#333; text-align:right;">{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                                <tr style="border-top:1px solid #f0f0f0;">
                                    <td style="padding:16px; font-size:13px; color:#666;">Total Amount</td>
                                    <td style="padding:16px; font-size:14px; color:#333; text-align:right; font-weight:600;">₹{{ number_format($order->total, 2) }}</td>
                                </tr>
                                <tr style="border-top:1px solid #f0f0f0;">
                                    <td style="padding:16px; font-size:13px; color:#666;">Items</td>
                                    <td style="padding:16px; font-size:14px; color:#333; text-align:right;">{{ $order->items->count() }} item(s)</td>
                                </tr>
                            </table>

                            <p style="color:#666; font-size:14px; line-height:1.6; margin:24px 0 0; padding-top:20px; border-top:1px solid #e5e5e5;">
                                Need help? Reply to this email or contact us on WhatsApp at +91 95915 79771.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#4a1c1a; padding:24px 40px; text-align:center;">
                            <p style="color:#d4a853; margin:0 0 4px; font-size:14px; font-weight:600;">Amsukham</p>
                            <p style="color:#ffffff99; margin:0; font-size:12px;">Heritage Sarees — Woven with Love</p>
                            <p style="color:#ffffff66; margin:12px 0 0; font-size:11px;">www.amsukham.com</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
