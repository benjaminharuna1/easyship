<?php
include 'auth.php'; // Use the new auth file for initialization

// Enable mysqli exceptions
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$msg = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);

$errors = [];
$row = [];
$package_items = [];
$shipment_history = [];
$edit_id = $_GET['edit'] ?? null;

if ($edit_id) {
    try {
        // Fetch main tracking data
        $stmt_main = mysqli_prepare($con, "SELECT * FROM addtracking WHERE tracking_id = ?");
        mysqli_stmt_bind_param($stmt_main, "s", $edit_id);
        mysqli_stmt_execute($stmt_main);
        $result_main = mysqli_stmt_get_result($stmt_main);
        if (mysqli_num_rows($result_main) > 0) {
            $row = mysqli_fetch_assoc($result_main);
        } else {
            $errors['not_found'] = "Tracking ID not found.";
        }

        // Fetch package items
        $stmt_items = mysqli_prepare($con, "SELECT * FROM package_items WHERE tracking_id = ?");
        mysqli_stmt_bind_param($stmt_items, "s", $edit_id);
        mysqli_stmt_execute($stmt_items);
        $result_items = mysqli_stmt_get_result($stmt_items);
        $package_items = mysqli_fetch_all($result_items, MYSQLI_ASSOC);

        // Fetch shipment history
        $stmt_history = mysqli_prepare($con, "SELECT * FROM shipment_history WHERE tracking_id = ?");
        mysqli_stmt_bind_param($stmt_history, "s", $edit_id);
        mysqli_stmt_execute($stmt_history);
        $result_history = mysqli_stmt_get_result($stmt_history);
        $shipment_history = mysqli_fetch_all($result_history, MYSQLI_ASSOC);

    } catch (Exception $e) {
        $errors['db_error'] = "Database query failed: " . $e->getMessage();
    }
} else {
    $errors['no_id'] = "No edit tracking ID provided.";
}

