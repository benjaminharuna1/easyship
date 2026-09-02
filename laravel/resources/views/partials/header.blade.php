<!--Start Main Header One -->
<header class="main-header main-header-one style4">
    <div id="sticky-header" class="menu-area">
        <div class="container">
            <div class="main-header-one__inner">

                <div class="main-header-style4__left">
                    <div class="logo-box-one">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset($settings->site_logo ?? '') }}" alt="Logo">
                        </a>
                    </div>
                </div>

                <div class="main-header-style4__middle">
                    <div class="menu-area__inner">
                        <div class="mobile-nav-toggler">
                            <i class="fas fa-bars"></i>
                        </div>
                        <div class="menu-wrap">
                            <nav class="menu-nav">
                                <div class="navbar-wrap main-menu">
                                    <ul class="navigation">
                                        <li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                                        <li class="{{ request()->routeIs('about') ? 'active' : '' }}"><a href="{{ route('about') }}">About Us</a></li>
                                        <li class="{{ request()->routeIs('services') ? 'active' : '' }}"><a href="{{ route('services') }}">Services</a></li>
                                        <li class="{{ request()->routeIs('track*') ? 'active' : '' }}"><a href="{{ route('track') }}">Track</a></li>
                                        <li class="{{ request()->routeIs('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">contact</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>

                    <div class="main-menu-right-box-one">
                        <div class="search-box-one">
                            <a href="#" class="main-menu__search search-toggler">
                                <span class="icon-search-interface-symbol"></span>
                            </a>
                        </div>
                        <div class="side-content-button-one">
                            <a class="menu-tigger" href="#">
                                <span class="line"></span>
                                <span class="line two"></span>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="main-header-style4__right">
                    <div class="contact-box">
                        <div class="icon">
                            <span class="icon-phone-call-1"></span>
                        </div>
                        <div class="text-box">
                            <p>Need Assistance?</p>
                            <h4><a href="tel:{{ $settings->phone_number }}">{{ $settings->phone_number }}</a></h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!--Start Mobile Menu -->
    <div class="mobile-menu">
        <nav class="menu-box">
            <div class="close-btn"><i class="fas fa-times"></i></div>
            <div class="nav-logo">
                <a href="{{ route('home') }}"><img src="{{ asset($settings->site_logo ?? '') }}" alt="Logo"></a>
            </div>
            <div class="menu-outer">
            </div>
        </nav>
    </div>
    <div class="menu-backdrop"></div>
    <!-- End Mobile Menu -->
</header>
<!--End Main Header One -->
