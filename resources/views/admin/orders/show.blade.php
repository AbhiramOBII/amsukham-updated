@extends('admin.layouts.app')

@section('title', 'Order ' . $order->order_number)

@section('content')
<div class="grid grid-cols-3 gap-6">
    <div class="col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Order Items</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $item->product_name }}</div>
                                    <div class="text-sm text-gray-500">SKU: {{ $item->product_sku ?? 'N/A' }}</div>
                                    @if($item->with_blouse)<div class="text-xs text-green-600">With Blouse</div>@endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->discount > 0)
                                        <div class="text-sm text-gray-500 line-through">₹{{ number_format($item->price, 2) }}</div>
                                        <div class="font-medium text-gray-900">₹{{ number_format($item->discounted_price, 2) }}</div>
                                    @else
                                        <div class="font-medium text-gray-900">₹{{ number_format($item->price, 2) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">₹{{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Subtotal</td>
                            <td class="px-6 py-3 whitespace-nowrap font-medium text-gray-900">₹{{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        @if($order->discount > 0)
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Discount</td>
                            <td class="px-6 py-3 whitespace-nowrap font-medium text-green-600">-₹{{ number_format($order->discount, 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Shipping</td>
                            <td class="px-6 py-3 whitespace-nowrap font-medium text-gray-900">₹{{ number_format($order->shipping, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-right text-lg font-bold text-gray-900">Total</td>
                            <td class="px-6 py-3 whitespace-nowrap text-lg font-bold text-gray-900">₹{{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Shipping Address</h3>
                <button onclick="document.getElementById('address-display').classList.add('hidden'); document.getElementById('address-form').classList.remove('hidden');"
                    class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit</button>
            </div>

            <div id="address-display" class="text-gray-700">
                <p class="font-medium">{{ $order->billing_name }}</p>
                <p>{{ $order->billing_address }}</p>
                <p>{{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_pincode }}</p>
                <p>{{ $order->billing_country }}</p>
                <p class="mt-2"><strong>Phone:</strong> {{ $order->billing_phone }}</p>
                <p><strong>Email:</strong> {{ $order->billing_email }}</p>
            </div>

            <form id="address-form" class="hidden space-y-3" action="{{ route('admin.orders.update-address', $order) }}" method="POST">
                @csrf @method('PATCH')
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Name</label>
                    <input type="text" name="billing_name" value="{{ $order->billing_name }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Phone</label>
                    <input type="text" name="billing_phone" value="{{ $order->billing_phone }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                    <input type="email" name="billing_email" value="{{ $order->billing_email }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Address</label>
                    <textarea name="billing_address" rows="2" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ $order->billing_address }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">City</label>
                        <input type="text" name="billing_city" value="{{ $order->billing_city }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">State</label>
                        <input type="text" name="billing_state" value="{{ $order->billing_state }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Pincode</label>
                    <input type="text" name="billing_pincode" value="{{ $order->billing_pincode }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="px-4 py-2 bg-amber-600 text-white text-sm rounded-lg hover:bg-amber-700">Save Address</button>
                    <button type="button" onclick="document.getElementById('address-form').classList.add('hidden'); document.getElementById('address-display').classList.remove('hidden');"
                        class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50">Cancel</button>
                </div>
            </form>
        </div>

        @if($order->notes)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Notes</h3>
            <p class="text-gray-700">{{ $order->notes }}</p>
        </div>
        @endif
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Details</h3>
            <dl class="space-y-3">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Order Number</dt>
                    <dd class="font-medium text-gray-900">{{ $order->order_number }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Date</dt>
                    <dd class="text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Payment Method</dt>
                    <dd class="text-gray-900">{{ $order->payment_method ?? 'Razorpay' }}</dd>
                </div>
                @if($order->razorpay_payment_id)
                <div class="flex justify-between">
                    <dt class="text-gray-500">Payment ID</dt>
                    <dd class="text-gray-900 text-sm">{{ $order->razorpay_payment_id }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Status</h3>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="mb-4">
                @csrf @method('PATCH')
                <label class="block text-sm font-medium text-gray-700 mb-2">Order Status</label>
                <div class="flex gap-2">
                    <select name="status" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">Update</button>
                </div>
            </form>

            <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST">
                @csrf @method('PATCH')
                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                <div class="flex gap-2">
                    <select name="payment_status" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">Update</button>
                </div>
            </form>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="block text-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">← Back to Orders</a>
    </div>
</div>
@endsection