if (isset($_POST['update'])) {

    $send_email_update = isset($_POST['send_email_update']);
    $send_email_history = isset($_POST['send_email_history']);

    // Validation
    $required_fields = ['tracking_id', 'sendername', 'sendercontact', 'senderemail', 'senderaddress', 'dispatchlocation', 'carrier', 'carrierreferencenumber', 'weight', 'paymentmode', 'total_cost', 'receivername', 'receiver_email', 'receivercontact', 'receiveraddress', 'destination', 'packagedescription', 'dispatch_date', 'estimateddeliverydate', 'shipmentmethod', 'quantity'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = ucfirst($field) . " is required.";
        }
    }

    if (empty($errors)) {
        try {
            mysqli_begin_transaction($con);

            $sender_name = text_input($_POST['sendername']);
            $sender_email = text_input($_POST['senderemail']);
            $receiver_name = text_input($_POST['receivername']);
            $receiver_email = text_input($_POST['receiver_email']);

            // Image handling
            $packageImage = $_POST['current_image'];
            if (isset($_POST['remove_image']) && $_POST['remove_image'] == 1) {
                if (!empty($packageImage) && file_exists("../uploads/" . $packageImage)) {
                    unlink("../uploads/" . $packageImage);
                }
                $packageImage = "";
            } elseif (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
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

            $published = isset($_POST['publish']) ? 1 : 0;
            $tracking_id_input = $_POST['tracking_id'];
            $new_tracking_id = text_input($tracking_id_input);

            // Main tracking info update
            $update_query = "UPDATE addtracking SET tracking_id=?, sender_name=?, sender_contact=?, sender_email=?, sender_address=?, dispatch_location=?, carrier=?, carrier_refrence_number=?, weight=?, payment_mode=?, total_cost=?, receiver_name=?, receiver_contact=?, receiver_email=?, receiver_address=?, destination=?, package_discription=?, dispatch_date=?, estimated_delivery_date=?, shipment_mode=?, quantity=?, total_freight=?, courier=?, comments=?, type_of_shipment=?, total_volumetric_weight=?, total_actual_weight=?, published=?, image=? WHERE tracking_id=?";
            $stmt_update = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($stmt_update, "ssssssssssdssssssssssssssssiss", $new_tracking_id, $_POST['sendername'], $_POST['sendercontact'], $_POST['senderemail'], $_POST['senderaddress'], $_POST['dispatchlocation'], $_POST['carrier'], $_POST['carrierreferencenumber'], $_POST['weight'], $_POST['paymentmode'], $_POST['total_cost'], $receiver_name, $_POST['receivercontact'], $receiver_email, $_POST['receiveraddress'], $_POST['destination'], $_POST['packagedescription'], $_POST['dispatch_date'], $_POST['estimateddeliverydate'], $_POST['shipmentmethod'], $_POST['quantity'], $_POST['total_freight'], $_POST['courier'], $_POST['comments'], $_POST['type_of_shipment'], $_POST['total_volumetric_weight'], $_POST['total_actual_weight'], $published, $packageImage, $edit_id);
            mysqli_stmt_execute($stmt_update);

            // If tracking ID was changed, update related tables
            if ($new_tracking_id !== $edit_id) {
                $stmt_update_items = mysqli_prepare($con, "UPDATE package_items SET tracking_id = ? WHERE tracking_id = ?");
                mysqli_stmt_bind_param($stmt_update_items, "ss", $new_tracking_id, $edit_id);
                mysqli_stmt_execute($stmt_update_items);

                $stmt_update_history = mysqli_prepare($con, "UPDATE shipment_history SET tracking_id = ? WHERE tracking_id = ?");
                mysqli_stmt_bind_param($stmt_update_history, "ss", $new_tracking_id, $edit_id);
                mysqli_stmt_execute($stmt_update_history);
            }

            // Resubmitting package items
            $stmt_delete_items = mysqli_prepare($con, "DELETE FROM package_items WHERE tracking_id = ?");
            mysqli_stmt_bind_param($stmt_delete_items, "s", $new_tracking_id);
            mysqli_stmt_execute($stmt_delete_items);

            if (!empty($_POST['package_quantity'])) {
                $stmt_items = mysqli_prepare($con, "INSERT INTO package_items (tracking_id, quantity, piece_type, description, length, width, height, weight) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                for ($i = 0; $i < count($_POST['package_quantity']); $i++) {
                     mysqli_stmt_bind_param($stmt_items, "sissdddd", $new_tracking_id, $_POST['package_quantity'][$i], $_POST['package_piece_type'][$i], $_POST['package_description'][$i], $_POST['package_length'][$i], $_POST['package_width'][$i], $_POST['package_height'][$i], $_POST['package_weight'][$i]);
                    mysqli_stmt_execute($stmt_items);
                }
            }

            // Resubmitting shipment history
            $stmt_delete_history = mysqli_prepare($con, "DELETE FROM shipment_history WHERE tracking_id = ?");
            mysqli_stmt_bind_param($stmt_delete_history, "s", $new_tracking_id);
            mysqli_stmt_execute($stmt_delete_history);

            if (!empty($_POST['history_date'])) {
                $stmt_history = mysqli_prepare($con, "INSERT INTO shipment_history (tracking_id, date, time, location, status, updated_by, remarks) VALUES (?, ?, ?, ?, ?, ?, ?)");
                for ($i = 0; $i < count($_POST['history_date']); $i++) {
                    mysqli_stmt_bind_param($stmt_history, "sssssss", $new_tracking_id, $_POST['history_date'][$i], $_POST['history_time'][$i], $_POST['history_location'][$i], $_POST['history_status'][$i], $_POST['history_updated_by'][$i], $_POST['history_remarks'][$i]);
                    mysqli_stmt_execute($stmt_history);
                }
            }

            mysqli_commit($con);

            // Send emails if checked
            if ($send_email_update) {
                // Email to Receiver
                $email_data_receiver = ['name' => $receiver_name, 'tracking_id' => $new_tracking_id];
                sendMail($receiver_email, "Shipment Update: " . $new_tracking_id, 'shipment_update', $email_data_receiver);

                // Email to Sender
                $email_data_sender = ['name' => $sender_name, 'tracking_id' => $new_tracking_id];
                sendMail($sender_email, "Shipment Update: " . $new_tracking_id, 'shipment_update', $email_data_sender);
            }
            if ($send_email_history) {
                // Email to Receiver
                $email_data_receiver = ['name' => $receiver_name, 'tracking_id' => $new_tracking_id];
                sendMail($receiver_email, "Shipment History Update: " . $new_tracking_id, 'shipment_history_update', $email_data_receiver);

                // Email to Sender
                $email_data_sender = ['name' => $sender_name, 'tracking_id' => $new_tracking_id];
                sendMail($sender_email, "Shipment History Update: " . $new_tracking_id, 'shipment_history_update', $email_data_sender);
            }

            $_SESSION['success_message'] = "Updated successfully";
            header("Location: edit.php?edit=" . urlencode($new_tracking_id));
            exit();

        } catch (Exception $e) {
            mysqli_rollback($con);
            $errors['db_error'] = "DATABASE ERROR: " . $e->getMessage();
        }
    }
}
include 'header.php';
?>

