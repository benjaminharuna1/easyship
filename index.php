<?php
include 'includes/init.php'; // Includes session, DB, and settings

$site_logo = $settings['site_logo'];
$site_favicon = $settings['site_favicon'];
$row = $settings; // For compatibility with existing code using $row
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo htmlspecialchars($settings['site_title']); ?></title>
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
                                                <li class="active"><a href="index.php">Home</a>
                                                </li>
                                                <li class=""><a href="about.php">About Us</a></li>
                                                <li class=""><a href="services.php">Services</a>

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


        <!--Start Banner One-->
        <section class="banner-one">
            <div class="banner-one__bg wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms"
                style="background-image: url(assets/img/slider/banner-one__mian-img.jpg);">
            </div>

            <div class="banner-one__bg-shape wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                <div class="border-box"></div>
            </div>

            <div class="banner-one__shape1">
                <img class="float-bob-y" src="assets/img/shape/banner-one__shape1.png" alt="#">
            </div>
            <div class="banner-one__shape2 wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                <img class="float-bob-y" src="assets/img/shape/banner-one__shape2.png" alt="#">
            </div>
            <div class="container">
                <div class="banner-one__content wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                    <div class="sub-title">
                        <h5><?php echo htmlspecialchars($row['hero_subtitle']); ?></h5>
                    </div>
                    <div class="big-title">
                        <h2><?php echo $row['hero_title']; ?></h2>
                    </div>
                    <div class="text">
                        <p><?php echo htmlspecialchars($row['hero_text']); ?></p>
                    </div>
                    <div class="btn-box">
                        <a class="thm-btn" href="track.php">
                            <span class="txt">
                                Track
                                <i class="icon-next"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!--End Banner One-->

        <!--Start Service One-->
        <section class="service-one">
            <div class="container">
                <div class="sec-title text-center">
                    <div class="sub-title">
                        <h4>Latest Service</h4>
                    </div>
                    <h2>
                        Logistics made simple transportation<br> made easy In Touch
                    </h2>
                </div>
                <div class="row">
                    <?php
                    $services_result = mysqli_query($con, "SELECT * FROM services WHERE is_published = 1 AND is_featured = 1 ORDER BY created_at DESC LIMIT 3");
                    $delay = 0;
                    while ($service = mysqli_fetch_assoc($services_result)) :
                    ?>
                    <div class="col-xl-4 col-lg-4 col-md-4 wow fadeInLeft" data-wow-delay="<?php echo $delay; ?>ms" data-wow-duration="1500ms">
                        <div class="service-one__single">
                            <div class="service-one__single-icon-box">
                                <div class="left-icon-box">
                                    <span class="<?php echo htmlspecialchars($service['icon_class']); ?>"></span>
                                </div>
                                <div class="right-icon-box">
                                    <a href="services.php"><span class="icon-next"></span></a>
                                </div>
                            </div>
                            <div class="service-one__single-content">
                                <h3><a href="services.php"><?php echo htmlspecialchars($service['title']); ?></a></h3>
                                <p><?php echo htmlspecialchars(substr($service['description'], 0, 150)) . '...'; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                    $delay += 200;
                    endwhile;
                    ?>
                </div>
            </div>
        </section>
        <!--End Service One-->

        <!--Start About One-->
        <section class="about-one">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="about-one__img-box">
                            <div class="about-one__img-box-overlay-bg"></div>
                            <div class="inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <img src="assets/img/about/about-one__img1.jpg" alt="#">
                            </div>
                            <div class="about-one__overlay-box text-center wow fadeInRight" data-wow-delay="0ms"
                                data-wow-duration="1500ms">
                                <div class="outer-box">
                                    <div class="count-outer count-box">
                                        <h2 class="odometer" data-count="<?php echo htmlspecialchars($row['years_experience']); ?>">00</h2>
                                        <i class="icon-add"></i>
                                    </div>
                                    <div class="title">
                                        <p>Years of experiences</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="about-one__content-box">
                            <div class="sec-title">
                                <div class="sub-title">
                                    <h4>About us</h4>
                                </div>
                                <h2>
                                    Delivering efficiency one<br>mile at a time
                                </h2>
                            </div>
                            <div class="text">
                                <p>At <?php echo htmlspecialchars($row['sitename']); ?>, we are more than just a courier service; we are your dedicated logistics partner. We understand that behind every package is a promise, a commitment, or a critical business need. That’s why we’ve built our reputation on a foundation of trust, reliability, and unparalleled customer service. Our global network and cutting-edge technology ensure that your shipments are handled with the utmost care and delivered on time, every time.</p>
                            </div>
                            <ul>

                                <li>
                                    <div class="icon">
                                        <span class="icon-check"></span>
                                    </div>
                                    <div class="text-box">
                                        <h3>
                                            Global Network
                                        </h3>
                                        <p>
                                            With a vast network of partners and agents worldwide, we offer seamless international shipping and customs clearance, connecting your business to every corner of the globe.
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-check"></span>
                                    </div>
                                    <div class="text-box">
                                        <h3>
                                            Advanced Tracking
                                        </h3>
                                        <p>
                                            Our state-of-the-art tracking system provides real-time updates, giving you complete visibility and peace of mind from pickup to delivery.
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End About One-->

        <!--Start Fact Counter One-->
        <section class="fact-counter-one">
            <div class="container">
                <div class="row">
                    <div class="fact-counter_box">
                        <ul class="clearfix">
                            <!--Start Single Fact Counter-->
                            <li class="single-fact-counter wow fadeInUp" data-wow-delay=".3s">
                                <div class="icon"><span class="icon-delivery"></span></div>
                                <div class="outer-box">
                                    <div class="count-outer count-box">
                                        <h2 class="odometer" data-count="<?php echo htmlspecialchars($row['achievement_1_num']); ?>">00</h2>
                                        <i class="icon-add"></i>
                                    </div>
                                    <div class="title"><p><?php echo htmlspecialchars($row['achievement_1_title']); ?></p></div>
                                </div>
                            </li>
                            <!--End Single Fact Counter-->
                            <!--Start Single Fact Counter-->
                            <li class="single-fact-counter wow fadeInDown" data-wow-delay=".3s">
                                <div class="icon"><span class="icon-package"></span></div>
                                <div class="outer-box">
                                    <div class="count-outer count-box">
                                        <h2 class="odometer" data-count="<?php echo htmlspecialchars($row['achievement_2_num']); ?>">00</h2>
                                        <i class="icon-add"></i>
                                    </div>
                                    <div class="title"><p><?php echo htmlspecialchars($row['achievement_2_title']); ?></p></div>
                                </div>
                            </li>
                            <!--End Single Fact Counter-->
                            <!--Start Single Fact Counter-->
                            <li class="single-fact-counter wow fadeInUp" data-wow-delay=".3s">
                                <div class="icon"><span class="icon-packages2"></span></div>
                                <div class="outer-box">
                                    <div class="count-outer count-box">
                                        <h2 class="odometer" data-count="<?php echo htmlspecialchars($row['achievement_3_num']); ?>">00</h2>
                                        <i class="icon-add"></i>
                                    </div>
                                    <div class="title"><p><?php echo htmlspecialchars($row['achievement_3_title']); ?></p></div>
                                </div>
                            </li>
                            <!--End Single Fact Counter-->
                            <!--Start Single Fact Counter-->
                            <li class="single-fact-counter wow fadeInDown" data-wow-delay=".3s">
                                <div class="icon"><span class="icon-delivery-truck"></span></div>
                                <div class="outer-box">
                                    <div class="count-outer count-box">
                                        <h2 class="odometer" data-count="<?php echo htmlspecialchars($row['achievement_4_num']); ?>">00</h2>
                                        <?php if (!empty($row['achievement_4_suffix'])): ?><i class="k"><?php echo htmlspecialchars($row['achievement_4_suffix']); ?></i><?php endif; ?>
                                        <i class="icon-add"></i>
                                    </div>
                                    <div class="title"><p><?php echo htmlspecialchars($row['achievement_4_title']); ?></p></div>
                                </div>
                            </li>
                            <!--End Single Fact Counter-->

                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--End Fact Counter One-->

        <!--Start Project One-->
        <section class="project-one">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="project-one__content-box">
                            <div class="sec-title">
                                <div class="sub-title">
                                    <h4>OUR LATEST Work</h4>
                                </div>
                                <h2>
                                    Efficient solutions<br>logistics needs
                                </h2>
                            </div>
                            <div class="text">
                                <p>
                                    We specialize in providing tailored logistics solutions that meet the unique needs of our clients. From small parcels to large-scale freight, our experienced team is dedicated to ensuring your shipments are delivered safely and on schedule. Explore some of our recent projects to see how we’re delivering excellence across the globe.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="row">

                            <!--Start Project One Single-->
                            <div class="col-xl-6 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s">
                                <div class="project-one__single">
                                    <div class="project-one__single-img">
                                        <div class="inner">
                                            <img src="assets/img/project/project-one__img1.jpg" alt="#">
                                        </div>
                                        <div class="overlay-icon">
                                            <a href="#">
                                                <span class="icon-plus"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="project-one__single-content text-center">
                                        <div class="title-box">
                                            <h3><a href="#">Express Logix</a></h3>
                                            <p>Swift, reliable, and efficient logistics solutions for your business needs. Trust us for timely and secure delivery every time.</p>
                                        </div>
                                        <!-- <div class="btn-box">
                                            <a href="#">Read More <span
                                                    class="icon-right-arrow-2"></span></a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <!--End Project One Single-->
                            <!--Start Project One Single-->
                            <div class="col-xl-6 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s">
                                <div class="project-one__single">
                                    <div class="project-one__single-img">
                                        <div class="inner">
                                            <img src="assets/img/project/project-one__img2.jpg" alt="#">
                                        </div>
                                        <div class="overlay-icon">
                                            <a href="#">
                                                <span class="icon-plus"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="project-one__single-content text-center">
                                        <div class="title-box">
                                            <h3><a href="#">Prime Cargo</a></h3>
                                            <p>Swift and reliable logistics partner for your shipping needs.</p>
                                        </div>
                                        <!-- <div class="btn-box">
                                            <a href="#">Read More <span
                                                class="icon-right-arrow-2"></span></a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <!--End Project One Single-->
                            <!--Start Project One Single-->
                            <div class="col-xl-6 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s">
                                <div class="project-one__single">
                                    <div class="project-one__single-img">
                                        <div class="inner">
                                            <img src="assets/img/project/project-one__img3.jpg" alt="#">
                                        </div>
                                        <div class="overlay-icon">
                                            <a href="#">
                                                <span class="icon-plus"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="project-one__single-content text-center">
                                        <div class="title-box">
                                            <h3><a href="#">Speedy Transit</a></h3>
                                            <p>Your fast, reliable logistics solution.</p>
                                        </div>
                                        <!-- <div class="btn-box">
                                            <a href="#">Read More <span
                                                    class="icon-right-arrow-2"></span></a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <!--End Project One Single-->
                            <!--Start Project One Single-->
                            <div class="col-xl-6 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s">
                                <div class="project-one__single">
                                    <div class="project-one__single-img">
                                        <div class="inner">
                                            <img src="assets/img/project/project-one__img4.jpg" alt="#">
                                        </div>
                                        <div class="overlay-icon">
                                            <a href="#">
                                                <span class="icon-plus"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="project-one__single-content text-center">
                                        <div class="title-box">
                                            <h3><a href="#">Prime Cargo</a></h3>
                                            <p>Your premier logistics partner, ensuring fast and reliable delivery for your shipments.</p>
                                        </div>
                                        <!-- <div class="btn-box">
                                            <a href="#">Read More <span
                                                    class="icon-right-arrow-2"></span></a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <!--End Project One Single-->

                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!--End Project One-->

        <!--Start Video One-->
        <section class="video-one">
            <div class="video-one__bg" data-jarallax data-speed="0.1" data-imgPosition="0% 0%"
                style="background-image: url(<?php echo htmlspecialchars($row['video_bg_image']); ?>);"></div>
            <div class="icon wow zoomIn animated" data-wow-delay="300ms" data-wow-duration="1500ms">
                <a class="video-popup" title="Video Gallery" href="<?php echo htmlspecialchars($row['video_url']); ?>">
                    <span class="icon-play-button-arrowhead"></span>
                </a>
            </div>
        </section>
        <!--End Video One-->

        <!--Start Testimonials One-->
        <section class="testimonials-one">
            <div class="container">
                <div class="sec-title text-center">
                    <div class="sub-title">
                        <h4>clients Testomonial</h4>
                    </div>
                    <h2>
                        Delivering excellence one<br>shipment at a time
                    </h2>
                </div>
                <div class="testimonials-one__inner">
                    <div class="thm-swiper__slider swiper-container" data-swiper-options='{
                        "loop": true,
                        "pagination": {
                            "el": "#testimonial-one-pagination",
                            "type": "bullets",
                            "clickable": true
                            },
                        "navigation": {
                            "nextEl": "#testimonial-two__swiper-button-next",
                            "prevEl": "#testimonial-two__swiper-button-prev"
                        },
                        "autoplay": { "delay": 5000 },
                        "breakpoints": {
                            "0": {
                                "spaceBetween": 30,
                                "slidesPerView": 1
                            },
                            "375": {
                                "spaceBetween": 30,
                                "slidesPerView": 1
                            },
                            "575": {
                                "spaceBetween": 30,
                                "slidesPerView": 1
                            },
                            "768": {
                                "spaceBetween": 30,
                                "slidesPerView": 1
                            },
                            "992": {
                                "spaceBetween": 30,
                                "slidesPerView": 2
                            },
                            "1200": {
                                "spaceBetween": 30,
                                "slidesPerView": 2
                            }
                        }}'>

                        <div class="swiper-wrapper">
                            <?php
                            $testimonials_result = mysqli_query($con, "SELECT * FROM testimonials WHERE is_published = 1 ORDER BY created_at DESC");
                            while ($testimonial = mysqli_fetch_assoc($testimonials_result)) :
                            ?>
                            <div class="swiper-slide">
                                <div class="testimonials-one__single">
                                    <div class="testimonials-one__single-img">
                                        <div class="testimonials-one__single-img__inner">
                                            <div class="inner">
                                                <img src="<?php echo htmlspecialchars($testimonial['image']); ?>" alt="">
                                            </div>
                                            <div class="overlay-box">
                                                <span class="icon-quote-right"></span>
                                            </div>
                                        </div>
                                        <div class="title-box">
                                            <h3><a href="#"><?php echo htmlspecialchars($testimonial['name']); ?></a></h3>
                                            <p><?php echo htmlspecialchars($testimonial['title']); ?></p>
                                        </div>
                                    </div>
                                    <div class="testimonials-one__single-content">
                                        <div class="ster-icon">
                                            <ul>
                                                <?php for ($i = 0; $i < $testimonial['rating']; $i++) : ?>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-star-1"></span>
                                                    </div>
                                                </li>
                                                <?php endfor; ?>
                                            </ul>
                                            <p>Reviews (0<?php echo htmlspecialchars($testimonial['rating']); ?>)</p>
                                        </div>
                                        <div class="text">
                                            <p>
                                                "<?php echo htmlspecialchars($testimonial['review_text']); ?>"
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Testimonials One-->

        <!--Start Cta One-->
        <section class="cta-one">
            <div class="container">
                <div class="cta-one__inner">
                    <div class="cta-one__inner-box">
                        <div class="title-box">
                            <h2>Logistics Solutions for Success</h2>
                            <p>Embracing real-time tracking, collaborative partnerships, and data-driven insights for seamless logistics success.</p>
                        </div>
                    </div>

                    <div class="cta-one__newsletter-box">
                        <form action="https://itcroctheme.com/nocimon/nocimon-html/index.html" method="post">
                            <div class="cta-one__form-group">
                                <input type="email" name="email" placeholder="Enter Email Address" required="">
                                <button class="thm-btn" type="submit">
                                    <span class="txt">
                                        <i class="icon-paper-plane"></i>
                                        Browse More
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </section>
        <!--End Cta One-->

        <!--Start Team One-->
        <section class="team-one">
            <div class="container">
                <div class="sec-title text-center">
                    <div class="sub-title">
                        <h4>our team members</h4>
                    </div>
                    <h2>
                        Your partner in seamless<br>transportation
                    </h2>
                </div>
                <div class="team-one__inner">
                    <div class="thm-swiper__slider swiper-container" data-swiper-options='{
                        "spaceBetween": 50,
                        "speed": 1500,
                        "slidesPerView": 3,
                        "loop": true,
                        "pagination": {
                            "el": "#swiper-dot-style1",
                            "type": "bullets",
                            "clickable": true
                            },
                        "navigation": {
                            "nextEl": "#team-one__swiper-button-next",
                            "prevEl": "#team-one__swiper-button-prev"
                            },
                        "autoplay": { "delay": 5000 },
                        "breakpoints": {
                                "0": {
                                    "spaceBetween": 30,
                                    "slidesPerView": 1
                                },
                                "375": {
                                    "spaceBetween": 30,
                                    "slidesPerView": 1
                                },
                                "575": {
                                    "spaceBetween": 30,
                                    "slidesPerView": 1
                                },
                                "768": {
                                    "spaceBetween": 30,
                                    "slidesPerView": 2
                                },
                                "992": {
                                    "spaceBetween": 30,
                                    "slidesPerView": 3
                                },
                                "1200": {
                                    "spaceBetween": 40,
                                    "slidesPerView": 4
                                }
                            }
                        }'>

                        <div class="swiper-wrapper">
                            <?php
                            $team_result = mysqli_query($con, "SELECT * FROM team_members WHERE is_published = 1 ORDER BY created_at DESC");
                            while ($member = mysqli_fetch_assoc($team_result)) :
                            ?>
                            <div class="swiper-slide">
                                <div class="team-one__single">
                                    <div class="team-one__single-img">
                                        <img src="<?php echo htmlspecialchars($member['image']); ?>" alt="#">
                                        <div class="social-share-box">
                                            <span class="icon-share"></span>
                                            <ul class="clearfix">
                                                <?php if (!empty($member['social_facebook'])) : ?>
                                                <li><a href="<?php echo htmlspecialchars($member['social_facebook']); ?>"><i class="icon-facebook-app-symbol"></i></a></li>
                                                <?php endif; ?>
                                                <?php if (!empty($member['social_twitter'])) : ?>
                                                <li><a href="<?php echo htmlspecialchars($member['social_twitter']); ?>"><i class="icon-twitter"></i></a></li>
                                                <?php endif; ?>
                                                <?php if (!empty($member['social_linkedin'])) : ?>
                                                <li><a href="<?php echo htmlspecialchars($member['social_linkedin']); ?>"><i class="icon-linked-in-logo-of-two-letters"></i></a></li>
                                                <?php endif; ?>
                                                <?php if (!empty($member['social_pinterest'])) : ?>
                                                <li><a href="<?php echo htmlspecialchars($member['social_pinterest']); ?>"><i class="icon-pinterest"></i></a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="team-one__single-content">
                                        <div class="title-box">
                                            <h3><a href="#"><?php echo htmlspecialchars($member['name']); ?></a></h3>
                                            <p><?php echo htmlspecialchars($member['title']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                        <!-- If we need navigation buttons -->
                        <div class="swiper-pagination team-one__dot-style1" id="swiper-dot-style1"></div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Team One-->

        <!--Start Scrolling Text One-->
        <section class="scrolling-text-one">
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
                        <span class="stroke">Our Technology</span>
                        RapidFleet
                        <div class="icon">
                            <span class="icon-sparkler"></span>
                        </div>
                    </li>
                    <li>
                        <span class="stroke">DriveLogistics</span>
                        Real DriveLogistics
                        <div class="icon">
                            <span class="icon-sparkler"></span>
                        </div>
                    </li>

                </ul>
            </div>
        </section>
        <!--End Scrolling Text One-->

      


        <!--Start Partner style1-->
        <div class="partner-style1">
            <div class="container">
                <div class="brand-content">
                    <div class="thm-swiper__slider swiper-container" data-swiper-options='{
                        "spaceBetween": 30,
                        "slidesPerView": 2,
                        "loop": true,
                        "pagination": {
                            "el": "#testimonial-one-pagination",
                            "type": "bullets",
                            "clickable": true
                            },
                            "navigation": {
                                "nextEl": "#testimonial-two__swiper-button-next",
                                "prevEl": "#testimonial-two__swiper-button-prev"
                            },
                        "autoplay": { "delay": 5000 },
                        "breakpoints": {
                            "0": {
                                "spaceBetween": 30,
                                "slidesPerView": 1
                            },
                            "375": {
                                "spaceBetween": 30,
                                "slidesPerView": 1
                            },
                            "575": {
                                "spaceBetween": 30,
                                "slidesPerView": 2
                            },
                            "768": {
                                "spaceBetween": 30,
                                "slidesPerView": 4
                            },
                            "992": {
                                "spaceBetween": 30,
                                "slidesPerView": 5
                            },
                            "1200": {
                                "spaceBetween": 30,
                                "slidesPerView": 6
                            }
                        }}'>

                        <div class="swiper-wrapper">
                            <!--Start Single Partner Logo Box-->
                            <div class="swiper-slide">
                                <div class="single-partner-logo-box">
                                    <a href="#">
                                        <img src="assets/img/brand/brand-v1-1.png" alt="Awesome Image">
                                    </a>
                                </div>
                            </div>
                            <!--End Single Partner Logo Box-->
                            <!--Start Single Partner Logo Box-->
                            <div class="swiper-slide">
                                <div class="single-partner-logo-box">
                                    <a href="#">
                                        <img src="assets/img/brand/brand-v1-2.png" alt="Awesome Image">
                                    </a>
                                </div>
                            </div>
                            <!--End Single Partner Logo Box-->
                            <!--Start Single Partner Logo Box-->
                            <div class="swiper-slide">
                                <div class="single-partner-logo-box">
                                    <a href="#">
                                        <img src="assets/img/brand/brand-v1-3.png" alt="Awesome Image">
                                    </a>
                                </div>
                            </div>
                            <!--End Single Partner Logo Box-->
                            <!--Start Single Partner Logo Box-->
                            <div class="swiper-slide">
                                <div class="single-partner-logo-box">
                                    <a href="#">
                                        <img src="assets/img/brand/brand-v1-4.png" alt="Awesome Image">
                                    </a>
                                </div>
                            </div>
                            <!--End Single Partner Logo Box-->
                            <!--Start Single Partner Logo Box-->
                            <div class="swiper-slide">
                                <div class="single-partner-logo-box">
                                    <a href="#">
                                        <img src="assets/img/brand/brand-v1-5.png" alt="Awesome Image">
                                    </a>
                                </div>
                            </div>
                            <!--End Single Partner Logo Box-->
                            <!--Start Single Partner Logo Box-->
                            <div class="swiper-slide">
                                <div class="single-partner-logo-box">
                                    <a href="#">
                                        <img src="assets/img/brand/brand-v1-2.png" alt="Awesome Image">
                                    </a>
                                </div>
                            </div>
                            <!--End Single Partner Logo Box-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Partner style1-->

        <!--Start Footer One-->
        <footer class="footer-one">
            <!--Start Footer Middle-->
            <div class="footer-middle">
                <div class="container">
                    <div class="footer-middle__inner">
                        <div class="footer-logo-box">
                            <img src="<?php echo htmlspecialchars($settings['site_logo']); ?>" style="width: 170px;" alt="Site Logo">
                        </div>
                        <div class="phone-number-box">
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
            <div class="footer-bottom">
                <div class="container">
                    <div class="footer-bottom__inner">
                        <div class="copyright-text">
                            <p>© <?php echo htmlspecialchars($settings['sitename']); ?> <?php echo date('Y'); ?> | All Rights Reserved.</p>
                        </div>


                        <div class="copyright-menu">
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


<!-- Mirrored from itcroctheme.com/nocimon/nocimon-html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 18 Mar 2024 08:22:04 GMT -->
</html>