@extends('frontend.layout.master')
@section('meta')
    <link rel="canonical" href="{{ route('user.index') }}" />
@endsection
@section('style')
@endsection

<div class="w-full sm:max-w-[420px] sm:mx-auto">
    @include('frontend.layout.header')

    <main class="mt-4">
        @yield('content')
    </main>
</div>

@section('content')
    <div
        class="mx-4 -mt-16 bg-white dark:bg-[#151515] rounded-[2rem] p-6 ios-shadow border border-gray-100 dark:border-white/5">
        <div class="grid grid-cols-3 gap-y-6 gap-x-4">

            <a href="javascript:void(0);" id="openFundModal" class="flex flex-col items-center gap-2">
                <div class="service-tile bg-gray-50 dark:bg-[#1E1E1E] p-4 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-3xl">add_circle</span>
                </div>
                <span class="text-[11px] font-bold text-center text-gray-700 dark:text-gray-300">টাকা জমা</span>
            </a>

            <a href="{{ route('bankpay') }}" class="flex flex-col items-center gap-2">
                <div class="service-tile bg-gray-50 dark:bg-[#1E1E1E] p-4 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-3xl">account_balance</span>
                </div>
                <span class="text-[11px] font-bold text-center text-gray-700 dark:text-gray-300">Bank Withdraw</span>
            </a>

            <a href="{{ route('recharge') }}" class="flex flex-col items-center gap-2">
                <div class="service-tile bg-gray-50 dark:bg-[#1E1E1E] p-4 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-3xl">bolt</span>
                </div>
                <span class="text-[11px] font-bold text-center text-gray-700 dark:text-gray-300">Recharge</span>
            </a>

            <a href="{{ route('remittance') }}" class="flex flex-col items-center gap-2">
                <div class="service-tile bg-gray-50 dark:bg-[#1E1E1E] p-4 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-3xl">currency_exchange</span>
                </div>
                <span class="text-[11px] font-bold text-center text-gray-700 dark:text-gray-300">Remittance</span>
            </a>

            <a href="{{ route('mobile.banking', 'bkash') }}">
                <div class="flex flex-col items-center gap-2">
                    <div class="service-tile bg-gray-50 dark:bg-[#1E1E1E] p-2 rounded-2xl">
                        <div class="grid grid-cols-2 gap-1">
                            <div class="flex items-center justify-center">
                                <img src="/images/front-icons/bkash3.png" class="h-4 w-auto">
                            </div>
                            <div class="flex items-center justify-center">
                                <img src="/images/front-icons/nagad3.png" class="h-4 w-auto">
                            </div>
                            <div class="flex items-center justify-center">
                                <img src="/images/front-icons/upay.png" class="h-4 w-auto">
                            </div>
                            <div class="flex items-center justify-center">
                                <img src="/images/front-icons/rocket.png" class="h-3 w-auto">
                            </div>
                        </div>
                    </div>
                    <span class="text-[11px] mt-1 font-bold text-center text-gray-700 dark:text-gray-300">
                        Mobile Banking
                    </span>
                </div>
            </a>

            <a href="{{ route('new.chat') }}" class="flex flex-col items-center gap-2">
                <div class="service-tile bg-gray-50 dark:bg-[#1E1E1E] p-4 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-3xl">chat</span>
                </div>
                <span class="text-[11px] font-bold text-center text-gray-700 dark:text-gray-300">Group Chat</span>
            </a>

            <a href="{{ route('support') }}" class="flex flex-col items-center gap-2">
                <div class="service-tile bg-gray-50 dark:bg-[#1E1E1E] p-4 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-3xl">support_agent</span>
                </div>
                <span class="text-[11px] font-bold text-center text-gray-700 dark:text-gray-300">Customer Care</span>
            </a>

            <a href="{{ route('reviews.view') }}" class="flex flex-col items-center gap-2">
                <div class="service-tile bg-gray-50 dark:bg-[#1E1E1E] p-4 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-3xl">star</span>
                </div>
                <span class="text-[11px] font-bold text-center text-gray-700 dark:text-gray-300">Customer Reviews</span>
            </a>

            <a href="{{ route('about') }}" class="flex flex-col items-center gap-2">
                <div class="service-tile bg-gray-50 dark:bg-[#1E1E1E] p-4 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-3xl">info</span>
                </div>
                <span class="text-[11px] font-bold text-center text-gray-700 dark:text-gray-300">About Us</span>
            </a>

        </div>
    </div>
    <div class="mt-8 px-4">
        <div class="flex justify-between items-center px-2 mb-4">
            <h3 class="text-lg font-bold tracking-tight">Special Offers</h3>
        </div>

        <div class="flex overflow-x-auto gap-4 scrollbar-hide snap-x px-2 pb-4">

            @forelse($banners as $banner)
                <div
                    class="snap-center min-w-[280px] h-36 rounded-2xl bg-primary p-5 flex flex-col justify-between relative overflow-hidden">

                    <div class="relative z-10">
                        <p class="text-white/70 text-[10px] font-bold uppercase tracking-widest mb-1">
                            Special Offer
                        </p>

                        <h4 class="text-white text-xl font-extrabold leading-tight">
                            {{ $banner->title }}
                        </h4>

                        @if ($banner->description)
                            <p class="text-white/80 text-sm mt-2 line-clamp-2">
                                {{ $banner->description }}
                            </p>
                        @endif
                    </div>

                    <div class="absolute -right-6 -bottom-6 opacity-10">
                        <span class="material-symbols-outlined text-[160px]">
                            local_offer
                        </span>
                    </div>

                </div>
            @empty
                <div class="text-gray-400 text-sm px-2">
                    No special offers available.
                </div>
            @endforelse

        </div>
    </div>

    {{-- <div class="mt-8 px-4">
        <div class="flex justify-between items-center px-2 mb-4">
            <h3 class="text-lg font-bold tracking-tight">Special Offers</h3>
        </div>

        <div class="flex overflow-x-auto gap-4 scrollbar-hide snap-x px-2 pb-4">

            @forelse($banners as $banner)
                <div class="snap-center min-w-[300px] h-40 rounded-2xl overflow-hidden shadow-md border border-gray-100 dark:border-white/5">
                    
                    <img 
                        src="{{ asset($banner->image) }}" 
                        alt="Banner"
                        class="w-full h-full object-cover"
                    >
                    
                </div>
            @empty
                <div class="text-gray-400 text-sm px-2">
                    No special offers available.
                </div>
            @endforelse

        </div>
    </div> --}}

    <div id="fundModal" class="fixed inset-0 z-50 hidden w-full max-w-[400px] mx-auto">
        <!-- Overlay -->
        <div id="sheetOverlay" class="absolute inset-0 opacity-0 transition-opacity duration-300"></div>
        <!-- Bottom Sheet -->
        <div id="bottomSheet"
            class="absolute bottom-0 left-0 right-0 bg-white dark:bg-[#151515] rounded-t-3xl shadow-xl transition-transform duration-300"
            style="height: 500px; transform: translateY(calc(100% - 500px)); overflow: hidden;">
            <!-- Drag Handle -->
            <div id="dragHandle" class="w-full flex justify-center py-3 cursor-grab">
                <div class="w-14 h-1.5 bg-gray-300 rounded-full"></div>
            </div>
            <!-- Content -->
            <div class="px-5 pb-10 space-y-4">
                <a href="{{ route('topup') }}" class="block p-4 rounded-xl border hover:bg-gray-50">
                    <h2 class="font-bold text-primary">মোবাইল পে ফান্ড অ্যাড</h2>
                    <p class="text-sm text-gray-500">বিকাশ , নগদ , রকেট, উপায় অ্যাড ফান্ড</p>
                </a>
                <a href="/cash_pickup" class="block p-4 rounded-xl border hover:bg-gray-50">
                    <h2 class="font-bold text-primary">ক্যাশ পিক আপ</h2>
                    <p class="text-sm text-gray-500">সরাসরি অ্যাড ফান্ড করুন</p>
                </a> <a href="{{ route('bank.topup') }}" class="block p-4 rounded-xl border hover:bg-gray-50">
                    <h2 class="font-bold text-primary">ব্যাংক ফান্ড অ্যাড</h2>
                    <p class="text-sm text-gray-500">লোকাল ব্যাংকের মাধ্যমে এডফান্ড করুন</p>
                </a>
            </div>
        </div>
    </div>

    <div class="mt-4 px-4 pb-12">
        <div class="flex justify-between items-center px-2 mb-4">
            <h3 class="text-lg font-bold tracking-tight">Recent Transactions</h3>
            <a href="{{ route('history') }}" class="text-primary font-bold text-sm">See All</a>
        </div>

        <div class="space-y-3">
            @forelse($transactions as $trx)
                <div
                    class="flex items-center justify-between p-4 bg-white dark:bg-[#151515] rounded-2xl ios-shadow border border-gray-100 dark:border-white/5">

                    <div class="flex items-center gap-4">
                        <div class="size-11 rounded-full bg-gray-50 dark:bg-[#1E1E1E] flex items-center justify-center">
                            @if ($trx['direction'] == 'in')
                                <span class="material-symbols-outlined text-green-600 text-xl">
                                    south_west
                                </span>
                            @else
                                <span class="material-symbols-outlined text-red-600 text-xl">
                                    north_east
                                </span>
                            @endif
                        </div>

                        <div>
                            <p class="font-bold text-sm tracking-tight">
                                {{ $trx['title'] }}
                            </p>
                            <p class="text-[10px] text-gray-500 font-medium">
                                {{ \Carbon\Carbon::parse($trx['created_at'])->format('d M Y, h:i A') }}
                            </p>
                        </div>
                    </div>

                    <div class="text-right">
                        <p
                            class="font-bold text-sm 
                    {{ $trx['direction'] == 'in' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $trx['direction'] == 'in' ? '+' : '-' }}
                            {{ number_format($trx['amount'], 2) }}
                        </p>

                        @if ($trx['status'] == 0)
                            <span
                                class="inline-block mt-1 px-2 py-0.5 text-[9px] font-bold rounded-full bg-yellow-100 text-yellow-700">
                                Pending
                            </span>
                        @elseif($trx['status'] == 1)
                            <span
                                class="inline-block mt-1 px-2 py-0.5 text-[9px] font-bold rounded-full bg-green-100 text-green-700">
                                Success
                            </span>
                        @elseif($trx['status'] == 2)
                            <span
                                class="inline-block mt-1 px-2 py-0.5 text-[9px] font-bold rounded-full bg-red-100 text-red-700">
                                Rejected
                            </span>
                        @endif
                    </div>

                </div>
            @empty
                <div class="text-center text-gray-400 py-6">
                    No recent transactions found.
                </div>
            @endforelse
        </div>
    </div>


