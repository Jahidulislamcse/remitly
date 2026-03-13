@extends('frontend.layout.master')

@section('meta')
    {{-- <link rel="canonical" href="{{ route('user.topup') }}" /> --}}
@endsection

@section('style')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .custom-scrollbar::-webkit-scrollbar { width: 0px; }
    .custom-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    input:checked + div { border-color: #f20d0d; background-color: rgba(242,13,13,0.1); }
</style>
@endsection

@section('content')

<div class="bg-background-light dark:bg-background-dark min-h-screen font-display text-slate-900 dark:text-white flex flex-col">
    <div class="w-full sm:max-w-[420px] sm:mx-auto">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md px-4 py-4 flex items-center justify-between">
            <a href="{{ route('user.index') }}">
                <div class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 cursor-pointer">
                    <span class="material-symbols-outlined text-black dark:text-white">
                        arrow_back_ios_new
                    </span>
                </div>
            </a>
            <h2 class="text-lg font-bold leading-tight tracking-tight">মোবাইল পে ফান্ড অ্যাড</h2>
            <button class="w-12 h-12 flex items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-white/10 transition-colors">
                <span class="material-symbols-outlined text-2xl">help</span>
            </button>
        </header>

        <!-- Form -->
        <form method="POST" action="{{ route('topup') }}">
        @csrf
        <main class="flex-1 px-4 pb-32 overflow-y-auto custom-scrollbar">

            <!-- Instructions Card -->
            <div class="bg-primary/10 rounded-2xl p-4 mb-6">
                <p class="text-sm font-semibold text-primary mb-2">নির্দেশনা</p>
                <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
                    বিকাশ / নগদ / রকেট / উপায় নাম্বারে টাকা পাঠিয়ে নিচে তথ্য পূরণ করুন।
                </p>
            </div>

            <!-- Account Selection -->
            <div class="px-4 mb-6">
                <h3 class="text-sm font-bold mb-3">পেমেন্ট মাধ্যম নির্বাচন করুন</h3>
                <div class="flex gap-4 overflow-x-auto hide-scrollbar pb-2">
                    @foreach($accounts as $account)
                    <label class="flex flex-col items-center shrink-0 cursor-pointer">
                        <input type="radio" name="account_id" value="{{ $account->id }}" class="hidden peer" required>

                        <div class="p-3 rounded-2xl border border-gray-200 dark:border-white/10 text-center peer-checked:border-primary peer-checked:bg-primary/10 transition-all">

                            <!-- Dynamic Icon -->
                            @php
                                $icon = asset('/images/front-icons/default.png'); // fallback
                                $lowerName = strtolower($account->name);
                                if (str_contains($lowerName, 'bkash')) {
                                    $icon = asset('/images/front-icons/bkash3.png');
                                } elseif (str_contains($lowerName, 'nagad')) {
                                    $icon = asset('/images/front-icons/nagad3.png');
                                } elseif (str_contains($lowerName, 'upay')) {
                                    $icon = asset('/images/front-icons/upay.png');
                                } elseif (str_contains($lowerName, 'rocket')) {
                                    $icon = asset('/images/front-icons/rocket.png');
                                }
                            @endphp

                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full w-12 h-12 mx-auto mb-2"
                                style="background-image: url('{{ $icon }}')">
                            </div>

                            <p class="font-bold text-sm">{{ $account->name }}</p>
                            <p class="text-xs text-gray-500 mt-1">{!! $account->details !!}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Sender Last 4 Digits -->
            <div class="flex flex-col gap-2 mb-4">
                <label class="text-sm font-semibold">প্রেরকের নাম্বারের শেষ ৪ ডিজিট</label>
                <input type="text" name="acc" required placeholder="1234"
                    class="w-full h-14 rounded-2xl px-4 border border-gray-200 dark:border-white/10 bg-white dark:bg-[#1E1E1E] focus:border-primary focus:ring-0">
            </div>

            <!-- Amount -->
            <div class="flex flex-col gap-2 mb-6">
                <label class="text-sm font-semibold">টাকার পরিমাণ</label>
                <input type="number" name="amount" required placeholder="1000"
                    class="w-full h-14 rounded-2xl px-4 border border-gray-200 dark:border-white/10 bg-white dark:bg-[#1E1E1E] focus:border-primary focus:ring-0">
            </div>

            <input type="hidden" name="type" value="Mobile Banking">

            <!-- Submit -->
            <button  
                type="button"
                id="openTopupModal"
                class="w-full h-14 rounded-full bg-primary text-white font-bold text-lg shadow-lg shadow-primary/20 active:scale-95 transition">
                কনফার্ম পেমেন্ট
            </button>

            <!-- Topup Confirm Modal -->
            <div id="topupConfirmModal"
                class="fixed inset-0 z-50 hidden items-center justify-center">

                <!-- Overlay -->
                <div id="topupOverlay"
                    class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

                <!-- Modal Card -->
                <div id="topupCard"
                    class="relative w-full max-w-[400px] mx-4
                            bg-white dark:bg-background-dark
                            rounded-2xl shadow-2xl p-6
                            transform scale-95 opacity-0 transition-all duration-300">

                    <div class="text-center mb-6">
                        <h3 class="text-lg font-bold text-primary">
                            Confirm Topup
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Please verify details
                        </p>
                    </div>

                    <!-- Summary -->
                    <div class="space-y-4 text-sm">

                        <div class="flex justify-between">
                            <span class="text-gray-500">Payment Method</span>
                            <span id="tAccount" class="font-semibold">—</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Amount</span>
                            <span id="tAmount" class="font-semibold text-primary">—</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Last 4 Digits</span>
                            <span id="tLast4" class="font-semibold text-primary">—</span>
                        </div>

                    </div>

                    <!-- PIN -->
                    <div class="mt-6">
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">
                            Enter PIN
                        </label>

                        <input name="pin"
                            type="password"
                            class="mt-2 w-full h-14 bg-gray-100 dark:bg-background-dark
                                    rounded-full px-6 text-lg font-medium
                                    border-2 border-transparent
                                    focus:border-primary focus:ring-0"
                            placeholder="">
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 mt-6">
                        <button type="button"
                                id="closeTopupModal"
                                class="flex-1 h-14 rounded-full bg-gray-200 dark:bg-gray-700 font-semibold">
                            Cancel
                        </button>

                        <button type="button"
                                id="confirmTopup"
                                class="flex-1 h-14 rounded-full bg-primary text-white font-bold">
                            Confirm
                        </button>
                    </div>

                </div>
            </div>

            </main>
        </form>
    </div>
</div>

@endsection

@section('script')
<script>
    const openTopupBtn  = document.getElementById('openTopupModal');
    const topupModal    = document.getElementById('topupConfirmModal');
    const topupCard     = document.getElementById('topupCard');
    const topupOverlay  = document.getElementById('topupOverlay');
    const closeTopupBtn = document.getElementById('closeTopupModal');

    openTopupBtn.addEventListener('click', function () {

        const form = this.closest('form');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const account = document.querySelector('[name="account_id"]:checked')
                        ?.closest('label')
                        .querySelector('p.font-bold')?.innerText;

        const amount  = document.querySelector('[name="amount"]').value;

        document.getElementById('tAccount').innerText = account ?? '—';
        document.getElementById('tAmount').innerText  = '৳ ' + amount;
        document.getElementById('tLast4').innerText  = document.querySelector('[name="acc"]').value || '—';

        topupModal.classList.remove('hidden');
        topupModal.classList.add('flex');

        setTimeout(() => {
            topupCard.classList.remove('scale-95','opacity-0');
            topupCard.classList.add('scale-100','opacity-100');
        }, 10);
    });

    document.getElementById('confirmTopup').addEventListener('click', function () {

        const pinInput = document.querySelector('[name="pin"]');

        if (!pinInput.value.trim()) {
            pinInput.focus();
            pinInput.classList.add('border-red-500');
            return;
        }

        this.closest('form').submit();
    });

    function closeTopupModal() {
        topupCard.classList.add('scale-95','opacity-0');
        topupCard.classList.remove('scale-100','opacity-100');

        setTimeout(() => {
            topupModal.classList.add('hidden');
            topupModal.classList.remove('flex');
        }, 200);
    }

    topupOverlay.addEventListener('click', closeTopupModal);
    closeTopupBtn.addEventListener('click', closeTopupModal);
</script>
@endsection