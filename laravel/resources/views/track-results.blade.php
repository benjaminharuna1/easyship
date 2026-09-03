@extends('layouts.subpage')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { width: 100%; height: 350px; border-radius: 8px; }
        .track-results { padding: 60px 0; }
        .track-results h1 {
            font-size: 24px; font-weight: 700; color: #041e42; margin-bottom: 20px;
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;
        }
        .thm-btn.print-btn { padding: 8px 16px; font-size: 14px; }
        .h1-actions { display: inline-flex; gap: 10px; flex-wrap: wrap; }
        .thm-btn.track-another-btn {
            padding: 8px 16px; font-size: 14px;
            background: #041e42; color: #fff; border: 1px solid #041e42;
        }
        .thm-btn.track-another-btn:hover { background: #0b2c5c; color: #fff; }
        .thm-btn.track-another-btn .txt i { margin-right: 5px; }
        .track-no {
            background: #fff; border: 1px solid #eee; padding: 20px 25px; border-radius: 10px;
            margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        }
        .track-no strong { color: #C40202; }
        .timeline-list { list-style: none; margin: 0; padding: 0; }
        .timeline-list li {
            position: relative; padding: 0 0 25px 30px; border-left: 2px solid #e5e7eb; margin-left: 10px;
        }
        .timeline-list li:last-child { border-left-color: transparent; padding-bottom: 0; }
        .timeline-list li::before {
            content: ''; position: absolute; left: -8px; top: 3px; width: 14px; height: 14px;
            border-radius: 50%; background: #fff; border: 3px solid #f6a400;
        }
        .timeline-list li.delivered::before { background: #22c55e; border-color: #22c55e; }
        .timeline-list .tl-date { font-weight: 700; color: #041e42; margin-bottom: 4px; }
        .timeline-list .tl-status {
            display: inline-block; background: #f6a400; color: #fff; font-size: 12px;
            padding: 2px 10px; border-radius: 20px; margin-top: 6px;
        }
        .history-item-old { display: none; }
        .timeline-list.show-old .history-item-old { display: block; }
        .history-more-btn {
            display: inline-flex; align-items: center; gap: 8px;
            background: none; border: 1px dashed #c8cdd5; color: #041e42;
            font-size: 14px; font-weight: 600; padding: 8px 18px;
            border-radius: 8px; cursor: pointer;
            transition: all .2s ease;
        }
        .history-more-btn:hover { border-color: #041e42; background: #f5f7fa; }
        .history-more-btn .chev { display: inline-block; transition: transform .25s ease; font-size: 12px; }
        .history-more-btn.expanded .chev { transform: rotate(180deg); }
        .track-side { background: #fff; border: 1px solid #eee; border-radius: 10px; padding: 25px; margin-bottom: 30px; }
        .track-side h3 { font-size: 16px; color: #041e42; margin-bottom: 15px; }
        .track-side table { width: 100%; }
        .track-side table th, .track-side table td { padding: 8px 4px; text-align: left; font-size: 14px; }
        .track-side table th { color: #555; font-weight: 600; width: 45%; }
        .track-side table tr { border-bottom: 1px dashed #eee; }
        .track-side table tr:last-child { border-bottom: none; }
        .track-side .red-title { color: #C40202; font-size: 18px; font-weight: 700; display: block; margin: 10px 0 5px; }
        .pkg-img { width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 15px; }
    </style>
@endpush

@section('title', 'Tracking Shipment')

@section('page_content')

    <section class="track-results">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8">
                    <div class="track-no">
                        <h1>
                            Tracking Shipment
                            <span class="h1-actions">
                                <a href="{{ route('track') }}" class="thm-btn track-another-btn">
                                    <span class="txt"><i class="icon-next"></i>Track Another Shipment</span>
                                </a>
                                <a href="{{ route('track.print', $shipment->tracking_id) }}" target="_blank" class="thm-btn print-btn">
                                    <span class="txt">Print-Invoice</span>
                                </a>
                            </span>
                        </h1>
                        <strong style="font-size:18px;">Tracking No:</strong>
                        <strong style="font-size:22px; color:#C40202;">{{ $shipment->tracking_id }}</strong>
                    </div>

                    @php
                        $history = $shipment->shipmentHistory; // ascending by date/time
                        $oldCount = max(0, $history->count() - 5);
                    @endphp

                    @if($history->isNotEmpty())
                    @if($oldCount > 0)
                    <div style="display:flex; justify-content:flex-end; margin-bottom:10px;">
                        <button type="button" class="history-more-btn" id="history-more-btn" aria-expanded="false" aria-controls="history-list" data-old-count="{{ $oldCount }}">
                            <span class="chev">&#9660;</span>
                            <span class="more-label">View Older Updates ({{ $oldCount }})</span>
                        </button>
                    </div>
                    @endif
                    <ul class="timeline-list" id="history-list">
                        @foreach($history as $index => $h)
                        @php $isRecent = $index >= $history->count() - 5; @endphp
                        <li class="{{ $isRecent ? '' : 'history-item-old' }} {{ strtolower($h->status) === 'delivered' ? 'delivered' : '' }}">
                            <div class="tl-date">
                                {{ \Illuminate\Support\Carbon::parse($h->date)->format('F dS, Y') }},
                                {{ \Illuminate\Support\Carbon::parse($h->time)->format('g:i A') }}
                            </div>
                            <div><strong>{{ $h->remarks }}</strong><br>Customer</div>
                            <div>{{ $h->location }}</div>
                            <span class="tl-status">{{ $h->status }}</span>
                        </li>
                        @endforeach
                    </ul>
                    @else
                        <p>No tracking history available yet for this shipment.</p>
                    @endif

                    <div style="margin-top: 40px;">
                        <h3 style="font-size:20px; color:#041e42; margin-bottom:15px;">Current Location on Map</h3>
                        <div id="map"></div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4">
                    <div class="track-side" style="text-align:center;">
                        <img class="pkg-img" src="{{ $image_src }}" alt="Package Image">
                        <h3>Content of Shipment: <strong>{{ $shipment->package_discription }}</strong></h3>
                    </div>

                    <div class="track-side">
                        <h3>Shipment Overview</h3>
                        <table>
                            <tr><th>Est. Delivery Date :</th><td>{{ $shipment->estimated_delivery_date }}</td></tr>
                            <tr><th>Origin Area:</th><td>{{ $shipment->dispatch_location }}</td></tr>
                            <tr><th>Destination Area:</th><td>{{ $shipment->destination }}</td></tr>
                        </table>
                    </div>

                    <div class="track-side">
                        <span class="red-title">Sender's Details</span>
                        <table>
                            <tr><th>Name:</th><td>{{ $shipment->sender_name }}</td></tr>
                            <tr><th>Email:</th><td>{{ $shipment->sender_email }}</td></tr>
                            <tr><th>Address:</th><td>{{ $shipment->sender_address }}</td></tr>
                        </table>
                    </div>

                    <div class="track-side">
                        <span class="red-title">Receiver's Details</span>
                        <table>
                            <tr><th>Name:</th><td>{{ $shipment->receiver_name }}</td></tr>
                            <tr><th>Email:</th><td>{{ $shipment->receiver_email }}</td></tr>
                            <tr><th>Address:</th><td>{{ $shipment->receiver_address }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Toggle: show/hide older shipment updates
        (function () {
            const btn = document.getElementById('history-more-btn');
            const list = document.getElementById('history-list');
            if (!btn || !list) return;

            const oldCount = parseInt(btn.dataset.oldCount || '0', 10);

            btn.addEventListener('click', function () {
                const expanded = list.classList.toggle('show-old');
                btn.classList.toggle('expanded', expanded);
                btn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                btn.querySelector('.more-label').textContent = expanded
                    ? 'Hide Older Updates'
                    : 'View Older Updates (' + oldCount + ')';
            });
        })();

        const LOCATIONIQ_KEY = @json($geocodeApiKey ?? '');
        const DEFAULT_CENTER = [9.0820, 8.6753];
        const DEFAULT_ZOOM = 6;

        const dispatchLabel = @json($shipment->dispatch_location ?? '');
        const destinationLabel = @json($shipment->destination ?? '');
        const shipmentHistory = @json($shipment_history ?? []);

        const map = L.map('map').setView(DEFAULT_CENTER, DEFAULT_ZOOM);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const markers = L.layerGroup().addTo(map);

        async function geocode(query) {
            if (!query || !query.trim()) return null;
            if (!LOCATIONIQ_KEY) {
                console.warn('Geocode API key is not configured; skipping geocoding for "' + query + '"');
                return null;
            }
            const url = `https://us1.locationiq.com/v1/search.php?key=${encodeURIComponent(LOCATIONIQ_KEY)}&q=${encodeURIComponent(query)}&format=json&limit=1`;
            try {
                const resp = await fetch(url);
                if (!resp.ok) { console.error('LocationIQ API Error: HTTP ' + resp.status); return null; }
                const data = await resp.json();
                if (!Array.isArray(data) || data.length === 0) { console.warn('No results found for "' + query + '"'); return null; }
                const best = data[0];
                return { lat: parseFloat(best.lat), lon: parseFloat(best.lon) };
            } catch (err) {
                console.error('Network error during geocoding:', err);
                return null;
            }
        }

        function escapeHtml(s) {
            return String(s).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;"}[m]));
        }

        function findCurrentLocationIndex(history) {
            let deliveredIndex = -1;
            for (let i = 0; i < history.length; i++) {
                if (history[i].status.toLowerCase() === 'delivered') { deliveredIndex = i; }
            }
            if (deliveredIndex !== -1) { return deliveredIndex; }
            return history.length > 0 ? history.length - 1 : -1;
        }

        (async function() {
            const dispatchCoords = await geocode(dispatchLabel);
            const destinationCoords = await geocode(destinationLabel);

            const historyCoords = [];
            for (const item of shipmentHistory) {
                const coords = await geocode(item.location);
                if (coords) { historyCoords.push({ ...coords, ...item }); }
            }

            const latlngs = [];

            if (dispatchCoords) {
                L.marker([dispatchCoords.lat, dispatchCoords.lon])
                    .addTo(markers)
                    .bindPopup('<b>Origin</b><br>' + escapeHtml(dispatchLabel))
                    .openPopup();
                latlngs.push([dispatchCoords.lat, dispatchCoords.lon]);
            }

            if (destinationCoords) {
                L.marker([destinationCoords.lat, destinationCoords.lon])
                    .addTo(markers)
                    .bindPopup('<b>Destination</b><br>' + escapeHtml(destinationLabel));
                latlngs.push([destinationCoords.lat, destinationCoords.lon]);
            }

            const currentLocationIndex = findCurrentLocationIndex(historyCoords);

            historyCoords.forEach((item, index) => {
                const isCurrentLocation = index === currentLocationIndex;
                const popupContent = `
                    <b>${escapeHtml(item.location)}</b><br>
                    Status: ${escapeHtml(item.status)}<br>
                    Date: ${escapeHtml(item.date)}<br>
                    Time: ${escapeHtml(item.time)}
                `;
                const marker = L.marker([item.lat, item.lon]).addTo(markers).bindPopup(popupContent);

                if (isCurrentLocation) {
                    const packageIcon = L.divIcon({
                        html: '<i class="fas fa-box" style="font-size: 24px; color: red;"></i>',
                        className: 'package-icon',
                        iconSize: [24, 24],
                        iconAnchor: [12, 24],
                        popupAnchor: [0, -24]
                    });
                    marker.setIcon(packageIcon);
                    marker.openPopup();
                }
            });

            const pathLatLngs = [];
            if (dispatchCoords) pathLatLngs.push([dispatchCoords.lat, dispatchCoords.lon]);
            historyCoords.forEach(item => pathLatLngs.push([item.lat, item.lon]));
            if (destinationCoords) pathLatLngs.push([destinationCoords.lat, destinationCoords.lon]);

            if (pathLatLngs.length > 1) {
                const polyline = L.polyline(pathLatLngs, { color: 'green' }).addTo(map);
                map.fitBounds(polyline.getBounds(), { padding: [50, 50] });
            } else if (latlngs.length === 1) {
                map.setView(latlngs[0], 13);
            } else {
                console.warn('Could not find coordinates for origin or destination.');
            }
        })();
    </script>
@endpush
