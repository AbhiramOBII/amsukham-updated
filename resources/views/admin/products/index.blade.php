@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between gap-4">
        <h2 class="text-lg font-semibold text-gray-800 shrink-0">Products</h2>
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex-1 max-w-md">
            <div class="relative">
                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Search by name, SKU or category…"
                    class="w-full border border-gray-300 rounded-lg pl-9 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                >
                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                </svg>
                @if($search)
                    <a href="{{ route('admin.products.index') }}" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600 text-xs">✕ Clear</a>
                @endif
            </div>
        </form>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.products.bulk.index') }}" class="border border-amber-600 text-amber-600 px-4 py-2 rounded-lg hover:bg-amber-50 transition">Bulk Upload</a>
            <a href="{{ route('admin.products.create') }}" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700">Add Product</a>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Pre-Booking</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->thumbnail)
                                <img src="{{ $product->thumbnail->url }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                            @elseif($product->primaryImage && $product->primaryImage->media)
                                <img src="{{ $product->primaryImage->media->url }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $product->name }}</div>
                            <div class="text-sm text-gray-500">{{ $product->sku }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->discount > 0)
                                <div class="text-sm text-gray-500 line-through">₹{{ number_format($product->price, 2) }}</div>
                                <div class="font-medium text-green-600">₹{{ number_format($product->discounted_price, 2) }}</div>
                            @else
                                <div class="font-medium text-gray-900">₹{{ number_format($product->price, 2) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->productColors->count() > 0 ? $product->productColors->sum('stock') : $product->stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if($product->is_featured)
                                <span class="px-2 py-1 text-xs rounded-full bg-amber-100 text-amber-800 ml-1">Featured</span>
                            @endif
                            </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <input
                                type="checkbox"
                                class="w-4 h-4 accent-amber-600 cursor-pointer"
                                data-toggle-url="{{ route('admin.products.toggle-prebooking', $product) }}"
                                {{ $product->is_preorder ? 'checked' : '' }}
                                onchange="togglePrebooking(this)"
                            >
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-6 py-4 text-center text-gray-500">No products yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())<div class="p-6 border-t border-gray-200">{{ $products->links() }}</div>@endif
</div>
@endsection

@push('scripts')
<script>
function togglePrebooking(checkbox) {
    fetch(checkbox.dataset.toggleUrl, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) checkbox.checked = !checkbox.checked; // revert on failure
    })
    .catch(() => {
        checkbox.checked = !checkbox.checked; // revert on error
        alert('Failed to update. Please try again.');
    });
}
</script>
@endpush
