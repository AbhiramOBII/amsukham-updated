@extends('admin.layouts.app')

@section('title', 'Banners')
@section('page-title', 'Home Page Banners')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-600">Manage your home page slider banners</p>
    <a href="{{ route('admin.banners.create') }}" class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Banner
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Button</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($banners as $banner)
                <tr>
                    <td class="px-6 py-4">
                        @if($banner->image)
                            <img src="{{ $banner->image->url }}" alt="{{ $banner->title }}" class="h-16 w-28 object-cover rounded">
                        @else
                            <div class="h-16 w-28 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                                No Image
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $banner->title }}</div>
                        @if($banner->subtitle)
                            <div class="text-sm text-gray-500">{{ Str::limit($banner->subtitle, 50) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $banner->button_text ?? '-' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $banner->sort_order }}
                    </td>
                    <td class="px-6 py-4">
                        @if($banner->is_active)
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="text-amber-600 hover:text-amber-800 mr-3">Edit</a>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline" onsubmit="return confirm('Delete this banner?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        No banners found. <a href="{{ route('admin.banners.create') }}" class="text-amber-600 hover:underline">Create your first banner</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
