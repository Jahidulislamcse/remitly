<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Redotpay Style Login</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;display=swap"
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
                        "primary": "#f20d0d",
                        "background-light": "#f8f5f5",
                        "background-dark": "#0F0F0F",
                        "surface-dark": "#1A1A1A",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: { "DEFAULT": "1rem", "lg": "2rem", "xl": "3rem", "full": "9999px" },
                    boxShadow: {
                        "neon": "0 0 20px rgba(242, 13, 13, 0.4)",
                        "neon-hover": "0 0 30px rgba(242, 13, 13, 0.6)",
                    }
                },
            },
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .logo-glow {
            background: radial-gradient(circle, rgba(242, 13, 13, 0.3) 0%, rgba(242, 13, 13, 0) 70%);
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display min-h-screen flex flex-col justify-between overflow-x-hidden transition-colors duration-300">
    <div class="flex-1 flex flex-col items-center justify-center pt-12 pb-6 px-6 relative w-full">
        <div
            class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 logo-glow pointer-events-none">
        </div>
        <div class="relative z-10 mb-8">
            <div
                class="w-20 h-20 bg-surface-dark rounded-2xl flex items-center justify-center border border-white/5 shadow-2xl">
                <span class="material-symbols-outlined text-primary text-5xl">
                    payments
                </span>
            </div>
        </div>
        <div class="text-center z-10">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-2">Welcome Back</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Securely access your digital wallet</p>
        </div>
    </div>
    <div class="w-full max-w-[480px] mx-auto px-6 pb-4 flex flex-col gap-5">
        <form action="{{ route('user.login.submit') }}" method="post" class="flex flex-col gap-5 w-full">
            @csrf

            <!-- Phone Input -->
            <div class="group relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors">
                        call
                    </span>
                </div>
                <input
                    name="phone"
                    required
                    class="block w-full pl-12 pr-4 py-4 bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 rounded-full text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 text-base font-medium h-14"
                    placeholder="Phone Number"
                    type="tel" />
            </div>

            <!-- Password Input -->
            <div class="group relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors">
                        lock
                    </span>
                </div>
                <input
                    name="password"
                    required
                    class="block w-full pl-12 pr-12 py-4 bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 rounded-full text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 text-base font-medium h-14"
                    placeholder="Password"
                    type="password" />
                <button
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-white transition-colors focus:outline-none"
                    type="button">
                    <span class="material-symbols-outlined">visibility_off</span>
                </button>
            </div>

            <!-- Forgot Password -->
            <div class="flex justify-end">
                <a class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-white transition-colors"
                    href="{{ route('password.request') }}">
                    Forgot Password?
                </a>
            </div>

            <!-- Login Buttons -->
            <div class="flex items-center gap-4 mt-2">
                <button type="submit"
                    class="flex-1 bg-primary hover:bg-red-600 text-white font-bold text-lg py-4 rounded-full shadow-neon hover:shadow-neon-hover transition-all duration-300 flex items-center justify-center gap-2 transform active:scale-[0.98]">
                    Log In
                    <span class="material-symbols-outlined text-xl">arrow_forward</span>
                </button>

                <button type="button" aria-label="Biometric Login"
                    class="w-14 h-14 bg-surface-dark border border-white/10 rounded-full flex items-center justify-center text-primary hover:bg-white/5 hover:border-primary/50 transition-all duration-300 transform active:scale-95">
                    <span class="material-symbols-outlined text-3xl">fingerprint</span>
                </button>
            </div>
        </form>
    </div>

    <div class="pb-10 pt-6 px-6 text-center">
        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">
            Don't have an account?
            <a class="text-primary font-bold hover:underline ml-1" href="{{ route('register') }}">Create New Account</a>
        </p>
        <div class="mt-8 mx-auto w-32 h-1 bg-gray-300 dark:bg-gray-800 rounded-full"></div>
    </div>
</body>

</html>