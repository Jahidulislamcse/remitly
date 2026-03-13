<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'RemitlyPay')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/emoji-mart@latest/css/emoji-mart.css" />
    <script
        id="tailwind-config">tailwind.config = { darkMode: "class", theme: { extend: { colors: { primary: "#EA2831", "accent-dark": "#1A1A1A", "background-light": "#f8f6f6", "background-dark": "#211111" }, fontFamily: { display: "Manrope" }, borderRadius: { DEFAULT: "0.25rem", lg: "0.5rem", xl: "0.75rem", full: "9999px" } } } };</script>

    <style type="text/tailwindcss">
        .glass-header {
            @apply bg-primary;
        }
        .dark .glass-header {
            background: linear-gradient(180deg, #0A0A0A 0%, #1A1A1A 100%);
        }
                .service-tile {
            transition: transform 0.2s;
        }
        .service-tile:active {
            transform: scale(0.95);
        }
        .ios-shadow {
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-[#1A1A1A] dark:text-white min-h-screen pb-24">

    <div class="w-full sm:max-w-[420px] sm:mx-auto">
        <main class="mt-4">
            @yield('content')
        </main>
    </div>


    @yield('script')
    <script>
        const html = document.documentElement;
        const toggleBtn = document.getElementById('themeToggle');
        const icon = document.getElementById('themeIcon');

        function setTheme(mode) {
            if (mode === 'dark') {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                if(icon) icon.textContent = 'light_mode';
            } else {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                if(icon) icon.textContent = 'dark_mode';
            }
        }

        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            setTheme(savedTheme);
        } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            setTheme('dark');
        } else {
            setTheme('light');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                if (html.classList.contains('dark')) {
                    setTheme('light');
                } else {
                    setTheme('dark');
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>
</body>
</html>
