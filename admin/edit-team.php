<?php
include 'auth.php';

$id = (int)$_GET['id'];

// Handle form submission for updating a team member
if (isset($_POST['update_member'])) {
    $name = text_input($_POST['name']);
    $title = text_input($_POST['title']);
    $is_published = isset($_POST['is_published']) ? 1 : 0;

    $image = $_POST['current_image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size (e.g., 2MB limit)
        if ($_FILES["image"]["size"] > 2000000) {
            $_SESSION['error_message'] = "Sorry, your file is too large.";
            header("Location: edit-team.php?id=" . $id);
            exit();
        }

        // Allow certain file formats
        $allowed_extensions = ["jpg", "png", "jpeg", "gif"];
        if (!in_array($imageFileType, $allowed_extensions)) {
            $_SESSION['error_message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            header("Location: edit-team.php?id=" . $id);
            exit();
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = 'uploads/' . basename($_FILES["image"]["name"]);
        } else {
            $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
            header("Location: edit-team.php?id=" . $id);
            exit();
        }
    }

    $stmt = mysqli_prepare($con, "UPDATE team_members SET name = ?, title = ?, image = ?, is_published = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssii", $name, $title, $image, $is_published, $id);
    mysqli_stmt_execute($stmt);

    $_SESSION['success_message'] = "Team member updated successfully.";
    header("Location: team.php");
    exit();
}

// Fetch the team member to edit
$stmt = mysqli_prepare($con, "SELECT * FROM team_members WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$member = mysqli_fetch_assoc($result);

include 'header.php';
?>

<div class="page-wrapper">
    <div class="page-content">
        <h1>Edit Team Member</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Details for "<?php echo htmlspecialchars($member['name']); ?>"</h5>
                <form method="POST" action="edit-team.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($member['name']); ?>" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Title/Position</label>
                            <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($member['title']); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image">
                        <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($member['image']); ?>">
                        <?php if (!empty($member['image'])) : ?>
                            <img src="../<?php echo htmlspecialchars($member['image']); ?>" width="100" class="mt-2">
                        <?php endif; ?>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" <?php if ($member['is_published']) echo 'checked'; ?>>
                        <label class="form-check-label" for="is_published">Publish</label>
                    </div>
                    <button type="submit" name="update_member" class="btn btn-primary">Update Member</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
