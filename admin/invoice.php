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
        $image = $row['image'];
        $receiver_name = $row['receiver_name'];
        $receiver_contact = $row['receiver_contact'];
        $receiver_email = $row['receiver_email'];
        $receiver_address = $row['receiver_address'];
        $package_discription = $row['package_discription'];
        $dispach_date = $row['dispach_date'];
        $destination = $row['destination'];
        $estimated_delivery_date = $row['estimated_delivery_date'];
        $shipment_mode = $row['shipment_mode'];
        $quantity = $row['quantity'];
        $delivery_time = $row ['delivery_time'];
        $date_added = $row['date_added'];
    }

    $sqls = mysqli_query($con, "SELECT * FROM track_update  WHERE track_num = '$post_id' ORDER BY id DESC LIMIT 1  ");
    if (mysqli_num_rows($sqls) > 0 ) {
        $rows = mysqli_fetch_assoc($sqls);
        $invoice_sub_total = $rows['invoice_sub_total'];
        $discounts = $rows['discount'];
        $tax = $rows['tax'];
        $invoice_total = $rows['invoice_total'];
    }
}

?>


<!DOCTYPE html>
<html lang="zxx" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Cargoflow Invoice</title>
	<link href="assets/images/favicon/icon.png" rel="icon">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/custom.css">
	<link rel="stylesheet" href="css/media-query.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
	<!--Invoice wrap start here -->
	<div class="invoice_wrap agency1">
		<div class="invoice-container">
			<div class="invoice-content-wrap" id="download_section">
				<!--Header start Here -->
				<header class="invoice-header " id="invo_header">
					<div class="invoice-logo-content bg-black ">
						<div class="invoice-logo" style="font-size: 15px;">
							<div class="agency-logo">
								<!-- <a href="#"><img src="image/logo.png" alt="logo"></a> -->
                                <h2 style="color: white" >Express Delivery</h2>
							</div>
						</div>
						<div class="invo-head-content">
							<div><h1 class="invoice-txt" style="font-size: 20px;">INVOICE</h1></div>
						</div>
					</div>
					<div class="container">
						<div class="invoice-agency-details">
							<!-- <div class="invo-head-wrap">
								<div class="color-light-black font-md wid-40">Invoice No:</div>
								<div class="font-md-grey color-grey wid-20">#DI56789</div>
							</div>
							<div class="invo-head-wrap invoi-date-wrap invoi-date-wrap-agency">
								<div class="color-light-black font-md wid-40">Invoice Date:</div>
								<div class="font-md-grey color-grey wid-20">15/12/2024</div>
							</div> -->
                            <h6 style="text-align: center;">SHIPMENT CONFIRMATION FOR ORDER No. <b style="font-size: 20px;"><?php echo $tracking_id ?></b> </h6> 
                            <h6 style="text-align: center;">You have created an order for a shipment with the following details</h6>
						</div>
					</div>
				</header>
				<!--Header end Here -->
				<!--Invoice content start here -->
				<section class="agency-service-content" id="agency_service">
					<div class="container">
						<div class="invoice-owner-conte-wrap pt-40">
						<div class="invo-to-wrap">
								<div class="invoice-to-content">
									<p class="font-md color-light-black" style="font-size: 15px;">Invoice From:</p>
									<h2 class="font-lg color-blue pt-10" style="font-size: 15px;"><?php echo $sender_name ?></h2>
									<p class="font-md-grey color-grey pt-10" style="font-size: 15px;"><?php  echo $sender_address ?></p>
								</div>
							</div>
							<div class="invo-pay-to-wrap">
								<div class="invoice-pay-content">
									<p class="font-md color-light-black" style="font-size: 15px;">Invoice To:</p>
									<h2 class="font-lg color-blue pt-10" style="font-size: 15px;"><?php  echo $receiver_name ?></h2>
									<p class="font-md-grey color-grey pt-10" style="font-size: 15px;"><?php echo $receiver_address ?></p>
								</div>
							</div>
						</div>
						<!--Invoice owner name content End -->
						<!--Invoice table data start here -->
						<div class="table-wrapper agency-service-table pt-32">
							<table class="invoice-table agency-table">
								<thead>
									<tr class="invo-tb-header bg-black">
										<th class="serv-wid pl-10 font-md">Name of Package</th>
										<th class="pric-wid font-md">Date created</th>
										<th class="tota-wid pr-10 font-md text-right ">Date of Dispach</th>
										<th class="tota-wid pr-10 font-md text-right ">Time of Arrival</th>
									</tr>
								</thead>
								<tbody class="invo-tb-body">
									<tr class="invo-tb-row">
										<td class="font-sm pl-10"><?php echo $package_discription  ?></td>
										<td class="font-sm pl-10"><?php echo $date_added ?></td>
										<td class="font-sm pl-10"><?php echo $dispach_date ?></td>
										<td class="font-sm text-right pr-10"><?php echo $delivery_time ?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<!--Invoice table data end here -->
						<!--Invoice additional info start here -->
						<div class="invo-addition-wrap pt-20">
							<div class="invo-add-info-content">
								<!-- <h3 class="font-md color-light-black">Additional Information:</h3>
								<p class="font-sm pt-10">This is computer generated receipt and does not require physical signature.</p> -->
							</div>
							<div class="invo-bill-total width-30">
								<table class="invo-total-table">
									<tbody>
										<tr>
											<td class="font-md color-light-black ">Shipping Cost</td>
											<td class="font-md-grey color-grey text-right pr-10 ">$<?php echo $invoice_sub_total  ?></td>
										</tr>
										<tr>
											<td class="font-md color-light-black">Clearance Cost </td>
											<td class="font-md-grey color-grey text-right pr-10 ">$<?php echo $discounts  ?></td>
										</tr>

										<tr>
											<td class="font-md color-light-black">Tax</td>
											<td class="font-md-grey color-grey text-right pr-10 ">$<?php echo $tax ?> </td>
										</tr>
									 
										
                                     
                                        <tr class="invo-grand-total">
											<td class="font-18-700 padding">Invoice total</td>
											<td class="font-18-500 text-right pr-10 ">$<?php echo $invoice_total ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!--Invoice additional info end here -->
					</div> <br> <br>
					<!--Contact details start here -->
			
                    <style>
        #con {
            display: flex;
            flex-wrap: nowrap; 
        }

        @media (max-width: 767px) {
            .col-md-3 {
            flex: 0 0 20%; 
            padding: 30px;
            }

           .images {
            max-width: 100%;
            height: auto;
          }
        }
    </style>

   <div class="con">
    <div class="container" id="con">
            <div class="col-md-3">
                <img class="images" src="image/image1.png" alt="" width="60" height="80">
            </div>

            <div class="col-md-3">
                <img class="images" src="image/image2.png" alt="" width="60" height="80">
            </div>

            <div class="col-md-3">
                <img class="images" src="image/image3.png" alt="" width="60" height="80">
            </div>

            <div class="col-md-3">
                <img class="images" src="image/image4.png" alt="" width="60" height="80">
            </div>
        </div>
   </div>
					<!--Contact details end here -->
				</section>
				<!--Invoice content end here -->
			</div>
			<!--Bottom content start here -->
			<section class="agency-bottom-content d-print-none" id="agency_bottom">
				<!--Print-download content start here -->
		
				<!--Print-download content end here -->
				<!--Note content start -->
				<div class="invo-note-wrap">
					<div class="note-title">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_8_240)"><path d="M14 3V7C14 7.26522 14.1054 7.51957 14.2929 7.70711C14.4804 7.89464 14.7348 8 15 8H19" stroke="#12151C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 21H7C6.46957 21 5.96086 20.7893 5.58579 20.4142C5.21071 20.0391 5 19.5304 5 19V5C5 4.46957 5.21071 3.96086 5.58579 3.58579C5.96086 3.21071 6.46957 3 7 3H14L19 8V19C19 19.5304 18.7893 20.0391 18.4142 20.4142C18.0391 20.7893 17.5304 21 17 21Z" stroke="#12151C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 7H10" stroke="#12151C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 13H15" stroke="#12151C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M13 17H15" stroke="#12151C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_8_240"><rect width="24" height="24" fill="white"/>
						</clipPath></defs></svg>
						<span class="font-md color-light-black">Note:</span>
					</div>
					<h3 class="font-md-grey color-grey note-desc">Agreement: This is to cenrtify that the consigment described in this slip form the 'Sender' and has accepted to deliver it to 'Reciver' to the address given by the condigner. This parcel is carried under Call Speed deliveries. This agreement herein is valid, correct and blinding on the parties. Alteration on this Airway Bill of Cell Sepend after it has been duly issused and accepted renders this parcel valueless, null and void.  </h3>
				</div>
				<!--Note content end -->
			</section> 
			<!--Bottom content end here -->
		</div>
	</div>

<!-- <p style="text-align: center;">
    <a href="javascript:window.print()" class="print-btn btn btn-info">
        <span class="inter-700 medium-font">Print</span>
   </a>
</p> -->
            <section class="agency-bottom-content agency-bottom-content-travel d-print-none" id="agency_bottom">
				<div class="invo-buttons-wrap">
                    <div class="invo-print-btn invo-btns">
						<a href="javascript:window.print()" class="btn btn-info">
							<span class="inter-700 medium-font">Print</span>
						</a>
					</div>
                </div>
            </div>

	<!--Invoice wrap End here -->
	<script src="js/jquery.min.js"></script> 
	<script src="js/jspdf.min.js"></script>
	<script src="js/html2canvas.min.js"></script>
	<script src="js/custom.js"></script> 
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>