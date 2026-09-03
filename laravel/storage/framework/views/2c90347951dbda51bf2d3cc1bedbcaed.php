<?php $__env->startSection('title', 'Admin Profile'); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Admin Profile</h5>
            <table class="table align-middle mb-3">
                <tr>
                    <th style="width:150px;">Email</th>
                    <td><?php echo e($admin->email); ?></td>
                </tr>
            </table>
            <a href="<?php echo e(route('admin.profile.edit')); ?>" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\admin\admin-profile.blade.php ENDPATH**/ ?>