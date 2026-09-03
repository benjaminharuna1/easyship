<?php $__env->startSection('title', 'View Details'); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
            <div>
                <h1 class="card-title mb-1">TRACKING NUMBER</h1>
                <h1 class="text-primary mb-0"><?php echo e($shipment->tracking_id); ?></h1>
            </div>
            <div class="text-end">
                <?php if($shipment->published): ?>
                    <span class="badge bg-success">Published</span>
                <?php else: ?>
                    <span class="badge bg-secondary">Not Published</span>
                <?php endif; ?>
                <?php if($shipment->status): ?>
                    <span class="badge bg-primary"><?php echo e($shipment->status); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-4">
            <?php if($shipment->image): ?>
                <div class="card">
                    <div class="card-body text-center">
                        <img src="<?php echo e(asset('uploads/' . $shipment->image)); ?>" alt="Package" class="img-fluid rounded">
                    </div>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Actions</h5>
                    <a class="btn btn-primary btn-sm w-100 mb-2" href="<?php echo e(route('admin.shipments.edit', $shipment->tracking_id)); ?>">
                        <i class="bx bx-edit"></i> Edit Shipment
                    </a>
                    <a class="btn btn-info btn-sm w-100" target="_blank"
                       href="<?php echo e(route('track.print', ['num' => $shipment->tracking_id])); ?>">
                        <i class="bx bx-printer"></i> Print Invoice
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-primary">SENDER INFO</h5>
                            <div class="mb-3">
                                <label class="form-label">Sender's Name</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->sender_name); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sender's Contact</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->sender_contact); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sender's Email</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->sender_email); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sender's Address</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->sender_address); ?>" readonly>
                            </div>

                            <h3 class="mt-4">Other info</h3>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->status); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Dispatch Location</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->dispatch_location); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Origin</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->origin ?: 'N/A'); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Carrier</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->carrier); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Courier</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->courier ?: 'N/A'); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Carrier Reference Number</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->carrier_refrence_number); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Weight</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->weight); ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-primary">RECEIVER INFO</h5>
                            <div class="mb-3">
                                <label class="form-label">Receiver Name</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->receiver_name); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Receiver Email</label>
                                <input type="email" class="form-control" value="<?php echo e($shipment->receiver_email); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Receiver Contact</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->receiver_contact); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Receiver Address</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->receiver_address); ?>" readonly>
                            </div>

                            <h3 class="mt-4">Other info</h3>
                            <div class="mb-3">
                                <label class="form-label">Destination</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->destination); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Package Description</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->package_discription); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Type of Shipment</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->type_of_shipment ?: 'N/A'); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Dispatch Date</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->dispatch_date); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Estimated Delivery Date</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->estimated_delivery_date); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Shipment Method</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->shipment_mode); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->quantity); ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">BILLING &amp; FINANCIAL INFO</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Payment Mode</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->payment_mode); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Volumetric Weight (kg)</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->total_volumetric_weight ?? 'N/A'); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Actual Weight (kg)</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->total_actual_weight ?? 'N/A'); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Total Freight</label>
                                <input type="text" class="form-control"
                                       value="<?php echo e($shipment->total_freight !== null ? ($settings->site_currency ?? '$') . number_format((float)$shipment->total_freight, 2) : 'N/A'); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Total Cost</label>
                                <input type="text" class="form-control"
                                       value="<?php echo e(($settings->site_currency ?? '$') . number_format((float)$shipment->total_cost, 2)); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date Added</label>
                                <input type="text" class="form-control" value="<?php echo e($shipment->date_added ?: 'N/A'); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <?php if($shipment->comments): ?>
                        <div class="mb-3">
                            <label class="form-label">Comments / Remarks</label>
                            <textarea class="form-control" rows="3" readonly><?php echo e($shipment->comments); ?></textarea>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Package Items</h5>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Quantity</th>
                            <th>Piece Type</th>
                            <th>Description</th>
                            <th>Length</th>
                            <th>Width</th>
                            <th>Height</th>
                            <th>Weight</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $shipment->packageItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($item->quantity); ?></td>
                                <td><?php echo e($item->piece_type); ?></td>
                                <td><?php echo e($item->description); ?></td>
                                <td><?php echo e($item->length); ?></td>
                                <td><?php echo e($item->width); ?></td>
                                <td><?php echo e($item->height); ?></td>
                                <td><?php echo e($item->weight); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="8" class="text-center text-muted">No package items.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Shipment History</h5>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Updated By</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $shipment->shipmentHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($h->date); ?></td>
                                <td><?php echo e($h->time); ?></td>
                                <td><?php echo e($h->location); ?></td>
                                <td><span class="badge bg-primary"><?php echo e($h->status); ?></span></td>
                                <td><?php echo e($h->updated_by); ?></td>
                                <td><?php echo e($h->remarks); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="text-center text-muted">No shipment history.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\easyship\laravel\resources\views\admin\view-details.blade.php ENDPATH**/ ?>