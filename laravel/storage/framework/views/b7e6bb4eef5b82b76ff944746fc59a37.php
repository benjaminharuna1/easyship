<?php $__env->startSection('title', 'Team'); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Add New Team Member</h5>
                    <form method="POST" action="<?php echo e(route('admin.team.store')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title / Role</label>
                            <input type="text" class="form-control" name="title" value="<?php echo e(old('title')); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" checked>
                            <label class="form-check-label" for="is_published">Published</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Member</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">All Team Members</h5>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $teamMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($i + 1); ?></td>
                                        <td>
                                            <?php if($member->image): ?>
                                                <img src="<?php echo e(asset($member->image)); ?>" width="50" height="50" class="rounded-circle" style="object-fit:cover;">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($member->name); ?></td>
                                        <td><?php echo e($member->title); ?></td>
                                        <td>
                                            <?php if($member->is_published): ?>
                                                <span class="badge bg-success">Published</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Unpublished</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.team.edit', $member->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <form method="POST" action="<?php echo e(route('admin.team.destroy', $member->id)); ?>" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="6" class="text-center text-muted">No team members added yet.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\admin\team.blade.php ENDPATH**/ ?>