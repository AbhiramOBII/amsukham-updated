@extends('admin.layouts.app')

@section('title', 'Edit Banner')
@section('page-title', 'Edit Banner')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.banners.update', $banner) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Banner Details</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $banner->title) }}" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $banner->subtitle) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('description', $banner->description) }}</textarea>
                </div>

                <div>
                    <label for="button_text" class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
                    <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $banner->button_text) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label for="button_link" class="block text-sm font-medium text-gray-700 mb-1">Button Link</label>
                    <input type="text" name="button_link" id="button_link" value="{{ old('button_link', $banner->button_link) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $banner->sort_order) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                    <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active</label>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Banner Images</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Desktop Image (Recommended: 1920x800)</label>
                    <input type="hidden" name="image_id" id="image_id" value="{{ old('image_id', $banner->image_id) }}">
                    <div id="image_preview" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-amber-500" onclick="openMediaBrowser('image_id', 'image_preview')">
                        @if($banner->image)
                            <img src="{{ $banner->image->url }}" class="max-h-40 mx-auto rounded">
                        @else
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="mt-2 text-sm text-gray-500">Click to select image</p>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Image (Optional, 768x600)</label>
                    <input type="hidden" name="mobile_image_id" id="mobile_image_id" value="{{ old('mobile_image_id', $banner->mobile_image_id) }}">
                    <div id="mobile_image_preview" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-amber-500" onclick="openMediaBrowser('mobile_image_id', 'mobile_image_preview')">
                        @if($banner->mobileImage)
                            <img src="{{ $banner->mobileImage->url }}" class="max-h-40 mx-auto rounded">
                        @else
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="mt-2 text-sm text-gray-500">Click to select image</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.banners.index') }}" class="px-6 py-2 border border-gray-300 rounded hover:bg-gray-50">Cancel</a>
            <button type="submit" class="bg-amber-600 text-white px-6 py-2 rounded hover:bg-amber-700">Update Banner</button>
        </div>
    </form>
</div>

<script>
let currentInputId = '';
let currentPreviewId = '';

function openMediaBrowser(inputId, previewId) {
    currentInputId = inputId;
    currentPreviewId = previewId;
    window.open('{{ route("admin.media.browse") }}', 'mediaBrowser', 'width=1000,height=700');
}

window.selectMedia = function(id, url) {
    if (currentInputId && currentPreviewId) {
        document.getElementById(currentInputId).value = id;
        document.getElementById(currentPreviewId).innerHTML = '<img src="' + url + '" class="max-h-40 mx-auto rounded">';
    }
};
</script>
@endsection
