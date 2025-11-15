<?php
include 'header.php';

$msg = ""; 
$err = "";

if (isset($_GET['edit'])) {
  $edit_id = $_GET['edit'];

  $sql = mysqli_query($con, "SELECT * FROM addtracking WHERE tracking_id = '$edit_id' ");
  if (mysqli_num_rows($sql) > 0 ) {
    $row = mysqli_fetch_assoc($sql);
    $tracking = $row['tracking_id'];
    $status = $row['status'];
    $destination = $row['destination'];
    $message = $row['message'];
    $current_location = $row['current_location'];
    $delivery_message = $row['delivery_message'];
    $receiver_name = $row['receiver_name'];
    $receiver_email = $row['receiver_email'];

  }
}

if (isset($_POST['update'])) {
  $current_location = ($_POST['current_location']);
  $date = ($_POST['date']);
  $time = ($_POST['time']);
  $status = ($_POST['status']);
  $invoice_sub_total = ($_POST['invoice_sub_total']);
  $discount = ($_POST['discount']);
  $tax = ($_POST['tax']);
  $invoice_total = $invoice_sub_total + $discount + $tax;
  $note = ($_POST['message']);

  if (empty($current_location) && empty($date) && empty($time) && empty($status) && empty($note) && empty($invoice_sub_total) && empty($discount) && empty($tax) && empty($invoice_total) ) {
    $err = "fill all filed";
  } else {
    $update = mysqli_query($con, "INSERT INTO track_update (track_num, status, date, time, note, current_location, invoice_sub_total, discount,tax,invoice_total ) VALUES ('$edit_id', '$status', '$date', '$time', '$note', '$current_location', '$invoice_sub_total', '$discount' ,'$tax', '$invoice_total' ) ");
    
    if ($update) {
      mysqli_query($con, "UPDATE addtracking SET current_location = '$current_location', status = '$status' WHERE tracking_id = '$edit_id' ");
    }
    if ($update) {
      $subject = "Shipment Update";
      $body = "<p>Dear $receiver_name</p> <p>We are pleased to inform you that your shipment has been updated successfully to $status </p>  <center>Tracking Information</center> <p> <strong>Tracking Number - $tracking </strong> </p> <p> <strong>Status - $status </strong> </p>  <p> <strong>Current Location - $current_location </strong> </p> <p> <strong>Note - $note </strong> </p> <p> Please know that you can get in touch with us if you have a question.</p> <p>For more information visit the <a href='$site_url/tracking.php'>Tracking Page</a> </p> ";
      sendMail($receiver_email, $subject, $body);
    }
    if ($update) {
      $msg = "Updated successfully";
    }
  }
}
?>
       

  <div class="page-wrapper">
    <div class="page-content">
                    
        
               
      <div class="card">
                    <div class="card-body">
                      <h1>TRACKING NUMBER</h1>
                      <h1> <?php echo $tracking  ?> </h1>       
                  </div>
                 </div>
                  <?php  
                  if ($msg != "") {
             ?>
                 <div class="alert alert success"><?php echo $msg ?></div>
             <?php } ?> 

                  
           
    <section class="section">
    
      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">

            <div class="card-body">
              <h5 class="card-title">update package</h5>

             <form method="POST" action="edit.php?edit=<?php echo $edit_id  ?>">
               <div class="col-12">
                 <label for="inputNanme4" class="form-label">product Status</label >
                  <select class="form-control" id="inputName4" name="status" value="<?php echo $row['status'] ?>">
                    <option>Pending</option>
                    <option>Active</option>
                    <option>In Transit</option>
                    <option>On Hold</option>
                    <option>Awaiting Delivery</option>
                    <option>Delivered</option>
                    
                   </select>
                </div>

                 <div class="col-12">
                  <label for="inputNanme4" class="form-label">current location</label>
                  <input type="text" class="form-control" id="inputNanme4" name="current_location"  required>
                </div>


                 <div class="col-12">
                  <label for="inputNanme4" class="form-label">date</label>
                  <input type="date" class="form-control" id="inputNanme4" name="date" required>
                </div>

                 <div class="col-12">
                  <label for="inputNanme4" class="form-label">Time</label>
                  <input type="time" class="form-control" id="inputNanme4" name="time" required>
                </div>

                
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Invoice sub total</label>
                  <input type="text" class="form-control" id="inputNanme4" name="invoice_sub_total"  required>
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Discount</label>
                  <input type="text" class="form-control" id="inputNanme4" name="discount" required>
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Tax</label>
                  <input type="text" class="form-control" id="inputNanme4" name="tax" required>
                </div>

                <div class="col-12">
                  <!-- <label for="inputNanme4" class="form-label">Invoice total</label> -->
                  <input type="text" class="form-control" id="inputNanme4" name="invoice_total" hidden  >
                </div>

                   
                  <div class="col-12">
                  <label for="inputNanme4" class="form-label">note</label>
                  <textarea class="form-control" id="inputNanme4" name="message"> </textarea> 
                </div>

                    <button type="submit" name="update" class="btn btn-primary" style="width: 50%;"> update</button>
           </form><!-- Vertical Form -->  

                  
                                          


            </div>
          </div>

          
     
    <!--end page wrapper -->

  