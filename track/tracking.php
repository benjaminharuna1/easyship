<?php
session_start();
include '../db.php';
include '../functions.php';

// $tracking_pr = "";
$error = "";
if (isset($_POST['search'])) {
  $tracking_pr = trim($_POST['search_P']);

  if (empty($tracking_pr)) {
    echo "<script> alert('insert a tracking number'); window.location.href = '../track.html'</script>";
  } else {
    $sql = mysqli_query($con, "SELECT * FROM addtracking WHERE tracking_id = '$tracking_pr' ");
    if (mysqli_num_rows($sql) > 0) {
      $rows = mysqli_fetch_assoc($sql);
      $user_tracking = $rows['tracking_id'];
      $package_discription = $rows['package_discription'];
      $image = $rows['image'];
      $order_date = $rows['updated_time'];
      $status = $rows['status'];
      $weight = $rows['weight'];
      $dispatch_location = $rows['dispatch_location'];
      $destination = $rows['destination'];
      $sender_name = $rows['sender_name'];
      $sender_contact = $rows['sender_contact'];
      $sender_email = $rows['sender_email'];
      $sender_address = $rows['sender_address'];
      $receiver_name = $rows['receiver_name'];
      $receiver_contact = $rows['receiver_contact'];
      $receiver_email = $rows['receiver_email'];
      $receiver_address = $rows['receiver_address'];
      $dispatch_location = $rows['dispatch_location'];
      $carrier = $rows['carrier'];
      $weight = $rows['weight'];
      $carrier_refrence_number = $rows['carrier_refrence_number'];
      $quantity = $rows['quantity'];
      $dispatch_date = $rows['dispatch_date'];
      $package_discription = $rows['package_discription'];
      $destination = $rows['destination'];
      $shipment_mode = $rows['shipment_mode'];
      $payment_mode = $rows['payment_mode'];
      $estimated_delivery_date = $rows['estimated_delivery_date'];
      $delivery_time = $rows['delivery_time'];
      $current_location = $rows['current_location'];
      $message = $rows['message'];
      $delivary_message = $rows['delivery_message'];
      $_SESSION['search_P'] = $user_tracking;
      // header('location:../track.html');
    } else {
      echo  "<script> alert('Tracking id Not Found'); window.location.href = '../track.html' </script>";
    }
  }
} else {
  echo "<script>  window.location.href = '../track.html'</script>";
}


