<!DOCTYPE html>
<html class="dark" lang="en">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Face Verification</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#da0b0b',
                        'background-dark': '#101010',
                        'surface-dark': '#181818'
                    },
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        body {
            min-height: max(884px, 100dvh);
        }

        .scan-line {
            background: linear-gradient(to bottom, transparent, #da0b0b, transparent);
            animation: scan 2s linear infinite;
        }

        @keyframes scan {
            0% {
                transform: translateY(-100%);
                opacity: 0
            }

            50% {
                opacity: 1
            }

            100% {
                transform: translateY(100%);
                opacity: 0
            }
        }

        video,
        canvas {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

</head>

<body class="bg-background-dark font-display text-white antialiased">

    <div class="w-full max-w-md h-screen flex flex-col mx-auto relative overflow-hidden">

        <!-- Header -->

        <header class="flex items-center justify-between p-6">

            <a href="{{ route('register') }}"
                class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/10">

                <span class="material-symbols-outlined">arrow_back_ios_new</span>

            </a>

            <h1 class="text-lg font-bold">Identity Check</h1>

            <div class="w-10"></div>

        </header>

        <!-- Progress -->

        <div class="px-8 py-2 flex flex-col items-center gap-2">

            <div class="flex gap-1.5 w-full max-w-[200px]">

                <div class="h-1.5 flex-1 rounded-full bg-primary"></div>

                <div class="h-1.5 flex-1 rounded-full bg-primary"></div>

                <div class="h-1.5 flex-1 rounded-full bg-neutral-800"></div>

            </div>

            <span class="text-xs text-neutral-400 uppercase">Step 2 of 3</span>

        </div>

        <!-- Main Scanner -->

        <main class="flex-1 flex flex-col items-center justify-center px-6">

            <div class="relative w-full aspect-[3/4] max-h-[50vh]">

                <div class="absolute inset-4 rounded-[45%] border-[3px] border-primary/30 overflow-hidden">

                    <!-- Camera -->

                    <video id="video" autoplay playsinline></video>

                    <canvas id="canvas" class="hidden"></canvas>

                    <div class="absolute w-full h-1 bg-primary top-0 scan-line"></div>

                </div>

            </div>

            <div class="text-center mt-6">

                <h2 class="text-2xl font-bold mb-2">Position your face within the frame</h2>

                <p class="text-neutral-400 text-sm">Make sure lighting is good</p>

            </div>

        </main>

        <!-- Footer -->

        <footer class="p-6 pb-10 flex flex-col gap-6">

            <button id="snapBtn"
                class="w-full bg-gradient-to-r from-primary to-red-600 text-white font-bold text-lg py-4 rounded-full flex items-center justify-center gap-2">

                <span class="material-symbols-outlined">face</span>

                Scan Face

            </button>

            <button id="retakeBtn" class="hidden w-full bg-neutral-800 text-white font-semibold py-3 rounded-full">

                Retake

            </button>

            <form method="POST" action="{{ route('register.image') }}">

                @csrf

                @php
                    $data = Illuminate\Support\Facades\Session::get('register-info');
                @endphp

                <input type="hidden" name="photo" id="photoInput" value="{{ @$data['photo'] }}">

                <input name="name" type="hidden" value="{{ @$data['name'] }}">
                <input name="email" type="hidden" value="{{ @$data['email'] }}">
                <input name="location" type="hidden" value="{{ @$data['location'] }}">
                <input name="password" type="hidden" value="{{ @$data['password'] }}">
                <input name="password_confirmation" type="hidden" value="{{ @$data['password_confirmation'] }}">
                <input name="role" type="hidden" value="{{ @$data['role'] }}">
                <input name="type" type="hidden" value="{{ @$data['type'] }}">

                <button type="submit" id="submitBtn"
                    class="hidden w-full bg-green-600 text-white font-bold py-4 rounded-full">

                    Continue

                </button>

            </form>

        </footer>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        const video = document.getElementById('video')
        const canvas = document.getElementById('canvas')
        const ctx = canvas.getContext('2d')

        const snapBtn = document.getElementById('snapBtn')
        const retakeBtn = document.getElementById('retakeBtn')
        const submitBtn = document.getElementById('submitBtn')

        const photoInput = document.getElementById('photoInput')

        navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: "user"
                }
            })
            .then(stream => {
                video.srcObject = stream
            })
            .catch(() => {
                toastr.error("Camera permission denied")
            })

        snapBtn.onclick = function() {

            canvas.width = video.videoWidth
            canvas.height = video.videoHeight

            ctx.drawImage(video, 0, 0, canvas.width, canvas.height)

            const image = canvas.toDataURL("image/png")

            photoInput.value = image

            video.classList.add("hidden")
            canvas.classList.remove("hidden")

            snapBtn.classList.add("hidden")
            retakeBtn.classList.remove("hidden")
            submitBtn.classList.remove("hidden")

        }

        retakeBtn.onclick = function() {

            video.classList.remove("hidden")
            canvas.classList.add("hidden")

            snapBtn.classList.remove("hidden")
            retakeBtn.classList.add("hidden")
            submitBtn.classList.add("hidden")

            photoInput.value = ""

        }

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}')
            @endforeach
        @endif
    </script>

</body>

</html>
