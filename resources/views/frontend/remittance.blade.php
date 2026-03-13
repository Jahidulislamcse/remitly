@extends('frontend.layout.master')
@section('meta')
    <link rel="canonical" href="{{ route('user.index') }}" />
@endsection
@section('style')
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .neon-shadow {
            box-shadow: 0 0 15px rgba(242, 13, 13, 0.3);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 0px;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
    
<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    input:checked + div { border-color: #f20d0d; background-color: rgba(242,13,13,0.1); }
</style>
@endsection

@section('content')

<div class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-white min-h-screen flex flex-col">
    <div class="w-full sm:max-w-[420px] sm:mx-auto">
    <header
        class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md px-4 py-4 flex items-center justify-between">
            <a href="{{ route('user.index') }}">
                <div class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 cursor-pointer">
                    <span class="material-symbols-outlined text-black dark:text-white">
                        arrow_back_ios_new
                    </span>
                </div>
            </a>
        <h2 class="text-lg font-bold leading-tight tracking-tight">Remittance &amp; Withdraw</h2>
        <button
            class="w-12 h-12 flex items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-white/10 transition-colors">
            <span class="material-symbols-outlined text-2xl">help</span>
        </button>
    </header>
    <form method="POST" action="{{ route('remittance') }}">
    @csrf

    <main class="flex-1 px-4 pb-32 overflow-y-auto custom-scrollbar">

        <div class="px-4 ">
            <h3 class="text-[#0c1d15] dark:text-white text-base font-bold leading-tight tracking-[-0.015em] mb-4">
                Select Channel
            </h3>

            <!-- Toggle Buttons -->
            <div class="flex mb-4 gap-2">
                <button id="toggleMobile" class="flex-1 py-1 rounded-full border-2 border-primary bg-primary text-white font-bold">
                    Mobile Banking
                </button>
                <button id="toggleBank" class="flex-1 py-1 rounded-full border-2 border-primary text-primary font-bold">
                    Bank Account
                </button>
            </div>

            <!-- Mobile Banking Section with Arrows -->
            <div class="relative">

                <!-- Prev Button -->
                <button id="prevMobile" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 w-8 h-8 bg-white dark:bg-charcoal rounded-full shadow flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-lg">arrow_back_ios</span>
                </button>

                <!-- Slider Container -->
                <div id="mobileSection" class="flex gap-6 overflow-x-auto hide-scrollbar scroll-smooth py-2 ml-8">
                    <!-- Bkash -->
                    <label class="flex flex-col items-center gap-2 shrink-0 cursor-pointer">
                        <input type="radio" name="operator" value="Bkash" class="hidden peer" required>
                        <div class="p-1 rounded-full border-2 border-transparent peer-checked:border-primary transition">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full w-10 h-10 bg-gray-100"
                                style='background-image: url("{{ asset("/images/front-icons/bkash3.png") }}");'>
                            </div>
                        </div>
                        <p class="text-[12px] font-bold peer-checked:text-primary text-[#45a179] dark:text-gray-400">Bkash</p>
                    </label>

                    <!-- Nagad -->
                    <label class="flex flex-col items-center gap-2 shrink-0 cursor-pointer">
                        <input type="radio" name="operator" value="Nagad" class="hidden peer" required>
                        <div class="p-1 rounded-full border-2 border-transparent peer-checked:border-primary transition">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full w-10 h-10 bg-gray-100"
                                style='background-image: url("{{ asset("/images/front-icons/nagad3.png") }}");'>
                            </div>
                        </div>
                        <p class="text-[12px] font-bold peer-checked:text-primary text-[#45a179] dark:text-gray-400">Nagad</p>
                    </label>

                    <!-- Upay -->
                    <label class="flex flex-col items-center gap-2 shrink-0 cursor-pointer">
                        <input type="radio" name="operator" value="Upay" class="hidden peer" required>
                        <div class="p-1 rounded-full border-2 border-transparent peer-checked:border-primary transition">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full w-10 h-10 bg-gray-100"
                                style='background-image: url("{{ asset("/images/front-icons/upay.png") }}");'>
                            </div>
                        </div>
                        <p class="text-[12px] font-bold peer-checked:text-primary text-[#45a179] dark:text-gray-400">Upay</p>
                    </label>

                    <!-- Rocket -->
                    <label class="flex flex-col items-center gap-2 shrink-0 cursor-pointer">
                        <input type="radio" name="operator" value="Rocket" class="hidden peer" required>
                        <div class="p-1 rounded-full border-2 border-transparent peer-checked:border-primary transition">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full w-10 h-10 bg-gray-100"
                                style='background-image: url("{{ asset("/images/front-icons/rocket.png") }}");'>
                            </div>
                        </div>
                        <p class="text-[12px] font-bold peer-checked:text-primary text-[#45a179] dark:text-gray-400">Rocket</p>
                    </label>
                </div>

                <!-- Next Button -->
                <button id="nextMobile" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 w-8 h-8 bg-white dark:bg-charcoal rounded-full shadow flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-lg">arrow_forward_ios</span>
                </button>
            </div>

            <!-- Bank Accounts Section (same slider) -->
            <div id="bankSection" class="relative hidden">

                <button id="prevBank" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 w-8 h-8 bg-white dark:bg-charcoal rounded-full shadow flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-lg">arrow_back_ios</span>
                </button>

                <div id="bankSlider" class="flex gap-4 overflow-x-auto hide-scrollbar scroll-smooth py-2">
                    @foreach($bank_accounts as $account)
                    <label class="flex flex-col items-center gap-2 shrink-0 cursor-pointer">
                        <input type="radio" name="operator" value="{{ $account->name }}" class="hidden peer" required>
                        <div class="p-1 rounded-full border-2 border-transparent peer-checked:border-primary transition">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full w-10 h-10 bg-gray-100"
                                style='background-image: url("{{ asset($account->logo) }}");'>
                            </div>
                        </div>
                        <p class="text-[12px] font-bold peer-checked:text-primary text-[#45a179] dark:text-gray-400">{{ $account->name }}</p>
                    </label>
                    @endforeach
                </div>

                <button id="nextBank" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 w-8 h-8 bg-white dark:bg-charcoal rounded-full shadow flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-lg">arrow_forward_ios</span>
                </button>
            </div>

        </div>

        <div class=" pb-4 text-center">
            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mt-2">Withdrawal Amount</p>

            <div class="flex justify-center items-center">
                <span class="text-primary text-3xl mr-2">৳</span>
                <input
                    name="amount"
                    type="number"
                    min="25000"
                    required
                    class="bg-transparent text-center text-[36px] font-extrabold focus:ring-0 border-none w-48"
                    placeholder="25000">
            </div>

            <p class="text-xs text-slate-500">
                Available Balance: ৳{{ number_format($user->balance,2) }}
            </p>
        </div>

        <div class="space-y-4 mb-8">

            <div class="flex flex-col gap-2">
                <label class="px-2 text-sm font-semibold text-slate-600 dark:text-slate-400">
                    Account Number
                </label>

                <div class="relative group">
                    <input
                        name="account"
                        required
                        class="w-full h-10 bg-slate-200 dark:bg-charcoal border-2 border-transparent focus:border-primary/50 focus:ring-0 rounded-full px-6 text-lg font-medium placeholder:text-slate-400 dark:placeholder:text-slate-600 transition-all"
                        placeholder="e.g. 2050 999 45345"
                        type="text" />

                    <span class="material-symbols-outlined absolute right-6 top-1/2 -translate-y-1/2 text-slate-400">
                        dialpad
                    </span>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label class="px-2 text-sm font-semibold text-slate-600 dark:text-slate-400">
                    Branch (Optional)
                </label>

                <div class="relative">
                    <input
                        name="branch"
                        type="text"
                        class="w-full h-10 bg-slate-200 dark:bg-charcoal border-2 border-transparent focus:border-primary/50 focus:ring-0 rounded-full px-6 text-lg font-medium placeholder:text-slate-400 dark:placeholder:text-slate-600 transition-all"
                        placeholder="Enter branch name (optional)" />
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label class="px-2 text-sm font-semibold text-slate-600 dark:text-slate-400">
                    Receiver Name
                </label>

                <input
                    name="achold"
                    required
                    class="w-full h-10 bg-slate-200 dark:bg-charcoal border-2 border-transparent focus:border-primary/50 focus:ring-0 rounded-full px-6 text-lg font-medium placeholder:text-slate-400 dark:placeholder:text-slate-600 transition-all"
                    placeholder="Full legal name"
                    type="text" />
            </div>

            {{-- <div class="flex flex-col gap-2">
                <label class="px-2 text-sm font-semibold text-slate-600 dark:text-slate-400">
                    Secret PIN
                </label>

                <input
                    name="pin"
                    required
                    type="password"
                    class="w-full h-10 bg-slate-200 dark:bg-charcoal border-2 border-transparent focus:border-primary/50 focus:ring-0 rounded-full px-6 text-lg font-medium placeholder:text-slate-400 dark:placeholder:text-slate-600 transition-all"
                    placeholder="Enter PIN" />
            </div> --}}

        </div>

        <div class="pb-8">
            <button
                type="button" 
                id="openConfirmModal"
                class="w-full h-14 bg-primary text-white text-lg font-bold rounded-full shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all">
                Submit
            </button>
        </div>

    </main>

    <!-- Confirm Modal (Hidden By Default) -->
    <div id="remitConfirmModal"
        class="fixed inset-0 z-50 hidden items-center justify-center">

        <!-- Overlay -->
        <div id="modalOverlay"
            class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

        <!-- Modal Card -->
        <div class="relative w-full max-w-[400px] mx-4
                    bg-background-light dark:bg-charcoal
                    rounded-2xl shadow-2xl p-6
                    transform scale-95 opacity-0 transition-all duration-300"
            id="modalCard">

            <div class="text-center mb-6">
                <h3 class="text-lg font-bold text-primary">
                    রেমিটেন্স কনফার্ম
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    নিচের তথ্য যাচাই করুন
                </p>
            </div>

            <!-- Summary -->
            <div class="space-y-4 text-sm">

                <div class="flex justify-between">
                    <span class="text-slate-500">অ্যাকাউন্ট</span>
                    <span id="mAccount" class="font-semibold">—</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">এমাউন্ট</span>
                    <span id="mAmount" class="font-semibold text-primary">—</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">রিসিভার</span>
                    <span id="mAchold" class="font-semibold">—</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">ব্রাঞ্চ</span>
                    <span id="mBranch" class="font-semibold">—</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">চ্যানেল</span>
                    <span id="mOperator" class="font-semibold">—</span>
                </div>

            </div>

            <!-- PIN -->
            <div class="mt-6">
                <label class="text-sm font-semibold text-slate-600 dark:text-slate-400">
                    PIN
                </label>

                <input name="pin"
                    type="password"
                    class="mt-2 w-full h-10 bg-slate-200 dark:bg-background-dark
                            rounded-full px-6 text-lg font-medium
                            border-2 border-transparent
                            focus:border-primary/50 focus:ring-0"
                    placeholder="••••••">
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 mt-6">
                <button type="button"
                        id="closeModal"
                        class="flex-1 h-10 rounded-full
                            bg-slate-200 dark:bg-background-dark
                            font-semibold">
                    Cancel
                </button>

                <button type="submit"
                        class="flex-1 h-10 rounded-full
                            bg-primary text-white font-bold">
                    Confirm
                </button>
            </div>

        </div>
    </div>
    </form>
    

</div>

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
                        "charcoal": "#1e1e1e",
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

    <script>
        const openBtn  = document.getElementById('openConfirmModal');
        const modal    = document.getElementById('remitConfirmModal');
        const card     = document.getElementById('modalCard');
        const overlay  = document.getElementById('modalOverlay');
        const closeBtn = document.getElementById('closeModal');

        openBtn.addEventListener('click', function () {

            const form = this.closest('form');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const account  = document.querySelector('[name="account"]').value;
            const amount   = document.querySelector('[name="amount"]').value;
            const achold   = document.querySelector('[name="achold"]').value;
            const branch   = document.querySelector('[name="branch"]').value || 'N/A';
            const operator = document.querySelector('[name="operator"]:checked').value;

            document.getElementById('mAccount').innerText  = account;
            document.getElementById('mAmount').innerText   = '৳ ' + amount;
            document.getElementById('mAchold').innerText   = achold;
            document.getElementById('mBranch').innerText   = branch;
            document.getElementById('mOperator').innerText = operator;

            // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                card.classList.remove('scale-95','opacity-0');
                card.classList.add('scale-100','opacity-100');
            }, 10);
        });

        function closeModal() {
            card.classList.add('scale-95','opacity-0');
            card.classList.remove('scale-100','opacity-100');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        overlay.addEventListener('click', closeModal);
        closeBtn.addEventListener('click', closeModal);
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleMobile = document.getElementById('toggleMobile');
        const toggleBank   = document.getElementById('toggleBank');
        const mobileSection = document.getElementById('mobileSection').parentElement;
        const bankSection   = document.getElementById('bankSection');

        function activateToggle(activeBtn, inactiveBtn, showSection, hideSection) {
            activeBtn.classList.add('bg-primary','text-white');
            activeBtn.classList.remove('text-primary','bg-white');
            inactiveBtn.classList.remove('bg-primary','text-white');
            inactiveBtn.classList.add('text-primary','bg-white');
            showSection.classList.remove('hidden');
            hideSection.classList.add('hidden');
        }

        toggleMobile.addEventListener('click', () => activateToggle(toggleMobile, toggleBank, mobileSection, bankSection));
        toggleBank.addEventListener('click', () => activateToggle(toggleBank, toggleMobile, bankSection, mobileSection));

        // Scroll buttons
        function setupScroll(btnId, containerId, distance = 120) {
            const btn = document.getElementById(btnId);
            const container = document.getElementById(containerId);
            btn.addEventListener('click', () => {
                container.scrollBy({ left: distance, behavior: 'smooth' });
            });
        }

        setupScroll('prevMobile','mobileSection', -120);
        setupScroll('nextMobile','mobileSection', 120);
        setupScroll('prevBank','bankSlider', -120);
        setupScroll('nextBank','bankSlider', 120);
    });
    </script>

@endsection