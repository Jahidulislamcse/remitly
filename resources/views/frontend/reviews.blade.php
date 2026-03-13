@extends('frontend.layout.master')
@section('meta')
    <link rel="canonical" href="{{ route('user.index') }}" />
@endsection

@section('style')
     <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
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
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out;
        }
    </style>
@endsection

@section('content')
<div class="max-w-md mx-auto pb-24">
    <div class="flex items-center bg-background-light dark:bg-background-dark p-4 pb-2 justify-between z-10">
            <a href="{{ route('user.index') }}">
                <div class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 cursor-pointer">
                    <span class="material-symbols-outlined text-black dark:text-white">
                        arrow_back_ios_new
                    </span>
                </div>
            </a>
            <h2 class="text-white text-lg font-bold leading-tight tracking-tight flex-1 text-center">Reviews</h2>
           
        </div>
    @if($reviews->count())
        <div class="flex justify-center gap-3 p-4 sticky top-0 bg-background-light dark:bg-background-dark z-10 ">
            <a href="{{ route('reviews.view') }}"
            class="px-4 py-1 rounded-full text-sm font-bold 
            {{ request('filter') !== 'my' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }}">
                All Reviews
            </a>

            @auth
                <a href="{{ route('reviews.view', ['filter' => 'my']) }}"
                class="px-4 py-1 rounded-full text-sm font-bold 
                {{ request('filter') === 'my' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }}">
                    My Reviews
                </a>
            @endauth
        </div>

        @foreach($reviews as $review)
            <div class="p-4 @container">
                <div
                    class="flex flex-col items-stretch justify-start rounded-xl shadow-lg shadow-black/5 bg-background-light dark:bg-background-dark border border-gray-50 dark:border-white/5 overflow-hidden">
                    
                    <!-- Video Thumbnail -->
                    <div class="relative group cursor-pointer video-wrapper">
                        <div class="w-full aspect-video overflow-hidden rounded-xl">
                            @if($review->video_path && file_exists(public_path($review->video_path)))
                                @php
                                    $ext = pathinfo($review->video_path, PATHINFO_EXTENSION);
                                    $mime = 'video/mp4';
                                    if ($ext === 'webm') $mime = 'video/webm';
                                    elseif ($ext === 'mov') $mime = 'video/quicktime';
                                    elseif ($ext === 'avi') $mime = 'video/x-msvideo';
                                @endphp

                                <video class="review-video w-full h-full object-cover">
                                    <source src="{{ asset($review->video_path) }}" type="{{ $mime }}">
                                </video>
                            @endif

                            <!-- Overlay -->
                            <div class="video-overlay absolute inset-0 flex items-center justify-center transition-all duration-300">
                                <div class="icon-wrapper size-14 bg-primary rounded-full flex items-center justify-center shadow-xl shadow-primary/40 transition-all duration-300">
                                    <span class="material-symbols-outlined text-white text-3xl video-icon">
                                        play_arrow
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Review Details -->
                    <div class="flex w-full flex-col gap-2 p-5">
                        <div class="flex justify-between items-start">
                            <p class="text-[#1b0e0e] dark:text-white text-xl font-extrabold leading-tight tracking-tight">
                                {{ $review->title }}
                            </p>
                            @if($review->status == 0 && auth()->check() && auth()->user()->is_admin)
                                <!-- Approve button only for admins -->
                                <form action="{{ route('reviews.approve', $review) }}" method="POST">
                                    @csrf
                                    <button class="text-xs font-bold text-white bg-primary px-2 py-1 rounded">
                                        Approve
                                    </button>
                                </form>
                            @endif
                        </div>
                        @if($review->description)
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-relaxed">
                                {{ $review->description }}
                            </p>
                        @endif

                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center gap-2 text-gray-400">
                                <span class="material-symbols-outlined text-sm">account_circle</span>
                                <span class="text-xs font-bold">
                                    {{ $review->user->name ?? 'Anonymous' }}
                                </span>
                            </div>
                            {{-- <button
                                class="flex items-center justify-center rounded-full h-8 px-5 border-2 border-primary text-primary text-xs font-extrabold transition-colors hover:bg-primary hover:text-white">
                                WATCH NOW
                            </button> --}}
                            @if(auth()->id() === $review->user_id)
                            <button
                                onclick="editReview(
                                    '{{ $review->id }}',
                                    `{{ addslashes($review->title) }}`,
                                    `{{ addslashes($review->description) }}`,
                                    '{{ asset($review->video_path) }}'
                                )"
                                class="flex items-center justify-center rounded-full h-8 px-5 border-2 border-primary text-primary text-xs font-extrabold transition-colors hover:bg-primary hover:text-white">
                                Edit
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        {{-- <div class="p-4">
            {{ $reviews->links('vendor.pagination.tailwind') }}
        </div> --}}
    @else
        <p class="text-center text-gray-500 py-10">No reviews found.</p>
    @endif

   
