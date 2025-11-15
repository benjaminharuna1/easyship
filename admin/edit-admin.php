<?php
include 'header.php'; 
include '../db.php';
  


    $sql = mysqli_query($con, "SELECT * FROM admin  ");
      if (mysqli_num_rows($sql) > 0 ) {
        $data = mysqli_fetch_assoc($sql);
        $admin_email = $data['email'];
        $admin_password = $data['password'];

  }
 

  $msg = "";
      if (isset($_POST['save'])) {
        $adminEmail = trim($_POST['email']);
        $adminPassword = trim($_POST['password']);
      

        if (!empty($admin_email) && !empty($admin_password) ) {
          $Sql = mysqli_query($con, "UPDATE admin SET email = '$adminEmail', password = '$adminPassword' ");
          if ($Sql) {
            $msg = "saved";
            header ('location: admin-profile.php');
          }
        }     
    }
    
    


 

 ?>

  <div class="page-wrapper">
        <div class="page-content">               
            <h1 >Send mail</h1>
               <section class="section profile">
   
        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">
                 

                   <li class="nav-item">
                     <a class="nav-link " href="admin-profile.php">Overview</a>
                  </li>


                   <li class="nav-item">
                     <a class="nav-link active" href="edit-admin.php">Edit profile</a>
                  </li>

                

                  
              </ul>

           <div class="tab-content pt-2">
              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title"></h5>

              <?php  
                  if ($msg != "") {
             ?>
                 <div class="alert alert success"><?php echo $msg ?></div>
             <?php } ?>
                <form method="POST" action="edit-admin.php">
                  <label>Email</label>
                  <input class="form-control" type="text" name="email" value="<?php echo $admin_email  ?>">
                  <br>

                  <label>Password</label>
                  <input class="form-control" type="password" name="password" value="<?php echo $admin_password  ?>">
                  <br>

                 

                  <button name="save" type="submit" class="btn btn-primary">update</button>
                </form>
                 


               
                    
        </div>
      </div>
    </section>
         </div>
  </div>

    <!--end page wrapper -->