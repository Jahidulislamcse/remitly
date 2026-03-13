<!-- ====================================================
     MODERN ADMIN NAV - FULL RE-DESIGN (NO BOOTSTRAP)
     ==================================================== -->

<div class="header-nav-section">
    <!-- Main Top Bar -->
    <div class="nav-flex-wrapper">
        
        <!-- Middle/Right Side: Links -->
        <nav class="desktop-navigation" id="mainNav">
            <!-- Mobile Close Button -->
            <div class="mobile-close-btn" id="closeMenu">&times;</div>
            
            <ul class="nav-links-list">
                <li><a href="{{ route('user.index') }}" class="{{ Request::routeIs('user.index') ? 'nav-active' : '' }}">Home</a></li>

                @if (auth()->user()->role == 'super admin')
                    <li><a href="{{ route('topup.list') }}">Deposits</a></li>
                    <li><a href="{{ route('recharge.list') }}">Recharge</a></li>
                    
                    <li class="nav-has-child">
                        <a href="javascript:void(0)" class="nav-link-item">Withdraw <i class="fa fa-angle-down arrow-ic"></i></a>
                        <ul class="nav-dropdown-menu">
                            <li><a href="{{ route('bankpay.list') }}">Bank</a></li>
                            <li class="nav-has-child">
                                <a href="javascript:void(0)" class="nav-link-item">Mobile Bank <i class="fa fa-angle-right arrow-ic"></i></a>
                                <ul class="nav-dropdown-menu sub-sub">
                                    {{-- <li><a href="{{ route('bkash.list') }}">Bkash</a></li>
                                    <li><a href="{{ route('nagad.list') }}">Nagad</a></li>
                                    <li><a href="{{ route('rocket.list') }}">Rocket</a></li>
                                    <li><a href="{{ route('upay.list') }}">Upay</a></li> --}}
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li><a href="{{ route('billpay.list') }}">Bill Pay</a></li>
                    <li><a href="{{ route('remittance.list') }}">Remittance</a></li>
                    <li><a href="{{ route('user.list') }}">Customers</a></li>
                    <li><a href="{{ route('notifications.index') }}" class="{{ Request::routeIs('notifications.index') ? 'nav-active' : '' }}">Notification</a></li>
                    
                     <!--[ADDED] Guest Link Section -->
                    <li><a href="{{ route('admin.chat.links') }}" class="{{ Request::routeIs('admin.chat.links') ? 'nav-active' : '' }}">Link</a></li>

                    <li class="nav-has-child">
                        <a href="javascript:void(0)" class="nav-link-item">Chat <i class="fa fa-angle-down arrow-ic"></i></a>
                        <ul class="nav-dropdown-menu">
                            <li><a href="{{ route('chat.admin') }}">Pending Messege</a></li>
                            <li><a href="{{ route('create-chat') }}">Create Messege</a></li>
                        </ul>
                    </li>

                    <li class="nav-has-child">
                        <a href="javascript:void(0)" class="nav-link-item">Setting <i class="fa fa-angle-down arrow-ic"></i></a>
                        <ul class="nav-dropdown-menu nav-scrollable">
                            <li><a href="{{ route('mobilebanking') }}">Mobile Banking</a></li>
                            <li><a href="{{ route('bank') }}">Bank Account</a></li>
                            <li><a href="{{ route('admin.payable_accounts.index') }}">Payable Accounts</a></li>
                            <li><a href="{{ route('admin.commission.index') }}">Commissions</a></li>
                            <li><a href="{{ route('country') }}">Country / Rate</a></li>
                            <li><a href="{{ route('slider') }}">Slider</a></li>
                            <li><a href="{{ route('page') }}">Content</a></li>
                            <li><a href="{{ route('setting.general') }}">General Setting</a></li>
                            <li><a href="{{ route('review.upload') }}">Reviews</a></li>
                            <li><a href="{{ route('admin.banners.index') }}">Banners</a></li>
                            <li><a href="{{ route('admin.colors.index') }}">Color Setting</a></li>
                            <li><a href="{{ route('guides.index') }}">App Guide</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>

        <!-- Right Side: Hamburger Icon (Visible on Mobile) -->
        <div class="mobile-toggler-icon" id="openMenu">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</div>

