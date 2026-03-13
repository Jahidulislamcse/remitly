<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Set PIN</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('styles/bootstrap.css') }}">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <style>
        :root {
            --primary-color: #078e42;
            --bg-color: #f8fafc;
            --text-dark: #1e293b;
            --input-border: #cbd5e1;
            --radius: 8px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            margin: 0;
        }

        /* ১) হেডার - ক্যামেরা পেজের সাথে ১০০% মিল রেখে */
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
        .back-btn { color: var(--text-dark); font-size: 18px; position: absolute; text-decoration: none; }

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
            margin-bottom: 35px;
            margin-top: 10px;
        }
        .step { height: 6px; width: 45px; background: #e2e8f0; border-radius: 10px; }
        .step.active { background: var(--primary-color); }

        /* টাইটেল সেকশন */
        .page-title { text-align: center; margin-bottom: 30px; }
        .page-title h4 { font-weight: 800; color: var(--text-dark); font-size: 20px; }
        .page-title p { font-size: 13px; color: #64748b; font-weight: 500; }

        /* পিন ইনপুট বক্স ডিজাইন */
        .pin-group {
            margin-bottom: 25px;
        }
        .pin-group label {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 8px;
            display: block;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .pin-field {
            width: 100%;
            height: 55px;
            background: #fff;
            border: 1.5px solid var(--input-border);
            border-radius: var(--radius);
            outline: none;
            font-size: 24px;
            text-align: center;
            letter-spacing: 12px;
            font-weight: 800;
            transition: 0.3s;
            color: var(--primary-color);
        }
        .pin-field:focus {
            border-color: var(--primary-color);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(7, 142, 66, 0.06);
        }
        .pin-field::placeholder {
            letter-spacing: 4px;
            font-size: 16px;
            color: #cbd5e1;
            font-weight: 400;
        }

        /* মেইন বাটন */
        .btn-register {
            width: 100%;
            background: var(--primary-color);
            color: #fff;
            padding: 16px;
            border-radius: var(--radius);
            border: none;
            font-weight: 800;
            font-size: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 15px;
            box-shadow: 0 8px 20px rgba(7, 142, 66, 0.2);
            transition: 0.3s;
        }
        .btn-register:active { transform: scale(0.98); }

        /* মোডাল ডিজাইন */
        .modal-content { border-radius: 12px; border: none; }
        .modal-body { padding: 25px; }
        .summary-card {
            background: #f8fafc;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #e2e8f0;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #edf2f7;
        }
        .summary-row:last-child { border-bottom: none; }
        .summary-row span:first-child { color: #64748b; font-size: 13px; font-weight: 600; }
        .summary-row span:last-child { color: var(--text-dark); font-size: 13px; font-weight: 700; }

        .btn-submit-final {
            width: 100%;
            background: var(--primary-color);
            color: #fff;
            padding: 14px;
            border-radius: var(--radius);
            border: none;
            font-weight: 700;
            margin-top: 20px;
        }

        /* প্রিলোডার */
        .spinner { width: 35px; height: 35px; border: 3px solid #f3f3f3; border-top: 3px solid var(--primary-color); border-radius: 50%; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    </style>
</head>

<body>
    <!-- Preloader -->
    <div class="preload preload-container">
        <div class="preload-logo"><div class="spinner"></div></div>
    </div>

    <!-- ১) হেডার - ক্যামেরা পেজের স্টাইল অনুযায়ী -->
    <div class="header-bar">
        <a href="{{ route('register.image') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
        <h3>নিবন্ধন সম্পন্ন করুন</h3>
    </div>

    <div class="main-content">
        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step active"></div>
            <div class="step active"></div>
            <div class="step active"></div>
        </div>

        <div class="page-title">
            <h4>গোপন পিন সেট করুন</h4>
            <p>আপনার লেনদেন নিরাপদ রাখতে ৬ ডিজিটের পিন দিন</p>
        </div>

        <form action="{{ route('register') }}" method="post">
            @csrf

            @php
                $data = Illuminate\Support\Facades\Session::get('register-info');
                $country = App\Models\Country::find($data['location']);
            @endphp

            <!-- Hidden Fields -->
            <input type="hidden" name="photo" value="{{ @$data['photo'] }}">
            <input type="hidden" name="name" value="{{ @$data['name'] }}">
            <input type="hidden" name="email" value="{{ @$data['email'] }}">
            <input type="hidden" name="location" value="{{ @$data['location'] }}">
            <input type="hidden" name="password" value="{{ @$data['password'] }}">
            <input type="hidden" name="password_confirmation" value="{{ @$data['password_confirmation'] }}">
            <input type="hidden" name="role" value="{{ @$data['role'] }}">
            <input type="hidden" name="type" value="{{ @$data['type'] }}">

            <!-- পিন ইনপুট বক্স - শার্প ও আধুনিক -->
            <div class="pin-group">
                <label>নতুন পিন কোড</label>
                <input type="password" name="pin" id="pin_1" maxlength="6" inputmode="numeric" placeholder="পিন কোড লিখুন" required class="pin-field">
            </div>

            <div class="pin-group">
                <label>পিন কোডটি পুনরায় দিন</label>
                <input type="password" name="confirm_pin" id="pin_2" maxlength="6" inputmode="numeric" placeholder="পিন কোড পুনরায় লিখুন" required class="pin-field">
            </div>

            <button type="button" class="btn-register" data-bs-toggle="modal" data-bs-target="#checkModal">
                নিবন্ধন সম্পন্ন করুন
            </button>

            <!-- Verification Modal -->
            <div class="modal fade" id="checkModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mx-3">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <i class="fa-solid fa-circle-check text-success mb-3" style="font-size: 40px;"></i>
                            <h5 class="font-weight-bold mb-3">তথ্যগুলো মিলিয়ে নিন</h5>
                            
                            <div class="summary-card text-left">
                                <div class="summary-row"><span>নাম</span><span>{{ @$data['name'] }}</span></div>
                                <div class="summary-row"><span>মোবাইল</span><span>{{ @$data['email'] }}</span></div>
                                <div class="summary-row"><span>দেশ</span><span>{{ @$country->name }}</span></div>
                                <div class="summary-row"><span>পিন</span><span id="pin_preview">******</span></div>
                            </div>

                            <p class="mt-4 mb-0 small font-weight-bold text-muted">উপরের সকল তথ্য সঠিক আছে?</p>
                            
                            <button type="submit" class="btn-submit-final shadow">হ্যাঁ, সাবমিট করুন</button>
                            <button type="button" class="btn btn-sm text-muted mt-3" data-bs-dismiss="modal">ভুল আছে, ফিরে যান</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // পিন প্রিভিউ ইন মোডাল
        document.getElementById('pin_1').addEventListener('input', function() {
            document.getElementById('pin_preview').innerText = this.value || '******';
        });

        // পিন ম্যাচ ভ্যালিডেশন
        $('.btn-register').on('click', function() {
            if($('#pin_1').val() !== $('#pin_2').val()) {
                toastr.error('পিন নম্বর দুটি মিলছে না!');
                return false;
            }
        });

        // প্রিলোডার
        $(window).on('load', function() {
            $('.preload').fadeOut('slow');
        });

        @if(session('msg'))
            toastr.{{ session('response') ? 'success' : 'error' }}('{{ session('msg') }}');
        @endif
    </script>

</body>
</html>