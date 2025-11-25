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
                                <textarea class="form-control" name="terms_content" rows="15"><?php echo htmlspecialchars($terms['page_content']); ?></textarea>
                            </div>
                            <div class="text-end">
                                <button name="update_terms" type="submit" class="btn btn-primary">Save Terms</button>
                            </div>
                        </form>
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
                                <textarea class="form-control" name="privacy_content" rows="15"><?php echo htmlspecialchars($privacy['page_content']); ?></textarea>
                            </div>
                             <div class="text-end">
                                <button name="update_privacy" type="submit" class="btn btn-primary">Save Privacy Policy</button>
                            </div>
                        </form>
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

<?php include 'footer.php'; ?>
