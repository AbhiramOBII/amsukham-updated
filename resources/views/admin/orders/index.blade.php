@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Orders</h2>
                <a href="{{ route('admin.orders.export-csv', request()->query()) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Download CSV
                </a>
            </div>
            <form action="" method="GET" class="flex flex-wrap items-end gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Order #, name, email, phone..." class="px-3 py-2 border border-gray-300 rounded-lg text-sm w-56">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Payment</label>
                    <select name="payment_status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">All Payment</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 text-sm">Filter</button>
                    @if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 text-sm">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $order->order_number }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $order->billing_name }}</div>
                            <div class="text-sm text-gray-500">{{ $order->billing_email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->items->count() }} items</td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">₹{{ number_format($order->total, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-200 rounded-full px-2 py-1 cursor-pointer {{ $order->status_badge }}">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <select name="payment_status" onchange="this.form.submit()" class="text-xs border border-gray-200 rounded-full px-2 py-1 cursor-pointer {{ $order->payment_status_badge }}">
                                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-6 py-4 text-center text-gray-500">No orders found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())<div class="p-6 border-t border-gray-200">{{ $orders->links() }}</div>@endif
</div>
@endsection
