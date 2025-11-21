<?php
include 'auth.php'; // Use the new auth file for initialization

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Use prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($con, "DELETE FROM addtracking WHERE tracking_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $id);
    if (mysqli_stmt_execute($stmt)) {
        header('location: dashboard.php');
        exit();
    }
}

include 'header.php'; // Include the header for HTML output
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
                            $productname = $row['package_discription'];
                            $status = $row['status'];
                            $dateAdded = $row['date_added'];
                            $tracking = $row['tracking_id'];
                            $i++;
                    ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td>
                                    <img src="../uploads/<?php echo htmlspecialchars($image) ?>" alt="" width="100" height="60">
                                </td>
                                <td>
                                    <div class="ms-2">
                                        <h6 class="mb-1 font-14"><?php echo htmlspecialchars($productname)  ?></h6>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($tracking) ?></td>
                                <td><?php echo htmlspecialchars($status) ?></td>
                                <td><?php echo htmlspecialchars($dateAdded) ?></td>
                                <td>
                                    <a class="badge rounded-pill bg-primary p-2 text-white w-100" href="edit.php?edit=<?php echo htmlspecialchars($tracking)  ?>">Update</a>
                                </td>
                                <td>
                                    <a class="badge rounded-pill bg-danger p-2 text-white w-100" onclick="return confirm('Do you really want to delete this ?')" href="dashboard.php?delete=<?php echo htmlspecialchars($tracking)  ?>">Delete</a>
                                </td>
                                <td>
                                    <button type="button" class="badge rounded-pill bg-info" onclick="copyContent('<?php echo htmlspecialchars($tracking) ?>')">Copy Tracking Number</button>
                                </td>
                                <td>
                                    <a class="badge rounded-pill bg-primary p-2 text-white w-100" href="../track/print.php?num=<?php echo htmlspecialchars($tracking)  ?>">Print Reciept</a>
                                </td>
                            </tr>
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
<script>
    function copyContent(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert("Tracking Number Copied: " + text);
        }, function(err) {
            console.error('Failed to copy: ', err);
        });
    }
</script>
<?php include 'footer.php';  ?>