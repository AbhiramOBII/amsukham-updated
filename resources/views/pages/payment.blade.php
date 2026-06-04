<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Amsukham</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body class="bg-soft-cream min-h-screen flex items-center justify-center">
    <div id="paymentStatus" class="max-w-md w-full mx-4">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="animate-pulse mb-6">
                <svg class="w-16 h-16 mx-auto text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Processing Payment</h1>
            <p class="text-gray-600 mb-4">Amount: ₹{{ number_format($total, 2) }}</p>
            <p class="text-sm text-gray-500">Please wait while we redirect you to Razorpay...</p>
        </div>
    </div>

    <form action="{{ route('checkout.verify') }}" method="POST" id="paymentForm">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    </form>

    <script>
        var options = {
            "key": "{{ $razorpayKey }}",
            "amount": "{{ $total * 100 }}",
            "currency": "INR",
            "name": "Amsukham",
            "description": "Order Payment",
            "image": "{{ asset('images/amsukham-logo.svg') }}",
            "order_id": "{{ $razorpayOrderId }}",
            "handler": function (response) {
                if (!response || !response.razorpay_payment_id || !response.razorpay_signature) {
                    window.location.href = "{{ route('order.failure', $orderNumber) }}";
                    return;
                }
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                document.getElementById('paymentForm').submit();
            },
            "prefill": {
                "name": "{{ $name }}",
                "email": "{{ $email }}",
                "contact": "{{ $phone }}"
            },
            "theme": {
                "color": "#B8860B"
            },
            "modal": {
                "ondismiss": function() {
                    window.location.href = "{{ route('order.failure', $orderNumber) }}";
                }
            }
        };

        var rzp = new Razorpay(options);
        rzp.open();
    </script>
</body>
</html>
