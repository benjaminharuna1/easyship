<?php $__env->startSection('email_title', 'Test Email'); ?>

<?php $__env->startSection('content'); ?>
    <h2 style="margin:0 0 15px; color:#041e42;">Test Email</h2>
    <p>Hello!</p>
    <p>This is a test email to confirm that your email configuration is working correctly.</p>
    <p>If you are reading this, it means your SMTP settings are configured properly and emails are being sent successfully from <strong><?php echo e($settings->sitename ?? 'EasyShip'); ?></strong>.</p>
    <p>No action is required. You can safely ignore this message.</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\emails\test_email.blade.php ENDPATH**/ ?>