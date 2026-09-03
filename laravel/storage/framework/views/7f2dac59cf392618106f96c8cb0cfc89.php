<!--Start Footer One-->
<footer class="footer-one">
    <div class="footer-middle <?php echo e(isset($footerVariant) ? 'footer-middle' . $footerVariant : ''); ?>">
        <div class="container">
            <div class="footer-middle__inner">
                <div class="footer-logo-box">
                    <img src="<?php echo e(asset($settings->site_logo ?? '')); ?>" style="width: 170px;" alt="Site Logo">
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom <?php echo e(isset($footerVariant) ? 'footer-bottom' . $footerVariant : ''); ?>">
        <div class="container">
            <div class="footer-bottom__inner">
                <div class="copyright-text <?php echo e(isset($footerVariant) ? 'copyright-text--two' : ''); ?>">
                    <p>© <?php echo e($settings->sitename); ?> <?php echo e(date('Y')); ?> | All Rights Reserved.</p>
                </div>

                <div class="copyright-menu <?php echo e(isset($footerVariant) ? 'copyright-menu--two' : ''); ?>">
                    <ul>
                        <li>
                            <p><a href="<?php echo e(route('terms')); ?>">Terms &amp; Condition</a></p>
                        </li>
                        <li>
                            <p><a href="<?php echo e(route('privacy')); ?>">Privacy Policy</a></p>
                        </li>
                        <li>
                            <p><a href="<?php echo e(route('contact')); ?>">Contact Us</a></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--End Footer One-->
<?php /**PATH C:\wamp64\www\easyship\laravel\resources\views/partials/footer.blade.php ENDPATH**/ ?>