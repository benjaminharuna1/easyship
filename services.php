<?php
include 'db.php';
$stmt = mysqli_prepare($con, "SELECT * FROM setting");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$site_logo = $row['site_logo'];
$site_favicon = $row['site_favicon'];
?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from itcroctheme.com/nocimon/nocimon-html/services.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 18 Mar 2024 08:22:37 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Service | Page</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
            <a href="index.php"><img src="assets/img/logo.png" alt="#"></a>
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
                <h3>Conatct Us</h3>
                <ul>
                    <li>
                        <div class="icon">
                            <span class="icon-open-mail"></span>
                        </div>
                        <div class="text">
                            <p><a href="mailto:info@cargolink.com">info@cargolink.com</a></p>
                        </div>
                    </li>
                    <li>
                        <div class="icon">
                            <span class="icon-phone-call-1"></span>
                        </div>
                        <div class="text">
                            <p><a href="tel:+8801682648101">+1800 456 7890</a></p>
                        </div>
                    </li>
                    <li>
                        <div class="icon">
                            <span class="fa-regular fa-clock"></span>
                        </div>
                        <div class="text">
                            <p>Working Hour : 7.00am to 4.00pm</p>
                        </div>
                    </li>
                </ul>
            </div>
            <!--End Sidebar Contact Info -->
            <div class="side-content-newsletter-box">
                <h3>Newsletter Subscription</h3>
                <form action="" method="post">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Enter Email Address" required="">
                        <button class="thm-btn" type="submit">
                            <span class="txt">
                                <i class="icon-paper-plane"></i>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
            <!--Start Side Social Links -->
            <div class="side-social-links">
                <ul class="clearfix">
                    <li>
                        <a href="#">
                            <i class="icon-facebook-app-symbol"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-linked-in-logo-of-two-letters"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-pinterest"></i>
                        </a>
                    </li>
                </ul>
            </div>
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

                                                <li><a href="contact.php">contacts</a></li>

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
                        <a href="index.php"><img src="assets/img/resource/mobile-menu-logo.png" alt="Logo"></a>
                    </div>
                    <div class="menu-outer">
                        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                    </div>
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

                    <!--Start Single Service Three-->
                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInLeft" data-wow-delay="0ms"
                        data-wow-duration="1500ms">
                        <div class="service-three__single">
                            <div class="service-three__single-img">
                                <img src="assets/img/service/service-three__img1.jpg" alt="#">
                                <div class="service-three__single-img-bg"></div>
                            </div>
                            <div class="service-three__single-content">
                                <div class="icon">
                                    <span class="icon-delivery-truck2"></span>
                                </div>
                                <div class="title">
                                    <h3><a href="#">Express Shipping</a></h3>
                                </div>
                                <div class="text">
                                    <p>
                                        When time is of the essence, our Express Shipping service guarantees the fastest possible delivery. We leverage our extensive network and optimized routes to ensure your urgent packages arrive on time, every time.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Service Three-->
                    <!--Start Single Service Three-->
                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInRight" data-wow-delay="200ms"
                        data-wow-duration="1500ms">
                        <div class="service-three__single">
                            <div class="service-three__single-img">
                                <img src="assets/img/service/service-three__img2.jpg" alt="#">
                                <div class="service-three__single-img-bg"></div>
                            </div>
                            <div class="service-three__single-content">
                                <div class="icon">
                                    <span class="icon-shipping1"></span>
                                </div>
                                <div class="title">
                                    <h3><a href="#">Standard Shipping</a></h3>
                                </div>
                                <div class="text">
                                    <p>
                                        Our Standard Shipping service offers a reliable and cost-effective solution for your less urgent delivery needs. We provide consistent, high-quality service with transparent tracking, ensuring your packages arrive safely and on schedule.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Service Three-->
                    <!--Start Single Service Three-->
                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInLeft" data-wow-delay="400ms"
                        data-wow-duration="1500ms">
                        <div class="service-three__single">
                            <div class="service-three__single-img">
                                <img src="assets/img/service/service-three__img3.jpg" alt="#">
                                <div class="service-three__single-img-bg"></div>
                            </div>
                            <div class="service-three__single-content">
                                <div class="icon">
                                    <span class="icon-cancel"></span>
                                </div>
                                <div class="title">
                                    <h3><a href="#">International Shipping</a></h3>
                                </div>
                                <div class="text">
                                    <p>
                                        Our International Shipping service connects you to the world. We handle all the complexities of customs and international logistics to ensure your packages reach their global destinations safely and efficiently.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Service Three-->


                    <!--Start Single Service Three-->
                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInLeft" data-wow-delay="400ms"
                        data-wow-duration="1500ms">
                        <div class="service-three__single">
                            <div class="service-three__single-img">
                                <img src="assets/img/service/service-three__img4.jpg" alt="#">
                                <div class="service-three__single-img-bg"></div>
                            </div>
                            <div class="service-three__single-content">
                                <div class="icon">
                                    <span class="icon-cancel"></span>
                                </div>
                                <div class="title">
                                    <h3><a href="#">Freight Services</a></h3>
                                </div>
                                <div class="text">
                                    <p>
                                        We offer comprehensive freight services for your large or heavy shipments. Our team is equipped to handle all your freight needs, ensuring safe and timely delivery.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Service Three-->
                    <!--Start Single Service Three-->
                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInLeft" data-wow-delay="0ms"
                        data-wow-duration="1500ms">
                        <div class="service-three__single">
                            <div class="service-three__single-img">
                                <img src="assets/img/service/service-three__img5.jpg" alt="#">
                                <div class="service-three__single-img-bg"></div>
                            </div>
                            <div class="service-three__single-content">
                                <div class="icon">
                                    <span class="icon-delivery-truck2"></span>
                                </div>
                                <div class="title">
                                    <h3><a href="#">Warehousing & Distribution</a></h3>
                                </div>
                                <div class="text">
                                    <p>
                                        Our secure warehousing and efficient distribution services are designed to streamline your supply chain. We offer flexible storage solutions and timely distribution to meet your business needs.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Service Three-->
                    <!--Start Single Service Three-->
                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInRight" data-wow-delay="200ms"
                        data-wow-duration="1500ms">
                        <div class="service-three__single">
                            <div class="service-three__single-img">
                                <img src="assets/img/service/service-three__img6.jpg" alt="#">
                                <div class="service-three__single-img-bg"></div>
                            </div>
                            <div class="service-three__single-content">
                                <div class="icon">
                                    <span class="icon-shipping1"></span>
                                </div>
                                <div class="title">
                                    <h3><a href="#">E-commerce Solutions</a></h3>
                                </div>
                                <div class="text">
                                    <p>
                                        We provide tailored logistics solutions for e-commerce businesses, including inventory management, order fulfillment, and last-mile delivery. Let us help you scale your business and delight your customers.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Service Three-->
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
                            <img src="assets/img/logo.png" style="width: 170px;" alt="#">
                        </div>
                        <div class="phone-number-box phone-number-box--style2">
                            <div class="icon">
                                <span class="icon-phone-call-1"></span>
                            </div>
                            <div class="text">
                                <p>Need help?</p>
                                <p><a href="tel:(808)555-0111">(808) 555-0111</a></p>
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
                            <p>© Cargo link 2023 | <a href="index.php">cargolink</a>, All Rights Reserved.</p>
                        </div>

                        <div class="copyright-menu copyright-menu--two">
                            <ul>
                                <li>
                                    <p><a href="#">Trams &amp; Condition</a></p>
                                </li>
                                <li>
                                    <p><a href="#">Privacy Policy</a></p>
                                </li>
                                <li>
                                    <p><a href="#">Contact Us</a></p>
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