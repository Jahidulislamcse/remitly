@php
    $admin = auth()->user();
@endphp


<header class="dashboard__header">
    <div class="dashboard__header-left">
        <span class="breadcrumb-icon navigation-bar"><i class="fa-solid fa-bars"></i></span>
        <div class="header-search__input">
            <label for="desktop-search-input" class="header-search__icon open-search">
                <x-admin.svg.search />
            </label>
            <label for="desktop-search-input">
                <input type="search" id="desktop-search-input" placeholder="@lang('Search')...."
                    class="desktop-search header-search-filed open-search" autocomplete="false">
                <span class="search-instruction flex-align gap-2">
                    <span class="instruction__icon esc-text fw-bold">@lang('Ctrl')</span>
                    <span class="instruction__icon esc-text fw-bold">@lang('K')</span>
                </span>
            </label>

        </div>
    </div>
    <div class="dashboard-info flex-align gap-sm-2 gap-1">
        <div class="header-dropdown">
            <a class="header-dropdown__icon" href="{{ route('user.index') }}" target="_blank" data-bs-toggle="tooltip"
                title="@lang('Go to Website')">
                <i class="las la-globe"></i>
            </a>
        </div>
        <div class="dashboard-quick-link header-dropdown">
            <button class="header-dropdown__icon dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
                <span data-bs-toggle="tooltip" title="@lang('Quick Link')">
                    <i class="las la-link"></i>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <div class="quick-link-list">
                    <a href="#" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-money-check-alt"></i>
                        </span>
                        <span class="quick-link-item__name">
                            @lang('Pending Add Money')
                        </span>
                    </a>


                    <a href="#" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-hand-holding-usd"></i>
                        </span>
                        <span class="quick-link-item__name">
                            @lang('Pending Withdrawals')
                        </span>
                    </a>


                    <a href="#" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="la la-ticket"></i>
                        </span>
                        <span class="quick-link-item__name">
                            @lang('Pending Ticket')
                        </span>
                    </a>

                    <a href="#" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-cogs"></i>
                        </span>
                        <span class="quick-link-item__name">@lang('General Setting')</span>
                    </a>

                    <a href="#" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-tools"></i>
                        </span>
                        <span class="quick-link-item__name">@lang('System Configuration')</span>
                    </a>

                    <a href="#" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-bell"></i>
                        </span>
                        <span class="quick-link-item__name">@lang('Notification Setting')</span>
                    </a>

                    <a href="#" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-users"></i>
                        </span>
                        <span class="quick-link-item__name">@lang('All User')</span>
                    </a>
                    <a href="#" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-user-check"></i>
                        </span>
                        <span class="quick-link-item__name">@lang('Active User')</span>
                    </a>
                    <a href="#" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-user-slash"></i>
                        </span>
                        <span class="quick-link-item__name">@lang('Banned User')</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="language-dropdown header-dropdown">
            <button class="header-dropdown__icon dropdown-toggle " data-bs-toggle="dropdown">
                <span data-bs-toggle="tooltip" title="@lang('Language')">
                    <i class="las la-language"></i>
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li class="dropdown-menu__item  align-items-center gap-2 justify-content-between langSel"
                    data-code="en">
                    <div class=" d-flex flex-wrap align-items-center gap-2">
                        <span class="language-dropdown__icon">
                            <img src="">
                        </span>
                        English
                    </div>
                    <span class="text--success">
                        <i class="las la-check-double"></i>
                    </span>
                </li>
            </ul>
        </div>
        <div class="header-dropdown">
            <button class=" dropdown-toggle header-dropdown__icon" type='button' data-bs-toggle="tooltip"
                title="@lang('Theme')" id="switch-theme">
                <span class=" dark-show">
                    <i class="las la-moon"></i>
                </span>
                <span class=" light-show">
                    <i class="las la-sun"></i>
                </span>
            </button>
        </div>
        <div class="notification header-dropdown">
            <button class="dropdown-toggle header-dropdown__icon" data-bs-toggle="dropdown" aria-expanded="false"
                data-bs-auto-close="outside">
                <span data-bs-toggle="tooltip" title="@lang('Notification')">
                    <i class="las la-bell"></i>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end notification__area">
                <div class="notification__header p-3">
                    <h4 class="notification__header-text">@lang('Notifications')</h4>
                </div>
                <div class="top-notification__body">
                    <ul class="notification__items">
                        <li class="p-3">
                            <div class="p-5 text-center">
                                <img src="{{ asset('assets/images/empty_box.png') }}" class="empty-message">
                                <span class="d-block">@lang('No unread notifications were found')</span>
                                <span class="d-block fs-13 text-muted">@lang('There is no available data to display here at the moment')</span>
                            </div>
                        </li>
                    </ul>
                </div>
                @if (false)
                    <div class="notification__footer p-3">
                        <a href="#" class="btn btn--primary btn-large  w-100">
                            @lang('View All Notification')
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="dashboard-header-user">
            <button class="header-dropdown__icon" data-bs-toggle="dropdown" aria-expanded="false">
                <span data-bs-toggle="tooltip" title="@lang('Profile')">
                    <i class="las la-user"></i>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end user__area">
                <div class="user__header">
                    <a href="#" class="user__info">
                        <div class="user__thumb">
                            <img src="">
                        </div>
                        <div class="user__details">
                            <h6 class="user__name">Admin</h6>
                            <p class="user__roll">@lang('Admin')</p>
                        </div>
                    </a>
                </div>
                <div class="user__body">
                    <nav class="user__link">
                        <a href="#" class="user__link-item">
                            <span class="user__link-item-icon">
                                <i class="las la-user-alt"></i>
                            </span>
                            <span class="user__link-item-text">@lang('My Profile')</span>
                        </a>
                        <a href="#" class="user__link-item">
                            <span class="user__link-item-icon">
                                <i class="las la-lock-open"></i>
                            </span>
                            <span class="user__link-item-text">@lang('Change Password')</span>
                        </a>
                    </nav>
                </div>
                <div class="user__footer">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn--danger">
                            <span class="btn--icon">
                                <i class="fas fa-sign-out text--danger"></i>
                            </span>
                            @lang('Logout')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
