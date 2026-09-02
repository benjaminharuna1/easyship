<!DOCTYPE html>
<html lang="en">
<head>
    <title>Print Invoice</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link href="{{ asset('track-printcss/bootstrap2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('track-printcss/print-invoice.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        #background { position: absolute; z-index: 0; display: block; min-height: 70%; min-width: 70%; }
        #content { position: absolute; z-index: 1; }
        #bg-text { color: grey; font-size: 36px; transform: rotate(300deg); -webkit-transform: rotate(300deg); }
    </style>
</head>
<body style="background-color:teal;" onload="window.print();">

    <div class="wrapper" id="background">
        <p id="bg-text">Certified True Copy</p>

        <section class="invoice">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <span>
                            <img src="{{ asset($settings->site_logo) }}" alt="Site logo"
                                title="{{ $settings->sitename }}" width="190" height="85" border="0">
                            <img class="pull-right" src="{{ asset($settings->invoice_banner) }}" alt="" height="185">

                            <div class="site-details" style="text-align: left; margin-top: 10px; color: black; font-size: 12px;">
                                <strong>{{ $settings->sitename }}</strong><br>
                                {!! nl2br(e($settings->site_address)) !!}<br>
                                {{ $settings->email_address }}<br>
                                <a href="{{ $settings->site_url }}">{{ $settings->site_url }}</a>
                            </div>

                            <h3 style="color:red;"><strong>Tracking Number: {{ $shipment->tracking_id }}</strong></h3>
                        </span>
                    </h2>
                </div>
            </div>

            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <strong style="color:blue;">FROM (SENDER)</strong>
                    <address>
                        <h3><strong style="color:green;">{{ $shipment->sender_name }}</strong></h3><br>
                        <b>Address:</b>&nbsp;&nbsp;{{ $shipment->sender_address }}<br/>
                        <b>Phone No:</b>&nbsp;&nbsp;{{ $shipment->sender_contact }}<br/>
                        <b>Origin </b>&nbsp;&nbsp;{{ $shipment->dispatch_location }}
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    <strong style="color:blue;">TO (CONSIGNEE)</strong>
                    <address>
                        <h3><strong style="color:green;">&nbsp;&nbsp;{{ $shipment->receiver_name }}</strong></h3><br>
                        <b>Address:</b>&nbsp;&nbsp;{{ $shipment->receiver_address }}<br/>
                        <b>Phone:</b>&nbsp;&nbsp;{{ $shipment->receiver_contact }}<br/>
                        <b>Destination</b>&nbsp;&nbsp;{{ $shipment->destination }}
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    <table>
                        <tr>
                            <td>
                                <center>
                                    <img src="{{ asset('track-image/barcode810e.png') }}" alt="barcode" /><br>
                                    <strong>{{ $shipment->tracking_id }}</strong><br>
                                </center>
                            </td>
                        </tr>
                    </table>
                    <br/>
                    <b>Order ID:</b>&nbsp;&nbsp;{{ $shipment->tracking_id }}<br/>
                    <b>Est. Delivery Date:</b>&nbsp;{{ $shipment->estimated_delivery_date }}<br/>
                    <b>Payment Mode:</b> <small class="label label-danger"><i class="fa fa-money"></i>&nbsp;&nbsp;{{ $shipment->payment_mode }}</small><br/>
                    <b>Total Amount Paid:</b>&nbsp;{{ $settings->site_currency ?? '$' }}{{ number_format($shipment->total_cost, 2) }}<br/>
                    <b>Mode of Transport:</b>&nbsp;{{ $shipment->shipment_mode }}<br/>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <h3 style="color:blue;"><strong>Package Items</strong></h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Quantity</th>
                                <th>Piece Type</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $sn = 1; @endphp
                            @foreach($shipment->packageItems as $item)
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->piece_type }}</td>
                                <td>{{ $item->description }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <br><br>
            <div class="row">
                <div class="col-xs-6">
                    <p class="lead"><strong>Payment Methods:</strong></p>
                    <img src="{{ asset($settings->payment_methods_image) }}" alt="Methods payments" />
                </div>
                <div class="col-xs-6">
                    <p class="lead"><strong>Official Stamp/ {{ $creationDate }} </strong></p>
                    <img src="{{ asset($settings->invoice_stamp) }}" alt="" height="100" />
                </div>
            </div>
        </section>
    </div>

</body>
</html>
