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
        // Fetch the main template
        $main_template_path = __DIR__ . '/mailer/main_template.html';
        if (!file_exists($main_template_path)) {
            error_log("Main email template not found.");
            return false;
        }
        $final_message = file_get_contents($main_template_path);

        // Determine the body content
        $body_content = '';
        if ($template_name === 'custom_email') {
            $body_content = $template_data['body'] ?? '';
        } else {
            $template_path = __DIR__ . '/mailer/' . $template_name . '.html';
            if (file_exists($template_path)) {
                $body_content = file_get_contents($template_path);
            } else {
                error_log("Email template not found: " . $template_path);
                return false;
            }
        }

        // Replace placeholders in the body content first
        foreach ($template_data as $key => $value) {
            $body_content = str_replace('{' . $key . '}', htmlspecialchars((string)$value), $body_content);
        }

        // Now, embed the processed body into the main template
        $final_message = str_replace('{body}', $body_content, $final_message);

        // Replace global placeholders in the main template
        $site_logo_url = rtrim($settings['site_url'], '/') . '/' . ltrim($settings['site_logo'], '/');
        $final_message = str_replace('{subject}', htmlspecialchars($subject), $final_message);
        $final_message = str_replace('{site_name}', htmlspecialchars($settings['sitename']), $final_message);
        $final_message = str_replace('{site_url}', htmlspecialchars($settings['site_url']), $final_message);
        $final_message = str_replace('{site_logo_url}', htmlspecialchars($site_logo_url), $final_message);
        $final_message = str_replace('{current_year}', date('Y'), $final_message);

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
        $mail->Body = $final_message;

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

function sanitize_html_input($data) {
    // A basic sanitizer to remove script tags and their content to prevent XSS.
    // This is not a replacement for a full-fledged library like HTML Purifier,
    // but it mitigates the most common XSS attack vector.
    $data = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $data);
    return $data;
}
   
function pageRedirect($sec, $route){
  $c = "<meta http-equiv='refresh' Content='".$sec."; url=".$route." ' />";
  return $c;
}

/**
 * getCoordinates($place)
 * - Checks local geocache table first.
 * - If not found, queries Nominatim and caches the result.
 * - Returns array('lat'=>..., 'lon'=>...) or null on failure.
 */
function getCoordinates($place) {
    global $con;
    $place = trim($place);
    if ($place === '') return null;

    // 1) check local cache
    $stmt = mysqli_prepare($con, "SELECT lat, lon FROM geocache WHERE place = ? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $place);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $lat, $lon);
        if (mysqli_stmt_fetch($stmt)) {
            mysqli_stmt_close($stmt);
            return ['lat' => $lat, 'lon' => $lon];
        }
        mysqli_stmt_close($stmt);
    }

    // 2) call LocationIQ API
    $stmt = mysqli_prepare($con, "SELECT geocode_api_key FROM setting WHERE id = 1");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $settings = mysqli_fetch_assoc($result);
    $api_key = $settings['geocode_api_key'] ?? '';

    if (empty($api_key)) {
        return ['error' => 'Geocode API key is not configured.'];
    }

    $params = http_build_query([
        'key' => $api_key,
        'q' => $place,
        'format' => 'json',
        'limit' => 1,
        'addressdetails' => 0,
        'accept-language' => 'en'
    ]);
    $url = "https://us1.locationiq.com/v1/search.php?$params";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    $resp = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$resp) {
        return ['error' => "API request failed with HTTP status $httpCode. Check your API key and server's internet connection."];
    }

    $data = json_decode($resp, true);
    if (!is_array($data) || empty($data) || !isset($data[0]['lat'], $data[0]['lon'])) {
        return ['error' => "Geocoding service could not find coordinates for the location: '$place'."];
    }

    $lat = $data[0]['lat'];
    $lon = $data[0]['lon'];

    // 3) insert into geocache
    $ins = mysqli_prepare($con, "INSERT INTO geocache (place, lat, lon, updated_at) VALUES (?, ?, ?, NOW())");
    if ($ins) {
        mysqli_stmt_bind_param($ins, "sss", $place, $lat, $lon);
        @mysqli_stmt_execute($ins);
        mysqli_stmt_close($ins);
    }

    return ['lat' => $lat, 'lon' => $lon];
}

/**
 * process_shortcodes($content, $settings)
 * - Replaces shortcodes like [site-name] with values from the settings array.
 */
function process_shortcodes($content, $settings) {
    if (empty($content) || empty($settings)) {
        return $content;
    }

    $replacements = [
        '[site-name]' => $settings['site_title'],
        '[site-url]' => $settings['site_url'],
        '[email-name]' => $settings['email_name'],
        '[email-address]' => $settings['email_address'],
        '[phone-number]' => $settings['phone_number'],
        '[fax-number]' => $settings['fax_number'],
        '[site-address]' => nl2br(htmlspecialchars($settings['site_address'])),
    ];

    foreach ($replacements as $shortcode => $value) {
        $content = str_replace($shortcode, $value, $content);
    }

    return $content;
}
?>
