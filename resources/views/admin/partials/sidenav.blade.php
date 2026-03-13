<aside class="dashboard__sidebar sidebar-menu">
    <div class="dashboard__sidebar-area">
        <div class="dashboard__sidebar-header">
            <span class="sidebar-menu__close header-dropdown__icon">
                <i class="las la-angle-double-left"></i>
            </span>
        </div>

        <div class="dashboard__sidebar-inner">
            <ul class="dashboard-nav ps-0">

                <li class="dashboard-nav__items">
                    <a href="{{ route('super.admin.dashboard') }}" 
                       class="dashboard-nav__link {{ Request::routeIs('super.admin.dashboard') ? 'menu-active' : '' }}">
                        <i class="las la-home"></i>
                        <span class="dashboard-nav__link-text">Home</span>
                    </a>
                </li>

                @if(auth()->user()->role == 'super admin')

                <li class="dashboard-nav__items">
                    <a href="{{ route('topup.list') }}" class="dashboard-nav__link">
                        <i class="las la-arrow-down"></i>
                        <span class="dashboard-nav__link-text">Deposits</span>
                    </a>
                </li>

                <li class="dashboard-nav__items">
                    <a href="{{ route('recharge.list') }}" class="dashboard-nav__link">
                        <i class="las la-sync-alt"></i>
                        <span class="dashboard-nav__link-text">Recharge</span>
                    </a>
                </li>

                <!-- Withdraw -->
                <li class="dashboard-nav__items has-dropdown">
                    <a href="javascript:void(0)" class="dashboard-nav__link">
                        <i class="las la-arrow-up"></i>
                        <span class="dashboard-nav__link-text">Withdraw</span>
                    </a>

                    <ul class="dashboard-nav sidebar-submenu">

                        <li class="dashboard-nav__items">
                            <a href="{{ route('bankpay.list') }}" class="dashboard-nav__link">
                                <i class="las la-university"></i>
                                <span class="dashboard-nav__link-text">Bank</span>
                            </a>
                        </li>

                        <li class="dashboard-nav__items">
                            <a href="{{ route('mobilebank.list', ['operator' => 'bkash']) }}" class="dashboard-nav__link">
                                 <i class="las la-mobile-alt"></i>
                                <span class="dashboard-nav__link-text">Mobile Bank</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="dashboard-nav__items">
                    <a href="{{ route('billpay.list') }}" class="dashboard-nav__link">
                        <i class="las la-file-invoice-dollar"></i>
                        <span class="dashboard-nav__link-text">Bill Pay</span>
                    </a>
                </li> --}}

                <li class="dashboard-nav__items">
                    <a href="{{ route('remittance.list') }}" class="dashboard-nav__link">
                        <i class="las la-paper-plane"></i>
                        <span class="dashboard-nav__link-text">Remittance</span>
                    </a>
                </li>

                <li class="dashboard-nav__items">
                    <a href="{{ route('user.list') }}" class="dashboard-nav__link">
                        <i class="las la-users"></i>
                        <span class="dashboard-nav__link-text">Customers</span>
                    </a>
                </li>

                <li class="dashboard-nav__items">
                    <a href="{{ route('admin.users.create') }}" class="dashboard-nav__link">
                        <i class="las la-user-plus"></i>
                        <span class="dashboard-nav__link-text">Create User</span>
                    </a>
                </li>

                <li class="dashboard-nav__items">
                    <a href="{{ route('notifications.index') }}" 
                       class="dashboard-nav__link {{ Request::routeIs('notifications.index') ? 'menu-active' : '' }}">
                        <i class="las la-bell"></i>
                        <span class="dashboard-nav__link-text">Notification</span>
                    </a>
                </li>

                <li class="dashboard-nav__items">
                    <a href="{{ route('admin.chat.links') }}" 
                       class="dashboard-nav__link {{ Request::routeIs('admin.chat.links') ? 'menu-active' : '' }}">
                        <i class="las la-link"></i>
                        <span class="dashboard-nav__link-text">Link</span>
                    </a>
                </li>

                <!-- Chat -->
                <li class="dashboard-nav__items has-dropdown">
                    <a href="javascript:void(0)" class="dashboard-nav__link">
                        <i class="las la-comments"></i>
                        <span class="dashboard-nav__link-text">Chat</span>
                    </a>

                    <ul class="dashboard-nav sidebar-submenu">
                        <li class="dashboard-nav__items">
                            <a href="{{ route('chat.admin') }}" class="dashboard-nav__link">
                                Pending Message
                            </a>
                        </li>
                        <li class="dashboard-nav__items">
                            <a href="{{ route('create-chat') }}" class="dashboard-nav__link">
                                Create Message
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Settings -->
                <li class="dashboard-nav__items has-dropdown">
                    <a href="javascript:void(0)" class="dashboard-nav__link">
                        <i class="las la-cog"></i>
                        <span class="dashboard-nav__link-text">Setting</span>
                    </a>

                    <ul class="dashboard-nav sidebar-submenu">
                        <li><a href="{{ route('mobilebanking') }}" class="dashboard-nav__link"><i class="las la-mobile-alt"></i> Mobile Banking</a></li>
                        <li><a href="{{ route('bank') }}" class="dashboard-nav__link"><i class="las la-university"></i> Bank Account</a></li>
                        <li><a href="{{ route('admin.payable_accounts.index') }}" class="dashboard-nav__link"><i class="las la-money-bill-wave"></i> Payable Accounts</a></li>
                        <li><a href="{{ route('admin.commission.index') }}" class="dashboard-nav__link"><i class="las la-percent"></i> Commissions</a></li>
                        <li><a href="{{ route('country') }}" class="dashboard-nav__link"><i class="las la-globe"></i> Country / Rate</a></li>
                        <li><a href="{{ route('slider') }}" class="dashboard-nav__link"><i class="las la-images"></i> Slider</a></li>
                        {{-- <li><a href="{{ route('page') }}" class="dashboard-nav__link"><i class="las la-file-alt"></i> Content</a></li> --}}
                        <li><a href="{{ route('setting.general') }}" class="dashboard-nav__link"><i class="las la-sliders-h"></i> General Setting</a></li>
                        <li><a href="{{ route('review.upload') }}" class="dashboard-nav__link"><i class="las la-star"></i> Reviews</a></li>
                        <li><a href="{{ route('admin.banners.index') }}" class="dashboard-nav__link"><i class="las la-image"></i> Banners</a></li>
                        <li><a href="{{ route('admin.colors.index') }}" class="dashboard-nav__link"><i class="las la-palette"></i> Color Setting</a></li>
                        <li><a href="{{ route('guides.index') }}" class="dashboard-nav__link"><i class="las la-book"></i> App Guide</a></li>
                    </ul>
                </li>

                @endif

            </ul>
        </div>
    </div>
</aside>