<!DOCTYPE html>
<html class="dark" lang="en">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Set Transaction PIN</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#da0b0b",
                        "background-dark": "#101010",
                        "surface-dark": "#1E1E1E"
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"]
                    }
                }
            }
        }
    </script>

    <style>
        body {
            min-height: max(884px, 100dvh);
        }

        .keypad-btn {
            transition: background-color .2s, transform .1s
        }

        .keypad-btn:active {
            background: #333;
            transform: scale(.95)
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 15px rgba(218, 11, 11, .2)
            }

            50% {
                box-shadow: 0 0 30px rgba(218, 11, 11, .6)
            }
        }

        .animate-glow {
            animation: pulse-glow 3s infinite
        }
    </style>

</head>

<body
    class="font-display bg-background-dark text-white min-h-screen flex flex-col items-center justify-between antialiased">

    <div class="flex-1 flex flex-col items-center justify-start w-full px-6 gap-8 ">

        <div class="text-center space-y-2 mt-4">

            <h1 class="text-2xl font-bold">Security Setup</h1>

            <p class="text-gray-400 text-sm">Create a 4-digit PIN to secure your account</p>

        </div>

        <div class="relative py-2">

            <div class="absolute inset-0 bg-primary/20 blur-2xl rounded-full scale-150 opacity-20"></div>

            <div
                class="w-24 h-24 rounded-full border border-primary/30 flex items-center justify-center bg-gradient-to-b from-[#1E1E1E] to-[#121212] shadow-lg animate-glow relative z-10">

                <span class="material-symbols-outlined text-primary text-4xl">lock</span>

            </div>

        </div>

        <!-- PIN Dots -->

        <div class="flex items-center justify-center gap-6 mb-4" id="pinDots">

            <div class="w-4 h-4 rounded-full bg-surface-dark border border-gray-700"></div>
            <div class="w-4 h-4 rounded-full bg-surface-dark border border-gray-700"></div>
            <div class="w-4 h-4 rounded-full bg-surface-dark border border-gray-700"></div>
            <div class="w-4 h-4 rounded-full bg-surface-dark border border-gray-700"></div>

        </div>

    </div>

    <!-- Bottom Section -->

    <div class="w-full bg-background-dark pb-8 rounded-t-3xl">

        <form method="POST" action="{{ route('register.final') }}">

            @csrf

            @php
                $data = Illuminate\Support\Facades\Session::get('register-info');
            @endphp

            <!-- Hidden inputs -->

            <input type="hidden" name="photo" value="{{ @$data['photo'] }}">
            <input type="hidden" name="name" value="{{ @$data['name'] }}">
            <input type="hidden" name="email" value="{{ @$data['email'] }}">
            <input type="hidden" name="location" value="{{ @$data['location'] }}">
            <input type="hidden" name="password" value="{{ @$data['password'] }}">
            <input type="hidden" name="password_confirmation" value="{{ @$data['password_confirmation'] }}">
            <input type="hidden" name="role" value="{{ @$data['role'] }}">
            <input type="hidden" name="type" value="{{ @$data['type'] }}">

            <input type="hidden" name="pin" id="pinInput">
            <input type="hidden" name="confirm_pin" id="confirmPinInput">

            <!-- Continue Button -->

            <div class="px-6 mb-8 flex justify-center w-full">

                <button type="submit"
                    class="w-full max-w-xs h-14 bg-primary hover:bg-red-700 text-white font-bold text-lg rounded-full shadow-lg transition active:scale-[0.98] flex items-center justify-center gap-2">

                    <span>Continue</span>
                    <span class="material-symbols-outlined text-xl">arrow_forward</span>

                </button>

            </div>

        </form>

        <!-- Keypad -->

        <div class="grid grid-cols-3 gap-y-4 gap-x-8 max-w-xs mx-auto px-4 pb-4">

            <button class="keypad-btn w-20 h-20 rounded-full bg-surface-dark text-2xl" data-num="1">1</button>
            <button class="keypad-btn w-20 h-20 rounded-full bg-surface-dark text-2xl" data-num="2">2</button>
            <button class="keypad-btn w-20 h-20 rounded-full bg-surface-dark text-2xl" data-num="3">3</button>

            <button class="keypad-btn w-20 h-20 rounded-full bg-surface-dark text-2xl" data-num="4">4</button>
            <button class="keypad-btn w-20 h-20 rounded-full bg-surface-dark text-2xl" data-num="5">5</button>
            <button class="keypad-btn w-20 h-20 rounded-full bg-surface-dark text-2xl" data-num="6">6</button>

            <button class="keypad-btn w-20 h-20 rounded-full bg-surface-dark text-2xl" data-num="7">7</button>
            <button class="keypad-btn w-20 h-20 rounded-full bg-surface-dark text-2xl" data-num="8">8</button>
            <button class="keypad-btn w-20 h-20 rounded-full bg-surface-dark text-2xl" data-num="9">9</button>

            <div></div>

            <button class="keypad-btn w-20 h-20 rounded-full bg-surface-dark text-2xl" data-num="0">0</button>

            <button id="backspace" class="keypad-btn w-20 h-20 flex items-center justify-center">

                <span class="material-symbols-outlined text-3xl text-gray-400">backspace</span>

            </button>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        let pin = ""

        const dots = document.querySelectorAll("#pinDots div")
        const pinInput = document.getElementById("pinInput")
        const confirmPinInput = document.getElementById("confirmPinInput")

        function updateDots() {

            dots.forEach((dot, index) => {

                if (index < pin.length) {
                    dot.classList.remove("bg-surface-dark", "border")
                    dot.classList.add("bg-primary")
                } else {
                    dot.classList.add("bg-surface-dark", "border")
                    dot.classList.remove("bg-primary")
                }

            })

        }

        document.querySelectorAll("[data-num]").forEach(btn => {

            btn.onclick = function() {

                if (pin.length >= 4) return

                pin += this.dataset.num

                updateDots()

                if (pin.length === 4) {

                    pinInput.value = pin
                    confirmPinInput.value = pin

                }

            }

        })

        document.getElementById("backspace").onclick = function() {

            pin = pin.slice(0, -1)

            updateDots()

            pinInput.value = ""
            confirmPinInput.value = ""

        }

        @if ($errors->any())

            @foreach ($errors->all() as $error)

                toastr.error('{{ $error }}')
            @endforeach
        @endif

        @if (session('msg'))

            toastr.{{ session('response') ? 'success' : 'error' }}('{{ session('msg') }}')
        @endif
    </script>

</body>

</html>
