<?php 
		include 'header.php';


 if (isset($_GET['post'])) {
 	$post_id = $_GET['post'];




 	//fetch this particular student details

 	$sql = mysqli_query($con, "SELECT * FROM addtracking WHERE tracking_id = '$post_id' ");
 	if (mysqli_num_rows($sql) > 0 ) {
 		$row = mysqli_fetch_assoc($sql);
 		   $tracking_id = $row['tracking_id'];
            $sender_name = $row['sender_name'];
            $sender_contact = $row ['sender_contact'];
            $sender_email = $row['sender_email'];
            $sender_address = $row['sender_address'];  
            $status = $row['status'];
            $dispatch_location = $row['dispatch_location'];                     
            $carrier = $row['carrier'];
            $carrier_refrence_number = $row['carrier_refrence_number'];
            $weight = $row['weight'];
            $payment_mode = $row['payment_mode'];
            $total_cost = $row['total_cost'];
            $image = $row['image'];
            $receiver_name = $row['receiver_name'];
            $receiver_contact = $row['receiver_contact'];
            $receiver_email = $row['receiver_email'];
            $receiver_address = $row['receiver_address'];
            $package_discription = $row['package_discription'];
            $dispatch_date = $row['dispatch_date'];
            $destination = $row['destination'];
            $estimated_delivery_date = $row['estimated_delivery_date'];
            $shipment_mode = $row['shipment_mode'];
            $quantity = $row['quantity'];
 		
 	}
 }
 ?>



   
  <div class="page-wrapper">
    <div class="page-content"> 
       <div class="card">
            <div class="card-body">
              <h1>TRACKING NUMBER</h1>
              <h1 class="card-title" ><?php echo $tracking_id  ?></h1>         
	   </div>
    </div>
        <img src="../tracking_image/<?php echo $image ?>" alt="" width="200" >
<form action="add-tracking.php" method="POST" enctype="multipart/form-data">
  <div class="table-responsive">
    <table class="table align-middle mb-0">
     <thead class="table-light">
             <main id="main" class="main">
 
       <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Sender info</h5>

              <!-- Horizontal Form -->
              <form action="add-tracking.php" method="POST" enctype="multipart/form-data">
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Senders Name</label>
                  <input type="text" class="form-control" id="inputNanme4" name="sendername" value="<?php echo $sender_name ?>" readonly>
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Senders Contact</label>
                  <input type="text" class="form-control" id="inputNanme4" name="sendercontact" value="<?php echo $sender_contact?>" readonly>
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Senders Email</label>
                  <input type="text" class="form-control" id="inputNanme4" name="senderemail"value="<?php echo $sender_email ?>" readonly>
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Senders Address</label>
                  <input type="text" class="form-control" id="inputNanme4" name="senderaddress" value="<?php echo $sender_address ?>" readonly>
                </div>

                <h3>Other info</h3>

               <div class="col-12">
                 <label for="inputNanme4" class="form-label">Status</label>
                  <select class="form-control" id="inputName4" name="status" value="<?php echo $status ?>">
                    <option>Pending</option>
                    <option>Active</option>
                    <option>Inactive</option>
                    <option>Picked Up</option>
                    <option>Arrived</option>
                    <option>Delivered</option>
                    <option>On Hold</option>
                   </select>

                </div>



                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Dispatch Location</label>
                  <input type="text" class="form-control" id="inputNanme4" name="dispatchlocation" value="<?php echo $dispatch_location ?>" readonly>
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Carrier</label>
                  <input type="text" class="form-control" id="inputNanme4" name="carrier" value="<?php echo $carrier ?>" readonly>
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Carrier reference number </label>
                  <input type="text" class="form-control" id="inputNanme4" name="carrierreferencenumber" value="<?php echo $carrier_refrence_number ?>" readonly>
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Weight</label>
                  <input type="text" class="form-control" id="inputNanme4" name="weight" value="<?php echo $weight ?>" readonly>
                </div>

                 <div class="col-12">
                  <label for="inputNanme4" class="form-label">Payment Mode </label>
                  <input type="text" class="form-control" id="inputNanme4" name="paymentmode" value="<?php echo $payment_mode ?>" readonly>
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Total Cost</label>
                  <input type="text" class="form-control" id="inputNanme4" name="totalcost" value="<?php echo $total_cost ?>" readonly>
                </div>

              <!--   <div class="col-12">
                  <label for="inputNanme4" class="form-label">Package image </label>
                   <input type="file" class="form-control" id="inputNanme4" name="image" value="<?php echo $payment_image ?>">
                </div> -->

            </div>
          </div>

          <div class="card">
            <div class="card-body">
                    <!-- <button type="submit" name="add" class="btn btn-primary" style="width: 800px;"> add</button> -->
            </div>
          </div>

        </div>

        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Reciver info</h5>

              <!-- Vertical Form -->
             
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Receiver Name</label>
                  <input type="text" class="form-control" id="inputNanme4" name="receviername"  value="<?php echo $receiver_name ?>" readonly>
                </div>
                <div class="col-12">
                  <label for="inputEmail4" class="form-label">Receiver Email</label>
                  <input type="email" class="form-control"  name="recevieremail" value="<?php echo $receiver_email ?>" readonly>
                </div>
                <div class="col-12">
                  <label for="inputEmail4" class="form-label">Recevier contact </label>
                  <input type="text" class="form-control" id="" name="receviercontact" value="<?php echo $receiver_contact ?>" readonly>
                </div>
               
                <div class="col-12">
                  <label for="inputAddress" class="form-label">Recevier Address</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="recevieraddress" value="<?php echo $receiver_address?>" readonly>
                </div>
                
                <h3>Other info</h3>

                 <div class="col-12">
                  <label for="inputAddress" class="form-label">Destination</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="destination" value="<?php echo $destination ?>" readonly>
                </div>


                 <div class="col-12">
                  <label for="inputAddress" class="form-label">Package description</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St"name="packagedescription"  value="<?php echo $package_discription ?>" readonly>
                </div>

                <div class="col-12">
                  <label for="inputAddress" class="form-label">Dispatch Date</label>
                  <input type="date" class="form-control" id="inputAddress" placeholder="1234 Main St" name="dispatchdate" value="<?php echo $dispatch_date?>" readonly>
                </div>

                 <div class="col-12">
                  <label for="inputAddress" class="form-label">Estimated Delivery Date</label>
                  <input type="date" class="form-control" id="inputAddress" placeholder="1234 Main St" name="estimateddeliverydate" value="<?php echo $estimated_delivery_date ?>" readonly>
                </div>

                <div class="col-12">
                  <label for="inputAddress" class="form-label">Shipment method</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="shipmentmethod" value="<?php echo $shipment_mode ?>" readonly>
                </div>

                 <div class="col-12">
                  <label for="inputAddress" class="form-label">quantity</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="quantity" value="<?php echo $quantity ?>" readonly>
                </div>



                  </form><!-- Vertical Form -->

                  


            </div>
          </div>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
    </div>
    <!--end page wrapper -->
