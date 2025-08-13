<?php
require '../db.php';

if (isset($_GET['id'], $_GET['action'])) {
    $id = intval($_GET['id']);
    $status = ($_GET['action'] === 'approve') ? 'approved' : 'rejected';

    $stmt = $conn->prepare("UPDATE testimonials SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to admin testimonials page
header("Location: /admin/index.php?page=testimonials");
exit;
