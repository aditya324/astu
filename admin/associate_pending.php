<?php
require '../db.php';

// Only select pending associates (make sure your table has a status column)
$result = $conn->query("SELECT * FROM associates WHERE status='pending' ORDER BY submitted_at DESC");
?>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
        <h2 class="fw-bold text-primary mb-3">
            <i class="bi bi-person-badge me-2"></i>Pending Associates
        </h2>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Organization</th>
                        <th>Message</th>
                        <th>Submitted At</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td>
                                    <a href="mailto:<?= htmlspecialchars($row['email']) ?>" class="text-decoration-none">
                                        <?= htmlspecialchars($row['email']) ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($row['association_type']) ?></td>
                                <td><?= nl2br(htmlspecialchars($row['reason'])) ?></td>
                                <td><?= htmlspecialchars($row['submitted_at']) ?></td>
                                <td class="text-center">
                                    <form action="approve_associate.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="action" value="approve" class="btn btn-sm btn-success">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                    </form>
                                    <form action="approve_associate.php" method="POST" class="d-inline" onsubmit="return confirm('Reject this associate?');">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="action" value="reject" class="btn btn-sm btn-danger">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-info-circle me-2"></i>No pending associates found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
