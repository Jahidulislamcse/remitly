 <!-- Top Header Area -->
 <div class="container">
    <header class="top-header-area top-menu-header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="left-side-content-area d-flex align-items-center">
                <!-- Top Logo -->
                <div class="top-logo">
                    <a href="{{ route('user.index') }}"><img src="{{ asset(@siteInfo()->logo) }}" alt="{{ @siteInfo()->company_name }}"></a>
                </div>

                {{-- <!-- Left Side Nav -->
                <ul class="left-side-navbar d-flex align-items-center">
                    <li class="hide-phone app-search">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="bx bx-search-alt"></span>
                    </li>
                </ul> --}}
            </div>

            <div class="right-side-navbar d-flex align-items-center justify-content-end">
                <!-- Mobile Trigger -->
                <div class="right-side-trigger me-0" id="rightSideTrigger">
                    <i class='bx bx-menu-alt-right'></i>
                </div>

                <!-- Top Bar Nav -->
                <ul class="right-side-content d-flex align-items-center">
              
                    <li class="nav-item dropdown">
                        <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><img src="{{ asset(auth()->user()->image) }}"
                                alt=""></button>
                        <div class="dropdown-menu profile dropdown-menu-right">
                            <!-- User Profile Area -->
                            <div class="user-profile-area">
                                <a href="{{ route('profile') }}" class="dropdown-item"><i class="bx bx-user font-15"
                                        aria-hidden="true"></i>
                                    My profile</a>
                             <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" href="#" class="dropdown-item"><i class="bx bx-power-off font-15"
                                    aria-hidden="true"></i> Sign-out</button>
                             </form>
                              
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-top my-3"></div>

        <!-- Classy Nav -->
       @include('admin.layout.menu')
    </header>
</div>