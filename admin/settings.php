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
                $phone_number = trim($_POST['phone_number']);
                $fax_number = trim($_POST['fax_number']);
                $site_address = trim($_POST['site_address']);
                $site_currency = trim($_POST['site_currency']);
                $geocode_api_key = trim($_POST['geocode_api_key']);
                $working_days = trim($_POST['working_days']);
                $working_hours = trim($_POST['working_hours']);

                if (empty($site_name) || empty($site_title) || empty($site_url) || empty($email_name) || empty($email_address) || empty($site_currency)) {
                    throw new Exception("All general settings fields are required.");
                }
                if (!filter_var($site_url, FILTER_VALIDATE_URL)) throw new Exception("Invalid Site URL format.");
                if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) throw new Exception("Invalid email address format.");

                $update_stmt = mysqli_prepare($con, "UPDATE setting SET sitename = ?, site_title = ?, site_url = ?, email_name = ?, email_address = ?, phone_number = ?, fax_number = ?, site_address = ?, site_currency = ?, geocode_api_key = ?, working_days = ?, working_hours = ? WHERE id = 1");
                mysqli_stmt_bind_param($update_stmt, "ssssssssssss", $site_name, $site_title, $site_url, $email_name, $email_address, $phone_number, $fax_number, $site_address, $site_currency, $geocode_api_key, $working_days, $working_hours);
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
                mysqli_commit($con);
                 $_SESSION['success_message'] = "Site settings updated successfully.";
                 header("Location: settings.php");
                 exit();
            }

            // Homepage content update
            if (isset($_POST['save-homepage-content'])) {
                $hero_subtitle = text_input($_POST['hero_subtitle']);
                $hero_title = text_input($_POST['hero_title']);
                $hero_text = text_input($_POST['hero_text']);
                $years_experience = (int)$_POST['years_experience'];
                $achievement_1_num = (int)$_POST['achievement_1_num'];
                $achievement_1_title = text_input($_POST['achievement_1_title']);
                $achievement_2_num = (int)$_POST['achievement_2_num'];
                $achievement_2_title = text_input($_POST['achievement_2_title']);
                $achievement_3_num = (int)$_POST['achievement_3_num'];
                $achievement_3_title = text_input($_POST['achievement_3_title']);
                $achievement_4_num = (int)$_POST['achievement_4_num'];
                $achievement_4_suffix = text_input($_POST['achievement_4_suffix']);
                $achievement_4_title = text_input($_POST['achievement_4_title']);
                $video_url = text_input($_POST['video_url']);

                // Handle video background image upload
                $video_bg_image = $_POST['current_video_bg_image'];
                if (isset($_FILES['video_bg_image']) && $_FILES['video_bg_image']['error'] == 0) {
                    $target_dir = "uploads/";
                    $filename = basename($_FILES["video_bg_image"]["name"]);
                    $target_file = $target_dir . time() . '_' . $filename;
                    if (move_uploaded_file($_FILES["video_bg_image"]["tmp_name"], '../' . $target_file)) {
                        $video_bg_image = $target_file;
                    } else {
                        throw new Exception("Sorry, there was an error uploading the video background image.");
                    }
                }

                $update_stmt = mysqli_prepare($con, "UPDATE setting SET hero_subtitle=?, hero_title=?, hero_text=?, years_experience=?, achievement_1_num=?, achievement_1_title=?, achievement_2_num=?, achievement_2_title=?, achievement_3_num=?, achievement_3_title=?, achievement_4_num=?, achievement_4_suffix=?, achievement_4_title=?, video_url=?, video_bg_image=? WHERE id=1");
                mysqli_stmt_bind_param($update_stmt, "sssiisisiisssss", $hero_subtitle, $hero_title, $hero_text, $years_experience, $achievement_1_num, $achievement_1_title, $achievement_2_num, $achievement_2_title, $achievement_3_num, $achievement_3_title, $achievement_4_num, $achievement_4_suffix, $achievement_4_title, $video_url, $video_bg_image);
                mysqli_stmt_execute($update_stmt);

                mysqli_commit($con);
                $_SESSION['success_message'] = "Homepage content updated successfully.";
                header("Location: settings.php#homepage-content");
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

                mysqli_commit($con);
                $_SESSION['success_message'] = "Email settings updated successfully.";
                header("Location: settings.php#email-settings");
                exit();
            }

            // General settings update
            if (isset($_POST['save-general-settings'])) {
                // Checkboxes send 'on' or nothing. We convert to boolean 1 or 0.
                $maintenance_mode = isset($_POST['maintenance_mode']) ? 1 : 0;
                $search_indexing = isset($_POST['search_engine_indexing']) ? 1 : 0;

                $update_stmt = mysqli_prepare($con, "UPDATE setting SET maintenance_mode = ?, search_engine_indexing = ? WHERE id = 1");
                mysqli_stmt_bind_param($update_stmt, "ii", $maintenance_mode, $search_indexing);
                mysqli_stmt_execute($update_stmt);

                // Also update robots.txt based on the search indexing setting
                $robots_content = $search_indexing ? "User-agent: *\nAllow: /" : "User-agent: *\nDisallow: /";
                if (file_put_contents('../robots.txt', $robots_content) === false) {
                    throw new Exception("Could not write to robots.txt. Please check file permissions.");
                }

                // Update .htaccess to block or allow bots
                $htaccess_path = '../.htaccess';
                if (!is_writable($htaccess_path)) {
                    throw new Exception(".htaccess file is not writable. Please check file permissions.");
                }
                $htaccess_content = file_get_contents($htaccess_path);
                if ($htaccess_content === false) {
                    throw new Exception("Could not read from .htaccess. Please check file permissions.");
                }
                $bot_blocking_rules = <<<EOT
# BEGIN Block Bad Bots
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{HTTP_USER_AGENT} (googlebot|bingbot|slurp|duckduckbot|baiduspider|yandexbot|sogou|exabot|facebot|ia_archiver) [NC]
RewriteRule ^.*$ - [F,L]
</IfModule>
# END Block Bad Bots
EOT;

                // Remove existing bot blocking rules
                $htaccess_content = preg_replace('/# BEGIN Block Bad Bots.*?# END Block Bad Bots\n?/s', '', $htaccess_content);

                if (!$search_indexing) {
                    // Add the bot blocking rules
                    $htaccess_content .= "\n" . $bot_blocking_rules;
                }

                file_put_contents($htaccess_path, $htaccess_content);

                mysqli_commit($con);
                $_SESSION['success_message'] = "General settings updated successfully.";
                header("Location: settings.php#general-settings");
                exit();
            }

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
                        <a class="nav-link" data-bs-toggle="tab" href="#homepage-content">Homepage Content</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#email-settings">Email Settings</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#general-settings">General</a>
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
                                <label class="col-sm-2 col-form-label">Phone Number</label>
                                <div class="col-sm-10"><input class="form-control" type="text" name="phone_number" value="<?php echo htmlspecialchars($_POST['phone_number'] ?? $settings['phone_number'] ?? ''); ?>" placeholder="Enter your contact phone number"></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Fax Number</label>
                                <div class="col-sm-10"><input class="form-control" type="text" name="fax_number" value="<?php echo htmlspecialchars($_POST['fax_number'] ?? $settings['fax_number'] ?? ''); ?>" placeholder="Enter your contact fax number"></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Site Address</label>
                                <div class="col-sm-10"><textarea class="form-control" name="site_address" rows="3" placeholder="Enter your company address"><?php echo htmlspecialchars($_POST['site_address'] ?? $settings['site_address'] ?? ''); ?></textarea></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Site Currency</label>
                                <div class="col-sm-10"><input class="form-control" type="text" name="site_currency" value="<?php echo htmlspecialchars($_POST['site_currency'] ?? $settings['site_currency'] ?? ''); ?>" placeholder="e.g., $, €, £" required></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Geocode API Key</label>
                                <div class="col-sm-10"><input class="form-control" type="password" name="geocode_api_key" value="<?php echo htmlspecialchars($_POST['geocode_api_key'] ?? $settings['geocode_api_key'] ?? ''); ?>" placeholder="Enter your LocationIQ API key"></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Working Days</label>
                                <div class="col-sm-10"><input class="form-control" type="text" name="working_days" value="<?php echo htmlspecialchars($_POST['working_days'] ?? $settings['working_days'] ?? ''); ?>" placeholder="e.g., Monday - Friday"></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Working Hours</label>
                                <div class="col-sm-10"><input class="form-control" type="text" name="working_hours" value="<?php echo htmlspecialchars($_POST['working_hours'] ?? $settings['working_hours'] ?? ''); ?>" placeholder="e.g., 9 AM - 5 PM"></div>
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

                    <!-- Homepage Content Tab -->
                    <div class="tab-pane fade" id="homepage-content">
                        <h5 class="card-title">Manage the dynamic content on your homepage.</h5>
                        <form method="POST" action="settings.php" enctype="multipart/form-data">
                            <!-- Hero Section -->
                            <h6 class="mb-3">Hero Section</h6>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Hero Subtitle</label>
                                <div class="col-sm-9"><input class="form-control" type="text" name="hero_subtitle" value="<?php echo htmlspecialchars($settings['hero_subtitle'] ?? ''); ?>"></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Hero Title</label>
                                <div class="col-sm-9"><textarea class="form-control" name="hero_title" rows="3"><?php echo htmlspecialchars($settings['hero_title'] ?? ''); ?></textarea></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Hero Text</label>
                                <div class="col-sm-9"><textarea class="form-control" name="hero_text" rows="2"><?php echo htmlspecialchars($settings['hero_text'] ?? ''); ?></textarea></div>
                            </div>
                            <hr>
                            <!-- Years of Experience -->
                             <h6 class="mb-3">Experience Counter</h6>
                             <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Years of Experience</label>
                                <div class="col-sm-9"><input class="form-control" type="number" name="years_experience" value="<?php echo htmlspecialchars($settings['years_experience'] ?? '10'); ?>"></div>
                            </div>
                            <hr>
                            <!-- Achievements Section -->
                            <h6 class="mb-3">Achievements Section</h6>
                            <div class="row mb-3 align-items-center">
                                <div class="col-sm-3"><label class="col-form-label">Achievement 1</label></div>
                                <div class="col-sm-4"><input class="form-control" type="number" name="achievement_1_num" value="<?php echo htmlspecialchars($settings['achievement_1_num'] ?? ''); ?>" placeholder="Number"></div>
                                <div class="col-sm-5"><input class="form-control" type="text" name="achievement_1_title" value="<?php echo htmlspecialchars($settings['achievement_1_title'] ?? ''); ?>" placeholder="Title"></div>
                            </div>
                             <div class="row mb-3 align-items-center">
                                <div class="col-sm-3"><label class="col-form-label">Achievement 2</label></div>
                                <div class="col-sm-4"><input class="form-control" type="number" name="achievement_2_num" value="<?php echo htmlspecialchars($settings['achievement_2_num'] ?? ''); ?>" placeholder="Number"></div>
                                <div class="col-sm-5"><input class="form-control" type="text" name="achievement_2_title" value="<?php echo htmlspecialchars($settings['achievement_2_title'] ?? ''); ?>" placeholder="Title"></div>
                            </div>
                             <div class="row mb-3 align-items-center">
                                <div class="col-sm-3"><label class="col-form-label">Achievement 3</label></div>
                                <div class="col-sm-4"><input class="form-control" type="number" name="achievement_3_num" value="<?php echo htmlspecialchars($settings['achievement_3_num'] ?? ''); ?>" placeholder="Number"></div>
                                <div class="col-sm-5"><input class="form-control" type="text" name="achievement_3_title" value="<?php echo htmlspecialchars($settings['achievement_3_title'] ?? ''); ?>" placeholder="Title"></div>
                            </div>
                             <div class="row mb-3 align-items-center">
                                <div class="col-sm-3"><label class="col-form-label">Achievement 4</label></div>
                                <div class="col-sm-3"><input class="form-control" type="number" name="achievement_4_num" value="<?php echo htmlspecialchars($settings['achievement_4_num'] ?? ''); ?>" placeholder="Number"></div>
                                <div class="col-sm-2"><input class="form-control" type="text" name="achievement_4_suffix" value="<?php echo htmlspecialchars($settings['achievement_4_suffix'] ?? ''); ?>" placeholder="Suffix (e.g., k)"></div>
                                <div class="col-sm-4"><input class="form-control" type="text" name="achievement_4_title" value="<?php echo htmlspecialchars($settings['achievement_4_title'] ?? ''); ?>" placeholder="Title"></div>
                            </div>
                            <hr>
                            <!-- Video Section -->
                            <h6 class="mb-3">Video Section</h6>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">YouTube Video URL</label>
                                <div class="col-sm-9"><input class="form-control" type="url" name="video_url" value="<?php echo htmlspecialchars($settings['video_url'] ?? ''); ?>"></div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Background Image</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="file" name="video_bg_image">
                                    <input type="hidden" name="current_video_bg_image" value="<?php echo htmlspecialchars($settings['video_bg_image'] ?? ''); ?>">
                                     <?php if (!empty($settings['video_bg_image'])): ?>
                                        <img src="../<?php echo htmlspecialchars($settings['video_bg_image']); ?>" width="200" class="mt-2">
                                     <?php endif; ?>
                                </div>
                            </div>

                            <div class="text-end">
                                <button name="save-homepage-content" type="submit" class="btn btn-primary">Save Homepage Content</button>
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

                    <!-- General Settings Tab -->
                    <div class="tab-pane fade" id="general-settings">
                        <h5 class="card-title">Manage general site settings.</h5>
                        <form method="POST" action="settings.php">
                            <!-- Maintenance Mode -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Maintenance Mode</label>
                                <div class="col-sm-8">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenance_mode" <?php echo ($settings['maintenance_mode'] ?? 0) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="maintenance_mode">Enable maintenance mode</label>
                                    </div>
                                    <small class="form-text text-muted">When enabled, only admins can access the site. A maintenance page will be shown to all other visitors.</small>
                                </div>
                            </div>

                            <!-- Search Engine Indexing -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Search Engine Indexing</label>
                                <div class="col-sm-8">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="search_engine_indexing" id="search_engine_indexing" <?php echo ($settings['search_engine_indexing'] ?? 1) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="search_engine_indexing">Allow search engine indexing</label>
                                    </div>
                                    <small class="form-text text-muted">When disabled, search engines will be discouraged from indexing your site via meta tags and an updated robots.txt.</small>
                                </div>
                            </div>

                            <div class="text-end">
                                <button name="save-general-settings" type="submit" class="btn btn-primary">Save General Settings</button>
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