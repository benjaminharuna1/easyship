<?php 
include 'header.php';
 


$error = "";
$msg = "";

$tnumbs = "12345678900987654321";
$tnumbs = str_shuffle($tnumbs);
$track_prefix = "CL";
$tnumbs = substr($tnumbs, 0,7);
$tnumbs = $track_prefix.date('m').$tnumbs;

$tracking = $sender_name = $sender_contact = $sender_email = $sender_address = $status =
$dispatch_location = $carrier  = $carrier_refrence_number = $weight = $payment_mode = $package_image =
$receiver_name  = $receiver_contact = $receiver_email = $receiver_address = $destination =
$package_discription = $dispach_date = $estimated_delivery_date = $shipment_mode = $quantity = 
$delivery_time  =  "";
$tracking_err = ""; 
$date_added = date('d-m-y h:i:sa');
  

if (isset($_POST['add'])) {

  if (empty($_POST['sendername'])) {
    $error = "Fill in Sender's name";
  }else{
    $sender_name = text_input($_POST['sendername']);
  }

  if (empty($_POST['sendercontact'])) {
    $error = "Fill in Sender's contact";
  }else{
    $sender_contact = text_input($_POST['sendercontact']);
  }
           
  if (empty($_POST['senderemail'])) {
    $error = "Fill in Sender's mail";
  }else{
    $sender_email = text_input($_POST['senderemail']);
  }
           

  if (empty($_POST['senderaddress'])) {
    $error = "Fill in Sender's address";
  }else{
    $sender_address = text_input($_POST['senderaddress']);
  }
           
  if (empty($_POST['status'])) {
    $error = "Pick a status";
  }else{
    $status = text_input($_POST['status']);
  }
           
  if (empty($_POST['dispatchlocation'])) {
    $error = "Fill in Dispatch Location";
  }else{
    $dispatch_location = text_input($_POST['dispatchlocation']);
  }
           
  if (empty($_POST['carrier'])) {
      $error = "Fill in carrier";
  }else{
      $carrier = text_input($_POST['carrier']);
  }
           
  if (empty($_POST['carrierreferencenumber'])) {
    $error = "Fill in carrier reference number";
  }else{
    $carrier_refrence_number = text_input($_POST['carrierreferencenumber']);
  }
           
  if (empty($_POST['weight'])) {
    $error = "Fill in weight";
  }else{
    $weight = text_input($_POST['weight']);
  }
           

            if (empty($_POST['paymentmode'])) {
                $error = "Fill in payment mode";
            }else{
                $payment_mode = text_input($_POST['paymentmode']);
           }
           

            if (empty($_POST['receivername'])) {
                $error = "Fill in receiver name";
            }else{
                $receiver_name = text_input($_POST['receivername']);
           }
           

            if (empty($_POST['recevieremail'])) {
                $error = "Fill in receiver mail";
            }else{
                $receiver_email = text_input($_POST['recevieremail']);
           }
           

            if (empty($_POST['receviercontact'])) {
                $error = "Fill in receiver contact";
            }else{
                $receiver_contact = text_input($_POST['receviercontact']);
           }
           

            if (empty($_POST['recevieraddress'])) {
                $error = "Fill in receiver address";
            }else{
                $receiver_address = text_input($_POST['recevieraddress']);
           }
           

            if (empty($_POST['destination'])) {
                $error = "Fill in destination";
            }else{
                $destination= text_input($_POST['destination']);
           }
           

            if (empty($_POST['packagedescription'])) {
                $error = "Fill in package description";
            }else{
                $package_discription = text_input($_POST['packagedescription']);
           }

            if (empty($_POST['dipatchdate'])) {
                $error = "Fill in dispatch date";
            }else{
                $dispach_date = text_input($_POST['dipatchdate']);
           }

             if (empty($_POST['estimateddeliverydate'])) {
                $error = "Fill in estimated delivery date";
            }else{
                $estimated_delivery_date = text_input($_POST['estimateddeliverydate']);
           }
           

             if (empty($_POST['shipmentmethod'])) {
                $error = "Fill in Shipment method";
            }else{
                $shipment_mode = text_input($_POST['shipmentmethod']);
           }


            if (empty($_POST['quantity'])) {
              $error = "Fill in quantity";
            }else{
              $quantity = text_input($_POST['quantity']);
            }
           


             if (empty($_POST['deliverytime'])) {
                $error = "Fill in delivery time";
                }else{
                    $delivery_time = text_input($_POST['deliverytime']);
              }

            $extensions = array("jpeg", "jpg", "png");
            $location = "../uploads/";
           //package image
           if(isset($_FILES["image"])){
              $filename1 = $_FILES["image"]["name"];
              $tempname1 = $_FILES["image"]["tmp_name"];
              $file_ext1 = @strtolower(end(explode('.',$filename1)));
              if (in_array($file_ext1, $extensions) === false) {
                  $error = "Extension not allowed, please choose a JPEG or PNG file.";
              }

           }else{
            $error = "Pick a package image";
           }

         if (empty($error)) {
              $packageImage = time().date('d').".png";
              //insert tracking details
              $insert = mysqli_query($con, "INSERT INTO addtracking ( tracking_id, sender_name, sender_contact, sender_email, sender_address, status, dispatch_location, carrier, carrier_refrence_number, weight, payment_mode, image,  receiver_name, receiver_contact, receiver_email, receiver_address, destination, package_discription, dispach_date ,estimated_delivery_date ,shipment_mode,  quantity , delivery_time, date_added ) VALUES ('$tnumbs', '$sender_name','$sender_contact', '$sender_email' ,'$sender_address','$status', '$dispatch_location', '$carrier', '$carrier_refrence_number', '$weight', '$payment_mode', '$packageImage', '$receiver_name', '$receiver_contact' ,'$receiver_email', '$receiver_address' ,'$destination' ,'$package_discription' ,'$dispach_date', '$estimated_delivery_date', '$shipment_mode', '$quantity', '$delivery_time', '$date_added' ) ");
              if ($insert) {
                // move inserted images inside the folder
                  move_uploaded_file($tempname1, $location.$packageImage);


                    //send mail
                    if ($insert ) {
                      $subject = "Registered Shipment";
                      $body = "<p>Dear $receiver_name</p> <p>We are pleased to inform you that your shipment has been registered with us at <strong>$sitename</strong>.</p>  <center>Tracking Information</center> <p> <strong>Tracking Number - $tnumbs </strong> </p> <p> <strong>Status - $status </strong> </p> <p> <strong>Package - $package_discription </strong> </p> <p> <strong>Dispatch Location - $dispatch_location </strong> </p> <p> <strong>Estimated Delivery Date - $destination </strong> </p> <p>For more information visit the <a href='$site_url/tracking.php'>Tracking Page</a> </p> ";
                      sendMail($receiver_email,$subject,$body);
                    }
                $msg = "Created successfully";
              }
            
          }

}    
 ?>

