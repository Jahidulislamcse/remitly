<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Blocked - Probasi Pay</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .block-card {
            background: white;
            width: 100%;
            max-width: 400px;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
        }

        .icon-container {
            width: 80px;
            height: 80px;
            background-color: #fee2e2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
        }

        .icon-container svg {
            width: 40px;
            height: 40px;
            color: #ef4444;
        }

        h2 {
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        p {
            color: #6b7280;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .contact-support {
            display: inline-block;
            margin-bottom: 20px;
            color: #009578; /* আপনার অ্যাপের গ্রিন থিম কালার */
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        /* লগআউট বাটন ডিজাইন */
        .logout-btn-container {
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
            margin-top: 10px;
        }

        .logout-btn {
            background-color: #111827;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            width: 100%;
            justify-content: center;
        }

        .logout-btn:hover {
            background-color: #374151;
            transform: translateY(-2px);
        }

        .logout-btn svg {
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>

    <div class="block-card">
        <!-- আইকন -->
        <div class="icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>

        <!-- টেক্সট -->
        <h2>অ্যাকাউন্ট ব্লক করা হয়েছে</h2>
        <p>দুঃখিত, অ্যাডমিন আপনার অ্যাকাউন্টটি সাময়িকভাবে বন্ধ করে দিয়েছে। কোনো ভুল হয়েছে মনে করলে অনুগ্রহ করে আমাদের সাপোর্টে যোগাযোগ করুন।</p>

        <!-- সাপোর্ট লিংক (অপশনাল) -->
        <a href="mailto:support@probasipay.com" class="contact-support">সাপোর্টে যোগাযোগ করুন &rarr;</a>

        <!-- লগআউট ফর্ম (আপনার স্ক্রিনশট অনুযায়ী) -->
        <div class="logout-btn-container">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    লগ আউট করুন
                </button>
            </form>
        </div>
    </div>

</body>
</html>