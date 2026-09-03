<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('email_title', ($settings->sitename ?? 'EasyShip') . ' Mail'); ?></title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f9; font-family:Arial, Helvetica, sans-serif;">
    <div style="max-width:600px; margin:0 auto; background-color:#ffffff;">
        <div style="background:<?php echo e($settings->email_primary_color ?: '#041e42'); ?>; padding:24px 30px; text-align:center;">
            <?php if(!empty($settings->site_logo)): ?>
                <img src="<?php echo e(asset($settings->site_logo)); ?>" alt="<?php echo e($settings->sitename); ?>" style="max-height:60px; display:inline-block;">
            <?php else: ?>
                <strong style="color:#ffffff; font-size:22px;"><?php echo e($settings->sitename ?? 'EasyShip'); ?></strong>
            <?php endif; ?>
        </div>

        <div style="padding:30px; color:#333; line-height:1.7; font-size:15px;">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <div style="background:#f4f6f9; padding:20px 30px; text-align:center; color:#888; font-size:13px;">
            <p style="margin:0 0 4px;"><strong><?php echo e($settings->sitename ?? 'EasyShip'); ?></strong></p>
            <?php if(!empty($settings->site_address)): ?>
                <p style="margin:0 0 4px;"><?php echo nl2br(e($settings->site_address)); ?></p>
            <?php endif; ?>
            <?php if(!empty($settings->email_address)): ?>
                <p style="margin:0 0 4px;"><?php echo e($settings->email_address); ?></p>
            <?php endif; ?>
            <?php if(!empty($settings->email_footer_text)): ?>
                <p style="margin:8px 0 0; padding-top:8px; border-top:1px solid #e2e6ea; color:#aaa;"><?php echo e($settings->email_footer_text); ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\emails\layout.blade.php ENDPATH**/ ?>