<?php
include 'auth.php';

// Enable mysqli exceptions
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$messages = [];
try {
    $stmt = mysqli_prepare($con, "SELECT * FROM support_messages ORDER BY created_at DESC");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $messages = mysqli_fetch_all($result, MYSQLI_ASSOC);
} catch (Exception $e) {
    $err = "Database Error: " . $e->getMessage();
}

include 'header.php';
?>

<div class="page-wrapper">
    <div class="page-content">
        <h1>Support Messages</h1>

        <?php if (!empty($err)) : ?>
            <div class="alert alert-danger"><?php echo $err; ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">All support messages</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Company</th>
                                <th>Message</th>
                                <th>Received At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($messages)) : ?>
                                <tr>
                                    <td colspan="7" class="text-center">No messages yet.</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($messages as $index => $message) : ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($message['name']); ?></td>
                                        <td><a href="mailto:<?php echo htmlspecialchars($message['email']); ?>"><?php echo htmlspecialchars($message['email']); ?></a></td>
                                        <td><?php echo htmlspecialchars($message['mobile'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($message['company'] ?? 'N/A'); ?></td>
                                        <td><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                                        <td><?php echo htmlspecialchars($message['created_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
