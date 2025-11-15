<?php
include 'header.php';

$msg = ""; 
$err = "";

if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];

    $sql = mysqli_query($con, "SELECT * FROM addtracking WHERE tracking_id = '$edit_id' ");
    if (mysqli_num_rows($sql) > 0 ) {
        $row = mysqli_fetch_assoc($sql);
    }

    $package_items_sql = mysqli_query($con, "SELECT * FROM package_items WHERE tracking_id = '$edit_id' ");
    $package_items = mysqli_fetch_all($package_items_sql, MYSQLI_ASSOC);

    $shipment_history_sql = mysqli_query($con, "SELECT * FROM shipment_history WHERE tracking_id = '$edit_id' ");
    $shipment_history = mysqli_fetch_all($shipment_history_sql, MYSQLI_ASSOC);
}

if (isset($_POST['update'])) {
    // Validation
    $required_fields = ['sendername', 'sendercontact', 'senderemail', 'senderaddress', 'status', 'dispatchlocation', 'carrier', 'carrierreferencenumber', 'weight', 'paymentmode', 'receivername', 'recevieremail', 'receviercontact', 'recevieraddress', 'destination', 'packagedescription', 'dipatchdate', 'estimateddeliverydate', 'shipmentmethod', 'quantity', 'deliverytime'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $err = "Please fill in all required fields.";
            break;
        }
    }

    if (empty($err)) {
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
        $departure_time = text_input($_POST['departure_time'] ?? '');
        $pickup_time = text_input($_POST['pickup_time'] ?? '');
        $comments = text_input($_POST['comments'] ?? '');
        $datetimepicker = text_input($_POST['datetimepicker'] ?? '');
        $type_of_shipment = text_input($_POST['type_of_shipment'] ?? '');
        $total_volumetric_weight = text_input($_POST['total_volumetric_weight'] ?? '');
        $total_actual_weight = text_input($_POST['total_actual_weight'] ?? '');
        $published = isset($_POST['publish']) ? 1 : 0;

        $stmt = mysqli_prepare($con, "UPDATE addtracking SET sender_name=?, sender_contact=?, sender_email=?, sender_address=?, status=?, dispatch_location=?, carrier=?, carrier_refrence_number=?, weight=?, payment_mode=?, receiver_name=?, receiver_contact=?, receiver_email=?, receiver_address=?, destination=?, package_discription=?, dispach_date=?, estimated_delivery_date=?, shipment_mode=?, quantity=?, delivery_time=?, remarks=?, total_freight=?, courier=?, departure_time=?, pickup_time=?, comments=?, datetimepicker=?, type_of_shipment=?, total_volumetric_weight=?, total_actual_weight=?, published=? WHERE tracking_id=?");
        mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssssssssssssis", $sender_name, $sender_contact, $sender_email, $sender_address, $status, $dispatch_location, $carrier, $carrier_refrence_number, $weight, $payment_mode, $receiver_name, $receiver_contact, $receiver_email, $receiver_address, $destination, $package_discription, $dispach_date, $estimated_delivery_date, $shipment_mode, $quantity, $delivery_time, $remarks, $total_freight, $courier, $departure_time, $pickup_time, $comments, $datetimepicker, $type_of_shipment, $total_volumetric_weight, $total_actual_weight, $published, $edit_id);
        $update = mysqli_stmt_execute($stmt);

        if ($update) {
            // Delete existing package items and shipment history
            $stmt = mysqli_prepare($con, "DELETE FROM package_items WHERE tracking_id = ?");
            mysqli_stmt_bind_param($stmt, "s", $edit_id);
            mysqli_stmt_execute($stmt);

            $stmt = mysqli_prepare($con, "DELETE FROM shipment_history WHERE tracking_id = ?");
            mysqli_stmt_bind_param($stmt, "s", $edit_id);
            mysqli_stmt_execute($stmt);

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
                    mysqli_stmt_bind_param($stmt, "sissdddd", $edit_id, $package_quantity, $package_piece_type, $package_description, $package_length, $package_width, $package_height, $package_weight);
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
                    mysqli_stmt_bind_param($stmt, "sssssss", $edit_id, $history_date, $history_time, $history_location, $history_status, $history_updated_by, $history_remarks);
                    mysqli_stmt_execute($stmt);
                }
            }
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
                      <h1> <?php echo $row['tracking_id'];  ?> </h1>
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
              <h5 class="card-title">Edit Shipment</h5>

             <form method="POST" action="edit.php?edit=<?php echo $edit_id;  ?>">
                <main id="main" class="main">
                    <section class="section">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Shipment Details</h5>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="type_of_shipment" class="form-label">Type of Shipment</label>
                                                <select class="form-control" id="type_of_shipment" name="type_of_shipment">
                                                    <option <?php if($row['type_of_shipment'] == 'Select') echo 'selected'; ?>>Select</option>
                                                    <option <?php if($row['type_of_shipment'] == 'Express') echo 'selected'; ?>>Express</option>
                                                    <option <?php if($row['type_of_shipment'] == 'Standard') echo 'selected'; ?>>Standard</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="payment_mode" class="form-label">Payment Mode</label>
                                                <select class="form-control" id="payment_mode" name="paymentmode">
                                                    <option <?php if($row['payment_mode'] == 'Select') echo 'selected'; ?>>Select</option>
                                                    <option <?php if($row['payment_mode'] == 'Cash') echo 'selected'; ?>>Cash</option>
                                                    <option <?php if($row['payment_mode'] == 'Card') echo 'selected'; ?>>Card</option>
                                                    <option <?php if($row['payment_mode'] == 'Transfer') echo 'selected'; ?>>Transfer</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="carrier" class="form-label">Carrier</label>
                                                <select class="form-control" id="carrier" name="carrier">
                                                    <option <?php if($row['carrier'] == 'Select') echo 'selected'; ?>>Select</option>
                                                    <option <?php if($row['carrier'] == 'DHL') echo 'selected'; ?>>DHL</option>
                                                    <option <?php if($row['carrier'] == 'UPS') echo 'selected'; ?>>UPS</option>
                                                    <option <?php if($row['carrier'] == 'FedEx') echo 'selected'; ?>>FedEx</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <label for="courier" class="form-label">Courier</label>
                                                <input type="text" class="form-control" id="courier" name="courier" value="<?php echo $row['courier']; ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="mode" class="form-label">Mode</label>
                                                <select class="form-control" id="mode" name="shipmentmethod">
                                                    <option <?php if($row['shipment_mode'] == 'Select') echo 'selected'; ?>>Select</option>
                                                    <option <?php if($row['shipment_mode'] == 'Land Shipping') echo 'selected'; ?>>Land Shipping</option>
                                                    <option <?php if($row['shipment_mode'] == 'Air Shipping') echo 'selected'; ?>>Air Shipping</option>
                                                    <option <?php if($row['shipment_mode'] == 'Sea Shipping') echo 'selected'; ?>>Sea Shipping</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="origin" class="form-label">Origin</label>
                                                <input type="text" class="form-control" id="origin" name="dispatchlocation" value="<?php echo $row['dispatch_location']; ?>">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <label for="destination" class="form-label">Destination</label>
                                                <input type="text" class="form-control" id="destination" name="destination" value="<?php echo $row['destination']; ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="weight" class="form-label">Weight</label>
                                                <input type="text" class="form-control" id="weight" name="weight" value="<?php echo $row['weight']; ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="packages_count" class="form-label">Packages count</label>
                                                <input type="number" class="form-control" id="packages_count" name="quantity" value="<?php echo $row['quantity']; ?>">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-8">
                                                <label for="product_description" class="form-label">Product description</label>
                                                <input type="text" class="form-control" id="product_description" name="packagedescription" value="<?php echo $row['package_discription']; ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="total_freight" class="form-label">Total Freight</label>
                                                <input type="text" class="form-control" id="total_freight" name="total_freight" value="<?php echo $row['total_freight']; ?>">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <label for="carrier_ref_no" class="form-label">Carrier Reference No.</label>
                                                <input type="text" class="form-control" id="carrier_ref_no" name="carrierreferencenumber" value="<?php echo $row['carrier_refrence_number']; ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="departure_time" class="form-label">Departure Time</label>
                                                <input type="time" class="form-control" id="departure_time" name="departure_time" value="<?php echo $row['departure_time']; ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="pickup_date" class="form-label">Pickup Date</label>
                                                <input type="date" class="form-control" id="pickup_date" name="dipatchdate" value="<?php echo $row['dispach_date']; ?>">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <label for="pickup_time" class="form-label">Pickup Time</label>
                                                <input type="time" class="form-control" id="pickup_time" name="deliverytime" value="<?php echo $row['delivery_time']; ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="expected_delivery_date" class="form-label">Expected Delivery Date</label>
                                                <input type="date" class="form-control" id="expected_delivery_date" name="estimateddeliverydate" value="<?php echo $row['estimated_delivery_date']; ?>">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <label for="comments" class="form-label">Comments</label>
                                                <textarea class="form-control" id="comments" name="comments" rows="3"><?php echo $row['comments']; ?></textarea>
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
                                        <h5 class="card-title">Basic Info</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="tracking_number" class="form-label">Tracking Code</label>
                                                <input type="text" readonly="" value="<?php echo $row['tracking_id']; ?>" name="tracking_number" class="form-control" id="tracking_number">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="shipment_status" class="form-label">Shipment Status</label>
                                                <select class="form-control" id="shipment_status" name="status">
                                                    <option <?php if($row['status'] == 'Draft') echo 'selected'; ?>>Draft</option>
                                                    <option <?php if($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                                    <option <?php if($row['status'] == 'In Transit') echo 'selected'; ?>>In Transit</option>
                                                    <option <?php if($row['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                                                    <option <?php if($row['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <label for="remarks" class="form-label">Remarks</label>
                                                <textarea class="form-control" id="remarks" name="remarks" rows="3"><?php echo $row['remarks']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label for="datetimepicker" class="form-label">Date & Time</label>
                                                <input type="datetime-local" class="form-control" id="datetimepicker" name="datetimepicker" value="<?php echo date('Y-m-d\TH:i:s', strtotime($row['datetimepicker'])); ?>">
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
                                            <input type="text" class="form-control" id="shipper_name" name="sendername" value="<?php echo $row['sender_name']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="shipper_phone" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" id="shipper_phone" name="sendercontact" value="<?php echo $row['sender_contact']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="shipper_address" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="shipper_address" name="senderaddress" value="<?php echo $row['sender_address']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="shipper_email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="shipper_email" name="senderemail" value="<?php echo $row['sender_email']; ?>">
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
                                            <input type="text" class="form-control" id="receiver_name" name="receivername" value="<?php echo $row['receiver_name']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="receiver_phone" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" id="receiver_phone" name="receviercontact" value="<?php echo $row['receiver_contact']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="receiver_address" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="receiver_address" name="recevieraddress" value="<?php echo $row['receiver_address']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="receiver_email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="receiver_email" name="recevieremail" value="<?php echo $row['receiver_email']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" name="update" class="btn btn-primary">Update</button>
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
                                                <?php foreach ($package_items as $item) : ?>
                                                    <tr>
                                                        <td><input type="number" class="form-control" name="package_quantity[]" value="<?php echo $item['quantity']; ?>"></td>
                                                        <td><input type="text" class="form-control" name="package_piece_type[]" value="<?php echo $item['piece_type']; ?>"></td>
                                                        <td><input type="text" class="form-control" name="package_description[]" value="<?php echo $item['description']; ?>"></td>
                                                        <td><input type="number" class="form-control" name="package_length[]" value="<?php echo $item['length']; ?>"></td>
                                                        <td><input type="number" class="form-control" name="package_width[]" value="<?php echo $item['width']; ?>"></td>
                                                        <td><input type="number" class="form-control" name="package_height[]" value="<?php echo $item['height']; ?>"></td>
                                                        <td><input type="number" class="form-control" name="package_weight[]" value="<?php echo $item['weight']; ?>"></td>
                                                        <td><button type="button" class="btn btn-danger remove_row">Delete</button></td>
                                                    </tr>
                                                <?php endforeach; ?>
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
                                                <?php foreach ($shipment_history as $history) : ?>
                                                    <tr>
                                                        <td><input type="date" class="form-control" name="history_date[]" value="<?php echo $history['date']; ?>"></td>
                                                        <td><input type="time" class="form-control" name="history_time[]" value="<?php echo $history['time']; ?>"></td>
                                                        <td><input type="text" class="form-control" name="history_location[]" value="<?php echo $history['location']; ?>"></td>
                                                        <td><input type="text" class="form-control" name="history_status[]" value="<?php echo $history['status']; ?>"></td>
                                                        <td><input type="text" class="form-control" name="history_updated_by[]" value="<?php echo $history['updated_by']; ?>"></td>
                                                        <td><input type="text" class="form-control" name="history_remarks[]" value="<?php echo $history['remarks']; ?>"></td>
                                                        <td><button type="button" class="btn btn-danger remove_row">Delete</button></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-primary" id="add_history_row">Add Row</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
           </form><!-- Vertical Form -->
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

                  
                                          


            </div>
          </div>

          
     
    <!--end page wrapper -->

  