<?php $__env->startSection('email_title', ($settings->sitename ?? 'EasyShip') . ' Notification'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $body ?? ''; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\emails\custom.blade.php ENDPATH**/ ?>