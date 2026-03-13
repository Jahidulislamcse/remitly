<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Account</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1"
        rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#f20d0d',
                        'primary-dark': '#c40a0a',
                        'background-dark': '#101010',
                        'surface-dark': '#1C1C1E'
                    },
                    fontFamily: {
                        display: ['Manrope', 'sans-serif']
                    },
                    boxShadow: {
                        glow: '0 0 20px rgba(242,13,13,0.15)',
                        'glow-focus': '0 0 25px rgba(242,13,13,0.4)'
                    }
                }
            }
        }
    </script>

    <style>
        body {
            min-height: max(884px, 100dvh);
        }

        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 30px #1C1C1E inset !important;
            -webkit-text-fill-color: white !important;
        }
    </style>

</head>

<body class="bg-background-dark font-display text-white antialiased">

    <div class="mx-auto flex min-h-screen w-full max-w-md flex-col overflow-hidden relative">

        <div class="absolute -top-20 -right-20 h-64 w-64 rounded-full bg-primary/20 blur-[100px]"></div>
        <div class="absolute top-40 -left-20 h-40 w-40 rounded-full bg-primary/10 blur-[80px]"></div>

        <div class="flex flex-col items-center px-6 pt-8 pb-6 relative z-10">

            <div class="w-full flex justify-between items-center mb-6">

                <a href="{{ route('user.login') }}"
                    class="flex items-center justify-center w-10 h-10 rounded-full bg-surface-dark/50">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>

            </div>

            <h1 class="text-3xl font-extrabold tracking-tight mb-2">
                Remitely <span class="text-primary">Pay</span>
            </h1>

            <p class="text-white/50 text-sm font-medium">
                Create your account to get started
            </p>

        </div>

        <form action="{{ route('register.data') }}" method="POST"
            class="flex-1 flex flex-col gap-5 px-6 pb-8 relative z-10 overflow-y-auto">

            @csrf

            @php
                $firstCountry = App\Models\Country::first();
            @endphp


            <div
                class="relative flex h-12 w-full items-center rounded-full bg-surface-dark p-1 shadow-inner border border-white/5">

                <div id="toggleBg"
                    class="absolute left-1 top-1 h-[calc(100%-8px)] w-[calc(50%-4px)] rounded-full bg-primary transition-all duration-300">
                </div>

                <label
                    class="z-10 flex h-full flex-1 cursor-pointer items-center justify-center text-sm font-bold text-white">

                    <span>Personal</span>
                    <input checked name="account_type" type="radio" value="personal" class="hidden">

                </label>

                <label class="z-10 flex h-full flex-1 cursor-pointer items-center justify-center text-sm text-white/60">

                    <span>Business</span>
                    <input name="account_type" type="radio" value="bussiness" class="hidden">

                </label>

            </div>

            <input type="hidden" name="type" id="accountTypeInput" value="personal">

            <!-- Name -->

            <div class="group relative">

                <div class="flex items-center h-14 w-full rounded-2xl bg-surface-dark border border-transparent px-4">

                    <span class="material-symbols-outlined  mr-3">person</span>

                    <div class="flex flex-col flex-1">

                        <label class="text-[10px] uppercase font-bold ">Full Name</label>

                        <input name="name" required
                            class="bg-transparent border-none p-0 text-white text-base focus:ring-0 w-full"
                            placeholder="Enter your name">

                    </div>

                </div>

            </div>

            <!-- Country -->

            <div class="group relative">

                <div class="flex items-center h-14 w-full rounded-2xl border border-gray-200 px-4">

                    <span class="material-symbols-outlined mr-3">public</span>

                    <div class="flex flex-col flex-1">

                        <label class="text-[10px] uppercase font-bold mt-2">Country</label>

                        <select id="countrySelect"
                            class="bg-transparent border-none text-white focus:ring-0 w-full text-sm font-medium">

                            @foreach (App\Models\Country::all() as $country)
                                <option value="{{ $country->id }}" data-code="{{ $country->code }}"
                                    class="text-black bg-white"
                                    {{ $country->id == $firstCountry?->id ? 'selected' : '' }}>

                                    {{ $country->name }} ({{ $country->code }})

                                </option>
                            @endforeach

                        </select>

                    </div>

                </div>

                <input type="hidden" name="location" id="countryInput" value="{{ $firstCountry?->id }}">
                <input type="hidden" name="code" id="phoneCodeInput" value="{{ $firstCountry?->code }}">

            </div>

            <!-- Mobile -->

            <div class="group relative">

                <div class="flex items-center h-14 w-full rounded-2xl bg-surface-dark border border-transparent px-4">

                    <span class="material-symbols-outlined  mr-3">smartphone</span>

                    <div class="flex flex-col flex-1">

                        <label class="text-[10px] uppercase font-bold mt-2">Mobile</label>

                        <input name="email" type="number" required placeholder="017XXXXXXXX"
                            class="bg-transparent border-none text-white focus:ring-0 w-full">

                    </div>

                </div>

            </div>

            <!-- Password -->

            <div class="group relative">

                <div class="flex items-center h-14 w-full rounded-2xl bg-surface-dark border border-transparent px-4">

                    <span class="material-symbols-outlined  mr-3">lock</span>

                    <div class="flex flex-col flex-1">

                        <label class="text-[10px] uppercase font-bold mt-2">Password</label>

                        <input name="password" type="password" required
                            class="bg-transparent border-none text-white focus:ring-0 w-full">

                    </div>

                </div>

            </div>

            <!-- Confirm Password -->

            <div class="group relative">

                <div class="flex items-center h-14 w-full rounded-2xl bg-surface-dark border border-transparent px-4">

                    <span class="material-symbols-outlined  mr-3">lock_reset</span>

                    <div class="flex flex-col flex-1">

                        <label class="text-[10px] uppercase font-bold mt-2">Confirm Password</label>

                        <input name="password_confirmation" type="password" required
                            class="bg-transparent border-none text-white focus:ring-0 w-full">

                    </div>

                </div>

            </div>

            <input type="hidden" name="role" value="digital-marketing">

            <button type="submit"
                class="w-full h-14 rounded-full bg-gradient-to-r from-primary to-primary-dark text-white font-bold text-lg mt-4">

                Go Ahead

            </button>

            <div class="mt-6 text-center">

                <p class="text-sm text-white/50">

                    Already registered?

                    <a href="{{ route('user.login') }}" class="text-primary font-bold">

                        Login

                    </a>

                </p>

            </div>

        </form>

    </div>

    <script>
        const countrySelect = document.getElementById('countrySelect');

        countrySelect.addEventListener('change', function() {

            let selected = this.options[this.selectedIndex];

            document.getElementById('countryInput').value = selected.value;
            document.getElementById('phoneCodeInput').value = selected.dataset.code;

        });

        const inputs = document.querySelectorAll('input[name="account_type"]');
        const bg = document.getElementById('toggleBg');

        inputs.forEach(input => {

            input.addEventListener('change', function() {

                document.getElementById('accountTypeInput').value = this.value;

                if (this.value === "bussiness") {
                    bg.style.transform = "translateX(100%)";
                } else {
                    bg.style.transform = "translateX(0)";
                }

            });

        });
    </script>

</body>

</html>
