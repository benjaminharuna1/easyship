<?php
include 'auth.php';

$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send-test-email'])) {
    $recipient = trim($_POST['recipient-email']);

    if (empty($recipient) || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
        $err = "Please enter a valid recipient email address.";
    } else {
        $stmt = mysqli_prepare($con, "SELECT sitename FROM setting WHERE id = 1");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $settings = mysqli_fetch_assoc($result);
        $sitename = $settings['sitename'] ?? 'Your Website';

        $subject = "Test Email from " . $sitename;

        $body = "
            <h2>This is a Test Email</h2>
            <p>If you have received this email, it means your SMTP settings are configured correctly and email sending is functional.</p>
            <p>Thank you for using the test email feature.</p>
        ";

        $template_data = ['body' => $body];

        if (sendMail($recipient, $subject, 'custom_email', $template_data)) {
            $msg = "Test email sent successfully to " . htmlspecialchars($recipient);
        } else {
            $err = "Failed to send test email. Please check your SMTP settings in the <a href='settings.php#email-settings'>Email Settings</a> tab and try again. Also, check the server's error logs for more details.";
        }
    }
}

include 'header.php';
?>

<div class="page-wrapper">
    <div class="page-content">
        <h1>Test Email Configuration</h1>
        <p>This page allows you to send a test email to verify that your SMTP settings are correctly configured and that the email sending functionality is working as expected.</p>

        <?php if (!empty($msg)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($err)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $err; // The error message can contain HTML, so it's not escaped here. ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Send a Test Email</h5>
                <form method="POST" action="test_email.php">
                    <div class="row mb-3">
                        <label for="recipient-email" class="col-sm-3 col-form-label">Recipient Email Address</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="recipient-email" name="recipient-email" required>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="send-test-email" class="btn btn-primary">Send Test Email</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="alert alert-info">
            <strong>Note:</strong> This tool uses the SMTP settings currently saved in the database. If you have recently made changes to your settings, please ensure they are saved before sending a test email. You can configure your SMTP settings on the <a href="settings.php#email-settings">Settings</a> page.
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
