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
    $stmt = mysqli_prepare($con, "SELECT * FROM addtracking WHERE tracking_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $tracking_pr);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
      $rows = mysqli_fetch_assoc($result);
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
      $coordinates = json_decode($rows['coordinates'], true);
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
<!DOCTYPE html>

<html dir="ltr" lang="en">

<head>
  <meta charset="utf-8">

  <meta name="keywords" content="#1 Best Courier & Logistics Company in UK">
  <meta name="description" content="#1 Best Courier & Logistics Company in UK">
  <title>Tracking Result</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script type="" src="j/jquery.js"> </script>
  <script type="" src="j/jquery-ui.custom.js"> </script>
  <link href="j/jquery-ui.custom.js" media="screen" rel="stylesheet" type="text/css">
  <script type="" src="j/jquery.idTabs.min.js"></script>
  <link href="c/template.css" media="screen" rel="stylesheet" type="text/css">
  <link href="c/general.css" media="screen" rel="stylesheet" type="text/css">
  <script type="" src="j/uploader.js"></script>
  <link href="c/pagination.css" media="screen" rel="stylesheet" type="text/css">
  <link href="c/pagination.css" media="screen" rel="stylesheet" type="text/css">
  <link href="c/menu.css" media="screen" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="c/responsives.css">
  <link href="images/favicon.png" rel="shortcut icon">
  <link rel="stylesheet" type="text/css" href="c/styl.css" media="all">
  <link rel="icon" href="images/favicon.png" type="image/x-icon">

  <!-- responsive css -->

  <link rel="stylesheet" type="text/css" href="c/custom-style.css">
  <link rel="stylesheet" type="text/css" href="c/carousel.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script type="text/javascript" src="process/jquery.min.js"></script>
  <script type="text/javascript" src="process/jquery-ui.min.js"></script>
  <script type="text/javascript" src="process/bootstrap.min.js"></script>
  <script type="text/javascript" src="process/carousel.js"></script>
  <script type="text/javascript" src="process/common.js"></script>


  <style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }
  </style>
  <style>
    .m-btm {
      text-align: center;
      margin-bottom: 35px;
    }

    .mtn {
      text-align: center;
    }

    .d-bl {
      display: block;
      margin-bottom: 25px;
    }

    #btnal {
      background: teal;
      color: aqua;
      border-radius: 5px;
      padding: 0.5rem;
      font-size: 0.83rem;
      cursor: pointer;
    }

    #btn {
      background: teal;
      color: aqua;
      border-radius: 5px;
      padding: 0.5rem;
      font-size: 0.83rem;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div id="wrapper">

    <!-- Tracker End-->

    <!-- Banner Start -->
    <div id="banner">
      <div class="container">
        <div class="bg"></div>
      </div>

      <!-- Tracker Start-->
      <div class="block block-tracker">
        <div class="h_container">
          <form action="tracking.php" method="post" id="userForm" onSubmit="return validate()">
            <p>TRACK YOUR SHIPMENT

              <input type="text" name="search_P" id="Consignment" placeholder="Enter Tracking number"  />
              <input type="submit" name="search" id="send" value="TRACK NOW" />
            </p>
          </form>
        </div>
      </div>
    </div>
    <!-- Banner End -->

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
                  $stmt = mysqli_prepare($con, "SELECT * FROM track_update  WHERE track_num = ? ORDER BY id DESC ");
                  mysqli_stmt_bind_param($stmt, "s", $tracking_pr);
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
                  if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {

                  switch ($row['status']) {
                      case 'active':
                          $class = "delivered-grid-box";
                          break;
                      default:
                          $class = "";
                          break;
                   }
?>
                  <ul class="delivered-grid-box">
                    <li>
                      <div class="delivered-left"> <span><strong><?php  echo date('F dS, Y', strtotime($row['date'])); ?></strong>,<br> <?php echo date("G:i A", strtotime($row['time'])); ?></span></div>
                      <span class="d-bulte"><i class="current"></i></span>
                      <div class="delivered-right"> <strong><?php echo $row['note'] ?></strong>
                        <br>Customer<br>
                        <?php echo $row['current_location'] ?><br> <span id="order-status" class="default"><?php echo $row['status'] ?></span>
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
                    <div id="map" style="width: 100%; height: 300px;"></div>
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

    <!-- Footer Start -->

    <footer id="footer">
      <div class="container">
        <div class="links-container">


          <div class="social">
            Always stay connected with us.. <br><br>
            <a href="http://www.facebook.com/" target="_blank"><img src="image/facebook.png" width="20" height="20" border="0" title="Facebook"></a>
            <a href="http://www.twitter.com/" target="_blank"><img src="image/twitter.png" width="20" height="20" border="0" title="Twitter"></a>
            <a href="http://www.youtube.com/" target="_blank"><img src="image/youtube.png" width="20" height="20" border="0" title="Youtube"></a>
            <a href="http://www.flickr.com/" target="_blank"><img src="image/flickr.png" width="20" height="20" border="0" title="Flickr"></a>
            <a href="http://www.delicious.com/" target="_blank"><img src="image/delicious.png" width="20" height="20" border="0" title="Delicious"></a>
            <a href="http://www.stumbleupon.com/" target="_blank"><img src="image/stumbleupon.png" width="20" height="20" border="0" title="Stumbleupon"></a>
            <a href="http://www.digg.com/" target="_blank"><img src="image/digg.png" width="20" height="20" border="0" title="Digg"></a>
            <a href="http://feeds.feedburner.com/" target="_blank"><img src="image/rss.png" width="20" height="20" border="0" title="RSS"></a>
            <a href="https://plus.google.com/" target="_blank"><img src="image/google-plus-one.png" width="32" height="20" border="0" title="Google +1"></a>
          </div>

          <div class="copyright clear">
            Copyright &copy 2023 All Rights Reserved.

          </div>
        </div>

      </div>
    </footer>

  </div>
  <div class="go-top"><a href="#top" id="scroll-top">Top</a></div>
  <script type="text/javascript" src="j/scroll.js">
  </script>


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

  <script>
    var map = L.map('map').setView([<?php echo $coordinates['dispatch']['lat'] ?? 0; ?>, <?php echo $coordinates['dispatch']['lon'] ?? 0; ?>], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var latlngs = [];
    <?php if (!empty($coordinates['dispatch'])) : ?>
      var dispatchMarker = L.marker([<?php echo $coordinates['dispatch']['lat']; ?>, <?php echo $coordinates['dispatch']['lon']; ?>]).addTo(map)
        .bindPopup('<b>Dispatch Location</b><br><?php echo $dispatch_location; ?>')
        .openPopup();
      latlngs.push([<?php echo $coordinates['dispatch']['lat']; ?>, <?php echo $coordinates['dispatch']['lon']; ?>]);
    <?php endif; ?>

    <?php if (!empty($coordinates['history'])) : ?>
      <?php foreach ($coordinates['history'] as $history) : ?>
        var historyMarker = L.marker([<?php echo $history['lat']; ?>, <?php echo $history['lon']; ?>]).addTo(map)
          .bindPopup('<b>History Location</b><br><?php echo $history['name']; ?>');
        latlngs.push([<?php echo $history['lat']; ?>, <?php echo $history['lon']; ?>]);
      <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($coordinates['destination'])) : ?>
      var destinationMarker = L.marker([<?php echo $coordinates['destination']['lat']; ?>, <?php echo $coordinates['destination']['lon']; ?>]).addTo(map)
        .bindPopup('<b>Destination Location</b><br><?php echo $destination; ?>');
      latlngs.push([<?php echo $coordinates['destination']['lat']; ?>, <?php echo $coordinates['destination']['lon']; ?>]);
    <?php endif; ?>

    if (latlngs.length > 0) {
      var polyline = L.polyline(latlngs, {
        color: 'blue'
      }).addTo(map);
      map.fitBounds(polyline.getBounds());
    }
  </script>
</body>

</html>