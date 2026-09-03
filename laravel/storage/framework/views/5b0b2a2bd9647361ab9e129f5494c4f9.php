<?php $__env->startSection('title', ($settings->sitename ?? 'EasyShip') . ' | Contact'); ?>

<?php $__env->startSection('page_content'); ?>

    <section class="contact-one">
        <div class="container">
            <?php if(!empty($msg)): ?>
                <div class="alert alert-success"><?php echo e($msg); ?></div>
            <?php endif; ?>
            <?php if(!empty($err)): ?>
                <div class="alert alert-danger"><?php echo e($err); ?></div>
            <?php endif; ?>
            <div class="sec-title text-center">
                <div class="sub-title">
                    <h4>Contact us</h4>
                </div>
                <h2>
                    Get in Touch With Us
                </h2>
            </div>
            <div class="row">

                <div class="col-xl-4">
                    <div class="contact-one__list-item">
                        <ul>
                            <li>
                                <div class="icon">
                                    <span class="icon-location-pin"></span>
                                </div>
                                <div class="text">
                                    <h4>Address</h4>
                                    <p>
                                        <?php echo nl2br(e($settings->site_address)); ?>

                                    </p>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <span class="icon-phone-call-1"></span>
                                </div>
                                <div class="text">
                                    <h4>Lets Talk us</h4>
                                    <p>Fax: <a href="tel:<?php echo e($settings->fax_number); ?>"><?php echo e($settings->fax_number); ?></a></p>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <span class="icon-envelope"></span>
                                </div>
                                <div class="text">
                                    <h4>Send us email</h4>
                                    <p>
                                        <a href="mailto:<?php echo e($settings->email_address); ?>"><?php echo e($settings->email_address); ?></a>
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-12">
                    <div class="contact-one__form">
                        <form id="contact-form" method="POST" action="<?php echo e(route('contact')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="contact-one__input-box">
                                        <input type="text" placeholder="Full name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="contact-one__input-box">
                                        <input type="email" placeholder="Email Address" name="email" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="contact-one__input-box">
                                        <input type="number" placeholder="Mobile" name="number">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="contact-one__input-box">
                                        <input type="text" placeholder="Company" name="company">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="contact-one__input-box text-message-box">
                                        <textarea name="message" placeholder="Messege" required></textarea>
                                    </div>
                                    <div class="contact-one__btn-box">
                                        <button class="thm-btn" type="submit" data-loading-text="Please wait...">
                                            <span class="txt">Submit Now</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <p class="ajax-response mb-0"></p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--Contact One End-->

    <!--Start Google Map One-->
    <?php if((int)($settings->show_contact_map ?? 1) === 1): ?>
        <section class="google-map-one">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4562.753041141002!2d-118.80123790098536!3d34.152323469614075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80e82469c2162619%3A0xba03efb7998eef6d!2sCostco+Wholesale!5e0!3m2!1sbn!2sbd!4v1562518641290!5m2!1sbn!2sbd"
                class="google-map-one__map" allowfullscreen></iframe>
        </section>
    <?php endif; ?>
    <!--End Google Map One-->

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

<?php echo $__env->make('layouts.subpage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\contact.blade.php ENDPATH**/ ?>