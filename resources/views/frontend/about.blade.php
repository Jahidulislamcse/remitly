@extends('frontend.layout.master')
@section('meta')
    <link rel="canonical" href="{{ route('user.index') }}" />
@endsection

@section('style')
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Manrope', sans-serif;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
@endsection


@section('content')
    <div class="w-full sm:max-w-[420px] sm:mx-auto">
    <div
        class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md px-4 py-4 flex items-center justify-between border-b border-gray-200 dark:border-gray-800">
       <a href="{{ route('user.index') }}">
            <div class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 cursor-pointer">
                <span class="material-symbols-outlined text-black dark:text-white">
                    arrow_back_ios_new
                </span>
            </div>
        </a>
        <h2 class="text-black dark:text-white text-lg font-bold leading-tight tracking-tight">About &amp; Legal</h2>
        <div class="w-10"></div> 
    </div>
    <main class="pb-32">
       <section class="mt-4">
        <h3 class="text-black dark:text-white text-lg font-bold px-4 py-2">
            Certificates
        </h3>

        <div class="flex overflow-x-auto gap-4 px-4 py-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">

            <div class="flex-shrink-0 w-40 flex flex-col gap-3">
                <div class="aspect-[3/4] w-full rounded-md glass-effect overflow-hidden">
                    <img src="/images/a1.jpg"
                        class="w-full h-full object-cover rounded-md cursor-pointer"
                        onclick="openModal(this.src)">
                </div>
                <p class="text-black dark:text-gray-300 text-sm font-medium">
                    Trade License
                </p>
            </div>

            <div class="flex-shrink-0 w-40 flex flex-col gap-3">
                <div class="aspect-[3/4] w-full rounded-md glass-effect overflow-hidden">
                    <img src="/images/ab.jpg"
                        class="w-full h-full object-cover rounded-md cursor-pointer"
                        onclick="openModal(this.src)">
                </div>
                <p class="text-black dark:text-gray-300 text-sm font-medium">
                    Registration Certificate
                </p>
            </div>

        </div>

        <!-- Image Preview Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
        <span id="closeModal" class="absolute top-5 right-6 text-white text-3xl cursor-pointer">&times;</span>
        <img id="modalImage" class="max-h-[70%] max-w-[80%] rounded-lg shadow-lg">
    </div>

    </section>

        <!-- Information Section (Accordions) -->
        <section class="mt-6 px-4">
            <h3 class="text-black dark:text-white text-lg font-bold mb-4">Information</h3>
            <div class="flex flex-col gap-3">
                <!-- Accordion 1 -->
                <details class="group bg-white dark:bg-[#1A1A1A] rounded-xl border border-gray-100 dark:border-gray-800 transition-all overflow-hidden" open>
                    <summary class="flex items-center justify-between p-4 cursor-pointer list-none">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">corporate_fare</span>
                            <p class="text-black dark:text-white font-medium">আমাদের সম্পর্কে</p>
                        </div>
                        <span class="material-symbols-outlined text-primary transition-transform group-open:rotate-180">
                            expand_more
                        </span>
                    </summary>

                    <div class="px-4 pb-4">
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed text-justify">
                            প্রবাসী পে সার্ভিস লি. একটি মোবাইল ভিত্তিক ইন্টারন্যাশনাল মানি ট্রান্সফার এন্ড রিচার্জ অ্যাপ।
                            আমরা ২০১৮ সাল থেকে বিশ্বস্ততার সাথে সৌদি আরব, কাতার, ওমান, দুবাই, মালয়েশিয়া,
                            সিঙ্গাপুর, মালদ্বীপ, ব্রুনাই সহ প্রায় ৩৮টি দেশে রেমিট্যান্স সেবা দিয়ে আসছি।
                            বর্তমানে বিশ্বব্যাপী ৩২,৮৫০+ গ্রাহক আমাদের সাথে যুক্ত আছেন।
                        </p>
                    </div>
                </details>

                <!-- Accordion 2 -->
                <details class="group bg-white dark:bg-[#1A1A1A] rounded-xl border border-gray-100 dark:border-gray-800 transition-all overflow-hidden">
                    <summary class="flex items-center justify-between p-4 cursor-pointer list-none">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">account_balance_wallet</span>
                            <p class="text-black dark:text-white font-medium">আমাদের সার্ভিসসমূহ</p>
                        </div>
                        <span class="material-symbols-outlined text-primary transition-transform group-open:rotate-180">
                            expand_more
                        </span>
                    </summary>

                    <div class="px-4 pb-4">
                        <ul class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed space-y-2">
                            <li>১. সর্বোচ্চ রেটে মোবাইল ব্যাংকিং (বিকাশ, নগদ, রকেট, এমক্যাশ ইত্যাদি)</li>
                            <li>২. যেকোন ব্যাংকে টাকা পাঠানো</li>
                            <li>৩. যেকোন সিমে ফ্লেক্সিলোড</li>
                            <li>৪. এমবি ও মিনিট প্যাক একটিভেশন</li>
                            <li>৫. বিল পেমেন্ট</li>
                            <li>৬. ২৪/৭ কাস্টমার হেল্পলাইন</li>
                            <li>৭. অটো ব্যালেন্স সুবিধা</li>
                        </ul>
                    </div>
                </details>

                <!-- Accordion 3 -->
                <details class="group bg-white dark:bg-[#1A1A1A] rounded-xl border border-gray-100 dark:border-gray-800 transition-all overflow-hidden">
                    <summary class="flex items-center justify-between p-4 cursor-pointer list-none">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">verified_user</span>
                            <p class="text-black dark:text-white font-medium">কেন আমাদের বিশ্বাস করবেন?</p>
                        </div>
                        <span class="material-symbols-outlined text-primary transition-transform group-open:rotate-180">
                            expand_more
                        </span>
                    </summary>

                    <div class="px-4 pb-4">
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed text-justify">
                            আমরা স্বচ্ছতা বজায় রেখে লাইভ গ্রুপ চ্যাট সুবিধা দিয়ে থাকি যেখানে গ্রাহকরা
                            সরাসরি যোগাযোগ করতে পারেন। আমাদের সকল লেনদেন অটো সার্ভার ভিত্তিক,
                            নিরাপদ ও ঝামেলাহীন। ট্রেড লাইসেন্স ও রেজিস্ট্রেশন যাচাইযোগ্য।
                        </p>
                    </div>
                </details>

            </div>
        </section>
        <!-- Location Section -->
        <section class="mt-8 px-4">
            <h3 class="text-black dark:text-white text-lg font-bold mb-4">Our Head Office</h3>
            <div class="relative w-full h-48 rounded-2xl overflow-hidden mb-4 border border-gray-100 dark:border-gray-800">

                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3619.313992521693!2d91.8807!3d24.8864!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x375054d3d270329f%3A0xf58ef93431f6738b!2sMirabazar%2C%20Sylhet!5e0!3m2!1sen!2sbd!4v1700000000000!5m2!1sen!2sbd"
                    class="w-full h-full border-0"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>

            </div>

            <div class="flex flex-col">
                {{-- <p class="text-black dark:text-white font-bold">120 Holborn</p> --}}
                <p class="text-gray-500 text-sm">মিরাবাজার রোড, সিলেট সদর, সিলেট - ৩১০০, বাংলাদেশ।</p>
            </div>
        </section>
    </main>
    </div>
    <!-- Sticky Footer -->
    <div class="fixed bottom-12 left-1/2 -translate-x-1/2 
        w-[92%] sm:max-w-[420px] 
        p-6 bg-gradient-to-t from-background-dark via-background-dark/95 to-transparent z-50">
        <button
            class="w-full bg-primary text-white font-bold py-4 rounded-full flex items-center justify-center gap-3 shadow-[0_10px_30px_rgba(242,13,13,0.3)] active:scale-95 transition-transform">
            <div class="bg-white/20 p-1 rounded-full flex items-center justify-center">
                <svg fill="currentColor" height="20" viewbox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.31.045-.697.073-1.126-.067-.27-.088-.611-.214-1.045-.403-1.841-.798-3.033-2.671-3.125-2.793-.092-.122-.751-.998-.751-1.908 0-.91.473-1.357.643-1.54.168-.184.372-.229.497-.229.125 0 .25.002.358.006.113.004.263-.042.412.316.155.372.531 1.293.578 1.385.046.092.077.2.015.323s-.092.214-.184.323c-.092.107-.193.242-.275.326-.092.094-.189.196-.081.381.108.184.481.794 1.034 1.285.713.633 1.313.83 1.5.921.186.092.296.077.405-.047.11-.125.473-.55.598-.737.126-.187.251-.157.423-.092.172.064 1.092.515 1.279.608.187.092.311.137.356.214.045.077.045.445-.099.85z">
                    </path>
                </svg>
            </div>
            Contact Support
        </button>
        <!-- iOS Home Indicator Space -->
        <div class="h-4"></div>
    </div>
@endsection

@section('script')
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#f20d0d",
                        "background-light": "#f8f5f5",
                        "background-dark": "#0F0F0F",
                    },
                    fontFamily: {
                        "display": ["Manrope"]
                    },
                    borderRadius: { "DEFAULT": "1rem", "lg": "2rem", "xl": "3rem", "full": "9999px" },
                },
            },
        }
    </script>
    <script>
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const closeBtn = document.getElementById('closeModal');

        function openModal(src) {
            modalImg.src = src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        closeBtn.onclick = function () {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        modal.onclick = function (e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        };
    </script>

@endsection