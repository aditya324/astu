<?php
require '../db.php'; // change path to your db connection file

$limit = 5;
$page = isset($_GET['p']) ? intval($_GET['p']) : 1;
$page = max($page, 1);
$start = ($page - 1) * $limit;

// Count total records
$total_res = $conn->query("SELECT COUNT(*) AS total FROM donor_tax_claims");
$total_row = $total_res->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch page data
$sql = "SELECT * FROM donor_tax_claims ORDER BY created_at DESC LIMIT $start, $limit";
$result = $conn->query($sql);

$claims = [];
while ($row = $result->fetch_assoc()) {
    $claims[] = [
        'id' => $row['id'],
        'payment_id' => htmlspecialchars($row['payment_id']),
        'name' => htmlspecialchars($row['name']),
        'email' => htmlspecialchars($row['email']),
        'pan' => htmlspecialchars($row['pan']),
        'address' => htmlspecialchars($row['address']),
        'amount' => $row['amount'],
        'date' => $row['date'],
        'created_at' => $row['created_at']
    ];
}

echo json_encode([
    'claims' => $claims,
    'total_pages' => $total_pages
]);
