<?php 
include 'header.php';

// Enable mysqli exceptions
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$errors = [];
$msg = "";

// Generate a default tracking number for display
$tnumbs = "12345678900987654321";
$tnumbs = str_shuffle($tnumbs);
$track_prefix = "CL";
$tnumbs = substr($tnumbs, 0, 7);
$tnumbs = $track_prefix . date('m') . $tnumbs;

$date_added = date('d-m-y h:i:sa');

if (isset($_POST['add']) || isset($_POST['publish'])) {

    $published = isset($_POST['publish']) ? 1 : 0;

    // Validation
    $required_fields = [
        'sendername' => 'Sender name is required.',
        'sendercontact' => 'Sender contact is required.',
        'senderemail' => 'Sender email is required.',
        'senderaddress' => 'Sender address is required.',
        'dispatchlocation' => 'Dispatch location is required.',
        'carrier' => 'Carrier is required.',
        'carrierreferencenumber' => 'Carrier reference number is required.',
        'weight' => 'Weight is required.',
        'paymentmode' => 'Payment mode is required.',
        'total_cost' => 'Total cost is required.',
        'receivername' => 'Receiver name is required.',
        'receiver_email' => 'Receiver email is required.',
        'receivercontact' => 'Receiver contact is required.',
        'receiveraddress' => 'Receiver address is required.',
        'destination' => 'Destination is required.',
        'packagedescription' => 'Package description is required.',
        'dispatch_date' => 'Dispatch date is required.',
        'estimateddeliverydate' => 'Estimated delivery date is required.',
        'shipmentmethod' => 'Shipment method is required.',
        'quantity' => 'Quantity is required.'
    ];

    foreach ($required_fields as $field => $message) {
        if (empty($_POST[$field])) {
            $errors[$field] = $message;
        }
    }

    if (empty($errors)) {
        try {
            $sender_name = text_input($_POST['sendername']);
            $sender_contact = text_input($_POST['sendercontact']);
            $sender_email = text_input($_POST['senderemail']);
            $sender_address = text_input($_POST['senderaddress']);
            $dispatch_location = text_input($_POST['dispatchlocation']);
            $carrier = text_input($_POST['carrier']);
            $carrier_refrence_number = text_input($_POST['carrierreferencenumber']);
            $weight = text_input($_POST['weight']);
            $payment_mode = text_input($_POST['paymentmode']);
            $total_cost = text_input($_POST['total_cost']);
            $receiver_name = text_input($_POST['receivername']);
            $receiver_email = text_input($_POST['receiver_email']);
            $receiver_contact = text_input($_POST['receivercontact']);
            $receiver_address = text_input($_POST['receiveraddress']);
            $destination = text_input($_POST['destination']);
            $package_discription = text_input($_POST['packagedescription']);
            $dispatch_date = text_input($_POST['dispatch_date']);
            $estimated_delivery_date = text_input($_POST['estimateddeliverydate']);
            $shipment_mode = text_input($_POST['shipmentmethod']);
            $quantity = text_input($_POST['quantity']);
            $total_freight = text_input($_POST['total_freight'] ?? '');
            $courier = text_input($_POST['courier'] ?? '');
            $comments = text_input($_POST['comments'] ?? '');
            $type_of_shipment = text_input($_POST['type_of_shipment'] ?? '');
            $total_volumetric_weight = text_input($_POST['total_volumetric_weight'] ?? '');
            $total_actual_weight = text_input($_POST['total_actual_weight'] ?? '');

            // Image upload
            $packageImage = "";
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0 && !empty($_FILES["image"]["name"])) {
                $extensions = array("jpeg", "jpg", "png");
                $location = "../uploads/";
                $filename1 = $_FILES["image"]["name"];
                $tempname1 = $_FILES["image"]["tmp_name"];
                $file_ext1 = @strtolower(end(explode('.', $filename1)));
                if (!in_array($file_ext1, $extensions)) {
                    throw new Exception("Extension not allowed, please choose a JPEG or PNG file.");
                }
                $packageImage = time() . date('d') . ".png";
                if (!move_uploaded_file($tempname1, $location . $packageImage)) {
                    throw new Exception("Failed to upload image.");
                }
            }

            // Tracking number generation
            $get_prefix_stmt = mysqli_prepare($con, "SELECT tracking_num FROM setting");
            mysqli_stmt_execute($get_prefix_stmt);
            $result = mysqli_stmt_get_result($get_prefix_stmt);
            $track_prefix = mysqli_fetch_assoc($result)['tracking_num'];
            $tnumbs_rand = "12345678900987654321";
            $tnumbs_rand = str_shuffle($tnumbs_rand);
            $tnumbs_rand = substr($tnumbs_rand, 0, 7);
            $tnumbs_final = $track_prefix . date('m') . $tnumbs_rand;

            // Start Transaction
            mysqli_begin_transaction($con);

            $stmt = mysqli_prepare($con, "INSERT INTO addtracking ( tracking_id, sender_name, sender_contact, sender_email, sender_address, dispatch_location, carrier, carrier_refrence_number, weight, payment_mode, total_cost, image,  receiver_name, receiver_contact, receiver_email, receiver_address, destination, package_discription, dispatch_date ,estimated_delivery_date ,shipment_mode,  quantity, date_added, total_freight, courier, comments, type_of_shipment, total_volumetric_weight, total_actual_weight, published ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssssssssssdssssssssssssssssssi", $tnumbs_final, $sender_name, $sender_contact, $sender_email, $sender_address, $dispatch_location, $carrier, $carrier_refrence_number, $weight, $payment_mode, $total_cost, $packageImage, $receiver_name, $receiver_contact, $receiver_email, $receiver_address, $destination, $package_discription, $dispatch_date, $estimated_delivery_date, $shipment_mode, $quantity, $date_added, $total_freight, $courier, $comments, $type_of_shipment, $total_volumetric_weight, $total_actual_weight, $published);
            mysqli_stmt_execute($stmt);

            // Process package items
            if (!empty($_POST['package_quantity']) && is_array($_POST['package_quantity'])) {
                $stmt_items = mysqli_prepare($con, "INSERT INTO package_items (tracking_id, quantity, piece_type, description, length, width, height, weight) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                for ($i = 0; $i < count($_POST['package_quantity']); $i++) {
                    $package_quantity = text_input($_POST['package_quantity'][$i]);
                    $package_piece_type = text_input($_POST['package_piece_type'][$i]);
                    $package_description = text_input($_POST['package_description'][$i]);
                    $package_length = text_input($_POST['package_length'][$i]);
                    $package_width = text_input($_POST['package_width'][$i]);
                    $package_height = text_input($_POST['package_height'][$i]);
                    $package_weight = text_input($_POST['package_weight'][$i]);
                    mysqli_stmt_bind_param($stmt_items, "sissdddd", $tnumbs_final, $package_quantity, $package_piece_type, $package_description, $package_length, $package_width, $package_height, $package_weight);
                    mysqli_stmt_execute($stmt_items);
                }
            }

            // Process shipment history
            if (!empty($_POST['history_date']) && is_array($_POST['history_date'])) {
                $stmt_history = mysqli_prepare($con, "INSERT INTO shipment_history (tracking_id, date, time, location, status, updated_by, remarks) VALUES (?, ?, ?, ?, ?, ?, ?)");
                for ($i = 0; $i < count($_POST['history_date']); $i++) {
                    $history_date = text_input($_POST['history_date'][$i]);
                    $history_time = text_input($_POST['history_time'][$i]);
                    $history_location = text_input($_POST['history_location'][$i]);
                    $history_status = text_input($_POST['history_status'][$i]);
                    $history_updated_by = text_input($_POST['history_updated_by'][$i]);
                    $history_remarks = text_input($_POST['history_remarks'][$i]);
                    mysqli_stmt_bind_param($stmt_history, "sssssss", $tnumbs_final, $history_date, $history_time, $history_location, $history_status, $history_updated_by, $history_remarks);
                    mysqli_stmt_execute($stmt_history);
                }
            }

            // Auto-log status change
            $status = 'Pending';
            if (isset($_POST['history_status']) && !empty($_POST['history_status'])) {
                $status = end($_POST['history_status']);
            }
            $stmt_log = mysqli_prepare($con, "INSERT INTO shipment_history (tracking_id, date, time, location, status, updated_by, remarks) VALUES (?, CURDATE(), CURTIME(), ?, ?, 'System', 'Shipment Created')");
            mysqli_stmt_bind_param($stmt_log, "sss", $tnumbs_final, $dispatch_location, $status);
            mysqli_stmt_execute($stmt_log);

            // Commit Transaction
            mysqli_commit($con);

            // Send mail
            $subject = "Registered Shipment";
            $body = "<p>Dear $receiver_name</p> <p>We are pleased to inform you that your shipment has been registered with us at <strong>$sitename</strong>.</p>  <center>Tracking Information</center> <p> <strong>Tracking Number - $tnumbs_final </strong> </p> <p> <strong>Status - $status </strong> </p> <p> <strong>Package - $package_discription </strong> </p> <p> <strong>Dispatch Location - $dispatch_location </strong> </p> <p> <strong>Estimated Delivery Date - $destination </strong> </p> <p>For more information visit the <a href='$site_url/tracking.php'>Tracking Page</a> </p> ";
            sendMail($receiver_email, $subject, $body);

            $_SESSION['success_message'] = "Shipment created successfully with Tracking ID: " . htmlspecialchars($tnumbs_final);
            header("Location: edit.php?edit=" . urlencode($tnumbs_final));
            exit();

        } catch (Exception $e) {
            mysqli_rollback($con);
            $errors['db_error'] = "DATABASE ERROR: " . $e->getMessage() . " (Line: " . $e->getLine() . ")";
        }
    } else {
        $_SESSION['form_data'] = $_POST;
        $_SESSION['errors'] = $errors;
        header("Location: add-tracking.php");
        exit();
    }
}

