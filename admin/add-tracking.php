<?php
include 'auth.php';


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

$date_added = date('Y-m-d H:i:s');

if (isset($_POST['add']) || isset($_POST['publish'])) {

    $published = isset($_POST['publish']) ? 1 : 0;
    $send_email_notification = isset($_POST['send_email_notification']);

    // Validation
    $required_fields = [
        'sendername' => 'Sender name is required.', 'sendercontact' => 'Sender contact is required.',
        'senderemail' => 'Sender email is required.', 'senderaddress' => 'Sender address is required.',
        'dispatchlocation' => 'Dispatch location is required.', 'carrier' => 'Carrier is required.',
        'carrierreferencenumber' => 'Carrier reference number is required.', 'weight' => 'Weight is required.',
        'paymentmode' => 'Payment mode is required.', 'total_cost' => 'Total cost is required.',
        'receivername' => 'Receiver name is required.', 'receiver_email' => 'Receiver email is required.',
        'receivercontact' => 'Receiver contact is required.', 'receiveraddress' => 'Receiver address is required.',
        'destination' => 'Destination is required.', 'packagedescription' => 'Package description is required.',
        'dispatch_date' => 'Dispatch date is required.', 'estimateddeliverydate' => 'Estimated delivery date is required.',
        'shipmentmethod' => 'Shipment method is required.', 'quantity' => 'Quantity is required.'
    ];

    foreach ($required_fields as $field => $message) {
        if (empty($_POST[$field])) {
            $errors[$field] = $message;
        }
    }

    if (empty($errors)) {
        try {
            mysqli_begin_transaction($con);

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
                $allowed_extensions = ["jpeg", "jpg", "png", "gif"];
                $file_ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                if (!in_array($file_ext, $allowed_extensions)) {
                    throw new Exception("Extension not allowed, please choose a valid image file.");
                }
                $packageImage = time() . '_' . basename($_FILES["image"]["name"]);
                if (!move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/" . $packageImage)) {
                    throw new Exception("Failed to upload image.");
                }
            }

            // Tracking number generation
            $tnumbs_final = text_input($_POST['tracking_id']);
            if (empty($tnumbs_final)) {
                $tnumbs_final = $_POST['auto_tracking_id'];
            }

            // Insert into addtracking
            $stmt = mysqli_prepare($con, "INSERT INTO addtracking (tracking_id, sender_name, sender_contact, sender_email, sender_address, dispatch_location, carrier, carrier_refrence_number, weight, payment_mode, total_cost, image, receiver_name, receiver_contact, receiver_email, receiver_address, destination, package_discription, dispatch_date, estimated_delivery_date, shipment_mode, quantity, date_added, total_freight, courier, comments, type_of_shipment, total_volumetric_weight, total_actual_weight, published) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssssssssssdssssssssssssssssssi", $tnumbs_final, $sender_name, $sender_contact, $sender_email, $sender_address, $dispatch_location, $carrier, $carrier_refrence_number, $weight, $payment_mode, $total_cost, $packageImage, $receiver_name, $receiver_contact, $receiver_email, $receiver_address, $destination, $package_discription, $dispatch_date, $estimated_delivery_date, $shipment_mode, $quantity, $date_added, $total_freight, $courier, $comments, $type_of_shipment, $total_volumetric_weight, $total_actual_weight, $published);
            mysqli_stmt_execute($stmt);

            // Process package items
            if (!empty($_POST['package_quantity']) && is_array($_POST['package_quantity'])) {
                $stmt_items = mysqli_prepare($con, "INSERT INTO package_items (tracking_id, quantity, piece_type, description, length, width, height, weight) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                for ($i = 0; $i < count($_POST['package_quantity']); $i++) {
                    mysqli_stmt_bind_param($stmt_items, "sissdddd", $tnumbs_final, $_POST['package_quantity'][$i], $_POST['package_piece_type'][$i], $_POST['package_description'][$i], $_POST['package_length'][$i], $_POST['package_width'][$i], $_POST['package_height'][$i], $_POST['package_weight'][$i]);
                    mysqli_stmt_execute($stmt_items);
                }
            }

            // Process shipment history
            $status = 'Pending';
            if (!empty($_POST['history_date']) && is_array($_POST['history_date'])) {
                $stmt_history = mysqli_prepare($con, "INSERT INTO shipment_history (tracking_id, date, time, location, status, updated_by, remarks) VALUES (?, ?, ?, ?, ?, ?, ?)");
                for ($i = 0; $i < count($_POST['history_date']); $i++) {
                    mysqli_stmt_bind_param($stmt_history, "sssssss", $tnumbs_final, $_POST['history_date'][$i], $_POST['history_time'][$i], $_POST['history_location'][$i], $_POST['history_status'][$i], $_POST['history_updated_by'][$i], $_POST['history_remarks'][$i]);
                    mysqli_stmt_execute($stmt_history);
                }
                $status = end($_POST['history_status']);
            }
            // Auto-log creation event
            $stmt_log = mysqli_prepare($con, "INSERT INTO shipment_history (tracking_id, date, time, location, status, updated_by, remarks) VALUES (?, CURDATE(), CURTIME(), ?, ?, 'System', 'Shipment Created')");
            mysqli_stmt_bind_param($stmt_log, "sss", $tnumbs_final, $dispatch_location, $status);
            mysqli_stmt_execute($stmt_log);

            mysqli_commit($con);

            if ($send_email_notification) {
                $email_data = [
                    'receiver_name' => $receiver_name,
                    'tracking_id' => $tnumbs_final,
                    'status' => $status,
                    'package_description' => $package_discription,
                    'dispatch_location' => $dispatch_location,
                    'delivery_date' => $estimated_delivery_date
                ];
                sendMail($receiver_email, "Shipment Created: " . $tnumbs_final, 'shipment_creation', $email_data);
            }

            $_SESSION['success_message'] = "Shipment created successfully with Tracking ID: " . htmlspecialchars($tnumbs_final);
            header("Location: edit.php?edit=" . urlencode($tnumbs_final));
            exit();

        } catch (Exception $e) {
            mysqli_rollback($con);
            $errors['db_error'] = "DATABASE ERROR: " . $e->getMessage() . " (Line: " . $e->getLine() . ")";
        }
    }
}
include 'header.php';
?>

