<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    require_once 'db.php';


    $fullName = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $city = trim($_POST['city']);
    $interest = trim($_POST['interest']);
    $message = trim($_POST['message']);

    $sql = "INSERT INTO volunteers (full_name, email, phone, city, interest, message) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind and execute... (this part is unchanged)
        $stmt->bind_param("ssssss", $fullName, $_POST['email'], $_POST['phone'], $_POST['city'], $_POST['interest'], $_POST['message']);

        if ($stmt->execute()) {
            // --- 2. SEND EMAIL NOTIFICATION ---
            $mail = new PHPMailer(true);
            try {
                // Server settings - NOW USING .ENV VARIABLES
                $mail->isSMTP();
                $mail->Host       = $_ENV['SMTP_HOST'];
                $mail->SMTPAuth   = true;
                $mail->Username   = $_ENV['SMTP_USER'];
                $mail->Password   = $_ENV['SMTP_PASS'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = $_ENV['SMTP_PORT'];

                // Recipients
                $mail->setFrom($_ENV['SMTP_USER'], 'Astu Foundation');
                $mail->addAddress($_ENV['ADMIN_EMAIL'], 'Admin');
                $mail->addReplyTo($email, $fullName);

                // Content (unchanged)
                // Content
                $mail->isHTML(true);
                $mail->Subject = 'New Volunteer Application: ' . htmlspecialchars($fullName);

                // The HTML email body
                $mail->Body    = "
    <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
        <h2 style='color:#0d5a66;'>New Volunteer Application</h2>
        <p>A new application was submitted on " . date('F j, Y, g:i a') . " with the following details:</p>
        <table cellpadding='10' border='1' style='border-collapse: collapse; width: 100%;'>
            <tr style='background-color:#f2f2f2;'>
                <td style='width: 150px;'><strong>Full Name:</strong></td>
                <td>" . htmlspecialchars($fullName) . "</td>
            </tr>
            <tr>
                <td><strong>Email Address:</strong></td>
                <td>" . htmlspecialchars($_POST['email']) . "</td>
            </tr>
            <tr style='background-color:#f2f2f2;'>
                <td><strong>Phone Number:</strong></td>
                <td>" . htmlspecialchars($_POST['phone']) . "</td>
            </tr>
            <tr>
                <td><strong>City:</strong></td>
                <td>" . htmlspecialchars($_POST['city']) . "</td>
            </tr>
            <tr style='background-color:#f2f2f2;'>
                <td><strong>Area of Interest:</strong></td>
                <td>" . htmlspecialchars($_POST['interest']) . "</td>
            </tr>
            <tr>
                <td><strong>Message:</strong></td>
                <td>" . nl2br(htmlspecialchars($_POST['message'])) . "</td>
            </tr>
        </table>
    </div>
";


                $mail->AltBody = "
New Volunteer Application Received
---------------------------------
Full Name: " . htmlspecialchars($fullName) . "
Email: " . htmlspecialchars($_POST['email']) . "
Phone: " . htmlspecialchars($_POST['phone']) . "
City: " . htmlspecialchars($_POST['city']) . "
Area of Interest: " . htmlspecialchars($_POST['interest']) . "
Message: " . htmlspecialchars($_POST['message']) . "
";

                $mail->send();
                $_SESSION['form_status'] = ['type' => 'success', 'message' => 'Thank you! Your application has been submitted successfully.'];
            } catch (Exception $e) {
                $_SESSION['form_status'] = ['type' => 'warning', 'message' => 'Your application was submitted, but the notification email could not be sent.'];
            }
        } else {
            $_SESSION['form_status'] = ['type' => 'danger', 'message' => 'Database insert failed. Please try again.'];
        }
        $stmt->close();
    }
    $conn->close();


    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">




