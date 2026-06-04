@extends('admin.layouts.app')

@section('title', 'Create Order')

@section('content')
<div class="max-w-5xl">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Create Order</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Orders</a>
            </div>
        </div>

        @if(session('error'))
            <div class="mx-6 mt-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.orders.store') }}" method="POST" id="createOrderForm" class="p-6 space-y-8">
            @csrf

            {{-- Customer Information --}}
            <div>
                <h3 class="text-md font-semibold text-gray-700 mb-4 pb-2 border-b">Customer Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                        <input type="text" name="billing_name" value="{{ old('billing_name') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('billing_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" name="billing_email" value="{{ old('billing_email') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('billing_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                        <input type="text" name="billing_phone" value="{{ old('billing_phone') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('billing_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div>
                <h3 class="text-md font-semibold text-gray-700 mb-4 pb-2 border-b">Shipping Address</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                        <input type="text" name="billing_address" value="{{ old('billing_address') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('billing_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                        <input type="text" name="billing_city" value="{{ old('billing_city') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('billing_city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                        <input type="text" name="billing_state" value="{{ old('billing_state') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('billing_state') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pincode *</label>
                        <input type="text" name="billing_pincode" value="{{ old('billing_pincode') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('billing_pincode') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Payment --}}
            <div>
                <h3 class="text-md font-semibold text-gray-700 mb-4 pb-2 border-b">Payment</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method *</label>
                        <select name="payment_method" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="manual" {{ old('payment_method', 'manual') == 'manual' ? 'selected' : '' }}>Manual / Cash</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="upi" {{ old('payment_method') == 'upi' ? 'selected' : '' }}>UPI</option>
                            <option value="razorpay" {{ old('payment_method') == 'razorpay' ? 'selected' : '' }}>Razorpay</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status *</label>
                        <select name="payment_status" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="paid" {{ old('payment_status', 'paid') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Order Items --}}
            <div>
                <h3 class="text-md font-semibold text-gray-700 mb-4 pb-2 border-b">Order Items</h3>
                @error('items') <p class="text-red-500 text-xs mb-2">{{ $message }}</p> @enderror

                {{-- Product Search --}}
                <div class="relative mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search Product</label>
                    <input type="text" id="productSearch" placeholder="Type product name or SKU..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"
                        autocomplete="off">
                    <div id="searchResults" class="absolute z-10 w-full bg-white border border-gray-200 rounded-lg shadow-lg mt-1 hidden max-h-72 overflow-y-auto"></div>
                </div>

                {{-- Items Table --}}
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-4 py-3 font-medium text-gray-600">Product</th>
                                <th class="text-left px-4 py-3 font-medium text-gray-600 w-32">Color</th>
                                <th class="text-center px-4 py-3 font-medium text-gray-600 w-24">Qty</th>
                                <th class="text-right px-4 py-3 font-medium text-gray-600 w-28">Price</th>
                                <th class="text-right px-4 py-3 font-medium text-gray-600 w-28">Total</th>
                                <th class="px-4 py-3 w-12"></th>
                            </tr>
                        </thead>
                        <tbody id="orderItems">
                            <tr id="emptyRow">
                                <td colspan="6" class="px-4 py-8 text-center text-gray-400">No items added. Search for a product above.</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-right font-medium text-gray-700">Subtotal</td>
                                <td class="px-4 py-3 text-right font-semibold text-gray-800" id="subtotalDisplay">₹0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Order Notes</label>
                <textarea name="notes" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('notes') }}</textarea>
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit" class="px-6 py-2.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 text-sm font-medium">
                    Create Order
                </button>
                <a href="{{ route('admin.orders.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('productSearch');
    const searchResults = document.getElementById('searchResults');
    const orderItems = document.getElementById('orderItems');
    const emptyRow = document.getElementById('emptyRow');
    const subtotalDisplay = document.getElementById('subtotalDisplay');
    let searchTimeout;
    let itemIndex = 0;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }
        searchTimeout = setTimeout(() => {
            fetch(`{{ route('admin.orders.search-products') }}?q=${encodeURIComponent(query)}`)
                .then(r => r.json())
                .then(products => {
                    if (products.length === 0) {
                        searchResults.innerHTML = '<div class="px-4 py-3 text-sm text-gray-400">No products found</div>';
                    } else {
                        searchResults.innerHTML = products.map(p => `
                            <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 flex items-center gap-3 product-result"
                                 data-product='${JSON.stringify(p).replace(/'/g, "&#39;")}'>
                                ${p.thumbnail ? `<img src="${p.thumbnail}" class="w-10 h-10 object-cover rounded">` : '<div class="w-10 h-10 bg-gray-100 rounded flex items-center justify-center text-gray-400 text-xs">No img</div>'}
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-gray-800 truncate">${p.name}</div>
                                    <div class="text-xs text-gray-500">SKU: ${p.sku} &middot; Stock: ${p.stock} &middot; ₹${Number(p.display_price).toLocaleString('en-IN')}</div>
                                </div>
                            </div>
                        `).join('');
                    }
                    searchResults.classList.remove('hidden');
                });
        }, 300);
    });

    searchResults.addEventListener('click', function(e) {
        const result = e.target.closest('.product-result');
        if (!result) return;
        const product = JSON.parse(result.dataset.product);
        addItem(product);
        searchInput.value = '';
        searchResults.classList.add('hidden');
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });

    function addItem(product) {
        emptyRow.style.display = 'none';
        const idx = itemIndex++;

        let colorOptions = '<option value="">No color</option>';
        if (product.colors && product.colors.length > 0) {
            colorOptions = '<option value="">Select color</option>' + product.colors.map(c =>
                `<option value="${c.id}">${c.name} (${c.stock} in stock)</option>`
            ).join('');
        }

        const tr = document.createElement('tr');
        tr.className = 'border-t border-gray-100 item-row';
        tr.dataset.price = product.display_price;
        tr.innerHTML = `
            <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                    ${product.thumbnail ? `<img src="${product.thumbnail}" class="w-8 h-8 object-cover rounded">` : ''}
                    <div>
                        <div class="font-medium text-gray-800 text-sm">${product.name}</div>
                        <div class="text-xs text-gray-500">${product.sku}</div>
                    </div>
                </div>
                <input type="hidden" name="items[${idx}][product_id]" value="${product.id}">
            </td>
            <td class="px-4 py-3">
                <select name="items[${idx}][product_color_id]" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                    ${colorOptions}
                </select>
            </td>
            <td class="px-4 py-3 text-center">
                <input type="number" name="items[${idx}][quantity]" value="1" min="1" max="${product.stock}"
                    class="w-16 border border-gray-300 rounded px-2 py-1 text-sm text-center qty-input">
            </td>
            <td class="px-4 py-3 text-right text-sm text-gray-700">₹${Number(product.display_price).toLocaleString('en-IN')}</td>
            <td class="px-4 py-3 text-right text-sm font-medium text-gray-800 line-total">₹${Number(product.display_price).toLocaleString('en-IN')}</td>
            <td class="px-4 py-3 text-center">
                <button type="button" class="text-red-500 hover:text-red-700 remove-item" title="Remove">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </td>
        `;
        orderItems.appendChild(tr);

        tr.querySelector('.qty-input').addEventListener('input', function() {
            updateLineTotal(tr);
            updateSubtotal();
        });

        tr.querySelector('.remove-item').addEventListener('click', function() {
            tr.remove();
            updateSubtotal();
            if (orderItems.querySelectorAll('.item-row').length === 0) {
                emptyRow.style.display = '';
            }
        });

        updateSubtotal();
    }

    function updateLineTotal(row) {
        const price = parseFloat(row.dataset.price);
        const qty = parseInt(row.querySelector('.qty-input').value) || 0;
        const total = price * qty;
        row.querySelector('.line-total').textContent = '₹' + total.toLocaleString('en-IN');
    }

    function updateSubtotal() {
        let subtotal = 0;
        orderItems.querySelectorAll('.item-row').forEach(row => {
            const price = parseFloat(row.dataset.price);
            const qty = parseInt(row.querySelector('.qty-input').value) || 0;
            subtotal += price * qty;
        });
        subtotalDisplay.textContent = '₹' + subtotal.toLocaleString('en-IN', { minimumFractionDigits: 2 });
    }
});
</script>
@endpush
@endsection
