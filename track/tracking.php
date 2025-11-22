<?php
session_start();
include '../db.php';
include '../functions.php';

if (!isset($_POST['search'])) {
    echo "<script>window.location.href='../track.html'</script>";
    exit;
}
$tracking_pr = trim($_POST['search_P'] ?? '');
if ($tracking_pr === '') {
    echo "<script>alert('Insert a tracking number'); window.location.href='../track.html'</script>";
    exit;
}

// fetch addtracking row
$stmt = mysqli_prepare($con, "SELECT * FROM addtracking WHERE tracking_id = ?");
mysqli_stmt_bind_param($stmt, "s", $tracking_pr);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) === 0) {
    echo "<script>alert('Tracking id Not Found'); window.location.href='../track.html'</script>";
    exit;
}
$row = mysqli_fetch_assoc($result);

// copy variables for display
$user_tracking = $row['tracking_id'];
$package_discription = $row['package_discription'];
$image = $row['image'];
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

$coordinates = json_decode($row['coordinates'] ?? 'null', true);
$geocoding_errors = [];

// If no coordinates saved yet, build from shipment_history
if (empty($coordinates) || !is_array($coordinates)) {
    $coordinates = ['dispatch' => null, 'destination' => null, 'history' => []];

    // If dispatch or destination exist on addtracking row, attempt to geocode them
    if (!empty($dispatch_location)) {
        $dc = getCoordinates($dispatch_location);
        if (isset($dc['error'])) {
            $geocoding_errors[] = "Dispatch location ('" . htmlspecialchars($dispatch_location) . "'): " . $dc['error'];
        } elseif ($dc) {
            $coordinates['dispatch'] = ['lat' => $dc['lat'], 'lon' => $dc['lon']];
        }
    }
    if (!empty($destination)) {
        $dd = getCoordinates($destination);
        if (isset($dd['error'])) {
            $geocoding_errors[] = "Destination location ('" . htmlspecialchars($destination) . "'): " . $dd['error'];
        } elseif ($dd) {
            $coordinates['destination'] = ['lat' => $dd['lat'], 'lon' => $dd['lon']];
        }
    }

    // fetch shipment_history for this tracking id (ordered)
    $hist_stmt = mysqli_prepare($con, "SELECT location, date, time, remarks FROM shipment_history WHERE tracking_id = ? ORDER BY date ASC, time ASC");
    mysqli_stmt_bind_param($hist_stmt, "s", $tracking_pr);
    mysqli_stmt_execute($hist_stmt);
    $hist_res = mysqli_stmt_get_result($hist_stmt);

    // to avoid duplicate geocoding, track which places we've already looked up
    $seen_places = [];

    while ($h = mysqli_fetch_assoc($hist_res)) {
        $place = trim($h['location']);
        if ($place === '') continue;

        if (!isset($seen_places[$place])) {
            $gc = getCoordinates($place); // uses geocache internally
            $seen_places[$place] = $gc; // possibly null
        } else {
            $gc = $seen_places[$place];
        }

        if (isset($gc['error'])) {
            $geocoding_errors[] = "History location ('" . htmlspecialchars($place) . "'): " . $gc['error'];
        } elseif ($gc) {
            $coordinates['history'][] = [
                'name' => $place,
                'lat' => $gc['lat'],
                'lon' => $gc['lon'],
                'date' => $h['date'],
                'time' => $h['time'],
                'remarks' => $h['remarks']
            ];
        }
    }

    // Save coordinates JSON back to addtracking for future loads
    $json_coordinates = json_encode($coordinates);
    $update_stmt = mysqli_prepare($con, "UPDATE addtracking SET coordinates = ? WHERE tracking_id = ?");
    mysqli_stmt_bind_param($update_stmt, "ss", $json_coordinates, $tracking_pr);
    mysqli_stmt_execute($update_stmt);
}

