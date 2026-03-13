<div class="fixed bottom-0 left-1/2 -translate-x-1/2 
    w-[92%] sm:max-w-[420px] 
    bg-white/90 dark:bg-[#0A0A0A]/90 backdrop-blur-xl 
    border border-gray-100 dark:border-white/10 
    h-20 rounded-full shadow-2xl flex items-center justify-between px-6 z-50">

    <button class="flex flex-col items-center gap-1 text-primary">
        <span class="material-symbols-outlined text-2xl">home</span>
        <span class="text-[10px] font-bold">Home</span>
    </button>

    <button class="flex flex-col items-center gap-1 text-gray-400">
        <span class="material-symbols-outlined text-2xl">history</span>
        <span class="text-[10px] font-medium">History</span>
    </button>

    <div class="relative -top-7">
        <button class="size-16 bg-primary text-white rounded-full flex items-center justify-center shadow-xl shadow-primary/40 border-[6px] border-background-light dark:border-background-dark">
            <span class="material-symbols-outlined text-3xl">qr_code_scanner</span>
        </button>
    </div>

    <button class="flex flex-col items-center gap-1 text-gray-400">
        <span class="material-symbols-outlined text-2xl">person</span>
        <span class="text-[10px] font-medium">Profile</span>
    </button>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="flex flex-col items-center gap-1 text-gray-400">
            <span class="material-symbols-outlined text-2xl">logout</span>
            <span class="text-[10px] font-medium">Logout</span>
        </button>
    </form>
</div>
