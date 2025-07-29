<?php
// FILE: webhook_handler.php

require 'vendor/autoload.php';
require_once 'db.php'; // Your DB connection

// Use the Utility class
use Razorpay\Api\Utility;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get the webhook body and signature
$payload = file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'];
$webhook_secret = $_ENV['RAZORPAY_WEBHOOK_SECRET'];

// Verify the webhook signature
try {

    $utility = new Utility();
    $utility->verifyWebhookSignature($payload, $sig_header, $webhook_secret);

} catch (Exception $e) {

    http_response_code(400);
    error_log('Webhook signature verification failed: ' . $e->getMessage());
    exit();
}

// Decode the payload
$data = json_decode($payload, true);
$event = $data['event'];

// Use a switch to handle different events
switch ($event) {
    case 'subscription.charged':
        $subscription = $data['payload']['subscription']['entity'];
        $payment = $data['payload']['payment']['entity'];

        // Logic for a successful charge:
        // 1. Find the subscription in your DB
        $sub_id = $subscription['id'];
        $status = $subscription['status']; // Should be 'active'
        $amount = $payment['amount'] / 100;

        // 2. Update your subscription table (e.g., status and last payment date)
        $stmt_sub = $conn->prepare("UPDATE subscriptions SET status = ?, last_payment_at = NOW() WHERE subscription_id = ?");
        $stmt_sub->bind_param("ss", $status, $sub_id);
        $stmt_sub->execute();

        // 3. Add a record to your main donations table for accounting
        // Ensure you have a donations table that can accept these columns
        $donor_name = $subscription['notes']['donor_name'] ?? 'N/A';
        $donor_email = $subscription['notes']['donor_email'] ?? 'N/A';
        
        $stmt_don = $conn->prepare("INSERT INTO donations (name, email, amount, payment_id, status, subscription_id) VALUES (?, ?, ?, ?, 'success', ?)");
        $stmt_don->bind_param("ssdss", $donor_name, $donor_email, $amount, $payment['id'], $sub_id);
        $stmt_don->execute();
        
        break;

    case 'subscription.halted':
    case 'subscription.cancelled':
        $subscription = $data['payload']['subscription']['entity'];
        $sub_id = $subscription['id'];
        $new_status = $subscription['status'];

        // Update the status in your subscriptions table
        $stmt = $conn->prepare("UPDATE subscriptions SET status = ? WHERE subscription_id = ?");
        $stmt->bind_param("ss", $new_status, $sub_id);
        $stmt->execute();
        
        break;
}

// Respond to Razorpay to acknowledge receipt
http_response_code(200);