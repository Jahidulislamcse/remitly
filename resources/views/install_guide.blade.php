<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wise Transfer - বিশ্বের যেকোনো জায়গায় সহজে টাকা পাঠান</title>
    
    <!-- Google Fonts: Hind Siliguri -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- PWA Link -->
    <link rel="manifest" href="{{ asset('manifest.json') }}?v={{ time() }}">

    <style>
        :root {
            --dark-bg: #0b2d35; /* আপনার স্ক্রিনশটের ডার্ক টিল কালার */
            --primary-green: #23943F;
            --capsule: #073825;
            --white: #ffffff;
            --text-gray: #64748b;
            --light-bg: #f4f7f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Hind Siliguri', sans-serif;
        }

        body {
            background-color: var(--white);
            color: var(--dark-bg);
            line-height: 1.6;
        }

        /* --- Header --- */
        header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .logo-text {
            font-size: 20px;
            font-weight: 800;
            color: var(--dark-bg);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .hamburger {
            width: 25px;
            height: 2px;
            background: var(--dark-bg);
            position: relative;
        }
        .hamburger::before, .hamburger::after {
            content: '';
            width: 25px;
            height: 2px;
            background: var(--dark-bg);
            position: absolute;
        }
        .hamburger::before { top: -8px; }
        .hamburger::after { top: 8px; }

        /* --- Hero Section --- */
        .hero {
            background-color: var(--dark-bg);
            color: var(--white);
            padding: 60px 25px;
            text-align: center;
        }

        .hero h1 {
            font-size: 32px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 16px;
            opacity: 0.8;
            margin-bottom: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-button {
            background-color: var(--primary-green);
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
            transition: 0.3s;
        }

        .hero-mockup {
            display: flex;
    justify-content: center;
    align-items: center;
        }
        
        .mockup-card{
    background: #ffffff;
    border-radius: 16px;
    padding: 15px;
    width: 320px;
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 5px solid var(--primary-green);

    /* incline effect */
    transform: rotate(0deg);

    /* modern shadow */
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}

        .hero-mockup img {
             width: 100%;
    height: 100%;
    object-fit: contain;

    /* image straight থাকবে */
    transform: rotate(0deg);
        }

        /* --- Tabs & Download Section --- */
        .download-area {
            padding: 50px 20px;
            background: var(--light-bg);
            text-align: center;
        }

        .tabs {
            display: flex;
            background: #e2e8f0;
            padding: 5px;
            border-radius: 12px;
            max-width: 350px;
            margin: 0 auto 30px;
        }

        .tab-btn {
            flex: 1;
            padding: 10px;
            border: none;
            background: none;
            font-weight: 700;
            cursor: pointer;
            border-radius: 8px;
            color: var(--text-gray);
        }

        .tab-btn.active {
            background: var(--white);
            color: var(--dark-bg);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .tab-content { display: none; animation: fadeIn 0.5s; }
        .tab-content.active { display: block; }

        @keyframes fadeIn { from {opacity: 0;} to {opacity: 1;} }

        /* --- Features Section --- */
        .features {
            padding: 60px 25px;
            text-align: center;
        }

        .section-title {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 40px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            width: 50px;
            height: 4px;
            background: var(--primary-green);
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .feature-card {
            background: var(--white);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            text-align: center;
        }

        .f-icon {
            width: 60px;
            height: 60px;
            background: #e6f7f3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
        }

        .feature-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: var(--text-gray);
            font-size: 14px;
        }

        /* --- FAQ Section --- */
        .faq {
            background: var(--light-bg);
            padding: 60px 25px;
        }

        .faq-item {
            background: var(--white);
            margin-bottom: 15px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.03);
        }

        .faq-question {
            padding: 18px;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .faq-answer {
            padding: 0 18px 18px;
            color: var(--text-gray);
            font-size: 14px;
            display: none;
        }

        /* --- Footer --- */
        footer {
            background: var(--dark-bg);
            color: var(--white);
            padding: 40px 25px;
            text-align: center;
            font-size: 14px;
        }

        .step-box {
            background: #fff;
            padding: 15px;
            border-radius: 12px;
            text-align: left;
            margin-bottom: 10px;
            border-left: 4px solid var(--primary-green);
        }

        /* Responsive */
        @media (min-width: 768px) {
            .features-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                max-width: 900px;
                margin: 0 auto;
            }
        }
        
        .capsule-text{
    display: inline-block;
    padding: 3px 10px;
    border-radius: 999px;
    background: var(--capsule);
    color: #fff;
    font-weight: 600;
    font-size: 13px;
    line-height: 1.2;
}


    </style>
</head>
<body>

    <header>
        <div class="logo-text">
            <span style="color: var(--primary-green);">Wise</span> Transfer
        </div>
        <div class="hamburger"></div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Wise Transfer – বিশ্বের যেকোনো জায়গায় সহজে টাকা পাঠান</h1>
        <p>আমাদের অ্যাপটির মাধ্যমে আপনি এখন পৃথিবীর যেকোনো প্রান্ত থেকে খুব সহজেই টাকা পাঠাতে পারবেন দ্রুত এবং নিরাপদে।</p>
        
        <a href="#hlw" class="cta-button">
            <span style="font-size: 22px; color: white;">⬇</span> ডাউনলোড করুন
        </a>

        <div class="hero-mockup" id="hlw">
    <div class="mockup-card">
        <img src="https://probasipay.com/logos/wise2.jpeg" alt="Wise Transfer Logo">
    </div>
</div>

    </section>

    <!-- Download & Instruction Section -->
    <section class="download-area" id="download">
        <h2 class="section-title">আজই ইনস্টল করুন</h2>
        
        <div class="tabs" id="deviceTabs">
            <button class="tab-btn active" onclick="openTab('android', this)">Android</button>
            <button class="tab-btn" onclick="openTab('iphone', this)">iPhone</button>

        </div>

        <!-- Android Content -->
        <div id="android" class="tab-content active">
            <p style="margin-bottom: 20px;">আপনার অ্যান্ড্রয়েড ফোনের জন্য সরাসরি APK ফাইলটি ডাউনলোড করুন।</p>
            <a href="{{ asset('downloads/wisetransfer.apk') }}" class="cta-button" style="margin-bottom: 0;">
                অ্যান্ড্রয়েড অ্যাপ ডাউনলোড
            </a>
        </div>

        <!-- iPhone Content -->
        <div id="iphone" class="tab-content">
    <div class="step-box">১. সাফারির নিচে <span class="capsule-text">Share</span> বাটনে ক্লিক করুন।</div>
    <div class="step-box">২. মেনু থেকে <span class="capsule-text">Add to Home Screen</span> সিলেক্ট করুন।</div>
    <div class="step-box">৩. উপরে ডানদিকে <span class="capsule-text">Add</span> বাটনে ক্লিক করুন।</div>
</div>

    </section>

    <!-- Features Section -->
    <section class="features">
        <h2 class="section-title">কেন Wise Transfer সেরা?</h2>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="f-icon">🚀</div>
                <h3>দ্রুত টাকা পাঠান</h3>
                <p>আমাদের উন্নত প্রযুক্তির মাধ্যমে টাকা পৌঁছে যায় চোখের পলকে। কোনো ঝামেলা ছাড়াই লেনদেন করুন।</p>
            </div>

            <div class="feature-card">
                <div class="f-icon">🔒</div>
                <h3>সুরক্ষিত লেনদেন</h3>
                <p>আপনার প্রতিটি ট্রানজ্যাকশন আমাদের কাছে অত্যন্ত নিরাপদ। আমরা ব্যবহার করি লেটেস্ট সিকিউরিটি এনক্রিপশন।</p>
            </div>

            <div class="feature-card">
                <div class="f-icon">💰</div>
                <h3>কম খরচে সেরা</h3>
                <p>আমরা দিচ্ছি বাজারের সেরা এক্সচেঞ্জ রেট এবং সবচাইতে কম সার্ভিস চার্জ। সাশ্রয় করুন প্রতিবার।</p>
            </div>

            <div class="feature-card">
                <div class="f-icon">💬</div>
                <h3>২৪/৭ সাপোর্ট</h3>
                <p>যেকোনো সমস্যায় আমাদের কাস্টমার কেয়ার টিম আপনার সেবায় নিয়োজিত থাকে ২৪ ঘণ্টা।</p>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq">
        <h2 class="section-title">সচরাচর জিজ্ঞাস্য প্রশ্নাবলী</h2>
        
        <div style="max-width: 600px; margin: 0 auto;">
            <div class="faq-item">
                <div class="faq-question">কিভাবে একাউন্ট ওপেন করব? <span>+</span></div>
                <div class="faq-answer">আমাদের অ্যাপটি ডাউনলোড করে আপনার ফোন নম্বর দিয়ে খুব সহজেই একাউন্ট খুলে নিতে পারেন।</div>
            </div>

            <div class="faq-item">
                <div class="faq-question">টাকা পাঠাতে কত সময় লাগবে? <span>+</span></div>
                <div class="faq-answer">অধিকাংশ লেনদেন তাৎক্ষণিকভাবে সম্পন্ন হয়। তবে ব্যাংকিং আওয়ারের ওপর ভিত্তি করে কিছুটা সময় লাগতে পারে।</div>
            </div>

            <div class="faq-item">
                <div class="faq-question">লেনদেনের লিমিট কত? <span>+</span></div>
                <div class="faq-answer">আপনার একাউন্টের ভেরিফিকেশন লেভেলের ওপর ভিত্তি করে দৈনিক এবং মাসিক লিমিট নির্ধারিত থাকে।</div>
            </div>

            <div class="faq-item">
                <div class="faq-question">২৪/৭ সাপোর্ট কিভাবে পাব? <span>+</span></div>
                <div class="faq-answer">অ্যাপের ভেতরে থাকা লাইভ চ্যাট অথবা আমাদের হেল্পলাইন নম্বরে যেকোনো সময় যোগাযোগ করতে পারেন।</div>
            </div>
        </div>
    </section>

    <footer>
        <p><b>Wise Transfer</b> - Your Trusted Partner</p>
        <p style="opacity: 0.6; margin-top: 10px;">&copy; 2026 Wise Transfer. All rights reserved.</p>
    </footer>

  <script>
/* ---------- TAB SWITCH FUNCTION ---------- */
function openTab(tabName, btn = null) {

    // সব content hide
    document.querySelectorAll('.tab-content').forEach(el => {
        el.classList.remove('active');
    });

    // সব tab button inactive
    document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('active');
    });

    // selected content show
    document.getElementById(tabName).classList.add('active');

    // selected button active (manual click হলে)
    if (btn) btn.classList.add('active');
}


