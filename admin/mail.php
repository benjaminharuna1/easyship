<?php
include 'header.php'; 
include '../db.php';
	
	$msg = "";
	if (isset($_POST['save'])) {
		$site_name =trim($_POST['site-name']);
		$site_title = trim($_POST['site-title']);
		$site_url = trim($_POST['site-url']);
		$email_name = trim($_POST['email-name']);
		$email_address = trim($_POST['email']);

		if (!empty($site_name) && !empty($site_title) &&  !empty($site_url) && !empty($email_name) && !empty($email_address) ) {
			$Sql = mysqli_query($con, "UPDATE setting SET Sitename = '$site_name', site_title = '$site_title', site_url ='$site_url', email_name = '$email_name', email_address = '$email_address' ");
			if ($Sql) {
				$msg = "saved";
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

                                <?php  
                                    if ($msg != "") {
                                ?>
                                <div class="alert alert success">
                                    <?php echo $msg ?>
                                </div>
                                <?php } ?>
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