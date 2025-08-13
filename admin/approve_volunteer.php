<?php
session_start();
require '../db.php';
require '../vendor/autoload.php'; // PHPMailer + dotenv

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Debug: Check if env variables are loaded (remove after testing)
// var_dump($_ENV);

$id = (int)($_POST['id'] ?? 0);
$action = $_POST['action'] ?? '';

if ($id && in_array($action, ['approve', 'reject'])) {
    // Get volunteer data
    $stmt = $conn->prepare("SELECT full_name, email FROM volunteers WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($full_name, $email);
    $stmt->fetch();
    $stmt->close();

    if (!$full_name || !$email) {
        die("Volunteer not found.");
    }

    // Update status
    $status = $action === 'approve' ? 'approved' : 'rejected';
    $stmt = $conn->prepare("UPDATE volunteers SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();

    // Send email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USER'];
        $mail->Password   = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'] ?? PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = (int)$_ENV['SMTP_PORT'];

        $mail->setFrom($_ENV['SMTP_FROM_EMAIL'], $_ENV['SMTP_FROM_NAME']);
        $mail->addAddress($email, $full_name);

        $mail->isHTML(true);
        $mail->Subject = ($status === 'approved')
            ? 'Volunteer Application Approved'
            : 'Volunteer Application Rejected';

        if ($status === 'approved') {
            $mail->Body = "
                <h2>Hello {$full_name},</h2>
                <p>We’re excited to inform you that your volunteer application has been <strong>approved</strong>!</p>
                <p>We’ll be reaching out with more details soon.</p>
                <p>Thank you for joining our mission!</p>
            ";
        } else {
            $mail->Body = "
                <h2>Hello {$full_name},</h2>
                <p>Unfortunately, your volunteer application has been <strong>rejected</strong>.</p>
                <p>We truly appreciate your interest and encourage you to apply again in the future.</p>
            ";
        }

        $mail->AltBody = strip_tags($mail->Body);

        if (!$mail->send()) {
            throw new Exception($mail->ErrorInfo);
        }

    } catch (Exception $e) {
        error_log("Email sending failed: " . $e->getMessage());
      
        echo "Mailer Error: " . $e->getMessage();
        exit;
    }
}

// Redirect back to the same page
$redirect_page = $_SERVER['HTTP_REFERER'] ?? 'volunteer_pending.php';
$separator = (strpos($redirect_page, '?') !== false) ? '&' : '?';
header("Location: {$redirect_page}{$separator}msg=Request updated");
exit;
