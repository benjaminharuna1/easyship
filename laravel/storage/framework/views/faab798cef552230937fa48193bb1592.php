<!--Start Page Header-->
<section class="page-header">
    <div class="page-header__img float-bob-y"><img src="<?php echo e(asset($settings->page_banner_image ?: 'assets/img/resource/page-header-img.png')); ?>" alt=""></div>
    <div class="container">
        <div class="page-header__inner">
            <h2><?php echo e($title); ?></h2>
            <ul class="thm-breadcrumb">
                <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                <li><span class="icon-left"></span></li>
                <li><?php echo e($title); ?></li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Header-->
<?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\partials\page-header.blade.php ENDPATH**/ ?>