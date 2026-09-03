<?php $__env->startSection('title', ($settings->sitename ?? 'EasyShip') . ' | Track Shipment'); ?>

<?php $__env->startSection('page_content'); ?>

    <section class="contact-one">
        <div class="container">
            <?php if(session('error')): ?>
                <div class="alert alert-danger" style="text-align:center;"><?php echo e(session('error')); ?></div>
            <?php endif; ?>
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="contact-one__form">
                        <div class="sec-title text-center">
                            <div class="sub-title">
                                <h4>Track Your Shipment</h4>
                            </div>
                            <h2>
                                Enter Your Tracking Number
                            </h2>
                            <p>Enter the tracking number provided to you to see the real-time status of your shipment.</p>
                        </div>
                        <form id="track-form" method="GET" action="<?php echo e(route('track')); ?>">
                            <div class="row">
                                <div class="col-xl-9 col-lg-9">
                                    <div class="contact-one__input-box">
                                        <input type="text" class="form-control" name="search_P" placeholder="Enter Tracking number" value="<?php echo e(old('search_P', request('search_P'))); ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3">
                                    <div class="contact-one__input-box">
                                        <button name="search" class="thm-btn" style="padding: 10px; margin-top: 0px;" type="submit">
                                            <b class="txt">Track</b>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

<?php echo $__env->make('layouts.subpage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\track.blade.php ENDPATH**/ ?>