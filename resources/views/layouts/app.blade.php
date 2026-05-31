<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Amsukham by Ram - Heritage Sarees')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:wght@400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/amsukham-logo.svg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .brand-pattern-header {
            background-image: url('{{ asset("images/amsukham-new-shape-2.svg") }}');
            background-size: 160px 160px;
        }
        
        .decorative-title::before,
        .decorative-title::after {
            content: '';
            background-image: url('{{ asset("images/amsukham-shape.svg") }}');
        }

        @stack('styles')
    </style>
</head>
<body class="font-sans bg-soft-cream">
    @include('partials.topbar')
    @include('partials.header')
    @include('partials.marquee')
    @include('partials.mobile-menu')
    @include('partials.track-order-modal')
    @include('partials.search-overlay')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route("cart.count") }}', { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(data => {
                    document.querySelectorAll('.cart-count-badge').forEach(badge => {
                        badge.textContent = data.count;
                    });
                })
                .catch(() => {});
        });
    </script>
    @stack('scripts')
</body>
</html>
