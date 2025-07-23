<?php
// create_order.php

require 'vendor/autoload.php';
use Razorpay\Api\Api;

header('Content-Type: application/json');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$input = json_decode(file_get_contents('php://input'), true);
$amount = $input['amount'];

if (empty($amount) || !is_numeric($amount)) {
    echo json_encode(['error' => 'Invalid amount']);
    exit;
}

$api = new Api($_ENV['RAZORPAY_KEY_ID'], $_ENV['RAZORPAY_KEY_SECRET']);


$amountInPaisa = $amount * 100;
$currency = 'INR';

$orderData = [
    'receipt'         => 'rcpt_' . time(),
    'amount'          => $amountInPaisa,
    'currency'        => $currency,
    'payment_capture' => 1 
];

$razorpayOrder = $api->order->create($orderData);

echo json_encode($razorpayOrder->toArray());
?>