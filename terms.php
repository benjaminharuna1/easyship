<?php
include 'includes/init.php'; // Includes session, DB, and settings
include 'functions.php';

// Use settings from init.php
$site_logo = $settings['site_logo'];
$site_favicon = $settings['site_favicon'];
$setting_row = $settings; // For compatibility

// Fetch the legal page content
$page_slug = 'terms-and-conditions';
$page_stmt = mysqli_prepare($con, "SELECT * FROM legal_pages WHERE page_slug = ?");
mysqli_stmt_bind_param($page_stmt, "s", $page_slug);
mysqli_stmt_execute($page_stmt);
$page_result = mysqli_stmt_get_result($page_stmt);
$page = mysqli_fetch_assoc($page_result);
if (!$page) {
    // Fallback if page is not in DB
    $page = ['page_title' => 'Terms & Conditions', 'page_content' => 'Content not available.'];
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo htmlspecialchars($page['page_title']); ?> | <?php echo htmlspecialchars($settings['site_title']); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if ($settings['search_engine_indexing'] == 0) : ?>
    <meta name="robots" content="noindex, nofollow">
    <?php endif; ?>

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $site_favicon; ?>">
    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/01-bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/02-all.min.css">
    <link rel="stylesheet" href="assets/css/10-icomoon.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="body-gray-bg">
    <!-- preloader -->
    <div id="preloader"><div id="loading-center"><div class="loader"><div class="loader-outter"></div><div class="loader-inner"></div></div></div></div>
    <!-- preloader-end -->

    <div class="page-wrapper">
        <!--Start Main Header One -->
        <header class="main-header main-header-one style4">
            <div id="sticky-header" class="menu-area">
                <div class="container">
                    <div class="main-header-one__inner">
                        <div class="main-header-style4__left">
                            <div class="logo-box-one"><a href="index.php"><img src="<?php echo $site_logo; ?>" alt="Logo"></a></div>
                        </div>
                        <div class="main-header-style4__middle">
                            <div class="menu-area__inner">
                                <div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
                                <div class="menu-wrap">
                                    <nav class="menu-nav">
                                        <div class="navbar-wrap main-menu">
                                            <ul class="navigation">
                                                <li><a href="index.php">Home</a></li>
                                                <li><a href="about.php">About Us</a></li>
                                                <li><a href="services.php">Services</a></li>
                                                <li><a href="track.php">Track</a></li>
                                                <li><a href="contact.php">Contact</a></li>
                                            </ul>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <div class="main-menu-right-box-one">
                                <div class="search-box-one"><a href="#" class="main-menu__search search-toggler"><span class="icon-search-interface-symbol"></span></a></div>
                                <div class="side-content-button-one"><a class="menu-tigger" href="#"><span class="line"></span><span class="line two"></span></a></div>
                            </div>
                        </div>
                        <div class="main-header-style4__right">
                            <div class="contact-box">
                                <div class="icon"><span class="icon-phone-call-1"></span></div>
                                <div class="text-box"><p>Need Assistance?</p><h4><a href="tel:<?php echo htmlspecialchars($setting_row['phone_number']); ?>"><?php echo htmlspecialchars($setting_row['phone_number']); ?></a></h4></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <!--Start Mobile Menu  -->
            <div class="mobile-menu">
                <nav class="menu-box">
                    <div class="close-btn"><i class="fas fa-times"></i></div>
                    <div class="nav-logo">
                        <a href="index.php"><img src="assets/img/resource/mobile-menu-logo.png" alt="Logo"></a>
                    </div>
                    <div class="menu-outer"></div>
                    <div class="social-links">
                        <ul class="clearfix list-wrap">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="menu-backdrop"></div>
            <!-- End Mobile Menu -->
        </header>
        <!--End Main Header One -->

        <!--Start Page Header-->
        <section class="page-header">
            <div class="container">
                <div class="page-header__inner">
                    <h2><?php echo htmlspecialchars($page['page_title']); ?></h2>
                    <ul class="thm-breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><span class="icon-left"></span></li>
                        <li><?php echo htmlspecialchars($page['page_title']); ?></li>
                    </ul>
                </div>
            </div>
        </section>
        <!--End Page Header-->

        <!--Start Legal Content Section-->
        <section class="legal-content-section" style="padding: 120px 0;">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="legal-content-box">
                            <?php echo process_shortcodes($page['page_content'], $settings); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Legal Content Section-->

        <!--Start Footer One-->
        <footer class="footer-one">
            <div class="footer-bottom footer-bottom--two">
                <div class="container">
                    <div class="footer-bottom__inner">
                        <div class="copyright-text copyright-text--two">
                             <p>&copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars($setting_row['sitename']); ?> | All Rights Reserved.</p>
                        </div>
                        <div class="copyright-menu copyright-menu--two">
                            <ul>
                                <li><p><a href="terms.php">Terms & Condition</a></p></li>
                                <li><p><a href="privacy.php">Privacy Policy</a></p></li>
                                <li><p><a href="contact.php">Contact Us</a></p></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--End Footer One-->
    </div>

    <!-- Scroll-top -->
    <button class="scroll-top scroll-to-target" data-target="html"><i class="icon-arrowhead-up"></i></button>
    <!-- Scroll-top-end-->

    <!-- JS here -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/02-bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
