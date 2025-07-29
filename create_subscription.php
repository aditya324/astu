<?php
// FILE: create_subscription.php
ini_set('display_errors', 0);
error_reporting(0);
require 'vendor/autoload.php';
require_once 'db.php'; // Your DB connection
use Razorpay\Api\Api;

// Load .env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');

if (empty($data['amount']) || empty($data['name']) || empty($data['email'])) {
    echo json_encode(['error' => 'Missing required fields.']);
    exit;
}

$api = new Api($_ENV['RAZORPAY_KEY_ID'], $_ENV['RAZORPAY_KEY_SECRET']);
$amountInPaise = (int)$data['amount'] * 100;

try {
    // STEP 1: Create a Plan
    $plan = $api->plan->create([
        'period' => 'monthly',
        'interval' => 1,
        'item' => [
            'name' => 'Monthly Donation of INR ' . $data['amount'],
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'description' => 'Monthly contribution to Astu Foundation'
        ]
    ]);

    // STEP 2: Create a Subscription using the Plan ID
    $subscription = $api->subscription->create([
        'plan_id' => $plan->id,
        'total_count' => 24, // The subscription will run for 24 months. Adjust as needed.
        'quantity' => 1,
        'customer_notify' => 1, // Let Razorpay handle notifications
        'notes' => [
            'donor_name' => $data['name'],
            'donor_email' => $data['email']
        ]
    ]);

    // Store subscription details in your database BEFORE sending to frontend
    $stmt = $conn->prepare("INSERT INTO subscriptions (donor_name, donor_email, donor_phone, plan_id, subscription_id, amount, status) VALUES (?, ?, ?, ?, ?, ?, 'created')");
    
    // MODIFICATION: Corrected the data types in this line
    $stmt->bind_param("sssssd", $data['name'], $data['email'], $data['phone'], $plan->id, $subscription->id, $data['amount']);
    
    $stmt->execute();
    
    // Send the subscription ID back to the frontend
    echo json_encode(['id' => $subscription->id]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}