/* ---------- AUTO DEVICE DETECT ---------- */
window.onload = function() {
    const userAgent = navigator.userAgent || navigator.vendor || window.opera;
    const isIphone = /iPad|iPhone|iPod/.test(userAgent);
    const isAndroid = /Android/.test(userAgent);

    const deviceTabs = document.getElementById('deviceTabs');
    const buttons = document.querySelectorAll('.tab-btn');

    if (isIphone) {
        deviceTabs.style.display = 'none';
        openTab('iphone');
    } 
    else if (isAndroid) {
        deviceTabs.style.display = 'none';
        openTab('android');
    } 
    else {
        // desktop বা অন্য device
        openTab('android', buttons[0]);
    }
};


/* ---------- FAQ TOGGLE ---------- */
document.querySelectorAll('.faq-question').forEach(q => {
    q.addEventListener('click', () => {

        // সব answer বন্ধ করে দাও
        document.querySelectorAll('.faq-answer').forEach(a => {
            a.style.display = 'none';
        });

        // সব icon + করে দাও
        document.querySelectorAll('.faq-question span').forEach(s => {
            s.innerText = '+';
        });

        const answer = q.nextElementSibling;
        const icon = q.querySelector('span');

        // যদি আগেই open না থাকে, তাহলে open করো
        if (answer.style.display !== 'block') {
            answer.style.display = 'block';
            icon.innerText = '−';
        }
    });
});



/* ---------- PWA INSTALL PREVENT DEFAULT ---------- */
window.addEventListener('beforeinstallprompt', (e) => { 
    e.preventDefault(); 
});
</script>

</body>
</html>