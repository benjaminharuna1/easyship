<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shipment Receipt - {{ $shipment->tracking_id }}</title>
    <style>
        :root {
            --navy: #041e42;
            --accent: #f6a400;
            --red: #c40202;
            --muted: #6b7280;
            --border: #e5e7eb;
            --bg: #eef1f5;
        }

        * { box-sizing: border-box; }

        html, body { margin: 0; padding: 0; }

        body {
            background: var(--bg);
            font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #1f2937;
            line-height: 1.5;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Screen toolbar */
        .invoice-toolbar {
            position: sticky;
            top: 0;
            z-index: 20;
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--navy);
            color: #fff;
            padding: 12px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }
        .invoice-toolbar .tb-title {
            font-weight: 600;
            font-size: 15px;
            margin-right: auto;
        }
        .invoice-toolbar .tb-title small {
            display: block;
            color: #9db2d1;
            font-weight: 400;
            font-size: 12px;
        }
        .btn-print, .btn-back {
            border: 0;
            border-radius: 6px;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: inherit;
        }
        .btn-print { background: var(--accent); color: #041e42; font-weight: 600; }
        .btn-print:hover { filter: brightness(1.06); }
        .btn-back { background: rgba(255, 255, 255, 0.12); color: #fff; border: 1px solid rgba(255,255,255,0.25); }
        .btn-back:hover { background: rgba(255, 255, 255, 0.2); }

        /* Sheet */
        .sheet {
            width: 800px;
            max-width: 100%;
            margin: 24px auto;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
            position: relative;
            overflow: hidden;
        }
        .invoice-body { padding: 40px 48px 30px; position: relative; }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-24deg);
            font-size: 58px;
            font-weight: 800;
            letter-spacing: 4px;
            color: rgba(180, 180, 180, 0.18);
            white-space: nowrap;
            pointer-events: none;
            user-select: none;
            z-index: 0;
        }
        .invoice-body > * { position: relative; z-index: 1; }

        /* Header */
        .invoice-head {
            display: flex;
            justify-content: space-between;
            gap: 24px;
            border-bottom: 3px solid var(--navy);
            padding-bottom: 22px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        .brand h1 {
            font-size: 22px;
            color: var(--navy);
            margin: 0 0 4px;
        }
        .brand img { max-height: 72px; margin-bottom: 8px; display: block; }
        .brand .site-meta {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.7;
        }
        .brand .site-meta a { color: inherit; }
        .doc-title {
            text-align: right;
        }
        .doc-title .doc-name {
            display: inline-block;
            background: var(--navy);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 3px;
            margin: 0 0 10px;
        }
        .doc-title .tracking-label { font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; }
        .doc-title .tracking-no { font-size: 22px; font-weight: 800; color: var(--red); margin: 2px 0 0; }

        /* Party + summary columns */
        .parties {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }
        .party-col h3 {
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #2563eb;
            margin: 0 0 10px;
            font-weight: 700;
        }
        .party-card {
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 14px 16px;
            background: #fafbfc;
            min-height: 150px;
        }
        .party-card .party-name {
            font-size: 17px;
            font-weight: 700;
            color: #15803d;
            margin: 0 0 8px;
        }
        .party-card .detail {
            font-size: 13px;
            margin: 3px 0;
        }
        .party-card .detail .k {
            font-weight: 600;
            color: #374151;
            display: inline-block;
            min-width: 74px;
        }

        /* Middle: barcode + summary */
        .meta-row {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 24px;
            margin-bottom: 26px;
        }
        .barcode-box {
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 18px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .barcode-box img { max-width: 210px; height: auto; display: block; margin-bottom: 10px; }
        .barcode-box .bc-number {
            font-family: "Courier New", monospace;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--navy);
        }
        .summary-box {
            border: 1px solid var(--border);
            border-radius: 6px;
            overflow: hidden;
        }
        .summary-box .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 9px 16px;
            font-size: 13px;
            border-bottom: 1px dashed #eef0f3;
        }
        .summary-box .summary-row:last-child { border-bottom: 0; }
        .summary-box .summary-row:nth-child(odd) { background: #fafbfc; }
        .summary-box .k { color: #6b7280; font-weight: 600; }
        .summary-box .v { font-weight: 600; color: #1f2937; text-align: right; }
        .summary-box .v.amount { color: var(--red); }
        .pay-badge {
            display: inline-block;
            background: #fee2e2;
            color: var(--red);
            font-size: 12px;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 999px;
        }

        /* Items table */
        .items h3 {
            font-size: 16px;
            color: #2563eb;
            margin: 0 0 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e5e7eb;
        }
        table.items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .items-table th {
            background: #041e42;
            color: #fff;
            text-align: left;
            padding: 10px 12px;
            font-size: 12px;
            letter-spacing: 0.4px;
        }
        .items-table th:first-child { border-radius: 4px 0 0 4px; }
        .items-table th:last-child { border-radius: 0 4px 4px 0; }
        .items-table td {
            padding: 9px 12px;
            border-bottom: 1px solid #eef0f3;
        }
        .items-table tbody tr:nth-child(even) { background: #f9fafb; }
        .items-table td.sn { color: var(--muted); width: 46px; }
        .items-table .empty-row td { text-align: center; color: var(--muted); padding: 20px; }

        /* Footer */
        .invoice-foot {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-top: 26px;
        }
        .foot-box h4 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #374151;
            margin: 0 0 8px;
        }
        .foot-box img { max-width: 260px; max-height: 84px; display: block; }
        .foot-box .stamp-date { font-size: 13px; color: var(--muted); margin-top: 6px; }
        .stamp-img { height: 92px; width: auto; }

        @media (max-width: 720px) {
            .invoice-body { padding: 24px 20px; }
            .parties, .meta-row, .invoice-foot { grid-template-columns: 1fr; }
            .doc-title { text-align: left; }
        }

        @media print {
            @page { size: A4; margin: 12mm; }
            body { background: #fff; }
            .invoice-toolbar, .no-print { display: none !important; }
            .sheet { width: 100%; margin: 0; border-radius: 0; box-shadow: none; }
            .invoice-body { padding: 0; }
            .watermark { color: rgba(180, 180, 180, 0.16); }
            a { color: inherit; text-decoration: none; }
        }
    </style>
</head>
<body>

    <div class="invoice-toolbar no-print">
        <span class="tb-title">
            Shipment Receipt
            <small>{{ $shipment->tracking_id }}</small>
        </span>
        <button type="button" class="btn-print" onclick="window.print()">&#128438; Print / Save PDF</button>
    </div>

    <div class="sheet">
        <div class="watermark">Certified True Copy</div>

        <div class="invoice-body">

            <!-- Header / branding -->
            <div class="invoice-head">
                <div class="brand">
                    @if(!empty($settings->site_logo))
                        <img src="{{ asset($settings->site_logo) }}" alt="{{ $settings->sitename }}" title="{{ $settings->sitename }}">
                    @endif
                    <h1>{{ $settings->sitename ?? '' }}</h1>
                    <div class="site-meta">
                        @if(!empty($settings->site_address))
                            {!! nl2br(e($settings->site_address)) !!}<br>
                        @endif
                        @if(!empty($settings->email_address))
                            {{ $settings->email_address }}<br>
                        @endif
                        @if(!empty($settings->site_url))
                            <a href="{{ $settings->site_url }}">{{ $settings->site_url }}</a>
                        @endif
                    </div>
                </div>
                <div class="doc-title">
                    <p class="doc-name">Shipment Receipt / Invoice</p>
                    <div class="tracking-label">Tracking Number</div>
                    <div class="tracking-no">{{ $shipment->tracking_id }}</div>
                </div>
            </div>

            <!-- From / To -->
            <div class="parties">
                <div class="party-col">
                    <h3>From (Sender)</h3>
                    <div class="party-card">
                        <p class="party-name">{{ $shipment->sender_name }}</p>
                        <div class="detail"><span class="k">Address:</span> {{ $shipment->sender_address }}</div>
                        <div class="detail"><span class="k">Phone No:</span> {{ $shipment->sender_contact }}</div>
                        <div class="detail"><span class="k">Origin:</span> {{ $shipment->dispatch_location }}</div>
                    </div>
                </div>
                <div class="party-col">
                    <h3>To (Consignee)</h3>
                    <div class="party-card">
                        <p class="party-name">{{ $shipment->receiver_name }}</p>
                        <div class="detail"><span class="k">Address:</span> {{ $shipment->receiver_address }}</div>
                        <div class="detail"><span class="k">Phone No:</span> {{ $shipment->receiver_contact }}</div>
                        <div class="detail"><span class="k">Destination:</span> {{ $shipment->destination }}</div>
                    </div>
                </div>
            </div>

            <!-- Barcode + summary -->
            <div class="meta-row">
                <div class="barcode-box">
                    <img src="{{ asset('track-image/barcode810e.png') }}" alt="Barcode">
                    <span class="bc-number">{{ $shipment->tracking_id }}</span>
                </div>
                <div class="summary-box">
                    <div class="summary-row"><span class="k">Order ID</span><span class="v">{{ $shipment->tracking_id }}</span></div>
                    <div class="summary-row"><span class="k">Est. Delivery Date</span><span class="v">{{ $shipment->estimated_delivery_date }}</span></div>
                    <div class="summary-row"><span class="k">Dispatch Date</span><span class="v">{{ $shipment->dispatch_date }}</span></div>
                    <div class="summary-row"><span class="k">Payment Mode</span><span class="v"><span class="pay-badge">{{ $shipment->payment_mode }}</span></span></div>
                    <div class="summary-row"><span class="k">Total Amount Paid</span><span class="v amount">{{ $settings->site_currency ?? '$' }}{{ number_format($shipment->total_cost, 2) }}</span></div>
                    <div class="summary-row"><span class="k">Mode of Transport</span><span class="v">{{ $shipment->shipment_mode }}</span></div>
                </div>
            </div>

            <!-- Package items -->
            <div class="items">
                <h3>Package Items</h3>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Quantity</th>
                            <th>Piece Type</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sn = 1; $items = $shipment->packageItems ?? collect(); @endphp
                        @forelse($items as $item)
                            <tr>
                                <td class="sn">{{ $sn++ }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->piece_type }}</td>
                                <td>{{ $item->description }}</td>
                            </tr>
                        @empty
                            <tr class="empty-row"><td colspan="4">No package items listed for this shipment.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="invoice-foot">
                <div class="foot-box">
                    <h4>Payment Methods</h4>
                    @if(!empty($settings->payment_methods_image))
                        <img src="{{ asset($settings->payment_methods_image) }}" alt="Accepted payment methods">
                    @else
                        <span style="color:var(--muted); font-size:13px;">N/A</span>
                    @endif
                </div>
                <div class="foot-box" style="text-align:right;">
                    <h4>Official Stamp / {{ $creationDate }}</h4>
                    @if(!empty($settings->invoice_stamp))
                        <img class="stamp-img" src="{{ asset($settings->invoice_stamp) }}" alt="Official stamp">
                    @else
                        <span style="color:var(--muted); font-size:13px;">N/A</span>
                    @endif
                </div>
            </div>

        </div>
    </div>

</body>
</html>
