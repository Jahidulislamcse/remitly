@extends('frontend.layout.master')
@section('meta')
    <link rel="canonical" href="{{ route('user.index') }}" />
@endsection

@section('style')
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .neon-glow {
            box-shadow: 0 0 15px rgba(242, 13, 13, 0.4);
        }

        .glass-header {
            background: rgba(16, 16, 16, 0.8);
            backdrop-filter: blur(12px);
        }
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        input[type=number] {
        -moz-appearance: textfield;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
@endsection


@section('content')
    @php
        $operators = [
            'bkash' => ['name' => 'bKash'],
            'nagad' => ['name' => 'Nagad'],
            'upay' => ['name' => 'Upay'],
            'rocket' => ['name' => 'Rocket'],
        ];

        $current = strtolower($operatorName ?? 'bkash');
    @endphp
    <div class="w-full sm:max-w-[420px] sm:mx-auto">
        <div class=" w-full"></div>
        <header class="sticky top-0 z-50 glass-header">
            <div class="flex items-center bg-background-light dark:bg-background-dark p-4 pb-2 justify-between z-10">
                <a href="{{ route('user.index') }}">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 cursor-pointer">
                        <span class="material-symbols-outlined text-black dark:text-white">
                            arrow_back_ios_new
                        </span>
                    </div>
                </a>
                <h2 class="text-black dark:text-white text-lg font-bold flex-1 text-center">Mobile Banking</h2>
            </div>
            <div class="flex items-center justify-center px-4 py-4">

                @php
                    $icons = [
                        'bkash' => '/images/front-icons/bkash3.png',
                        'nagad' => '/images/front-icons/nagad3.png',
                        'upay' => '/images/front-icons/upay.png',
                        'rocket' => '/images/front-icons/rocket.png',
                    ];
                @endphp

                <button id="openOperatorModal" class="flex items-center gap-2 bg-zinc-800 px-4 py-2 rounded-full">
                    <img id="selectedOperatorIcon" src="{{ $icons[array_key_first($operators)] }}"
                        class="w-6 h-6 object-contain">
                    <span id="selectedOperatorName" class="text-white font-semibold text-sm">
                        {{ reset($operators)['name'] }}
                    </span>
                    <span class="material-symbols-outlined text-white text-sm">expand_more</span>
                </button>

            </div>
        </header>

        <form method="POST" action="{{ route('mobile.banking', $current) }}">
            @csrf

            <main class="flex-1 flex flex-col px-4 pb-24">
                <input type="hidden" name="operator" id="operatorInput" value="{{ strtolower($operatorName) }}">
                <div class="mt-6 mb-8">
                    <div class="flex h-12 items-center justify-center rounded-full  border border-zinc-800 p-1">
                        <label
                            class="flex cursor-pointer h-full grow items-center justify-center overflow-hidden rounded-full px-2 has-[:checked]:bg-primary has-[:checked]:text-white text-zinc-500 text-sm font-semibold transition-all duration-300">
                            <span class="truncate">Send Money</span>
                            <input checked="" class="invisible w-0" name="type" required type="radio"
                                value="Send Money" />
                        </label>
                        <label
                            class="flex cursor-pointer h-full grow items-center justify-center overflow-hidden rounded-full px-2 has-[:checked]:bg-primary has-[:checked]:text-white text-zinc-500 text-sm font-semibold transition-all duration-300">
                            <span class="truncate">Payment</span>
                            <input class="invisible w-0" name="type" required type="radio" value="Payment" />
                        </label>
                        <label
                            class="flex cursor-pointer h-full grow items-center justify-center overflow-hidden rounded-full px-2 has-[:checked]:bg-primary has-[:checked]:text-white text-zinc-500 text-sm font-semibold transition-all duration-300">
                            <span class="truncate">Cashout</span>
                            <input class="invisible w-0" name="type" required type="radio" value="Cashout" />
                        </label>
                    </div>
                </div>
                <div class="flex flex-col items-center justify-center py-10">
                    <div class="relative group">
                        <div
                            class="absolute -inset-4 bg-primary/10 blur-3xl rounded-full opacity-50 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div class="relative flex items-baseline justify-center">
                            <span class="text-primary text-4xl font-light mr-2">৳</span>
                            <input 
                                name="amount" 
                                required 
                                type="number" 
                                min="1"
                                class="bg-transparent border-0 outline-none text-black dark:text-white text-5xl font-bold tracking-tight text-center focus:ring-0 w-full max-w-[280px] p-0 placeholder:text-zinc-400 dark:placeholder:text-zinc-500"
                                placeholder="0"
                                />
                        </div>
                    </div>
                    <div
                        class="mt-4 flex items-center gap-2 px-4 py-1.5 rounded-full bg-zinc-900/30 dark:bg-zinc-800/30 border border-zinc-800/50">
                        <span class="material-symbols-outlined text-zinc-500 text-sm">account_balance</span>
                        <p class="text-zinc-400 text-sm font-medium">Available Balance:
                            <span
                                class="text-zinc-200 dark:text-white">৳{{ number_format(auth()->user()->balance, 2) }}</span>
                        </p>
                    </div>
                </div>
                <div class="mt-2 space-y-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-zinc-400 text-sm font-medium ml-4 uppercase tracking-wider">Account
                            Number</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-zinc-500">
                                <span class="material-symbols-outlined">alternate_email</span>
                            </div>
                            <input name="mobile" required type="number"
                                class="w-full bg-white dark:bg-black border border-zinc-800 text-black dark:text-white rounded-full pl-12 pr-14 
                                    focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/20 transition-all text-lg placeholder:text-zinc-600 dark:placeholder:text-zinc-400"
                                placeholder="Enter account number" />
                        </div>
                    </div>
                    <div class="w-full flex justify-center ">
                        <div
                            class="w-[92%] sm:max-w-[420px] p-6  from-background-dark via-background-dark/95 to-transparent">
                            <button type="button" id="openConfirmModal"
                                class="w-full h-16 rounded-full bg-gradient-to-r from-primary to-[#b80a0a]
                        text-white font-bold text-lg shadow-lg">
                                Next (এগিয়ে যান)
                            </button>
                        </div>
                    </div>


                </div>
                <div id="confirmModal" class="fixed inset-0 z-50 hidden items-center justify-center">
                    <div id="overlay" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
                    <div id="modalCard"
                        class="relative w-full max-w-[400px] mx-4 bg-background-light dark:bg-zinc-900 rounded-2xl shadow-2xl p-6 transform scale-95 opacity-0 transition-all duration-300">
                        <h3 class="text-lg font-bold text-primary text-center mb-6">Confirm Transaction</h3>
                        <div class="space-y-3 text-sm text-black dark:text-white">
                            <div class="flex justify-between"><span>Operator</span><span id="mOperator"
                                    class="font-semibold">—</span></div>
                            <div class="flex justify-between"><span>Type</span><span id="mType"
                                    class="font-semibold">—</span></div>
                            <div class="flex justify-between"><span>Account</span><span id="mAccount"
                                    class="font-semibold">—</span></div>
                            <div class="flex justify-between"><span>Amount</span><span id="mAmount"
                                    class="font-semibold text-primary">—</span></div>
                        </div>
                        <div class="mt-6">
                            <label class="text-sm font-semibold text-zinc-400 dark:text-zinc-300">PIN</label>
                            <input name="pin" type="password"
                                class="mt-2 w-full h-14 bg-white dark:bg-zinc-800 text-black dark:text-white rounded-full px-6 text-lg placeholder:text-zinc-500 dark:placeholder:text-zinc-400"
                                placeholder="Enter PIN">
                        </div>
                        <div class="flex gap-3 mt-6">
                            <button type="button" id="closeModal"
                                class="flex-1 h-14 rounded-full bg-zinc-700 dark:bg-zinc-600 text-white">Cancel</button>
                            <button type="submit"
                                class="flex-1 h-14 rounded-full bg-primary text-white font-bold">Confirm</button>
                        </div>
                    </div>
                </div>

                <div id="operatorModal" class="fixed inset-0 z-50 hidden items-center justify-center">

                    <!-- Overlay -->
                    <div id="operatorOverlay" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

                    <!-- Modal Card -->
                    <div id="operatorModalCard"
                        class="relative w-full max-w-[320px] bg-zinc-900 rounded-2xl p-6
                                flex flex-col items-center gap-4">

                        <h3 class="text-white text-lg font-bold text-center mb-4">
                            Select Your Operator
                        </h3>

                        @foreach ($operators as $key => $op)
                            <button
                                class="select-operator flex items-center gap-3 w-full bg-zinc-800 p-4 rounded-xl justify-center"
                                data-name="{{ $op['name'] }}" data-icon="{{ $icons[$key] }}">
                                <img src="{{ $icons[$key] }}" class="w-8 h-8 object-contain">
                                <span class="text-white font-semibold">{{ $op['name'] }}</span>
                            </button>
                        @endforeach

                    </div>
                </div>
            </main>
        </form>
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
                    },
                    fontFamily: {
                        "display": ["Space Grotesk", "sans-serif"]
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const openBtn = document.getElementById('openConfirmModal');
            const modal = document.getElementById('confirmModal');
            const card = document.getElementById('modalCard');
            const overlay = document.getElementById('overlay');
            const closeBtn = document.getElementById('closeModal');
            const form = document.querySelector('form'); // 🔥 FIX HERE

            openBtn.addEventListener('click', function() {

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const operator = document.querySelector('[name="operator"]:checked')?.value;
                const type = document.querySelector('[name="type"]:checked')?.value;
                const account = document.querySelector('[name="mobile"]').value;
                const amount = document.querySelector('[name="amount"]').value;

                document.getElementById('mOperator').innerText = operator;
                document.getElementById('mType').innerText = type;
                document.getElementById('mAccount').innerText = account;
                document.getElementById('mAmount').innerText = '৳ ' + amount;

                modal.classList.remove('hidden');
                modal.classList.add('flex');

                setTimeout(() => {
                    card.classList.remove('scale-95', 'opacity-0');
                    card.classList.add('scale-100', 'opacity-100');
                }, 10);
            });

            function closeModal() {
                card.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 200);
            }

            overlay.addEventListener('click', closeModal);
            closeBtn.addEventListener('click', closeModal);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const items = document.querySelectorAll(".operator-item");
            const radios = document.querySelectorAll('[name="operator"]');
            const nextBtn = document.getElementById("nextOperator");
            const prevBtn = document.getElementById("prevOperator");

            let currentIndex = 0;

            function showOperator(index) {
                items.forEach(i => i.classList.add("hidden"));
                items[index].classList.remove("hidden");
                items[index].classList.add("flex");
                radios[index].checked = true;
                currentIndex = index;
            }

            nextBtn.addEventListener("click", function() {
                let next = (currentIndex + 1) % items.length;
                showOperator(next);
            });

            prevBtn.addEventListener("click", function() {
                let prev = (currentIndex - 1 + items.length) % items.length;
                showOperator(prev);
            });

            showOperator(0);

        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const modal = document.getElementById("operatorModal");
            const overlay = document.getElementById("operatorOverlay");
            const card = document.getElementById("operatorModalCard");
            const openBtn = document.getElementById("openOperatorModal");
            const nameEl = document.getElementById("selectedOperatorName");
            const iconEl = document.getElementById("selectedOperatorIcon");

            // Function to open modal
            function showModal() {
                modal.classList.remove("hidden");
                modal.classList.add("flex");
                card.classList.add("scale-95", "opacity-0");
                setTimeout(() => {
                    card.classList.remove("scale-95", "opacity-0");
                    card.classList.add("scale-100", "opacity-100");
                }, 10);
            }

            showModal();

            openBtn.addEventListener("click", showModal);

            document.querySelectorAll(".select-operator").forEach(btn => {
                btn.addEventListener("click", function() {
                    const name = this.dataset.name;
                    const icon = this.dataset.icon;

                     document.getElementById("operatorInput").value = name.toLowerCase();

                    // Update header
                    nameEl.innerText = name;
                    iconEl.src = icon;

                    let radio = document.querySelector(`[name="operator"][value="${name}"]`);
                    if (!radio) {
                        radio = document.createElement("input");
                        radio.type = "radio";
                        radio.name = "operator";
                        radio.value = name;
                        radio.classList.add("hidden");
                        document.querySelector("form").appendChild(radio);
                    }
                    radio.checked = true;

                    // Close modal
                    modal.classList.add("hidden");
                });
            });

            overlay.addEventListener("click", function() {
                modal.classList.add("hidden");
            });

        });
    </script>
@endsection
