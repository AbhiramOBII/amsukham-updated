@extends('admin.layouts.app')

@section('title', 'Colors')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-800">Colors</h2>
        <a href="{{ route('admin.colors.create') }}" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700">Add Color</a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Color</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($colors as $color)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="w-8 h-8 rounded-full border border-gray-300" style="background-color: {{ $color->hex_code ?? '#ccc' }}"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $color->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $color->slug }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $color->products()->count() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full {{ $color->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $color->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.colors.edit', $color) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                            <form action="{{ route('admin.colors.destroy', $color) }}" method="POST" class="inline" onsubmit="return confirm('Delete this color?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No colors yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($colors->hasPages())<div class="p-6 border-t border-gray-200">{{ $colors->links() }}</div>@endif
</div>
@endsection
