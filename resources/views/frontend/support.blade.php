@extends('frontend.layout.master')
@section('meta')
    <link rel="canonical" href="{{ route('user.index') }}" />
@endsection
@section('style')
    <style>
        body {
            font-family: 'Manrope', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .neon-glow {
            box-shadow: 0 0 20px rgba(242, 13, 13, 0.4);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
@endsection

@section('content')
    <!-- Main Container -->
    <div class="relative flex h-screen w-full flex-col overflow-hidden max-w-[430px] mx-auto shadow-2xl border-x border-white/5">
        <!-- TopAppBar Component -->
        <div class="flex items-center bg-background-light dark:bg-background-dark p-4 pb-2 justify-between z-10">
            <a href="{{ route('user.index') }}">
                <div class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 cursor-pointer">
                    <span class="material-symbols-outlined text-black dark:text-white">
                        arrow_back_ios_new
                    </span>
                </div>
            </a>
            <h2 class="text-white text-lg font-bold leading-tight tracking-tight flex-1 text-center">Support Center</h2>
            <div class="flex w-12 items-center justify-end">
                <div class="flex items-center gap-1.5 bg-primary/10 px-3 py-1 rounded-full border border-primary/20">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                    <p class="text-primary text-[10px] font-bold uppercase tracking-wider">Online</p>
                </div>
            </div>
        </div>
        <!-- Content Area -->
        <div class="flex-1 flex flex-col items-center justify-center px-6 pb-20">
            <!-- Hero HeaderImage Visual (3D Bubble Container) -->
            <div class="relative w-full aspect-square max-w-[280px] flex items-center justify-center mb-8">
                <!-- Background Glow -->
                <div class="absolute inset-0 bg-primary/20 blur-[80px] rounded-full"></div>
                <!-- 3D Glossy Bubble Concept -->
                <div
                    class="relative z-10 w-48 h-48 bg-gradient-to-br from-primary via-primary to-red-900 rounded-full flex items-center justify-center shadow-2xl overflow-hidden border border-white/20">
                    <!-- Gloss Layer -->
                    <div class="absolute top-0 left-0 w-full h-1/2 bg-gradient-to-b from-white/30 to-transparent"></div>
                    <!-- Icon -->
                    <span class="material-symbols-outlined text-white text-7xl drop-shadow-lg"
                        style="font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 48">forum</span>
                    <!-- Reflection -->
                    <div class="absolute bottom-4 right-8 w-12 h-4 bg-white/10 blur-md rotate-45 rounded-full"></div>
                </div>
            </div>
            <!-- HeadlineText Component -->
            <div class="text-center mb-2">
                <h1 class="text-white tracking-tight text-3xl font-extrabold leading-tight">We're here to help</h1>
            </div>
            <!-- BodyText Component -->
            <div class="text-center mb-10">
                <p class="text-gray-400 text-base font-medium leading-relaxed max-w-[280px] mx-auto">
                    Agents are online and ready to chat with you right now.
                </p>
            </div>
            <!-- SingleButton Component (WhatsApp) -->
            <div class="w-full max-w-xs space-y-4">
                <a href="https://wa.me/8801812345678" target="_blank">
                    <button
                        class="w-full flex cursor-pointer items-center justify-center overflow-hidden rounded-full h-14 px-6 bg-gradient-to-r from-primary to-[#ff4d4d] text-white gap-3 neon-glow transition-transform active:scale-95 group">

                        <div class="text-white flex items-center justify-center">
                            <!-- SVG -->
                        </div>

                        <span class="truncate text-base font-bold leading-normal tracking-wide">
                            Chat on WhatsApp
                        </span>

                    </button>
                </a>

                <!-- Secondary Support -->
                {{-- <div class="flex justify-between px-2">
                    <button
                        class="text-xs font-bold text-gray-500 hover:text-white transition-colors uppercase tracking-widest flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">mail</span>
                        Email Us
                    </button>
                    <button
                        class="text-xs font-bold text-gray-500 hover:text-white transition-colors uppercase tracking-widest flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">help</span>
                        FAQ Center
                    </button>
                </div> --}}
            </div>
        </div>
       
@endsection


@section('script')
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#f20d0d",
                        "background-light": "#f8f5f5",
                        "background-dark": "#101010",
                        "card-dark": "#1a1a1a"
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "1rem",
                        "lg": "2rem",
                        "xl": "3rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
@endsection