<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>User Agreement</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#da0b0b",
                        "background-light": "#f8f5f5",
                        "background-dark": "#121212", // Adjusted to user request
                        "surface-dark": "#1e1e1e",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        /* Custom Scrollbar for the legal text area */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Checkbox styling override to match theme */
        input[type="checkbox"]:checked {
            background-color: #da0b0b;
            border-color: #da0b0b;
            box-shadow: 0 0 8px rgba(218, 11, 11, 0.5);
        }

        input[type="checkbox"] {
            background-color: transparent;
            border-color: #4a4a4a;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-white antialiased h-screen flex flex-col overflow-hidden">

    <main class="flex-1 flex flex-col px-4 pb-0 overflow-hidden relative w-full max-w-md mx-auto">

        <!-- Scrollable Legal Card -->
        <div
            class="flex-1 bg-white dark:bg-surface-dark rounded-t-2xl shadow-lg relative overflow-hidden flex flex-col border border-slate-200 dark:border-white/5">
            <!-- Hero Image / Header inside card -->
            <div class="h-32 shrink-0 bg-cover bg-center relative"
                data-alt="Abstract legal documents and pen on dark desk"
                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuA2mCJvzZKl-1IclwpRAMmeT02XpQr0oSSQf0h9sz0Nnzmv6C9Uku0brBO-VcjJuWZGtaK9PL6EgC-T_Z1nx_3VW_lkt0jWV7gfPJx04ujvnp1a3-rjrhNjpuJknDCstNJf1tuSlgZM6JZu194xuOSE3sAXqfwMreMje8na6zlZba4Hn45-7udZdvvoE5BpdJ1ELHqqcVP_vW8sIkjcviyRdPGVLRKciqhqj_sDltbzx_6N-oWkjlWDR9p4BBz5UX-2r1X-5Q-bURmM");'>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-white dark:to-surface-dark"></div>
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="absolute bottom-4 left-4">
                    <p class="text-white/80 text-xs font-medium uppercase tracking-wider mb-1">Last Updated: Oct 2023
                    </p>
                    <h3 class="text-white text-xl font-bold">Terms of Service</h3>
                </div>
            </div>
            <!-- Scrollable Text Content -->
            <div class="flex-1 overflow-y-auto custom-scrollbar p-5 space-y-6 pb-24">
                <section>
                    <h4 class="text-slate-900 dark:text-white text-base font-bold mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">info</span>
                        1. Introduction
                    </h4>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                        Welcome to Remitely Pay. By accessing our services, you agree to be bound by these terms. These
                        terms constitute a legally binding agreement between you and Remitely Pay regarding your use of
                        the website and services.
                    </p>
                </section>
                <section>
                    <h4 class="text-slate-900 dark:text-white text-base font-bold mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">lock</span>
                        2. Privacy Policy
                    </h4>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                        We are committed to protecting your personal data. We collect information to provide better
                        services and comply with legal obligations. Your data is encrypted and stored securely. We do
                        not sell your personal information to third parties.
                    </p>
                </section>
                <section>
                    <h4 class="text-slate-900 dark:text-white text-base font-bold mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">payments</span>
                        3. Fees &amp; Charges
                    </h4>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                        Standard transaction fees apply to all transfers. Please review our fee schedule for detailed
                        information. Fees are subject to change with prior notice. Currency exchange rates are
                        determined at the time of transaction.
                    </p>
                </section>
                <section>
                    <h4 class="text-slate-900 dark:text-white text-base font-bold mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">security</span>
                        4. Security Protocols
                    </h4>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                        We employ industry-standard encryption protocols to safeguard your financial data. Two-factor
                        authentication is required for sensitive actions. You are responsible for maintaining the
                        confidentiality of your account credentials.
                    </p>
                </section>
                <section>
                    <h4 class="text-slate-900 dark:text-white text-base font-bold mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">gavel</span>
                        5. Termination Conditions
                    </h4>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                        We reserve the right to terminate or suspend access to our service immediately, without prior
                        notice or liability, for any reason whatsoever, including without limitation if you breach the
                        Terms.
                    </p>
                </section>
                <!-- Extra space at bottom to ensure content isn't hidden by gradient overlay -->
                <div
                    class="  px-6 py-4 pb-8 shrink-0 border-t border-slate-200 dark:border-white/5 w-full max-w-md mx-auto z-30">
                    <form method="POST" action="{{ route('register.agree') }}" class="flex flex-col">
                        @csrf

                        <!-- Checkbox Row -->
                        <label class="flex items-start gap-3 mb-5 cursor-pointer group">
                            <div class="relative flex items-center pt-0.5">
                                <input id="agreeCheckbox" name="agree" type="checkbox"
                                    class="peer size-5 rounded border-2 border-slate-400 dark:border-slate-500 text-primary focus:ring-0 focus:ring-offset-0 bg-transparent transition-all cursor-pointer" />
                            </div>
                            <span
                                class="text-sm text-slate-600 dark:text-slate-400 font-medium select-none group-hover:text-slate-800 dark:group-hover:text-slate-200 transition-colors">
                                I have read and agree to the
                                <span class="text-primary underline decoration-primary/50 underline-offset-2">Terms &
                                    Conditions</span>
                                and
                                <span class="text-primary underline decoration-primary/50 underline-offset-2">Privacy
                                    Policy</span>.
                            </span>
                        </label>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full h-14 rounded-xl bg-gradient-to-r from-[#da0b0b] to-[#b00505] text-white font-bold text-lg shadow-[0_4px_14px_rgba(218,11,11,0.4)] hover:shadow-[0_6px_20px_rgba(218,11,11,0.6)] active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                            <span>I Accept & Continue</span>
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </button>
                    </form>
                </div>
                <!-- Fade gradient at bottom of scroll area -->
                <div
                    class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-white dark:from-surface-dark to-transparent pointer-events-none">
                </div>
            </div>
    </main>
    <!-- Sticky Footer Section -->
    <div
        class="bg-background-light dark:bg-background-dark px-6 py-4 pb-8 shrink-0 border-t border-slate-200 dark:border-white/5 w-full max-w-md mx-auto z-30">
        <!-- Checkbox Row -->
        <label class="flex items-start gap-3 mb-5 cursor-pointer group">

</body>

</html>
