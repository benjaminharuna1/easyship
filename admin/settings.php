<?php
include 'header.php';

$msg = "";
$err = "";
if (isset($_POST['save'])) {
    $site_name = trim($_POST['site-name']);
    $site_title = trim($_POST['site-title']);
    $site_url = trim($_POST['site-url']);
    $email_name = trim($_POST['email-name']);
    $email_address = trim($_POST['email']);

    // Validation
    if (empty($site_name)) $err = "Site name is required.";
    elseif (empty($site_title)) $err = "Site title is required.";
    elseif (empty($site_url)) $err = "Site URL is required.";
    elseif (!filter_var($site_url, FILTER_VALIDATE_URL)) $err = "Invalid Site URL format.";
    elseif (empty($email_name)) $err = "Email name is required.";
    elseif (empty($email_address)) $err = "Email address is required.";
    elseif (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) $err = "Invalid email address format.";

    if (empty($err)) {
        $stmt = mysqli_prepare($con, "UPDATE setting SET Sitename = ?, site_title = ?, site_url = ?, email_name = ?, email_address = ?");
        mysqli_stmt_bind_param($stmt, "sssss", $site_name, $site_title, $site_url, $email_name, $email_address);
        if (mysqli_stmt_execute($stmt)) {
            $msg = "Settings updated successfully.";
        } else {
            $err = "Error updating settings: " . mysqli_stmt_error($stmt);
        }
    }
}

if (isset($_POST['upload-logo'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["site-logo"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $err = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    } else {
        if (move_uploaded_file($_FILES["site-logo"]["tmp_name"], '../' . $target_file)) {
            $stmt = mysqli_prepare($con, "UPDATE setting SET site_logo = ?");
            mysqli_stmt_bind_param($stmt, "s", $target_file);
            if (mysqli_stmt_execute($stmt)) {
                $msg = "Logo uploaded successfully.";
            } else {
                $err = "Error uploading logo: " . mysqli_stmt_error($stmt);
            }
        } else {
            $err = "Sorry, there was an error uploading your file.";
        }
    }
}

if (isset($_POST['upload-favicon'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["site-favicon"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && $imageFileType != "ico" ) {
        $err = "Sorry, only JPG, JPEG, PNG, GIF & ICO files are allowed.";
    } else {
        if (move_uploaded_file($_FILES["site-favicon"]["tmp_name"], '../' . $target_file)) {
            $stmt = mysqli_prepare($con, "UPDATE setting SET site_favicon = ?");
            mysqli_stmt_bind_param($stmt, "s", $target_file);
            if (mysqli_stmt_execute($stmt)) {
                $msg = "Favicon uploaded successfully.";
            } else {
                $err = "Error uploading favicon: " . mysqli_stmt_error($stmt);
            }
        } else {
            $err = "Sorry, there was an error uploading your file.";
        }
    }
}

if(isset($_POST['save-email-settings'])){
    $smtp_host = $_POST['smtp-host'];
    $smtp_username = $_POST['smtp-username'];
    $smtp_password = $_POST['smtp-password'];
    $smtp_port = $_POST['smtp-port'];
    $smtp_secure = $_POST['smtp-secure'];
    $email_on_creation = isset($_POST['email-on-creation']) ? 1 : 0;
    $email_on_update = isset($_POST['email-on-update']) ? 1 : 0;

    $stmt = mysqli_prepare($con, "UPDATE setting SET smtp_host = ?, smtp_username = ?, smtp_password = ?, smtp_port = ?, smtp_secure = ?, email_on_creation = ?, email_on_update = ?");
    mysqli_stmt_bind_param($stmt, "sssssii", $smtp_host, $smtp_username, $smtp_password, $smtp_port, $smtp_secure, $email_on_creation, $email_on_update);
    if (mysqli_stmt_execute($stmt)) {
        $msg = "Email settings updated successfully.";
    } else {
        $err = "Error updating email settings: " . mysqli_stmt_error($stmt);
    }
}
?>

<div class="page-wrapper">
    <div class="page-content">
        <h1>Settings</h1>
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

                                <?php if (!empty($msg)) : ?>
                                    <div class="alert alert-success"><?php echo $msg; ?></div>
                                <?php endif; ?>
                                <?php if (!empty($err)) : ?>
                                    <div class="alert alert-danger"><?php echo $err; ?></div>
                                <?php endif; ?>

                                <form method="POST" action="settings.php">
                                    <label>Site name</label>
                                    <input class="form-control" type="text" name="site-name"
                                        value="<?php echo htmlspecialchars($sitename ?? ''); ?>">
                                    <br>

                                    <label>Site title</label>
                                    <input class="form-control" type="text" name="site-title"
                                        value="<?php echo htmlspecialchars($site_title ?? ''); ?>">
                                    <br>

                                    <label>site Url</label>
                                    <input class="form-control" type="text" name="site-url"
                                        value="<?php echo htmlspecialchars($site_url ?? ''); ?>">
                                    <br>


                                    <label>Email Name</label>
                                    <input class="form-control" type="text" name="email-name"
                                        value="<?php echo htmlspecialchars($email_name ?? ''); ?>">
                                    <br>

                                    <label> Email Address</label>
                                    <input class="form-control" type="email" name="email"
                                        value="<?php echo htmlspecialchars($email_address ?? ''); ?>">
                                    <br>

                                    <button name="save" type="submit" class="btn btn-primary">save</button>
                                </form>

                                <hr>

                                <form method="POST" action="settings.php" enctype="multipart/form-data">
                                    <label>Site Logo</label>
                                    <input class="form-control" type="file" name="site-logo">
                                    <br>
                                    <button name="upload-logo" type="submit" class="btn btn-primary">Upload Logo</button>
                                </form>

                                <hr>

                                <form method="POST" action="settings.php" enctype="multipart/form-data">
                                    <label>Site Favicon</label>
                                    <input class="form-control" type="file" name="site-favicon">
                                    <br>
                                    <button name="upload-favicon" type="submit" class="btn btn-primary">Upload Favicon</button>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="email-settings">
                                <h5 class="card-title"></h5>

                                <form method="POST" action="settings.php">
                                    <label>SMTP Host</label>
                                    <input class="form-control" type="text" name="smtp-host"
                                        value="<?php echo htmlspecialchars($smtp_host ?? ''); ?>">
                                    <br>

                                    <label>SMTP Username</label>
                                    <input class="form-control" type="text" name="smtp-username"
                                        value="<?php echo htmlspecialchars($smtp_username ?? ''); ?>">
                                    <br>

                                    <label>SMTP Password</label>
                                    <input class="form-control" type="password" name="smtp-password"
                                        value="<?php echo htmlspecialchars($smtp_password ?? ''); ?>">
                                    <br>

                                    <label>SMTP Port</label>
                                    <input class="form-control" type="text" name="smtp-port"
                                        value="<?php echo htmlspecialchars($smtp_port ?? ''); ?>">
                                    <br>

                                    <label>SMTP Secure</label>
                                    <input class="form-control" type="text" name="smtp-secure"
                                        value="<?php echo htmlspecialchars($smtp_secure ?? ''); ?>">
                                    <br>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="email-on-creation" value="1" <?php echo $email_on_creation == 1 ? 'checked' : '' ?>>
                                        <label class="form-check-label">
                                            Email on Shipment Creation
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="email-on-update" value="1" <?php echo $email_on_update == 1 ? 'checked' : '' ?>>
                                        <label class="form-check-label">
                                            Email on Package History Update
                                        </label>
                                    </div>
                                    <br>

                                    <button name="save-email-settings" type="submit" class="btn btn-primary">Save Settings</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>

<!--end page wrapper -->