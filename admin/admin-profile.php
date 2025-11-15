<?php
include 'header.php'; 
include '../db.php';

 ?>



  <div class="page-wrapper">
        <div class="page-content">               
            <h1 >Admin Profile</h1>
               <section class="section profile">
   
        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">
                  <li class="nav-item">
                      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="">Overview</button>
                  </li>


                   <li class="nav-item">
                     <a class="nav-link" href="edit-admin.php">Edit profile</a>
                  </li>

                  

                  
              </ul>

           <div class="tab-content pt-2">
              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">About</h5>
                  <p class="small fst-italic">The admin have the right to change any thing he or she like to change in the site</p>

                  <h5 class="card-title">Profile Details</h5>


                   <?php
                       $select = mysqli_query($con, "SELECT * FROM admin");
                         if (mysqli_num_rows($select) > 0) {
                            while ($row = mysqli_fetch_assoc($select)) {
                              $email = $row['email'];
                                $password = $row['password'];                                             
                    ?>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Email </div>
                    <div class="col-lg-9 col-md-8"><?php echo $email ?></div>
                  </div>


            
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">password</div>
                    <div class="col-lg-9 col-md-8"><?php echo $password ?></div>
                  </div>
                  <br>



                     <a href="logout.php" class="btn btn-primary ">logout</a>
                </div>

                <?php 
                  }
                  } 
                 ?>

               

               
                    
        </div>
      </div>
    </section>
         </div>
  </div>

    <!--end page wrapper -->

  