@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Revenue Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <!-- Today's Revenue -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-50 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center gap-3 mb-3">
                <div class="bg-emerald-100 p-2.5 rounded-lg">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Today's Revenue</p>
            </div>
            <p class="text-2xl font-bold text-gray-900">₹{{ number_format($stats['today_revenue'], 0) }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $stats['today_orders'] }} order{{ $stats['today_orders'] !== 1 ? 's' : '' }} today</p>
        </div>
    </div>

    <!-- This Month's Revenue -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center gap-3 mb-3">
                <div class="bg-blue-100 p-2.5 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <p class="text-sm font-medium text-gray-500">This Month</p>
            </div>
            <p class="text-2xl font-bold text-gray-900">₹{{ number_format($stats['month_revenue'], 0) }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $stats['month_orders'] }} orders &middot; Last month: ₹{{ number_format($stats['last_month_revenue'], 0) }}</p>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-amber-50 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center gap-3 mb-3">
                <div class="bg-amber-100 p-2.5 rounded-lg">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Total Revenue</p>
            </div>
            <p class="text-2xl font-bold text-gray-900">₹{{ number_format($stats['total_revenue'], 0) }}</p>
            <p class="text-xs text-gray-400 mt-1">Avg order: ₹{{ number_format($stats['avg_order_value'], 0) }}</p>
        </div>
    </div>

    <!-- Units Sold -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-purple-50 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center gap-3 mb-3">
                <div class="bg-purple-100 p-2.5 rounded-lg">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Units Sold</p>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_units_sold'] }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $stats['total_orders'] }} total orders</p>
        </div>
    </div>
</div>

<!-- Order Status + Inventory Overview -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
    <!-- Order Pipeline -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-4">Order Pipeline</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span>
                    <span class="text-sm text-gray-600">Pending</span>
                </div>
                <span class="text-sm font-semibold text-gray-800">{{ $stats['pending_orders'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-400"></span>
                    <span class="text-sm text-gray-600">Processing</span>
                </div>
                <span class="text-sm font-semibold text-gray-800">{{ $stats['processing_orders'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-purple-400"></span>
                    <span class="text-sm text-gray-600">Shipped</span>
                </div>
                <span class="text-sm font-semibold text-gray-800">{{ $stats['shipped_orders'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-green-400"></span>
                    <span class="text-sm text-gray-600">Delivered</span>
                </div>
                <span class="text-sm font-semibold text-gray-800">{{ $stats['delivered_orders'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-400"></span>
                    <span class="text-sm text-gray-600">Cancelled</span>
                </div>
                <span class="text-sm font-semibold text-gray-800">{{ $stats['cancelled_orders'] }}</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all orders &rarr;</a>
        </div>
    </div>

    <!-- Inventory Snapshot -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-4">Inventory Snapshot</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Total Products</span>
                <span class="text-sm font-semibold text-gray-800">{{ $stats['total_products'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Active</span>
                <span class="text-sm font-semibold text-green-600">{{ $stats['active_products'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Out of Stock</span>
                <span class="text-sm font-semibold {{ $stats['out_of_stock'] > 0 ? 'text-red-600' : 'text-gray-800' }}">{{ $stats['out_of_stock'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Categories</span>
                <span class="text-sm font-semibold text-gray-800">{{ $stats['total_categories'] }}</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.products.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Manage products &rarr;</a>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-4">
            <span class="inline-flex items-center gap-1.5">
                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                Low Stock Alert
            </span>
        </h3>
        @if($lowStockProducts->isEmpty())
            <p class="text-sm text-gray-400 text-center py-4">All products are well-stocked</p>
        @else
            <div class="space-y-3">
                @foreach($lowStockProducts as $product)
                    <div class="flex items-center justify-between">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm text-gray-700 truncate">{{ $product->name }}</p>
                            <p class="text-xs text-gray-400">{{ $product->category->name ?? '' }}</p>
                        </div>
                        <span class="flex-shrink-0 ml-2 px-2 py-0.5 text-xs font-semibold rounded-full {{ $product->stock <= 2 ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700' }}">
                            {{ $product->stock }} left
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.products.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all stock &rarr;</a>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h2 class="text-base font-semibold text-gray-800">Recent Orders</h2>
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all &rarr;</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-medium text-gray-900">{{ $order->order_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $order->billing_name }}</div>
                            <div class="text-xs text-gray-400">{{ $order->billing_phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->items->sum('quantity') }} items</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">₹{{ number_format($order->total, 0) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $order->status_badge }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $order->payment_status_badge }}">{{ ucfirst($order->payment_status) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            No orders yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
