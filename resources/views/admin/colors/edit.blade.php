@extends('admin.layouts.app')

@section('title', 'Edit Color')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Edit Color: {{ $color->name }}</h2>
        </div>
        
        <form action="{{ route('admin.colors.update', $color) }}" method="POST" class="p-6 space-y-6">
            @csrf @method('PUT')
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $color->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $color->slug) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hex Color Code</label>
                <div class="flex items-center gap-3">
                    <input type="color" id="colorPicker" value="{{ old('hex_code', $color->hex_code ?? '#000000') }}" class="w-12 h-10 rounded border border-gray-300 cursor-pointer">
                    <input type="text" name="hex_code" id="hexInput" value="{{ old('hex_code', $color->hex_code ?? '#000000') }}" placeholder="#000000" class="w-32 px-4 py-2 border border-gray-300 rounded-lg uppercase">
                </div>
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ $color->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                    <span class="text-sm text-gray-700">Active</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t">
                <a href="{{ route('admin.colors.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">Update Color</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const colorPicker = document.getElementById('colorPicker');
        const hexInput = document.getElementById('hexInput');

        // When color picker changes, update text input
        colorPicker.addEventListener('input', function() {
            hexInput.value = this.value.toUpperCase();
        });

        // When text input changes, update color picker if valid hex
        hexInput.addEventListener('input', function() {
            let val = this.value;
            
            // Add # if missing
            if (!val.startsWith('#') && val.length > 0) {
                val = '#' + val;
            }
            
            // Basic hex validation before applying to color picker
            if (/^#[0-9A-Fa-f]{6}$/.test(val) || /^#[0-9A-Fa-f]{3}$/.test(val)) {
                colorPicker.value = val;
            }
        });
        
        // On blur, format to full uppercase 6-digit hex if possible
        hexInput.addEventListener('blur', function() {
            let val = this.value;
            if (!val.startsWith('#')) val = '#' + val;
            
            if (/^#[0-9A-Fa-f]{3}$/.test(val)) {
                // Convert 3-digit hex to 6-digit hex
                val = '#' + val[1]+val[1] + val[2]+val[2] + val[3]+val[3];
            }
            
            if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                this.value = val.toUpperCase();
            }
        });
    });
</script>
@endpush
@endsection
