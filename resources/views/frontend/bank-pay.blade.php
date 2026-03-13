@extends('frontend.layout.master')
@section('meta')
    <link rel="canonical" href="{{ route('user.index') }}" />
@endsection

@section('style')
    <style>
        .ios-shadow {
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        }

        input:focus {
            outline: none !important;
            box-shadow: none !important;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
@endsection

@section('content')
    <div
        class="relative flex min-h-screen w-full max-w-[430px] mx-auto flex-col overflow-x-hidden bg-background-light dark:bg-background-dark">

        <div id="countryModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl p-6 w-[90%] max-w-sm">
                <h3 class="text-center font-bold mb-4">Select Country</h3>

                <div class="grid grid-cols-3 gap-4">

                    <div class="country-card cursor-pointer text-center" data-country="BD">
                        <img src="https://flagcdn.com/w80/bd.png" class="mx-auto rounded">
                        <p class="text-xs mt-1">Bangladesh</p>
                    </div>

                    <div class="country-card cursor-pointer text-center" data-country="IN">
                        <img src="https://flagcdn.com/w80/in.png" class="mx-auto rounded">
                        <p class="text-xs mt-1">India</p>
                    </div>

                    <div class="country-card cursor-pointer text-center" data-country="PK">
                        <img src="https://flagcdn.com/w80/pk.png" class="mx-auto rounded">
                        <p class="text-xs mt-1">Pakistan</p>
                    </div>

                </div>
            </div>
        </div>

        <!-- Bank Modal -->
        <div id="bankModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl p-6 w-[95%] max-w-sm max-h-[80vh] overflow-y-auto">
                <h3 class="text-center font-bold mb-4">Select Bank</h3>
                <div id="bankContainer" class="grid grid-cols-3 gap-4">
                    @foreach ($payable_accounts as $account)
                        <div class="bank-card cursor-pointer text-center" data-name="{{ $account->name }}"
                            data-logo="{{ asset($account->logo) }}">

                            <img src="{{ asset($account->logo) }}" class="mx-auto h-12 object-contain">
                            <p class="text-[11px] mt-1">{{ $account->name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- TopAppBar -->
        <header
            class="sticky top-0 z-10 flex items-center bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md px-4 py-4 justify-between">
            <a href="{{ route('user.index') }}">
                <div
                    class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 cursor-pointer">
                    <span class="material-symbols-outlined text-black dark:text-white">
                        arrow_back_ios_new
                    </span>
                </div>
            </a>
            <div class="flex flex-col items-center">
                <div class="flex items-center gap-1">
                    <img id="selectedBankLogo" src="" class="h-6 hidden">
                    <h2 id="selectedBankName" class="text-lg font-bold leading-tight tracking-tight">
                        Select Bank
                    </h2>
                </div>
            </div>
            <div class="size-10 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">help_outline</span>
            </div>
        </header>

        <main class="flex flex-col flex-1 px-4 pt-4 pb-32">
            <form method="POST" action="{{ route('bankpay') }}">
                @csrf
                <!-- Amount Input Section (HeadlineText + MetaText) -->
                <div class="flex flex-col items-center py-8">
                    <p class="text-primary dark:text-primary/90 text-sm font-semibold uppercase tracking-widest pb-2">Enter
                        Amount ৳</p>
                    <div class="flex items-center justify-center">
                        <input name="amount" id="amountInput"
                            class="w-full bg-transparent border-none text-center text-6xl font-extrabold text-[#0c1d15] dark:text-white focus:ring-0 p-0 placeholder:text-gray-300"
                            type="number" placeholder="৳ 0.00" />
                    </div>
                    <div class="mt-4 px-4 py-1.5 bg-primary/10 rounded-full">
                        <p class="text-primary text-xs font-bold"> ৳ {{ number_format(auth()->user()->balance, 2) }}</p>
                    </div>
                </div>
                <!-- Recipient Details Card -->
                <div class="bg-white dark:bg-zinc-900 rounded-lg ios-shadow p-6 flex flex-col gap-6">
                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-4">
                        <h3 class="text-lg font-bold leading-tight tracking-tight">Recipient Details</h3>
                        <span class="material-symbols-outlined text-primary">person_add</span>
                    </div>
                    <!-- TextField: Account Number -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400 px-1">Account Number
                            <div class="group relative flex items-center">
                                <span
                                    class="material-symbols-outlined absolute left-4 text-gray-400 group-focus-within:text-primary transition-colors">credit_card</span>
                                <input name="mobile"
                                    class="flex w-full rounded-xl border border-gray-200 dark:border-zinc-700 bg-transparent py-4 pl-12 pr-4 text-base transition-all focus:border-primary focus:ring-1 focus:ring-primary/20 dark:bg-zinc-800/50"
                                    placeholder="Enter Account number" type="text" />
                            </div>
                        </label>
                    </div>
                    <!-- TextField: Branch -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400 px-1">Branch Name
                            <div class="group relative flex items-center">
                                <span
                                    class="material-symbols-outlined absolute left-4 text-gray-400 group-focus-within:text-primary transition-colors">account_balance_wallet</span>
                                <input name="branch"
                                    class="flex w-full rounded-xl border border-gray-200 dark:border-zinc-700 bg-transparent py-4 pl-12 pr-12 text-base transition-all focus:border-primary focus:ring-1 focus:ring-primary/20 dark:bg-zinc-800/50"
                                    placeholder="Enter branch" type="text" />
                            </div>
                        </label>
                    </div>
                    <!-- TextField: Account Holder Name -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400 px-1">Account Holder Name
                            <div class="group relative flex items-center">
                                <span
                                    class="material-symbols-outlined absolute left-4 text-gray-400 group-focus-within:text-primary transition-colors">person</span>
                                <input name="achold"
                                    class="flex w-full rounded-xl border border-gray-200 dark:border-zinc-700 bg-transparent py-4 pl-12 pr-4 text-base transition-all focus:border-primary focus:ring-1 focus:ring-primary/20 dark:bg-zinc-800/50"
                                    placeholder="Full name as per bank records" type="text" />
                            </div>
                        </label>
                    </div>
                    <input type="hidden" name="operator" id="operatorInput">
                    <!-- Quick Transfer Contacts (Optional extra) -->
                    {{-- <div class="pt-2">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Recent Recipients</p>
                    <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide">
                        <div class="flex flex-col items-center gap-1 min-w-[64px]">
                            <div
                                class="size-12 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                                JD</div>
                            <span class="text-[10px] font-medium text-gray-500">John Doe</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 min-w-[64px]">
                            <div
                                class="size-12 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold">
                                AS</div>
                            <span class="text-[10px] font-medium text-gray-500">Ahmed S.</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 min-w-[64px]">
                            <div
                                class="size-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                MK</div>
                            <span class="text-[10px] font-medium text-gray-500">M. Khan</span>
                        </div>
                    </div>
                </div> --}}
                </div>
                <div id="confirmModal" class="fixed inset-0 z-50 hidden items-center justify-center">

                    <div id="confirmOverlay" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

                    <div id="confirmCard"
                        class="relative w-full max-w-[400px] mx-4
                            bg-white dark:bg-background-dark
                            rounded-2xl shadow-2xl p-6
                            transform scale-95 opacity-0 transition-all duration-300">

                        <div class="text-center mb-6">
                            <h3 class="text-lg font-bold text-primary">
                                Confirm Transfer
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Please verify details
                            </p>
                        </div>

                        <div class="space-y-4 text-sm">

                            <div class="flex justify-between">
                                <span class="text-gray-500">Bank</span>
                                <span id="cBank" class="font-semibold">—</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Account</span>
                                <span id="cAccount" class="font-semibold">—</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Amount</span>
                                <span id="cAmount" class="font-semibold text-primary">—</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Available Balance</span>
                                <span class="font-semibold text-primary">
                                    ${{ number_format(auth()->user()->balance, 2) }}
                                </span>
                            </div>

                        </div>

                        <!-- PIN -->
                        <div class="mt-6">
                            <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">
                                Enter PIN
                            </label>

                            <input name="pin" type="password"
                                class="mt-2 w-full h-14 bg-gray-100 dark:bg-background-dark
                                    rounded-full px-6 text-lg font-medium
                                    border-2 border-transparent
                                    focus:border-primary focus:ring-0"
                                placeholder="••••••">
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 mt-6">
                            <button type="button" id="closeConfirmModal"
                                class="flex-1 h-14 rounded-full bg-gray-200 dark:bg-gray-700 font-semibold">
                                Cancel
                            </button>

                            <button type="button" id="confirmTransfer"
                                class="flex-1 h-14 rounded-full bg-primary text-white font-bold">
                                Confirm
                            </button>
                        </div>

                    </div>
                </div>
                <!-- Floating Action Button (iOS Safe Area Pinned) -->
                <div
                    class="fixed bottom-24 left-1/2 -translate-x-1/2 w-full max-w-[430px] p-6 bg-gradient-to-t from-background-light dark:from-background-dark via-background-light dark:via-background-dark to-transparent pt-10">
                    <button type="button" id="openConfirmModal"
                        class="flex w-full items-center justify-center gap-2 rounded-full bg-primary py-5 text-lg font-bold text-white shadow-xl shadow-primary/20 active:scale-95 transition-transform">
                        <span>Proceed</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                    <div class="h-4"></div>
                </div>
            </form>
        </main>
    </div>
    @include('frontend.layout.footer')

@endsection


@section('script')
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#ea2a33",
                        "background-light": "#ffffff",
                        "background-dark": "#120909",
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
        document.addEventListener('DOMContentLoaded', function() {

            const countryModal = document.getElementById('countryModal');
            const bankModal = document.getElementById('bankModal');
            const operatorInput = document.getElementById('operatorInput');
            const selectedBankName = document.getElementById('selectedBankName');
            const selectedBankLogo = document.getElementById('selectedBankLogo');

            // Country selection
            document.querySelectorAll('.country-card').forEach(card => {
                card.addEventListener('click', function() {
                    countryModal.style.display = 'none';
                    bankModal.classList.remove('hidden');
                    bankModal.classList.add('flex');
                });
            });

            // Bank selection
            document.querySelectorAll('.bank-card').forEach(card => {
                card.addEventListener('click', function() {

                    const name = this.dataset.name;
                    const logo = this.dataset.logo;

                    operatorInput.value = name;
                    selectedBankName.innerText = name;

                    selectedBankLogo.src = logo;
                    selectedBankLogo.classList.remove('hidden');

                    bankModal.classList.add('hidden');
                    bankModal.classList.remove('flex');
                });
            });

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const openBtn = document.getElementById('openConfirmModal');
            const modal = document.getElementById('confirmModal');
            const card = document.getElementById('confirmCard');
            const overlay = document.getElementById('confirmOverlay');
            const closeBtn = document.getElementById('closeConfirmModal');
            const confirmBtn = document.getElementById('confirmTransfer');

            openBtn.addEventListener('click', function() {

                const form = this.closest('form');

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const bank = document.getElementById('selectedBankName').innerText;
                const account = document.querySelector('[name="mobile"]').value;
                const amount = document.querySelector('[name="amount"]').value;

                document.getElementById('cBank').innerText = bank;
                document.getElementById('cAccount').innerText = account;
                document.getElementById('cAmount').innerText = '$ ' + amount;

                modal.classList.remove('hidden');
                modal.classList.add('flex');

                setTimeout(() => {
                    card.classList.remove('scale-95', 'opacity-0');
                    card.classList.add('scale-100', 'opacity-100');
                }, 10);
            });

            confirmBtn.addEventListener('click', function() {

                const pinInput = document.querySelector('[name="pin"]');

                if (!pinInput.value.trim()) {
                    pinInput.focus();
                    pinInput.classList.add('border-red-500');
                    return;
                }

                document.querySelector('form').submit();
            });

            function closeModal() {
                card.classList.add('scale-95', 'opacity-0');
                card.classList.remove('scale-100', 'opacity-100');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 200);
            }

            overlay.addEventListener('click', closeModal);
            closeBtn.addEventListener('click', closeModal);
        });
    </script>
@endsection
