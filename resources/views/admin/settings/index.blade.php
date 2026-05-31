@extends('admin.layouts.app')

@section('title', 'Site Settings')
@section('page-title', 'Site Settings')

@section('content')
<div class="max-w-4xl">
    @if($settings->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500 mb-4">No settings found. Click below to create default settings.</p>
            <a href="{{ route('admin.settings.seed') }}" class="inline-block bg-amber-600 text-white px-6 py-2 rounded hover:bg-amber-700">
                Create Default Settings
            </a>
        </div>
    @else
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            @foreach($settings as $group => $groupSettings)
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 capitalize border-b pb-2">{{ $group }} Settings</h3>
                    <div class="space-y-4">
                        @foreach($groupSettings as $setting)
                            <div>
                                <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ $setting->label }}
                                </label>
                                @if($setting->type === 'textarea')
                                    <textarea 
                                        name="{{ $setting->key }}" 
                                        id="{{ $setting->key }}" 
                                        rows="3"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                                    >{{ $setting->value }}</textarea>
                                @elseif($setting->type === 'password')
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            name="{{ $setting->key }}" 
                                            id="{{ $setting->key }}" 
                                            value="{{ $setting->value }}"
                                            class="w-full border border-gray-300 rounded px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-amber-500"
                                        >
                                        <button type="button" onclick="togglePassword('{{ $setting->key }}')" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </button>
                                    </div>
                                @elseif($setting->type === 'select' && $setting->key === 'razorpay_mode')
                                    <select 
                                        name="{{ $setting->key }}" 
                                        id="{{ $setting->key }}"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                                    >
                                        <option value="test" {{ $setting->value === 'test' ? 'selected' : '' }}>Test Mode</option>
                                        <option value="live" {{ $setting->value === 'live' ? 'selected' : '' }}>Live Mode</option>
                                    </select>
                                @elseif($setting->type === 'number')
                                    <input 
                                        type="number" 
                                        name="{{ $setting->key }}" 
                                        id="{{ $setting->key }}" 
                                        value="{{ $setting->value }}"
                                        min="0"
                                        step="1"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                                    >
                                @else
                                    <input 
                                        type="text" 
                                        name="{{ $setting->key }}" 
                                        id="{{ $setting->key }}" 
                                        value="{{ $setting->value }}"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                                    >
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.settings.seed') }}" class="px-6 py-2 border border-gray-300 rounded hover:bg-gray-50">
                    Reset to Defaults
                </a>
                <button type="submit" class="bg-amber-600 text-white px-6 py-2 rounded hover:bg-amber-700">
                    Save Settings
                </button>
            </div>
        </form>
    @endif
</div>

@push('scripts')
<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endpush
@endsection
