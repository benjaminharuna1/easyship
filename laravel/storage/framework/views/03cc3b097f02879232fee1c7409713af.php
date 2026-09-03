<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<?php use Illuminate\Support\Str; ?>

    <div class="row row-cols-1 row-cols-xl-4 row-cols-md-2">
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Shipments</p>
                            <h4 class="my-1 text-primary"><?php echo e($totalShipments); ?></h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-light-primary text-primary ms-auto"><i class="bx bxs-package"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Pending</p>
                            <h4 class="my-1 text-warning"><?php echo e($pendingShipments); ?></h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-light-warning text-warning ms-auto"><i class="bx bxs-hourglass"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">In Transit</p>
                            <h4 class="my-1 text-info"><?php echo e($inTransit); ?></h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-light-info text-info ms-auto"><i class="bx bxs-truck"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Delivered</p>
                            <h4 class="my-1 text-success"><?php echo e($delivered); ?></h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-light-success text-success ms-auto"><i class="bx bxs-check-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card radius-10 mt-3">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h5 class="mb-0">Recently Updated Shipments</h5>
                <a href="<?php echo e(route('admin.shipments.list')); ?>" class="btn btn-primary btn-sm ms-auto">View All Shipments</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Package Image</th>
                            <th>Package name</th>
                            <th>Tracking Number</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $shipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $imagePath = $row->image ? asset('uploads/' . $row->image) : 'https://placehold.co/100x60/EEE/31343C.png?text=Package';
                            ?>
                            <tr>
                                <td><?php echo e($i + 1); ?></td>
                                <td><img src="<?php echo e($imagePath); ?>" alt="" width="100" height="60"></td>
                                <td>
                                    <div class="ms-2">
                                        <h6 class="mb-1 font-14"><?php echo e($row->package_discription); ?></h6>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-1">
                                        <span><?php echo e($row->tracking_id); ?></span>
                                        <button type="button" class="btn btn-sm btn-link p-0 border-0" title="Copy tracking number" onclick="copyContent('<?php echo e($row->tracking_id); ?>')"><i class="bx bx-copy"></i></button>
                                    </div>
                                </td>
                                <td><?php echo e($row->status); ?></td>
                                <td><?php echo e($row->updated_at ? $row->updated_at->format('d M Y H:i') : ($row->date_added ?: 'N/A')); ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="<?php echo e(route('admin.shipments.edit', $row->tracking_id)); ?>"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                            <li>
                                                <form method="POST" action="<?php echo e(route('admin.shipments.destroy', $row->tracking_id)); ?>" onsubmit="return confirm('Do you really want to delete this ?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="dropdown-item text-danger"><i class="bx bx-trash me-2"></i>Delete</button>
                                                </form>
                                            </li>
                                            <li><a class="dropdown-item" target="_blank" href="<?php echo e(route('track.print', $row->tracking_id)); ?>"><i class="bx bx-printer me-2"></i>Print Receipt</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="7" class="text-center text-muted">No shipments found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card radius-10 mt-3">
        <div class="card-body">
            <h5 class="mb-3">Recent Support Messages</h5>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $supportMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($msg->name); ?></td>
                                <td><?php echo e($msg->email); ?></td>
                                <td><?php echo e($msg->mobile); ?></td>
                                <td><?php echo e(Str::limit($msg->message, 60)); ?></td>
                                <td><?php echo e($msg->created_at ? $msg->created_at->format('d M Y') : ''); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="5" class="text-center text-muted">No support messages.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function copyContent(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert("Tracking Number Copied: " + text);
            }, function(err) {
                console.error('Failed to copy: ', err);
            });
        }
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>