<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Received</title>
</head>
<body style="margin:0; padding:0; background-color:#f8f5f0; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f5f0; padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 6px rgba(0,0,0,0.07);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color:#4a1c1a; padding:24px 40px; text-align:center;">
                            <h1 style="color:#d4a853; margin:0; font-size:20px; letter-spacing:2px;">🛒 NEW ORDER RECEIVED</h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:32px 40px;">
                            <!-- Order Summary -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0fdf4; border:1px solid #bbf7d0; border-radius:6px; margin-bottom:20px;">
                                <tr>
                                    <td style="padding:20px; text-align:center;">
                                        <span style="font-size:28px; font-weight:700; color:#16a34a;">₹{{ number_format($order->total, 2) }}</span>
                                        <br>
                                        <span style="font-size:13px; color:#666; text-transform:uppercase; letter-spacing:1px;">Order Total</span>
                                    </td>
                                </tr>
                            </table>

                            <!-- Order Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e5e5; border-radius:6px; overflow:hidden; margin-bottom:20px;">
                                <tr style="background-color:#faf7f2;">
                                    <td style="padding:12px 16px; font-size:13px; color:#666;">Order Number</td>
                                    <td style="padding:12px 16px; font-size:14px; color:#333; text-align:right; font-weight:600;">{{ $order->order_number }}</td>
                                </tr>
                                <tr style="border-top:1px solid #f0f0f0;">
                                    <td style="padding:12px 16px; font-size:13px; color:#666;">Customer</td>
                                    <td style="padding:12px 16px; font-size:14px; color:#333; text-align:right;">{{ $order->billing_name }}</td>
                                </tr>
                                <tr style="border-top:1px solid #f0f0f0;">
                                    <td style="padding:12px 16px; font-size:13px; color:#666;">Email</td>
                                    <td style="padding:12px 16px; font-size:14px; color:#333; text-align:right;">{{ $order->billing_email }}</td>
                                </tr>
                                <tr style="border-top:1px solid #f0f0f0;">
                                    <td style="padding:12px 16px; font-size:13px; color:#666;">Phone</td>
                                    <td style="padding:12px 16px; font-size:14px; color:#333; text-align:right;">{{ $order->billing_phone }}</td>
                                </tr>
                                <tr style="border-top:1px solid #f0f0f0;">
                                    <td style="padding:12px 16px; font-size:13px; color:#666;">Payment</td>
                                    <td style="padding:12px 16px; font-size:14px; color:#16a34a; text-align:right; font-weight:600;">{{ ucfirst($order->payment_status) }}</td>
                                </tr>
                                <tr style="border-top:1px solid #f0f0f0;">
                                    <td style="padding:12px 16px; font-size:13px; color:#666;">Date</td>
                                    <td style="padding:12px 16px; font-size:14px; color:#333; text-align:right;">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>

                            <!-- Items -->
                            <h3 style="color:#4a1c1a; margin:0 0 10px; font-size:15px;">Items Ordered</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e5e5; border-radius:6px; overflow:hidden; margin-bottom:20px;">
                                @foreach($order->items as $item)
                                <tr style="border-top:1px solid #f0f0f0;">
                                    <td style="padding:10px 16px; font-size:13px; color:#333;">
                                        {{ $item->product_name }} × {{ $item->quantity }}
                                        @if($item->with_blouse)<span style="color:#16a34a; font-size:11px;">(With Blouse)</span>@endif
                                    </td>
                                    <td style="padding:10px 16px; font-size:13px; color:#333; text-align:right; font-weight:600;">₹{{ number_format($item->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>

                            <!-- Shipping Address -->
                            <h3 style="color:#4a1c1a; margin:0 0 8px; font-size:15px;">Ship To</h3>
                            <p style="color:#555; font-size:13px; line-height:1.5; margin:0 0 20px; padding:12px 16px; background:#faf7f2; border-radius:6px;">
                                {{ $order->billing_name }}<br>
                                {{ $order->billing_address }}<br>
                                {{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_pincode }}<br>
                                Ph: {{ $order->billing_phone }}
                            </p>

                            <!-- CTA -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="text-align:center; padding-top:10px;">
                                        <a href="{{ url('/admin/orders/' . $order->id) }}" style="display:inline-block; background-color:#4a1c1a; color:#ffffff; padding:12px 32px; border-radius:6px; text-decoration:none; font-size:14px; font-weight:600;">View Order in Admin</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
