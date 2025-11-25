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


<!-- Mirrored from itcroctheme.com/nocimon/nocimon-html/about.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 18 Mar 2024 08:22:37 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>About | Page</title>
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
                            <p><a href="mailto:info@example.com">info@cargolink.com</a></p>
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
                <form action="index.php" method="post">
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
                                                <li class="active"><a href="about.php">About Us</a></li>
                                                <li class=""><a href="services.php">Services</a>
                                        
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
                    <h2>About Us</h2>
                    <ul class="thm-breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><span class="icon-left"></span></li>
                        <li>About Us</li>
                    </ul>
                </div>
            </div>
        </section>
        <!--End Page Header-->

        <!--Start About Two-->
        <section class="about-two about-two--about">
            <div class="container">
                <div class="row">

                    <div class="col-xl-7">
                        <div class="about-two__img">
                            <ul>
                                <li class="wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <!--Single About Two Img-->
                                    <div class="single-about-two__img-box">
                                        <img src="assets/img/about/about-two__img1.jpg" alt="#">
                                    </div>
                                    <!--End About Two Img-->
                                </li>
                                <li class="wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <!--Single About Two Img-->
                                    <div class="single-about-two__img-box">
                                        <div class="inner">
                                            <img src="assets/img/about/about-two__img2.jpg" alt="#">
                                        </div>
                                    </div>
                                    <!--End About Two Img-->
                                    <!--Single About Two Img-->
                                    <div class="single-about-two__img-box">
                                        <div class="inner">
                                            <img src="assets/img/about/about-two__img3.jpg" alt="#">
                                        </div>
                                    </div>
                                    <!--End About Two Img-->
                                </li>
                            </ul>
                            <div class="overlay-box">
                                <div class="outer-box">
                                    <div class="count-outer count-box">
                                        <h2 class="odometer" data-count="10"></h2>
                                        <i class="fa-solid fa-plus"></i>
                                    </div>
                                    <div class="title">
                                        <h4>Years Of Experiences</h4>
                                    </div>
                                    <div class="text">
                                        <p>
                                            Lorem Ipsum is simply dummy text.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-5">
                        <div class="about-two__contant-box">
                            <div class="sec-title">
                                <div class="sub-title">
                                    <h4>About us</h4>
                                </div>
                                <h2>
                                    Delivering efficiency one<br>mile at a time
                                </h2>
                            </div>
                            <div class="text">
                                <p>Welcome to <?php echo htmlspecialchars($row['sitename']); ?>, where we are redefining the world of logistics through a steadfast commitment to reliability, innovation, and customer-centric solutions. Our journey began over a decade ago with a simple mission: to provide a seamless, transparent, and efficient shipping experience for businesses and individuals alike. Today, we are proud to be a trusted partner for clients across the globe, delivering not just packages, but also peace of mind.</p>
                            </div>

                            <div class="about-one__futures1">
                                <ul>
                                    <li>
                                        <div class="icon">
                                            <span class="icon-cargo-ship"></span>
                                        </div>
                                        <h3>Our Mission</h3>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <span class="icon-packages3"></span>
                                        </div>
                                        <h3>Our Vision</h3>
                                    </li>
                                </ul>
                            </div>

                            <div class="about-one__list-item">
                                <ul>
                                    <li>
                                        <div class="icon">
                                            <span class="icon-check-mark"></span>
                                        </div>
                                        <p>To provide reliable and timely delivery services that exceed our customers' expectations.</p>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <span class="icon-check-mark"></span>
                                        </div>
                                        <p>To leverage cutting-edge technology to offer transparent and efficient logistics solutions.</p>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <span class="icon-check-mark"></span>
                                        </div>
                                        <p>To build long-lasting partnerships with our clients based on trust and mutual success.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!--End About Two-->

        <!--Start Who we Are-->
        <section class="who-we-are-one who-we-are-one--about">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                        <div class="who-we-are-one__content-box">
                            <div class="sec-title">
                                <div class="sub-title">
                                    <h4>WHo we ARE</h4>
                                </div>
                                <h2>
                                    Logistics made transportation<br>made easy Design
                                </h2>
                            </div>
                            <div class="text">
                                <p>
                                    Our team is composed of seasoned logistics professionals who are passionate about what they do. We combine our expertise with a customer-first approach, ensuring that we not only meet but exceed your expectations. From our dedicated customer service representatives to our experienced drivers and handlers, every member of the <?php echo htmlspecialchars($row['sitename']); ?> team is committed to providing you with a seamless and reliable shipping experience.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                        <div class="who-we-are-one__img-box">
                            <img src="assets/img/resource/who-we-are-one__img1.jpg" alt="#">
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">

            </div>
        </section>
        <!--Start Who we Are-->

        <!--Start Fact Counter Two-->
        <section class="fact-counter-two fact-counter-two--about">
            <div class="container">
                <div class="row">
                    <!--Start Single Fact Counter-->
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="0ms"
                        data-wow-duration="1500ms">
                        <div class="single-fact-counter-two">
                            <div class="outer-box">
                                <div class="count-outer count-box">
                                    <h2 class="odometer" data-count="200"></h2>
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                                <div class="text">
                                    <p>Happy Clients</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Fact Counter-->
                    <!--Start Single Fact Counter-->
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInRight" data-wow-delay="200ms"
                        data-wow-duration="1500ms">
                        <div class="single-fact-counter-two">
                            <div class="outer-box">
                                <div class="count-outer count-box">
                                    <h2 class="odometer" data-count="5"></h2>
                                    <i class="k">k</i>
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                                <div class="text">
                                    <p>Parcels Delivered</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Fact Counter-->
                    <!--Start Single Fact Counter-->
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="400ms"
                        data-wow-duration="1500ms">
                        <div class="single-fact-counter-two">
                            <div class="outer-box">
                                <div class="count-outer count-box">
                                    <h2 class="odometer" data-count="500"></h2>
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                                <div class="text">
                                    <p>Global Destinations</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Fact Counter-->
                    <!--Start Single Fact Counter-->
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInRight" data-wow-delay="600ms"
                        data-wow-duration="1500ms">
                        <div class="single-fact-counter-two">
                            <div class="outer-box">
                                <div class="count-outer count-box">
                                    <h2 class="odometer" data-count="400"></h2>
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                                <div class="text">
                                    <p>Team Members</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Fact Counter-->
                </div>
            </div>
        </section>
        <!--End Fact Counter One-->

        <!--Start Scrolling Text One-->
        <section class="scrolling-text-one scrolling-text-two about">
            <div class="inner">
                <ul class="clearfix marquee_mode">
                    <li>
                        <span class="stroke">Logitruck</span>
                        RealTimeLogistics
                        <div class="icon">
                            <span class="icon-sparkler"></span>
                        </div>
                    </li>
                    <li>
                        <span class="stroke">DriveLogistics</span>
                        RapidFleet
                        <div class="icon">
                            <span class="icon-sparkler"></span>
                        </div>
                    </li>
                    <li>
                        <span class="stroke">Our Technology</span>
                        RapidFleet
                        <div class="icon">
                            <span class="icon-sparkler"></span>
                        </div>
                    </li>
                </ul>

                <ul class="clearfix marquee_mode-two">
                    <li>
                        <span class="stroke">Logistics</span>
                        Ocean Wave Cargo
                        <div class="icon">
                            <span class="icon-sparkler"></span>
                        </div>
                    </li>
                    <li>
                        <span class="stroke">World wides</span>
                        Sea Cargo
                        <div class="icon">
                            <span class="icon-sparkler"></span>
                        </div>
                    </li>
                    <li>
                        <span class="stroke">Shipping cargo</span>
                        RapidFleet
                        <div class="icon">
                            <span class="icon-sparkler"></span>
                        </div>
                    </li>
                </ul>

            </div>
        </section>
        <!--End Scrolling Text One-->

        <!--Start Testimonials Two-->
        <section class="testimonials-two testimonials-two--about">
            <div class="container">
                <div class="sec-title text-center">
                    <div class="sub-title">
                        <h4>Testomonial</h4>
                    </div>
                    <h2>
                        Navigating your supply chain<br>with precision
                    </h2>
                </div>

                <div class="testimonials-two__inner">
                    <div class="thm-swiper__slider swiper-container" data-swiper-options='{
                                "spaceBetween": 50,
                                "slidesPerView": 3,
                                "speed": 2000,
                                "loop": false,
                                "pagination": {
                                    "el": ".swiper-pagination",
                                    "type": "progressbar",
                                    "clickable": true
                                    },
                                "navigation": {
                                    "nextEl": "#team-one__swiper-button-next",
                                    "prevEl": "#team-one__swiper-button-prev"
                                    },
                                "autoplay": { "delay": 9000 },
                                "breakpoints": {
                                        "0": {
                                            "spaceBetween": 0,
                                            "slidesPerView": 1
                                        },
                                        "375": {
                                            "spaceBetween": 0,
                                            "slidesPerView": 1
                                        },
                                        "575": {
                                            "spaceBetween": 0,
                                            "slidesPerView": 1
                                        },
                                        "768": {
                                            "spaceBetween": 0,
                                            "slidesPerView": 1
                                        },
                                        "992": {
                                            "spaceBetween": 0,
                                            "slidesPerView": 1
                                        },
                                        "1200": {
                                            "spaceBetween": 30,
                                            "slidesPerView": 2
                                        }
                                    }
                                }'>

                        <div class="swiper-wrapper">
                            <?php
                            $testimonial_result = mysqli_query($con, "SELECT * FROM testimonials WHERE is_published = 1 ORDER BY created_at DESC");
                            while ($testimonial = mysqli_fetch_assoc($testimonial_result)) :
                            ?>
                            <div class="swiper-slide">
                                <div class="testimonials-two__single">
                                    <div class="testimonials-two__single-img">
                                        <div class="inner">
                                            <img src="<?php echo htmlspecialchars($testimonial['image']); ?>" alt="#">
                                        </div>
                                        <div class="overlay-icon">
                                            <span class="icon-quote-right"></span>
                                        </div>
                                    </div>
                                    <div class="testimonials-two__single-content">
                                        <div class="text">
                                            <p><?php echo nl2br(htmlspecialchars($testimonial['review_text'])); ?></p>
                                        </div>
                                        <div class="customer-info">
                                            <div class="title">
                                                <h3><?php echo htmlspecialchars($testimonial['name']); ?></h3>
                                                <p><?php echo htmlspecialchars($testimonial['title']); ?></p>
                                            </div>
                                            <div class="ster-icon">
                                                <ul>
                                                    <?php
                                                    $rating = (int)$testimonial['rating'];
                                                    for ($i = 0; $i < $rating; $i++) :
                                                    ?>
                                                    <li>
                                                        <div class="icon">
                                                            <span class="icon-star-1"></span>
                                                        </div>
                                                    </li>
                                                    <?php endfor; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>

                        <div class="scroll-pagination">
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!--End Testimonials Two-->


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




    <!-- Scroll-top -->
    <button class="scroll-top scroll-to-target" data-target="html">
        <i class="icon-arrowhead-up"></i>
    </button>
    <!-- Scroll-top-end-->







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


<!-- Mirrored from itcroctheme.com/nocimon/nocimon-html/about.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 18 Mar 2024 08:22:37 GMT -->
</html>