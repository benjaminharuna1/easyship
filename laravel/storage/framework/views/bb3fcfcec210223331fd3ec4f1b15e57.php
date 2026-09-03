<?php $__env->startSection('title', 'Edit Service'); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Edit Service</h5>
            <form method="POST" action="<?php echo e(route('admin.services.update', $service->id)); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="title" value="<?php echo e(old('title', $service->title)); ?>" required>
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
                    <label class="form-label">Icon Class</label>
                    <input type="text" class="form-control" name="icon_class" value="<?php echo e(old('icon_class', $service->icon_class)); ?>" placeholder="e.g., icon-air-freight">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="description" rows="4" required><?php echo e(old('description', $service->description)); ?></textarea>
                    <?php $__errorArgs = ['description'];
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
                    <?php if($service->image): ?>
                        <div class="mb-2"><img src="<?php echo e(asset($service->image)); ?>" style="max-width:200px;" class="rounded"></div>
                    <?php endif; ?>
                    <input type="file" class="form-control" name="image">
                    <input type="hidden" name="current_image" value="<?php echo e($service->image); ?>">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" <?php echo e($service->is_published ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="is_published">Published</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" <?php echo e($service->is_featured ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="is_featured">Featured</label>
                </div>
                <button type="submit" class="btn btn-primary">Update Service</button>
                <a href="<?php echo e(route('admin.services.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\admin\edit-service.blade.php ENDPATH**/ ?>