<!-- Dark Overlay for Mobile Lock -->
<div class="nav-body-overlay" id="navBodyOverlay"></div>

<!-- CSS STYLES -->
<style>
.header-nav-section {
    background: #fff;
    padding: 0 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.06);
    position: sticky;
    top: 0;
    z-index: 999;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.nav-flex-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1400px;
    margin: 0 auto;
    height: 70px;
}

.nav-links-list {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
}
.nav-links-list > li { position: relative; }

.nav-links-list > li > a,
.nav-link-item {
    color: #444;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    padding: 25px 12px;
    display: block;
}

/* অ্যাক্টিভ কালার হিসেবে নীল রাখা হয়েছে তোমার দেওয়া সিএসএস অনুযায়ী */
.nav-links-list > li:hover > a,
.nav-active {
    color: #007bff !important;
}

.arrow-ic {
    font-size: 11px;
    margin-left: 3px;
}

.nav-dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    min-width: 220px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    list-style: none;
    padding: 10px 0;
    display: none;
    border-radius: 0 0 8px 8px;
    border-top: 3px solid #007bff;
}

.nav-has-child:hover > .nav-dropdown-menu { display: block; }

.nav-dropdown-menu li a {
    padding: 12px 20px;
    color: #555;
    font-size: 14px;
    display: block;
    text-decoration: none;
}

.nav-dropdown-menu li a:hover {
    background: #f8f9fa;
    color: #007bff;
    padding-left: 25px;
}

.sub-sub {
    top: 0;
    left: 100%;
    border-top: none;
    border-left: 3px solid #007bff;
    border-radius: 0 8px 8px 0;
}

.nav-scrollable {
    max-height: 380px;
    overflow-y: auto;
}

.mobile-toggler-icon,
.mobile-close-btn {
    display: none;
}

.nav-body-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 998;
    display: none;
}

@media (max-width: 991px) {
    .mobile-toggler-icon {
        display: block;
        font-size: 24px;
        cursor: pointer;
        color: #333;
    }

    .desktop-navigation {
        position: fixed;
        top: 0;
        right: -280px;
        width: 280px;
        height: 100%;
        background: #fff;
        z-index: 1000;
        transition: 0.3s;
        padding-top: 50px;
        overflow-y: auto;
    }

    .desktop-navigation.menu-open {
        right: 0;
    }

    .nav-body-overlay.show {
        display: block;
    }

    .mobile-close-btn {
        display: block;
        position: absolute;
        top: 15px;
        left: 15px;
        font-size: 30px;
        cursor: pointer;
        color: #666;
    }

    .nav-links-list {
        flex-direction: column;
    }

    .nav-links-list > li > a,
    .nav-link-item {
        padding: 15px 20px;
        border-bottom: 1px dotted #eee;
    }

    .nav-dropdown-menu,
    .sub-sub {
        position: static;
        box-shadow: none;
        border: none;
        background: #fcfcfc;
        display: none;
    }

    .nav-has-child.mob-open > .nav-dropdown-menu {
        display: block;
    }
}
</style>

<!-- JS Logic -->
<script>
    const navMenu = document.getElementById('mainNav');
    const openMenuBtn = document.getElementById('openMenu');
    const closeMenuBtn = document.getElementById('closeMenu');
    const navBodyOverlay = document.getElementById('navBodyOverlay');

    openMenuBtn.onclick = function() {
        navMenu.classList.add('menu-open');
        navBodyOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    };

    const hideSidebar = () => {
        navMenu.classList.remove('menu-open');
        navBodyOverlay.classList.remove('show');
        document.body.style.overflow = 'auto';
    };

    closeMenuBtn.onclick = hideSidebar;
    navBodyOverlay.onclick = hideSidebar;

    document.querySelectorAll('.nav-has-child > .nav-link-item').forEach(link => {
        link.addEventListener('click', function (e) {
            if (window.innerWidth < 992) {
                e.preventDefault();
                e.stopPropagation();
                const parentLi = this.parentElement;
                parentLi.classList.toggle('mob-open');
                const siblings = Array.from(parentLi.parentElement.children).filter(li => li !== parentLi);
                siblings.forEach(li => {
                    li.classList.remove('mob-open');
                });
            }
        });
    });
</script>