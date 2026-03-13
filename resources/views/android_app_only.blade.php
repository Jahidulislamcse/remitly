<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Use Official App - Wise Transfer</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Hind Siliguri', sans-serif; background: #f0f2f5; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .box { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); max-width: 350px; text-align: center; }
        h2 { color: #0b2d35; margin-bottom: 15px; }
        p { color: #64748b; margin-bottom: 30px; font-size: 16px; }
        .btn { background: #23943F; color: white; text-decoration: none; padding: 14px 30px; border-radius: 10px; font-weight: bold; display: block; margin-bottom: 20px; transition: 0.3s; }
        .btn:hover { background: #1a7a33; }
        .logout { background: none; border: none; color: #94a3b8; text-decoration: underline; cursor: pointer; }
    </style>
</head>
<body>
    <div class="box">
        <h2>অ্যাপ থেকে লগইন করুন</h2>
        <p>অ্যান্ড্রয়েড ইউজারদের জন্য ব্রাউজারে লগইন করা বন্ধ রাখা হয়েছে। অনুগ্রহ করে আমাদের অফিসিয়াল অ্যাপ ব্যবহার করুন।</p>
        <a href="{{ route('install.guide') }}" class="btn">অ্যাপটি ডাউনলোড করুন</a>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout">লগআউট করে বেরিয়ে যান</button>
        </form>
    </div>
</body>
</html>