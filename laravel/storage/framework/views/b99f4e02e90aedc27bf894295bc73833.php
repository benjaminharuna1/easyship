<!-- Start Extra Info -->
<div class="extra-info">
    <div class="close-icon menu-close">
        <button>
            <i class="icon-close"></i>
        </button>
    </div>
    <div class="logo-side">
        <a href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset($settings->site_logo ?? '')); ?>" alt="Logo"></a>
    </div>
    <div class="side-info">
        <div class="menu-outer">
            
        </div>
    </div>
</div>
<div class="offcanvas-overly"></div>
<!-- End Extra Info -->

<style>
    .extra-info .menu-outer .navigation {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .extra-info .menu-outer .navigation > li {
        margin-bottom: 10px;
    }
    .extra-info .menu-outer .navigation > li > a {
        display: block;
        font-size: 16px;
        font-weight: 500;
        color: #131313;
        text-transform: capitalize;
        padding: 8px 0;
        border-bottom: 1px solid rgba(19, 19, 19, 0.08);
        transition: all 0.3s ease;
    }
    .extra-info .menu-outer .navigation > li > a:hover,
    .extra-info .menu-outer .navigation > li.active > a {
        color: #ef3724;
    }
</style>

<?php $__env->startPush('scripts'); ?>
<script>
    $(function () {
        var navHtml = $(".navbar-wrap.main-menu .navigation").clone();
        $(".extra-info .side-info .menu-outer").html(navHtml);
    });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\wamp64\www\easyship\laravel\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>