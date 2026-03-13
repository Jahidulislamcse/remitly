@extends('frontend.layout.master')
@section('meta')
    <link rel="canonical" href="{{ route('user.index') }}" />
@endsection
@section('style')
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* Custom scrollbar for better look in dark mode */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: #121212;
        }

        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <div
        class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden max-w-md mx-auto shadow-2xl">
        <!-- TopAppBar -->
        <header
            class="sticky top-0 z-50 flex items-center bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md p-4 pb-2 justify-between">
            <a href="{{ route('user.index') }}">
                <div class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 cursor-pointer">
                    <span class="material-symbols-outlined text-black dark:text-white">
                        arrow_back_ios_new
                    </span>
                </div>
            </a>
            <h2
                class="text-slate-900 dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center">
                Settings</h2>
            <div class="flex w-12 items-center justify-end">
                <button
                    class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 bg-transparent text-primary gap-2 text-base font-bold leading-normal tracking-[0.015em] min-w-0 p-0">
                    <span class="material-symbols-outlined text-[24px]">notifications</span>
                </button>
            </div>
        </header>
        <main class="flex-1 pb-10">
            <!-- ProfileHeader -->
            <section class="flex p-6">
                <div class="flex w-full flex-col gap-4 items-center">
                    <div class="flex gap-4 flex-col items-center">
                        <div class="relative">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full min-h-32 w-32 border-4 border-primary/20 p-1"
                                data-alt="User profile photo of a person smiling"
                                style='background-image: url("{{ $data->image ? asset($data->image) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png' }}");'>
                            </div>
                            <form action="{{ route('profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="image" id="imageUpload" class="hidden"
                                    onchange="this.form.submit()">

                                <div onclick="document.getElementById('imageUpload').click()"
                                    class="absolute bottom-1 right-1 bg-primary text-white rounded-full p-2 shadow-lg border-2 border-background-dark cursor-pointer">
                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                </div>
                            </form>
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <p
                                class="text-slate-900 dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] text-center">
                                {{ $data->name }}</p>
                            <p class="text-slate-500 dark:text-[#b99d9e] text-base font-normal leading-normal text-center">
                                {{ $data->phone }}</p>
                            <div class="mt-2 inline-flex items-center gap-1 bg-primary/10 px-3 py-1 rounded-full">
                                <span class="material-symbols-outlined text-primary text-[14px] font-bold">verified</span>
                                <span class="text-primary text-xs font-bold uppercase tracking-wider">Premium
                                    Member</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Account Section -->
            <section class="px-4">
                <h3 class="text-slate-500 dark:text-[#b99d9e] text-sm font-bold uppercase tracking-wider px-2 pb-3 pt-4">
                    Account Management</h3>
                <div
                    class="bg-white dark:bg-surface-dark rounded-xl overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                    <div onclick="toggleEditProfile()"
                        class="flex items-center gap-4 px-4 min-h-[64px] hover:bg-slate-50 dark:hover:bg-white/5 cursor-pointer transition-colors">
                        <div
                            class="text-primary flex items-center justify-center rounded-lg bg-primary/10 shrink-0 size-10">
                            <span class="material-symbols-outlined">person</span>
                        </div>
                        <div class="flex flex-col justify-center flex-1">
                            <p class="text-slate-900 dark:text-white text-base font-medium leading-normal">
                                Edit Profile
                            </p>
                        </div>
                        <div class="shrink-0 text-slate-400">
                            <span id="editProfileIcon" class="material-symbols-outlined text-[20px]">
                                expand_more
                            </span>
                        </div>
                    </div>

                    <div id="editProfileSection" class="hidden px-4 pb-6 bg-white dark:bg-surface-dark">
                        <form action="{{ route('profile') }}" method="POST" enctype="multipart/form-data"
                            class="flex flex-col gap-6 mt-4">
                            @csrf

                            <div class="relative">
                                <input name="name" value="{{ $data->name }}"
                                    class="h-14 w-full bg-transparent border border-slate-300 dark:border-slate-700 rounded-lg px-4 pt-2 focus:border-primary focus:ring-1 focus:ring-primary outline-none"
                                    type="text" required />
                                <label
                                    class="absolute left-4 top-1 text-[10px] text-primary uppercase font-bold tracking-wider">
                                    Full Name
                                </label>
                            </div>

                            <div class="relative">
                                <input name="email" value="{{ $data->email }}"
                                    class="h-14 w-full bg-transparent border border-slate-300 dark:border-slate-700 rounded-lg px-4 pt-2 focus:border-primary focus:ring-1 focus:ring-primary outline-none"
                                    type="email" />
                                <label
                                    class="absolute left-4 top-1 text-[10px] text-primary uppercase font-bold tracking-wider">
                                    Email
                                </label>
                            </div>

                            <div class="relative">
                                <input name="phone" value="{{ $data->phone }}"
                                    class="h-14 w-full bg-transparent border border-slate-300 dark:border-slate-700 rounded-lg px-4 pt-2 focus:border-primary focus:ring-1 focus:ring-primary outline-none"
                                    type="text" required />
                                <label
                                    class="absolute left-4 top-1 text-[10px] text-primary uppercase font-bold tracking-wider">
                                    Phone
                                </label>
                            </div>

                            <button type="submit"
                                class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-3 rounded-xl shadow-lg transition-all active:scale-95">
                                Save Changes
                            </button>
                        </form>
                    </div>
                    <!-- ListItem: KYC Verification -->
                    {{-- <div
                        class="flex items-center gap-4 px-4 min-h-[64px] hover:bg-slate-50 dark:hover:bg-white/5 cursor-pointer transition-colors">
                        <div
                            class="text-primary flex items-center justify-center rounded-lg bg-primary/10 shrink-0 size-10">
                            <span class="material-symbols-outlined">shield_person</span>
                        </div>
                        <div class="flex flex-col justify-center flex-1">
                            <p class="text-slate-900 dark:text-white text-base font-medium leading-normal">KYC
                                Verification</p>
                            <p class="text-slate-500 dark:text-[#b99d9e] text-xs font-normal">Level 2 - Verified</p>
                        </div>
                        <div class="shrink-0">
                            <div class="flex size-7 items-center justify-center">
                                <div class="size-2 rounded-full bg-[#0bda95] ring-4 ring-[#0bda95]/20 animate-pulse">
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div onclick="openPasswordModal()"
                        class="flex items-center gap-4 px-4 min-h-[64px] hover:bg-slate-50 dark:hover:bg-white/5 cursor-pointer transition-colors">
                        <div
                            class="text-primary flex items-center justify-center rounded-lg bg-primary/10 shrink-0 size-10">
                            <span class="material-symbols-outlined">lock</span>
                        </div>
                        <div class="flex flex-col justify-center flex-1">
                            <p class="text-slate-900 dark:text-white text-base font-medium leading-normal">
                                Security & Password
                            </p>
                        </div>
                        <div class="shrink-0 text-slate-400">
                            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Preferences Section -->
            <section class="px-4 mt-6">
                <h3 class="text-slate-500 dark:text-[#b99d9e] text-sm font-bold uppercase tracking-wider px-2 pb-3 pt-4">
                    Preferences</h3>
                <div
                    class="bg-white dark:bg-surface-dark rounded-xl overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                    <!-- ListItem: Language -->
                    <div
                        class="flex items-center gap-4 px-4 min-h-[64px] hover:bg-slate-50 dark:hover:bg-white/5 cursor-pointer transition-colors">
                        <div
                            class="text-primary flex items-center justify-center rounded-lg bg-primary/10 shrink-0 size-10">
                            <span class="material-symbols-outlined">translate</span>
                        </div>
                        <div class="flex flex-col justify-center flex-1">
                            <p class="text-slate-900 dark:text-white text-base font-medium leading-normal">Language</p>
                        </div>
                        <div class="shrink-0 flex items-center gap-2">
                            <span class="text-slate-400 text-sm">English</span>
                            <span class="material-symbols-outlined text-slate-400 text-[20px]">chevron_right</span>
                        </div>
                    </div>
                    <!-- ListItem: Currency -->
                    @php
                        $country = auth()->user()->country;
                    @endphp

                    <div
                        class="flex items-center gap-4 px-4 min-h-[64px] hover:bg-slate-50 dark:hover:bg-white/5 cursor-pointer transition-colors">

                        <div
                            class="text-primary flex items-center justify-center rounded-lg bg-primary/10 shrink-0 size-10">
                            <span class="material-symbols-outlined">payments</span>
                        </div>

                        <div class="flex flex-col justify-center flex-1">
                            <p class="text-slate-900 dark:text-white text-base font-medium leading-normal">
                                Local Currency
                            </p>
                        </div>

                        <div class="shrink-0 flex items-center gap-2">
                            @if($country && $country->currency)
                                <span class="text-slate-400 text-sm">
                                    {{ $country->currency }} ({{ $country->currency_code }})
                                </span>
                            @else
                                <span class="text-slate-400 text-sm">
                                    Not Set
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
            </section>
            <!-- Support Section -->
            <section class="px-4 mt-6">
                <h3 class="text-slate-500 dark:text-[#b99d9e] text-sm font-bold uppercase tracking-wider px-2 pb-3 pt-4">
                    Support</h3>
                <div
                    class="bg-white dark:bg-surface-dark rounded-xl overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                    <!-- ListItem: Help Center -->
                    <a href="{{ route('support') }}"
                        class="flex items-center gap-4 px-4 min-h-[64px] hover:bg-slate-50 dark:hover:bg-white/5 cursor-pointer transition-colors">

                            <div class="text-primary flex items-center justify-center rounded-lg bg-primary/10 shrink-0 size-10">
                                <span class="material-symbols-outlined">help</span>
                            </div>

                            <div class="flex flex-col justify-center flex-1">
                                <p class="text-slate-900 dark:text-white text-base font-medium leading-normal">
                                    Help Center
                                </p>
                            </div>

                            <div class="shrink-0 text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">open_in_new</span>
                            </div>

                        </a>
                    <!-- ListItem: Legal -->
                    {{-- <div
                        class="flex items-center gap-4 px-4 min-h-[64px] hover:bg-slate-50 dark:hover:bg-white/5 cursor-pointer transition-colors">
                        <div
                            class="text-primary flex items-center justify-center rounded-lg bg-primary/10 shrink-0 size-10">
                            <span class="material-symbols-outlined">description</span>
                        </div>
                        <div class="flex flex-col justify-center flex-1">
                            <p class="text-slate-900 dark:text-white text-base font-medium leading-normal">Terms of
                                Service</p>
                        </div>
                        <div class="shrink-0 text-slate-400">
                            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                        </div>
                    </div> --}}
                </div>
            </section>
            <section class="px-6 mt-10">

            </section>
            <section class="px-6 mt-12 mb-8">
                <form action="{{ route('user.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/20 transition-all active:scale-95 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">logout</span>
                        Logout
                    </button>
                </form>
            </section>
        </main>
        <div class="h-1.5 w-32 bg-slate-300 dark:bg-slate-800 rounded-full mx-auto mb-2 shrink-0"></div>
        <div id="passwordModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
            <div class="bg-white dark:bg-surface-dark w-[80%] max-w-md rounded-xl p-6 relative">

                <button onclick="closePasswordModal()" class="absolute right-4 top-4 text-slate-400">
                    ✕
                </button>

                <h3 class="text-lg font-bold mb-6">Change Password</h3>

                <form action="{{ route('change.password') }}" method="POST" class="flex flex-col gap-5">
                    @csrf

                    <input type="password" name="current_password" placeholder="Current Password"
                        class="h-12 border border-slate-300 dark:border-slate-700 rounded-lg px-4 bg-transparent" required>

                    <input type="password" name="new_password" placeholder="New Password"
                        class="h-12 border border-slate-300 dark:border-slate-700 rounded-lg px-4 bg-transparent" required>

                    <input type="password" name="new_password_confirmation" placeholder="Confirm New Password"
                        class="h-12 border border-slate-300 dark:border-slate-700 rounded-lg px-4 bg-transparent" required>

                    <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-bold">
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#ec131e",
                        "background-light": "#f8f6f6",
                        "background-dark": "#121212",
                        "surface-dark": "#1e1e1e",
                        "surface-light": "#ffffff",
                    },
                    fontFamily: {
                        "display": ["Manrope"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>

    <script>
        function toggleEditProfile() {
            const section = document.getElementById('editProfileSection');
            const icon = document.getElementById('editProfileIcon');

            section.classList.toggle('hidden');

            if (section.classList.contains('hidden')) {
                icon.innerText = 'expand_more';
            } else {
                icon.innerText = 'expand_less';
            }
        }

        function openPasswordModal() {
            document.getElementById('passwordModal').classList.remove('hidden');
            document.getElementById('passwordModal').classList.add('flex');
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').classList.add('hidden');
            document.getElementById('passwordModal').classList.remove('flex');
        }
    </script>
@endsection
