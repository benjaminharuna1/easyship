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
        // This is a critical error, the settings table must have the first row.
        $err = "Settings not found. Please configure your site.";
    }

    // Handle POST requests for all forms on this page
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // For main settings forms, use a transaction
        mysqli_begin_transaction($con);
        try {
            // Site settings update
            if (isset($_POST['save-site-settings'])) {
                $site_name = trim($_POST['site-name']);
                $site_title = trim($_POST['site-title']);
                $site_url = trim($_POST['site-url']);
                $email_name = trim($_POST['email-name']);
                $email_address = trim($_POST['email']);
                $geocode_api_key = trim($_POST['geocode_api_key']);

                if (empty($site_name) || empty($site_title) || empty($site_url) || empty($email_name) || empty($email_address)) {
                    throw new Exception("All general settings fields are required.");
                }
                if (!filter_var($site_url, FILTER_VALIDATE_URL)) throw new Exception("Invalid Site URL format.");
                if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) throw new Exception("Invalid email address format.");

                $update_stmt = mysqli_prepare($con, "UPDATE setting SET sitename = ?, site_title = ?, site_url = ?, email_name = ?, email_address = ?, geocode_api_key = ? WHERE id = 1");
                mysqli_stmt_bind_param($update_stmt, "ssssss", $site_name, $site_title, $site_url, $email_name, $email_address, $geocode_api_key);
                mysqli_stmt_execute($update_stmt);

                // Image upload/removal logic for Site Logo and Favicon
                $image_fields = ['site-logo' => 'site_logo', 'site-favicon' => 'site_favicon'];
                foreach ($image_fields as $input_name => $db_column) {
                    $current_image = $settings[$db_column] ?? '';

                    if (!empty($_POST['remove_' . $db_column])) {
                        if (!empty($current_image) && file_exists('../' . $current_image)) {
                            unlink('../' . $current_image);
                        }
                        $update_img_stmt = mysqli_prepare($con, "UPDATE setting SET $db_column = '' WHERE id = 1");
                        mysqli_stmt_execute($update_img_stmt);
                    } elseif (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] == 0) {
                        $target_dir = "uploads/";
                        $filename = basename($_FILES[$input_name]["name"]);
                        $target_file = $target_dir . time() . '_' . $filename;
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                        $allowed_extensions = ($db_column == 'site_logo')
                            ? ["jpg", "png", "jpeg", "gif", "svg"]
                            : ["jpg", "png", "jpeg", "gif", "ico", "svg"];

                        if (!in_array($imageFileType, $allowed_extensions)) {
                             throw new Exception("Invalid file type for " . htmlspecialchars(ucwords(str_replace('_', ' ', $db_column))) . ".");
                        }

                        // Remove old image if it exists
                        if (!empty($current_image) && file_exists('../' . $current_image)) {
                            unlink('../' . $current_image);
                        }

                        // Move new image and update DB
                        if (move_uploaded_file($_FILES[$input_name]["tmp_name"], '../' . $target_file)) {
                            $update_img_stmt = mysqli_prepare($con, "UPDATE setting SET $db_column = ? WHERE id = 1");
                            mysqli_stmt_bind_param($update_img_stmt, "s", $target_file);
                            mysqli_stmt_execute($update_img_stmt);
                        } else {
                            throw new Exception("Sorry, there was an error uploading your file.");
                        }
                    }
                }
                 $_SESSION['success_message'] = "Site settings updated successfully.";
                 header("Location: settings.php");
                 exit();
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

                $_SESSION['success_message'] = "Email settings updated successfully.";
                header("Location: settings.php#email-settings");
                exit();
            }

            mysqli_commit($con);

        } catch (Exception $e) {
            mysqli_rollback($con);
            // Stay on page to show error, don't redirect
            $err = "Error: " . $e->getMessage();
        }
    }
} catch (Exception $e) {
    // This catches errors from the initial settings fetch
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

        <div class="card">
            <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#site-settings">Site Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#email-settings">Email Settings</a>
                    </li>
                </ul>

                <div class="tab-content pt-2">
                    <!-- Site Settings Tab -->
                    <div class="tab-pane fade show active" id="site-settings">
                        <h5 class="card-title">Manage your site's general information and branding.</h5>

                        <form method="POST" action="settings.php" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Site name</label>
                                <div class="col-sm-10"><input class="form-control" type="text" name="site-name" value="<?php echo htmlspecialchars($_POST['site-name'] ?? $settings['sitename'] ?? ''); ?>" required></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Site title</label>
                                <div class="col-sm-10"><input class="form-control" type="text" name="site-title" value="<?php echo htmlspecialchars($_POST['site-title'] ?? $settings['site_title'] ?? ''); ?>" required></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Site Url</label>
                                <div class="col-sm-10"><input class="form-control" type="url" name="site-url" value="<?php echo htmlspecialchars($_POST['site-url'] ?? $settings['site_url'] ?? ''); ?>" required></div>
                            </div>
                             <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Email Name</label>
                                <div class="col-sm-10"><input class="form-control" type="text" name="email-name" value="<?php echo htmlspecialchars($_POST['email-name'] ?? $settings['email_name'] ?? ''); ?>" placeholder="The name emails will come from" required></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Email Address</label>
                                <div class="col-sm-10"><input class="form-control" type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? $settings['email_address'] ?? ''); ?>" placeholder="The email address emails will come from" required></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Geocode API Key</label>
                                <div class="col-sm-10"><input class="form-control" type="password" name="geocode_api_key" value="<?php echo htmlspecialchars($_POST['geocode_api_key'] ?? $settings['geocode_api_key'] ?? ''); ?>" placeholder="Enter your LocationIQ API key"></div>
                            </div>
                            <hr>
                            <!-- Site Logo -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Site Logo</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" id="site-logo-input" name="site-logo" onchange="previewImage(event, 'logo-preview')">
                                    <input type="hidden" name="remove_site_logo" id="remove_site_logo_input" value="">
                                    <?php $logo_src = !empty($settings['site_logo']) ? '../' . htmlspecialchars($settings['site_logo']) : ''; ?>
                                    <div class="mt-2">
                                        <img id="logo-preview" src="<?php echo $logo_src; ?>" alt="Logo Preview" style="max-width: 200px; max-height: 100px; <?php echo empty($logo_src) ? 'display: none;' : ''; ?>">
                                    </div>
                                    <?php if (!empty($logo_src)): ?>
                                    <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeImage('site-logo-input', 'logo-preview', 'remove_site_logo_input')">Remove Current Logo</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Site Favicon -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Site Favicon</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" id="site-favicon-input" name="site-favicon" onchange="previewImage(event, 'favicon-preview')">
                                    <input type="hidden" name="remove_site_favicon" id="remove_site_favicon_input" value="">
                                     <?php $favicon_src = !empty($settings['site_favicon']) ? '../' . htmlspecialchars($settings['site_favicon']) : ''; ?>
                                     <div class="mt-2">
                                        <img id="favicon-preview" src="<?php echo $favicon_src; ?>" alt="Favicon Preview" style="max-width: 50px; max-height: 50px; <?php echo empty($favicon_src) ? 'display: none;' : ''; ?>">
                                     </div>
                                     <?php if (!empty($favicon_src)): ?>
                                     <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeImage('site-favicon-input', 'favicon-preview', 'remove_site_favicon_input')">Remove Current Favicon</button>
                                     <?php endif; ?>
                                </div>
                            </div>
                            <div class="text-end">
                                <button name="save-site-settings" type="submit" class="btn btn-primary">Save Settings</button>
                            </div>
                        </form>
                    </div>

                    <!-- Email Settings Tab -->
                    <div class="tab-pane fade" id="email-settings">
                        <h5 class="card-title">Configure SMTP settings for sending emails.</h5>
                        <form method="POST" action="settings.php">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">SMTP Host</label>
                                <div class="col-sm-10"><input class="form-control" type="text" name="smtp-host" value="<?php echo htmlspecialchars($_POST['smtp-host'] ?? $settings['smtp_host'] ?? ''); ?>"></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">SMTP Username</label>
                                <div class="col-sm-10"><input class="form-control" type="text" name="smtp-username" value="<?php echo htmlspecialchars($_POST['smtp-username'] ?? $settings['smtp_username'] ?? ''); ?>"></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">SMTP Password</label>
                                <div class="col-sm-10"><input class="form-control" type="password" name="smtp-password" value="<?php echo htmlspecialchars($_POST['smtp-password'] ?? $settings['smtp_password'] ?? ''); ?>"></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">SMTP Port</label>
                                <div class="col-sm-10"><input class="form-control" type="number" name="smtp-port" value="<?php echo htmlspecialchars($_POST['smtp-port'] ?? $settings['smtp_port'] ?? ''); ?>"></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">SMTP Secure</label>
                                <div class="col-sm-10"><input class="form-control" type="text" name="smtp-secure" placeholder="e.g., tls or ssl" value="<?php echo htmlspecialchars($_POST['smtp-secure'] ?? $settings['smtp_secure'] ?? ''); ?>"></div>
                            </div>
                             <div class="text-end">
                                <button name="save-email-settings" type="submit" class="btn btn-primary">Save Email Settings</button>
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

// Preview selected image and handle removal
function previewImage(event, previewId) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById(previewId);
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}

function removeImage(inputId, previewId, removeFlagId) {
    document.getElementById(inputId).value = ''; // Clear the file input
    document.getElementById(previewId).src = '';
    document.getElementById(previewId).style.display = 'none';
    document.getElementById(removeFlagId).value = '1'; // Set flag to remove on save
}
</script>

<?php include 'footer.php'; ?>