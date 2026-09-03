<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title', $settings->site_title ?? 'EasyShip'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', ''); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if(($settings->search_engine_indexing ?? 1) == 0): ?>
    <meta name="robots" content="noindex, nofollow">
    <?php endif; ?>

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset($settings->site_favicon ?? '')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/01-bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/02-all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/03-jquery.magnific-popup.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/04-nice-select.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/05-odometer.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/06-swiper.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/07-animate.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/08-custom-animate.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/09-slick.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/10-icomoon.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/custom-animate/custom-animate.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/jarallax/jarallax.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/odometer/odometer.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/responsive.css')); ?>">

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="body-gray-bg">

    <?php echo $__env->make('partials.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if (! empty(trim($__env->yieldContent('content_wrapper')))): ?>
        <?php echo $__env->yieldContent('content_wrapper'); ?>
    <?php else: ?>
        <div class="page-wrapper">

            <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <main>
                <?php echo $__env->yieldContent('content'); ?>
            </main>

            <?php if (! empty(trim($__env->yieldContent('footer')))): ?>
                <?php echo $__env->yieldContent('footer'); ?>
            <?php else: ?>
                <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

        </div>
    <?php endif; ?>

    <button class="scroll-top scroll-to-target" data-target="html">
        <i class="icon-arrowhead-up"></i>
    </button>

    <!-- JS here -->
    <script src="<?php echo e(asset('assets/js/jquery-3.6.0.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/01-ajax-form.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/02-bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/03-jquery.appear.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/04-swiper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/05-jquery.odometer.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/06-jquery.magnific-popup.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/07-jquery.nice-select.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/08-slick.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/09-wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/10-jquery.circleType.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/11-jquery.lettering.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/12-TweenMax.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/jarallax/jarallax.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/marquee/marquee.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/odometer/odometer.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html>
<?php /**PATH C:\wamp64\www\easyship\laravel\resources\views/layouts/base.blade.php ENDPATH**/ ?>