<div class="page-wrapper">
    <div class="page-content">
        <?php if (!empty($msg)): ?>
            <div class="alert alert-success"><?php echo $msg; ?></div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($row)): ?>
            <form method="POST" action="edit.php?edit=<?php echo htmlspecialchars($edit_id); ?>" enctype="multipart/form-data">
                <main id="main" class="main">
                    <section class="section">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="tracking_id" class="form-label">Tracking ID</label>
                                    <input type="text" id="tracking_id" name="tracking_id" value="<?php echo htmlspecialchars($_POST['tracking_id'] ?? $row['tracking_id']); ?>" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <!-- Shipper and Receiver Cards -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Shipper Details</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Shipper Name</label>
                                            <input type="text" class="form-control" name="sendername" value="<?php echo htmlspecialchars($_POST['sendername'] ?? $row['sender_name']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" name="sendercontact" value="<?php echo htmlspecialchars($_POST['sendercontact'] ?? $row['sender_contact']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" name="senderaddress" value="<?php echo htmlspecialchars($_POST['senderaddress'] ?? $row['sender_address']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="senderemail" value="<?php echo htmlspecialchars($_POST['senderemail'] ?? $row['sender_email']); ?>" required>
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
                                            <input type="text" class="form-control" name="receivername" value="<?php echo htmlspecialchars($_POST['receivername'] ?? $row['receiver_name']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" name="receivercontact" value="<?php echo htmlspecialchars($_POST['receivercontact'] ?? $row['receiver_contact']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" name="receiveraddress" value="<?php echo htmlspecialchars($_POST['receiveraddress'] ?? $row['receiver_address']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="receiver_email" value="<?php echo htmlspecialchars($_POST['receiver_email'] ?? $row['receiver_email']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Basic Info & Shipment Details Cards -->
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
                                                    <option value="Express" <?php if (($_POST['type_of_shipment'] ?? $row['type_of_shipment']) == 'Express') echo 'selected'; ?>>Express</option>
                                                    <option value="Standard" <?php if (($_POST['type_of_shipment'] ?? $row['type_of_shipment']) == 'Standard') echo 'selected'; ?>>Standard</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Payment Mode</label>
                                                <select class="form-control" name="paymentmode" required>
                                                    <option value="">Select</option>
                                                    <option value="Cash" <?php if (($_POST['paymentmode'] ?? $row['payment_mode']) == 'Cash') echo 'selected'; ?>>Cash</option>
                                                    <option value="Card" <?php if (($_POST['paymentmode'] ?? $row['payment_mode']) == 'Card') echo 'selected'; ?>>Card</option>
                                                    <option value="Transfer" <?php if (($_POST['paymentmode'] ?? $row['payment_mode']) == 'Transfer') echo 'selected'; ?>>Transfer</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Total Cost</label>
                                                <input type="text" class="form-control" name="total_cost" value="<?php echo htmlspecialchars($_POST['total_cost'] ?? $row['total_cost']); ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Carrier</label>
                                                <select class="form-control" name="carrier" required>
                                                    <option value="">Select</option>
                                                    <option value="DHL" <?php if (($_POST['carrier'] ?? $row['carrier']) == 'DHL') echo 'selected'; ?>>DHL</option>
                                                    <option value="UPS" <?php if (($_POST['carrier'] ?? $row['carrier']) == 'UPS') echo 'selected'; ?>>UPS</option>
                                                    <option value="FedEx" <?php if (($_POST['carrier'] ?? $row['carrier']) == 'FedEx') echo 'selected'; ?>>FedEx</option>
                                                    <option value="<?php echo htmlspecialchars($sitename); ?>" <?php if (($_POST['carrier'] ?? $row['carrier']) == $sitename) echo 'selected'; ?>><?php echo htmlspecialchars($sitename); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Courier</label>
                                                <select class="form-control" name="courier" required>
                                                    <option value="">Select</option>
                                                    <option value="DHL" <?php if (($_POST['courier'] ?? $row['courier']) == 'DHL') echo 'selected'; ?>>DHL</option>
                                                    <option value="UPS" <?php if (($_POST['courier'] ?? $row['courier']) == 'UPS') echo 'selected'; ?>>UPS</option>
                                                    <option value="FedEx" <?php if (($_POST['courier'] ?? $row['courier']) == 'FedEx') echo 'selected'; ?>>FedEx</option>
                                                    <option value="<?php echo htmlspecialchars($sitename); ?>" <?php if (($_POST['courier'] ?? $row['courier']) == $sitename) echo 'selected'; ?>><?php echo htmlspecialchars($sitename); ?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Mode</label>
                                                <select class="form-control" name="shipmentmethod" required>
                                                    <option value="">Select</option>
                                                    <option value="Land Shipping" <?php if (($_POST['shipmentmethod'] ?? $row['shipment_mode']) == 'Land Shipping') echo 'selected'; ?>>Land Shipping</option>
                                                    <option value="Air Shipping" <?php if (($_POST['shipmentmethod'] ?? $row['shipment_mode']) == 'Air Shipping') echo 'selected'; ?>>Air Shipping</option>
                                                    <option value="Sea Shipping" <?php if (($_POST['shipmentmethod'] ?? $row['shipment_mode']) == 'Sea Shipping') echo 'selected'; ?>>Sea Shipping</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Origin</label>
                                                <input type="text" class="form-control" name="dispatchlocation" value="<?php echo htmlspecialchars($_POST['dispatchlocation'] ?? $row['dispatch_location']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Destination</label>
                                                <input type="text" class="form-control" name="destination" value="<?php echo htmlspecialchars($_POST['destination'] ?? $row['destination']); ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Weight</label>
                                                <input type="text" class="form-control" name="weight" value="<?php echo htmlspecialchars($_POST['weight'] ?? $row['weight']); ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Packages count</label>
                                                <input type="number" class="form-control" name="quantity" value="<?php echo htmlspecialchars($_POST['quantity'] ?? $row['quantity']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-8">
                                                <label class="form-label">Product description</label>
                                                <input type="text" class="form-control" name="packagedescription" value="<?php echo htmlspecialchars($_POST['packagedescription'] ?? $row['package_discription']); ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Total Freight</label>
                                                <input type="text" class="form-control" name="total_freight" value="<?php echo htmlspecialchars($_POST['total_freight'] ?? $row['total_freight']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Carrier Reference No.</label>
                                                <input type="text" class="form-control" name="carrierreferencenumber" value="<?php echo htmlspecialchars($_POST['carrierreferencenumber'] ?? $row['carrier_refrence_number']); ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Dispatch Date</label>
                                                <input type="date" class="form-control" name="dispatch_date" value="<?php echo htmlspecialchars($_POST['dispatch_date'] ?? $row['dispatch_date']); ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Expected Delivery Date</label>
                                                <input type="date" class="form-control" name="estimateddeliverydate" value="<?php echo htmlspecialchars($_POST['estimateddeliverydate'] ?? $row['estimated_delivery_date']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <label class="form-label">Comments</label>
                                                <textarea class="form-control" name="comments" rows="3"><?php echo htmlspecialchars($_POST['comments'] ?? $row['comments']); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <label class="form-label">Package Image</label>
                                                <input type="file" class="form-control" name="image" onchange="previewImage(event)">
                                                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($row['image'] ?? ''); ?>">
                                                <input type="hidden" name="remove_image" id="remove_image" value="0">
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <img id="image_preview" src="<?php echo !empty($row['image']) ? '../uploads/' . htmlspecialchars($row['image']) : '#'; ?>" alt="Image Preview" style="max-width: 200px; max-height: 200px; <?php if (empty($row['image'])) echo 'display: none;'; ?>">
                                            </div>
                                            <?php if (!empty($row['image'])): ?>
                                                <div class="col-md-12 mt-2">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeCurrentImage()">Remove Image</button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Package Items and History Cards -->
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
                                                <?php $items = isset($_POST['package_quantity']) ? count($_POST['package_quantity']) : count($package_items);
                                                for ($i = 0; $i < $items; $i++) { ?>
                                                    <tr>
                                                        <td><input type="number" class="form-control" name="package_quantity[]" value="<?php echo htmlspecialchars($_POST['package_quantity'][$i] ?? $package_items[$i]['quantity']); ?>"></td>
                                                        <td><input type="text" class="form-control" name="package_piece_type[]" value="<?php echo htmlspecialchars($_POST['package_piece_type'][$i] ?? $package_items[$i]['piece_type']); ?>"></td>
                                                        <td><input type="text" class="form-control" name="package_description[]" value="<?php echo htmlspecialchars($_POST['package_description'][$i] ?? $package_items[$i]['description']); ?>"></td>
                                                        <td><input type="number" class="form-control" name="package_length[]" step="any" value="<?php echo htmlspecialchars($_POST['package_length'][$i] ?? $package_items[$i]['length']); ?>"></td>
                                                        <td><input type="number" class="form-control" name="package_width[]" step="any" value="<?php echo htmlspecialchars($_POST['package_width'][$i] ?? $package_items[$i]['width']); ?>"></td>
                                                        <td><input type="number" class="form-control" name="package_height[]" step="any" value="<?php echo htmlspecialchars($_POST['package_height'][$i] ?? $package_items[$i]['height']); ?>"></td>
                                                        <td><input type="number" class="form-control" name="package_weight[]" step="any" value="<?php echo htmlspecialchars($_POST['package_weight'][$i] ?? $package_items[$i]['weight']); ?>"></td>
                                                        <td><button type="button" class="btn btn-danger remove_row">Delete</button></td>
                                                    </tr>
                                                <?php } ?>
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
                                                <?php $history_items = isset($_POST['history_date']) ? count($_POST['history_date']) : count($shipment_history);
                                                for ($i = 0; $i < $history_items; $i++) { ?>
                                                    <tr>
                                                        <td><input type="date" class="form-control" name="history_date[]" value="<?php echo htmlspecialchars($_POST['history_date'][$i] ?? $shipment_history[$i]['date']); ?>"></td>
                                                        <td><input type="time" class="form-control" name="history_time[]" value="<?php echo htmlspecialchars($_POST['history_time'][$i] ?? $shipment_history[$i]['time']); ?>"></td>
                                                        <td><input type="text" class="form-control" name="history_location[]" value="<?php echo htmlspecialchars($_POST['history_location'][$i] ?? $shipment_history[$i]['location']); ?>"></td>
                                                        <td>
                                                            <select class="form-control" name="history_status[]">
                                                                <option value="Pending" <?php if (($_POST['history_status'][$i] ?? $shipment_history[$i]['status']) == 'Pending') echo 'selected'; ?>>Pending</option>
                                                                <option value="In Process" <?php if (($_POST['history_status'][$i] ?? $shipment_history[$i]['status']) == 'In Process') echo 'selected'; ?>>In Process</option>
                                                                <option value="In Transit" <?php if (($_POST['history_status'][$i] ?? $shipment_history[$i]['status']) == 'In Transit') echo 'selected'; ?>>In Transit</option>
                                                                <option value="On Hold" <?php if (($_POST['history_status'][$i] ?? $shipment_history[$i]['status']) == 'On Hold') echo 'selected'; ?>>On Hold</option>
                                                                <option value="Delivered" <?php if (($_POST['history_status'][$i] ?? $shipment_history[$i]['status']) == 'Delivered') echo 'selected'; ?>>Delivered</option>
                                                                <option value="Cancelled" <?php if (($_POST['history_status'][$i] ?? $shipment_history[$i]['status']) == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                                                <option value="Returned" <?php if (($_POST['history_status'][$i] ?? $shipment_history[$i]['status']) == 'Returned') echo 'selected'; ?>>Returned</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" class="form-control" name="history_updated_by[]" value="<?php echo htmlspecialchars($_POST['history_updated_by'][$i] ?? $shipment_history[$i]['updated_by']); ?>"></td>
                                                        <td><input type="text" class="form-control" name="history_remarks[]" value="<?php echo htmlspecialchars($_POST['history_remarks'][$i] ?? $shipment_history[$i]['remarks']); ?>"></td>
                                                        <td><button type="button" class="btn btn-danger remove_row">Delete</button></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-primary" id="add_history_row">Add Row</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" name="send_email_update" id="send_email_update">
                                            <label class="form-check-label" for="send_email_update">Notify Shipper and Receiver of package update</label>
                                        </div>
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" name="send_email_history" id="send_email_history">
                                            <label class="form-check-label" for="send_email_history">Notify Shipper and Receiver of shipment history update</label>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>
                </main>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
      let historyRow = `
        <tr>
          <td><input type="date" class="form-control" name="history_date[]"></td>
          <td><input type="time" class="form-control" name="history_time[]"></td>
          <td><input type="text" class="form-control" name="history_location[]"></td>
          <td>
            <select class="form-control" name="history_status[]">
              <option value="Pending">Pending</option>
              <option value="In Process">In Process</option>
              <option value="In Transit">In Transit</option>
              <option value="On Hold">On Hold</option>
              <option value="Delivered">Delivered</option>
              <option value="Cancelled">Cancelled</option>
              <option value="Returned">Returned</option>
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
            document.getElementById('remove_image').value = 0;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function removeCurrentImage() {
        var output = document.getElementById('image_preview');
        output.src = '#';
        output.style.display = 'none';
        document.getElementById('image').value = ''; // Clear the file input
        document.getElementById('remove_image').value = 1;
        document.querySelector('[name="current_image"]').value = '';
    }
</script>