<?php
require_once '../db.php';
require_once '../config.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$rows = $conn->query("SELECT id,title,event_date,event_time,venue FROM events ORDER BY event_date DESC, id DESC");
?>
<div class="card shadow-sm border-0 rounded-4">
  <div class="card-body">
    <h2 class="fw-bold text-primary mb-3"><i class="bi bi-calendar3 me-2"></i>Manage Events</h2>

    <?php if(!empty($_GET['msg'])): ?>
      <div class="alert alert-success py-2 mb-3"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>

    <div class="table-responsive">
      <table class="table align-middle">
        <thead><tr>
          <th>Title</th><th>Date</th><th>Time</th><th>Venue</th><th class="text-end">Actions</th>
        </tr></thead>
        <tbody>
        <?php if($rows && $rows->num_rows): while($r=$rows->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($r['title']) ?></td>
            <td><?= htmlspecialchars($r['event_date']) ?></td>
            <td><?= htmlspecialchars($r['event_time']) ?></td>
            <td><?= htmlspecialchars($r['venue']) ?></td>
            <td class="text-end d-flex gap-2 justify-content-end">
              <a href="?page=event_edit&id=<?= (int)$r['id'] ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="event_delete.php" method="POST" onsubmit="return confirm('Delete this event? This cannot be undone.');">
                <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        <?php endwhile; else: ?>
          <tr><td colspan="5" class="text-muted">No events found.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
