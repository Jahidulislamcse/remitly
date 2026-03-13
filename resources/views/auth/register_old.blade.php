<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Create Account</title>

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
            --input-border: #cbd5e1;
            --radius: 8px; /* বর্ডার রেডিয়াস কমানো হয়েছে */
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            margin: 0;
        }

        /* হেডার */
        .header-bar {
            background: #fff;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #edf2f7;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .back-btn { color: var(--text-dark); font-size: 18px; }

        .register-container {
            max-width: 450px;
            margin: 0 auto;
            padding: 15px 25px;
        }

        .logo-box {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo-box img {
            width: 100px;
            border-radius: 10px; /* লোগোর রেডিয়াস কমানো হয়েছে */
            border: 2px solid #078e42;
            padding: 5px;
        }

        /* ইনপুট গ্রুপ */
        .form-group-custom { margin-bottom: 18px; }

        .form-group-custom label {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 6px;
            display: block;
            color: #64748b;
            text-transform: uppercase;
        }

        .form-group-custom input {
            width: 100%;
            padding: 11px 14px;
            border-radius: var(--radius);
            border: 1.5px solid var(--input-border);
            outline: none;
            transition: 0.2s;
            font-size: 15px;
            box-sizing: border-box;
        }

        .form-group-custom input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(7, 142, 66, 0.1);
        }

        /* সার্চেবল কান্ট্রি ড্রপডাউন */
        .custom-dropdown { position: relative; }

        .selected-box {
            display: flex;
            align-items: center;
            background: #fff;
            border: 1.5px solid var(--input-border);
            padding: 10px 12px;
            border-radius: var(--radius);
            cursor: pointer;
            height: 48px;
        }

        .country-list-ui {
            display: none;
            position: absolute;
            top: 105%;
            left: 0;
            width: 100%;
            background: #fff;
            border-radius: var(--radius);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            padding: 0;
            border: 1px solid #e2e8f0;
        }

        .search-holder {
            position: sticky;
            top: 0;
            background: #fff;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .search-holder input {
            width: 100%;
            padding: 8px 12px;
            font-size: 13px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
        }

        .country-list-ui li {
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: 0.2s;
        }

        .country-list-ui li:hover { background: #f1f5f9; }
        .show { display: block; }

        /* রেডিও বাটন */
        .account-type-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .type-radio { display: none; }
        .type-label {
            display: block;
            text-align: center;
            padding: 11px;
            background: #fff;
            border: 1.5px solid var(--input-border);
            border-radius: var(--radius);
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            color: #64748b;
        }
        .type-radio:checked + .type-label {
            background: var(--primary-color);
            color: #fff;
            border-color: var(--primary-color);
        }

        /* বাটন */
        .btn-submit {
            width: 100%;
            background: var(--primary-color);
            color: #fff;
            padding: 14px;
            border-radius: var(--radius);
            border: none;
            font-weight: 700;
            font-size: 15px;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(7, 142, 66, 0.2);
        }

        .login-footer { text-align: center; margin-top: 30px; font-size: 14px; color: #64748b; }
        .login-footer a { color: var(--primary-color); font-weight: 700; text-decoration: none; }
    </style>
</head>

<body>

    <div class="header-bar">
        <a href="{{ route('user.login') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    </div>

    <div class="register-container">
        <div class="logo-box">
            <img src="{{ asset('logos/wise2.jpeg') }}" alt="Logo">
            <h5 class="mt-3 font-weight-bold">নিবন্ধন ফরম</h5>
        </div>

        <form action="{{ route('register.data') }}" method="post">
            @csrf

            <div class="form-group-custom">
                <label>নাম</label>
                <input name="name" type="text" placeholder="পুরো নাম লিখুন" required>
            </div>

            <div class="row gx-2">
                <div class="col-5">
                    <div class="form-group-custom custom-dropdown">
                        <label>দেশ</label>
                        @php $firstCountry = App\Models\Country::first(); @endphp
                        <div class="selected-box" onclick="toggleCountryDropdown()">
                            <img id="selected-flag" src="{{ asset($firstCountry?->image) }}" style="height: 16px; width: 26px; border-radius: 2px; margin-right: 8px;">
                            <span id="selected-code" style="font-size: 14px; font-weight: 700;">{{ $firstCountry?->code }}</span>
                        </div>
                        <div class="country-list-ui" id="countryDropdown">
                            <div class="search-holder">
                                <input type="text" id="countrySearch" placeholder="Search country..." onclick="event.stopPropagation()">
                            </div>
                            <ul class="p-0 m-0" id="countryUl">
                                @foreach (App\Models\Country::all() as $data)
                                    <li class="country-item" onclick="selectCountry('{{ $data->id }}', '{{ asset($data->image) }}', '{{ $data->name }}', '{{ $data->code }}')">
                                        <img src="{{ asset($data->image) }}" style="height: 18px; width: 28px; border-radius: 2px;">
                                        <span class="c-name" style="font-size: 13px; font-weight: 600;">{{ $data->name }} ({{ $data->code }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <input type="hidden" name="location" id="countryInput" value="{{ $firstCountry?->id }}">
                        <input type="hidden" name="code" id="phoneCodeInput" value="{{ $firstCountry?->code }}">
                    </div>
                </div>
                <div class="col-7">
                    <div class="form-group-custom">
                        <label>মোবাইল নম্বর</label>
                        <input name="email" type="number" placeholder="017XXXXXXXX" required>
                    </div>
                </div>
            </div>

            <div class="form-group-custom">
                <label>পাসওয়ার্ড</label>
                <input type="password" name="password" placeholder="সর্বনিম্ন ৬ অক্ষর" required>
            </div>

            <div class="form-group-custom">
                <label>পাসওয়ার্ড নিশ্চিত করুন</label>
                <input type="password" name="password_confirmation" placeholder="আবার লিখুন" required>
            </div>

            <label class="small font-weight-bold text-muted mb-2 d-block">একাউন্টের ধরণ</label>
            <div class="account-type-grid">
                <div>
                    <input type="radio" id="personal" name="type" value="personal" class="type-radio" checked>
                    <label for="personal" class="type-label">পার্সোনাল</label>
                </div>
                <div>
                    <input type="radio" id="business" name="type" value="bussiness" class="type-radio">
                    <label for="business" class="type-label">বিজনেস</label>
                </div>
            </div>

            <input type="hidden" name="role" value="digital-marketing">

            <button type="submit" class="btn-submit">এগিয়ে যান</button>
        </form>

        <div class="login-footer">
             ইতিমধ্যেই নিবন্ধিত? <a href="{{ route('user.login') }}">লগইন করুন</a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Dropdown Toggle
        function toggleCountryDropdown() {
            $('#countryDropdown').toggleClass('show');
            if($('#countryDropdown').hasClass('show')){
                $('#countrySearch').focus();
            }
        }

        // Live Search Logic
        $('#countrySearch').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $("#countryUl li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Select Country
        function selectCountry(id, image, name, code) {
            $('#selected-flag').attr('src', image);
            $('#selected-code').text(code);
            $('#countryInput').val(id);
            $('#phoneCodeInput').val(code);
            $('#countryDropdown').removeClass('show');
            $('#countrySearch').val(''); // Reset search
            $("#countryUl li").show(); // Reset list
        }

        // Close when clicking outside
        $(window).on('click', function (e) {
            if (!$(e.target).closest('.custom-dropdown').length) {
                $('#countryDropdown').removeClass('show');
            }
        });

        // Notifications
        @if(session('msg'))
            toastr.{{ session('response') ? 'success' : 'error' }}('{{ session('msg') }}');
        @endif
    </script>
</body>
</html>