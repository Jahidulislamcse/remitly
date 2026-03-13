@extends('frontend.layout.master')

@section('content')
<div class="max-w-md mx-auto px-4 pb-28">

    <header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md px-4 py-4 flex items-center justify-between">
        <a href="{{ route('user.index') }}">
            <div class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 cursor-pointer">
                <span class="material-symbols-outlined text-black dark:text-white">
                    arrow_back_ios_new
                </span>
            </div>
        </a>
        <h2 class="text-lg font-bold leading-tight tracking-tight">Cash Pick-up</h2>
        <button class="w-12 h-12 flex items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-white/10 transition-colors">
            <span class="material-symbols-outlined text-2xl">help</span>
        </button>
    </header>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 mt-6">
        
        <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-5 mb-6 relative overflow-hidden border border-red-100 dark:border-red-700 shadow-sm">
            @php $guide = \App\Models\Guide::first(); @endphp
            @if(!empty($guide->cash_pickup))
                {!! $guide->cash_pickup !!}
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center">
                    No instructions found for cash pick-up.
                </p>
            @endif
            <div class="absolute right-0 bottom-0 text-[80px] text-red-200 dark:text-red-700 opacity-10">
                <i class="fas fa-info-circle"></i>
            </div>
        </div>

        <div class="text-center">
            <h5 class="text-red-600 dark:text-red-400 font-bold mb-4">Contact Directly</h5>

            <a href="https://wa.me/+13194321520" target="_blank"
               class="inline-flex items-center gap-3 bg-green-600 dark:bg-green-700 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg border-4 border-white transition-all hover:bg-green-500 hover:scale-105">
                <i class="fab fa-whatsapp text-2xl"></i> WhatsApp Us
            </a>

            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">
                24/7 Customer Support
            </p>
        </div>

    </div>

</div>
@endsection

@section('script')
<script>
</script>
@endsection