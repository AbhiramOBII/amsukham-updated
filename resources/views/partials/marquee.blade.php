@php
    $marqueeEnabled = App\Models\SiteSetting::get('marquee_enabled', '0');
    $marqueeText = App\Models\SiteSetting::get('marquee_text', '');
@endphp

@if($marqueeEnabled && $marqueeText)
<div class="bg-red-600 text-white py-2 overflow-hidden relative" id="announcement-bar">
    <div class="marquee-container flex whitespace-nowrap">
        <div class="marquee-content flex items-center animate-marquee">
            @foreach(explode('|', $marqueeText) as $message)
                <span class="mx-8 text-sm font-medium tracking-wide">{{ trim($message) }}</span>
                <span class="mx-2 text-red-300">&#9830;</span>
            @endforeach
            @foreach(explode('|', $marqueeText) as $message)
                <span class="mx-8 text-sm font-medium tracking-wide">{{ trim($message) }}</span>
                <span class="mx-2 text-red-300">&#9830;</span>
            @endforeach
        </div>
    </div>
</div>

<style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-marquee {
        animation: marquee 30s linear infinite;
    }
    .animate-marquee:hover {
        animation-play-state: paused;
    }
</style>
@endif
