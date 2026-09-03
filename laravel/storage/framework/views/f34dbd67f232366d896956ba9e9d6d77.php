<?php $__env->startSection('title', 'Edit Shipment'); ?>

<?php $__env->startSection('content'); ?>

    <form method="POST" action="<?php echo e(route('admin.shipments.update', $shipment->tracking_id)); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Edit Shipment</h5>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-light btn-sm notify-toggle-btn" data-bs-toggle="modal" data-bs-target="#notifyModal">
                                <i class="bx bx-mail-send me-1"></i>Notify User of Update
                            </button>
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
unset($__errorArgs, $__bag); ?>" name="sendername" value="<?php echo e(old('sendername', $shipment->sender_name)); ?>" required>
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
unset($__errorArgs, $__bag); ?>" name="sendercontact" value="<?php echo e(old('sendercontact', $shipment->sender_contact)); ?>" required>
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
unset($__errorArgs, $__bag); ?>" name="senderaddress" value="<?php echo e(old('senderaddress', $shipment->sender_address)); ?>" required>
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
unset($__errorArgs, $__bag); ?>" name="senderemail" value="<?php echo e(old('senderemail', $shipment->sender_email)); ?>" required>
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
unset($__errorArgs, $__bag); ?>" name="receivername" value="<?php echo e(old('receivername', $shipment->receiver_name)); ?>" required>
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
unset($__errorArgs, $__bag); ?>" name="receivercontact" value="<?php echo e(old('receivercontact', $shipment->receiver_contact)); ?>" required>
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
unset($__errorArgs, $__bag); ?>" name="receiveraddress" value="<?php echo e(old('receiveraddress', $shipment->receiver_address)); ?>" required>
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
unset($__errorArgs, $__bag); ?>" name="receiver_email" value="<?php echo e(old('receiver_email', $shipment->receiver_email)); ?>" required>
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
                                <select class="form-control" name="type_of_shipment">
                                    <option value="">Select</option>
                                    <option value="Express" <?php echo e(old('type_of_shipment', $shipment->type_of_shipment) == 'Express' ? 'selected' : ''); ?>>Express</option>
                                    <option value="Standard" <?php echo e(old('type_of_shipment', $shipment->type_of_shipment) == 'Standard' ? 'selected' : ''); ?>>Standard</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($s); ?>" <?php echo e(old('status', $shipment->status) == $s ? 'selected' : ''); ?>><?php echo e($s); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Payment Mode</label>
                                <select class="form-control" name="paymentmode" required>
                                    <option value="">Select</option>
                                    <option value="Cash" <?php echo e(old('paymentmode', $shipment->payment_mode) == 'Cash' ? 'selected' : ''); ?>>Cash</option>
                                    <option value="Card" <?php echo e(old('paymentmode', $shipment->payment_mode) == 'Card' ? 'selected' : ''); ?>>Card</option>
                                    <option value="Transfer" <?php echo e(old('paymentmode', $shipment->payment_mode) == 'Transfer' ? 'selected' : ''); ?>>Transfer</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Total Cost</label>
                                <input type="number" step="any" class="form-control" name="total_cost" value="<?php echo e(old('total_cost', $shipment->total_cost)); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Carrier</label>
                                <select class="form-control" name="carrier" required>
                                    <option value="">Select</option>
                                    <option value="DHL" <?php echo e(old('carrier', $shipment->carrier) == 'DHL' ? 'selected' : ''); ?>>DHL</option>
                                    <option value="UPS" <?php echo e(old('carrier', $shipment->carrier) == 'UPS' ? 'selected' : ''); ?>>UPS</option>
                                    <option value="FedEx" <?php echo e(old('carrier', $shipment->carrier) == 'FedEx' ? 'selected' : ''); ?>>FedEx</option>
                                    <option value="<?php echo e($settings->sitename); ?>" <?php echo e(old('carrier', $shipment->carrier) == $settings->sitename ? 'selected' : ''); ?>><?php echo e($settings->sitename); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Courier</label>
                                <select class="form-control" name="courier">
                                    <option value="">Select</option>
                                    <option value="DHL" <?php echo e(old('courier', $shipment->courier) == 'DHL' ? 'selected' : ''); ?>>DHL</option>
                                    <option value="UPS" <?php echo e(old('courier', $shipment->courier) == 'UPS' ? 'selected' : ''); ?>>UPS</option>
                                    <option value="FedEx" <?php echo e(old('courier', $shipment->courier) == 'FedEx' ? 'selected' : ''); ?>>FedEx</option>
                                    <option value="<?php echo e($settings->sitename); ?>" <?php echo e(old('courier', $shipment->courier) == $settings->sitename ? 'selected' : ''); ?>><?php echo e($settings->sitename); ?></option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Mode</label>
                                <select class="form-control" name="shipmentmethod" required>
                                    <option value="">Select</option>
                                    <option value="Land Shipping" <?php echo e(old('shipmentmethod', $shipment->shipment_mode) == 'Land Shipping' ? 'selected' : ''); ?>>Land Shipping</option>
                                    <option value="Air Shipping" <?php echo e(old('shipmentmethod', $shipment->shipment_mode) == 'Air Shipping' ? 'selected' : ''); ?>>Air Shipping</option>
                                    <option value="Sea Shipping" <?php echo e(old('shipmentmethod', $shipment->shipment_mode) == 'Sea Shipping' ? 'selected' : ''); ?>>Sea Shipping</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Origin</label>
                                <input type="text" class="form-control" name="dispatchlocation" value="<?php echo e(old('dispatchlocation', $shipment->dispatch_location)); ?>" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Destination</label>
                                <input type="text" class="form-control" name="destination" value="<?php echo e(old('destination', $shipment->destination)); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Weight</label>
                                <input type="text" class="form-control" name="weight" value="<?php echo e(old('weight', $shipment->weight)); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Packages count</label>
                                <input type="number" class="form-control" name="quantity" value="<?php echo e(old('quantity', $shipment->quantity)); ?>" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Product description</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['packagedescription'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="packagedescription" value="<?php echo e(old('packagedescription', $shipment->package_discription)); ?>" required>
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
                                <input type="number" step="any" class="form-control" name="total_freight" value="<?php echo e(old('total_freight', $shipment->total_freight)); ?>" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Dispatch Date</label>
                                <input type="date" class="form-control" name="dispatch_date" value="<?php echo e(old('dispatch_date', $shipment->dispatch_date)); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Expected Delivery Date</label>
                                <input type="date" class="form-control" name="estimateddeliverydate" value="<?php echo e(old('estimateddeliverydate', $shipment->estimated_delivery_date)); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Carrier Reference No.</label>
                                <input type="text" class="form-control" name="carrierreferencenumber" value="<?php echo e(old('carrierreferencenumber', $shipment->carrier_refrence_number)); ?>" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Comments</label>
                                <textarea class="form-control" name="comments" rows="3"><?php echo e(old('comments', $shipment->comments)); ?></textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Package Image</label>
                                <input type="file" class="form-control" name="image" accept="image/*" onchange="previewImage(event)">
                                <input type="hidden" name="current_image" value="<?php echo e($shipment->image); ?>">
                                <input type="hidden" name="remove_image" id="remove_image" value="0">
                                <?php if($shipment->image): ?>
                                    <div class="mt-2">
                                        <img src="<?php echo e(asset('uploads/' . $shipment->image)); ?>" style="max-width:200px; max-height:200px;" class="rounded">
                                    </div>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeCurrentImage()">Remove Image</button>
                                    </div>
                                <?php endif; ?>
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
                        <div class="mb-3">
                            <input type="hidden" id="clear_package_items" name="clear_package_items" value="0">
                            <button type="button" id="clear_package_items_btn" class="btn btn-outline-danger btn-sm" onclick="toggleReplaceItems()">
                                <i class="bx bx-refresh"></i> Replace existing package items on save
                            </button>
                            <small class="text-muted d-block mt-1">Click to replace the current items with the rows below when saving.</small>
                        </div>
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
                                <?php $__currentLoopData = $shipment->packageItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><input type="number" class="form-control" name="package_quantity[]" value="<?php echo e($item->quantity); ?>"></td>
                                    <td><input type="text" class="form-control" name="package_piece_type[]" value="<?php echo e($item->piece_type); ?>"></td>
                                    <td><input type="text" class="form-control" name="package_description[]" value="<?php echo e($item->description); ?>"></td>
                                    <td><input type="number" class="form-control" step="any" name="package_length[]" value="<?php echo e($item->length); ?>"></td>
                                    <td><input type="number" class="form-control" step="any" name="package_width[]" value="<?php echo e($item->width); ?>"></td>
                                    <td><input type="number" class="form-control" step="any" name="package_height[]" value="<?php echo e($item->height); ?>"></td>
                                    <td><input type="number" class="form-control" step="any" name="package_weight[]" value="<?php echo e($item->weight); ?>"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove_row" title="Delete item"><i class="bx bx-trash"></i></button></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <h5 class="card-title mb-3">Shipment History (add new updates)</h5>
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
                                <?php $__empty_1 = true; $__currentLoopData = $shipment->shipmentHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><input type="date" class="form-control" name="history_date[]" value="<?php echo e($h->date); ?>"></td>
                                    <td><input type="time" class="form-control" name="history_time[]" value="<?php echo e($h->time); ?>"></td>
                                    <td><input type="text" class="form-control" name="history_location[]" value="<?php echo e($h->location); ?>"></td>
                                    <td>
                                        <input type="text" class="form-control" name="history_status[]" list="history-status-options" value="<?php echo e($h->status); ?>" placeholder="Select or type a status">
                                    </td>
                                    <td><input type="text" class="form-control" name="history_updated_by[]" value="<?php echo e($h->updated_by); ?>"></td>
                                    <td><input type="text" class="form-control" name="history_remarks[]" value="<?php echo e($h->remarks); ?>"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove_row" title="Delete item"><i class="bx bx-trash"></i></button></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
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
                    <div class="card-body d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Update Shipment</button>
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

    <!-- Notify User of Update modal -->
    <div class="modal fade" id="notifyModal" tabindex="-1" aria-labelledby="notifyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="notify-form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notifyModalLabel">Notify User of Update</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Send To</label>
                            <select name="recipient" class="form-control">
                                <option value="receiver">Receiver</option>
                                <option value="shipper">Shipper</option>
                                <option value="both">Both Receiver and Shipper</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Available Tags</label>
                            <div class="d-flex flex-wrap gap-2 notify-tags-list">
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-insert-tag="{name}"><code>{name}</code></button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-insert-tag="{tracking_id}"><code>{tracking_id}</code></button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-insert-tag="{status}"><code>{status}</code></button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-insert-tag="{link}"><code>{link}</code></button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-insert-tag="{site_name}"><code>{site_name}</code></button>
                            </div>
                            <small class="text-muted d-block mt-1">Click a tag to insert it at the cursor. Tags are replaced with the shipment's details when sent. <code>{link}</code> becomes the tracking link to /track/<?php echo e($shipment->tracking_id); ?>.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea id="notify-body" name="body" rows="8"><?php echo $defaultNotifyBody; ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span id="notify-result" class="me-auto"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="notify-send-btn" class="btn btn-primary"><i class="bx bx-send me-1"></i>Send Update Notification</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* White "Notify User of Update" button (invisible as blue-on-blue before) */
    .notify-toggle-btn,
    .notify-toggle-btn:hover,
    .notify-toggle-btn:focus,
    .notify-toggle-btn:active {
        color: #ffffff !important;
        border-color: #ffffff !important;
        background-color: transparent !important;
    }
    .notify-toggle-btn i {
        color: #ffffff !important;
    }

    /* Make the notify modal light so its content is readable */
    #notifyModal .modal-content {
        background-color: #ffffff;
        color: #212529;
        border: 1px solid #dee2e6;
    }
    #notifyModal .modal-header,
    #notifyModal .modal-footer {
        border-color: #dee2e6;
    }
    #notifyModal .modal-title {
        color: #212529;
    }
    #notifyModal .form-label,
    #notifyModal .form-check-label {
        color: #212529;
    }
    #notifyModal .text-muted {
        color: #6c757d !important;
    }
    #notifyModal .form-control,
    #notifyModal .form-select {
        color: #212529;
        background-color: #ffffff;
        border-color: #ced4da;
    }
    #notifyModal .form-control:focus,
    #notifyModal .form-select:focus {
        color: #212529;
        background-color: #ffffff;
        border-color: #86b7fe;
        box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
    }
    #notifyModal .btn-close {
        filter: none;
    }
    #notifyModal .notify-tags-list .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
        background-color: #ffffff;
    }
    #notifyModal .notify-tags-list .btn-outline-secondary:hover {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }
    #notifyModal .notify-tags-list code {
        color: inherit;
    }
    #notifyModal .note-editor.note-frame {
        border-color: #ced4da;
    }
    #notifyModal .note-editor .note-toolbar {
        background-color: #f5f5f5;
        border-color: #ced4da;
    }
    #notifyModal .note-editor .note-toolbar .note-btn {
        color: #212529 !important;
        background-color: #ffffff !important;
        border-color: #ced4da;
    }
    #notifyModal .note-editor .note-toolbar .note-btn:hover {
        background-color: #e9ecef !important;
    }
    #notifyModal .note-editor.note-frame .note-editing-area .note-editable {
        background-color: #ffffff;
        color: #212529;
    }
    #notifyModal .note-placeholder {
        color: #6c757d;
    }