if (isset($_SESSION['form_data'])) {
    $_POST = $_SESSION['form_data'];
    unset($_SESSION['form_data']);
}

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
 ?>

<span></span>

  <div class="page-wrapper">
    <div class="page-content">               
        <h1>Add Tracking</h1>
             <?php  
                  if (!empty($msg)) {
             ?>
                 <div class="alert alert-success"><?php echo $msg ?></div>

             <?php } ?>

               <?php  
                  if (!empty($errors)) {
             ?>
                 <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error ?></p>
                    <?php endforeach; ?>
                 </div>
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
                <div class="col-md-12">
                  <label for="tracking_number" class="form-label">Tracking Code</label>
                  <input type="text" readonly="" value="<?php echo $tnumbs ?>" name="tracking_number" class="form-control" id="tracking_number">
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
                <input type="text" class="form-control" id="shipper_name" name="sendername" value="<?php echo htmlspecialchars($_POST['sendername'] ?? ''); ?>" required>
                <?php if (isset($errors['sendername'])) : ?>
                  <div class="text-danger"><?php echo $errors['sendername']; ?></div>
                <?php endif; ?>
              </div>
              <div class="mb-3">
                <label for="shipper_phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="shipper_phone" name="sendercontact" value="<?php echo htmlspecialchars($_POST['sendercontact'] ?? ''); ?>" required>
                <?php if (isset($errors['sendercontact'])) : ?>
                  <div class="text-danger"><?php echo $errors['sendercontact']; ?></div>
                <?php endif; ?>
              </div>
              <div class="mb-3">
                <label for="shipper_address" class="form-label">Address</label>
                <input type="text" class="form-control" id="shipper_address" name="senderaddress" value="<?php echo htmlspecialchars($_POST['senderaddress'] ?? ''); ?>" required>
                <?php if (isset($errors['senderaddress'])) : ?>
                  <div class="text-danger"><?php echo $errors['senderaddress']; ?></div>
                <?php endif; ?>
              </div>
              <div class="mb-3">
                <label for="shipper_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="shipper_email" name="senderemail" value="<?php echo htmlspecialchars($_POST['senderemail'] ?? ''); ?>" required>
                <?php if (isset($errors['senderemail'])) : ?>
                  <div class="text-danger"><?php echo $errors['senderemail']; ?></div>
                <?php endif; ?>
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
                <input type="text" class="form-control" id="receiver_name" name="receivername" value="<?php echo htmlspecialchars($_POST['receivername'] ?? ''); ?>" required>
                <?php if (isset($errors['receivername'])) : ?>
                  <div class="text-danger"><?php echo $errors['receivername']; ?></div>
                <?php endif; ?>
              </div>
              <div class="mb-3">
                <label for="receiver_phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="receiver_phone" name="receivercontact" value="<?php echo htmlspecialchars($_POST['receivercontact'] ?? ''); ?>" required>
                <?php if (isset($errors['receivercontact'])) : ?>
                  <div class="text-danger"><?php echo $errors['receivercontact']; ?></div>
                <?php endif; ?>
              </div>
              <div class="mb-3">
                <label for="receiver_address" class="form-label">Address</label>
                <input type="text" class="form-control" id="receiver_address" name="receiveraddress" value="<?php echo htmlspecialchars($_POST['receiveraddress'] ?? ''); ?>" required>
                <?php if (isset($errors['receiveraddress'])) : ?>
                  <div class="text-danger"><?php echo $errors['receiveraddress']; ?></div>
                <?php endif; ?>
              </div>
              <div class="mb-3">
                <label for="receiver_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="receiver_email" name="receiver_email" value="<?php echo htmlspecialchars($_POST['receiver_email'] ?? ''); ?>" required>
                <?php if (isset($errors['receiver_email'])) : ?>
                  <div class="text-danger"><?php echo $errors['receiver_email']; ?></div>
                <?php endif; ?>
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
                  <select class="form-control" id="type_of_shipment" name="type_of_shipment" required>
                    <option value="">Select</option>
                    <option value="Express" <?php if (($_POST['type_of_shipment'] ?? '') == 'Express') echo 'selected'; ?>>Express</option>
                    <option value="Standard" <?php if (($_POST['type_of_shipment'] ?? '') == 'Standard') echo 'selected'; ?>>Standard</option>
                  </select>
                  <?php if (isset($errors['type_of_shipment'])) : ?>
                    <div class="text-danger"><?php echo $errors['type_of_shipment']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="col-md-4">
                  <label for="payment_mode" class="form-label">Payment Mode</label>
                  <select class="form-control" id="payment_mode" name="paymentmode" required>
                    <option value="">Select</option>
                    <option value="Cash" <?php if (($_POST['paymentmode'] ?? '') == 'Cash') echo 'selected'; ?>>Cash</option>
                    <option value="Card" <?php if (($_POST['paymentmode'] ?? '') == 'Card') echo 'selected'; ?>>Card</option>
                    <option value="Transfer" <?php if (($_POST['paymentmode'] ?? '') == 'Transfer') echo 'selected'; ?>>Transfer</option>
                  </select>
                  <?php if (isset($errors['paymentmode'])) : ?>
                    <div class="text-danger"><?php echo $errors['paymentmode']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="col-md-4">
                  <label for="total_cost" class="form-label">Total Cost</label>
                  <input type="text" class="form-control" id="total_cost" name="total_cost" value="<?php echo htmlspecialchars($_POST['total_cost'] ?? ''); ?>" required>
                  <?php if (isset($errors['total_cost'])) : ?>
                    <div class="text-danger"><?php echo $errors['total_cost']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="col-md-4">
                  <label for="carrier" class="form-label">Carrier</label>
                  <select class="form-control" id="carrier" name="carrier" required>
                    <option value="">Select</option>
                    <option value="DHL" <?php if (($_POST['carrier'] ?? '') == 'DHL') echo 'selected'; ?>>DHL</option>
                    <option value="UPS" <?php if (($_POST['carrier'] ?? '') == 'UPS') echo 'selected'; ?>>UPS</option>
                    <option value="FedEx" <?php if (($_POST['carrier'] ?? '') == 'FedEx') echo 'selected'; ?>>FedEx</option>
                  </select>
                  <?php if (isset($errors['carrier'])) : ?>
                    <div class="text-danger"><?php echo $errors['carrier']; ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-4">
                  <label for="courier" class="form-label">Courier</label>
                  <input type="text" class="form-control" id="courier" name="courier" value="<?php echo htmlspecialchars($_POST['courier'] ?? ''); ?>" required>
                  <?php if (isset($errors['courier'])) : ?>
                    <div class="text-danger"><?php echo $errors['courier']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="col-md-4">
                  <label for="mode" class="form-label">Mode</label>
                  <select class="form-control" id="mode" name="shipmentmethod" required>
                    <option value="">Select</option>
                    <option value="Land Shipping" <?php if (($_POST['shipmentmethod'] ?? '') == 'Land Shipping') echo 'selected'; ?>>Land Shipping</option>
                    <option value="Air Shipping" <?php if (($_POST['shipmentmethod'] ?? '') == 'Air Shipping') echo 'selected'; ?>>Air Shipping</option>
                    <option value="Sea Shipping" <?php if (($_POST['shipmentmethod'] ?? '') == 'Sea Shipping') echo 'selected'; ?>>Sea Shipping</option>
                  </select>
                  <?php if (isset($errors['shipmentmethod'])) : ?>
                    <div class="text-danger"><?php echo $errors['shipmentmethod']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="col-md-4">
                  <label for="origin" class="form-label">Origin</label>
                  <input type="text" class="form-control" id="origin" name="dispatchlocation" value="<?php echo htmlspecialchars($_POST['dispatchlocation'] ?? ''); ?>" required>
                  <?php if (isset($errors['dispatchlocation'])) : ?>
                    <div class="text-danger"><?php echo $errors['dispatchlocation']; ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-4">
                  <label for="destination" class="form-label">Destination</label>
                  <input type="text" class="form-control" id="destination" name="destination" value="<?php echo htmlspecialchars($_POST['destination'] ?? ''); ?>" required>
                  <?php if (isset($errors['destination'])) : ?>
                    <div class="text-danger"><?php echo $errors['destination']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="col-md-4">
                  <label for="weight" class="form-label">Weight</label>
                  <input type="text" class="form-control" id="weight" name="weight" value="<?php echo htmlspecialchars($_POST['weight'] ?? ''); ?>" required>
                  <?php if (isset($errors['weight'])) : ?>
                    <div class="text-danger"><?php echo $errors['weight']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="col-md-4">
                  <label for="packages_count" class="form-label">Packages count</label>
                  <input type="number" class="form-control" id="packages_count" name="quantity" value="<?php echo htmlspecialchars($_POST['quantity'] ?? ''); ?>" required>
                  <?php if (isset($errors['quantity'])) : ?>
                    <div class="text-danger"><?php echo $errors['quantity']; ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-8">
                  <label for="product_description" class="form-label">Product description</label>
                  <input type="text" class="form-control" id="product_description" name="packagedescription" value="<?php echo htmlspecialchars($_POST['packagedescription'] ?? ''); ?>" required>
                  <?php if (isset($errors['packagedescription'])) : ?>
                    <div class="text-danger"><?php echo $errors['packagedescription']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="col-md-4">
                  <label for="total_freight" class="form-label">Total Freight</label>
                  <input type="text" class="form-control" id="total_freight" name="total_freight" value="<?php echo htmlspecialchars($_POST['total_freight'] ?? ''); ?>" required>
                  <?php if (isset($errors['total_freight'])) : ?>
                    <div class="text-danger"><?php echo $errors['total_freight']; ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-4">
                  <label for="carrier_ref_no" class="form-label">Carrier Reference No.</label>
                  <input type="text" class="form-control" id="carrier_ref_no" name="carrierreferencenumber" value="<?php echo htmlspecialchars($_POST['carrierreferencenumber'] ?? ''); ?>" required>
                  <?php if (isset($errors['carrierreferencenumber'])) : ?>
                    <div class="text-danger"><?php echo $errors['carrierreferencenumber']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="col-md-4">
                  <label for="dispatch_date" class="form-label">Dispatch Date</label>
                  <input type="date" class="form-control" id="dispatch_date" name="dispatch_date" value="<?php echo htmlspecialchars($_POST['dispatch_date'] ?? ''); ?>" required>
                  <?php if (isset($errors['dispatch_date'])) : ?>
                    <div class="text-danger"><?php echo $errors['dispatch_date']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="col-md-4">
                  <label for="expected_delivery_date" class="form-label">Expected Delivery Date</label>
                  <input type="date" class="form-control" id="expected_delivery_date" name="estimateddeliverydate" value="<?php echo htmlspecialchars($_POST['estimateddeliverydate'] ?? ''); ?>" required>
                  <?php if (isset($errors['estimateddeliverydate'])) : ?>
                    <div class="text-danger"><?php echo $errors['estimateddeliverydate']; ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-12">
                  <label for="comments" class="form-label">Comments</label>
                  <textarea class="form-control" id="comments" name="comments" rows="3"><?php echo htmlspecialchars($_POST['comments'] ?? ''); ?></textarea>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-12">
                  <label for="image" class="form-label">Package Image</label>
                  <input type="file" class="form-control" id="image" name="image" onchange="previewImage(event)">
                </div>
                <div class="col-md-12 mt-3">
                    <img id="image_preview" src="#" alt="Image Preview" style="display: none; max-width: 200px; max-height: 200px;">
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
                  <?php if (isset($_POST['package_quantity'])) : ?>
                    <?php for ($i = 0; $i < count($_POST['package_quantity']); $i++) : ?>
                      <tr>
                        <td><input type="number" class="form-control" name="package_quantity[]" value="<?php echo htmlspecialchars($_POST['package_quantity'][$i]); ?>"></td>
                        <td><input type="text" class="form-control" name="package_piece_type[]" value="<?php echo htmlspecialchars($_POST['package_piece_type'][$i]); ?>"></td>
                        <td><input type="text" class="form-control" name="package_description[]" value="<?php echo htmlspecialchars($_POST['package_description'][$i]); ?>"></td>
                        <td><input type="number" class="form-control" name="package_length[]" value="<?php echo htmlspecialchars($_POST['package_length'][$i]); ?>"></td>
                        <td><input type="number" class="form-control" name="package_width[]" value="<?php echo htmlspecialchars($_POST['package_width'][$i]); ?>"></td>
                        <td><input type="number" class="form-control" name="package_height[]" value="<?php echo htmlspecialchars($_POST['package_height'][$i]); ?>"></td>
                        <td><input type="number" class="form-control" name="package_weight[]" value="<?php echo htmlspecialchars($_POST['package_weight'][$i]); ?>"></td>
                        <td><button type="button" class="btn btn-danger remove_row">Delete</button></td>
                      </tr>
                    <?php endfor; ?>
                  <?php endif; ?>
                </tbody>
              </table>
              <button type="button" class="btn btn-primary" id="add_package_row">Add Row</button>
              <button type="submit" name="add" class="btn btn-primary">Update</button>
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
                  <?php if (isset($_POST['history_date'])) : ?>
                    <?php for ($i = 0; $i < count($_POST['history_date']); $i++) : ?>
                      <tr>
                        <td><input type="date" class="form-control" name="history_date[]" value="<?php echo htmlspecialchars($_POST['history_date'][$i]); ?>"></td>
                        <td><input type="time" class="form-control" name="history_time[]" value="<?php echo htmlspecialchars($_POST['history_time'][$i]); ?>"></td>
                        <td><input type="text" class="form-control" name="history_location[]" value="<?php echo htmlspecialchars($_POST['history_location'][$i]); ?>"></td>
                        <td>
                          <select class="form-control" name="history_status[]">
                            <option <?php if ($_POST['history_status'][$i] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option <?php if ($_POST['history_status'][$i] == 'In Transit') echo 'selected'; ?>>In Transit</option>
                            <option <?php if ($_POST['history_status'][$i] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                            <option <?php if ($_POST['history_status'][$i] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                          </select>
                        </td>
                        <td><input type="text" class="form-control" name="history_updated_by[]" value="<?php echo htmlspecialchars($_POST['history_updated_by'][$i]); ?>"></td>
                        <td><input type="text" class="form-control" name="history_remarks[]" value="<?php echo htmlspecialchars($_POST['history_remarks'][$i]); ?>"></td>
                        <td><button type="button" class="btn btn-danger remove_row">Delete</button></td>
                      </tr>
                    <?php endfor; ?>
                  <?php endif; ?>
                </tbody>
              </table>
              <button type="button" class="btn btn-primary" id="add_history_row">Add Row</button>
              <button type="submit" name="add" class="btn btn-primary">Update</button>
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
      <td>
        <select class="form-control" name="history_status[]">
          <option>Pending</option>
          <option>In Transit</option>
          <option>Delivered</option>
          <option>Cancelled</option>
        </select>
      </td>
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

function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('image_preview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>