<?php   
include '../db.php'; 
include '../functions.php';

if (isset($_GET['num']) &&  $_GET['num'] !="") {
    $post_id = text_input($_GET['num']);

    $stmt = mysqli_prepare($con, "SELECT * FROM addtracking WHERE tracking_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0 ) {
        $row = mysqli_fetch_assoc($result);
    }

    $stmt = mysqli_prepare($con, "SELECT * FROM package_items WHERE tracking_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $post_id);
    mysqli_stmt_execute($stmt);
    $package_items_result = mysqli_stmt_get_result($stmt);
    $package_items = mysqli_fetch_all($package_items_result, MYSQLI_ASSOC);

    $stmt = mysqli_prepare($con, "SELECT * FROM shipment_history WHERE tracking_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $post_id);
    mysqli_stmt_execute($stmt);
    $shipment_history_result = mysqli_stmt_get_result($stmt);
    $shipment_history = mysqli_fetch_all($shipment_history_result, MYSQLI_ASSOC);
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
										<th class="serv-wid pl-10 font-md">Description</th>
										<th class="pric-wid font-md">Value</th>
									</tr>
								</thead>
								<tbody class="invo-tb-body">
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Type of Shipment</td>
										<td class="font-sm pl-10"><?php echo $row['type_of_shipment']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Payment Mode</td>
										<td class="font-sm pl-10"><?php echo $row['payment_mode']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Carrier</td>
										<td class="font-sm pl-10"><?php echo $row['carrier']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Courier</td>
										<td class="font-sm pl-10"><?php echo $row['courier']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Mode</td>
										<td class="font-sm pl-10"><?php echo $row['shipment_mode']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Origin</td>
										<td class="font-sm pl-10"><?php echo $row['dispatch_location']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Destination</td>
										<td class="font-sm pl-10"><?php echo $row['destination']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Weight</td>
										<td class="font-sm pl-10"><?php echo $row['weight']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Packages count</td>
										<td class="font-sm pl-10"><?php echo $row['quantity']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Product description</td>
										<td class="font-sm pl-10"><?php echo $row['package_discription']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Total Freight</td>
										<td class="font-sm pl-10"><?php echo $row['total_freight']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Carrier Reference No.</td>
										<td class="font-sm pl-10"><?php echo $row['carrier_refrence_number']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Departure Time</td>
										<td class="font-sm pl-10"><?php echo $row['departure_time']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Pickup Date</td>
										<td class="font-sm pl-10"><?php echo $row['dispach_date']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Pickup Time</td>
										<td class="font-sm pl-10"><?php echo $row['delivery_time']; ?></td>
									</tr>
									<tr class="invo-tb-row">
										<td class="font-sm pl-10">Expected Delivery Date</td>
										<td class="font-sm pl-10"><?php echo $row['estimated_delivery_date']; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<!--Invoice table data end here -->
						<!--Invoice table data start here -->
						<div class="table-wrapper agency-service-table pt-32">
							<h3 class="font-md color-light-black">Package Items</h3>
							<table class="invoice-table agency-table">
								<thead>
									<tr class="invo-tb-header bg-black">
										<th class="serv-wid pl-10 font-md">Quantity</th>
										<th class="pric-wid font-md">Piece Type</th>
										<th class="tota-wid pr-10 font-md text-right ">Description</th>
										<th class="tota-wid pr-10 font-md text-right ">Length (cm)</th>
										<th class="tota-wid pr-10 font-md text-right ">Width (cm)</th>
										<th class="tota-wid pr-10 font-md text-right ">Height (cm)</th>
										<th class="tota-wid pr-10 font-md text-right ">Weight (kg)</th>
									</tr>
								</thead>
								<tbody class="invo-tb-body">
									<?php foreach ($package_items as $item) : ?>
										<tr class="invo-tb-row">
											<td class="font-sm pl-10"><?php echo $item['quantity']; ?></td>
											<td class="font-sm pl-10"><?php echo $item['piece_type']; ?></td>
											<td class="font-sm pl-10"><?php echo $item['description']; ?></td>
											<td class="font-sm text-right pr-10"><?php echo $item['length']; ?></td>
											<td class="font-sm text-right pr-10"><?php echo $item['width']; ?></td>
											<td class="font-sm text-right pr-10"><?php echo $item['height']; ?></td>
											<td class="font-sm text-right pr-10"><?php echo $item['weight']; ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<!--Invoice table data end here -->
						<!--Invoice table data start here -->
						<div class="table-wrapper agency-service-table pt-32">
							<h3 class="font-md color-light-black">Shipment History</h3>
							<table class="invoice-table agency-table">
								<thead>
									<tr class="invo-tb-header bg-black">
										<th class="serv-wid pl-10 font-md">Date</th>
										<th class="pric-wid font-md">Time</th>
										<th class="tota-wid pr-10 font-md text-right ">Location</th>
										<th class="tota-wid pr-10 font-md text-right ">Status</th>
										<th class="tota-wid pr-10 font-md text-right ">Updated By</th>
										<th class="tota-wid pr-10 font-md text-right ">Remarks</th>
									</tr>
								</thead>
								<tbody class="invo-tb-body">
									<?php foreach ($shipment_history as $history) : ?>
										<tr class="invo-tb-row">
											<td class="font-sm pl-10"><?php echo $history['date']; ?></td>
											<td class="font-sm pl-10"><?php echo $history['time']; ?></td>
											<td class="font-sm pl-10"><?php echo $history['location']; ?></td>
											<td class="font-sm text-right pr-10"><?php echo $history['status']; ?></td>
											<td class="font-sm text-right pr-10"><?php echo $history['updated_by']; ?></td>
											<td class="font-sm text-right pr-10"><?php echo $history['remarks']; ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<!--Invoice table data end here -->
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