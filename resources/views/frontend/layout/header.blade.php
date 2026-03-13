<div class="glass-header pt-8 pb-20 px-6 rounded-b-[2.5rem]">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-3">
            @php
                if (preg_match('/^data:image\/(\w+);base64,/', auth()->user()->image)) {
                    $user_image = auth()->user()->image;
                } else {
                    $user_image = asset(auth()->user()->image);
                }

                $country = auth()->user()->country;
            @endphp

            <div class="size-10 rounded-full border-2 border-white/10 bg-cover bg-center"
                style='background-image: url("{{ $user_image }}");'>
            </div>

            <div class="flex flex-col">
                <h2 class="text-white text-lg font-bold tracking-tight">
                    {{ Auth::user()->name }}
                </h2>

               @if($country)
                <div class="flex items-center gap-2 mt-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm w-fit">
                    <img src="{{ $country->image }}" 
                        alt="{{ $country->name }}" 
                        class="w-4 h-4 rounded-full object-cover">

                    <span class="text-white text-xs font-medium">
                        {{ $country->name }}
                    </span>
                </div>
                @endif
            </div>
        </div>

        <button class="relative bg-white/5 p-2 rounded-full text-white border border-white/10">
            <span class="material-symbols-outlined">notifications</span>
            <span class="absolute top-2.5 right-2.5 size-2 bg-primary rounded-full border-2 border-[#1A1A1A]"></span>
        </button>
        <button id="themeToggle"
            class="bg-white/5 p-2 rounded-full text-white border border-white/10">
            <span id="themeIcon" class="material-symbols-outlined">dark_mode</span>
        </button>
    </div>

    <div class="mt-4">
        <div class="flex items-center gap-2">
            <p class="text-white/60 text-sm font-medium">Current Balance</p>
        </div>
        <div class="flex items-baseline gap-1 mt-1">
            <span class="text-white text-2xl font-extrabold tracking-tight">${{ number_format(Auth::user()->balance, 2) }}</span>
        </div>
    </div>

    @if($country)
        <div class="mt-2 inline-block bg-white/10 border border-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-[12px] w-fit">
            @if($rate)
                {{ enToBnNumber(1) }} {{ $country->currency }} = {{ enToBnNumber(number_format($rate, 2)) }} টাকা
            @else
                Rate not found
            @endif
        </div>
    @endif
</div>
