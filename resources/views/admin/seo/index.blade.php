@extends('admin.layouts.app')

@section('title', 'SEO Settings')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">SEO Settings</h2>
        <p class="text-sm text-gray-500 mt-1">Manage SEO settings for different pages</p>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $pages = [
                    'home' => 'Home Page',
                    'products' => 'Products Page',
                    'latest-collections' => 'Latest Collections',
                    'about' => 'About Page',
                    'contact' => 'Contact Page',
                ];
            @endphp

            @foreach($pages as $identifier => $name)
                @php
                    $seo = $seoSettings->where('page_identifier', $identifier)->first();
                @endphp
                <div class="border border-gray-200 rounded-lg p-4 hover:border-amber-500 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-medium text-gray-900">{{ $name }}</h3>
                        @if($seo)
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Configured</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Not Set</span>
                        @endif
                    </div>
                    @if($seo && $seo->meta_title)
                        <p class="text-sm text-gray-500 truncate">{{ $seo->meta_title }}</p>
                    @endif
                    <a href="{{ route('admin.seo.edit', $identifier) }}" class="mt-3 inline-block text-sm text-amber-600 hover:text-amber-700">Edit Settings →</a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
