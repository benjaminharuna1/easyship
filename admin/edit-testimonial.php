<?php
include 'auth.php';

$id = (int)$_GET['id'];

// Handle form submission for updating a testimonial
if (isset($_POST['update_testimonial'])) {
    $name = text_input($_POST['name']);
    $title = text_input($_POST['title']);
    $review_text = text_input($_POST['review_text']);
    $rating = (int)$_POST['rating'];
    $is_published = isset($_POST['is_published']) ? 1 : 0;

    $image = $_POST['current_image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image);
    }

    $stmt = mysqli_prepare($con, "UPDATE testimonials SET name = ?, title = ?, review_text = ?, rating = ?, image = ?, is_published = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssissi", $name, $title, $review_text, $rating, $image, $is_published, $id);
    mysqli_stmt_execute($stmt);

    $_SESSION['success_message'] = "Testimonial updated successfully.";
    header("Location: testimonials.php");
    exit();
}

// Fetch the testimonial to edit
$stmt = mysqli_prepare($con, "SELECT * FROM testimonials WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$testimonial = mysqli_fetch_assoc($result);

include 'header.php';
?>

<div class="page-wrapper">
    <div class="page-content">
        <h1>Edit Testimonial</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Details for "<?php echo htmlspecialchars($testimonial['name']); ?>"</h5>
                <form method="POST" action="edit-testimonial.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($testimonial['name']); ?>" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Title/Position</label>
                            <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($testimonial['title']); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Review Text</label>
                        <textarea class="form-control" name="review_text" rows="4" required><?php echo htmlspecialchars($testimonial['review_text']); ?></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Rating (1-5)</label>
                            <input type="number" class="form-control" name="rating" min="1" max="5" value="<?php echo htmlspecialchars($testimonial['rating']); ?>" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image">
                            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($testimonial['image']); ?>">
                            <?php if (!empty($testimonial['image'])) : ?>
                                <img src="../<?php echo htmlspecialchars($testimonial['image']); ?>" width="100" class="mt-2">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" <?php if ($testimonial['is_published']) echo 'checked'; ?>>
                        <label class="form-check-label" for="is_published">Publish</label>
                    </div>
                    <button type="submit" name="update_testimonial" class="btn btn-primary">Update Testimonial</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
