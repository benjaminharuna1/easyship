@extends('layouts.admin')

@section('title', 'View Details')

@section('content')

    <div class="card">
        <div class="card-body">
            <h1 class="card-title">TRACKING NUMBER</h1>
            <h1 class="text-primary">{{ $shipment->tracking_id }}</h1>
            @if($shipment->image)
                <img src="{{ asset('uploads/' . $shipment->image) }}" alt="" width="200" class="rounded mt-2">
            @endif
            <div class="mt-3">
                <a class="btn btn-primary btn-sm" href="{{ route('admin.shipments.edit', $shipment->tracking_id) }}">Edit Shipment</a>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sender info</h5>
                    <div class="col-12 mb-3">
                        <label class="form-label">Senders Name</label>
                        <input type="text" class="form-control" value="{{ $shipment->sender_name }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Senders Contact</label>
                        <input type="text" class="form-control" value="{{ $shipment->sender_contact }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Senders Email</label>
                        <input type="text" class="form-control" value="{{ $shipment->sender_email }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Senders Address</label>
                        <input type="text" class="form-control" value="{{ $shipment->sender_address }}" readonly>
                    </div>

                    <h3>Other info</h3>
                    <div class="col-12 mb-3">
                        <label class="form-label">Status</label>
                        <input type="text" class="form-control" value="{{ $shipment->status }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Dispatch Location</label>
                        <input type="text" class="form-control" value="{{ $shipment->dispatch_location }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Carrier</label>
                        <input type="text" class="form-control" value="{{ $shipment->carrier }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Carrier reference number</label>
                        <input type="text" class="form-control" value="{{ $shipment->carrier_refrence_number }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Weight</label>
                        <input type="text" class="form-control" value="{{ $shipment->weight }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Volumetric Weight (kg)</label>
                        <input type="text" class="form-control" value="{{ $shipment->total_volumetric_weight ?? 'N/A' }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Actual Weight (kg)</label>
                        <input type="text" class="form-control" value="{{ $shipment->total_actual_weight ?? 'N/A' }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Total Freight</label>
                        <input type="text" class="form-control" value="{{ $shipment->total_freight !== null ? ($settings->site_currency ?? '$') . number_format((float)$shipment->total_freight, 2) : 'N/A' }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Payment Mode</label>
                        <input type="text" class="form-control" value="{{ $shipment->payment_mode }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Total Cost</label>
                        <input type="text" class="form-control" value="{{ $settings->site_currency ?? '$' }}{{ number_format((float)$shipment->total_cost, 2) }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Receiver info</h5>
                    <div class="col-12 mb-3">
                        <label class="form-label">Receiver Name</label>
                        <input type="text" class="form-control" value="{{ $shipment->receiver_name }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Receiver Email</label>
                        <input type="email" class="form-control" value="{{ $shipment->receiver_email }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Receiver contact</label>
                        <input type="text" class="form-control" value="{{ $shipment->receiver_contact }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Receiver Address</label>
                        <input type="text" class="form-control" value="{{ $shipment->receiver_address }}" readonly>
                    </div>

                    <h3>Other info</h3>
                    <div class="col-12 mb-3">
                        <label class="form-label">Destination</label>
                        <input type="text" class="form-control" value="{{ $shipment->destination }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Package description</label>
                        <input type="text" class="form-control" value="{{ $shipment->package_discription }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Dispatch Date</label>
                        <input type="text" class="form-control" value="{{ $shipment->dispatch_date }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Estimated Delivery Date</label>
                        <input type="text" class="form-control" value="{{ $shipment->estimated_delivery_date }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Shipment method</label>
                        <input type="text" class="form-control" value="{{ $shipment->shipment_mode }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="text" class="form-control" value="{{ $shipment->quantity }}" readonly>
                    </div>
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
                        @forelse($shipment->packageItems as $item)
                            <tr>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->piece_type }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->length }}</td>
                                <td>{{ $item->width }}</td>
                                <td>{{ $item->height }}</td>
                                <td>{{ $item->weight }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">No package items.</td></tr>
                        @endforelse
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
                        @forelse($shipment->shipmentHistory as $h)
                            <tr>
                                <td>{{ $h->date }}</td>
                                <td>{{ $h->time }}</td>
                                <td>{{ $h->location }}</td>
                                <td><span class="badge bg-primary">{{ $h->status }}</span></td>
                                <td>{{ $h->updated_by }}</td>
                                <td>{{ $h->remarks }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted">No shipment history.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
