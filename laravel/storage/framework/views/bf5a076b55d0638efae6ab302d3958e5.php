<?php $__env->startSection('title', ($settings->sitename ?? 'EasyShip') . ' | ' . $page->page_title); ?>

<?php $__env->startSection('page_content'); ?>

    <!--Start Legal Content Section-->
    <section class="legal-content-section" style="padding: 120px 0;">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="legal-content-box">
                        <?php echo $page->page_content; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Legal Content Section-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.subpage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\legal.blade.php ENDPATH**/ ?>