<?php
include 'auth.php';

// Handle form submission for adding a new team member
if (isset($_POST['add_member'])) {
    $name = text_input($_POST['name']);
    $title = text_input($_POST['title']);
    $is_published = isset($_POST['is_published']) ? 1 : 0;

    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image);
    }

    $stmt = mysqli_prepare($con, "INSERT INTO team_members (name, title, image, is_published) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssi", $name, $title, $image, $is_published);
    mysqli_stmt_execute($stmt);

    $_SESSION['success_message'] = "Team member added successfully.";
    header("Location: team.php");
    exit();
}

// Handle team member deletion
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = mysqli_prepare($con, "DELETE FROM team_members WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $_SESSION['success_message'] = "Team member deleted successfully.";
    header("Location: team.php");
    exit();
}

// Fetch all team members
$team_result = mysqli_query($con, "SELECT * FROM team_members ORDER BY created_at DESC");
$team_members = mysqli_fetch_all($team_result, MYSQLI_ASSOC);

include 'header.php';
?>

<div class="page-wrapper">
    <div class="page-content">
        <h1>Team Members</h1>
        <?php if (isset($_SESSION['success_message'])) : ?>
            <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add New Team Member</h5>
                <form method="POST" action="team.php" enctype="multipart/form-data">
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
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" checked>
                        <label class="form-check-label" for="is_published">Publish</label>
                    </div>
                    <button type="submit" name="add_member" class="btn btn-primary">Add Member</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">All Team Members</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($team_members as $member) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($member['name']); ?></td>
                                    <td><?php echo htmlspecialchars($member['title']); ?></td>
                                    <td><?php echo $member['is_published'] ? 'Yes' : 'No'; ?></td>
                                    <td>
                                        <a href="edit-team.php?id=<?php echo $member['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="team.php?delete=<?php echo $member['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