// Temporary debugging to expose raw errors
if (!empty($geocoding_errors)) {
    echo "<h1>Geocoding Debug Output</h1>";
    echo "<pre>";
    var_dump($geocoding_errors);
    echo "</pre>";
    die("Execution halted for debugging.");
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
                  $stmt = mysqli_prepare($con, "SELECT * FROM shipment_history WHERE tracking_id = ? ORDER BY date DESC, time DESC");
                  mysqli_stmt_bind_param($stmt, "s", $tracking_pr);
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
                  if (mysqli_num_rows($result) > 0) {
                      while ($row_history = mysqli_fetch_assoc($result)) {
                  ?>
                  <ul class="delivered-grid-box">
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
                    </li><br><br>
                  </ul>
                <?php }}?>
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
                <img class="nav-profile-img mr-2" alt="" src="../uploads/<?php echo htmlspecialchars($image, ENT_QUOTES); ?>" style="width:330px; height:150px;" />
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

  <!-- Scripts: jQuery (only once) and Leaflet JS -->
  <script src="j/jquery.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

  <script>
    // Export PHP coordinates and location strings into JS safely
    var coords = <?php echo json_encode($coordinates ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    var dispatchLabel = <?php echo json_encode($dispatch_location ?? '', JSON_HEX_TAG); ?>;
    var destinationLabel = <?php echo json_encode($destination ?? '', JSON_HEX_TAG); ?>;
    console.log("coords from server:", coords);

    // sensible fallback (Lagos coordinates)
    var fallback = {lat: 6.5244, lon: 3.3792};

    function safeParseFloat(v) {
      if (typeof v === 'number') return v;
      if (typeof v === 'string') { v = v.trim(); return v === '' ? NaN : parseFloat(v); }
      return NaN;
    }

    // pick initial center
    var centerLat = fallback.lat, centerLon = fallback.lon, zoom = 6;

    if (coords && coords.dispatch && coords.dispatch.lat && coords.dispatch.lon) {
      centerLat = safeParseFloat(coords.dispatch.lat);
      centerLon = safeParseFloat(coords.dispatch.lon);
      zoom = 10;
    }

    var map = L.map('map').setView([centerLat, centerLon], zoom);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{ attribution: '&copy; OpenStreetMap contributors' }).addTo(map);

    var latlngs = [];

    function addIfValid(lat, lon, popup, openPopup=false){
      lat = safeParseFloat(lat); lon = safeParseFloat(lon);
      if (isNaN(lat) || isNaN(lon)) return false;
      var m = L.marker([lat, lon]).addTo(map).bindPopup(popup || '');
      if (openPopup) m.openPopup();
      return [lat, lon];
    }

    if (coords && coords.dispatch && coords.dispatch.lat && coords.dispatch.lon) {
      var r = addIfValid(coords.dispatch.lat, coords.dispatch.lon, '<b>Dispatch</b><br>' + dispatchLabel, true);
      if (r) latlngs.push(r);
    }

    if (coords && Array.isArray(coords.history)) {
      coords.history.forEach(function(h){
        var popup = '<b>' + (h.name||'') + '</b>' + (h.remarks ? '<br/>' + h.remarks : '');
        var r = addIfValid(h.lat, h.lon, popup, false);
        if (r) latlngs.push(r);
      });
    }

    if (coords && coords.destination && coords.destination.lat && coords.destination.lon) {
      var r = addIfValid(coords.destination.lat, coords.destination.lon, '<b>Destination</b><br>' + destinationLabel, false);
      if (r) latlngs.push(r);
    }

    if (latlngs.length > 1) {
      var polyline = L.polyline(latlngs, {color: 'blue'}).addTo(map);
      map.fitBounds(polyline.getBounds(), {padding:[40,40]});
    } else if (latlngs.length === 1) {
      map.setView(latlngs[0], 13);
    } else {
      console.warn('No valid coordinates available to show on map.');
    }

    if (coords && coords.dispatch && coords.dispatch.lat && coords.dispatch.lon && coords.destination && coords.destination.lat && coords.destination.lon) {
      var directLatLngs = [
        [safeParseFloat(coords.dispatch.lat), safeParseFloat(coords.dispatch.lon)],
        [safeParseFloat(coords.destination.lat), safeParseFloat(coords.destination.lon)]
      ];
      var directPolyline = L.polyline(directLatLngs, {color: 'red'}).addTo(map);
    }
  </script>

</body>
</html>
