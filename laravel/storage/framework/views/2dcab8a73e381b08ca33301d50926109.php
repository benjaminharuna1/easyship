<?php $__env->startSection('title', ($settings->sitename ?? 'EasyShip') . ' | Services'); ?>

<?php $__env->startSection('page_content'); ?>

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
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInLeft" data-wow-delay="<?php echo e(($index % 3) * 200); ?>ms" data-wow-duration="1500ms">
                    <div class="service-three__single">
                        <div class="service-three__single-img">
                            <img src="<?php echo e(asset($service->image)); ?>" alt="<?php echo e($service->title); ?>">
                            <div class="service-three__single-img-bg"></div>
                        </div>
                        <div class="service-three__single-content">
                            <div class="icon">
                                <span class="<?php echo e($service->icon_class); ?>"></span>
                            </div>
                            <div class="title">
                                <h3><a href="#"><?php echo e($service->title); ?></a></h3>
                            </div>
                            <div class="text">
                                <p><?php echo e($service->description); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End FAQ One-->

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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.subpage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\services.blade.php ENDPATH**/ ?>