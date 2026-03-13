<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Admin Portal Authentication</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#da0b0b",
                        "background-light": "#f8f5f5",
                        "background-dark": "#050A15",
                        "surface-dark": "#0A1120",
                        "accent-border": "#1E293B",
                    },
                    fontFamily: {
                        "display": ["Space Grotesk", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "sm": "0.25rem",
                        "lg": "0.375rem",
                        "xl": "0.5rem",
                        "full": "9999px"
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                    }
                },
            },
        }
    </script>
    <style>
        .glass-panel {
            background: rgba(10, 17, 32, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glow-input:focus-within {
            box-shadow: 0 0 15px rgba(218, 11, 11, 0.15);
            border-color: rgba(218, 11, 11, 0.4);
        }

        .btn-shadow {
            box-shadow: 0 4px 20px rgba(218, 11, 11, 0.3);
        }

        .scanlines {
            background: linear-gradient(to bottom,
                    rgba(255, 255, 255, 0),
                    rgba(255, 255, 255, 0) 50%,
                    rgba(0, 0, 0, 0.2) 50%,
                    rgba(0, 0, 0, 0.2));
            background-size: 100% 4px;
            pointer-events: none;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display antialiased min-h-screen flex flex-col relative overflow-hidden selection:bg-primary selection:text-white">
    <div
        class="absolute inset-0 z-0 bg-gradient-radial from-[#132342] to-background-dark opacity-50 pointer-events-none">
    </div>
    <div class="absolute inset-0 z-0 scanlines opacity-30 pointer-events-none"></div>
    <main
        class="relative z-10 flex flex-col flex-1 w-full max-w-md mx-auto min-h-screen px-6 pt-12 pb-8 justify-between">
        <div class="flex flex-col items-center mt-8">
            <div class="relative group">
                <div
                    class="absolute -inset-4 bg-primary/20 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-500">
                </div>
                <div
                    class="relative w-24 h-24 flex items-center justify-center bg-gradient-to-b from-slate-700 to-slate-900 rounded-2xl shadow-2xl border border-slate-600/50">
                    <div
                        class="absolute inset-[1px] rounded-2xl bg-[#080F1F] flex items-center justify-center overflow-hidden">
                        <div class="w-full h-full bg-cover bg-center opacity-90"
                            data-alt="Metallic abstract 3D shield geometric security icon"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCjJKDcNRZq4ivO4LRBGn-g-wG0VQn3wlZC-suT6zpzcLA_fbZXa4AJe_DpEy1xskkQl1LuNKeONwi3w8jxssL-qVGdtTsfnKuvgtLS9xcUkdhN7t6eXHj8HfR79aIZkcMexMhjlU2iEN6ArhYgY56E1b2TRaUsTVSYmR2FQEgmJjdISAWkCmPOJrQVpdM-puwEPxRpdeLRb4FwyfPqaQvsqKc53syHefvIKY-EoeGlYXzOEZnI154zsguEmNxl4UeEqPrOM0iMD6Z1");'>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span
                            class="material-symbols-outlined text-white/90 text-4xl absolute drop-shadow-lg z-10">shield_lock</span>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8 space-y-2">
                <h1 class="text-white text-3xl font-bold tracking-tight uppercase">Admin Access</h1>
                <div class="flex items-center gap-2 justify-center">
                    <span class="h-px w-8 bg-primary/50"></span>
                    <p class="text-slate-400 text-sm font-medium tracking-wide uppercase">Remitely Pay Secure Gateway
                    </p>
                    <span class="h-px w-8 bg-primary/50"></span>
                </div>
            </div>
        </div>
       <form action="{{ route('admin.login.submit') }}" method="POST" class="flex flex-col gap-6 w-full mt-8">
            @csrf

            <div class="space-y-2 group">
                <label class="text-xs font-bold text-slate-400 tracking-widest uppercase ml-1 flex items-center gap-2" for="email">
                    <span class="material-symbols-outlined text-[14px] text-primary">badge</span>
                    Admin ID
                </label>
                <div class="relative glow-input transition-all duration-300 rounded-sm bg-surface-dark border border-accent-border">
                    <input
                        name="phone"
                        id="phone"
                        autocomplete="off"
                        required
                        class="w-full bg-transparent text-white px-4 py-4 outline-none border-none ring-0 focus:ring-0 placeholder:text-slate-600 font-mono text-base tracking-wider"
                        placeholder="USR-774-X9"
                        type="text" />
                    <div class="absolute right-0 top-0 h-full w-1 bg-primary opacity-0 group-focus-within:opacity-100 transition-opacity"></div>
                </div>
            </div>

            <div class="space-y-2 group">
                <label class="text-xs font-bold text-slate-400 tracking-widest uppercase ml-1 flex items-center gap-2" for="password">
                    <span class="material-symbols-outlined text-[14px] text-primary">key</span>
                    Secure Key
                </label>
                <div class="relative glow-input transition-all duration-300 rounded-sm bg-surface-dark border border-accent-border flex items-center">
                    <input
                        name="password"
                        id="password"
                        required
                        autocomplete="off"
                        class="flex-1 bg-transparent text-white px-4 py-4 outline-none border-none ring-0 focus:ring-0 placeholder:text-slate-600 font-mono text-base tracking-[0.2em]"
                        placeholder="••••••••••••"
                        type="password" />
                    <button class="px-4 text-slate-500 hover:text-white transition-colors focus:outline-none" type="button">
                        <span class="material-symbols-outlined text-xl">visibility_off</span>
                    </button>
                    <div class="absolute right-0 top-0 h-full w-1 bg-primary opacity-0 group-focus-within:opacity-100 transition-opacity"></div>
                </div>
            </div>

            <button
                class="group relative w-full mt-6 overflow-hidden rounded-sm bg-primary py-4 text-white transition-all hover:bg-red-600 active:scale-[0.98] btn-shadow"
                type="submit">
                <div class="absolute inset-0 opacity-10"
                    style="background-image: repeating-linear-gradient(45deg, transparent, transparent 5px, #000 5px, #000 10px);">
                </div>
                <div class="relative flex items-center justify-center gap-3">
                    <span class="font-bold tracking-widest uppercase text-sm">Authenticate</span>
                    <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">login</span>
                </div>
            </button>

            <div class="flex justify-center mt-2">
                <button class="text-primary hover:text-white transition-colors p-2 rounded-full hover:bg-white/5" type="button">
                    <span class="material-symbols-outlined text-3xl">face</span>
                </button>
            </div>
        </form>

        <div class="mt-auto space-y-6 text-center">
            <div class="flex items-center justify-center gap-6 text-sm">
                <a class="text-slate-500 hover:text-white transition-colors" href="#">Recover ID</a>
                <span class="text-slate-700">•</span>
                <a class="text-slate-500 hover:text-white transition-colors" href="#">Support Access</a>
            </div>
            <div class="glass-panel rounded-sm p-3 border-l-2 border-l-primary/60">
                <p class="text-[10px] uppercase text-slate-500 leading-tight tracking-wide font-mono">
                    <span class="text-primary font-bold">Warning:</span> Restricted Area. Authorized Personnel Only. All
                    IP addresses are logged and monitored.
                </p>
            </div>
        </div>
    </main>

    <script>
        const togglePass = document.querySelector('#password + button');
        const passInput = document.querySelector('#password');

        togglePass.addEventListener('click', () => {
            const type = passInput.type === 'password' ? 'text' : 'password';
            passInput.type = type;
            togglePass.querySelector('span').textContent = type === 'password' ? 'visibility_off' : 'visibility';
        });
    </script>

</body>

</html>
