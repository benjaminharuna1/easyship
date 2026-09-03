<?php $__env->startSection('title', 'Testimonials'); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Add New Testimonial</h5>
                    <form method="POST" action="<?php echo e(route('admin.testimonials.store')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" value="<?php echo e(old('title')); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select class="form-control" name="rating" required>
                                <?php for($r = 1; $r <= 5; $r++): ?>
                                    <option value="<?php echo e($r); ?>" <?php echo e(old('rating') == $r ? 'selected' : ''); ?>><?php echo e($r); ?> Star<?php echo e($r > 1 ? 's' : ''); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Review Text</label>
                            <textarea class="form-control" name="review_text" rows="4" required><?php echo e(old('review_text')); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" checked>
                            <label class="form-check-label" for="is_published">Published</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Testimonial</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">All Testimonials</h5>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($i + 1); ?></td>
                                        <td>
                                            <?php if($testimonial->image): ?>
                                                <img src="<?php echo e(asset($testimonial->image)); ?>" width="50" height="50" class="rounded-circle" style="object-fit:cover;">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($testimonial->name); ?></td>
                                        <td><?php echo e($testimonial->title); ?></td>
                                        <td>
                                            <?php for($r = 1; $r <= 5; $r++): ?>
                                                <span class="text-warning"><?php echo e($r <= $testimonial->rating ? '★' : '☆'); ?></span>
                                            <?php endfor; ?>
                                        </td>
                                        <td>
                                            <?php if($testimonial->is_published): ?>
                                                <span class="badge bg-success">Published</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Unpublished</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.testimonials.edit', $testimonial->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <form method="POST" action="<?php echo e(route('admin.testimonials.destroy', $testimonial->id)); ?>" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="7" class="text-center text-muted">No testimonials added yet.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\admin\testimonials.blade.php ENDPATH**/ ?>