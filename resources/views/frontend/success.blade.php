<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Transaction Success</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#da0b0b",
                        "background-light": "#f8f5f5",
                        "background-dark": "#09090b",
                        "surface-dark": "#18181b", 
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "full": "9999px"
                    },
                    boxShadow: {
                        'glow-green': '0 0 20px 5px rgba(34, 197, 94, 0.3)',
                    }
                },
            },
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
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

<body
class="bg-background-light dark:bg-background-dark min-h-screen text-slate-900 dark:text-white flex flex-col items-center justify-center font-display antialiased selection:bg-primary selection:text-white">

@php
    $amount = $data['টাকা'] ?? 0;
    $balance = auth()->user()->balance ?? 0;
@endphp

<div class="relative w-full max-w-md h-screen flex flex-col bg-background-light dark:bg-background-dark overflow-hidden shadow-2xl">

    <!-- Header -->
    <div class="flex items-center justify-between p-6 z-10">
        <a href="{{ url('/') }}"
            class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-black/5 dark:hover:bg-white/10 transition-colors">
            <span class="material-symbols-outlined text-slate-900 dark:text-white">close</span>
        </a>
        <div class="text-xs font-medium uppercase tracking-widest text-slate-500 dark:text-slate-400">
            Receipt
        </div>
        <div class="w-10"></div>
    </div>

    <!-- Scroll Area -->
    <div class="flex-1 overflow-y-auto no-scrollbar px-6 pb-32 flex flex-col items-center">

        <!-- Success Icon -->
        <div class="mt-8 mb-6 relative">
            <div class="absolute inset-0 bg-green-500/20 rounded-full blur-xl animate-pulse"></div>
            <div class="relative w-24 h-24 rounded-full bg-green-500/10 border-2 border-green-500 shadow-glow-green flex items-center justify-center">
                <span class="material-symbols-outlined text-green-500 text-[48px] font-bold">check</span>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-center mb-2">
            {{ $title }} সফল হয়েছে
        </h1>

        <p class="text-slate-500 dark:text-slate-400 text-sm mb-8 text-center">
            আপনার আবেদন সফলভাবে গ্রহণ করা হয়েছে।
        </p>

        <!-- Big Amount -->
        <div class="text-[40px] font-extrabold leading-none tracking-tight mb-10 text-center">
            {{ number_format($amount) }}
            <span class="text-2xl text-slate-400 font-bold">BDT</span>
        </div>

        <!-- Receipt Card -->
        <div class="w-full bg-white dark:bg-surface-dark rounded-2xl px-6 py-3 shadow-sm border border-slate-200 dark:border-white/5 relative overflow-hidden">

            <div class="space-y-1">

                <!-- Loop Dynamic Data -->
                @foreach($data as $label => $value)
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            {{ $label }}
                        </span>

                        <span class="text-sm font-semibold text-slate-900 dark:text-white text-right">
                            @if($label == 'টাকা')
                                {{ number_format($value) }} BDT
                            @elseif($label == 'তারিখ')
                                {{ \Carbon\Carbon::parse($value)->format('d M Y, h:i A') }}
                            @else
                                {{ $value }}
                            @endif
                        </span>
                    </div>
                @endforeach

                <!-- Current Balance -->
                <div class="pt-4 mt-4 border-t border-dashed border-slate-200 dark:border-white/10 flex justify-between items-end">
                    <span class="text-sm font-medium text-slate-500 dark:text-slate-400">
                        বর্তমান ব্যালেন্স
                    </span>
                    <span class="text-lg font-bold text-slate-900 dark:text-white">
                        {{ number_format($balance) }} BDT
                    </span>
                </div>

            </div>

            <!-- Bottom design -->
            <div class="absolute bottom-0 left-0 w-full h-2 bg-background-light dark:bg-background-dark"
                style="mask-image: radial-gradient(circle, transparent 5px, black 6px); mask-size: 16px 16px; mask-position: bottom;
                -webkit-mask-image: radial-gradient(circle, transparent 5px, black 6px);
                -webkit-mask-size: 16px 16px; -webkit-mask-position: bottom;">
            </div>
        </div>

        <!-- Support -->
        {{-- <button class="mt-8 text-sm font-medium text-primary hover:text-red-400 transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">help</span>
            Report an issue
        </button> --}}

    </div>

    <!-- Bottom Buttons -->
    <div class="absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-background-light via-background-light to-transparent dark:from-background-dark dark:via-background-dark dark:to-transparent pt-12">

        <div class="flex flex-col gap-3">
            {{-- <button
                class="w-full h-14 rounded-xl border border-slate-300 dark:border-white/20 bg-transparent font-semibold flex items-center justify-center gap-2 hover:bg-slate-50 dark:hover:bg-white/5 active:scale-[0.98] transition-all">
                <span class="material-symbols-outlined">ios_share</span>
                Share Receipt
            </button> --}}

            <a href="{{ url('/') }}"
                class="w-full h-14 rounded-xl bg-primary text-white font-bold flex items-center justify-center hover:bg-red-700 active:scale-[0.98] transition-all">
                Back to Home
            </a>
        </div>

        <div class="h-6 w-full"></div>
    </div>

</div>
</body>


</html>
