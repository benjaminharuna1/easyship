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
                        <div class="side-content-button-one">
                            <a class="menu-tigger" href="#">
                                <span class="line"></span>
                                <span class="line two"></span>
                            </a>
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

<style>
    /* Hide the offcanvas trigger by default; it is only for the desktop offcanvas */
    .main-header-style4__middle .side-content-button-one {
        display: none;
    }
    @media (max-width: 991.98px) {
        /* Show the hamburger that opens the slide-in mobile menu */
        .main-header-style4__middle .mobile-nav-toggler {
            display: flex !important;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            background: var(--thm-primary, #f6a400);
            color: #fff;
            border-radius: 6px;
            font-size: 22px;
            cursor: pointer;
        }
        /* Hide the desktop offcanvas trigger on mobile so only one hamburger shows */
        .main-header-style4__middle .side-content-button-one {
            display: none !important;
        }
    }
</style>
