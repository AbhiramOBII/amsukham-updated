<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Amsukham by Ram - Heritage Sarees')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:wght@400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/amsukham-logo.svg') }}" type="image/svg+xml">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'deep-maroon': '#87000D',
                        'royal-gold': '#D79B2F',
                        'soft-cream': '#FAEAC5',
                        'heritage-white': '#FFFFFF'
                    },
                    fontFamily: {
                        'serif': ['DM Serif Display', 'serif'],
                        'sans': ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
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
    @include('partials.mobile-menu')
    @include('partials.track-order-modal')

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
