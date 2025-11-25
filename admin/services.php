<?php
include 'auth.php';

// Handle form submission for adding a new service
if (isset($_POST['add_service'])) {
    $title = text_input($_POST['title']);
    $description = text_input($_POST['description']);
    $icon_class = text_input($_POST['icon_class']);
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    $image = '';
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
            header("Location: services.php");
            exit();
        }

        // Allow certain file formats
        $allowed_extensions = ["jpg", "png", "jpeg", "gif", "svg"];
        if (!in_array($imageFileType, $allowed_extensions)) {
            $_SESSION['error_message'] = "Sorry, only JPG, JPEG, PNG, GIF & SVG files are allowed.";
            header("Location: services.php");
            exit();
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = 'uploads/' . basename($_FILES["image"]["name"]);
        } else {
            $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
            header("Location: services.php");
            exit();
        }
    }

    $stmt = mysqli_prepare($con, "INSERT INTO services (title, description, icon_class, image, is_published, is_featured) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssii", $title, $description, $icon_class, $image, $is_published, $is_featured);
    mysqli_stmt_execute($stmt);

    $_SESSION['success_message'] = "Service added successfully.";
    header("Location: services.php");
    exit();
}

// Handle service deletion
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = mysqli_prepare($con, "DELETE FROM services WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $_SESSION['success_message'] = "Service deleted successfully.";
    header("Location: services.php");
    exit();
}

// Fetch all services
$services_result = mysqli_query($con, "SELECT * FROM services ORDER BY created_at DESC");
$services = mysqli_fetch_all($services_result, MYSQLI_ASSOC);

include 'header.php';
?>

<div class="page-wrapper">
    <div class="page-content">
        <h1>Manage Services</h1>
        <?php if (isset($_SESSION['success_message'])) : ?>
            <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])) : ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add New Service</h5>
                <form method="POST" action="services.php" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Service Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Icon Class</label>
                            <input type="text" class="form-control" name="icon_class" placeholder="e.g., icon-air-freight">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" checked>
                                <label class="form-check-label" for="is_published">Publish</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1">
                                <label class="form-check-label" for="is_featured">Feature on Homepage</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="add_service" class="btn btn-primary">Add Service</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">All Services</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Icon Class</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $service) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($service['title']); ?></td>
                                    <td><?php echo htmlspecialchars($service['icon_class']); ?></td>
                                    <td><?php echo $service['is_published'] ? 'Yes' : 'No'; ?></td>
                                    <td>
                                        <a href="edit-service.php?id=<?php echo $service['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="services.php?delete=<?php echo $service['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
