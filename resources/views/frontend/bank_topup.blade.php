@extends('frontend.layout.master')

@section('content')
<div class="max-w-md mx-auto px-4 pb-28">

    <!-- Header -->
    <header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md px-4 py-4 flex items-center justify-between">
        <a href="{{ route('user.index') }}">
            <div class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 cursor-pointer">
                <span class="material-symbols-outlined text-black dark:text-white">
                    arrow_back_ios_new
                </span>
            </div>
        </a>
        <h2 class="text-lg font-bold leading-tight tracking-tight">Bank Add Fund</h2>
        <button class="w-12 h-12 flex items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-white/10 transition-colors">
            <span class="material-symbols-outlined text-2xl">help</span>
        </button>
    </header>

    {{-- <div class="text-center py-6">
        <h2 class="text-2xl font-bold text-primary dark:text-primary-light">
            Bank Add Fund
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
            Submit your bank deposit receipt
        </p>
    </div> --}}
    

    <form method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="Bank Add pay">

        <!-- ================= BANK SELECTION ================= -->
        <div class="mb-6">
            <p class="text-sm font-semibold mb-4 text-gray-700 dark:text-gray-200">
                Select Bank Account
            </p>

            <div class="space-y-4">
                @foreach($accounts as $account)
                    @php $details = strip_tags($account->details ?? ''); @endphp
                    <label class="block cursor-pointer">
                        <input type="radio" name="account_id" value="{{ $account->id }}"
                               data-name="{{ $account->name }}" data-details="{{ $details }}"
                               class="peer absolute opacity-0 w-0 h-0" required>

                        <div class="p-4 rounded-2xl border 
                                    bg-white dark:bg-gray-800
                                    border-gray-200 dark:border-gray-700
                                    transition-all duration-300
                                    hover:shadow-md
                                    peer-checked:border-primary
                                    peer-checked:ring-2 peer-checked:ring-primary/30">

                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm">
                                        {{ $account->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-mono break-all">
                                        {{ $details }}
                                    </p>
                                </div>

                                <div class="w-5 h-5 rounded-full border-2
                                            flex items-center justify-center
                                            border-gray-400 dark:border-gray-500
                                            transition-all duration-300
                                            peer-checked:border-primary">
                                    <div class="w-2.5 h-2.5 rounded-full bg-primary
                                                scale-0 peer-checked:scale-100
                                                transition-transform duration-200"></div>
                                </div>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- ================= FILE UPLOAD ================= -->
        <div class="mb-5">
            <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                Upload Deposit Slip
            </label>
            <input type="file" name="file" id="fileInput" accept="image/*" required
                   class="mt-2 w-full bg-gray-100 dark:bg-gray-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none">

            <!-- Preview -->
            <div id="filePreview" class="mt-3 hidden relative">
                <img src="" alt="Preview" class="rounded-xl w-full object-contain max-h-64 border border-gray-200 dark:border-gray-600">
                <button type="button" id="removeImage" 
                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center shadow">
                    &times;
                </button>
            </div>
        </div>

        <!-- ================= AMOUNT ================= -->
        <div class="mb-6">
            <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                Amount (BDT)
            </label>
            <input type="number" name="amount" step="any" required placeholder="Enter deposit amount"
                   class="mt-2 w-full bg-gray-100 dark:bg-gray-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none">
        </div>

        <!-- ================= OPEN MODAL BUTTON ================= -->
        <button type="button" id="openConfirmModal"
                class="w-full h-14 rounded-full bg-primary text-white font-bold text-lg shadow-lg">
            Confirm Deposit
        </button>

        <!-- ================= CONFIRMATION MODAL ================= -->
        <div id="confirmModal" class="fixed inset-0 z-50 hidden items-center justify-center">

            <div id="overlay" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

            <div id="modalCard"
                 class="relative w-full max-w-[400px] mx-4
                        bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6
                        transform scale-95 opacity-0 transition-all duration-300">

                <div class="text-center mb-5">
                    <h3 class="font-bold text-lg text-primary dark:text-primary-light">
                        Confirm Bank Deposit
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                        Please verify the details and enter your PIN
                    </p>
                </div>

                <div class="space-y-4 text-sm">

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                        <p class="text-xs uppercase text-gray-500 dark:text-gray-400 tracking-wide">
                            Selected Bank
                        </p>
                        <p id="mBank" class="font-bold text-gray-800 dark:text-gray-100 mt-1">
                            —
                        </p>

                        <p class="text-xs uppercase text-gray-500 dark:text-gray-400 tracking-wide mt-4">
                            Account Number
                        </p>
                        <p id="mDetails" class="font-mono font-semibold text-gray-800 dark:text-gray-100 mt-1 break-all">
                            —
                        </p>
                    </div>

                    <div class="flex justify-between text-base mt-2">
                        <span class="text-gray-600 dark:text-gray-300 font-medium">
                            Deposit Amount
                        </span>
                        <span id="mAmount" class="font-bold text-primary text-lg">
                            —
                        </span>
                    </div>

                    <!-- PIN INPUT -->
                    <div class="mt-4">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Enter PIN
                        </label>
                        <input type="password" name="pin" id="pinInput"
                               placeholder="••••••"
                               class="mt-2 w-full bg-gray-100 dark:bg-gray-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none">
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex gap-3 mt-6">
                    <button type="button" id="closeModal"
                            class="flex-1 h-12 rounded-full bg-gray-200 dark:bg-gray-700 font-semibold">
                        Cancel
                    </button>

                    <button type="submit" class="flex-1 h-12 rounded-full bg-primary text-white font-bold">
                        Submit
                    </button>
                </div>

            </div>
        </div>

    </form>
</div>
@endsection

@section('script')
<script>
const openBtn = document.getElementById('openConfirmModal');
const modal = document.getElementById('confirmModal');
const card = document.getElementById('modalCard');
const overlay = document.getElementById('overlay');
const closeBtn = document.getElementById('closeModal');

openBtn.addEventListener('click', function() {
    const form = this.closest('form');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const selected = document.querySelector('[name="account_id"]:checked');
    if (!selected) {
        alert('Please select a bank account');
        return;
    }

    const pinInput = document.getElementById('pinInput');
    pinInput.value = '';

    document.getElementById('mBank').innerText = selected.dataset.name;
    document.getElementById('mDetails').innerText = selected.dataset.details;
    document.getElementById('mAmount').innerText = '৳ ' + document.querySelector('[name="amount"]').value;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        card.classList.remove('scale-95', 'opacity-0');
        card.classList.add('scale-100', 'opacity-100');
    }, 10);
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

// ================= FILE PREVIEW =================
const fileInput = document.getElementById('fileInput');
const filePreview = document.getElementById('filePreview');
const removeBtn = document.getElementById('removeImage');

fileInput.addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            filePreview.querySelector('img').src = e.target.result;
            filePreview.classList.remove('hidden');
        }
        reader.readAsDataURL(this.files[0]);
    } else {
        filePreview.classList.add('hidden');
    }
});

removeBtn.addEventListener('click', function() {
    fileInput.value = '';
    filePreview.classList.add('hidden');
});
</script>
@endsection