<?php
include 'functions.php';
$stmt = mysqli_prepare($con, "SELECT * FROM setting");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$site_logo = $row['site_logo'];
$site_favicon = $row['site_favicon'];

$msg = '';
$err = '';

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    $response = [];
    if (isset($_POST['name'])) {
        $name = text_input($_POST['name']);
        $email = text_input($_POST['email']);
        $mobile = text_input($_POST['number']);
        $company = text_input($_POST['company']);
        $message = text_input($_POST['message']);

        if (empty($name) || empty($email) || empty($message)) {
            $response = ['status' => 'error', 'message' => 'Name, email, and message are required.'];
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response = ['status' => 'error', 'message' => 'Invalid email address.'];
        } else {
            $stmt = mysqli_prepare($con, "INSERT INTO support_messages (name, email, mobile, company, message) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $mobile, $company, $message);
            if (mysqli_stmt_execute($stmt)) {
                // Message saved to DB, now send email notification
                $admin_email = $row['email_address'];
                $subject = "New Contact Form Message from " . htmlspecialchars($name);

                // Using 'custom_email' template type
                $email_body = "
                    <h2>New Contact Form Submission</h2>
                    <p>You have received a new message from the contact form on your website.</p>
                    <hr>
                    <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>
                    <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
                    <p><strong>Mobile:</strong> " . htmlspecialchars($mobile) . "</p>
                    <p><strong>Company:</strong> " . htmlspecialchars($company) . "</p>
                    <p><strong>Message:</strong></p>
                    <p>" . nl2br(htmlspecialchars($message)) . "</p>
                    <hr>
                    <p>Please log in to the admin panel to view and manage this message.</p>
                ";

                $template_data = ['body' => $email_body];

                if (sendMail($admin_email, $subject, 'custom_email', $template_data)) {
                    $response = ['status' => 'success', 'message' => 'Your message has been sent successfully. We will get back to you shortly.'];
                } else {
                    // Log error for admin, but for user, it's a failure.
                    error_log("Contact form submission saved to DB but failed to send email notification to " . $admin_email);
                    $response = ['status' => 'error', 'message' => 'Failed to send message due to a mail server error. Please try again later.'];
                }
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to save your message. Please try again later.'];
            }
        }
    }
    echo json_encode($response);
    exit;
}
include 'header.php';
?>


        <!--Start Page Header-->
        <section class="page-header">
            <div class="page-header__img float-bob-y"><img src="assets/img/resource/page-header-img.png" alt=""></div>
            <div class="container">
                <div class="page-header__inner">
                    <h2>Contact Details</h2>
                    <ul class="thm-breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><span class="icon-left"></span></li>
                        <li>Contact Details</li>
                    </ul>
                </div>
            </div>
        </section>
        <!--End Page Header-->


        <!--Contact One Start-->
        <section class="contact-one">
            <div class="container">
                <?php if (!empty($msg)) : ?>
                    <div class="alert alert-success"><?php echo $msg; ?></div>
                <?php endif; ?>
                <?php if (!empty($err)) : ?>
                    <div class="alert alert-danger"><?php echo $err; ?></div>
                <?php endif; ?>
                <div class="sec-title text-center">
                    <div class="sub-title">
                        <h4>Contact us</h4>
                    </div>
                    <h2>
                        Get in Touch With Us
                    </h2>
                </div>
                <div class="row">

                    <div class="col-xl-4">
                        <div class="contact-one__list-item">
                            <ul>
                                <li>
                                    <div class="icon">
                                        <span class="icon-location-pin"></span>
                                    </div>
                                    <div class="text">
                                        <h4>Address</h4>
                                        <p>
                                            Dhaka 102, 8000 sent behaibior utl<br>1216, road 45 house of street
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-phone-call-1"></span>
                                    </div>
                                    <div class="text">
                                        <h4>Lets Talk us</h4>
                                        <p>Phone number: <a href="tel:32566-800-890">+32566 - 800 - 890</a></p>
                                        <p>Fax: <a href="tel:1234-58963-007">1234 -58963 - 007</a></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-envelope"></span>
                                    </div>
                                    <div class="text">
                                        <h4>Send us email</h4>
                                        <p>
                                            <a href="cargolink@gmail.com">cargolink@gmail.com</a>
                                        </p>
                                        <p>
                                            <a href="cargolink@gmail.com">demo23yourmail.com</a>
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-8 col-lg-12">
                        <div class="contact-one__form">
                            <form id="contact-form" action="contact.php" method="POST">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="contact-one__input-box">
                                            <input type="text" placeholder="Full name" name="name">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="contact-one__input-box">
                                            <input type="email" placeholder="Email Address" name="email">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="contact-one__input-box">
                                            <input type="number" placeholder="Mobile" name="number">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="contact-one__input-box">
                                            <input type="text" placeholder="Company" name="company">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="contact-one__input-box text-message-box">
                                            <textarea name="message" placeholder="Messege"></textarea>
                                        </div>
                                        <div class="contact-one__btn-box">
                                            <button class="thm-btn" type="submit" data-loading-text="Please wait...">
                                                <span class="txt">Submit Now</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <p class="ajax-response mb-0"></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Contact One End-->



        <!--Start Google Map One-->
        <section class="google-map-one">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4562.753041141002!2d-118.80123790098536!3d34.152323469614075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80e82469c2162619%3A0xba03efb7998eef6d!2sCostco+Wholesale!5e0!3m2!1sbn!2sbd!4v1562518641290!5m2!1sbn!2sbd"
                class="google-map-one__map" allowfullscreen></iframe>
        </section>
        <!--End Google Map One-->






        <!--Start Cta One-->
        <section class="cta-one cta-one--style2">
            <div class="container">
                <div class="cta-one__inner cta-one__inner--style2">
                    <div class="cta-one__inner-box cta-one__inner-box--style2">
                        <div class="title-box">
                            <h2>Efficiency in Motion Connecting the<br>World One Delivery at a Time!</h2>
                        </div>
                    </div>
                    <div class="cta-one__btn cta-one__btn--style2">
                        <a href="#" class="thm-btn">
                            <span class="txt">
                                contact us
                            </span>
                        </a>
                    </div>

                </div>
            </div>
        </section>
        <!--End Cta One-->
<?php include 'footer.php'; ?>
