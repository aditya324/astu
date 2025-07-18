<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // if installed via Composer

function sendMail($subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com';  // e.g. smtp.gmail.com or smtp.hostinger.com
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your_email@example.com';
        $mail->Password   = 'your_email_password';
        $mail->SMTPSecure = 'tls'; // or 'ssl'
        $mail->Port       = 587;   // or 465 for SSL

        // Recipients
        $mail->setFrom('your_email@example.com', 'Astu Foundation');
        $mail->addAddress('admin_email@example.com'); // Admin's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
?>