@endsection


@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById('fundModal');
            const sheet = document.getElementById('bottomSheet');
            const overlay = document.getElementById('sheetOverlay');
            const openBtn = document.getElementById('openFundModal');
            const dragHandle = document.getElementById('dragHandle');

            if (!openBtn) return;

            const minHeight = 500;
            const maxHeight = window.innerHeight * 0.9;

            let startY = 0;
            let currentY = 0;
            let isDragging = false;

            function openSheet() {
                modal.classList.remove('hidden');
                overlay.classList.remove('opacity-0');
                sheet.style.height = minHeight + 'px';
                sheet.style.transform = `translateY(${window.innerHeight - minHeight}px)`;
            }

            function closeSheet() {
                sheet.style.transform = `translateY(${window.innerHeight}px)`;
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    sheet.style.height = minHeight + 'px';
                    sheet.style.transform = `translateY(${window.innerHeight - minHeight}px)`;
                }, 300);
            }

            function startDrag(y) {
                startY = y;
                isDragging = true;
            }

            function drag(y) {
                if (!isDragging) return;
                currentY = y;

                let diff = startY - currentY;
                let newHeight = minHeight + diff;

                if (newHeight < minHeight) newHeight = minHeight;
                if (newHeight > maxHeight) newHeight = maxHeight;

                sheet.style.height = newHeight + 'px';
                sheet.style.transform = `translateY(${window.innerHeight - newHeight}px)`;
            }

            function endDrag() {
                if (!isDragging) return;
                isDragging = false;

                let dragDistance = currentY - startY;

                if (dragDistance > 50) {
                    closeSheet();
                } else if (-dragDistance > 50) {
                    sheet.style.height = maxHeight + 'px';
                    sheet.style.transform = `translateY(${window.innerHeight - maxHeight}px)`;
                } else {
                    sheet.style.height = minHeight + 'px';
                    sheet.style.transform = `translateY(${window.innerHeight - minHeight}px)`;
                }
            }

            dragHandle.addEventListener('touchstart', e => startDrag(e.touches[0].clientY));
            dragHandle.addEventListener('touchmove', e => drag(e.touches[0].clientY));
            dragHandle.addEventListener('touchend', endDrag);

            dragHandle.addEventListener('mousedown', e => startDrag(e.clientY));
            document.addEventListener('mousemove', e => drag(e.clientY));
            document.addEventListener('mouseup', endDrag);

            openBtn.addEventListener('click', openSheet);
            overlay.addEventListener('click', closeSheet);
        });
    </script>
@endsection
