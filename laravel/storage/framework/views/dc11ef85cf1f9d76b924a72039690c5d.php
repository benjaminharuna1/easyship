<?php $__env->startSection('title', 'Add Tracking'); ?>

<?php $__env->startSection('content'); ?>

    <form method="POST" action="<?php echo e(route('admin.shipments.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Tracking Information</h5>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="tracking_id" class="form-label">Tracking ID (leave blank to auto-generate)</label>
                                <input type="text" id="tracking_id" name="tracking_id" value="<?php echo e(old('tracking_id', $trackingNumber ?? '')); ?>" class="form-control <?php $__errorArgs = ['tracking_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <input type="hidden" name="auto_tracking_id" value="<?php echo e($trackingNumber ?? ''); ?>">
                                <?php $__errorArgs = ['tracking_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                        <h5 class="card-title mb-3">Shipper Details</h5>
                        <div class="mb-3">
                            <label class="form-label">Shipper Name</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['sendername'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="sendername" value="<?php echo e(old('sendername')); ?>" required>
                            <?php $__errorArgs = ['sendername'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['sendercontact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="sendercontact" value="<?php echo e(old('sendercontact')); ?>" required>
                            <?php $__errorArgs = ['sendercontact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['senderaddress'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="senderaddress" value="<?php echo e(old('senderaddress')); ?>" required>
                            <?php $__errorArgs = ['senderaddress'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control <?php $__errorArgs = ['senderemail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="senderemail" value="<?php echo e(old('senderemail')); ?>" required>
                            <?php $__errorArgs = ['senderemail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Receiver Details</h5>
                        <div class="mb-3">
                            <label class="form-label">Receiver Name</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['receivername'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="receivername" value="<?php echo e(old('receivername')); ?>" required>
                            <?php $__errorArgs = ['receivername'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['receivercontact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="receivercontact" value="<?php echo e(old('receivercontact')); ?>" required>
                            <?php $__errorArgs = ['receivercontact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['receiveraddress'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="receiveraddress" value="<?php echo e(old('receiveraddress')); ?>" required>
                            <?php $__errorArgs = ['receiveraddress'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control <?php $__errorArgs = ['receiver_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="receiver_email" value="<?php echo e(old('receiver_email')); ?>" required>
                            <?php $__errorArgs = ['receiver_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Shipment Details</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Type of Shipment</label>
                                <select class="form-control" name="type_of_shipment" required>
                                    <option value="">Select Type</option>
                                    <option value="Air Freight" <?php echo e(old('type_of_shipment') == 'Air Freight' ? 'selected' : ''); ?>>Air Freight</option>
                                    <option value="Sea Freight" <?php echo e(old('type_of_shipment') == 'Sea Freight' ? 'selected' : ''); ?>>Sea Freight</option>
                                    <option value="Road Freight" <?php echo e(old('type_of_shipment') == 'Road Freight' ? 'selected' : ''); ?>>Road Freight</option>
                                    <option value="Express" <?php echo e(old('type_of_shipment') == 'Express' ? 'selected' : ''); ?>>Express</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Payment Mode</label>
                                <select class="form-control" name="paymentmode" required>
                                    <option value="">Select Mode</option>
                                    <option value="Cash" <?php echo e(old('paymentmode') == 'Cash' ? 'selected' : ''); ?>>Cash</option>
                                    <option value="Card" <?php echo e(old('paymentmode') == 'Card' ? 'selected' : ''); ?>>Card</option>
                                    <option value="Bank Transfer" <?php echo e(old('paymentmode') == 'Bank Transfer' ? 'selected' : ''); ?>>Bank Transfer</option>
                                    <option value="Pay on Delivery" <?php echo e(old('paymentmode') == 'Pay on Delivery' ? 'selected' : ''); ?>>Pay on Delivery</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Total Cost</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['total_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="total_cost" value="<?php echo e(old('total_cost')); ?>" required>
                                <?php $__errorArgs = ['total_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Carrier</label>
                                <select class="form-control" name="carrier" required>
                                    <option value="">Select Carrier</option>
                                    <option value="DHL" <?php echo e(old('carrier') == 'DHL' ? 'selected' : ''); ?>>DHL</option>
                                    <option value="FedEx" <?php echo e(old('carrier') == 'FedEx' ? 'selected' : ''); ?>>FedEx</option>
                                    <option value="UPS" <?php echo e(old('carrier') == 'UPS' ? 'selected' : ''); ?>>UPS</option>
                                    <option value="USPS" <?php echo e(old('carrier') == 'USPS' ? 'selected' : ''); ?>>USPS</option>
                                    <option value="Other" <?php echo e(old('carrier') == 'Other' ? 'selected' : ''); ?>>Other</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Courier</label>
                                <select class="form-control" name="courier">
                                    <option value="">Select Courier</option>
                                    <option value="Standard" <?php echo e(old('courier') == 'Standard' ? 'selected' : ''); ?>>Standard</option>
                                    <option value="Express" <?php echo e(old('courier') == 'Express' ? 'selected' : ''); ?>>Express</option>
                                    <option value="Overnight" <?php echo e(old('courier') == 'Overnight' ? 'selected' : ''); ?>>Overnight</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Mode</label>
                                <select class="form-control" name="shipmentmethod" required>
                                    <option value="">Select Mode</option>
                                    <option value="Air" <?php echo e(old('shipmentmethod') == 'Air' ? 'selected' : ''); ?>>Air</option>
                                    <option value="Sea" <?php echo e(old('shipmentmethod') == 'Sea' ? 'selected' : ''); ?>>Sea</option>
                                    <option value="Road" <?php echo e(old('shipmentmethod') == 'Road' ? 'selected' : ''); ?>>Road</option>
                                    <option value="Rail" <?php echo e(old('shipmentmethod') == 'Rail' ? 'selected' : ''); ?>>Rail</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Origin</label>
                                <input type="text" class="form-control" name="dispatchlocation" value="<?php echo e(old('dispatchlocation')); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Destination</label>
                                <input type="text" class="form-control" name="destination" value="<?php echo e(old('destination')); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Weight</label>
                                <input type="text" class="form-control" name="weight" value="<?php echo e(old('weight')); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Packages count</label>
                                <input type="number" class="form-control" name="quantity" value="<?php echo e(old('quantity')); ?>" required>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Product description</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['packagedescription'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="packagedescription" value="<?php echo e(old('packagedescription')); ?>" required>
                                <?php $__errorArgs = ['packagedescription'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Total Freight</label>
                                <input type="text" class="form-control" name="total_freight" value="<?php echo e(old('total_freight')); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Carrier Reference No.</label>
                                <input type="text" class="form-control" name="carrierreferencenumber" value="<?php echo e(old('carrierreferencenumber')); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Dispatch Date</label>
                                <input type="date" class="form-control" name="dispatch_date" value="<?php echo e(old('dispatch_date')); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Expected Delivery Date</label>
                                <input type="date" class="form-control" name="estimateddeliverydate" value="<?php echo e(old('estimateddeliverydate')); ?>" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Comments</label>
                                <textarea class="form-control" name="comments" rows="3"><?php echo e(old('comments')); ?></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Package Image</label>
                                <input type="file" class="form-control" name="image" accept="image/*" onchange="previewImage(event)">
                            </div>
                            <div class="col-md-12">
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
                        <h5 class="card-title mb-3">Package Items</h5>
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
                        <h5 class="card-title mb-3">Shipment History</h5>
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
                            <input class="form-check-input" type="checkbox" name="publish" id="publish" value="1" <?php echo e(old('publish') ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="publish">Publish this shipment</label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="send_email_notification" id="send_email_notification" value="1" <?php echo e(old('send_email_notification') ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="send_email_notification">Send shipment notification to Shipper and Receiver</label>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">Save Shipment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <datalist id="history-status-options">
        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($st); ?>"></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </datalist>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('image_preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) { preview.src = e.target.result; preview.style.display = 'block'; };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function statusSelectHtml() {
        return '<input type="text" class="form-control" name="history_status[]" list="history-status-options" placeholder="Select or type a status">';
    }

    $(function() {
        $('#add_package_row').click(function() {
            let i = $('#package_items_table tbody tr').length;
            let row = '<tr>' +
                '<td><input type="number" class="form-control" name="package_quantity[]"></td>' +
                '<td><input type="text" class="form-control" name="package_piece_type[]"></td>' +
                '<td><input type="text" class="form-control" name="package_description[]"></td>' +
                '<td><input type="number" class="form-control" step="any" name="package_length[]"></td>' +
                '<td><input type="number" class="form-control" step="any" name="package_width[]"></td>' +
                '<td><input type="number" class="form-control" step="any" name="package_height[]"></td>' +
                '<td><input type="number" class="form-control" step="any" name="package_weight[]"></td>' +
                '<td><button type="button" class="btn btn-danger btn-sm remove_row" title="Delete item"><i class="bx bx-trash"></i></button></td>' +
                '</tr>';
            $('#package_items_table tbody').append(row);
        });

        $('#add_history_row').click(function() {
            let row = '<tr>' +
                '<td><input type="date" class="form-control" name="history_date[]"></td>' +
                '<td><input type="time" class="form-control" name="history_time[]"></td>' +
                '<td><input type="text" class="form-control" name="history_location[]"></td>' +
                '<td>' + statusSelectHtml() + '</td>' +
                '<td><input type="text" class="form-control" name="history_updated_by[]"></td>' +
                '<td><input type="text" class="form-control" name="history_remarks[]"></td>' +
                '<td><button type="button" class="btn btn-danger btn-sm remove_row" title="Delete item"><i class="bx bx-trash"></i></button></td>' +
                '</tr>';
            $('#shipment_history_table tbody').append(row);
        });

        $(document).on('click', '.remove_row', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\admin\add-tracking.blade.php ENDPATH**/ ?>