<?php
session_start();
include '../db.php';
include '../functions.php';

if (!isset($_POST['search'])) {
    echo "<script>window.location.href='../track.php'</script>";
    exit;
}
$tracking_pr = trim($_POST['search_P'] ?? '');
if ($tracking_pr === '') {
    echo "<script>alert('Insert a tracking number'); window.location.href='../track.php'</script>";
    exit;
}

// fetch addtracking row
$stmt = mysqli_prepare($con, "SELECT * FROM addtracking WHERE tracking_id = ?");
mysqli_stmt_bind_param($stmt, "s", $tracking_pr);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) === 0) {
    echo "<script>alert('Tracking id Not Found'); window.location.href='../track.php'</script>";
    exit;
}
$row = mysqli_fetch_assoc($result);

// copy variables for display
$user_tracking = $row['tracking_id'];
$package_discription = $row['package_discription'];
$image = $row['image'];

// Set a placeholder image if no image is provided
$image_src = '';
if (!empty($image)) {
    $image_src = '../uploads/' . htmlspecialchars($image, ENT_QUOTES);
} else {
    $image_src = 'https://placehold.co/330x150/EEE/31343C.png?text=Package';
}
$dispatch_location = $row['dispatch_location'];
$destination = $row['destination'];
$estimated_delivery_date = $row['estimated_delivery_date'];
$sender_name = $row['sender_name'];
$sender_email = $row['sender_email'];
$sender_address = $row['sender_address'];
$sender_contact = $row['sender_contact'];
$receiver_name = $row['receiver_name'];
$receiver_email = $row['receiver_email'];
$receiver_address = $row['receiver_address'];
$receiver_contact = $row['receiver_contact'];

// No server-side geocoding needed anymore.
// The location names will be passed to the client-side JavaScript.

// Fetch shipment history and pass it to the client-side
$history_stmt = mysqli_prepare($con, "SELECT location, date, time, remarks, status FROM shipment_history WHERE tracking_id = ? ORDER BY date ASC, time ASC");
mysqli_stmt_bind_param($history_stmt, "s", $tracking_pr);
mysqli_stmt_execute($history_stmt);
$history_result = mysqli_stmt_get_result($history_stmt);
$shipment_history = [];
while ($history_row = mysqli_fetch_assoc($history_result)) {
    $shipment_history[] = $history_row;
}

