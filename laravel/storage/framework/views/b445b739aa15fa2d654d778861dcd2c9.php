<?php $__env->startSection('email_title', 'Shipment Created - ' . ($tracking_id ?? '')); ?>

<?php $__env->startSection('content'); ?>
    <p>Dear <?php echo e($name ?? 'Customer'); ?>,</p>
    <p>We are pleased to inform you that your shipment has been registered with us at <strong><?php echo e($settings->sitename ?? 'EasyShip'); ?></strong>.</p>

    <div style="background:#f4f6f9; border-left:4px solid #f6a400; padding:20px; margin:20px 0; border-radius:4px;">
        <p style="margin:0 0 12px; font-weight:bold; text-align:center; font-size:16px;">Tracking Information</p>

        <table style="width:100%; font-size:14px; border-collapse:collapse;">
            <tr>
                <td style="padding:6px 0; color:#555; width:45%;"><strong>Tracking Number</strong></td>
                <td style="padding:6px 0;"><strong style="color:#C40202;"><?php echo e($tracking_id ?? ''); ?></strong></td>
            </tr>
            <tr>
                <td style="padding:6px 0; color:#555;"><strong>Status</strong></td>
                <td style="padding:6px 0;"><?php echo e($status ?? ''); ?></td>
            </tr>
            <tr>
                <td style="padding:6px 0; color:#555;"><strong>Package</strong></td>
                <td style="padding:6px 0;"><?php echo e($package_description ?? ''); ?></td>
            </tr>
            <tr>
                <td style="padding:6px 0; color:#555;"><strong>Dispatch Location</strong></td>
                <td style="padding:6px 0;"><?php echo e($dispatch_location ?? ''); ?></td>
            </tr>
            <tr>
                <td style="padding:6px 0; color:#555;"><strong>Estimated Delivery Date</strong></td>
                <td style="padding:6px 0;"><?php echo e($delivery_date ?? ''); ?></td>
            </tr>
        </table>
    </div>

    <p>
        For more information visit the
        <a href="<?php echo e(rtrim($settings->site_url ?? '', '/')); ?>/track/<?php echo e($tracking_id); ?>" style="color:#f6a400;">Tracking Page</a>.
    </p>
    <p>Thank you for choosing <?php echo e($settings->sitename ?? 'EasyShip'); ?>.</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\emails\shipment_creation.blade.php ENDPATH**/ ?>