<?php
require '../db.php';

$limit = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1);
$start = ($page - 1) * $limit;

// Get total donations
$total_result = $conn->query("SELECT COUNT(*) AS total FROM donations");
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch donations for this page
$sql = "SELECT * FROM donations ORDER BY donated_at DESC LIMIT $start, $limit";
$result = $conn->query($sql);

$donations = [];
while ($row = $result->fetch_assoc()) {
    $donations[] = [
        'id' => $row['id'],
        'name' => htmlspecialchars($row['name']),
        'email' => htmlspecialchars($row['email']),
        'phone' => htmlspecialchars($row['phone']),
        'amount' => $row['amount'],
        'razorpay_payment_id' => htmlspecialchars($row['razorpay_payment_id']),
        'razorpay_order_id' => htmlspecialchars($row['razorpay_order_id']),
        'status' => htmlspecialchars($row['status']),
        'donated_at' => $row['donated_at'],
    ];
}

echo json_encode([
    'donations' => $donations,
    'total_pages' => $total_pages
]);
