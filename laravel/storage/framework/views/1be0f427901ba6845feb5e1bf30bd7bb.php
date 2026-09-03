<?php $__env->startSection('title', 'Edit Team Member'); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Edit Team Member</h5>
            <form method="POST" action="<?php echo e(route('admin.team.update', $member->id)); ?>" enctype="multipart/form-data">
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
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name', $member->name)); ?>" required>
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
                    <label class="form-label">Title / Role</label>
                    <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="title" value="<?php echo e(old('title', $member->title)); ?>" required>
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
                    <label class="form-label">Image</label>
                    <?php if($member->image): ?>
                        <div class="mb-2"><img src="<?php echo e(asset($member->image)); ?>" style="max-width:150px;" class="rounded-circle"></div>
                    <?php endif; ?>
                    <input type="file" class="form-control" name="image">
                    <input type="hidden" name="current_image" value="<?php echo e($member->image); ?>">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Facebook URL</label>
                        <input type="url" class="form-control" name="social_facebook" value="<?php echo e(old('social_facebook', $member->social_facebook)); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Twitter URL</label>
                        <input type="url" class="form-control" name="social_twitter" value="<?php echo e(old('social_twitter', $member->social_twitter)); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">LinkedIn URL</label>
                        <input type="url" class="form-control" name="social_linkedin" value="<?php echo e(old('social_linkedin', $member->social_linkedin)); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pinterest URL</label>
                        <input type="url" class="form-control" name="social_pinterest" value="<?php echo e(old('social_pinterest', $member->social_pinterest)); ?>">
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" <?php echo e($member->is_published ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="is_published">Published</label>
                </div>

                <button type="submit" class="btn btn-primary">Update Member</button>
                <a href="<?php echo e(route('admin.team.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\admin\edit-team.blade.php ENDPATH**/ ?>