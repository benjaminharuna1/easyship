<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') | {{ $settings->sitename ?? 'EasyShip' }}</title>
    <link rel="icon" href="{{ asset($settings->site_favicon ?? 'uploads/favicon.png') }}" type="image/png" />
    <link href="{{ asset('admin-assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin-assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin-assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin-assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin-assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('admin-assets/js/pace.min.js') }}"></script>
    <link href="{{ asset('admin-assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('admin-assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-assets/css/icons.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

    <style>
        /* Style for the desktop sidebar collapse/expand button */
        .sidebar-collapse-trigger {
            font-size: 22px;
            cursor: pointer;
            color: #ffffff;
            line-height: 1;
            background: transparent;
            border: 0;
            padding: 0;
        }
        /* Keep the desktop collapse button visible even when the sidebar is collapsed,
           so the user can always restore it. */
        .wrapper.toggled:not(.sidebar-hovered) .sidebar-wrapper .sidebar-header .sidebar-collapse-trigger {
            display: inline-flex !important;
        }
        .wrapper.toggled:not(.sidebar-hovered) .sidebar-wrapper .sidebar-header {
            justify-content: center !important;
        }
        /* Mobile: the slide-in sidebar should sit above the overlay */
        .sidebar-overlay {
            cursor: pointer;
        }
        @media (min-width: 1025px) {
            .wrapper.toggled .topbar,
            .wrapper.toggled .page-wrapper,
            .wrapper.toggled .page-footer {
                left: 70px;
            }
            .wrapper.toggled .page-wrapper {
                margin-left: 70px;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-theme bg-theme1">
    <div class="wrapper">
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="{{ asset($settings->site_logo ?? '') }}" class="logo-icon" alt="logo" style="height:38px; width:auto;">
                </div>
                <div class="ms-auto sidebar-collapse-trigger"><i class='bx bx-arrow-back'></i>
                </div>
            </div>

            <ul class="metismenu" id="menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <div class="parent-icon"><i class='bx bx-home-alt'></i></div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.shipments.create') }}" class="{{ request()->routeIs('admin.shipments.create') ? 'active' : '' }}">
                        <div class="parent-icon"><i class='bx bx-message-square-edit'></i></div>
                        <div class="menu-title">Add Tracking</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.shipments.list') }}" class="{{ request()->routeIs('admin.shipments.list') ? 'active' : '' }}">
                        <div class="parent-icon"><i class='bx bx-list-ul'></i></div>
                        <div class="menu-title">Shipments</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.profile') }}" class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                        <div class="parent-icon"><i class="bx bx-user-circle"></i></div>
                        <div class="menu-title">Profile</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <div class="parent-icon"><i class="bx bx-cog fs-5"></i></div>
                        <div class="menu-title">Site Setting</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.email.test-form') }}" class="{{ request()->routeIs('admin.email.test-form') ? 'active' : '' }}">
                        <div class="parent-icon"><i class="bx bx-mail-send fs-5"></i></div>
                        <div class="menu-title">Test Email</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.email.send-form') }}" class="{{ request()->routeIs('admin.email.send-form') ? 'active' : '' }}">
                        <div class="parent-icon"><i class="bx bx-envelope fs-5"></i></div>
                        <div class="menu-title">Send Email</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.support') }}" class="{{ request()->routeIs('admin.support') ? 'active' : '' }}">
                        <div class="parent-icon"><i class="bx bx-support fs-5"></i></div>
                        <div class="menu-title">Support Messages</div>
                    </a>
                </li>

                <li class="menu-label">Site Content</li>

                <li>
                    <a href="{{ route('admin.testimonials.index') }}" class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                        <div class="parent-icon"><i class="bx bx-comment-detail fs-5"></i></div>
                        <div class="menu-title">Testimonials</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.team.index') }}" class="{{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                        <div class="parent-icon"><i class="bx bx-user-pin fs-5"></i></div>
                        <div class="menu-title">Team</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <div class="parent-icon"><i class="bx bx-briefcase fs-5"></i></div>
                        <div class="menu-title">Services</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.legal') }}" class="{{ request()->routeIs('admin.legal') ? 'active' : '' }}">
                        <div class="parent-icon"><i class="bx bx-file fs-5"></i></div>
                        <div class="menu-title">Legal Pages</div>
                    </a>
                </li>

                <li>
                    <form method="POST" action="{{ route('admin.logout') }}" id="logout-form" style="display:none;">
                        @csrf
                    </form>
                    <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="parent-icon"><i class="bx bx-log-out fs-5"></i></div>
                        <div class="menu-title">Logout</div>
                    </a>
                </li>
            </ul>
        </div>

        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand gap-3">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center gap-1">
                            <li class="nav-item topbar-user dropdown hidden-xs">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="text-center">
                                        <h6 class="user-name mb-0">{{ auth('admin')->user()->email }}</h6>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

        <div class="page-wrapper">
            <div class="page-content p-3">
                @if(session('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success_message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error_message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

        <div class="overlay sidebar-overlay"></div>
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>

        <footer class="page-footer">
            <p class="mb-0">Copyright © {{ $settings->sitename ?? 'EasyShip' }} 2023 - {{ date('Y') }} All right reserved.</p>
        </footer>
    </div>
    <!--end wrapper-->

    <script src="{{ asset('admin-assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin-assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script src="{{ asset('admin-assets/js/index.js') }}"></script>

    <script>
        // Robust sidebar toggle (desktop collapse + mobile hamburger) that overrides
        // the fragile stock handler in app.js.
        $(function () {
            var $wrapper = $(".wrapper");
            var $overlay = $(".sidebar-overlay");
            var $collapseBtn = $(".sidebar-collapse-trigger");
            var $collapseIcon = $collapseBtn.find("i");
            var $mobileBtn = $(".mobile-toggle-menu");
            var iconIn = "bx-arrow-back";      // sidebar open / hamburger is a menu icon
            var iconOut = "bx-arrow-forward";   // sidebar collapsed / wants to close

            // Drop the stock app.js handlers so only ours run.
            $(".mobile-toggle-menu, .toggle-icon").off("click");

            // Desktop: collapse/expand the sidebar
            $collapseBtn.on("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                var collapsed = $wrapper.hasClass("toggled") && !$wrapper.hasClass("sidebar-hovered");
                if (collapsed) {
                    $wrapper.removeClass("toggled sidebar-hovered");
                    $collapseIcon.removeClass(iconOut).addClass(iconIn);
                } else {
                    $wrapper.addClass("toggled");
                    $collapseIcon.removeClass(iconIn).addClass(iconOut);
                }
                return false;
            });

            // Desktop: hover over the collapsed rail temporarily reveals the full menu,
            // but moving away returns to the icon rail (toggle button stays visible).
            $wrapper.off("mouseenter.sidebar mouseleave.sidebar")
                .on("mouseenter.sidebar", function () {
                    if ($wrapper.hasClass("toggled")) {
                        $wrapper.addClass("sidebar-hovered");
                    }
                })
                .on("mouseleave.sidebar", function () {
                    if ($wrapper.hasClass("toggled")) {
                        $wrapper.removeClass("sidebar-hovered");
                        if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                            $collapseIcon.removeClass(iconIn).addClass(iconOut);
                        }
                    }
                });

            // Mobile: hamburger opens AND closes the slide-in sidebar
            $mobileBtn.on("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                $wrapper.toggleClass("toggled");
                return false;
            });

            // Clicking the overlay closes the mobile menu
            $overlay.on("click", function () {
                $wrapper.removeClass("toggled sidebar-hovered");
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
