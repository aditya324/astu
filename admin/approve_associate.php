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

$id = (int)($_POST['id'] ?? 0);
$action = $_POST['action'] ?? '';

if ($id && in_array($action, ['approve', 'reject'])) {
    // Get associate details
    $stmt = $conn->prepare("SELECT name, email FROM associates WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name, $email);
    $stmt->fetch();
    $stmt->close();

    if (!$name || !$email) {
        die("Associate not found.");
    }

    // Update status in DB
    $status = $action === 'approve' ? 'approved' : 'rejected';
    $stmt = $conn->prepare("UPDATE associates SET status=? WHERE id=?");
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
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = ($status === 'approved')
            ? 'Associate Application Approved'
            : 'Associate Application Rejected';

        if ($status === 'approved') {
            $mail->Body = "
                <h2>Hello {$name},</h2>
                <p>Your associate application has been <strong>approved</strong>!</p>
                <p>We’re excited to have you on board and will be sharing further details shortly.</p>
                <p>Thank you for joining us!</p>
            ";
        } else {
            $mail->Body = "
                <h2>Hello {$name},</h2>
                <p>We regret to inform you that your associate application has been <strong>rejected</strong>.</p>
                <p>We appreciate your interest and encourage you to apply again in the future.</p>
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

// Redirect back to same page
$redirect_page = $_SERVER['HTTP_REFERER'] ?? 'associate_pending.php';
$separator = (strpos($redirect_page, '?') !== false) ? '&' : '?';
header("Location: {$redirect_page}{$separator}msg=Request updated");
exit;
