<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taste of Home</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Add Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            light: '#DF9455',
                            DEFAULT: '#F9A55F', 
                            dark: '#C6834C'
                        }
                    },
                    borderRadius: {
                        '3xl': '1.5rem',
                        '4xl': '2rem',
                    },
                    maxWidth: {
                        '8xl': '88rem',
                    },
                    screens: {
                        '2xl': '1536px',
                    },
                    gridTemplateColumns: {
                        '7': 'repeat(7, minmax(0, 1fr))',
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'soft-lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                        'soft-xl': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                        'glow': '0 0 20px rgba(99, 102, 241, 0.15)',
                    }
                }
            }
        }
    </script>

    @livewireStyles
</head>
<body class="min-h-screen flex font-inter" style="background-color: #EEE6DE;">

    {{-- Page content --}}
    <div class="flex flex-1">
        {{-- Include sidebar --}}
        @php
        $section = match (true) {
            request()->is('orders*') => 'orders',
            request()->is('products*') => 'products',
            request()->is('payments*') => 'payments',
            request()->is('reports*') => 'reports',
            request()->is('users*') => 'users',
            request()->is('dashboard*') => 'dashboard',
            default => ''
        };
        @endphp
        <x-layouts.sidebar :activeSection="$section" />

        {{-- Main content with no extra padding or background --}}
        <main class="flex-1 p-6 ml-48">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>