<!-- ====================================================
     PREMIUM HEADER - FIXED OVERLAP & POSITIONING
     ==================================================== -->

<div class="main-layout-header">
    <div class="container">
        <!-- TOP ROW: Logo & Icons -->
        <div class="top-header-content d-flex align-items-center justify-content-between py-2">
            
            <!-- Logo Section -->
            <div class="logo-area">
                <a href="{{ route('user.index') }}">
                    <img src="https://probasipay.com/logos/wise2.jpeg" alt="Logo" class="top-site-logo">
                </a>
            </div>

            <!-- Icons Area -->
            <div class="utility-actions">
                <ul class="nav-icon-list d-flex align-items-center gap-2 mb-0 list-unstyled">
                    
                    <li class="nav-icon-item">
                        <a href="#" id="enablePush" class="u-icon-link">
                            <i class='bx bx-bell'></i>
                            <span class="u-noti-dot shadow-sm">0</span>
                        </a>
                    </li>

                    <li class="nav-icon-item d-none d-md-block">
                        <a href="{{ route('user.index') }}" class="u-icon-link shadow-sm">
                            <i class='bx bx-world'></i>
                        </a>
                    </li>

                    <!-- FIXED PROFILE SECTION -->
                    <li class="nav-icon-item position-relative">
                        <!-- Profile Toggle -->
                        <div class="u-profile-pill" id="profileDropBtn" onclick="toggleUserDropdown(event)">
                            <div class="avatar-container">
                                <img src="{{ asset(auth()->user()->image) }}" alt="User" class="u-avatar">
                                <span class="online-status-pulse"></span>
                            </div>
                            <div class="user-text d-none d-lg-block ms-1">
                                <span class="u-name-top">{{ auth()->user()->name }}</span>
                                
                            </div>
                            <i class='bx bx-chevron-down u-arrow ms-1'></i>
                        </div>
                        
                        <!-- Fixed Position Dropdown List -->
                        <div class="custom-profile-dropdown" id="userDropdownContent">
                            <div class="pd-header py-3 px-3 border-bottom text-center">
                                <div class="avatar-lg-wrap mb-2 mx-auto">
                                    <img src="{{ asset(auth()->user()->image) }}" alt="Large User">
                                    <span class="indicator-fixed"></span>
                                </div>
                                <h6 class="m-0 fw-bold text-dark">{{ auth()->user()->name }}</h6>
                                <p class="small text-muted mb-0">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="pd-body py-2">
                                <a class="pd-item" href="{{ route('profile') }}"><i class='bx bx-user-pin'></i> My Profile</a>
                                <form action="{{ route('logout') }}" method="post" class="m-0 p-0">
                                    @csrf
                                    <button type="submit" class="pd-item text-danger border-0 w-100 text-start bg-transparent">
                                        <i class='bx bx-power-off'></i> Sign Out
                                    </button>
                                    <button type="button" class="pd-item border-0 w-100 text-start bg-transparent" id="profileMenuBtn">
                                        <i class='bx bx-menu'></i> Menu
                                    </button>

                                    
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="h-divider-line"></div>

        <!-- 3. ADMIN MENU (INTEGRATED) -->
        <div class="bottom-menu-area">
             @include('backend.adminLayout.menu')
        </div>
    </div>
</div>

<style>
    /* 1. Header and Overlay Fix */
    .main-layout-header {
        background: #ffffff;
        position: relative;
        z-index: 9999;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .top-site-logo { max-height: 44px; border-radius: 6px; }

    /* 2. Utility Buttons */
    .u-icon-link {
        width: 38px; height: 38px; background: #f3f6f9; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #444; font-size: 19px; text-decoration: none; position: relative;
    }
    .u-noti-dot {
        position: absolute; top: 0; right: 0; background: #ff4757; color: white;
        font-size: 10px; font-weight: bold; padding: 1px 4px; border-radius: 50%; border: 1.5px solid #fff;
    }

    /* 3. Fixed Profile Pillar & Indicator */
    .u-profile-pill {
        display: flex; align-items: center; background: #f8fafc; padding: 4px 10px 4px 4px;
        border-radius: 50px; border: 1px solid #eef2f6; cursor: pointer; position: relative;
    }
    .avatar-container { position: relative; display: inline-flex; }
    .u-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; }
    .online-status-pulse {
        position: absolute; bottom: 0; right: 1px; width: 10px; height: 10px;
        background: #22c55e; border-radius: 50%; border: 2.5px solid #fff;
    }

    /* Pulse effect (Optional premium feel) */
    .online-status-pulse::before {
        content: ''; position: absolute; top:0; left:0; width:100%; height:100%; border-radius: 50%;
        background-color: #22c55e; animation: statuspulse 2s infinite ease-out;
    }
    @keyframes statuspulse { 0% { transform: scale(1); opacity: 0.8; } 100% { transform: scale(2.8); opacity: 0; } }

    /* 4. ABSOLUTELY FIXED DROPDOWN POSITION */
    .custom-profile-dropdown {
        position: absolute;
        top: 50px; /* ঠিক প্রোফাইল বাটনের নিচ থেকে */
        right: 0;
        width: 240px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.18);
        border: 1px solid #f1f1f1;
        display: none; /* Initially hide */
        z-index: 10001; /* যাতে কেউ একে ওভারল্যাপ না করতে পারে */
        animation: dropSlide 0.2s ease-out;
    }

    @keyframes dropSlide {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Dropdown Show state */
    .show-custom-menu { display: block !important; }

    /* Dropdown Internal Elements */
    .avatar-lg-wrap { width: 55px; height: 55px; position: relative; }
    .avatar-lg-wrap img { width: 100%; height: 100%; border-radius: 50%; border: 2px solid #007bff; }
    .indicator-fixed {
        position: absolute; bottom: 2px; right: 2px; width: 12px; height: 12px;
        background: #22c55e; border: 2px solid #fff; border-radius: 50%;
    }
    
    .pd-item {
        padding: 10px 18px; color: #334155; text-decoration: none; display: flex;
        align-items: center; gap: 10px; font-weight: 500; font-size: 14.5px;
    }
    .pd-item:hover { background: #f8f9fb; color: #007bff; }
    .pd-item i { font-size: 18px; }

    /* Fix Layout Issue on Header Area */
    .h-divider-line { height: 1px; background: #eef2f6; width: 100%; }
    
    
</style>


<script>
    function toggleUserDropdown(event) {
        event.stopPropagation(); 
        const dropdownMenu = document.getElementById('userDropdownContent');
        dropdownMenu.classList.toggle('show-custom-menu');
    }

    window.onclick = function(event) {
        if (!event.target.closest('.u-profile-pill')) {
            const dropdown = document.getElementById('userDropdownContent');
            if (dropdown && dropdown.classList.contains('show-custom-menu')) {
                dropdown.classList.remove('show-custom-menu');
            }
        }
    }
    
    const profileMenuBtn = document.getElementById('profileMenuBtn');

    if (profileMenuBtn) {
        profileMenuBtn.onclick = function () {
            navMenu.classList.add('menu-open');
            navBodyOverlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        };
    }
</script>