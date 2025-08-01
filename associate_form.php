<?php
// associate_form.php

// Start the session to store status messages
session_start();

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// --- LOAD ENVIRONMENT VARIABLES ---
// This will load variables from the .env file in your project's root directory
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Include DB connection (which now uses .env variables)
    require_once 'db.php';

    // --- FORM DATA ---
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $type = trim($_POST['type']);
    $reason = trim($_POST['reason']);

    // --- 1. DATABASE INSERTION ---
    $sql = "INSERT INTO associates (name, email, phone, association_type, reason) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $name, $email, $phone, $type, $reason);

        if ($stmt->execute()) {
            // --- 2. SEND EMAIL NOTIFICATION ---
            $mail = new PHPMailer(true);
            try {
                // Server settings - LOADING FROM .ENV
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
                $mail->addReplyTo($email, $name);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'New Association Inquiry from: ' . htmlspecialchars($name);
                $mail->Body    = "
                    <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                        <h2 style='color:#0d5a66;'>New Association Inquiry</h2>
                        <p>An inquiry was submitted on " . date('F j, Y, g:i a') . " with the following details:</p>
                        <table cellpadding='10' border='1' style='border-collapse: collapse; width: 100%;'>
                            <tr style='background-color:#f2f2f2;'>
                                <td style='width: 150px;'><strong>Full Name:</strong></td>
                                <td>" . htmlspecialchars($name) . "</td>
                            </tr>
                            <tr>
                                <td><strong>Email Address:</strong></td>
                                <td>" . htmlspecialchars($email) . "</td>
                            </tr>
                            <tr style='background-color:#f2f2f2;'>
                                <td><strong>Phone Number:</strong></td>
                                <td>" . htmlspecialchars($phone) . "</td>
                            </tr>
                            <tr>
                                <td><strong>Type of Association:</strong></td>
                                <td>" . htmlspecialchars($type) . "</td>
                            </tr>
                            <tr style='background-color:#f2f2f2;'>
                                <td><strong>Reason to Associate:</strong></td>
                                <td>" . nl2br(htmlspecialchars($reason)) . "</td>
                            </tr>
                        </table>
                    </div>
                ";
                $mail->AltBody = "New Association Inquiry Received\n---------------------------------\nFull Name: " . htmlspecialchars($name) . "\nEmail: " . htmlspecialchars($email) . "\nPhone: " . htmlspecialchars($phone) . "\nType of Association: " . htmlspecialchars($type) . "\nReason to Associate: " . htmlspecialchars($reason);


                $mail->send();
                $_SESSION['form_status'] = ['type' => 'success', 'message' => 'Thank you! Your form has been submitted successfully.'];
            } catch (Exception $e) {
                $_SESSION['form_status'] = ['type' => 'warning', 'message' => 'Your form was submitted, but the notification email could not be sent.'];
            }
        } else {
            $_SESSION['form_status'] = ['type' => 'danger', 'message' => 'Oops! Something went wrong with the database. Please try again.'];
        }
        $stmt->close();
    } else {
        $_SESSION['form_status'] = ['type' => 'danger', 'message' => 'Oops! A database error occurred. Please try again.'];
    }
    $conn->close();

    // Redirect back to the form page to prevent re-submission and show the status message
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body class="bg-light">
    <?php require "header.php" ?>

    <div class="container mt-5">
        <div class="col-md-8 mx-auto">
            <h2 class="mb-4 text-center">Associate with Astu Foundation</h2>

            <?php
            // Display the status message if it exists
            if (isset($_SESSION['form_status'])) {
                $status = $_SESSION['form_status'];
                echo '<div class="alert alert-' . htmlspecialchars($status['type']) . ' alert-dismissible fade show" role="alert">
                    ' . htmlspecialchars($status['message']) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                // Unset the session variable so it doesn't show again on refresh
                unset($_SESSION['form_status']);
            }
            ?>

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" style="margin-bottom: 10px;">
                <div class="mb-3">
                    <label for="name" class="form-label" style="color: black;">Full Name</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label" style="color: black;">Email ID</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label" style="color: black;">Phone Number</label>
                    <input type="tel" class="form-control" name="phone" id="phone" required>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label" style="color: black;">Type of Association</label>
                    <select class="form-select" name="type" id="type" required>
                        <option value="" disabled selected>Select an option</option>
                        <option value="Individual">Individual</option>
                        <option value="Organization">Organization</option>
                        <option value="Corporate">Corporate</option>
                        <option value="NGO">NGO</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="reason" class="form-label"style="color: black;">Why do you want to associate?</label>
                    <textarea class="form-control" name="reason" id="reason" rows="4" required></textarea>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-lg" style="background-color:#DF5311">Submit Form</button>
                </div>
            </form>
        </div>
    </div>


    <?php require "footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>