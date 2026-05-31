@extends('admin.layouts.app')

@section('title', 'Create Coupon')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Create Coupon</h2>
        </div>
        <form action="{{ route('admin.coupons.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Coupon Code *</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 uppercase focus:outline-none focus:ring-2 focus:ring-amber-500"
                        placeholder="e.g. WELCOME10">
                    @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <input type="text" name="description" id="description" value="{{ old('description') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                        placeholder="e.g. Welcome offer for new users">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="discount_type" class="block text-sm font-medium text-gray-700 mb-1">Discount Type *</label>
                    <select name="discount_type" id="discount_type" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                    </select>
                </div>

                <div>
                    <label for="discount_value" class="block text-sm font-medium text-gray-700 mb-1">Discount Value *</label>
                    <input type="number" name="discount_value" id="discount_value" value="{{ old('discount_value') }}" required
                        step="0.01" min="0.01"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                        placeholder="e.g. 10">
                    @error('discount_value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="maximum_discount" class="block text-sm font-medium text-gray-700 mb-1">Maximum Discount (₹)</label>
                    <input type="number" name="maximum_discount" id="maximum_discount" value="{{ old('maximum_discount') }}"
                        step="0.01" min="0"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                        placeholder="e.g. 1000">
                    <p class="text-xs text-gray-400 mt-1">Only applies to percentage discounts</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="minimum_order_value" class="block text-sm font-medium text-gray-700 mb-1">Minimum Order Value (₹)</label>
                    <input type="number" name="minimum_order_value" id="minimum_order_value" value="{{ old('minimum_order_value', 0) }}"
                        step="0.01" min="0"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                        placeholder="0">
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                    <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @error('expiry_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="usage_limit" class="block text-sm font-medium text-gray-700 mb-1">Total Usage Limit</label>
                    <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit') }}"
                        min="1"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                        placeholder="Unlimited">
                    <p class="text-xs text-gray-400 mt-1">Leave empty for unlimited</p>
                </div>

                <div>
                    <label for="usage_limit_per_user" class="block text-sm font-medium text-gray-700 mb-1">Per User Limit</label>
                    <input type="number" name="usage_limit_per_user" id="usage_limit_per_user" value="{{ old('usage_limit_per_user', 1) }}"
                        min="1"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div class="flex items-end pb-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                        <span class="text-sm font-medium text-gray-700">Active</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 font-medium">Create Coupon</button>
                <a href="{{ route('admin.coupons.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-gray-700">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
