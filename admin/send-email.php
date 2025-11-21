<?php
include 'auth.php';

// Enable mysqli exceptions
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$msg = '';
$err = '';

if (isset($_POST['send_email'])) {
    $recipient = trim($_POST['recipient']);
    $subject = trim($_POST['subject']);
    $body = $_POST['body']; // Quill content is HTML
    $attachments = $_FILES['attachments'];

    if (empty($recipient) || empty($subject) || empty($body)) {
        $err = "Recipient, subject, and body are required.";
    } elseif (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
        $err = "Invalid recipient email address.";
    } else {
        // File upload validation
        if (!empty($attachments['name'][0])) {
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'];
            $max_size = 5 * 1024 * 1024; // 5 MB

            foreach ($attachments['name'] as $key => $name) {
                $file_size = $attachments['size'][$key];
                $file_ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                if ($file_size > $max_size) {
                    $err = "File '" . htmlspecialchars($name) . "' is too large. Maximum size is 5 MB.";
                    break;
                }

                if (!in_array($file_ext, $allowed_types)) {
                    $err = "File type for '" . htmlspecialchars($name) . "' is not allowed.";
                    break;
                }
            }
        }

        if (empty($err) && sendMail($recipient, $subject, 'custom_email', ['body' => $body], $attachments)) {
            $msg = "Email sent successfully to " . htmlspecialchars($recipient);
        } else {
            $err = "Failed to send email. Please check your SMTP settings and logs.";
        }
    }
}

include 'header.php';
?>

<!-- Quill.js CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div class="page-wrapper">
    <div class="page-content">
        <h1>Send Email</h1>

        <?php if (!empty($msg)) : ?>
            <div class="alert alert-success"><?php echo $msg; ?></div>
        <?php endif; ?>
        <?php if (!empty($err)) : ?>
            <div class="alert alert-danger"><?php echo $err; ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Compose a new email</h5>
                <form method="POST" action="send-email.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="recipient" class="form-label">Recipient</label>
                        <input type="email" class="form-control" id="recipient" name="recipient" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="body" class="form-label">Body</label>
                        <div id="editor" style="height: 300px;"></div>
                        <input type="hidden" name="body" id="body">
                    </div>
                    <div class="mb-3">
                        <label for="attachments" class="form-label">Attachments</label>
                        <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                    </div>
                    <button type="submit" name="send_email" class="btn btn-primary">Send Email</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Quill.js JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['clean'],
                    ['link', 'image', 'video']
                ]
            }
        });

        var form = document.querySelector('form');
        form.onsubmit = function() {
            var body = document.querySelector('input[name=body]');
            body.value = quill.root.innerHTML;
        };
    });
</script>

<?php include 'footer.php'; ?>
