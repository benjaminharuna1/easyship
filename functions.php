<?php
include 'db.php';

include 'mailer/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

require_once "mailer/PHPMailer.php";
require_once "mailer/SMTP.php";
require_once "mailer/Exception.php";



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


function sendMail($email, $subject, $message){

   $mail = new PHPMailer();
   //SMTP Settings (use default cpanel email account)
   $mail->isSMTP();
   $mail->Host = "karamelhub.com.ng"; //
   $mail->SMTPAuth = true;
   $mail->Username = "mail@karamelhub.com.ng"; // Default cpanel email account
   $mail->Password = '@@mailpass##'; // Default cpanel email password
   $mail->Port = 465; // 587
   $mail->SMTPSecure = "ssl"; // tls

   //Email Settings
   $mail->isHTML(true);
   $mail->setFrom('mail@karamelhub.com.ng','Easy Ship'); // Email address/ Bank bane shown to reciever
   $mail->addAddress($email);
   $mail->AddReplyTo("mail@karamelhub.com.ng", "Easy Ship"); // Email address/ Bank bane shown to reciever
   $mail->Subject = $subject;
   $mail->MsgHTML($message);
   $send = $mail->Send();
   return $send;
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



// function sendMail($email, $subject, $body){
//   global $email_address, $email_name;
//   $message = "$body";
//   $headers = "MIME-Version: 1.0" . "\r\n";
//     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
//     $headers .= 'From: '.$email_name.'<'.$email_address.'>' . "\r\n";
//     return mail($email,$subject,$message,$headers);
// }

?>