<head>
    <meta charset="UTF-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Nonpro-Nonprofit Charity HTML5 Template</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Favicon -->
    <link
        rel="icon"
        type="image/png"
        sizes="56x56"
        href="assets/images/fav-icon/icon.png" />
    <!-- bootstrap CSS -->
    <link
        rel="stylesheet"
        href="assets/css/bootstrap.min.css"
        type="text/css"
        media="all" />

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- carousel CSS -->
    <link
        rel="stylesheet"
        href="assets/css/owl.carousel.min.css"
        type="text/css"
        media="all" />
    <!-- animate CSS -->
    <link
        rel="stylesheet"
        href="assets/css/animate.css"
        type="text/css"
        media="all" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- font-awesome CSS -->
    <link
        rel="stylesheet"
        href="assets/css/all.min.css"
        type="text/css"
        media="all" />
    <!-- font-flaticon CSS -->
    <link
        rel="stylesheet"
        href="assets/css/flaticon.css"
        type="text/css"
        media="all" />
    <!-- theme-default CSS -->
    <link
        rel="stylesheet"
        href="assets/css/theme-default.css"
        type="text/css"
        media="all" />
    <!-- meanmenu CSS -->
    <link
        rel="stylesheet"
        href="assets/css/meanmenu.min.css"
        type="text/css"
        media="all" />
    <!-- transitions CSS -->
    <link
        rel="stylesheet"
        href="assets/css/owl.transitions.css"
        type="text/css"
        media="all" />
    <!-- venobox CSS -->
    <link
        rel="stylesheet"
        href="venobox/venobox.css"
        type="text/css"
        media="all" />
    <!-- bootstrap icons -->
    <link
        rel="stylesheet"
        href="assets/css/bootstrap-icons.css"
        type="text/css"
        media="all" />
    <!-- Slick Slider -->
    <link rel="stylesheet" type="text/css" href="assets/slick/slick.css" />
    <link
        rel="stylesheet"
        type="text/css"
        href="assets/slick/slick-theme.css" />
    <!-- Main Style CSS -->
    <link
        rel="stylesheet"
        href="assets/css/style.css"
        type="text/css"
        media="all" />
    <!-- Dropdown CSS -->
    <link
        rel="stylesheet"
        href="assets/css/dropdown.css"
        type="text/css"
        media="all" />
    <!-- responsive CSS -->
    <link
        rel="stylesheet"
        href="assets/css/responsive.css"
        type="text/css"
        media="all" />
    <!-- rangeslider CSS -->
    <link
        rel="stylesheet"
        href="assets/css/rangeslider.css"
        type="text/css"
        media="all" />
    <!-- modernizr js -->
    <script src="assets/js/vendor/modernizr-3.5.0.min.js"></script>


</head>

<body class="bg-light">


    <?php require "header.php" ?>

    <div class="container mt-5">
        <div class="col-md-8 mx-auto">
            <h2 class="mb-4 text-center">Become a Volunteer</h2>

            <?php
            // Display status message if it exists
            if (isset($_SESSION['form_status'])) {
                $status = $_SESSION['form_status'];
                echo '<div class="alert alert-' . htmlspecialchars($status['type']) . ' alert-dismissible fade show" role="alert">
                    ' . htmlspecialchars($status['message']) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                unset($_SESSION['form_status']);
            }
            ?>

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" style="margin-bottom: 10px;">
                <div class="mb-3">
                    <label for="fullName" class="form-label" style="color: black;">Full Name</label>
                    <input type="text" class="form-control" name="full_name" id="fullName" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label" style="color: black;">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label" style="color: black;">Phone Number</label>
                        <input type="tel" class="form-control" name="phone" id="phone" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="city" class="form-label" style="color: black;">City</label>
                        <input type="text" class="form-control" name="city" id="city" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="interest" class="form-label" style="color: black;">Area of Interest</label>
                        <select class="form-select" name="interest" id="interest" required>
                            <option value="" disabled selected>Select an option</option>
                            <option value="Event Planning">Event Planning</option>
                            <option value="Fundraising">Fundraising</option>
                            <option value="Community Outreach">Community Outreach</option>
                            <option value="Administrative Support">Administrative Support</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label" style="color: black;">Message (Optional)</label>
                    <textarea class="form-control" name="message" id="message" rows="4"></textarea>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg" style="background-color:#DF5311">Submit Application</button>
                </div>
            </form>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php require "footer.php" ?>
</body>`

</html>