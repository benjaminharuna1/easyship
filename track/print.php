<?php
 
include '../db.php'; 
include '../functions.php';

if (isset($_GET['num']) &&  $_GET['num'] !="") {
    $post_id = text_input($_GET['num']);

    // Fetch all site settings
    $settings_stmt = mysqli_prepare($con, "SELECT * FROM setting WHERE id = 1");
    mysqli_stmt_execute($settings_stmt);
    $settings_result = mysqli_stmt_get_result($settings_stmt);
    $settings = mysqli_fetch_assoc($settings_result);

    // Fetch main tracking data
    $stmt = mysqli_prepare($con, "SELECT * FROM addtracking WHERE tracking_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Fetch package items
    $stmt_items = mysqli_prepare($con, "SELECT * FROM package_items WHERE tracking_id = ?");
    mysqli_stmt_bind_param($stmt_items, "s", $post_id);
    mysqli_stmt_execute($stmt_items);
    $result_items = mysqli_stmt_get_result($stmt_items);
    $package_items = mysqli_fetch_all($result_items, MYSQLI_ASSOC);
}



?>

<!DOCTYPE html>
<html>
  
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <title>Print Invoice</title>
	
	<!-- Define Charset -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<!-- Page Description and Author -->
	<meta name="description" content="De-Eagle Courier & Logistics"/>
	<meta name="keywords" content="Courier Delivery & Logistic Company" />
	<meta name="author" content="Viz">	
	
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="css/bootstrap2.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="css/print-invoice.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="barcode.html"></script>
	
	
<style>
	    
	    #background{
    position:absolute;
    z-index:0; 
    display:block;
    min-height:70%; Z
    min-width:70%; 
}

#content{X
    position:absolute;
    z-index:1;
}

#bg-text
{
    color:grey;
    font-size:36px;
    transform:rotate(300deg);
    -webkit-transform:rotate(300deg);
}
	    
	</style>
	
	
 


  </head>
  <body  style="background-color:teal;"  onload="window.print();">
      
      
	
	
    <div class="wrapper" id="background"> <p id="bg-text">Certified True Copy</p>

      <!-- Main content -->
      <section class="invoice" >
        <!-- title row -->
        <div class="row"  >
          <div class="col-xs-12">
            <h2 class="page-header">
			  <span><img src="image/logo.png"
                                alt="Air shipment tracking system, Sea shipment tracking system, Cargo tracking system"
                                title="Worldwide ExpressForce & shpiment tracking system" width="190" height="85" border="0"> 
			  
			  
		
			  <img class="pull-right"  src="image/banner.png" alt=""  height="185"/> 
			  
			  <div class="site-details" style="text-align: left; margin-top: 10px; color: black; font-size: 12px;">
                <strong><?php echo htmlspecialchars($settings['sitename']); ?></strong><br>
                <?php echo nl2br(htmlspecialchars($settings['site_address'])); ?><br>
                <?php echo htmlspecialchars($settings['email_address']); ?><br>
                <a href="<?php echo htmlspecialchars($settings['site_url']); ?>"><?php echo htmlspecialchars($settings['site_url']); ?></a>
              </div>

			  <h3 style="color:red;"><strong> Tracking Number:  <?php echo htmlspecialchars($row['tracking_id']); ?></strong>
			  </h3></span>
			  
            </h2>
          </div><!-- /.col -->
        </div>
        
        
         <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            <strong style="color:blue;">FROM (SENDER)</strong>
            <address>
              <h3><strong style="color:green;"><?php echo htmlspecialchars($row['sender_name']); ?></strong></h3><br>

              <b>Address:</b>&nbsp;&nbsp;<?php echo htmlspecialchars($row['sender_address']); ?><br/>
			  <b>Phone No:</b>&nbsp;&nbsp;<?php echo htmlspecialchars($row['sender_contact']); ?><br/>
			  <b>Origin </b> &nbsp;&nbsp;<?php echo htmlspecialchars($row['dispatch_location']); ?>   </address>
          </div><!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <strong style="color:blue;">TO (CONSIGNEE)</strong>
            <address>
              <h3><strong style="color:green;">&nbsp;&nbsp;<?php echo htmlspecialchars($row['receiver_name']); ?></strong></h3><br>
               
			  <b>Address:</b>&nbsp;&nbsp;<?php echo htmlspecialchars($row['receiver_address']); ?><br/>
              <b>Phone:</b> &nbsp;&nbsp;<?php echo htmlspecialchars($row['receiver_contact']); ?><br/>
			 
              <b>Destination</b>&nbsp;&nbsp;<?php echo htmlspecialchars($row['destination']); ?>   </address>
          </div><!-- /.col -->
          <div class="col-sm-4 invoice-col">
		  <table>
                                        	<tr>
                                                <td>
                                                    <center>
                                                        <img src="image/barcode810e.png" alt="testing" /><br>
                                                        <strong><?php echo htmlspecialchars($row['tracking_id']); ?></strong><br>
                                                    </center>
                                                </td>
                                                
                                            </tr>
                                        </table>
			<br/>
            <b>Order ID:</b>&nbsp;&nbsp;<?php echo htmlspecialchars($row['tracking_id']); ?><br/>
            <b>Est. Delivery Date:</b>&nbsp;<?php echo htmlspecialchars($row['estimated_delivery_date']); ?><br/>
			<b>Payment Mode:</b> <small class="label label-danger"><i class="fa fa-money"></i>&nbsp;&nbsp;<?php echo htmlspecialchars($row['payment_mode']); ?></small><br/>
			<b>Total Amount Paid:</b>&nbsp;<?php echo htmlspecialchars($settings['site_currency'] ?? '$'); ?><?php echo number_format($row['total_cost'], 2); ?><br/>
			<b>Mode of Transport:</b>&nbsp;<?php echo htmlspecialchars($row['shipment_mode']); ?><br/>
			
          </div><!-- /.col -->		 
        </div><!-- /.row -->


        <!-- Package Items Table -->
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
                        <?php
                            $sn = 1;
                            foreach ($package_items as $item) :
                        ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo $item['piece_type']; ?></td>
                                <td><?php echo $item['description']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
		
		      
		
		<br>
		<br>
        <div class="row">
          <!-- accepted payments column -->
          <div class="col-xs-6">
            <p class="lead"><strong>Payment Methods:</strong></p>
            <img src="image/securepayment.png" alt="Methods payments" /> 
           
         
          </div>
          
          <div class="col-xs-6">
            <p class="lead"><strong>Official Stamp/ Wednesday, 27.Mar.2024 </strong></p>
            <img src="image/stamp1.png" alt="" height="100" />           
             
          </div>
          
          
          
          
        </div><!-- /.row -->
      </section><!-- /.content -->
    </div><!-- ./wrapper -->

    <!-- AdminLTE App -->
    <script src="js/app.min.js" type="text/javascript"></script>
  </body>

</html>
