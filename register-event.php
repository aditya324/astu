<?php
// register-event.php

// Start session to show success/error messages
session_start();

// Use PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 1. Load prerequisites
require 'vendor/autoload.php'; // Composer autoloader

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Connect to the database
require_once 'db.php';

$event_id = null;
$event_title = "Unknown Event";

// 2. Handle the initial page load (GET request)
// This part runs when the user first clicks the "Register" link.
if (isset($_GET['event_id']) && is_numeric($_GET['event_id'])) {
    $event_id = (int)$_GET['event_id'];

    // Fetch the event name from the 'events' table to display it
    $stmt = $conn->prepare("SELECT title FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
        $event_title = $event['title'];
    } else {
        die("Error: The event you are trying to register for could not be found.");
    }
    $stmt->close();
} else {
    die("Error: No event was specified for registration.");
}


// 3. Handle the form submission (POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $registrant_name = trim($_POST['registrant_name']);
    $registrant_email = trim($_POST['registrant_email']);
    $registrant_phone = trim($_POST['registrant_phone']);
    $submitted_event_id = (int)$_POST['event_id'];

    // The event title is already known from the GET request logic above
    
    // --- DATABASE INSERTION ---
    $sql = "INSERT INTO event_registrations (event_id, event_name, registrant_name, registrant_email, registrant_phone) VALUES (?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind all 5 parameters correctly
        $stmt->bind_param("issss", $submitted_event_id, $event_title, $registrant_name, $registrant_email, $registrant_phone);

        if ($stmt->execute()) {
            // --- EMAIL NOTIFICATION ---
            $mail = new PHPMailer(true);
            try {
                // Server settings from .env
                $mail->isSMTP();
                $mail->Host       = $_ENV['SMTP_HOST'];
                $mail->SMTPAuth   = true;
                $mail->Username   = $_ENV['SMTP_USER'];
                $mail->Password   = $_ENV['SMTP_PASS'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = $_ENV['SMTP_PORT'];

                //Recipients
                $mail->setFrom($_ENV['SMTP_USER'], 'Your Foundation Name');
                $mail->addAddress($_ENV['ADMIN_EMAIL'], 'Admin');
                $mail->addReplyTo($registrant_email, $registrant_name);

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'New Event Registration: ' . htmlspecialchars($event_title);
                $mail->Body    = "<h2>New Registration for: " . htmlspecialchars($event_title) . "</h2><p>Details:</p><ul><li>Name: " . htmlspecialchars($registrant_name) . "</li><li>Email: " . htmlspecialchars($registrant_email) . "</li><li>Phone: " . htmlspecialchars($registrant_phone) . "</li></ul>";
                
                $mail->send();
                $_SESSION['form_status'] = ['type' => 'success', 'message' => 'Thank you for registering! We have received your details.'];

            } catch (Exception $e) {
                $_SESSION['form_status'] = ['type' => 'warning', 'message' => 'Registration successful, but the notification email failed.'];
            }
        } else {
            $_SESSION['form_status'] = ['type' => 'danger', 'message' => 'Database error: Could not save registration.'];
        }
        $stmt->close();
    }
    $conn->close();

    // Redirect to the same page to show the status message and prevent re-submission
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register for an Event</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="col-md-8 mx-auto">
        <div class="text-center">
            <h5 class="text-muted">You are registering for the event:</h5>
            <h2 class="mb-4"><?= htmlspecialchars($event_title) ?></h2>
        </div>
        
        <?php
        // Display the success or error message
        if (isset($_SESSION['form_status'])) {
            $status = $_SESSION['form_status'];
            echo '<div class="alert alert-' . htmlspecialchars($status['type']) . '">' . htmlspecialchars($status['message']) . '</div>';
            unset($_SESSION['form_status']); // Clear message after displaying
        }
        ?>

        <form action="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="POST">
            
            <input type="hidden" name="event_id" value="<?= (int)$event_id ?>">

            <div class="mb-3">
                <label for="registrant_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="registrant_name" id="registrant_name" required>
            </div>
            <div class="mb-3">
                <label for="registrant_email" class="form-label">Email ID</label>
                <input type="email" class="form-control" name="registrant_email" id="registrant_email" required>
            </div>
            <div class="mb-3">
                <label for="registrant_phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" name="registrant_phone" id="registrant_phone" required>
            </div>
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-success btn-lg">Complete Registration</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>