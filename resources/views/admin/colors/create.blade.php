@extends('admin.layouts.app')

@section('title', 'Add Color')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Add Color</h2>
        </div>
        
        <form action="{{ route('admin.colors.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" placeholder="Auto-generated" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hex Color Code</label>
                <div class="flex items-center gap-3">
                    <input type="color" name="hex_code" id="colorPicker" value="{{ old('hex_code', '#000000') }}" class="w-12 h-10 rounded border border-gray-300 cursor-pointer">
                    <input type="text" id="hexInput" value="{{ old('hex_code', '#000000') }}" placeholder="#000000" class="w-32 px-4 py-2 border border-gray-300 rounded-lg" readonly>
                </div>
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                    <span class="text-sm text-gray-700">Active</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t">
                <a href="{{ route('admin.colors.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">Create Color</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('colorPicker').addEventListener('input', function() {
        document.getElementById('hexInput').value = this.value;
        document.querySelector('input[name="hex_code"]').value = this.value;
    });
</script>
@endpush
@endsection
