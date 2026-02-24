@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Edit Category: {{ $category->name }}</h2>
        </div>
        
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $category->slug) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                <div class="flex items-center gap-4">
                    <div id="imagePreview" class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                        @if($category->image)
                            <img src="{{ $category->image->url }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        @endif
                    </div>
                    <input type="hidden" name="image_id" id="image_id" value="{{ old('image_id', $category->image_id) }}">
                    <button type="button" onclick="openMediaBrowser()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Select Image
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">SEO Settings</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old('meta_description', $category->meta_description) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $category->meta_keywords) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                    <span class="text-sm text-gray-700">Active</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">Update Category</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    ClassicEditor.create(document.querySelector('#description')).catch(console.error);

    function openMediaBrowser() {
        window.open('{{ route("admin.media.browse") }}', 'mediaBrowser', 'width=900,height=600');
    }

    function selectMedia(id, url) {
        document.getElementById('image_id').value = id;
        document.getElementById('imagePreview').innerHTML = `<img src="${url}" class="w-full h-full object-cover">`;
    }
</script>
@endpush
@endsection