?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Track | Page</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="../assets/css/01-bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/02-all.min.css">
    <link rel="stylesheet" href="../assets/css/03-jquery.magnific-popup.css">
    <link rel="stylesheet" href="../assets/css/04-nice-select.css">
    <link rel="stylesheet" href="../assets/css/05-odometer.css">
    <link rel="stylesheet" href="../assets/css/06-swiper.min.css">
    <link rel="stylesheet" href="../assets/css/07-animate.min.css">
    <link rel="stylesheet" href="../assets/css/08-custom-animate.css">
    <link rel="stylesheet" href="../assets/css/09-slick.css">
    <link rel="stylesheet" href="../assets/css/10-icomoon.css">
    <link rel="stylesheet" href="../assets/vendor/custom-animate/custom-animate.css">
    <link rel="stylesheet" href="../assets/vendor/jarallax/jarallax.css">
    <link rel="stylesheet" href="../assets/vendor/odometer/odometer.min.css">

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
</head>
<body>
    <div class="page-wrapper">
        <!--Start Main Header One -->
        <header class="main-header main-header-one style4">
            <div id="sticky-header" class="menu-area">
                <div class="container">
                    <div class="main-header-one__inner">

                        <!--Start Main Header one Inner Left -->
                        <div class="main-header-style4__left">
                            <div class="logo-box-one">
                                <a href="../index.php">
                                    <img src="../assets/img/logo.png" alt="Logo">
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
                                                <li class=""><a href="../index.php">Home</a>
                                                </li>
                                                <li class=""><a href="../about.php">About Us</a></li>
                                                <li class=""><a href="../services.php">Services</a>

                                                </li>

                                                <li class="active"><a href="../track.php">Track</a></li>

                                                <li><a href="../contact.php">contacts</a></li>

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
                        <a href="../index.php"><img src="../assets/img/resource/mobile-menu-logo.png" alt="Logo"></a>
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
  <?php 
    if (isset($_POST['search'])) {
?>

<?php 
    $select = mysqli_query($con, "SELECT * FROM addtracking  WHERE tracking_id = '$tracking_pr' ");
    if (mysqli_num_rows($select) > 0) {               
?>

    <!-- Body Start-->
    <div class="content_wrapper">
      <div class="container">
        <div class="section_row">
          <div class="col_7">
            <div class="main_content">
              <div class="mod mod-article">
                <div class="article-icon">


                  <h1>Tracking Shipment &nbsp;

              
                      <a href="print.php?num=<?php echo $user_tracking ?>" target="_blank"  id="order-status" class="default"> Print-Invoice</a>
               
                  </h1>
                </div>
                <div class="clear"></div>


                <div id="article_content_area"><strong>
                    <font size="5">
                      <font face="helvetica">
                        <font size="5" color="#2c2c2c">Tracking No:</font>
                        <font size="5" color="#C40202" face="arial,helvetica,sans-serif"><?php echo $user_tracking ?> </font><br />
                      </font>
                    </font>

                  </strong><br /><br />

                  <?php
                  $stmt = mysqli_prepare($con, "SELECT * FROM shipment_history WHERE tracking_id = ? ORDER BY date DESC, time DESC");
                  mysqli_stmt_bind_param($stmt, "s", $tracking_pr);
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
                  if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                  ?>
                  <ul class="delivered-grid-box">
                    <li>
                      <div class="delivered-left"> <span><strong><?php  echo date('F dS, Y', strtotime($row['date'])); ?></strong>,<br> <?php echo date("G:i A", strtotime($row['time'])); ?></span></div>
                      <span class="d-bulte"><i class="current"></i></span>
                      <div class="delivered-right"> <strong><?php echo $row['remarks'] ?></strong>
                        <br><?php echo $row['updated_by'] ?><br>
                        <?php echo $row['location'] ?><br> <span id="order-status" class="default"><?php echo $row['status'] ?></span>
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
                  <font size="5" color="#2c2c2c">Current Location on Map</font></span>
                  </font><br/>



                  <div align="center">
                    <div style="width: 100%; height: 300px;">
                      <?php
                      $locations = [];
                      $locations[] = $dispatch_location;
                      $stmt_history_map = mysqli_prepare($con, "SELECT * FROM shipment_history WHERE tracking_id = ? ORDER BY date ASC, time ASC");
                      mysqli_stmt_bind_param($stmt_history_map, "s", $tracking_pr);
                      mysqli_stmt_execute($stmt_history_map);
                      $result_history_map = mysqli_stmt_get_result($stmt_history_map);
                      if (mysqli_num_rows($result_history_map) > 0) {
                        while ($row_history = mysqli_fetch_assoc($result_history_map)) {
                          $locations[] = $row_history['location'];
                        }
                      }
                      $locations = array_unique($locations);
                      $origin = array_shift($locations);
                      $destination_map = count($locations) > 0 ? implode('+to:', array_map('urlencode', $locations)) : urlencode($origin);
                      $map_url = "https://maps.google.com/maps?f=d&source=s_d&saddr=" . urlencode($origin) . "&daddr=" . $destination_map . "&output=embed";
                      ?>
                      <iframe class="map" src="<?php echo $map_url; ?>" style="border:0; width: 100%; height: 300px;"></iframe>
                    </div>
                  </div>
                </div>
              </div>
              </article>

            </div>
          </div>






          <div class="col_3">
            <div>

              <center><img class="nav-profile-img mr-2" alt="" src="../uploads/<?php echo $image ?>" alt="photo" style="width:330px; height:150px;" />

                <br />
                <h3>Content of Shipment: <strong><?php echo $package_discription ?></strong></h3>
              </center>

              <br><br />
              <table>
                <tr>
                  <th>Est. Delivery Date :</th>
                  <td><?php echo $estimated_delivery_date ?></td>

                </tr>
                <tr>
                  <th>Origin Area:</th>
                  <td><?php echo $dispatch_location  ?></td>
                </tr>
                <tr>
                  <th>Destination Area:</th>
                  <td><?php echo $destination ?></td>
                </tr>


              </table>


              <br><br />


              <strong>
                <font size="5" color="#C40202" face="arial,helvetica,sans-serif">Sender's Details</font>
              </strong>
              <br />
              <table>
                <tr>
                  <th>Name:</th>
                  <td><?php  echo $sender_name ?></td>

                </tr>

                <tr>
                  <th>Email:</th>
                  <td><?php echo $sender_email ?></td>
                </tr>

                <tr>
                  <th>Address:</th>
                  <td><?php echo $sender_address ?></td>
                </tr>

                <tr>
                  <th>Mobile:</th>
                  <td><?php echo $sender_contact ?></td>

                </tr>

              </table>




              <br><br />


              <strong>
                <font size="5" color="#C40202" face="arial,helvetica,sans-serif">Receiver's Details</font>
              </strong>
              <br />
              <table>
                <tr>
                  <th>Name:</th>
                  <td><?php echo $receiver_name ?></td>

                </tr>

                <tr>
                  <th>Email:</th>
                  <td><?php echo $receiver_email  ?></td>
                </tr>

                <tr>
                  <th>Address:</th>
                  <td><?php echo $receiver_address ?></td>
                </tr>

                <tr>
                  <th>Mobile:</th>
                  <td><?php echo $receiver_contact ?></td>

                </tr>

              </table>



              <br><br />



              </table>

              <br><br />

              <br /><br />



            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Body End -->

    <?php }} ?>

        <!--Start Footer One-->
        <footer class="footer-one">
            <!--Start Footer Middle-->
            <div class="footer-middle footer-middle--two">
                <div class="container">
                    <div class="footer-middle__inner">
                        <div class="footer-logo-box">
                            <img src="../assets/img/logo.png" style="width: 170px;" alt="#">
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
                            <p>© Cargo link 2023 | <a href="../index.php">Cargolink</a>, All Rights Reserved.</p>
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


  <script src="j/jquery.min.js"></script>
  <script src="j/jquery.validate.js"></script>

  <script src="j/bootstrap.min.js"></script>

  <script>
    $(document).ready(function() {
      $(".nav-tabs a").click(function() {
        $(this).tab('show');
      });
    });
  </script>


  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>

  <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0JAyU28GRrRC_o5gXkY_CjjHlX5r5Wds&callback=console.debug&libraries=maps,marker&v=beta">
  </script>

  <script type="text/javascript">
    function initialize() {
      // put latitude and longitude data here
      var latinfo = new google.maps.LatLng(6.6754553, -1.5854323);
      var map = new google.maps.Map(document.getElementById('map'), {
        center: latinfo,
        zoom: 13
      });
      var marker = new google.maps.Marker({
        map: map,
        position: latinfo,
        draggable: false,
        animation: google.maps.Animation.BOUNCE,
        anchorPoint: new google.maps.Point(0, -29)
      });
      var infowindow = new google.maps.InfoWindow();
      google.maps.event.addListener(marker, 'click', function() {
        var iwContent = '<div id="pop_window">' + '<div><b>Location</b> : Connaught Place, New Delhi</div></div>';
        // put content to the infowindow
        infowindow.setContent(iwContent);
        // show infowindow in the google map and at the current marker location
        infowindow.open(map, marker);
      });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
  </script> 




</body>

</html>