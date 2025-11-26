<?php
include 'auth.php';

// Enable mysqli exceptions for error handling
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$msg = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);
$err = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']);

try {
    // Handle POST requests for updating legal content
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $page_slug = '';
        $page_title = '';
        $page_content = '';
        $redirect_hash = '';

        if (isset($_POST['update_terms'])) {
            $page_slug = 'terms-and-conditions';
            $page_title = text_input($_POST['terms_title']);
            $page_content = sanitize_html_input($_POST['terms_content']); // Sanitize HTML content
            $redirect_hash = '#terms';
        } elseif (isset($_POST['update_privacy'])) {
            $page_slug = 'privacy-policy';
            $page_title = text_input($_POST['privacy_title']);
            $page_content = sanitize_html_input($_POST['privacy_content']); // Sanitize HTML content
            $redirect_hash = '#privacy';
        }

        if (!empty($page_slug)) {
            $stmt = mysqli_prepare($con, "UPDATE legal_pages SET page_title = ?, page_content = ? WHERE page_slug = ?");
            mysqli_stmt_bind_param($stmt, "sss", $page_title, $page_content, $page_slug);
            mysqli_stmt_execute($stmt);

            $_SESSION['success_message'] = "Page content updated successfully.";
            header("Location: legal.php" . $redirect_hash);
            exit();
        }
    }

    // Fetch the current content for both pages
    $legal_pages_result = mysqli_query($con, "SELECT * FROM legal_pages");
    $legal_pages = [];
    while ($row = mysqli_fetch_assoc($legal_pages_result)) {
        $legal_pages[$row['page_slug']] = $row;
    }

    $terms = $legal_pages['terms-and-conditions'] ?? ['page_title' => 'Terms & Conditions', 'page_content' => ''];
    $privacy = $legal_pages['privacy-policy'] ?? ['page_title' => 'Privacy Policy', 'page_content' => ''];

} catch (Exception $e) {
    $err = "Database Error: " . $e->getMessage();
}

include 'header.php';
?>

<!-- Quill.js CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div class="page-wrapper">
    <div class="page-content">
        <h1>Manage Legal Pages</h1>

        <?php if (!empty($msg)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($msg); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($err)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($err); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#terms">Terms & Conditions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#privacy">Privacy Policy</a>
                    </li>
                </ul>

                <div class="tab-content pt-2">
                    <!-- Terms & Conditions Tab -->
                    <div class="tab-pane fade show active" id="terms">
                        <h5 class="card-title">Edit the content for the Terms & Conditions page.</h5>
                        <form method="POST" action="legal.php">
                            <div class="mb-3">
                                <label class="form-label">Page Title</label>
                                <input class="form-control" type="text" name="terms_title" value="<?php echo htmlspecialchars($terms['page_title']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Page Content</label>
                                <div id="terms_editor" style="height: 300px;"><?php echo $terms['page_content']; ?></div>
                                <input type="hidden" name="terms_content" id="terms_content">
                            </div>
                            <div class="text-end">
                                <button name="update_terms" type="submit" class="btn btn-primary">Save Terms</button>
                            </div>
                        </form>
                        <div class="mt-3">
                            <small class="form-text text-muted">
                                <strong>Note:</strong> You can use the following shortcodes to display dynamic information:
                                <code>[site-name]</code>, <code>[site-url]</code>, <code>[email-name]</code>, <code>[email-address]</code>, <code>[phone-number]</code>, <code>[fax-number]</code>, <code>[site-address]</code>.
                            </small>
                        </div>
                    </div>

                    <!-- Privacy Policy Tab -->
                    <div class="tab-pane fade" id="privacy">
                        <h5 class="card-title">Edit the content for the Privacy Policy page.</h5>
                        <form method="POST" action="legal.php">
                            <div class="mb-3">
                                <label class="form-label">Page Title</label>
                                <input class="form-control" type="text" name="privacy_title" value="<?php echo htmlspecialchars($privacy['page_title']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Page Content</label>
                                <div id="privacy_editor" style="height: 300px;"><?php echo $privacy['page_content']; ?></div>
                                <input type="hidden" name="privacy_content" id="privacy_content">
                            </div>
                             <div class="text-end">
                                <button name="update_privacy" type="submit" class="btn btn-primary">Save Privacy Policy</button>
                            </div>
                        </form>
                        <div class="mt-3">
                            <small class="form-text text-muted">
                                <strong>Note:</strong> You can use the following shortcodes to display dynamic information:
                                <code>[site-name]</code>, <code>[site-url]</code>, <code>[email-name]</code>, <code>[email-address]</code>, <code>[phone-number]</code>, <code>[fax-number]</code>, <code>[site-address]</code>.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Logic to stay on the correct tab after a page reload/redirect
document.addEventListener('DOMContentLoaded', function() {
    if (location.hash) {
        const tabTrigger = document.querySelector('a.nav-link[href="' + location.hash + '"]');
        if (tabTrigger) {
            new bootstrap.Tab(tabTrigger).show();
        }
    }
});
</script>

<!-- Quill.js JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Define the toolbar options
    var toolbarOptions = [
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],
        [{ 'direction': 'rtl' }],
        [{ 'size': ['small', false, 'large', 'huge'] }],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'font': [] }],
        [{ 'align': [] }],
        ['clean'],
        ['link', 'image', 'video']
    ];

    // Initialize Quill editor for Terms & Conditions
    var termsEditor = new Quill('#terms_editor', {
        theme: 'snow',
        modules: {
            toolbar: toolbarOptions
        }
    });

    // Initialize Quill editor for Privacy Policy
    var privacyEditor = new Quill('#privacy_editor', {
        theme: 'snow',
        modules: {
            toolbar: toolbarOptions
        }
    });

    // Update hidden inputs on form submit
    var termsForm = document.querySelector('#terms form');
    termsForm.onsubmit = function() {
        var content = document.querySelector('input[name=terms_content]');
        content.value = termsEditor.root.innerHTML;
    };

    var privacyForm = document.querySelector('#privacy form');
    privacyForm.onsubmit = function() {
        var content = document.querySelector('input[name=privacy_content]');
        content.value = privacyEditor.root.innerHTML;
    };
});
</script>

<?php include 'footer.php'; ?>
