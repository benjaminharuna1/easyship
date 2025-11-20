<?php
 
include '../db.php'; 
include '../functions.php';

if (isset($_GET['num']) &&  $_GET['num'] !="") {
    $post_id = $_GET['num'];

    $sql = mysqli_query($con, "SELECT * FROM addtracking WHERE tracking_id = '$post_id' ");
    if (mysqli_num_rows($sql) > 0 ) {
        $row = mysqli_fetch_assoc($sql);
        $tracking_id = $row['tracking_id'];
        $sender_name = $row['sender_name'];
        $sender_contact = $row ['sender_contact'];
        $sender_email = $row['sender_email'];
        $sender_address = $row['sender_address'];  
        $status = $row['status'];
        $dispatch_location = $row['dispatch_location'];                     
        $carrier = $row['carrier'];
        $carrier_refrence_number = $row['carrier_refrence_number'];
        $weight = $row['weight'];
        $payment_mode = $row['payment_mode'];
        $total_cost = $row['total_cost'];
        $image = $row['image'];
        $receiver_name = $row['receiver_name'];
        $receiver_contact = $row['receiver_contact'];
        $receiver_email = $row['receiver_email'];
        $receiver_address = $row['receiver_address'];
        $package_discription = $row['package_discription'];
        $dispatch_date = $row['dispatch_date'];
        $destination = $row['destination'];
        $estimated_delivery_date = $row['estimated_delivery_date'];
        $shipment_mode = $row['shipment_mode'];
        $quantity = $row['quantity'];
        $delivery_time = $row ['delivery_time'];
        $date_added = $row['date_added'];
    }

    $stmt_items = mysqli_prepare($con, "SELECT * FROM package_items WHERE tracking_id = ?");
    mysqli_stmt_bind_param($stmt_items, "s", $post_id);
    mysqli_stmt_execute($stmt_items);
    $result_items = mysqli_stmt_get_result($stmt_items);
    $package_items = mysqli_fetch_all($result_items, MYSQLI_ASSOC);

    $sqls = mysqli_query($con, "SELECT * FROM track_update  WHERE track_num = '$post_id' ORDER BY id DESC LIMIT 1  ");
    if (mysqli_num_rows($sqls) > 0 ) {
        $rows = mysqli_fetch_assoc($sqls);
        $invoice_sub_total = $rows['invoice_sub_total'];
        $discounts = $rows['discount'];
        $tax = $rows['tax'];
        $invoice_total = $rows['invoice_total'];
    }

    $sqlss = mysqli_query($con, "SELECT * FROM  setting  ORDER BY id DESC LIMIT 1  ");
    if (mysqli_num_rows($sqlss) > 0 ) {
        $rowss = mysqli_fetch_assoc($sqlss);
        $email = $rowss['email_address'];
        $site_url = $rowss['site_url'];
        $sitename = $rowss['sitename'];

    }
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
			  
			  <h3 style="color:red;"><strong> Tracking Number:  <?php echo $tracking_id ?></strong>
			  </h3></span>
			  
            </h2>
          </div><!-- /.col -->
        </div>
        
					

         
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
			   <center> 
			       <strong style="color:green;"><?php echo $sitename ?><br>
Email: <?php echo $email  ?><br>
Company Website: <?php echo $site_url ?></strong></center>
            </h2>
          </div><!-- /.col -->
        </div>
        
        
         <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            <strong style="color:blue;">FROM (SENDER)</strong>
            <address>
              <h3><strong style="color:green;"><?php echo $sender_name ?></strong></h3><br>

              <b>Address:</b>&nbsp;&nbsp;<?php echo $sender_address ?><br/>
			  <b>Phone No:</b>&nbsp;&nbsp;<?php echo $sender_contact ?><br/>
			  <b>Origin </b> &nbsp;&nbsp;<?php echo $dispatch_location ?>   </address>
          </div><!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <strong style="color:blue;">TO (CONSIGNEE)</strong>
            <address>
              <h3><strong style="color:green;">&nbsp;&nbsp;<?php echo $receiver_name ?></strong></h3><br>
               
			  <b>Address:</b>&nbsp;&nbsp;<?php echo $receiver_address ?><br/>
              <b>Phone:</b> &nbsp;&nbsp;<?php echo $receiver_contact ?><br/>
			 
              <b>Destination</b>&nbsp;&nbsp;<?php  echo $destination ?>   </address>
          </div><!-- /.col -->
          <div class="col-sm-4 invoice-col">
		  <table>
                                        	<tr>
                                                <td>
                                                    <center>
                                                        <img src="image/barcode810e.png" alt="testing" /><br>
                                                        <strong><?php echo $tracking_id ?></strong><br>
                                                    </center>
                                                </td>
                                                
                                            </tr>
                                        </table>
			<br/>
            <b>Order ID:</b>&nbsp;&nbsp;<?php echo $tracking_id  ?><br/>
            <b>Est. Delivery Date:</b>&nbsp;<?php echo $estimated_delivery_date  ?><br/>
			<b>Payment Mode:</b> <small class="label label-danger"><i class="fa fa-money"></i>&nbsp;&nbsp;<?php echo $payment_mode   ?></small><br/> 
			<b>Total Amount Paid:</b>&nbsp;<?php echo $total_cost   ?><br/>
			<b>Mode of Transport:</b>&nbsp;<?php echo $shipment_mode   ?><br/>
			
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
