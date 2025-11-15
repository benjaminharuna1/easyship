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
  

if (isset($_POST['add']) || isset($_POST['publish'])) {

    $published = isset($_POST['publish']) ? 1 : 0;

    // Validation
    $required_fields = ['sendername', 'sendercontact', 'senderemail', 'senderaddress', 'status', 'dispatchlocation', 'carrier', 'carrierreferencenumber', 'weight', 'paymentmode', 'receivername', 'recevieremail', 'receviercontact', 'recevieraddress', 'destination', 'packagedescription', 'dipatchdate', 'estimateddeliverydate', 'shipmentmethod', 'quantity', 'deliverytime'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $error = "Please fill in all required fields.";
            break;
        }
    }

    if (empty($error)) {
        $sender_name = text_input($_POST['sendername']);
        $sender_contact = text_input($_POST['sendercontact']);
        $sender_email = text_input($_POST['senderemail']);
        $sender_address = text_input($_POST['senderaddress']);
        $status = text_input($_POST['status']);
        $dispatch_location = text_input($_POST['dispatchlocation']);
        $carrier = text_input($_POST['carrier']);
        $carrier_refrence_number = text_input($_POST['carrierreferencenumber']);
        $weight = text_input($_POST['weight']);
        $payment_mode = text_input($_POST['paymentmode']);
        $receiver_name = text_input($_POST['receivername']);
        $receiver_email = text_input($_POST['recevieremail']);
        $receiver_contact = text_input($_POST['receviercontact']);
        $receiver_address = text_input($_POST['recevieraddress']);
        $destination = text_input($_POST['destination']);
        $package_discription = text_input($_POST['packagedescription']);
        $dispach_date = text_input($_POST['dipatchdate']);
        $estimated_delivery_date = text_input($_POST['estimateddeliverydate']);
        $shipment_mode = text_input($_POST['shipmentmethod']);
        $quantity = text_input($_POST['quantity']);
        $delivery_time = text_input($_POST['deliverytime']);
        $remarks = text_input($_POST['remarks']);
        $total_freight = text_input($_POST['total_freight']);
        $courier = text_input($_POST['courier']);
        $departure_time = text_input($_POST['departure_time']);
        $pickup_time = text_input($_POST['pickup_time']);
        $comments = text_input($_POST['comments']);
        $datetimepicker = text_input($_POST['datetimepicker']);
        $type_of_shipment = text_input($_POST['type_of_shipment']);
        $total_volumetric_weight = text_input($_POST['total_volumetric_weight']);
        $total_actual_weight = text_input($_POST['total_actual_weight']);

        // Tracking number generation
        $get_prefix = mysqli_prepare($con, "SELECT tracking_num FROM setting");
        mysqli_stmt_execute($get_prefix);
        $result = mysqli_stmt_get_result($get_prefix);
        $track_prefix = mysqli_fetch_assoc($result)['tracking_num'];
        $tnumbs = "12345678900987654321";
        $tnumbs = str_shuffle($tnumbs);
        $tnumbs = substr($tnumbs, 0, 7);
        $tnumbs = $track_prefix . date('m') . $tnumbs;

        // Image upload
        $packageImage = "";
        if (isset($_FILES["image"])) {
            $extensions = array("jpeg", "jpg", "png");
            $location = "../uploads/";
            $filename1 = $_FILES["image"]["name"];
            $tempname1 = $_FILES["image"]["tmp_name"];
            $file_ext1 = @strtolower(end(explode('.', $filename1)));
            if (in_array($file_ext1, $extensions) === false) {
                $error = "Extension not allowed, please choose a JPEG or PNG file.";
            } else {
                $packageImage = time() . date('d') . ".png";
                move_uploaded_file($tempname1, $location . $packageImage);
            }
        } else {
            $error = "Pick a package image";
        }

        if (empty($error)) {
            $stmt = mysqli_prepare($con, "INSERT INTO addtracking ( tracking_id, sender_name, sender_contact, sender_email, sender_address, status, dispatch_location, carrier, carrier_refrence_number, weight, payment_mode, image,  receiver_name, receiver_contact, receiver_email, receiver_address, destination, package_discription, dispach_date ,estimated_delivery_date ,shipment_mode,  quantity , delivery_time, date_added, remarks, total_freight, courier, departure_time, pickup_time, comments, datetimepicker, type_of_shipment, total_volumetric_weight, total_actual_weight, published ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssssssssssssssssi", $tnumbs, $sender_name, $sender_contact, $sender_email, $sender_address, $status, $dispatch_location, $carrier, $carrier_refrence_number, $weight, $payment_mode, $packageImage, $receiver_name, $receiver_contact, $receiver_email, $receiver_address, $destination, $package_discription, $dispach_date, $estimated_delivery_date, $shipment_mode, $quantity, $delivery_time, $date_added, $remarks, $total_freight, $courier, $departure_time, $pickup_time, $comments, $datetimepicker, $type_of_shipment, $total_volumetric_weight, $total_actual_weight, $published);
            $insert = mysqli_stmt_execute($stmt);

            if ($insert) {
                // Process package items
                if (isset($_POST['package_quantity'])) {
                    $stmt = mysqli_prepare($con, "INSERT INTO package_items (tracking_id, quantity, piece_type, description, length, width, height, weight) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    for ($i = 0; $i < count($_POST['package_quantity']); $i++) {
                        $package_quantity = text_input($_POST['package_quantity'][$i]);
                        $package_piece_type = text_input($_POST['package_piece_type'][$i]);
                        $package_description = text_input($_POST['package_description'][$i]);
                        $package_length = text_input($_POST['package_length'][$i]);
                        $package_width = text_input($_POST['package_width'][$i]);
                        $package_height = text_input($_POST['package_height'][$i]);
                        $package_weight = text_input($_POST['package_weight'][$i]);
                        mysqli_stmt_bind_param($stmt, "sissdddd", $tnumbs, $package_quantity, $package_piece_type, $package_description, $package_length, $package_width, $package_height, $package_weight);
                        mysqli_stmt_execute($stmt);
                    }
                }

                // Process shipment history
                if (isset($_POST['history_date'])) {
                    $stmt = mysqli_prepare($con, "INSERT INTO shipment_history (tracking_id, date, time, location, status, updated_by, remarks) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    for ($i = 0; $i < count($_POST['history_date']); $i++) {
                        $history_date = text_input($_POST['history_date'][$i]);
                        $history_time = text_input($_POST['history_time'][$i]);
                        $history_location = text_input($_POST['history_location'][$i]);
                        $history_status = text_input($_POST['history_status'][$i]);
                        $history_updated_by = text_input($_POST['history_updated_by'][$i]);
                        $history_remarks = text_input($_POST['history_remarks'][$i]);
                        mysqli_stmt_bind_param($stmt, "sssssss", $tnumbs, $history_date, $history_time, $history_location, $history_status, $history_updated_by, $history_remarks);
                        mysqli_stmt_execute($stmt);
                    }
                }

                // Auto-log status change
                $stmt = mysqli_prepare($con, "INSERT INTO shipment_history (tracking_id, date, time, location, status, updated_by, remarks) VALUES (?, NOW(), NOW(), ?, ?, 'System', 'Shipment Created')");
                mysqli_stmt_bind_param($stmt, "sss", $tnumbs, $dispatch_location, $status);
                mysqli_stmt_execute($stmt);

                // Send mail
                $subject = "Registered Shipment";
                $body = "<p>Dear $receiver_name</p> <p>We are pleased to inform you that your shipment has been registered with us at <strong>$sitename</strong>.</p>  <center>Tracking Information</center> <p> <strong>Tracking Number - $tnumbs </strong> </p> <p> <strong>Status - $status </strong> </p> <p> <strong>Package - $package_discription </strong> </p> <p> <strong>Dispatch Location - $dispatch_location </strong> </p> <p> <strong>Estimated Delivery Date - $destination </strong> </p> <p>For more information visit the <a href='$site_url/tracking.php'>Tracking Page</a> </p> ";
                sendMail($receiver_email, $subject, $body);

                $msg = "Created successfully";
            }
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
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Basic Info</h5>
              <div class="row">
                <div class="col-md-6">
                  <label for="tracking_number" class="form-label">Tracking Code</label>
                  <input type="text" readonly="" value="<?php echo $tnumbs ?>" name="tracking_number" class="form-control" id="tracking_number">
                </div>
                <div class="col-md-6">
                  <label for="shipment_status" class="form-label">Shipment Status</label>
                  <select class="form-control" id="shipment_status" name="status">
                    <option>Draft</option>
                    <option>Pending</option>
                    <option>In Transit</option>
                    <option>Delivered</option>
                    <option>Cancelled</option>
                  </select>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-12">
                  <label for="remarks" class="form-label">Remarks</label>
                  <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6">
                  <label for="datetimepicker" class="form-label">Date & Time</label>
                  <input type="datetime-local" class="form-control" id="datetimepicker" name="datetimepicker">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Shipper Details</h5>
              <div class="mb-3">
                <label for="shipper_name" class="form-label">Shipper Name</label>
                <input type="text" class="form-control" id="shipper_name" name="sendername">
              </div>
              <div class="mb-3">
                <label for="shipper_phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="shipper_phone" name="sendercontact">
              </div>
              <div class="mb-3">
                <label for="shipper_address" class="form-label">Address</label>
                <input type="text" class="form-control" id="shipper_address" name="senderaddress">
              </div>
              <div class="mb-3">
                <label for="shipper_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="shipper_email" name="senderemail">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Receiver Details</h5>
              <div class="mb-3">
                <label for="receiver_name" class="form-label">Receiver Name</label>
                <input type="text" class="form-control" id="receiver_name" name="receivername">
              </div>
              <div class="mb-3">
                <label for="receiver_phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="receiver_phone" name="receviercontact">
              </div>
              <div class="mb-3">
                <label for="receiver_address" class="form-label">Address</label>
                <input type="text" class="form-control" id="receiver_address" name="recevieraddress">
              </div>
              <div class="mb-3">
                <label for="receiver_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="receiver_email" name="recevieremail">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Shipment Details</h5>
              <div class="row">
                <div class="col-md-4">
                  <label for="type_of_shipment" class="form-label">Type of Shipment</label>
                  <select class="form-control" id="type_of_shipment" name="type_of_shipment">
                    <option>Select</option>
                    <option>Express</option>
                    <option>Standard</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="payment_mode" class="form-label">Payment Mode</label>
                  <select class="form-control" id="payment_mode" name="paymentmode">
                    <option>Select</option>
                    <option>Cash</option>
                    <option>Card</option>
                    <option>Transfer</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="carrier" class="form-label">Carrier</label>
                  <select class="form-control" id="carrier" name="carrier">
                    <option>Select</option>
                    <option>DHL</option>
                    <option>UPS</option>
                    <option>FedEx</option>
                  </select>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-4">
                  <label for="courier" class="form-label">Courier</label>
                  <input type="text" class="form-control" id="courier" name="courier">
                </div>
                <div class="col-md-4">
                  <label for="mode" class="form-label">Mode</label>
                  <select class="form-control" id="mode" name="shipmentmethod">
                    <option>Select</option>
                    <option>Land Shipping</option>
                    <option>Air Shipping</option>
                    <option>Sea Shipping</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="origin" class="form-label">Origin</label>
                  <input type="text" class="form-control" id="origin" name="dispatchlocation">
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-4">
                  <label for="destination" class="form-label">Destination</label>
                  <input type="text" class="form-control" id="destination" name="destination">
                </div>
                <div class="col-md-4">
                  <label for="weight" class="form-label">Weight</label>
                  <input type="text" class="form-control" id="weight" name="weight">
                </div>
                <div class="col-md-4">
                  <label for="packages_count" class="form-label">Packages count</label>
                  <input type="number" class="form-control" id="packages_count" name="quantity">
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-8">
                  <label for="product_description" class="form-label">Product description</label>
                  <input type="text" class="form-control" id="product_description" name="packagedescription">
                </div>
                <div class="col-md-4">
                  <label for="total_freight" class="form-label">Total Freight</label>
                  <input type="text" class="form-control" id="total_freight" name="total_freight">
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-4">
                  <label for="carrier_ref_no" class="form-label">Carrier Reference No.</label>
                  <input type="text" class="form-control" id="carrier_ref_no" name="carrierreferencenumber">
                </div>
                <div class="col-md-4">
                  <label for="departure_time" class="form-label">Departure Time</label>
                  <input type="time" class="form-control" id="departure_time" name="departure_time">
                </div>
                <div class="col-md-4">
                  <label for="pickup_date" class="form-label">Pickup Date</label>
                  <input type="date" class="form-control" id="pickup_date" name="dipatchdate">
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-4">
                  <label for="pickup_time" class="form-label">Pickup Time</label>
                  <input type="time" class="form-control" id="pickup_time" name="deliverytime">
                </div>
                <div class="col-md-4">
                  <label for="expected_delivery_date" class="form-label">Expected Delivery Date</label>
                  <input type="date" class="form-control" id="expected_delivery_date" name="estimateddeliverydate">
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-12">
                  <label for="comments" class="form-label">Comments</label>
                  <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-12">
                  <label for="image" class="form-label">Package Image</label>
                  <input type="file" class="form-control" id="image" name="image">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Package Items</h5>
              <table class="table" id="package_items_table">
                <thead>
                  <tr>
                    <th scope="col">Quantity</th>
                    <th scope="col">Piece Type</th>
                    <th scope="col">Description</th>
                    <th scope="col">Length (cm)</th>
                    <th scope="col">Width (cm)</th>
                    <th scope="col">Height (cm)</th>
                    <th scope="col">Weight (kg)</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              <button type="button" class="btn btn-primary" id="add_package_row">Add Row</button>
              <div class="row mt-3">
                <div class="col-md-4">
                  <label for="total_volumetric_weight" class="form-label">Total Volumetric Weight</label>
                  <input type="text" class="form-control" id="total_volumetric_weight" name="total_volumetric_weight" readonly>
                </div>
                <div class="col-md-4">
                  <label for="total_actual_weight" class="form-label">Total Actual Weight</label>
                  <input type="text" class="form-control" id="total_actual_weight" name="total_actual_weight" readonly>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Shipment History</h5>
              <table class="table" id="shipment_history_table">
                <thead>
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Location</th>
                    <th scope="col">Status</th>
                    <th scope="col">Updated By</th>
                    <th scope="col">Remarks</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              <button type="button" class="btn btn-primary" id="add_history_row">Add Row</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-end">
                <button type="submit" name="add" class="btn btn-primary">Save</button>
                <button type="submit" name="publish" class="btn btn-secondary ms-2">Publish</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
</form>
    <!--end page wrapper -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  let historyRow = `
    <tr>
      <td><input type="date" class="form-control" name="history_date[]"></td>
      <td><input type="time" class="form-control" name="history_time[]"></td>
      <td><input type="text" class="form-control" name="history_location[]"></td>
      <td><input type="text" class="form-control" name="history_status[]"></td>
      <td><input type="text" class="form-control" name="history_updated_by[]"></td>
      <td><input type="text" class="form-control" name="history_remarks[]"></td>
      <td><button type="button" class="btn btn-danger remove_row">Delete</button></td>
    </tr>
  `;
  document.getElementById('add_history_row').addEventListener('click', function() {
    document.querySelector('#shipment_history_table tbody').insertAdjacentHTML('beforeend', historyRow);
  });

  let packageRow = `
    <tr>
      <td><input type="number" class="form-control" name="package_quantity[]"></td>
      <td><input type="text" class="form-control" name="package_piece_type[]"></td>
      <td><input type="text" class="form-control" name="package_description[]"></td>
      <td><input type="number" class="form-control" name="package_length[]"></td>
      <td><input type="number" class="form-control" name="package_width[]"></td>
      <td><input type="number" class="form-control" name="package_height[]"></td>
      <td><input type="number" class="form-control" name="package_weight[]"></td>
      <td><button type="button" class="btn btn-danger remove_row">Delete</button></td>
    </tr>
  `;
  document.getElementById('add_package_row').addEventListener('click', function() {
    document.querySelector('#package_items_table tbody').insertAdjacentHTML('beforeend', packageRow);
  });

  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove_row')) {
      e.target.closest('tr').remove();
      calculateTotals();
    }
  });

  document.addEventListener('input', function(e) {
    if (e.target.name.startsWith('package_')) {
      calculateTotals();
    }
  });

  function calculateTotals() {
    let totalVolumetricWeight = 0;
    let totalActualWeight = 0;
    document.querySelectorAll('#package_items_table tbody tr').forEach(function(row) {
      let length = parseFloat(row.querySelector('[name="package_length[]"]').value) || 0;
      let width = parseFloat(row.querySelector('[name="package_width[]"]').value) || 0;
      let height = parseFloat(row.querySelector('[name="package_height[]"]').value) || 0;
      let weight = parseFloat(row.querySelector('[name="package_weight[]"]').value) || 0;
      let quantity = parseInt(row.querySelector('[name="package_quantity[]"]').value) || 0;

      let volumetricWeight = (length * width * height) / 5000;
      totalVolumetricWeight += volumetricWeight * quantity;
      totalActualWeight += weight * quantity;
    });

    document.getElementById('total_volumetric_weight').value = totalVolumetricWeight.toFixed(2);
    document.getElementById('total_actual_weight').value = totalActualWeight.toFixed(2);
  }
});
</script>