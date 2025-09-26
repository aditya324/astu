<?php
// verify_payment.php

require 'vendor/autoload.php';
require 'db.php';

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function sendPaymentEmail($toEmail, $toName, $razorpayPaymentId)
{
    $mail = new PHPMailer(true);
    try {
        // SMTP Config
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USER'];
        $mail->Password   = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
        $mail->Port       = $_ENV['SMTP_PORT'];

        // From & To
        $mail->setFrom($_ENV['SMTP_USER'], $_ENV['SMTP_FROM_NAME']);
        $mail->addAddress($toEmail, $toName);

        // Subject & Body
        $mail->isHTML(true);
        $mail->Subject = "Payment Successful";

        $baseUrl = rtrim($_ENV['APP_URL'], '/');
        $claimUrl = $baseUrl . "/claim-tax-benefit.php?payment_id=" . urlencode($razorpayPaymentId);

        $mail->Body = "
            <h2>Thank you for your donation!</h2>
            <p>We have received your payment successfully. Your Razorpay Payment ID is: <strong>$razorpayPaymentId</strong></p>
            <p>If you would like to claim your 80G tax benefit, please click the button below to fill out the form and download your certificate.</p>
            <a href='$claimUrl' style='
                display: inline-block;
                padding: 10px 20px;s
                color: white;
                background-color: #28a745;
                text-decoration: none;
                border-radius: 5px;
            '>Claim Tax Benefit</a>
        ";

        $mail->AltBody = "Thank you for your donation. Claim your 80G tax benefit here: $claimUrl";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email Error: " . $mail->ErrorInfo);
        return false;
    }
}

$input = json_decode(file_get_contents('php://input'), true);

$success = false;
$error = "Payment Failed";

if (!empty($input['razorpay_payment_id'])) {
    $api = new Api($_ENV['RAZORPAY_KEY_ID'], $_ENV['RAZORPAY_KEY_SECRET']);

    try {
        $attributes = [
            'razorpay_order_id' => $input['razorpay_order_id'],
            'razorpay_payment_id' => $input['razorpay_payment_id'],
            'razorpay_signature' => $input['razorpay_signature']
        ];
        $api->utility->verifyPaymentSignature($attributes);
        $success = true;
    } catch (SignatureVerificationError $e) {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true) {
    $name = $input['name'];
    $email = $input['email'];
    $phone = $input['phone'];
    $amount = $input['amount'];
    $payment_id = $input['razorpay_payment_id'];
    $order_id = $input['razorpay_order_id'];

    $sql = "INSERT INTO donations (name, email, phone, amount, razorpay_payment_id, razorpay_order_id, status) VALUES (?, ?, ?, ?, ?, ?, 'success')";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssdss", $name, $email, $phone, $amount, $payment_id, $order_id);
        $stmt->execute();
        $stmt->close();


        sendPaymentEmail($email, $name, $payment_id);
    }

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $error]);
}

$conn->close();
