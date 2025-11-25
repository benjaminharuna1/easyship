<?php
include 'auth.php';

// Handle form submission for adding a new testimonial
if (isset($_POST['add_testimonial'])) {
    $name = text_input($_POST['name']);
    $title = text_input($_POST['title']);
    $review_text = text_input($_POST['review_text']);
    $rating = (int)$_POST['rating'];
    $is_published = isset($_POST['is_published']) ? 1 : 0;

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
            header("Location: testimonials.php");
            exit();
        }

        // Allow certain file formats
        $allowed_extensions = ["jpg", "png", "jpeg", "gif"];
        if (!in_array($imageFileType, $allowed_extensions)) {
            $_SESSION['error_message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            header("Location: testimonials.php");
            exit();
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = 'uploads/' . basename($_FILES["image"]["name"]);
        } else {
            $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
            header("Location: testimonials.php");
            exit();
        }
    }

    $stmt = mysqli_prepare($con, "INSERT INTO testimonials (name, title, review_text, rating, image, is_published) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssisi", $name, $title, $review_text, $rating, $image, $is_published);
    mysqli_stmt_execute($stmt);

    $_SESSION['success_message'] = "Testimonial added successfully.";
    header("Location: testimonials.php");
    exit();
}

// Handle testimonial deletion
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = mysqli_prepare($con, "DELETE FROM testimonials WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $_SESSION['success_message'] = "Testimonial deleted successfully.";
    header("Location: testimonials.php");
    exit();
}

// Fetch all testimonials
$testimonials_result = mysqli_query($con, "SELECT * FROM testimonials ORDER BY created_at DESC");
$testimonials = mysqli_fetch_all($testimonials_result, MYSQLI_ASSOC);

include 'header.php';
?>

<div class="page-wrapper">
    <div class="page-content">
        <h1>Testimonials</h1>
        <?php if (isset($_SESSION['success_message'])) : ?>
            <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add New Testimonial</h5>
                <form method="POST" action="testimonials.php" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Title/Position</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Review Text</label>
                        <textarea class="form-control" name="review_text" rows="4" required></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Rating (1-5)</label>
                            <input type="number" class="form-control" name="rating" min="1" max="5" value="5" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" checked>
                        <label class="form-check-label" for="is_published">Publish</label>
                    </div>
                    <button type="submit" name="add_testimonial" class="btn btn-primary">Add Testimonial</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">All Testimonials</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Rating</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($testimonials as $testimonial) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($testimonial['name']); ?></td>
                                    <td><?php echo htmlspecialchars($testimonial['title']); ?></td>
                                    <td><?php echo htmlspecialchars($testimonial['rating']); ?></td>
                                    <td><?php echo $testimonial['is_published'] ? 'Yes' : 'No'; ?></td>
                                    <td>
                                        <a href="edit-testimonial.php?id=<?php echo $testimonial['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="testimonials.php?delete=<?php echo $testimonial['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
