@extends('frontend.layout.master')
@section('meta')
    <link rel="canonical" href="{{ route('user.index') }}" />
@endsection
@section('style')
    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
@endsection

@section('content')

<form method="POST" action="{{ route('recharge') }}">
    @csrf

    <div class="relative flex h-full min-h-screen w-full max-w-[480px] flex-col bg-white dark:bg-background-dark overflow-x-hidden shadow-2xl">

        <div class="flex items-center bg-white dark:bg-background-dark p-4 pb-2 justify-between sticky top-0 z-50">
            <a href="{{ route('user.index') }}">
                <div class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 cursor-pointer">
                    <span class="material-symbols-outlined text-black dark:text-white">
                        arrow_back_ios_new
                    </span>
                </div>
            </a>
            <h2
                class="text-[#0c1d15] dark:text-white text-lg font-extrabold leading-tight tracking-[-0.015em] flex-1 text-center pr-12">
                Mobile Recharge</h2>
        </div>

        <div class="px-4 pt-6">
            <h3 class="text-[#0c1d15] dark:text-white text-base font-bold leading-tight tracking-[-0.015em] mb-4">Select
                Operator</h3>

            <div class="flex gap-4 overflow-x-auto hide-scrollbar pb-4">

            <!-- Grameenphone -->
            <label class="flex flex-col items-center gap-2 shrink-0 cursor-pointer">
                <input type="radio" name="operator" value="Grameenphone" class="hidden peer" required>

                <div class="p-1 rounded-full border-2 border-transparent peer-checked:border-primary transition">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-14 bg-gray-100"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBPdmYzWzv2SfUwxkVzuOxeiqsw0C-VlCQSDDtYeP5t9gqMCKPH1f05b8XGMA_t1PshtHyKIKVlDNpprnVQPFpKFs0ZV-HgWkFXqbW6krbyWOHuQ5AhglXFyYCtKxDeA-k1apwB_hYiuUNiAStt-izjAKCFfcbIpGm0pBj15Ykuk7-LMYSy2efaiizsuqTq_IUcU6ZiNSFR1set41sudyk3In18RLOtGaOJIg80CCrOG1xNkJzO_aszQXjvDM30tOyCa1POk-8HYis");'>
                    </div>
                </div>

                <p class="text-[12px] font-bold peer-checked:text-primary text-[#45a179] dark:text-gray-400">
                    Grameenphone
                </p>
            </label>


            <!-- Robi -->
            <label class="flex flex-col items-center gap-2 shrink-0 cursor-pointer">
                <input type="radio" name="operator" value="Robi" class="hidden peer" required>

                <div class="p-1 rounded-full border-2 border-transparent peer-checked:border-primary transition">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-14 bg-gray-100"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCZi7Mu38YHJjTD_q19DxH7jYu5UWePm8K4ss-qORvhBaU2I3u3cl1ARa6yIYRJOcbfQCQ4xGJDfV8613jhIpun5u_k9hWcdRgRQnysePMEenK03kLO4CViDwXk3apI4cyD6Xyi9bZe6XTSihHWDWEO3_nU7DA-6hPT68Ha8zEpINBgizckRUIieb9Y0j0aVxGl10d8mD6LtKAHii1tofFJdnY4RuhUt38R7GkOOPh0UES7u6vvrqm5WB0cVDow2G03Me0FB2VWMAA");'>
                    </div>
                </div>

                <p class="text-[12px] font-bold peer-checked:text-primary text-[#45a179] dark:text-gray-400">
                    Robi
                </p>
            </label>


            <!-- Airtel -->
            <label class="flex flex-col items-center gap-2 shrink-0 cursor-pointer">
                <input type="radio" name="operator" value="Airtel" class="hidden peer" required>

                <div class="p-1 rounded-full border-2 border-transparent peer-checked:border-primary transition">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-14 bg-gray-100"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuC__9VcJldgc5FFxuS3az9naQ3e0G444eWamTw-QJ6bM0JKClobPZ4xjBGSFPPdpSTtRult99uG6fuj8rbnowOlko3mMR6gok8zjavZnO1TzyNgTPRntO1pJ3NiEltXUtqijP3kFQ-Cfw6A8daKoU4WGlrDvcLjop6EPWSVF5H6K24rJNDG1B0rTP6Ebk9a7z9ncD1k73289VOqo-t3rAxhNpnEbqv1ztESg98acPfvmSTo7WwojKZJA2ZjdOBYo8q0JIVePIG-dvc");'>
                    </div>
                </div>

                <p class="text-[12px] font-bold peer-checked:text-primary text-[#45a179] dark:text-gray-400">
                    Airtel
                </p>
            </label>

            <label class="flex flex-col items-center gap-2 shrink-0 cursor-pointer">
                <input type="radio" name="operator" value="Teletalk" class="hidden peer" required>

                <div class="p-1 rounded-full border-2 border-transparent peer-checked:border-primary transition">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-14 bg-gray-100"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCJDgfSsJXBol_ZbvsMWl-uUiz46yYjnHoUyfuGoA0d2KMcXOOdPkYjtU6z2GwBs79XDTGMVjMbIMNOpNg14Pag_q6Eeh3joAxiltsp9vaqU6pqso9HbBYwv4twVxW1PBjg0YKU7b_9wfSwQBPp0nIeixHgNcApAPXSeHoMTWNwKnhGcK54EhpnXeLMQpIVjMoFeGopkVCNWbEhKnA_GxdFALwZp4eL8UeAEwFdvOi10bOvHthBhUHCckkCqpX1e5o9to74_4znE6w");'>
                    </div>
                </div>

                <p class="text-[12px] font-bold peer-checked:text-primary text-[#45a179] dark:text-gray-400">
                    Teletalk
                </p>
            </label>

            <label class="flex flex-col items-center gap-2 shrink-0 cursor-pointer">
                <input type="radio" name="operator" value="Banglalink" class="hidden peer" required>

                <div class="p-1 rounded-full border-2 border-transparent peer-checked:border-primary transition">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-14 bg-gray-100"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAbUjlN2fHHUwuChPnXblVYKDxGMV_nOu8Y0h_IfshkMwq91XNHGNFheZzyqTcJzEqYucr3aeLfwjR5XxJoCzqfhCjcAme_ur9ATjLv9BNTmY7K3H-Hi1FJ8kOm2cKPse60EyVPNSAG-kTZrlbPKXO1_5yhsnePWG4vyWVfYvVTFg6dV0jjkSHPWNNRcpIM5pe4ZxHYxLvk2LPcTp8SwaQt47fXGXC3otIXxTHGJmK5dCONAxSO5x33-5L-RS9YeEdCEiULnYF186w");'>
                    </div>
                </div>

                <p class="text-[12px] font-bold peer-checked:text-primary text-[#45a179] dark:text-gray-400">
                    Banglalink
                </p>
            </label>
        </div>


        <div class="flex flex-col gap-4 px-4 py-4">
            <div class="flex flex-col">
                <p class="text-[#0c1d15] dark:text-gray-300 text-sm font-bold leading-normal pb-2">Mobile Number</p>
                <div
                    class="flex w-full items-stretch rounded-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-gray-700 overflow-hidden focus-within:border-primary transition-colors">
                    <input
                        name="mobile"
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden text-[#0c1d15] dark:text-white focus:outline-0 focus:ring-0 border-none bg-transparent h-14 placeholder:text-gray-400 p-[15px] pr-2 text-base font-medium"
                        placeholder="017XX-XXXXXX" type="tel" required />
                    <div class="text-primary flex items-center justify-center pr-[15px] cursor-pointer">
                        <span class="material-symbols-outlined">contact_page</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col pt-2">
                <p class="text-[#0c1d15] dark:text-gray-300 text-sm font-bold leading-normal pb-2">Recharge Amount</p>
                <div
                    class="relative flex flex-col items-center justify-center bg-primary/5 dark:bg-primary/10 rounded-xl py-2 border-2 border-dashed border-primary/20">
                    <div class="flex items-center gap-2">
                        <span class="text-3xl font-extrabold text-primary">৳</span>
                        <input
                            name="amount"
                            class="w-32 bg-transparent text-4xl font-extrabold text-primary focus:ring-0 border-none p-0 text-center"
                            placeholder="0" type="number" min="1" required />
                    </div>
                    <p class="text-primary/70 text-xs font-bold mt-2 uppercase tracking-wider">
                        Available Balance: ৳{{ number_format(auth()->user()->balance,2) }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <p class="text-[#0c1d15] dark:text-gray-300 text-sm font-bold leading-normal pb-2">SIM Type</p>
                    <div class="relative">
                        <select
                            name="type"
                            class="form-select w-full h-14 rounded-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-gray-700 text-[#0c1d15] dark:text-white px-4 focus:ring-primary focus:border-primary appearance-none"
                            required>
                            <option value="Prepaid">Prepaid</option>
                            <option value="Postpaid">Postpaid</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <span class="material-symbols-outlined">expand_more</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="px-4 pb-8 pt-4">
            <button
                type="button" id="openRechargeModal"
               class="w-full h-14 bg-primary text-white text-lg font-bold rounded-full shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all">
                <span>Recharge Now</span>
                <span class="material-symbols-outlined">bolt</span>
            </button>
        </div>
    </div>

    <!-- Recharge Confirm Modal -->
    <div id="rechargeConfirmModal"
        class="fixed inset-0 z-50 hidden items-center justify-center">

        <!-- Overlay -->
        <div id="rechargeOverlay"
            class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

        <!-- Modal Card -->
        <div id="rechargeCard"
            class="relative w-full max-w-[400px] mx-4
                    bg-white dark:bg-background-dark
                    rounded-2xl shadow-2xl p-6
                    transform scale-95 opacity-0 transition-all duration-300">

            <div class="text-center mb-6">
                <h3 class="text-lg font-bold text-primary">
                    Confirm Recharge
                </h3>
                <p class="text-sm text-gray-500 mt-1">
                    Please verify details
                </p>
            </div>

            <!-- Summary -->
            <div class="space-y-4 text-sm">

                <div class="flex justify-between">
                    <span class="text-gray-500">Operator</span>
                    <span id="rOperator" class="font-semibold">—</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Number</span>
                    <span id="rMobile" class="font-semibold">—</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Type</span>
                    <span id="rType" class="font-semibold">—</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Amount</span>
                    <span id="rAmount" class="font-semibold text-primary">—</span>
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
                    placeholder="••••••"
                    >
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 mt-6">
                <button type="button"
                        id="closeRechargeModal"
                        class="flex-1 h-14 rounded-full
                            bg-gray-200 dark:bg-gray-700
                            font-semibold">
                    Cancel
                </button>

                <button type="button"
                        id="confirmRecharge"
                        class="flex-1 h-14 rounded-full bg-primary text-white font-bold">
                    Confirm
                </button>

            </div>

        </div>
    </div>

</form>

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
    const openRechargeBtn  = document.getElementById('openRechargeModal');
    const rechargeModal    = document.getElementById('rechargeConfirmModal');
    const rechargeCard     = document.getElementById('rechargeCard');
    const rechargeOverlay  = document.getElementById('rechargeOverlay');
    const closeRechargeBtn = document.getElementById('closeRechargeModal');

    openRechargeBtn.addEventListener('click', function () {

        const form = this.closest('form');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const operator = document.querySelector('[name="operator"]:checked')?.value;
        const mobile   = document.querySelector('[name="mobile"]').value;
        const amount   = document.querySelector('[name="amount"]').value;
        const type     = document.querySelector('[name="type"]').value;

        document.getElementById('rOperator').innerText = operator;
        document.getElementById('rMobile').innerText   = mobile;
        document.getElementById('rType').innerText     = type;
        document.getElementById('rAmount').innerText   = '৳ ' + amount;

        rechargeModal.classList.remove('hidden');
        rechargeModal.classList.add('flex');

        setTimeout(() => {
            rechargeCard.classList.remove('scale-95','opacity-0');
            rechargeCard.classList.add('scale-100','opacity-100');
        }, 10);
    }); 

    const confirmBtn = document.getElementById('confirmRecharge');

    confirmBtn.addEventListener('click', function () {
        const pinInput = document.querySelector('[name="pin"]');

        if (!pinInput.value.trim()) {
            pinInput.focus();
            pinInput.classList.add('border-red-500');
            return;
        }

        this.closest('form').submit();
    });


    function closeRechargeModal() {
        rechargeCard.classList.add('scale-95','opacity-0');
        rechargeCard.classList.remove('scale-100','opacity-100');

        setTimeout(() => {
            rechargeModal.classList.add('hidden');
            rechargeModal.classList.remove('flex');
        }, 200);
    }

    rechargeOverlay.addEventListener('click', closeRechargeModal);
    closeRechargeBtn.addEventListener('click', closeRechargeModal);
</script>


@endsection