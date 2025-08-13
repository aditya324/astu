<?php
// db.php — Your database connection
require '../db.php';

// Pagination settings
$limit = 5; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Ensure page is at least 1
if ($page < 1) {
    $page = 1;
}

$start = ($page - 1) * $limit;

// Get total records
$result = $conn->query("SELECT COUNT(*) AS total FROM donations");
$row = $result->fetch_assoc();
$total_records = $row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch paginated records
$sql = "SELECT * FROM donations ORDER BY donated_at DESC LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donations List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        .pagination {
            margin-top: 15px;
            text-align: center;
        }
        .pagination a {
            padding: 6px 12px;
            border: 1px solid #ccc;
            margin: 0 2px;
            text-decoration: none;
            color: black;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
        }
        .pagination a.disabled {
            pointer-events: none;
            background-color: #eee;
            color: #777;
        }
    </style>
</head>
<body>

<h2>Donations Table</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Amount</th>
        <th>Razorpay Payment ID</th>
        <th>Razorpay Order ID</th>
        <th>Status</th>
        <th>Donated At</th>
    </tr>
    <?php if ($result->num_rows > 0) { ?>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= number_format($row['amount'], 2) ?></td>
                <td><?= htmlspecialchars($row['razorpay_payment_id']) ?></td>
                <td><?= htmlspecialchars($row['razorpay_order_id']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td><?= $row['donated_at'] ?></td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="9">No donations found</td>
        </tr>
    <?php } ?>
</table>

<div class="pagination">
    <a href="?page=<?= $page - 1 ?>" class="<?= ($page <= 1) ? 'disabled' : '' ?>">Prev</a>

    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
        <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
    <?php } ?>

    <a href="?page=<?= $page + 1 ?>" class="<?= ($page >= $total_pages) ? 'disabled' : '' ?>">Next</a>
</div>

</body>
</html>
