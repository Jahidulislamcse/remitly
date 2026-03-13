<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@extends('backend.layout.master')

@section('style')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --app-green: #078e42;
        --app-bg: #f4f7fa;
        --text-dark: #0f172a;
        --text-muted: #64748b;
        --card-white: #ffffff;
    }

    body {
        background-color: var(--app-bg) !important;
        font-family: 'Plus Jakarta Sans', 'SolaimanLipi', sans-serif !important;
        margin: 0;
    }

    /* ১) হেডার ডিজাইন */
    .app-header {
        background-color: var(--app-green) !important;
        padding: 15px 20px 0px 20px;
        position: sticky;
        top: 0;
        z-index: 999;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        border-radius: 0 0 30px 30px;
    }
    
    .header-top {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 15px;
    }

    .back-btn { 
        position: absolute; left: 0; color: #fff !important; font-size: 22px; text-decoration: none;
    }
    
    .header-title { 
        color: #fff !important; font-weight: 800; font-size: 20px; margin: 0; 
    }

    /* [FIXED] স্ক্রলিং ক্যাপসুল - এনিমেশন ফিক্স */
    .scroll-pill-wrapper {
        padding-bottom: 15px;
        display: flex;
        justify-content: center;
    }

    .info-scroll-pill {
        position: relative;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.15); 
        border-radius: 50px;
        width: 80%; 
        max-width: 350px; 
        height: 28px; 
        overflow: hidden;
    }

    .info-scroll-text {
        position: absolute;
        white-space: nowrap;
        color: #fff;
        font-size: 13px;
        font-weight: 800;
        line-height: 26px; /* ভার্টিক্যাল সেন্টার */
        animation: info-marquee 17s linear infinite;
        left: 100%; /* শুরু হবে বাইরে থেকে */
    }

    @keyframes info-marquee { 
        0% { left: 100%; transform: translateX(0); } 
        100% { left: 0; transform: translateX(-100%); } 
    }

    /* ২) কন্টেইনার */
    .review-container {
        max-width: 800px; margin: 20px auto 100px auto; padding: 0 15px;
    }

    .action-bar {
        background: #fff; padding: 6px; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03); display: flex;
        gap: 8px; margin-bottom: 20px;
    }
    
    .btn-filter {
        flex: 1; padding: 12px; text-align: center; border-radius: 10px;
        font-size: 14px; font-weight: 700; text-decoration: none !important;
        transition: 0.3s; color: var(--text-muted); background: transparent;
    }
    .btn-filter.active {
        background: var(--app-green); color: #fff;
        box-shadow: 0 4px 12px rgba(7, 142, 66, 0.3);
    }

    /* সার্চ বক্স */
    .search-wrap { position: relative; margin-bottom: 25px; }
    .search-input {
        width: 100%; padding: 14px 20px 14px 45px; border-radius: 15px;
        border: 1px solid #e2e8f0; outline: none; font-size: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02); transition: 0.3s;
    }
    .search-input:focus { border-color: var(--app-green); }
    .search-icon {
        position: absolute; left: 18px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 18px;
    }

    /* ৩) রিভিউ কার্ড */
    .review-card {
        background: var(--card-white); border-radius: 24px; padding: 18px;
        margin-bottom: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        border: 1px solid #ffffff; position: relative;
        overflow: visible;
    }

    .user-header { display: flex; align-items: center; margin-bottom: 15px; }
    .user-avatar-circle {
        width: 48px; height: 48px; border-radius: 50%;
        background: #f1f5f9; display: flex; align-items: center; justify-content: center;
        margin-right: 12px; overflow: hidden; border: 2px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .user-avatar-circle img { width: 100%; height: 100%; object-fit: cover; }
    
    .user-info h5 { font-size: 16px; font-weight: 800; color: var(--text-main); margin: 0; }
    .user-location { font-size: 12px; color: var(--text-sub); display: flex; align-items: center; gap: 5px; font-weight: 600; margin-top: 2px; }
    .flag-icon { width: 18px; border-radius: 3px; }

    .video-wrapper {
        position: relative; width: 100%; border-radius: 16px; overflow: hidden;
        background: #000; margin-bottom: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        aspect-ratio: 16/9;
    }
    .video-wrapper video { width: 100%; height: 100%; object-fit: contain; }

    /* [FIXED] কাস্টম প্লে বাটন - বর্ডার রিমুভড */
    .play-overlay {
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center;
        cursor: pointer; z-index: 10; transition: 0.3s;
    }
    
    .play-icon-circle {
        width: 60px; height: 60px;
        background: rgba(7, 142, 66, 0.9);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 24px;
        /* box-shadow রিমুভ করা হয়েছে */
        transition: 0.3s;
    }
    .play-overlay:hover .play-icon-circle { transform: scale(1.1); }

    /* ড্রপডাউন মেনু */
    .custom-dropdown {
        position: absolute; right: 0; top: 40px; background: #fff;
        border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        min-width: 140px; z-index: 1000; display: none; border: 1px solid #f1f5f9;
        overflow: hidden;
    }
    .custom-dropdown.show { display: block; animation: fadeIn 0.2s; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    .dropdown-item-c {
        display: block; padding: 10px 15px; color: #334155; 
        font-size: 13px; font-weight: 600; text-decoration: none;
        border-bottom: 1px solid #f1f5f9; cursor: pointer; width: 100%; text-align: left;
        background: none; border-left: none; border-right: none; border-top: none;
    }
    .dropdown-item-c:last-child { border-bottom: none; }
    .dropdown-item-c:hover { background: #f8fafc; color: var(--app-green); }
    .dropdown-item-c.delete { color: #ef4444; }
    .options-btn { background: none; border: none; color: #94a3b8; font-size: 18px; padding: 5px 10px; }

    .review-title { font-weight: 800; font-size: 15px; color: var(--app-green); margin-bottom: 6px; }
    .review-desc { font-size: 14px; color: #334155; line-height: 1.6; }
    .see-more-link { color: var(--app-green); font-weight: 800; font-size: 13px; cursor: pointer; }

    .fab-btn {
        position: fixed; bottom: 90px; right: 20px;
        background: var(--app-green); color: #fff; width: 60px; height: 60px;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 26px; box-shadow: 0 10px 25px rgba(7, 142, 66, 0.5);
        z-index: 1000; border: none;
    }

    /* পপআপ ডিজাইন */
    .custom-modal-content { border-radius: 25px !important; border: none !important; }
    .custom-modal-header { background: var(--app-green) !important; padding: 15px 20px !important; }
    .custom-modal-title { color: #fff !important; font-weight: 700 !important; margin: 0 !important; font-size: 18px !important; }
    .custom-modal-body { padding: 25px 20px !important; background: #fff !important; }

    .iso-input-group { margin-bottom: 20px; width: 100%; }
    .iso-label {
        font-size: 12px !important; font-weight: 700 !important; color: #64748b !important;
        margin-bottom: 8px !important; display: block !important;
    }
    
    .iso-field-wrapper { position: relative; width: 100%; }
    
    /* [FIXED] ইনপুট আইকন পজিশন */
    .iso-icon {
        position: absolute !important; left: 15px !important; top: 50% !important;
        transform: translateY(-50%) !important; color: var(--app-green) !important;
        font-size: 18px !important; pointer-events: none; z-index: 10;
    }
    /* [FIXED] টেক্সট এরিয়া আইকন - উপরে ফিক্স */
    .iso-icon-top { 
        top: 15px !important; 
        transform: none !important; 
    }

    /* [FIXED] ইনপুট প্যাডিং - লেখা যেন আইকনের উপর না উঠে */
    .iso-input {
        width: 100% !important;
        padding: 12px 15px 12px 45px !important; /* বামে ৪৫px জায়গা */
        border-radius: 12px !important;
        border: 1.5px solid #e2e8f0 !important;
        font-size: 14px !important;
        color: #1e293b !important;
        background: #f8fafc !important;
        outline: none !important;
    }
    .iso-input:focus { border-color: var(--app-green) !important; background: #fff !important; }

    .iso-upload-box {
        border: 2px dashed #cbd5e1 !important; border-radius: 12px !important;
        padding: 15px !important; text-align: center !important;
        background: #fdfdfd !important; cursor: pointer !important; width: 100% !important;
        display: block !important; margin: 0 !important;
    }
    .btn-iso-save {
        width: 100% !important; background: var(--app-green) !important; color: #fff !important;
        padding: 14px !important; border-radius: 12px !important; border: none !important;
        font-weight: 700 !important; text-transform: uppercase !important; margin-top: 10px !important;
    }
</style>
@endsection

@section('main')
<!-- হেডার -->
<div class="app-header">
    <div class="tf-container">
        <div class="header-top">
            <a href="{{ route('user.index') }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
            <h3 class="header-title">কাস্টমারদের রিভিউ</h3>
        </div>
        <div class="scroll-pill-wrapper">
            <div class="info-scroll-pill">
                <div class="info-scroll-text">
                    আপনার মূল্যবান মতামত ভিডিও আকারে আপলোড করতে নিচের প্লাস (+) আইকনে ক্লিক করুন। ধন্যবাদ!
                </div>
            </div>
        </div>
    </div>
</div>

<div class="iso-review-page">
    <div class="review-container">
        <div class="action-bar">
            <a href="{{ route('reviews.view') }}" class="btn-filter {{ !request('filter') ? 'active' : '' }}">সকল রিভিউ</a>
            <a href="{{ route('reviews.view', ['filter' => 'my']) }}" class="btn-filter {{ request('filter') == 'my' ? 'active' : '' }}">আমার রিভিউ</a>
        </div>

        <!--<div class="search-wrap">-->
        <!--    <i class="fas fa-search search-icon"></i>-->
        <!--    <input type="text" id="searchInput" class="search-input" placeholder="শিরোনাম দিয়ে খুঁজুন...">-->
        <!--</div>-->

        <div id="reviewsContainer">
            @if($reviews->isNotEmpty())
                @foreach($reviews as $review)
                    <div class="review-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar-circle">
                                    <img src="{{ $review->user->image ? asset($review->user->image) : asset('images/avatar.png') }}" 
                                         onerror="this.src='{{ asset('images/avatar.png') }}'" alt="User">
                                </div>
                                <div>
                                    <h5 style="font-weight:800; margin:0; font-size:15px;">{{ $review->user->name ?? 'Unknown' }}</h5>
                                    <small class="text-muted"><i class="fas fa-globe me-1"></i> {{ $review->user->country->name ?? 'Global' }}</small>
                                </div>
                            </div>
                            
                            @if($authId == $review->user_id)
                            <div class="dropdown">
                                <button class="options-btn" onclick="toggleMenu({{ $review->id }})">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div id="menu-{{ $review->id }}" class="custom-dropdown">
                                    <a class="dropdown-item-c" href="#" data-bs-toggle="modal" data-bs-target="#editReviewModal{{ $review->id }}">
                                        <i class="fas fa-pen text-warning me-2"></i> এডিট করুন
                                    </a>
                                    <form action="{{ route('user.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('মুছে ফেলতে চান?');" style="margin:0;">
                                        @csrf @method('DELETE')
                                        <button class="dropdown-item-c delete" style="width:100%; text-align:left;">
                                            <i class="fas fa-trash-alt me-2"></i> ডিলিট করুন
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>

                        @if($review->video_path)
                        <div class="video-wrapper">
                            <div class="play-overlay" onclick="playVideo(this)">
                                <div class="play-icon-circle">
                                    <i class="fas fa-play" style="padding-left:4px;"></i>
                                </div>
                            </div>
                            <video controlsList="nodownload" oncontextmenu="return false;" preload="metadata">
                                <source src="{{ asset($review->video_path) }}#t=0.5" type="video/mp4">
                            </video>
                        </div>
                        @endif

                        <div>
                            <div class="review-title">{{ $review->title }}</div>
                            <div class="desc-wrapper" id="desc-wrapper-{{ $review->id }}" style="max-height: 42px; overflow: hidden; transition: 0.3s;">
                                <p class="review-desc">{{ $review->description }}</p>
                            </div>
                            @if(strlen($review->description) > 60)
                                <span class="see-more-link" onclick="toggleReadMore({{ $review->id }}, this)">আরও পড়ুন...</span>
                            @endif
                        </div>
                    </div>

                    <!-- এডিট মোডাল (ফিক্সড) -->
                    @if($authId == $review->user_id)
                    <div class="modal fade" id="editReviewModal{{ $review->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content custom-modal-content">
                                <div class="modal-header custom-modal-header">
                                    <h5 class="modal-title custom-modal-title">রিভিউ আপডেট</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body custom-modal-body">
                                    <form action="{{ route('user.reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf @method('PUT')
                                        <div class="iso-input-group">
                                            <label class="iso-label">শিরোনাম</label>
                                            <div class="iso-field-wrapper">
                                                <i class="fas fa-pen-nib iso-icon"></i>
                                                <input type="text" name="title" class="iso-input" value="{{ $review->title }}" required>
                                            </div>
                                        </div>
                                        <div class="iso-input-group">
                                            <label class="iso-label">মতামত</label>
                                            <div class="iso-field-wrapper">
                                                <i class="fas fa-comment-dots iso-icon iso-icon-top"></i>
                                                <textarea name="description" class="iso-input" rows="3" required>{{ $review->description }}</textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn-iso-save">আপডেট করুন</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                <div class="mt-4">{{ $reviews->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>
</div>

<button class="fab-btn" data-bs-toggle="modal" data-bs-target="#createReviewModal"><i class="fas fa-plus"></i></button>

<!-- নতুন রিভিউ মোডাল (ফিক্সড) -->
<div class="modal fade" id="createReviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title custom-modal-title">আমার রিভিউ</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body custom-modal-body">
                <form action="{{ route('user.reviews.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="iso-input-group">
                        <label class="iso-label">শিরোনাম</label>
                        <div class="iso-field-wrapper">
                            <i class="fas fa-pen-nib iso-icon"></i>
                            <input type="text" name="title" class="iso-input" placeholder="শিরোনাম লিখুন..." required>
                        </div>
                    </div>

                    <div class="iso-input-group">
                        <label class="iso-label">মতামত</label>
                        <div class="iso-field-wrapper">
                            <i class="fas fa-comment-dots iso-icon iso-icon-top"></i>
                            <textarea name="description" class="iso-input" rows="3" placeholder="বিস্তারিত লিখুন..." required></textarea>
                        </div>
                    </div>

                    <div class="iso-input-group">
                        <label class="iso-label">ভিডিও আপলোড (ঐচ্ছিক)</label>
                        <label class="iso-upload-box">
                            <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i><br>
                            <span class="text-muted small fw-bold" id="video-name">ভিডিও সিলেক্ট করুন</span>
                            <input type="file" name="video_path" class="d-none" accept="video/*" onchange="document.getElementById('video-name').innerText = this.files[0].name; document.getElementById('video-name').style.color = '#078e42';">
                        </label>
                    </div>

                    <button type="submit" class="btn-iso-save">সাবমিট করুন</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ১. ভিডিও লজিক
    function playVideo(overlay) {
        var wrapper = overlay.parentElement;
        var video = wrapper.querySelector('video');
        
        document.querySelectorAll('video').forEach(v => {
            if(v !== video) {
                v.pause();
                v.previousElementSibling.style.display = 'flex';
                v.removeAttribute('controls');
            }
        });

        overlay.style.display = 'none'; 
        video.setAttribute('controls', 'true'); 
        video.play();
    }

    document.querySelectorAll('video').forEach(video => {
        video.addEventListener('pause', function() {
            this.previousElementSibling.style.display = 'flex';
            this.controls = false;
        });
        video.addEventListener('ended', function() {
            this.previousElementSibling.style.display = 'flex';
            this.load(); 
        });
    });

    // ২. মেনু টগল
    function toggleMenu(id) {
        document.querySelectorAll('.custom-dropdown').forEach(el => {
            if(el.id !== 'menu-' + id) el.classList.remove('show');
        });
        var menu = document.getElementById('menu-' + id);
        menu.classList.toggle('show');
    }

    window.onclick = function(event) {
        if (!event.target.closest('.options-btn')) {
            document.querySelectorAll('.custom-dropdown').forEach(el => el.classList.remove('show'));
        }
    }

    // ৩. রিড মোর এবং সার্চ
    function toggleReadMore(id, btn) {
        const content = document.getElementById('desc-wrapper-' + id);
        if (content.style.maxHeight) {
            content.style.maxHeight = null;
            btn.innerText = "কম পড়ুন";
        } else {
            content.style.maxHeight = "42px";
            btn.innerText = "আরও পড়ুন...";
        }
    }

    document.getElementById('searchInput').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        let cards = document.querySelectorAll('.review-card');
        cards.forEach(card => {
            let text = card.innerText.toLowerCase();
            card.style.display = text.includes(val) ? "block" : "none";
        });
    });
</script>
@endsection