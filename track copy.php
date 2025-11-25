<?php
session_start();
include 'db.php';
include 'functions.php';

$stmt = mysqli_prepare($con, "SELECT * FROM setting");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$site_logo = $row['site_logo'];
$site_favicon = $row['site_favicon'];
$geocode_api = $row['geocode_api_key'];

$tracking_details = null;

if (isset($_POST['search'])) {
    $tracking_pr = trim($_POST['search_P'] ?? '');
    if ($tracking_pr === '') {
        echo "<script>alert('Insert a tracking number'); window.location.href='track.php'</script>";
        exit;
    }

    // fetch addtracking row
    $stmt = mysqli_prepare($con, "SELECT * FROM addtracking WHERE tracking_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $tracking_pr);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) === 0) {
        echo "<script>alert('Tracking id Not Found'); window.location.href='track.php'</script>";
        exit;
    }
    $tracking_details = mysqli_fetch_assoc($result);

    // Fetch shipment history and pass it to the client-side
    $history_stmt = mysqli_prepare($con, "SELECT location, date, time, remarks, status FROM shipment_history WHERE tracking_id = ? ORDER BY date ASC, time ASC");
    mysqli_stmt_bind_param($history_stmt, "s", $tracking_pr);
    mysqli_stmt_execute($history_stmt);
    $history_result = mysqli_stmt_get_result($history_stmt);
    $shipment_history = [];
    while ($history_row = mysqli_fetch_assoc($history_result)) {
        $shipment_history[] = $history_row;
    }
    $tracking_details['history'] = $shipment_history;
}
?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from itcroctheme.com/nocimon/nocimon-html/contact.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 18 Mar 2024 08:22:48 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Track | Page</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $site_favicon; ?>">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/01-bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/02-all.min.css">
    <link rel="stylesheet" href="assets/css/03-jquery.magnific-popup.css">
    <link rel="stylesheet" href="assets/css/04-nice-select.css">
    <link rel="stylesheet" href="assets/css/05-odometer.css">
    <link rel="stylesheet" href="assets/css/06-swiper.min.css">
    <link rel="stylesheet" href="assets/css/07-animate.min.css">
    <link rel="stylesheet" href="assets/css/08-custom-animate.css">
    <link rel="stylesheet" href="assets/css/09-slick.css">
    <link rel="stylesheet" href="assets/css/10-icomoon.css">
    <link rel="stylesheet" href="assets/vendor/custom-animate/custom-animate.css">
    <link rel="stylesheet" href="assets/vendor/jarallax/jarallax.css">
    <link rel="stylesheet" href="assets/vendor/odometer/odometer.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/tracking.css">

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