<span></span>

  <div class="page-wrapper">
    <div class="page-content">               
        <h1>Add Tracking</h1>
             <?php  
                  if ($msg != "") {
             ?>
                 <div class="alert alert success"><?php echo $msg ?></div>

             <?php } ?>

               <?php  
                  if ($error != "") {
             ?>
                 <div class="alert alert danger"><?php echo $error ?></div>
             <?php } ?>
               
                <br>
                <br>

         <form action="add-tracking.php" method="POST" enctype="multipart/form-data">

                <div class="col-12">
                       <input type="text" readonly="" value="<?php echo $tnumbs ?>" name="tracking_number" class="form-control" id="exampleInputUsername1" >
                </div>


                <br>
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead class="table-light">
            <main id="main" class="main">
    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Sender info</h5>

              <!-- Horizontal Form -->
              <form action="add-tracking.php" method="POST" enctype="multipart/form-data">
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Senders Name</label>
                  <input type="text" class="form-control" id="inputNanme4" name="sendername">
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Senders Contact</label>
                  <input type="text" class="form-control" id="inputNanme4" name="sendercontact">
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Senders Email</label>
                  <input type="text" class="form-control" id="inputNanme4" name="senderemail">
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Senders Address</label>
                  <input type="text" class="form-control" id="inputNanme4" name="senderaddress">
                </div>

                <h3>Other info</h3>

               <div class="col-12">
                 <label for="inputNanme4" class="form-label">Status</label>
                  <select class="form-control" id="inputName4" name="status">
                    <option>Pending</option>
                    <option>Active</option>
                    <option>In Transit</option>
                    <option>On Hold</option>
                    <option>Awaiting Delivery</option>
                    <option>Delivered</option>
                   </select>

                </div>



                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Dispatch Location</label>
                  <input type="text" class="form-control" id="inputNanme4" name="dispatchlocation" >
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Type</label>
                  <input type="text" class="form-control" id="inputNanme4" name="carrier">
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Carrier reference number </label>
                  <input type="text" class="form-control" id="inputNanme4" name="carrierreferencenumber" >
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Weight</label>
                  <input type="text" class="form-control" id="inputNanme4" name="weight" >
                </div>

                 <div class="col-12">
                  <label for="inputNanme4" class="form-label">Payment Mode </label>
                  <input type="text" class="form-control" id="inputNanme4" name="paymentmode" >
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Package image </label>
                   <input type="file" class="form-control" id="inputNanme4" name="image" >
                </div>

            </div>
          </div>

          <div class="card">
            <div class="card-body">
                    <button type="submit" name="add" class="btn btn-primary" style="width: 800px;"> add</button>
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
                  <input type="text" class="form-control" id="inputNanme4" name="receivername" >
                </div>
                <div class="col-12">
                  <label for="inputEmail4" class="form-label">Receiver Email</label>
                  <input type="email" class="form-control"  name="recevieremail"  >
                </div>
                <div class="col-12">
                  <label for="inputEmail4" class="form-label">Recevier contact </label>
                  <input type="text" class="form-control" id="" name="receviercontact" >
                </div>
               
                <div class="col-12">
                  <label for="inputAddress" class="form-label">Recevier Address</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="recevieraddress" >
                </div>
                
                <h3>Other info</h3>

                 <div class="col-12">
                  <label for="inputAddress" class="form-label">Destination</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="destination" >
                </div>


                 <div class="col-12">
                  <label for="inputAddress" class="form-label">Package description</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St"name="packagedescription"  >
                </div>

                <div class="col-12">
                  <label for="inputAddress" class="form-label">Dipatch Date</label>
                  <input type="date" class="form-control" id="inputAddress" placeholder="1234 Main St" name="dipatchdate" >
                </div>

                 <div class="col-12">
                  <label for="inputAddress" class="form-label">Estimated Deliverly Date</label>
                  <input type="date" class="form-control" id="inputAddress" placeholder="1234 Main St" name="estimateddeliverydate" >
                </div>

                <div class="col-12">
                  <label for="inputAddress" class="form-label">Shipment method</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="shipmentmethod" >
                </div>

                 <div class="col-12">
                  <label for="inputAddress" class="form-label">quantity</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="quantity" >
                </div>


                 <div class="col-12">
                  <label for="inputAddress" class="form-label">Devlivery time</label>
                  <input type="time" class="form-control" id="inputAddress" placeholder="1234 Main St" name="deliverytime" >
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

    