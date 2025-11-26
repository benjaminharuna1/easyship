<?php
include 'includes/init.php'; // Includes session, DB, and settings

$site_logo = $settings['site_logo'];
$site_favicon = $settings['site_favicon'];
$row = $settings; // For compatibility with existing code using $row
?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from itcroctheme.com/nocimon/nocimon-html/services.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 18 Mar 2024 08:22:37 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Services | <?php echo htmlspecialchars($settings['site_title']); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if ($settings['search_engine_indexing'] == 0) : ?>
    <meta name="robots" content="noindex, nofollow">
    <?php endif; ?>

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $site_favicon; ?>">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/01-bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/02-all.min.css">
    <link rel="stylesheet" href="assets/css/03-jquery.magnific-popup.css">
    <link rel="stylesheet" href="assets/css/04-nice-select.css">
    <link rel="stylesheet" href="assets/css/05-odometer.css">
    <link rel="stylesheet" href="assets/css/06-swiper.min.css">
    <link rel="stylesheet" href="assets/css/07-animate.min.css">
    <link rel="stylesheet" href="assets/css/08-custom-animate.css">
    <link rel="stylesheet" href="assets/css/09-slick.css">
    <link rel="stylesheet" href="assets/css/10-icomoon.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/vendor/custom-animate/custom-animate.css">
    <link rel="stylesheet" href="assets/vendor/jarallax/jarallax.css">
    <link rel="stylesheet" href="assets/vendor/odometer/odometer.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body class="body-gray-bg">

    <!-- preloader -->
    <div id="preloader">
        <div id="loading-center">
            <div class="loader">
                <div class="loader-outter"></div>
                <div class="loader-inner"></div>
            </div>
        </div>
    </div>
    <!-- preloader-end -->


    <!-- Start Extra Info -->
    <div class="extra-info">
        <div class="close-icon menu-close">
            <button>
                <i class="icon-close"></i>
            </button>
        </div>
        <div class="logo-side">
            <a href="index.php"><img src="<?php echo $site_logo; ?>" alt="Logo"></a>
        </div>
        <div class="side-info">
            <div class="content-box">
                <h3>Welcome to our Best<br> Transportation Company</h3>
                <div class="text">
                    <p>
                        It is a long established fact that a reader will be distracted by the content of a page when
                        looking at its layout. Lorem Ipsum is simply text of the printing
                    </p>
                </div>
            </div>
            <!--Start Sidebar Contact Info -->
            <div class="sidebar-contact-info">
                <h3>Contact Us</h3>
                <ul>
                    <li>
                        <div class="icon">
                            <span class="icon-open-mail"></span>
                        </div>
                        <div class="text">
                            <p><a href="mailto:<?php echo htmlspecialchars($settings['email_address']); ?>"><?php echo htmlspecialchars($settings['email_address']); ?></a></p>
                        </div>
                    </li>
                    <li>
                        <div class="icon">
                            <span class="icon-phone-call-1"></span>
                        </div>
                        <div class="text">
                            <p><a href="tel:<?php echo htmlspecialchars($settings['phone_number']); ?>"><?php echo htmlspecialchars($settings['phone_number']); ?></a></p>
                        </div>
                    </li>
                    <li>
                        <div class="icon">
                            <span class="fa-regular fa-clock"></span>
                        </div>
                        <div class="text">
                            <p><?php echo htmlspecialchars($settings['working_days']); ?> : <?php echo htmlspecialchars($settings['working_hours']); ?></p>
                        </div>
                    </li>
                </ul>
            </div>
            <!--End Sidebar Contact Info -->
            <!--End Side Social Links -->
        </div>
    </div>
    <div class="offcanvas-overly"></div>
    <!-- End Extra Info -->


    <div class="page-wrapper">
        <!--Start Main Header One -->
        <header class="main-header main-header-one style4">
            <div id="sticky-header" class="menu-area">
                <div class="container">
                    <div class="main-header-one__inner">

                        <!--Start Main Header one Inner Left -->
                        <div class="main-header-style4__left">
                            <div class="logo-box-one">
                                <a href="index.php">
                                    <img src="<?php echo $site_logo; ?>" alt="Logo">
                                </a>
                            </div>
                        </div>
                        <!--End Main Header one Inner Left -->

                        <!--Start Main Header Style4 Middle -->
                        <div class="main-header-style4__middle">
                            <div class="menu-area__inner">
                                <div class="mobile-nav-toggler">
                                    <i class="fas fa-bars"></i>
                                </div>
                                <div class="menu-wrap">
                                    <nav class="menu-nav">
                                        <div class="navbar-wrap main-menu">
                                            <ul class="navigation">
                                                <li class=""><a href="index.php">Home</a>
                                                </li>
                                                <li class=""><a href="about.php">About Us</a></li>
                                                <li class="active"><a href="services.php">Services</a>

                                                </li>

                                                <li><a href="track.php">Track</a></li>

                                                <li><a href="contact.php">contact</a></li>

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
                        <!--End Main Header Style4 Middle -->

                        <!--Start Main Header Style4 Right -->
                        <div class="main-header-style4__right">
                            <div class="contact-box">
                                <div class="icon">
                                    <span class="icon-phone-call-1"></span>
                                </div>
                                <div class="text-box">
                                    <p>Need Assistance?</p>
                                    <h4><a href="tel:<?php echo htmlspecialchars($row['phone_number']); ?>"><?php echo htmlspecialchars($row['phone_number']); ?></a></h4>
                                </div>
                            </div>
                        </div>
                        <!--End Main Header Style4 Right -->

                    </div>
                </div>
            </div>

            <!--Start Mobile Menu  -->
            <div class="mobile-menu">
                <nav class="menu-box">
                    <div class="close-btn"><i class="fas fa-times"></i></div>
                    <div class="nav-logo">
                        <a href="index.php"><img src="<?php echo $site_logo; ?>" alt="Logo"></a>
                    </div>
                    <div class="menu-outer">
                        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                    </div>
                </nav>
            </div>
            <div class="menu-backdrop"></div>
            <!-- End Mobile Menu -->
        </header>
        <!--End Main Header One -->

        <!--Start Page Header-->
        <section class="page-header">
            <div class="page-header__img float-bob-y"><img src="assets/img/resource/page-header-img.png" alt=""></div>
            <div class="container">
                <div class="page-header__inner">
                    <h2>Service</h2>
                    <ul class="thm-breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><span class="icon-left"></span></li>
                        <li>Service</li>
                    </ul>
                </div>
            </div>
        </section>
        <!--End Page Header-->

        <!--Start Service Two-->
        <section class="service-two service-two--service">
            <div class="container">
                <div class="sec-title">
                    <div class="sub-title">
                        <h4>Latest Service</h4>
                    </div>
                    <h2>
                        Logistics made simple, transportation <br> made easy
                    </h2>
                </div>
                <div class="row">
                    <?php
                    $services_result = mysqli_query($con, "SELECT * FROM services WHERE is_published = 1 ORDER BY created_at DESC");
                    $delay = 0;
                    while ($service = mysqli_fetch_assoc($services_result)) :
                    ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInLeft" data-wow-delay="<?php echo $delay; ?>ms" data-wow-duration="1500ms">
                        <div class="service-three__single">
                            <div class="service-three__single-img">
                                <img src="<?php echo htmlspecialchars($service['image']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>">
                                <div class="service-three__single-img-bg"></div>
                            </div>
                            <div class="service-three__single-content">
                                <div class="icon">
                                    <span class="<?php echo htmlspecialchars($service['icon_class']); ?>"></span>
                                </div>
                                <div class="title">
                                    <h3><a href="#"><?php echo htmlspecialchars($service['title']); ?></a></h3>
                                </div>
                                <div class="text">
                                    <p><?php echo htmlspecialchars($service['description']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        // Increment delay for staggered animation effect
                        $delay = ($delay + 200) % 600;
                    endwhile;
                    ?>
                </div>
            </div>
        </section>
        <!--End Service Two-->

        <!--Start FAQ One-->
        <section class="faq-one faq-one--service">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="faq-one__title">
                            <div class="sec-title">
                                <div class="sub-title">
                                    <h4>Ask Question</h4>
                                </div>
                                <h2>
                                    Delivering Beyond<br>Expectations
                                </h2>
                            </div>
                            <div class="text">
                                <p>
                                    Emphasizes surpassing customer anticipations through superior products/services and exceptional standards, fostering long-term loyalty and satisfaction.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="faq-one__content">
                            <div class="accordion-box-one">
                                <!--Start single accordion box-->
                                <div class="accordion accordion-block">
                                    <div class="accord-btn">
                                        <h3>
                                            <span>01.</span> How do I track my package?
                                        </h3>
                                    </div>
                                    <div class="accord-content">
                                        <p>You can easily track your package in real-time by entering your tracking number on our "Track" page. Our system provides up-to-the-minute updates on the status and location of your shipment.</p>
                                    </div>
                                </div>
                                <!--End single accordion box-->
                                <!--Start single accordion box-->
                                <div class="accordion accordion-block">
                                    <div class="accord-btn active">
                                        <h3>
                                            <span>02.</span>
                                            What are your shipping rates?
                                        </h3>
                                    </div>
                                    <div class="accord-content collapsed">
                                        <p>Our shipping rates are based on a variety of factors, including the package weight, dimensions, destination, and the type of service selected. For a detailed quote, please use our online shipping calculator or contact our customer service team.</p>
                                    </div>
                                </div>
                                <!--End single accordion box-->
                                <!--Start single accordion box-->
                                <div class="accordion accordion-block">
                                    <div class="accord-btn">
                                        <h3>
                                            <span>03.</span> Do you offer international shipping?
                                        </h3>
                                    </div>
                                    <div class="accord-content">
                                        <p>Yes, we offer comprehensive international shipping services to destinations around the world. We handle all customs documentation and logistics to ensure a smooth and hassle-free delivery process for your global shipments.</p>
                                    </div>
                                </div>
                                <!--End single accordion box-->

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!--End FAQ One-->

        <!--Start Cta One-->
        <section class="cta-one cta-one--style2">
            <div class="container">
                <div class="cta-one__inner cta-one__inner--style2">
                    <div class="cta-one__inner-box cta-one__inner-box--style2">
                        <div class="title-box">
                            <h2>Efficiency in Motion Connecting the<br>World One Delivery at a Time!</h2>
                        </div>
                    </div>
                    <div class="cta-one__btn cta-one__btn--style2">
                        <a href="#" class="thm-btn">
                            <span class="txt">
                                contact us
                            </span>
                        </a>
                    </div>

                </div>
            </div>
        </section>
        <!--End Cta One-->

        <!--Start Footer One-->
        <footer class="footer-one">
            <!--Start Footer Middle-->
            <div class="footer-middle footer-middle--two">
                <div class="container">
                    <div class="footer-middle__inner">
                        <div class="footer-logo-box">
                            <img src="<?php echo htmlspecialchars($settings['site_logo']); ?>" style="width: 170px;" alt="Site Logo">
                        </div>
                        <div class="phone-number-box phone-number-box--style2">
                            <div class="icon">
                                <span class="icon-phone-call-1"></span>
                            </div>
                            <div class="text">
                                <p>Need help?</p>
                                <p><a href="tel:<?php echo htmlspecialchars($settings['phone_number']); ?>"><?php echo htmlspecialchars($settings['phone_number']); ?></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Footer Middle-->

            <!--Start Footer Bottom -->
            <div class="footer-bottom footer-bottom--two">
                <div class="container">
                    <div class="footer-bottom__inner">
                        <div class="copyright-text copyright-text--two">
                            <p>© <?php echo htmlspecialchars($settings['sitename']); ?> <?php echo date('Y'); ?> | All Rights Reserved.</p>
                        </div>

                        <div class="copyright-menu copyright-menu--two">
                            <ul>
                                <li>
                                    <p><a href="terms.php">Terms &amp; Condition</a></p>
                                </li>
                                <li>
                                    <p><a href="privacy.php">Privacy Policy</a></p>
                                </li>
                                <li>
                                    <p><a href="contact.php">Contact Us</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Footer Bottom -->
        </footer>
        <!--Start Footer One-->

    </div>


    <!-- Scroll-top -->
    <button class="scroll-top scroll-to-target" data-target="html">
        <i class="icon-arrowhead-up"></i>
    </button>
    <!-- Scroll-top-end-->


    <!--Start Search Popup -->
    <div class="search-popup">
        <div class="search-popup__overlay search-toggler">
            <div class="search-close-btn">
                <i class="icon-plus"></i>
            </div>
        </div>
        <div class="search-popup__content">
            <form action="#">
                <label for="search" class="sr-only">search here</label>
                <input type="search" id="search" placeholder="Search Here..." />
                <button type="submit" aria-label="search submit" class="btn-one">
                    <i class="icon-search-interface-symbol"></i>
                </button>
            </form>
        </div>
    </div>
    <!--End Search Popup -->



    <!-- JS here -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/01-ajax-form.js"></script>
    <script src="assets/js/02-bootstrap.min.js"></script>
    <script src="assets/js/03-jquery.appear.js"></script>
    <script src="assets/js/04-swiper.min.js"></script>
    <script src="assets/js/05-jquery.odometer.min.js"></script>
    <script src="assets/js/06-jquery.magnific-popup.min.js"></script>
    <script src="assets/js/07-jquery.nice-select.min.js"></script>
    <script src="assets/js/08-slick.min.js"></script>
    <script src="assets/js/09-wow.min.js"></script>
    <script src="assets/js/10-jquery.circleType.js"></script>
    <script src="assets/js/11-jquery.lettering.min.js"></script>
    <script src="assets/js/12-TweenMax.min.js"></script>
    <script src="assets/vendor/jarallax/jarallax.min.js"></script>
    <script src="assets/vendor/marquee/marquee.min.js"></script>
    <script src="assets/vendor/odometer/odometer.min.js"></script>




    <script src="assets/js/main.js"></script>

</body>


<!-- Mirrored from itcroctheme.com/nocimon/nocimon-html/services.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 18 Mar 2024 08:22:38 GMT -->
</html>