<?php $__env->startSection('title', 'Legal Pages'); ?>

<?php $__env->startSection('content'); ?>

    <form method="POST" action="<?php echo e(route('admin.legal.update')); ?>">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Terms & Conditions</h5>
                        <div class="mb-3">
                            <label class="form-label">Page Title</label>
                            <input type="text" class="form-control" name="terms_title" value="<?php echo e(old('terms_title', $terms->page_title)); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea class="form-control js-summernote" name="terms_content" rows="10"><?php echo e(old('terms_content', $terms->page_content)); ?></textarea>
                            <small class="text-muted">Use [SITENAME] shortcode for the site name.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Privacy Policy</h5>
                        <div class="mb-3">
                            <label class="form-label">Page Title</label>
                            <input type="text" class="form-control" name="privacy_title" value="<?php echo e(old('privacy_title', $privacy->page_title)); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea class="form-control js-summernote" name="privacy_content" rows="10"><?php echo e(old('privacy_content', $privacy->page_content)); ?></textarea>
                            <small class="text-muted">Use [SITENAME] shortcode for the site name.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Update Legal Pages</button>
            </div>
        </div>
    </form>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(function() {
        $('.js-summernote').summernote({
            height: 250,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['codeview', 'undo', 'redo']]
            ]
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\admin\legal.blade.php ENDPATH**/ ?>