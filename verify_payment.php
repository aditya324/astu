<?php
// verify_payment.php

require 'vendor/autoload.php';
require 'db.php';
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

header('Content-Type: application/json');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$input = json_decode(file_get_contents('php://input'), true);

$success = false;
$error = "Payment Failed";

if (empty($input['razorpay_payment_id']) === false) {
    $api = new Api($_ENV['RAZORPAY_KEY_ID'], $_ENV['RAZORPAY_KEY_SECRET']);

    try {
        $attributes = [
            'razorpay_order_id' => $input['razorpay_order_id'],
            'razorpay_payment_id' => $input['razorpay_payment_id'],
            'razorpay_signature' => $input['razorpay_signature']
        ];
        // This is the crucial security step
        $api->utility->verifyPaymentSignature($attributes);
        $success = true;
    } catch (SignatureVerificationError $e) {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true) {
    // Signature is valid, so we can save the donation to the database
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
    }
    
    echo json_encode(['status' => 'success']);
} else {
    // Signature is invalid
    echo json_encode(['status' => 'error', 'message' => $error]);
}

$conn->close();
?>