<?php $__env->startSection('title', 'Edit Testimonial'); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Edit Testimonial</h5>
            <form method="POST" action="<?php echo e(route('admin.testimonials.update', $testimonial->id)); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name', $testimonial->name)); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="title" value="<?php echo e(old('title', $testimonial->title)); ?>" required>
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <select class="form-control" name="rating" required>
                        <?php for($r = 1; $r <= 5; $r++): ?>
                            <option value="<?php echo e($r); ?>" <?php echo e(old('rating', $testimonial->rating) == $r ? 'selected' : ''); ?>><?php echo e($r); ?> Star<?php echo e($r > 1 ? 's' : ''); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Review Text</label>
                    <textarea class="form-control <?php $__errorArgs = ['review_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="review_text" rows="4" required><?php echo e(old('review_text', $testimonial->review_text)); ?></textarea>
                    <?php $__errorArgs = ['review_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <?php if($testimonial->image): ?>
                        <div class="mb-2"><img src="<?php echo e(asset($testimonial->image)); ?>" style="max-width:150px;" class="rounded-circle"></div>
                    <?php endif; ?>
                    <input type="file" class="form-control" name="image">
                    <input type="hidden" name="current_image" value="<?php echo e($testimonial->image); ?>">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" <?php echo e($testimonial->is_published ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="is_published">Published</label>
                </div>

                <button type="submit" class="btn btn-primary">Update Testimonial</button>
                <a href="<?php echo e(route('admin.testimonials.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\admin\edit-testimonial.blade.php ENDPATH**/ ?>