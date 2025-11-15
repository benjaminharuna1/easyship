<?php
include 'header.php'; 
include '../db.php';
	
<?php
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
                                <a class="nav-link active " href="dashboard.php">Home</a>
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

                                <form method="POST" action="mail.php">
                                    <label>Site name</label>
                                    <input class="form-control" type="text" name="site-name"
                                        value="<?php echo $sitename  ?>">
                                    <br>

                                    <label>Site title</label>
                                    <input class="form-control" type="text" name="site-title"
                                        value="<?php echo $site_title  ?>">
                                    <br>

                                    <label>site Url</label>
                                    <input class="form-control" type="text" name="site-url"
                                        value="<?php echo $site_url  ?>">
                                    <br>


                                    <label>Email Name</label>
                                    <input class="form-control" type="text" name="email-name"
                                        value="<?php echo $email_name  ?>">
                                    <br>

                                    <label> Email Address</label>
                                    <input class="form-control" type="email" name="email"
                                        value="<?php echo $email_address  ?>">
                                    <br>

                                    <button name="save" type="submit" class="btn btn-primary">save</button>
                                </form>





                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>

<!--end page wrapper -->