<?php
include 'db.php';

// It's better to include the autoloader only once.
// The require_once calls are redundant if the autoloader is working.
// I'll keep them for safety as the original code had them.
include 'mailer/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "mailer/PHPMailer.php";
require_once "mailer/SMTP.php";
require_once "mailer/Exception.php";


// This global query is inefficient as it runs on every page load.
// It's better to fetch settings when needed, like inside the functions.
// I'll leave it for now to avoid breaking other parts of the site.
$sql = mysqli_query($con, "SELECT * FROM setting WHERE id = 1 ");
if (mysqli_num_rows($sql) > 0) {
  $data = mysqli_fetch_assoc($sql);

  $tracking_id = $data['tracking_num'];
  $email_name = $data['email_name'];
  $email_address = $data['email_address'];
  $sitename = $data['sitename'];
  $site_title = $data['site_title'];
  $site_url = $data['site_url'];
}

/**
 * Sends an email using a template.
 *
 * @param string $email Recipient's email address.
 * @param string $subject The subject of the email.
 * @param string $template_name The name of the HTML template file (without .html extension).
 * @param array $template_data An associative array of data to replace placeholders in the template.
 * @param array $attachments An array of file attachments in $_FILES format.
 * @return bool True on success, false on failure.
 */
function sendMail($email, $subject, $template_name, $template_data = [], $attachments = []){
    global $con;
    $stmt = mysqli_prepare($con, "SELECT * FROM setting WHERE id = 1");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $settings = mysqli_fetch_assoc($result);

    if (!$settings) {
        // Cannot send mail without settings
        return false;
    }

    $smtp_host = $settings['smtp_host'];
    $smtp_username = $settings['smtp_username'];
    $smtp_password = $settings['smtp_password'];
    $smtp_port = $settings['smtp_port'];
    $smtp_secure = $settings['smtp_secure'];
    $from_name = $settings['email_name'];
    $from_email = $settings['email_address'];

    $mail = new PHPMailer(true); // Enable exceptions

    try {
        // Message Body
        if ($template_name === 'custom_email') {
            // For custom emails, the body is passed directly.
            $message = $template_data['body'] ?? '';
        } else {
            // For template-based emails, load and process the template.
            $template_path = __DIR__ . '/mailer/' . $template_name . '.html';
            if (!file_exists($template_path)) {
                error_log("Email template not found: " . $template_path);
                return false;
            }
            $message = file_get_contents($template_path);

            $template_data['site_name'] = $settings['sitename'] ?? 'Our Site';
            $template_data['site_url'] = $settings['site_url'] ?? '#';

            foreach ($template_data as $key => $value) {
                $message = str_replace('{' . $key . '}', htmlspecialchars((string)$value), $message);
            }
        }

        // Attachments
        if (!empty($attachments['name'][0])) {
            for ($i = 0; $i < count($attachments['name']); $i++) {
                $mail->addAttachment($attachments['tmp_name'][$i], $attachments['name'][$i]);
            }
        }

        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->Port = (int)$smtp_port;
        $mail->SMTPSecure = $smtp_secure;

        //Email Settings
        $mail->isHTML(true);
        $mail->setFrom($smtp_username, $from_name);
        $mail->addAddress($email);
        $mail->AddReplyTo($smtp_username, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $message; // Use Body for HTML content

        return $mail->send();

    } catch (Exception $e) {
        error_log("PHPMailer Error: " . $mail->ErrorInfo);
        return false;
    }
}


function customAlert($case, $content){
  switch ($case) {
    case 'success':
      $mesg =  '<script type="text/javascript">
        $(document).ready(function() {
            swal("Success", "'.$content.'", "success")    
        });
      </script>';
      break;

      case 'error':
        $mesg = '<script type="text/javascript">
            $(document).ready(function() {
                sweetAlert("Error", "'.$content.'", "error")    
            });
        </script>'; 
      break;
    default:
    break;
  }
  return $mesg;
}

  
function text_input($data) {
  global $con;
  $data = trim($data ?? '');
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = mysqli_real_escape_string($con,$data);
  return $data;
}
   
function pageRedirect($sec, $route){
  $c = "<meta http-equiv='refresh' Content='".$sec."; url=".$route." ' />";
  return $c;
}

?>