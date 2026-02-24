@extends('admin.layouts.app')

@section('title', 'Edit Work Type')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Edit Work Type: {{ $work->name }}</h2>
        </div>
        
        <form action="{{ route('admin.works.update', $work) }}" method="POST" class="p-6 space-y-6">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $work->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $work->slug) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('description', $work->description) }}</textarea>
            </div>
            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">SEO Settings</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $work->meta_title) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('meta_description', $work->meta_description) }}</textarea>
                    </div>
                </div>
            </div>
            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ $work->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600">
                    <span class="text-sm text-gray-700">Active</span>
                </label>
            </div>
            <div class="flex justify-end gap-3 pt-6 border-t">
                <a href="{{ route('admin.works.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">Update Work Type</button>
            </div>
        </form>
    </div>
</div>
@push('scripts')<script>ClassicEditor.create(document.querySelector('#description')).catch(console.error);</script>@endpush
@endsection
