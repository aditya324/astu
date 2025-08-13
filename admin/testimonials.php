<?php
require '../db.php';

// Fetch pending testimonials
$result = $conn->query("SELECT * FROM testimonials WHERE status='pending'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Approve Testimonials</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h2 class="mb-4">Pending Testimonials</h2>
    <?php if ($result->num_rows > 0) { ?>
    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Testimonial</th>
                <th>Image</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['testimonial'])) ?></td>
                <td>
                    <?php if (!empty($row['image']) && file_exists("../uploads/testimonials/" . $row['image'])) { ?>
                        <img src="../uploads/testimonials/<?= htmlspecialchars($row['image']) ?>" 
                             alt="Testimonial Image" 
                             class="img-thumbnail" 
                             style="width:120px; height:auto;">
                    <?php } else { ?>
                        <span class="text-muted">No image</span>
                    <?php } ?>
                </td>
                <td class="text-center">
                    <a href="update_testimonial_status.php?action=approve&id=<?= $row['id'] ?>" class="btn btn-success btn-sm me-1">Approve</a>
                    <a href="update_testimonial_status.php?action=reject&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Reject</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <div class="alert alert-info">No pending testimonials found.</div>
    <?php } ?>
</div>
</body>
</html>