<body class="body-gray-bg">

    <!-- preloader -->
    <div id="preloader">
        <div id="loading-center">
            <div class="loader">
                <div class="loader-outter"></div>
                <div class="loader-inner"></div>
            </div>
        </div>
    </div>
    <!-- preloader-end -->


    <!-- Start Extra Info -->
    <div class="extra-info">
        <div class="close-icon menu-close">
            <button>
                <i class="icon-close"></i>
            </button>
        </div>
        <div class="logo-side">
            <a href="index.php"><img src="assets/img/logo.png" alt="#"></a>
        </div>
        <div class="side-info">
            <div class="content-box">
                <h3>Welcome to our Best<br> Transportation Company</h3>
                <div class="text">
                    <p>
                        It is a long established fact that a reader will be distracted by the content of a page when
                        looking at its layout. Lorem Ipsum is simply text of the printing
                    </p>
                </div>
            </div>
            <!--Start Sidebar Contact Info -->
            <div class="sidebar-contact-info">
                <h3>Conatct Us</h3>
                <ul>
                    <li>
                        <div class="icon">
                            <span class="icon-open-mail"></span>
                        </div>
                        <div class="text">
                            <p><a href="mailto:info@example.com">info@cargolink.com</a></p>
                        </div>
                    </li>
                    <li>
                        <div class="icon">
                            <span class="icon-phone-call-1"></span>
                        </div>
                        <div class="text">
                            <p><a href="tel:+8801682648101">+1800 456 7890</a></p>
                        </div>
                    </li>
                    <li>
                        <div class="icon">
                            <span class="fa-regular fa-clock"></span>
                        </div>
                        <div class="text">
                            <p>Working Hour : 7.00am to 4.00pm</p>
                        </div>
                    </li>
                </ul>
            </div>
            <!--End Sidebar Contact Info -->
            <div class="side-content-newsletter-box">
                <h3>Newsletter Subscription</h3>
               
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Enter Email Address" required="">
                        <button class="thm-btn" type="submit">
                            <span class="txt">
                                <i class="icon-paper-plane"></i>
                            </span>
                        </button>
                    </div>
         
            </div>
            <!--Start Side Social Links -->
            <div class="side-social-links">
                <ul class="clearfix">
                    <li>
                        <a href="#">
                            <i class="icon-facebook-app-symbol"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-linked-in-logo-of-two-letters"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-pinterest"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!--End Side Social Links -->
        </div>
    </div>
    <div class="offcanvas-overly"></div>
    <!-- End Extra Info -->


    <div class="page-wrapper">
        <!--Start Main Header One -->
        <header class="main-header main-header-one style4">
            <div id="sticky-header" class="menu-area">
                <div class="container">
                    <div class="main-header-one__inner">

                        <!--Start Main Header one Inner Left -->
                        <div class="main-header-style4__left">
                            <div class="logo-box-one">
                                <a href="index.php">
                                    <img src="<?php echo $site_logo; ?>" alt="Logo">
                                </a>
                            </div>
                        </div>
                        <!--End Main Header one Inner Left -->

                        <!--Start Main Header Style4 Middle -->
                        <div class="main-header-style4__middle">
                            <div class="menu-area__inner">
                                <div class="mobile-nav-toggler">
                                    <i class="fas fa-bars"></i>
                                </div>
                                <div class="menu-wrap">
                                    <nav class="menu-nav">
                                        <div class="navbar-wrap main-menu">
                                            <ul class="navigation">
                                                <li class=""><a href="index.php">Home</a>
                                                </li>
                                                <li class=""><a href="about.php">About Us</a></li>
                                                <li class=""><a href="services.php">Services</a>
                                        
                                                </li>

                                                <li class="active"><a href="track.php">Track</a></li>

                                                <li><a href="contact.php">contact</a></li>

                                            </ul>
                                        </div>
                                    </nav>
                                </div>
                            </div>

                            <div class="main-menu-right-box-one">
                                <div class="search-box-one">
                                    <a href="#" class="main-menu__search search-toggler">
                                        <span class="icon-search-interface-symbol"></span>
                                    </a>
                                </div>
                                <div class="side-content-button-one">
                                    <a class="menu-tigger" href="#">
                                        <span class="line"></span>
                                        <span class="line two"></span>
                                    </a>
                                </div>
                            </div>

                        </div>
                        <!--End Main Header Style4 Middle -->

                        <!--Start Main Header Style4 Right -->
                        <div class="main-header-style4__right">
                            <div class="contact-box">
                                <div class="icon">
                                    <span class="icon-phone-call-1"></span>
                                </div>
                                <div class="text-box">
                                    <p>Requesting A Call:</p>
                                    <h4><a href="tel:123456789">(629) 555-0129</a></h4>
                                </div>
                            </div>
                        </div>
                        <!--End Main Header Style4 Right -->

                    </div>
                </div>
            </div>

            <!--Start Mobile Menu  -->
            <div class="mobile-menu">
                <nav class="menu-box">
                    <div class="close-btn"><i class="fas fa-times"></i></div>
                    <div class="nav-logo">
                        <a href="index.php"><img src="assets/img/resource/mobile-menu-logo.png" alt="Logo"></a>
                    </div>
                    <div class="menu-outer">
                        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                    </div>
                    <div class="social-links">
                        <ul class="clearfix list-wrap">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="menu-backdrop"></div>
            <!-- End Mobile Menu -->
        </header>
        <!--End Main Header One -->

        <!--Start Page Header-->
        <section class="page-header">
            <div class="page-header__img float-bob-y"><img src="assets/img/resource/page-header-img.png" alt=""></div>
            <div class="container">
                <div class="page-header__inner">
                    <h2>Tracking Page</h2>
                    <ul class="thm-breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><span class="icon-left"></span></li>
                        <li>Tracking Page</li>
                    </ul>
                </div>
            </div>
        </section> <br> <br> 
        <!--End Page Header-->



        <div class="col-xl-12 col-lg-12">
            <div class="contact-one__form">
                <form id="" action="track.php" method="POST">
                    <div class="row">
                        <div class="col-xl-9 col-lg-9">
                            <div class="contact-one__input-box">
                                <!-- <input type="text" class="form-control" name="search_P" placeholder="egq32232131" name="name"> -->
                                <input type="text" class="form-control" name="search_P" placeholder="Enter Tracking number" >
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3">
                            <div class="contact-one__input-box">
                                <button name="search" class=" thm-btn" style="padding: 10px; margin-top: 0px;" type="submit" ><b class="txt">Track</b></button>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    