<div class="page-wrapper">
    <div class="page-content">
        <h1>Add Tracking</h1>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

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
                                            <label for="tracking_id" class="form-label">Tracking ID (leave blank to auto-generate)</label>
                                            <input type="text" id="tracking_id" name="tracking_id" value="<?php echo htmlspecialchars($_POST['tracking_id'] ?? $tnumbs); ?>" class="form-control">
                                            <input type="hidden" name="auto_tracking_id" value="<?php echo htmlspecialchars($tnumbs); ?>">
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
                                        <label class="form-label">Shipper Name</label>
                                        <input type="text" class="form-control" name="sendername" value="<?php echo htmlspecialchars($_POST['sendername'] ?? ''); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="sendercontact" value="<?php echo htmlspecialchars($_POST['sendercontact'] ?? ''); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" name="senderaddress" value="<?php echo htmlspecialchars($_POST['senderaddress'] ?? ''); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="senderemail" value="<?php echo htmlspecialchars($_POST['senderemail'] ?? ''); ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Receiver Details</h5>
                                    <div class="mb-3">
                                        <label class="form-label">Receiver Name</label>
                                        <input type="text" class="form-control" name="receivername" value="<?php echo htmlspecialchars($_POST['receivername'] ?? ''); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="receivercontact" value="<?php echo htmlspecialchars($_POST['receivercontact'] ?? ''); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" name="receiveraddress" value="<?php echo htmlspecialchars($_POST['receiveraddress'] ?? ''); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="receiver_email" value="<?php echo htmlspecialchars($_POST['receiver_email'] ?? ''); ?>" required>
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
                                            <label class="form-label">Type of Shipment</label>
                                            <select class="form-control" name="type_of_shipment" required>
                                                <option value="">Select</option>
                                                <option value="Express" <?php if (($_POST['type_of_shipment'] ?? '') == 'Express') echo 'selected'; ?>>Express</option>
                                                <option value="Standard" <?php if (($_POST['type_of_shipment'] ?? '') == 'Standard') echo 'selected'; ?>>Standard</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Payment Mode</label>
                                            <select class="form-control" name="paymentmode" required>
                                                <option value="">Select</option>
                                                <option value="Cash" <?php if (($_POST['paymentmode'] ?? '') == 'Cash') echo 'selected'; ?>>Cash</option>
                                                <option value="Card" <?php if (($_POST['paymentmode'] ?? '') == 'Card') echo 'selected'; ?>>Card</option>
                                                <option value="Transfer" <?php if (($_POST['paymentmode'] ?? '') == 'Transfer') echo 'selected'; ?>>Transfer</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Total Cost</label>
                                            <input type="text" class="form-control" name="total_cost" value="<?php echo htmlspecialchars($_POST['total_cost'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Carrier</label>
                                            <select class="form-control" name="carrier" required>
                                                <option value="">Select</option>
                                                <option value="DHL" <?php if (($_POST['carrier'] ?? '') == 'DHL') echo 'selected'; ?>>DHL</option>
                                                <option value="UPS" <?php if (($_POST['carrier'] ?? '') == 'UPS') echo 'selected'; ?>>UPS</option>
                                                <option value="FedEx" <?php if (($_POST['carrier'] ?? '') == 'FedEx') echo 'selected'; ?>>FedEx</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Courier</label>
                                            <input type="text" class="form-control" name="courier" value="<?php echo htmlspecialchars($_POST['courier'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Mode</label>
                                            <select class="form-control" name="shipmentmethod" required>
                                                <option value="">Select</option>
                                                <option value="Land Shipping" <?php if (($_POST['shipmentmethod'] ?? '') == 'Land Shipping') echo 'selected'; ?>>Land Shipping</option>
                                                <option value="Air Shipping" <?php if (($_POST['shipmentmethod'] ?? '') == 'Air Shipping') echo 'selected'; ?>>Air Shipping</option>
                                                <option value="Sea Shipping" <?php if (($_POST['shipmentmethod'] ?? '') == 'Sea Shipping') echo 'selected'; ?>>Sea Shipping</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Origin</label>
                                            <input type="text" class="form-control" name="dispatchlocation" value="<?php echo htmlspecialchars($_POST['dispatchlocation'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Destination</label>
                                            <input type="text" class="form-control" name="destination" value="<?php echo htmlspecialchars($_POST['destination'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Weight</label>
                                            <input type="text" class="form-control" name="weight" value="<?php echo htmlspecialchars($_POST['weight'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Packages count</label>
                                            <input type="number" class="form-control" name="quantity" value="<?php echo htmlspecialchars($_POST['quantity'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-8">
                                            <label class="form-label">Product description</label>
                                            <input type="text" class="form-control" name="packagedescription" value="<?php echo htmlspecialchars($_POST['packagedescription'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Total Freight</label>
                                            <input type="text" class="form-control" name="total_freight" value="<?php echo htmlspecialchars($_POST['total_freight'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Carrier Reference No.</label>
                                            <input type="text" class="form-control" name="carrierreferencenumber" value="<?php echo htmlspecialchars($_POST['carrierreferencenumber'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Dispatch Date</label>
                                            <input type="date" class="form-control" name="dispatch_date" value="<?php echo htmlspecialchars($_POST['dispatch_date'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Expected Delivery Date</label>
                                            <input type="date" class="form-control" name="estimateddeliverydate" value="<?php echo htmlspecialchars($_POST['estimateddeliverydate'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Comments</label>
                                            <textarea class="form-control" name="comments" rows="3"><?php echo htmlspecialchars($_POST['comments'] ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Package Image</label>
                                            <input type="file" class="form-control" name="image" onchange="previewImage(event)">
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
                                                <th>Quantity</th>
                                                <th>Piece Type</th>
                                                <th>Description</th>
                                                <th>Length (cm)</th>
                                                <th>Width (cm)</th>
                                                <th>Height (cm)</th>
                                                <th>Weight (kg)</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($_POST['package_quantity'])) {
                                                for ($i = 0; $i < count($_POST['package_quantity']); $i++) { ?>
                                                    <tr>
                                                        <td><input type="number" class="form-control" name="package_quantity[]" value="<?php echo htmlspecialchars($_POST['package_quantity'][$i]); ?>"></td>
                                                        <td><input type="text" class="form-control" name="package_piece_type[]" value="<?php echo htmlspecialchars($_POST['package_piece_type'][$i]); ?>"></td>
                                                        <td><input type="text" class="form-control" name="package_description[]" value="<?php echo htmlspecialchars($_POST['package_description'][$i]); ?>"></td>
                                                        <td><input type="number" class="form-control" name="package_length[]" step="any" value="<?php echo htmlspecialchars($_POST['package_length'][$i]); ?>"></td>
                                                        <td><input type="number" class="form-control" name="package_width[]" step="any" value="<?php echo htmlspecialchars($_POST['package_width'][$i]); ?>"></td>
                                                        <td><input type="number" class="form-control" name="package_height[]" step="any" value="<?php echo htmlspecialchars($_POST['package_height'][$i]); ?>"></td>
                                                        <td><input type="number" class="form-control" name="package_weight[]" step="any" value="<?php echo htmlspecialchars($_POST['package_weight'][$i]); ?>"></td>
                                                        <td><button type="button" class="btn btn-danger remove_row">Delete</button></td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary" id="add_package_row">Add Row</button>
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
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Location</th>
                                                <th>Status</th>
                                                <th>Updated By</th>
                                                <th>Remarks</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($_POST['history_date'])) {
                                                for ($i = 0; $i < count($_POST['history_date']); $i++) { ?>
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
                                            <?php }
                                            } ?>
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
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" name="send_email_notification" id="send_email_notification" value="1" <?php if (isset($_POST['send_email_notification'])) echo 'checked'; ?>>
                                        <label class="form-check-label" for="send_email_notification">Send shipment notification to user</label>
                                    </div>
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="submit" name="add" class="btn btn-primary">Save</button>
                                        <button type="submit" name="publish" class="btn btn-secondary ms-2">Publish</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </form>
    </div>
</div>

<script>
    // JavaScript for adding/removing rows and calculating weights remains the same
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
          <td><input type="number" class="form-control" name="package_length[]" step="any"></td>
          <td><input type="number" class="form-control" name="package_width[]" step="any"></td>
          <td><input type="number" class="form-control" name="package_height[]" step="any"></td>
          <td><input type="number" class="form-control" name="package_weight[]" step="any"></td>
          <td><button type="button" class="btn btn-danger remove_row">Delete</button></td>
        </tr>
      `;
      document.getElementById('add_package_row').addEventListener('click', function() {
        document.querySelector('#package_items_table tbody').insertAdjacentHTML('beforeend', packageRow);
      });

      document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove_row')) {
          e.target.closest('tr').remove();
        }
      });
    });

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('image_preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
<?php include 'footer.php'; ?>