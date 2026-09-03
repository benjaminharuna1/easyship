<?php $__env->startSection('content_wrapper'); ?>
    <div class="page-wrapper">

        <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <main>
            <!--Start Banner One-->
            <section class="banner-one">
                <div class="banner-one__bg wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms"
                    style="background-image: url(<?php echo e(asset($settings->home_banner_image ?: 'assets/img/slider/banner-one__mian-img.jpg')); ?>);">
                </div>

                <div class="banner-one__bg-shape wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                    <div class="border-box"></div>
                </div>

                <div class="banner-one__shape1">
                    <img class="float-bob-y" src="<?php echo e(asset('assets/img/shape/banner-one__shape1.png')); ?>" alt="#">
                </div>
                <div class="banner-one__shape2 wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                    <img class="float-bob-y" src="<?php echo e(asset('assets/img/shape/banner-one__shape2.png')); ?>" alt="#">
                </div>
                <div class="container">
                    <div class="banner-one__content wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                        <div class="sub-title">
                            <h5><?php echo e($settings->hero_subtitle); ?></h5>
                        </div>
                        <div class="big-title">
                            <h2><?php echo $settings->hero_title; ?></h2>
                        </div>
                        <div class="text">
                            <p><?php echo e($settings->hero_text); ?></p>
                        </div>
                        <div class="btn-box">
                            <a class="thm-btn" href="<?php echo e(route('track')); ?>">
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

            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>

    <?php echo $__env->yieldPushContent('home_scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\layouts\home.blade.php ENDPATH**/ ?>