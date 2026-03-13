<!-- Classy Nav -->
<div class="classy-nav-container breakpoint-off">
    <nav class="classy-navbar justify-content-between" id="classyNav">
        <div class="classy-navbar-toggler">
            <i class="fa fa-bars me-2" aria-hidden="true"></i>
            <span>Menu</span>
        </div>

        <div class="classy-menu">
            <div class="classycloseIcon">
                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
            </div>

            <!-- Nav Start -->
            <div class="classynav">


                <ul>
                    <li><a href="{{ route('index') }}">Home</a></li>

                    
                   @if(auth()->user()->role == 'super admin')

                    <li><a href="#">Order</a>
                        <ul class="dropdown">

                            <li class="{{ Request::routeIs('order.index') ? 'active' : '' }}"><a  href="{{ route('order.index') }}">Order</a>
                            <li class="{{ Request::routeIs('order.delivered') ? 'active' : '' }}"><a  href="{{ route('order.delivered') }}">Delivered Order</a>
                            <li class="{{ Request::routeIs('order.cancel') ? 'active' : '' }}"><a  href="{{ route('order.cancel') }}">Cancel Order</a>
                            
                        </ul>
                    </li>
                    
                     <li><a href="{{ route('user.list') }}">Customers</a> </li>
                     <li><a href="{{ route('announce') }}">Announcement</a> </li>
                  
                    <li><a href="#">Setting</a>
                        <ul class="dropdown">
                         
                            <li class="{{ Request::routeIs('setting.general') ? 'active' : '' }}">
                                <a href="{{ route('setting.general') }}">Genral Setting</a>
                            </li>
                          

                        </ul>
                    </li>

                    @else
                    <li><a href="{{  route('order.now') }}">Order Now</a></li>
                <li><a href="{{  route('order.index') }}">Order History</a></li>
                <li><a href="{{  route('contact') }}">Contact us</a></li>

                    @endif

                    
                  
                </ul>

              
            </div>
        </div>
    </nav>
</div>