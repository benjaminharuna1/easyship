<?php
// All PHP logic now comes before any HTML output.
// This includes includes, session handling, and form processing.
include 'auth.php'; // Handles session, DB connection, and login check

// Enable mysqli exceptions for error handling
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Initialize variables
$msg = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);
$err = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']);

$settings = [];

try {
    // Fetch all settings from the database first
    $stmt = mysqli_prepare($con, "SELECT * FROM setting WHERE id = 1");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $settings = mysqli_fetch_assoc($result);
    } else {
        $err = "Settings not found. Please configure your site.";
    }

    // Handle POST requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Handle Test Email Submission
        if (isset($_POST['send-test-email'])) {
            $test_email_recipient = trim($_POST['test-email-recipient']);
            if (!filter_var($test_email_recipient, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = "Invalid recipient email address for the test email.";
            } else {
                $subject = "SMTP Test Email from " . ($settings['Sitename'] ?? 'your site');
                if (sendMail($test_email_recipient, $subject, 'test_email', [])) {
                    $_SESSION['success_message'] = "Test email sent successfully to " . htmlspecialchars($test_email_recipient);
                } else {
                    $_SESSION['error_message'] = "Failed to send test email. Please check your SMTP settings and try again.";
                }
            }
            header("Location: settings.php#email-settings");
            exit();
        }

        // All other updates require a transaction
        mysqli_begin_transaction($con);
        try {
            // General settings update
            if (isset($_POST['save'])) {
                $site_name = trim($_POST['site-name']);
                $site_title = trim($_POST['site-title']);
                $site_url = trim($_POST['site-url']);
                $email_name = trim($_POST['email-name']);
                $email_address = trim($_POST['email']);

                if (empty($site_name) || empty($site_title) || empty($site_url) || empty($email_name) || empty($email_address)) {
                    throw new Exception("All general settings fields are required.");
                }
                if (!filter_var($site_url, FILTER_VALIDATE_URL)) throw new Exception("Invalid Site URL format.");
                if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) throw new Exception("Invalid email address format.");

                $update_stmt = mysqli_prepare($con, "UPDATE setting SET Sitename = ?, site_title = ?, site_url = ?, email_name = ?, email_address = ? WHERE id = 1");
                mysqli_stmt_bind_param($update_stmt, "sssss", $site_name, $site_title, $site_url, $email_name, $email_address);
                mysqli_stmt_execute($update_stmt);
            }

            // Email settings update
            if (isset($_POST['save-email-settings'])) {
                $smtp_host = $_POST['smtp-host'];
                $smtp_username = $_POST['smtp-username'];
                $smtp_password = $_POST['smtp-password'];
                $smtp_port = $_POST['smtp-port'];
                $smtp_secure = $_POST['smtp-secure'];

                $update_stmt = mysqli_prepare($con, "UPDATE setting SET smtp_host = ?, smtp_username = ?, smtp_password = ?, smtp_port = ?, smtp_secure = ? WHERE id = 1");
                mysqli_stmt_bind_param($update_stmt, "sssss", $smtp_host, $smtp_username, $smtp_password, $smtp_port, $smtp_secure);
                mysqli_stmt_execute($update_stmt);
            }

            // Image upload/removal logic
            $image_fields = ['site-logo' => 'site_logo', 'site-favicon' => 'site_favicon'];
            foreach ($image_fields as $input_name => $db_column) {
                if (isset($_POST['remove_' . $db_column])) {
                    if (!empty($settings[$db_column]) && file_exists('../' . $settings[$db_column])) {
                        unlink('../' . $settings[$db_column]);
                    }
                    $update_img_stmt = mysqli_prepare($con, "UPDATE setting SET $db_column = '' WHERE id = 1");
                    mysqli_stmt_execute($update_img_stmt);
                } elseif (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] == 0) {
                    $target_dir = "uploads/";
                    $filename = basename($_FILES[$input_name]["name"]);
                    $target_file = $target_dir . time() . '_' . $filename;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $allowed_extensions = ($db_column == 'site_logo') ? ["jpg", "png", "jpeg", "gif"] : ["jpg", "png", "jpeg", "gif", "ico", "svg"];

                    if (!in_array($imageFileType, $allowed_extensions)) throw new Exception("Invalid file type for " . htmlspecialchars($input_name) . ".");
                    if (!empty($settings[$db_column]) && file_exists('../' . $settings[$db_column])) unlink('../' . $settings[$db_column]);

                    if (move_uploaded_file($_FILES[$input_name]["tmp_name"], '../' . $target_file)) {
                        $update_img_stmt = mysqli_prepare($con, "UPDATE setting SET $db_column = ? WHERE id = 1");
                        mysqli_stmt_bind_param($update_img_stmt, "s", $target_file);
                        mysqli_stmt_execute($update_img_stmt);
                    } else {
                        throw new Exception("Sorry, there was an error uploading your file.");
                    }
                }
            }

            mysqli_commit($con);
            $_SESSION['success_message'] = "Settings updated successfully.";
            header("Location: settings.php" . (isset($_POST['save-email-settings']) ? '#email-settings' : ''));
            exit();

        } catch (Exception $e) {
            mysqli_rollback($con);
            // Stay on page to show error, don't redirect
            $err = "Error: " . $e->getMessage();
        }
    }
} catch (Exception $e) {
    $err = "Database Error: " . $e->getMessage();
}