</style>
<?php $__env->stopPush(); ?>

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

    const statusOptions = <?php echo json_encode($statuses, 15, 512) ?>;

    function statusSelectHtml(selected) {
        return '<input type="text" class="form-control" name="history_status[]" list="history-status-options" value="' + (selected || '') + '" placeholder="Select or type a status">';
    }

    $(function() {
        window.toggleReplaceItems = function() {
            var input = document.getElementById('clear_package_items');
            var btn = document.getElementById('clear_package_items_btn');
            var on = input.value === '1';
            input.value = on ? '0' : '1';
            if (!on) {
                btn.classList.remove('btn-outline-danger');
                btn.classList.add('btn-danger');
            } else {
                btn.classList.remove('btn-danger');
                btn.classList.add('btn-outline-danger');
            }
        };

        $('#add_package_row').click(function() {
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
                '<td>' + statusSelectHtml('Pending') + '</td>' +
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

    $(function() {
        var notifyModalEl = document.getElementById('notifyModal');
        if (notifyModalEl) {
            var notifyBody = $('#notify-body');
            var notifyForm = document.getElementById('notify-form');
            var notifyResult = document.getElementById('notify-result');

            function sendNotify() {
                var csrf = document.querySelector('meta[name="csrf-token"]').content;
                var btn = document.getElementById('notify-send-btn');
                notifyResult.textContent = '';
                notifyResult.style.color = '';
                btn.disabled = true;
                var original = btn.innerHTML;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Sending...';

                var fd = new FormData();
                fd.append('body', notifyBody.summernote('code'));
                fd.append('recipient', notifyForm.recipient.value);

                fetch('<?php echo e(route('admin.shipments.notify', $shipment->tracking_id)); ?>', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: fd
                }).then(function(res) {
                    return res.json().catch(function() {
                        return { status: res.ok ? 'success' : 'error', message: res.ok ? 'Notification sent.' : 'Failed to send the notification.' };
                    });
                }).then(function(data) {
                    notifyResult.textContent = data.message;
                    notifyResult.style.color = data.status === 'success' ? 'green' : 'red';
                }).catch(function() {
                    notifyResult.textContent = 'Failed to send the notification. Please try again.';
                    notifyResult.style.color = 'red';
                }).finally(function() {
                    btn.disabled = false;
                    btn.innerHTML = original;
                });
            }

            $(notifyModalEl).on('shown.bs.modal', function() {
                notifyBody.summernote({ height: 300 });
            }).on('hidden.bs.modal', function() {
                notifyBody.summernote('destroy');
            });

            $('.notify-tags-list [data-insert-tag]').on('click', function() {
                notifyBody.summernote('insertText', $(this).data('insert-tag'));
            });

            $('#notify-form').on('submit', function(e) {
                e.preventDefault();
                sendNotify();
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\admin\edit.blade.php ENDPATH**/ ?>