</div>
@auth
    <button onclick="openReviewModal()"
        class="fixed bottom-28 
            right-40% translate-x-1/2
            max-w-md
            w-14 h-14
            rounded-full
            bg-primary text-white
            shadow-lg shadow-primary/40
            flex items-center justify-center
            transition transform hover:scale-110 active:scale-95">

        <span class="material-symbols-outlined text-3xl">
            add
        </span>
    </button>
@endauth
<!-- Review Modal -->
<div id="reviewModal"
     class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">

    <div class="w-full max-w-sm rounded-xl shadow-lg shadow-black/20
                bg-background-light dark:bg-background-dark
                border border-gray-100 dark:border-white/10
                overflow-hidden animate-fadeIn">

        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-white/10">
            <h2 id="modalTitle"
                class="text-lg font-extrabold text-[#1b0e0e] dark:text-white">
                Upload Review
            </h2>

            <button onclick="closeReviewModal()"
                class="text-gray-400 hover:text-primary transition">
                ✕
            </button>
        </div>

        <form id="reviewForm"
              method="POST"
              enctype="multipart/form-data"
              class="p-5 space-y-4">

            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div>
                <label class="text-xs font-bold text-gray-500">TITLE</label>
                <input type="text"
                       name="title"
                       id="reviewTitle"
                       class="w-full mt-1 px-4 py-2 rounded-lg
                              bg-gray-50 dark:bg-white/5
                              border border-gray-200 dark:border-white/10
                              focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="text-xs font-bold text-gray-500">DESCRIPTION</label>
                <textarea name="description"
                          id="reviewDescription"
                          rows="3"
                          class="w-full mt-1 px-4 py-2 rounded-lg
                                 bg-gray-50 dark:bg-white/5
                                 border border-gray-200 dark:border-white/10
                                 focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
            </div>

            <div>
                <label class="text-xs font-bold text-gray-500">VIDEO</label>

                <div id="videoPreviewContainer"
                    class="mt-2 hidden rounded-xl overflow-hidden border border-gray-200 dark:border-white/10">
                    <video id="videoPreview"
                        class="w-full aspect-video object-cover"
                        controls></video>
                </div>

                <input type="file"
                    name="video_path"
                    id="videoInput"
                    accept="video/*"
                    class="w-full mt-3 text-sm
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-bold
                            file:bg-primary file:text-white
                            hover:file:opacity-90">
            </div>

            <button
                class="w-full h-10 rounded-full
                       bg-primary text-white
                       text-sm font-extrabold
                       transition hover:opacity-90">
                Save Review
            </button>
        </form>
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
        document.addEventListener("DOMContentLoaded", function () {
            const wrappers = document.querySelectorAll(".video-wrapper");

            wrappers.forEach(wrapper => {
                const video = wrapper.querySelector(".review-video");
                const overlay = wrapper.querySelector(".video-overlay");
                const icon = wrapper.querySelector(".video-icon");
                const iconWrapper = wrapper.querySelector(".icon-wrapper");

                overlay.addEventListener("click", function () {
                    if (video.paused) {
                        video.play();
                        icon.textContent = "pause";

                        // Remove background when playing
                        iconWrapper.classList.remove("bg-primary", "shadow-xl", "shadow-primary/40");
                        iconWrapper.classList.add("bg-transparent");
                        icon.classList.add("opacity-50");
                    } else {
                        video.pause();
                        icon.textContent = "play_arrow";

                        // Restore background when paused
                        iconWrapper.classList.remove("bg-transparent");
                        iconWrapper.classList.add("bg-primary", "shadow-xl", "shadow-primary/40");
                        icon.classList.remove("opacity-50");
                    }
                });

                video.addEventListener("ended", function () {
                    icon.textContent = "play_arrow";
                    iconWrapper.classList.remove("bg-transparent");
                    iconWrapper.classList.add("bg-primary", "shadow-xl", "shadow-primary/40");
                    icon.classList.remove("opacity-50");
                });
            });
        });
    </script>

    <script>
        const modal = document.getElementById('reviewModal');
        const form = document.getElementById('reviewForm');
        const videoInput = document.getElementById('videoInput');
        const videoPreview = document.getElementById('videoPreview');
        const previewContainer = document.getElementById('videoPreviewContainer');

        function openReviewModal() {
            document.getElementById('modalTitle').innerText = "Upload Review";
            document.getElementById('reviewTitle').value = "";
            document.getElementById('reviewDescription').value = "";

            document.getElementById('formMethod').value = "POST";
            form.action = "{{ route('user.reviews.store') }}";

            previewContainer.classList.add('hidden');
            videoPreview.src = "";

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function editReview(id, title, description, videoUrl) {
            document.getElementById('modalTitle').innerText = "Update Review";
            document.getElementById('reviewTitle').value = title;
            document.getElementById('reviewDescription').value = description;

            document.getElementById('formMethod').value = "PUT";
            form.action = "/user/reviews/" + id;

            // Show existing video
            if (videoUrl) {
                videoPreview.src = videoUrl;
                previewContainer.classList.remove('hidden');
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeReviewModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Show preview when selecting new file
        videoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const url = URL.createObjectURL(file);
                videoPreview.src = url;
                previewContainer.classList.remove('hidden');
            }
        });
    </script>
@endsection