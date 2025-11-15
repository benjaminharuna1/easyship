<?php 
	include 'header.php';

		if (isset($_GET['edit'])) {
	 	$edit_id = $_GET['edit'];

			 $sql = mysqli_query($con, "SELECT * FROM track_update WHERE track_num = '$edit_id' ORDER BY id DESC ");
			 if (mysqli_num_rows($sql) > 0 ) {
			 
			         
			    }
			}


 ?>


		<div class="page-wrapper">
			<div class="page-content">
							 
							<h1>Data Page</h1>
							<div class="table-responsive">
								<table class="table align-middle mb-0">
									<thead class="table-light">
										<tr>
											<th>#</th>
											<!-- <th>Destinaation</th> -->
											<th>current location</th>
											<th>Status</th>
											<th>Date</th>
											<th>Time</th>
											<th style="width:200px">Update message</th>
											<th>Updated At</th>
								
											

										</tr>
									</thead>
									<tbody>
								   <?php
					                        $i = 0;
					                	      while ($row = mysqli_fetch_assoc($sql)) {
					                			$i++
				                   ?>
										<tr>
											<td><?php echo $i; ?></td>
											<td> <?php  echo $row['current_location']  ?></td>
											<td><?php  echo $row['status']  ?></td>
											<td><?php  echo $row['date']  ?></td>
											<td><?php  echo $row['time']   ?></td>
											<td><?php  echo $row['note']  ?></td>
											<td><?php echo $row['updated_at']   ?></td>
											


										
								     <?php
								           }
								        
                                     ?>

									</tbody>
								</table>
							</div>
						</div>
					</div>
			</div>
		</div>
		<!--end page wrapper -->