<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
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
                            <h2 style="color:#4a1c1a; margin:0 0 8px; font-size:22px;">Thank You for Your Order!</h2>
                            <p style="color:#666; margin:0 0 24px; font-size:15px; line-height:1.6;">
                                Hi {{ $order->billing_name }}, your order has been placed successfully and payment has been confirmed.
                            </p>

                            <!-- Order Info -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#faf7f2; border-radius:6px; padding:20px; margin-bottom:24px;">
                                <tr>
                                    <td style="padding:20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding-bottom:10px;">
                                                    <strong style="color:#4a1c1a; font-size:13px;">Order Number</strong><br>
                                                    <span style="color:#333; font-size:15px;">{{ $order->order_number }}</span>
                                                </td>
                                                <td style="padding-bottom:10px; text-align:right;">
                                                    <strong style="color:#4a1c1a; font-size:13px;">Date</strong><br>
                                                    <span style="color:#333; font-size:15px;">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong style="color:#4a1c1a; font-size:13px;">Payment Status</strong><br>
                                                    <span style="color:#16a34a; font-size:15px; font-weight:600;">Paid</span>
                                                </td>
                                                <td style="text-align:right;">
                                                    <strong style="color:#4a1c1a; font-size:13px;">Payment ID</strong><br>
                                                    <span style="color:#333; font-size:13px;">{{ $order->razorpay_payment_id }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Order Items -->
                            <h3 style="color:#4a1c1a; margin:0 0 12px; font-size:16px;">Order Items</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e5e5; border-radius:6px; overflow:hidden; margin-bottom:24px;">
                                <thead>
                                    <tr style="background-color:#faf7f2;">
                                        <th style="padding:12px 16px; text-align:left; font-size:12px; color:#666; text-transform:uppercase;">Item</th>
                                        <th style="padding:12px 16px; text-align:center; font-size:12px; color:#666; text-transform:uppercase;">Qty</th>
                                        <th style="padding:12px 16px; text-align:right; font-size:12px; color:#666; text-transform:uppercase;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr style="border-top:1px solid #f0f0f0;">
                                        <td style="padding:12px 16px; font-size:14px; color:#333;">
                                            {{ $item->product_name }}
                                            @if($item->with_blouse)<br><span style="font-size:12px; color:#16a34a;">With Blouse</span>@endif
                                        </td>
                                        <td style="padding:12px 16px; text-align:center; font-size:14px; color:#333;">{{ $item->quantity }}</td>
                                        <td style="padding:12px 16px; text-align:right; font-size:14px; color:#333;">₹{{ number_format($item->total, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Totals -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                                <tr>
                                    <td style="padding:6px 0; font-size:14px; color:#666;">Subtotal</td>
                                    <td style="padding:6px 0; font-size:14px; color:#333; text-align:right;">₹{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                @if($order->discount > 0)
                                <tr>
                                    <td style="padding:6px 0; font-size:14px; color:#16a34a;">Discount{{ $order->coupon_code ? ' (' . $order->coupon_code . ')' : '' }}</td>
                                    <td style="padding:6px 0; font-size:14px; color:#16a34a; text-align:right;">-₹{{ number_format($order->discount, 2) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding:6px 0; font-size:14px; color:#666;">Shipping</td>
                                    <td style="padding:6px 0; font-size:14px; color:#333; text-align:right;">{{ $order->shipping > 0 ? '₹' . number_format($order->shipping, 2) : 'Free' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0 0; font-size:18px; font-weight:700; color:#4a1c1a; border-top:2px solid #e5e5e5;">Total</td>
                                    <td style="padding:12px 0 0; font-size:18px; font-weight:700; color:#4a1c1a; text-align:right; border-top:2px solid #e5e5e5;">₹{{ number_format($order->total, 2) }}</td>
                                </tr>
                            </table>

                            <!-- Shipping Address -->
                            <h3 style="color:#4a1c1a; margin:0 0 8px; font-size:16px;">Shipping Address</h3>
                            <p style="color:#555; font-size:14px; line-height:1.6; margin:0 0 24px;">
                                {{ $order->billing_name }}<br>
                                {{ $order->billing_address }}<br>
                                {{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_pincode }}<br>
                                Phone: {{ $order->billing_phone }}
                            </p>

                            <p style="color:#666; font-size:14px; line-height:1.6; margin:24px 0 0; padding-top:20px; border-top:1px solid #e5e5e5;">
                                We'll notify you when your order is shipped. If you have any questions, reply to this email or reach out on WhatsApp at +91 95915 79771.
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