<?php if ($tracking_details): ?>
<div class="tracking-container">
    <div class="tracking-header">
        <h1>Tracking Shipment</h1>
        <a href="track/print.php?num=<?php echo htmlspecialchars($tracking_details['tracking_id'], ENT_QUOTES); ?>" target="_blank" class="print-invoice">Print Invoice</a>
    </div>

    <p class="tracking-id">
        <strong>Tracking No:</strong>
        <span class="number"><?php echo htmlspecialchars($tracking_details['tracking_id'], ENT_QUOTES); ?></span>
    </p>

    <div class="tracking-body">
        <div class="tracking-main-content">
            <ul class="timeline">
                <?php foreach ($tracking_details['history'] as $history_row): ?>
                <li>
                    <div class="timeline-date">
                        <strong><?php echo date('F dS, Y', strtotime($history_row['date'])); ?></strong>
                        <br>
                        <?php echo date("g:i A", strtotime($history_row['time'])); ?>
                    </div>
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <strong><?php echo htmlspecialchars($history_row['remarks'], ENT_QUOTES); ?></strong>
                        <div class="location"><?php echo htmlspecialchars($history_row['location'], ENT_QUOTES); ?></div>
                        <span class="status"><?php echo htmlspecialchars($history_row['status'], ENT_QUOTES); ?></span>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>

            <div class="map-card">
                <h3>Current Location on Map</h3>
                <div id="map"></div>
            </div>
        </div>

        <div class="tracking-sidebar">
            <div class="details-card">
                <h3>Shipment Details</h3>
                <img src="uploads/<?php echo htmlspecialchars($tracking_details['image'], ENT_QUOTES); ?>" alt="Package Image" class="shipment-image">
                <p><strong>Content:</strong> <?php echo htmlspecialchars($tracking_details['package_discription'], ENT_QUOTES); ?></p>
                <table>
                    <tr>
                        <th>Est. Delivery Date:</th>
                        <td><?php echo htmlspecialchars($tracking_details['estimated_delivery_date'], ENT_QUOTES); ?></td>
                    </tr>
                    <tr>
                        <th>Origin:</th>
                        <td><?php echo htmlspecialchars($tracking_details['dispatch_location'], ENT_QUOTES); ?></td>
                    </tr>
                    <tr>
                        <th>Destination:</th>
                        <td><?php echo htmlspecialchars($tracking_details['destination'], ENT_QUOTES); ?></td>
                    </tr>
                </table>
            </div>

            <div class="details-card">
                <h3>Sender's Details</h3>
                <table>
                    <tr>
                        <th>Name:</th>
                        <td><?php echo htmlspecialchars($tracking_details['sender_name'], ENT_QUOTES); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo htmlspecialchars($tracking_details['sender_email'], ENT_QUOTES); ?></td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td><?php echo htmlspecialchars($tracking_details['sender_address'], ENT_QUOTES); ?></td>
                    </tr>
                    <tr>
                        <th>Mobile:</th>
                        <td><?php echo htmlspecialchars($tracking_details['sender_contact'], ENT_QUOTES); ?></td>
                    </tr>
                </table>
            </div>

            <div class="details-card">
                <h3>Receiver's Details</h3>
                <table>
                    <tr>
                        <th>Name:</th>
                        <td><?php echo htmlspecialchars($tracking_details['receiver_name'], ENT_QUOTES); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo htmlspecialchars($tracking_details['receiver_email'], ENT_QUOTES); ?></td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td><?php echo htmlspecialchars($tracking_details['receiver_address'], ENT_QUOTES); ?></td>
                    </tr>
                    <tr>
                        <th>Mobile:</th>
                        <td><?php echo htmlspecialchars($tracking_details['receiver_contact'], ENT_QUOTES); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


        
        <!--Start Footer One-->
        <footer class="footer-one">
            <!--Start Footer Middle-->
            <div class="footer-middle footer-middle--two">
                <div class="container">
                    <div class="footer-middle__inner">
                        <div class="footer-logo-box">
                            <img src="assets/img/logo.png" style="width: 170px;" alt="#">
                        </div>
                        <div class="phone-number-box phone-number-box--style2">
                            <div class="icon">
                                <span class="icon-phone-call-1"></span>
                            </div>
                            <div class="text">
                                <p>Need help?</p>
                                <p><a href="tel:(808)555-0111">(808) 555-0111</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Footer Middle-->

            <!--Start Footer Bottom -->
            <div class="footer-bottom footer-bottom--two">
                <div class="container">
                    <div class="footer-bottom__inner">
                        <div class="copyright-text copyright-text--two">
                            <p>© Cargo link 2023 | <a href="index.php">Cargolink</a>, All Rights Reserved.</p>
                        </div>

                        <div class="copyright-menu copyright-menu--two">
                            <ul>
                                <li>
                                    <p><a href="#">Trams &amp; Condition</a></p>
                                </li>
                                <li>
                                    <p><a href="#">Privacy Policy</a></p>
                                </li>
                                <li>
                                    <p><a href="#">Contact Us</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Footer Bottom -->
        </footer>
        <!--Start Footer One-->
    </div>


    

    <!--Start Search Popup -->
    <div class="search-popup">
        <div class="search-popup__overlay search-toggler">
            <div class="search-close-btn">
                <i class="icon-plus"></i>
            </div>
        </div>
        <div class="search-popup__content">
           
                <label for="search" class="sr-only">search here</label>
                <input type="search" id="search" placeholder="Search Here..." />
                <button type="submit" aria-label="search submit" class="btn-one">
                    <i class="icon-search-interface-symbol"></i>
                </button>
           
        </div>
    </div>
    <!--End Search Popup -->




    <!-- Scroll-top -->
    <button class="scroll-top scroll-to-target" data-target="html">
        <i class="icon-arrowhead-up"></i>
    </button>
    <!-- Scroll-top-end-->




    <!-- JS here -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/01-ajax-form.js"></script>
    <script src="assets/js/02-bootstrap.min.js"></script>
    <script src="assets/js/03-jquery.appear.js"></script>
    <script src="assets/js/04-swiper.min.js"></script>
    <script src="assets/js/05-jquery.odometer.min.js"></script>
    <script src="assets/js/06-jquery.magnific-popup.min.js"></script>
    <script src="assets/js/07-jquery.nice-select.min.js"></script>
    <script src="assets/js/08-slick.min.js"></script>
    <script src="assets/js/09-wow.min.js"></script>
    <script src="assets/js/10-jquery.circleType.js"></script>
    <script src="assets/js/11-jquery.lettering.min.js"></script>
    <script src="assets/js/12-TweenMax.min.js"></script>
    <script src="assets/vendor/jarallax/jarallax.min.js"></script>
    <script src="assets/vendor/marquee/marquee.min.js"></script>
    <script src="assets/vendor/odometer/odometer.min.js"></script>




    <script src="assets/js/main.js"></script>

      <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
  // --- CONFIG ---
  const LOCATIONIQ_KEY = <?php echo json_encode($geocode_api, JSON_HEX_TAG); ?>;
  const DEFAULT_CENTER = [9.0820, 8.6753]; // Nigeria center
  const DEFAULT_ZOOM = 6;

  // --- PHP DATA ---
  const dispatchLabel = <?php echo json_encode($tracking_details['dispatch_location'] ?? '', JSON_HEX_TAG); ?>;
  const destinationLabel = <?php echo json_encode($tracking_details['destination'] ?? '', JSON_HEX_TAG); ?>;
  const shipmentHistory = <?php echo json_encode($tracking_details['history'] ?? [], JSON_HEX_TAG); ?>;

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


<!-- Mirrored from itcroctheme.com/nocimon/nocimon-html/contact.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 18 Mar 2024 08:22:48 GMT -->
</html>