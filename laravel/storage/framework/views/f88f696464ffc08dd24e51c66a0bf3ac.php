<?php $__env->startSection('content'); ?>

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
                <?php $__currentLoopData = $featuredServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xl-4 col-lg-4 col-md-4 wow fadeInLeft" data-wow-delay="<?php echo e($index * 200); ?>ms" data-wow-duration="1500ms">
                    <div class="service-one__single">
                        <div class="service-one__single-icon-box">
                            <div class="left-icon-box">
                                <span class="<?php echo e($service->icon_class); ?>"></span>
                            </div>
                            <div class="right-icon-box">
                                <a href="<?php echo e(route('services')); ?>"><span class="icon-next"></span></a>
                            </div>
                        </div>
                        <div class="service-one__single-content">
                            <h3><a href="<?php echo e(route('services')); ?>"><?php echo e($service->title); ?></a></h3>
                            <p><?php echo e(\Illuminate\Support\Str::limit($service->description, 150)); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <img src="<?php echo e(asset('assets/img/about/about-one__img1.jpg')); ?>" alt="#">
                        </div>
                        <div class="about-one__overlay-box text-center wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="outer-box">
                                <div class="count-outer count-box">
                                    <h2 class="odometer" data-count="<?php echo e($settings->years_experience); ?>">00</h2>
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
                            <p>At <?php echo e($settings->sitename); ?>, we are more than just a courier service; we are your dedicated logistics partner. We understand that behind every package is a promise, a commitment, or a critical business need. That’s why we’ve built our reputation on a foundation of trust, reliability, and unparalleled customer service.</p>
                        </div>
                        <ul>
                            <li>
                                <div class="icon">
                                    <span class="icon-check"></span>
                                </div>
                                <div class="text-box">
                                    <h3>Global Network</h3>
                                    <p>With a vast network of partners and agents worldwide, we offer seamless international shipping and customs clearance.</p>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <span class="icon-check"></span>
                                </div>
                                <div class="text-box">
                                    <h3>Advanced Tracking</h3>
                                    <p>Our state-of-the-art tracking system provides real-time updates, giving you complete visibility from pickup to delivery.</p>
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
                        <li class="single-fact-counter wow fadeInUp" data-wow-delay=".3s">
                            <div class="icon"><span class="icon-delivery"></span></div>
                            <div class="outer-box">
                                <div class="count-outer count-box">
                                    <h2 class="odometer" data-count="<?php echo e($settings->achievement_1_num); ?>">00</h2>
                                    <i class="icon-add"></i>
                                </div>
                                <div class="title"><p><?php echo e($settings->achievement_1_title); ?></p></div>
                            </div>
                        </li>
                        <li class="single-fact-counter wow fadeInDown" data-wow-delay=".3s">
                            <div class="icon"><span class="icon-package"></span></div>
                            <div class="outer-box">
                                <div class="count-outer count-box">
                                    <h2 class="odometer" data-count="<?php echo e($settings->achievement_2_num); ?>">00</h2>
                                    <i class="icon-add"></i>
                                </div>
                                <div class="title"><p><?php echo e($settings->achievement_2_title); ?></p></div>
                            </div>
                        </li>
                        <li class="single-fact-counter wow fadeInUp" data-wow-delay=".3s">
                            <div class="icon"><span class="icon-packages2"></span></div>
                            <div class="outer-box">
                                <div class="count-outer count-box">
                                    <h2 class="odometer" data-count="<?php echo e($settings->achievement_3_num); ?>">00</h2>
                                    <i class="icon-add"></i>
                                </div>
                                <div class="title"><p><?php echo e($settings->achievement_3_title); ?></p></div>
                            </div>
                        </li>
                        <li class="single-fact-counter wow fadeInDown" data-wow-delay=".3s">
                            <div class="icon"><span class="icon-delivery-truck"></span></div>
                            <div class="outer-box">
                                <div class="count-outer count-box">
                                    <h2 class="odometer" data-count="<?php echo e($settings->achievement_4_num); ?>">00</h2>
                                    <?php if(!empty($settings->achievement_4_suffix)): ?><i class="k"><?php echo e($settings->achievement_4_suffix); ?></i><?php endif; ?>
                                    <i class="icon-add"></i>
                                </div>
                                <div class="title"><p><?php echo e($settings->achievement_4_title); ?></p></div>
                            </div>
                        </li>
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
                            <h2>Efficient solutions<br>logistics needs</h2>
                        </div>
                        <div class="text">
                            <p>We specialize in providing tailored logistics solutions that meet the unique needs of our clients. From small parcels to large-scale freight, our experienced team ensures your shipments are delivered safely and on schedule.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s">
                            <div class="project-one__single">
                                <div class="project-one__single-img">
                                    <div class="inner">
                                        <img src="<?php echo e(asset('assets/img/project/project-one__img1.jpg')); ?>" alt="#">
                                    </div>
                                </div>
                                <div class="project-one__single-content text-center">
                                    <div class="title-box">
                                        <h3><a href="#">Express Logix</a></h3>
                                        <p>Swift, reliable, and efficient logistics solutions for your business needs.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s">
                            <div class="project-one__single">
                                <div class="project-one__single-img">
                                    <div class="inner">
                                        <img src="<?php echo e(asset('assets/img/project/project-one__img2.jpg')); ?>" alt="#">
                                    </div>
                                </div>
                                <div class="project-one__single-content text-center">
                                    <div class="title-box">
                                        <h3><a href="#">Prime Cargo</a></h3>
                                        <p>Swift and reliable logistics partner for your shipping needs.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s">
                            <div class="project-one__single">
                                <div class="project-one__single-img">
                                    <div class="inner">
                                        <img src="<?php echo e(asset('assets/img/project/project-one__img3.jpg')); ?>" alt="#">
                                    </div>
                                </div>
                                <div class="project-one__single-content text-center">
                                    <div class="title-box">
                                        <h3><a href="#">Speedy Transit</a></h3>
                                        <p>Your fast, reliable logistics solution.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s">
                            <div class="project-one__single">
                                <div class="project-one__single-img">
                                    <div class="inner">
                                        <img src="<?php echo e(asset('assets/img/project/project-one__img4.jpg')); ?>" alt="#">
                                    </div>
                                </div>
                                <div class="project-one__single-content text-center">
                                    <div class="title-box">
                                        <h3><a href="#">Prime Cargo</a></h3>
                                        <p>Your premier logistics partner, ensuring fast and reliable delivery.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Project One-->

    <!--Start Video One-->
    <section class="video-one">
        <div class="video-one__bg" data-jarallax data-speed="0.1" data-imgPosition="0% 0%"
            style="background-image: url(<?php echo e(asset($settings->video_bg_image)); ?>);"></div>
        <div class="icon wow zoomIn animated" data-wow-delay="300ms" data-wow-duration="1500ms">
            <a class="video-popup" title="Video Gallery" href="<?php echo e($settings->video_url); ?>">
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
                    "pagination": { "el": "#testimonial-one-pagination", "type": "bullets", "clickable": true },
                    "navigation": { "nextEl": "#testimonial-two__swiper-button-next", "prevEl": "#testimonial-two__swiper-button-prev" },
                    "autoplay": { "delay": 5000 },
                    "breakpoints": {
                        "0": { "spaceBetween": 30, "slidesPerView": 1 },
                        "992": { "spaceBetween": 30, "slidesPerView": 2 }
                    }}'>
                    <div class="swiper-wrapper">
                        <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                            <div class="testimonials-one__single">
                                <div class="testimonials-one__single-img">
                                    <div class="testimonials-one__single-img__inner">
                                        <div class="inner">
                                            <img src="<?php echo e(asset($testimonial->image)); ?>" alt="">
                                        </div>
                                        <div class="overlay-box">
                                            <span class="icon-quote-right"></span>
                                        </div>
                                    </div>
                                    <div class="title-box">
                                        <h3><a href="#"><?php echo e($testimonial->name); ?></a></h3>
                                        <p><?php echo e($testimonial->title); ?></p>
                                    </div>
                                </div>
                                <div class="testimonials-one__single-content">
                                    <div class="ster-icon">
                                        <ul>
                                            <?php for($i = 0; $i < $testimonial->rating; $i++): ?>
                                            <li>
                                                <div class="icon">
                                                    <span class="icon-star-1"></span>
                                                </div>
                                            </li>
                                            <?php endfor; ?>
                                        </ul>
                                        <p>Reviews (0<?php echo e($testimonial->rating); ?>)</p>
                                    </div>
                                    <div class="text">
                                        <p>"<?php echo e($testimonial->review_text); ?>"</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <div class="btn-box">
                    <a class="thm-btn" href="<?php echo e(route('contact')); ?>">
                        <span class="txt">
                            Get in touch
                            <i class="icon-next"></i>
                        </span>
                    </a>
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
                    "spaceBetween": 50, "speed": 1500, "slidesPerView": 3, "loop": true,
                    "pagination": { "el": "#swiper-dot-style1", "type": "bullets", "clickable": true },
                    "navigation": { "nextEl": "#team-one__swiper-button-next", "prevEl": "#team-one__swiper-button-prev" },
                    "autoplay": { "delay": 5000 },
                    "breakpoints": {
                        "0": { "spaceBetween": 30, "slidesPerView": 1 },
                        "768": { "spaceBetween": 30, "slidesPerView": 2 },
                        "992": { "spaceBetween": 30, "slidesPerView": 3 },
                        "1200": { "spaceBetween": 40, "slidesPerView": 4 }
                    }}'>
                    <div class="swiper-wrapper">
                        <?php $__currentLoopData = $teamMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                            <div class="team-one__single">
                                <div class="team-one__single-img">
                                    <img src="<?php echo e(asset($member->image)); ?>" alt="#">
                                    <div class="social-share-box">
                                        <span class="icon-share"></span>
                                        <ul class="clearfix">
                                            <?php if(!empty($member->social_facebook)): ?><li><a href="<?php echo e($member->social_facebook); ?>"><i class="icon-facebook-app-symbol"></i></a></li><?php endif; ?>
                                            <?php if(!empty($member->social_twitter)): ?><li><a href="<?php echo e($member->social_twitter); ?>"><i class="icon-twitter"></i></a></li><?php endif; ?>
                                            <?php if(!empty($member->social_linkedin)): ?><li><a href="<?php echo e($member->social_linkedin); ?>"><i class="icon-linked-in-logo-of-two-letters"></i></a></li><?php endif; ?>
                                            <?php if(!empty($member->social_pinterest)): ?><li><a href="<?php echo e($member->social_pinterest); ?>"><i class="icon-pinterest"></i></a></li><?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="team-one__single-content">
                                    <div class="title-box">
                                        <h3><a href="#"><?php echo e($member->name); ?></a></h3>
                                        <p><?php echo e($member->title); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
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
                    "spaceBetween": 30, "slidesPerView": 2, "loop": true,
                    "pagination": { "el": "#testimonial-one-pagination", "type": "bullets", "clickable": true },
                    "navigation": { "nextEl": "#testimonial-two__swiper-button-next", "prevEl": "#testimonial-two__swiper-button-prev" },
                    "autoplay": { "delay": 5000 },
                    "breakpoints": {
                        "0": { "spaceBetween": 30, "slidesPerView": 1 },
                        "575": { "spaceBetween": 30, "slidesPerView": 2 },
                        "768": { "spaceBetween": 30, "slidesPerView": 4 },
                        "992": { "spaceBetween": 30, "slidesPerView": 5 },
                        "1200": { "spaceBetween": 30, "slidesPerView": 6 }
                    }}'>
                    <div class="swiper-wrapper">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                        <div class="swiper-slide">
                            <div class="single-partner-logo-box">
                                <a href="#">
                                    <img src="<?php echo e(asset('assets/img/brand/brand-v1-' . $i . '.png')); ?>" alt="Awesome Image">
                                </a>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Partner style1-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\home.blade.php ENDPATH**/ ?>