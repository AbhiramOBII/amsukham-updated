@extends('admin.layouts.app')

@section('title', 'Coupons')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Coupons</h2>
            <a href="{{ route('admin.coupons.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create Coupon
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Discount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Min Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Validity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usage</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($coupons as $coupon)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-mono font-semibold text-gray-900">{{ $coupon->code }}</span>
                            @if($coupon->description)
                                <p class="text-xs text-gray-400 mt-0.5">{{ $coupon->description }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            @if($coupon->discount_type === 'percentage')
                                {{ number_format($coupon->discount_value, 0) }}%
                                @if($coupon->maximum_discount)
                                    <span class="text-xs text-gray-400">(max ₹{{ number_format($coupon->maximum_discount, 0) }})</span>
                                @endif
                            @else
                                ₹{{ number_format($coupon->discount_value, 0) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ₹{{ number_format($coupon->minimum_order_value, 0) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($coupon->start_date && $coupon->expiry_date)
                                {{ $coupon->start_date->format('d M') }} - {{ $coupon->expiry_date->format('d M Y') }}
                            @elseif($coupon->expiry_date)
                                Until {{ $coupon->expiry_date->format('d M Y') }}
                            @else
                                No expiry
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $coupon->times_used }}{{ $coupon->usage_limit ? ' / ' . $coupon->usage_limit : '' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($coupon->is_active)
                                @if($coupon->expiry_date && $coupon->expiry_date->isPast())
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Expired</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                @endif
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Delete this coupon?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">No coupons created yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($coupons->hasPages())<div class="p-6 border-t border-gray-200">{{ $coupons->links() }}</div>@endif
</div>
@endsection
