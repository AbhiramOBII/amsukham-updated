@extends('admin.layouts.app')

@section('title', 'Edit SEO - ' . ucwords(str_replace('-', ' ', $seo->page_identifier)))

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">SEO Settings: {{ ucwords(str_replace('-', ' ', $seo->page_identifier)) }}</h2>
        </div>
        
        <form action="{{ route('admin.seo.update', $seo->page_identifier) }}" method="POST" class="p-6 space-y-6">
            @csrf @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                <input type="text" name="meta_title" value="{{ old('meta_title', $seo->meta_title) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                <p class="text-sm text-gray-500 mt-1">Recommended: 50-60 characters</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                <textarea name="meta_description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">{{ old('meta_description', $seo->meta_description) }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Recommended: 150-160 characters</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $seo->meta_keywords) }}" placeholder="keyword1, keyword2, keyword3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Open Graph (Social Sharing)</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">OG Title</label>
                        <input type="text" name="og_title" value="{{ old('og_title', $seo->og_title) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">OG Description</label>
                        <textarea name="og_description" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('og_description', $seo->og_description) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">OG Image URL</label>
                        <input type="text" name="og_image" value="{{ old('og_image', $seo->og_image) }}" placeholder="https://example.com/image.jpg" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t">
                <a href="{{ route('admin.seo.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
