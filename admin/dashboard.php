<?php
include 'header.php'; 
	if (isset($_GET['delete'])) {
		$id =  $_GET['delete'];
		$sql = mysqli_query($con, "DELETE FROM addtracking WHERE tracking_id = '$id' ");
		if ($sql) {
			// header('location: dashboard.php');
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
											<th>Package Image</th>
											<th>Package name</th>
											<th>Tracking Number</th>
											<th>Status</th>
											<th>Date Added</th>
											<th>Edit</th>
											<th>Delete</th>
											<th>Copy</th>
											<th>View details</th>
											<th>View update</th>
											<th>Print Reciept</th>
											
										</tr>
									</thead>
									<tbody>
										<?php
										   $i = 0;
										     $select = mysqli_query($con, "SELECT * FROM addtracking ");
											    if (mysqli_num_rows($select) > 0) {
												while ($row = mysqli_fetch_assoc($select)) {
												$id = $row['id'];
												$image = $row['image'];
												$productname = $row ['package_discription'];
												$status = $row['status'];
												$dateAdded = $row['date_added'];  
												$tracking = $row['tracking_id'];  
											$i++                        
										?>				
								        <form method="POST" action="dashboard.php">
										   <tr>
											    <td><?php echo $i  ?></td>
											    <td>
												  <img src="../uploads/<?php echo $image ?>" alt="" width="100" height="60">	
											    </td>
											 
										        <td>  
												    <div class="ms-2">
														<h6 class="mb-1 font-14"><?php echo $productname  ?></h6>
												    </div>
											    </td>
											    <td><?php echo $tracking  ?></td>
											    <td><?php echo $status  ?></td>
											    <td><?php echo $dateAdded  ?></td>
											    <td>
												   <a class="badge rounded-pill bg-primary p-2 text-white w-100" href="edit.php?edit=<?php echo $tracking  ?>">Update</a>
											    </td>

												<td>
													<a class="badge rounded-pill bg-danger p-2 text-white w-100" onclick="return confirm('Do you really want to delete this ?')" href="dashboard.php?delete=<?php echo $tracking  ?>">Delete</a>
												</td> 

												<td>
													<button type="button" class="badge rounded-pill bg-info " onclick="copyContent()">Copy Tracking Number</button>
												</td>

												<td>
													<a  style= "background-color: brown;"class="badge rounded-pill  p-2 text-white w-100" href="view-details.php?post=<?php echo $tracking  ?>" >View details </a>
												</td>

												<td>
													<a class="badge rounded-pill  p-2 text-white w-100 btn btn-warning" href="view-update.php?edit=<?php echo $tracking  ?>">View update </a>
												</td>

												<td>
													<a class="badge rounded-pill bg-primary p-2 text-white w-100" href="../track/print.php?num=<?php echo $tracking  ?>">Print Reciept</a> 
												</td>
										  </tr>
										   <input type="hidden" id="tn<?php echo $id ?>" value="<?php echo $tracking  ?>">
									   </form>
								        <script>
										    let text = document.getElementById('tn<?php echo $id ?>').value;
										    const copyContent = async () => {
											try {
											await navigator.clipboard.writeText(text);
											alert("Tracking Number Copied: " + text);
											} catch (err) {
											console.error('Failed to copy: ', err);
											}
										   }
                                       </script>
										
								     <?php
								           }
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
		<br>
		<?php include 'footer.php';  ?>