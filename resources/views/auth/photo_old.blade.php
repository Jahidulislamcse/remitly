<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Face Verification</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('styles/bootstrap.css') }}">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <style>
        :root {
            --primary-color: #078e42;
            --bg-color: #f8fafc;
            --text-dark: #1e293b;
            --radius: 8px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            overflow-x: hidden;
        }

        /* হেডার */
        .header-bar {
            background: #fff;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #edf2f7;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header-bar h3 { font-size: 16px; margin: 0 auto; font-weight: 700; color: var(--text-dark); }
        .back-btn { color: var(--text-dark); font-size: 18px; position: absolute; }

        .main-content {
            max-width: 450px;
            margin: 0 auto;
            padding: 20px;
        }

        /* প্রগ্রেস বার */
        .step-indicator {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 25px;
        }
        .step { height: 6px; width: 40px; background: #e2e8f0; border-radius: 10px; }
        .step.active { background: var(--primary-color); }

        /* ক্যামেরা কন্টেইনার */
        .camera-wrapper {
            position: relative;
            width: 100%;
            max-width: 320px;
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;
            background: #000;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border: 4px solid #fff;
        }

        video, canvas {
            width: 100%;
            height: auto;
            display: block;
            transform: scaleX(1); /* ফ্রন্ট ক্যামেরা মিরর ইফেক্ট ছাড়া */
        }

        /* ফেস ওভাল ওভারলে */
        .face-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70%;
            height: 80%;
            border: 2px dashed rgba(255,255,255,0.5);
            border-radius: 50%;
            pointer-events: none;
            box-shadow: 0 0 0 500px rgba(0,0,0,0.4);
        }

        .instruction-text {
            text-align: center;
            margin: 20px 0;
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }

        /* বাটন স্টাইল */
        .action-area {
            text-align: center;
            margin-top: 10px;
        }

        .btn-snap {
            background: var(--primary-color);
            color: #fff;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(7, 142, 66, 0.3);
            font-size: 24px;
            transition: 0.3s;
        }
        .btn-snap:active { transform: scale(0.9); }

        .btn-next {
            width: 100%;
            background: var(--primary-color);
            color: #fff;
            padding: 14px;
            border-radius: var(--radius);
            border: none;
            font-weight: 700;
            margin-top: 20px;
            transition: 0.3s;
            display: none; /* শুরুতে লুকানো থাকবে */
        }

        .btn-retake {
            background: #fff;
            color: #ef4444;
            border: 1px solid #fee2e2;
            padding: 8px 20px;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 13px;
            margin-top: 15px;
            display: none;
        }

    </style>
</head>

<body>

    <!-- Header -->
    <div class="header-bar">
        <a href="{{ route('register') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
        <h3>ভেরিফিকেশন তথ্য</h3>
    </div>

    <div class="main-content">
        <!-- Progress Steps -->
        <div class="step-indicator">
            <div class="step active"></div>
            <div class="step active"></div>
            <div class="step"></div>
        </div>

        <div class="instruction-text">
            <h5 class="text-dark font-weight-bold">মুখমন্ডলের ছবি তুলুন</h5>
            <p>আপনার ফেসটি ফ্রেমের মাঝখানে রাখুন এবং বোতামটি চাপুন</p>
        </div>

        <!-- Camera UI -->
        <div class="camera-wrapper">
            <video id="video" autoplay playsinline></video>
            <canvas id="canvas" style="display:none;"></canvas>
            <div class="face-overlay" id="overlay"></div>
        </div>

        <div class="action-area">
            <!-- Snap Button -->
            <button type="button" id="snap" class="btn-snap">
                <i class="fa-solid fa-camera"></i>
            </button>

            <!-- Retake Button -->
            <button type="button" id="retake" class="btn-retake">
                <i class="fa-solid fa-rotate-left mr-1"></i> পুনরায় তুলুন
            </button>

            <!-- Form -->
            <form method="POST" action="{{ route('register.image') }}" enctype="multipart/form-data">
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

                <button type="submit" id="next-btn" class="btn-next shadow">
                    পরবর্তী ধাপ <i class="fa-solid fa-arrow-right ml-2"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');
        const snapButton = document.getElementById('snap');
        const retakeButton = document.getElementById('retake');
        const nextButton = document.getElementById('next-btn');
        const overlay = document.getElementById('overlay');
        const photoInput = document.getElementById('photoInput');

        // ক্যামেরা চালু
        navigator.mediaDevices.getUserMedia({
            video: { facingMode: "user" }
        })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(err => {
            toastr.error("ক্যামেরা চালু করা যাচ্ছে না। পারমিশন চেক করুন।");
        });

        // ছবি তোলা
        snapButton.addEventListener('click', () => {
            // রেজোলিউশন সেট করা
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            const imageData = canvas.toDataURL('image/png');
            photoInput.value = imageData;

            // UI পরিবর্তন
            video.style.display = 'none';
            canvas.style.display = 'block';
            overlay.style.display = 'none';
            snapButton.style.display = 'none';
            retakeButton.style.display = 'inline-block';
            nextButton.style.display = 'block';
        });

        // পুনরায় ছবি তোলা
        retakeButton.addEventListener('click', () => {
            video.style.display = 'block';
            canvas.style.display = 'none';
            overlay.style.display = 'block';
            snapButton.style.display = 'inline-block';
            retakeButton.style.display = 'none';
            nextButton.style.display = 'none';
            photoInput.value = '';
        });

        // এরর মেসেজ হ্যান্ডলিং
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        @endif
    </script>
</body>
</html>