// Now that all logic is done, we can start outputting the page
include 'header.php';
?>

<div class="page-wrapper">
    <div class="page-content">
        <h1>Settings</h1>

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

        <section class="section profile">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#profile-overview">Site Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#email-settings">Email Settings</a>
                            </li>
                        </ul>

                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title"></h5>

                                <form method="POST" action="settings.php">
                                    <div class="mb-3"><label class="form-label">Site name</label><input class="form-control" type="text" name="site-name" value="<?php echo htmlspecialchars($settings['Sitename'] ?? ''); ?>"></div>
                                    <div class="mb-3"><label class="form-label">Site title</label><input class="form-control" type="text" name="site-title" value="<?php echo htmlspecialchars($settings['site_title'] ?? ''); ?>"></div>
                                    <div class="mb-3"><label class="form-label">Site Url</label><input class="form-control" type="text" name="site-url" value="<?php echo htmlspecialchars($settings['site_url'] ?? ''); ?>"></div>
                                    <div class="mb-3"><label class="form-label">Email Name</label><input class="form-control" type="text" name="email-name" value="<?php echo htmlspecialchars($settings['email_name'] ?? ''); ?>"></div>
                                    <div class="mb-3"><label class="form-label">Email Address</label><input class="form-control" type="email" name="email" value="<?php echo htmlspecialchars($settings['email_address'] ?? ''); ?>"></div>
                                    <button name="save" type="submit" class="btn btn-primary">Save Settings</button>
                                </form>
                                <hr>
                                <form method="POST" action="settings.php" enctype="multipart/form-data" class="mb-4">
                                    <div class="mb-3">
                                        <label class="form-label">Site Logo</label>
                                        <?php if (!empty($settings['site_logo'])) : ?>
                                            <div class="mb-2"><img src="../<?php echo htmlspecialchars($settings['site_logo']); ?>" alt="Site Logo" style="max-width: 200px; max-height: 100px;"><button type="submit" name="remove_site_logo" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Remove</button></div>
                                        <?php endif; ?>
                                        <div class="input-group"><input class="form-control" type="file" name="site-logo"><button name="upload-logo" type="submit" class="btn btn-primary">Upload</button></div>
                                    </div>
                                </form>
                                <hr>
                                <form method="POST" action="settings.php" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label class="form-label">Site Favicon</label>
                                        <?php if (!empty($settings['site_favicon'])) : ?>
                                            <div class="mb-2"><img src="../<?php echo htmlspecialchars($settings['site_favicon']); ?>" alt="Site Favicon" style="max-width: 50px; max-height: 50px;"><button type="submit" name="remove_site_favicon" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Remove</button></div>
                                        <?php endif; ?>
                                        <div class="input-group"><input class="form-control" type="file" name="site-favicon"><button name="upload-favicon" type="submit" class="btn btn-primary">Upload</button></div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="email-settings">
                                <h5 class="card-title"></h5>
                                <form method="POST" action="settings.php">
                                    <div class="mb-3"><label class="form-label">SMTP Host</label><input class="form-control" type="text" name="smtp-host" value="<?php echo htmlspecialchars($settings['smtp_host'] ?? ''); ?>"></div>
                                    <div class="mb-3"><label class="form-label">SMTP Username</label><input class="form-control" type="text" name="smtp-username" value="<?php echo htmlspecialchars($settings['smtp_username'] ?? ''); ?>"></div>
                                    <div class="mb-3"><label class="form-label">SMTP Password</label><input class="form-control" type="password" name="smtp-password" value="<?php echo htmlspecialchars($settings['smtp_password'] ?? ''); ?>"></div>
                                    <div class="mb-3"><label class="form-label">SMTP Port</label><input class="form-control" type="text" name="smtp-port" value="<?php echo htmlspecialchars($settings['smtp_port'] ?? ''); ?>"></div>
                                    <div class="mb-3"><label class="form-label">SMTP Secure</label><input class="form-control" type="text" name="smtp-secure" placeholder="e.g., tls or ssl" value="<?php echo htmlspecialchars($settings['smtp_secure'] ?? ''); ?>"></div>
                                    <button name="save-email-settings" type="submit" class="btn btn-primary">Save Email Settings</button>
                                </form>
                                <hr>
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#testEmailModal">Send Test Email</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Test Email Modal -->
<div class="modal fade" id="testEmailModal" tabindex="-1" aria-labelledby="testEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testEmailModalLabel">Send Test Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="settings.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="test-email-recipient" class="form-label">Recipient Email</label>
                        <input type="email" class="form-control" id="test-email-recipient" name="test-email-recipient" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="send-test-email" class="btn btn-primary">Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Logic to stay on the correct tab after a page reload/redirect
document.addEventListener('DOMContentLoaded', function() {
    if (location.hash) {
        const tabTrigger = document.querySelector('a[href="' + location.hash + '"]');
        if (tabTrigger) {
            new bootstrap.Tab(tabTrigger).show();
        }
    }
});
</script>

<?php include 'footer.php'; ?>