<?php $__env->startSection('title', 'Support Messages'); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Support Messages</h5>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Company</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($i + 1); ?></td>
                                <td><?php echo e($msg->name); ?></td>
                                <td><?php echo e($msg->email); ?></td>
                                <td><?php echo e($msg->mobile); ?></td>
                                <td><?php echo e($msg->company); ?></td>
                                <td><?php echo e($msg->message); ?></td>
                                <td><?php echo e($msg->created_at ? $msg->created_at->format('d M Y') : ''); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="7" class="text-center text-muted">No support messages.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\admin\support-messages.blade.php ENDPATH**/ ?>