$_SESSION['search_P'] = $user_tracking;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta charset="utf-8">
  <meta name="keywords" content="#1 Best Courier & Logistics Company in UK">
  <meta name="description" content="#1 Best Courier & Logistics Company in UK">
  <title>Tracking Result</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- styles -->
  <link href="c/template.css" rel="stylesheet" type="text/css">
  <link href="c/general.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="c/responsives.css">
  <link rel="stylesheet" type="text/css" href="c/styl.css" media="all">
  <link rel="stylesheet" type="text/css" href="c/custom-style.css">
  <link rel="stylesheet" type="text/css" href="c/carousel.css">
  <link href="images/favicon.png" rel="shortcut icon">
  <link rel="icon" href="images/favicon.png" type="image/x-icon">

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <style>
    /* ensure the map has height */
    #map { width:100%; height:300px; }
    table { font-family: arial, sans-serif; border-collapse: collapse; width: 100%; }
    td, th { border: 1px solid #dddddd; text-align: left; padding: 8px; }
    tr:nth-child(even) { background-color: #dddddd; }
    .m-btm { text-align: center; margin-bottom: 35px; }
    .mtn { text-align: center; }
    .d-bl { display: block; margin-bottom: 25px; }
    #btnal, #btn { background: teal; color: aqua; border-radius: 5px; padding: 0.5rem; font-size: 0.83rem; cursor: pointer; }
  </style>
</head>

<body>
  <div id="wrapper">
    <div id="banner">
      <div class="container"><div class="bg"></div></div>
      <div class="block block-tracker">
        <div class="h_container">
          <form action="tracking.php" method="post" id="userForm">
            <p>TRACK YOUR SHIPMENT
              <input type="text" name="search_P" id="Consignment" placeholder="Enter Tracking number"  />
              <input type="submit" name="search" id="send" value="TRACK NOW" />
            </p>
          </form>
        </div>
      </div>
    </div>

  <?php
    // show content if search
    if (isset($_POST['search'])) {
  ?>

    <div class="content_wrapper">
      <div class="container">
        <div class="section_row">
          <div class="col_7">
            <div class="main_content">
              <div class="mod mod-article">
                <div class="article-icon">
                  <h1>Tracking Shipment &nbsp;
                    <a href="print.php?num=<?php echo htmlspecialchars($user_tracking, ENT_QUOTES); ?>" target="_blank" id="order-status" class="default"> Print-Invoice</a>
                  </h1>
                </div>
                <div class="clear"></div>

                <div id="article_content_area">
                  <strong>
                    <font size="5">
                      <font face="helvetica">
                        <font size="5" color="#2c2c2c">Tracking No:</font>
                        <font size="5" color="#C40202" face="arial,helvetica,sans-serif"><?php echo htmlspecialchars($user_tracking, ENT_QUOTES); ?> </font><br />
                      </font>
                    </font>
                  </strong><br /><br />

                  <?php
                  $stmt = mysqli_prepare($con, "SELECT * FROM shipment_history WHERE tracking_id = ? ORDER BY date ASC, time ASC");
                  mysqli_stmt_bind_param($stmt, "s", $tracking_pr);
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
                  if (mysqli_num_rows($result) > 0) {
                  ?>
                  <ul class="delivered-grid-box">
                  <?php
                      while ($row_history = mysqli_fetch_assoc($result)) {
                  ?>
                    <li>
                      <div class="delivered-left">
                        <span><strong><?php echo date('F dS, Y', strtotime($row_history['date'])); ?></strong>,<br> <?php echo date("G:i A", strtotime($row_history['time'])); ?></span>
                      </div>
                      <span class="d-bulte"><i class="current"></i></span>
                      <div class="delivered-right">
                        <strong><?php echo htmlspecialchars($row_history['remarks'], ENT_QUOTES); ?></strong><br>Customer<br>
                        <?php echo htmlspecialchars($row_history['location'], ENT_QUOTES); ?><br>
                        <span id="order-status" class="default"><?php echo htmlspecialchars($row_history['status'], ENT_QUOTES); ?></span>
                      </div>
                    </li>
                  <?php
                      }
                  ?>
                  </ul>
                  <?php
                  }?>
                  <br /><br />
                </div>

                <div class="clear">&nbsp;</div>
              </div>

              <div class="block block-scrolling-ad">
                <div class="block-content">
                  <font size="5" color="#2c2c2c">Current Location on Map</font><br/>
                  <?php if (!empty($geocoding_errors)): ?>
                    <div style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 20px;">
                        <strong><i class="icon-warning"></i> Geocoding Errors:</strong>
                        <ul style="margin-top: 10px; padding-left: 20px;">
                            <?php foreach ($geocoding_errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                  <?php endif; ?>
                  <div align="center">
                    <div id="map"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col_3">
            <div>
              <center>
                <img class="nav-profile-img mr-2" alt="Package Image" src="<?php echo $image_src; ?>" style="width:330px; height:150px;" />
                <br />
                <h3>Content of Shipment: <strong><?php echo htmlspecialchars($package_discription, ENT_QUOTES); ?></strong></h3>
              </center>

              <br><br />
              <table>
                <tr><th>Est. Delivery Date :</th><td><?php echo htmlspecialchars($estimated_delivery_date, ENT_QUOTES); ?></td></tr>
                <tr><th>Origin Area:</th><td><?php echo htmlspecialchars($dispatch_location, ENT_QUOTES); ?></td></tr>
                <tr><th>Destination Area:</th><td><?php echo htmlspecialchars($destination, ENT_QUOTES); ?></td></tr>
              </table>

              <br><br />
              <strong><font size="5" color="#C40202" face="arial,helvetica,sans-serif">Sender's Details</font></strong><br />
              <table>
                <tr><th>Name:</th><td><?php echo htmlspecialchars($sender_name, ENT_QUOTES); ?></td></tr>
                <tr><th>Email:</th><td><?php echo htmlspecialchars($sender_email, ENT_QUOTES); ?></td></tr>
                <tr><th>Address:</th><td><?php echo htmlspecialchars($sender_address, ENT_QUOTES); ?></td></tr>
                <tr><th>Mobile:</th><td><?php echo htmlspecialchars($sender_contact, ENT_QUOTES); ?></td></tr>
              </table>

              <br><br />
              <strong><font size="5" color="#C40202" face="arial,helvetica,sans-serif">Receiver's Details</font></strong><br />
              <table>
                <tr><th>Name:</th><td><?php echo htmlspecialchars($receiver_name, ENT_QUOTES); ?></td></tr>
                <tr><th>Email:</th><td><?php echo htmlspecialchars($receiver_email, ENT_QUOTES); ?></td></tr>
                <tr><th>Address:</th><td><?php echo htmlspecialchars($receiver_address, ENT_QUOTES); ?></td></tr>
                <tr><th>Mobile:</th><td><?php echo htmlspecialchars($receiver_contact, ENT_QUOTES); ?></td></tr>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>

  <?php } // end if POST search ?>

    <footer id="footer">
      <div class="container">
        <div class="links-container">
          <div class="social">
            Always stay connected with us.. <br><br>
            <a href="http://www.facebook.com/" target="_blank"><img src="image/facebook.png" width="20" height="20" border="0" title="Facebook"></a>
            <a href="http://www.twitter.com/" target="_blank"><img src="image/twitter.png" width="20" height="20" border="0" title="Twitter"></a>
            <a href="http://www.youtube.com/" target="_blank"><img src="image/youtube.png" width="20" height="20" border="0" title="Youtube"></a>
          </div>

          <div class="copyright clear">
            Copyright &copy 2023 All Rights Reserved.
          </div>
        </div>
      </div>
    </footer>

  </div>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <script>
    // --- CONFIG ---
    const LOCATIONIQ_KEY = 'pk.01682cb67d93596fbb5d646c24723c75'; // Your public API key
    const DEFAULT_CENTER = [9.0820, 8.6753]; // Nigeria center
    const DEFAULT_ZOOM = 6;

    // --- PHP DATA ---
    const dispatchLabel = <?php echo json_encode($dispatch_location ?? '', JSON_HEX_TAG); ?>;
    const destinationLabel = <?php echo json_encode($destination ?? '', JSON_HEX_TAG); ?>;
    const shipmentHistory = <?php echo json_encode($shipment_history ?? [], JSON_HEX_TAG); ?>;

    // --- MAP SETUP ---
    const map = L.map('map').setView(DEFAULT_CENTER, DEFAULT_ZOOM);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const markers = L.layerGroup().addTo(map);

    // --- GEOCODING LOGIC ---
    async function geocode(query) {
        if (!query || !query.trim()) return null;
        const url = `https://us1.locationiq.com/v1/search.php?key=${encodeURIComponent(LOCATIONIQ_KEY)}&q=${encodeURIComponent(query)}&format=json&limit=1`;
        try {
            const resp = await fetch(url);
            if (!resp.ok) {
                console.error('LocationIQ API Error: HTTP ' + resp.status);
                return null;
            }
            const data = await resp.json();
            if (!Array.isArray(data) || data.length === 0) {
                console.warn('No results found for "' + query + '"');
                return null;
            }
            const best = data[0];
            return { lat: parseFloat(best.lat), lon: parseFloat(best.lon) };
        } catch (err) {
            console.error('Network error during geocoding:', err);
            return null;
        }
    }

    // --- HELPERS ---
    function findCurrentLocationIndex(history) {
        let deliveredIndex = -1;
        // The history is already sorted chronologically, so the last 'Delivered' is the most recent.
        for (let i = 0; i < history.length; i++) {
            if (history[i].status.toLowerCase() === 'delivered') {
                deliveredIndex = i;
            }
        }

        if (deliveredIndex !== -1) {
            return deliveredIndex; // Return the last 'Delivered' entry
        }

        // If no 'Delivered' status is found, return the last known location.
        return history.length > 0 ? history.length - 1 : -1;
    }

    // --- MAIN EXECUTION ---
    (async function() {
        const dispatchCoords = await geocode(dispatchLabel);
        const destinationCoords = await geocode(destinationLabel);

        const historyCoords = [];
        for (const item of shipmentHistory) {
            const coords = await geocode(item.location);
            if (coords) {
                historyCoords.push({ ...coords, ...item });
            }
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
            const marker = L.marker([item.lat, item.lon]).addTo(markers)
                .bindPopup(popupContent);

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

    function escapeHtml(s) {
        return String(s).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;"}[m]));
    }
  </script>

</body>
</html>
