<?php
require_once '../db.php';
require_once '../config.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  echo '<div class="alert alert-danger">Invalid event ID.</div>';
  exit;
}
$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT id,title,description,event_date,event_time,venue,image_path FROM events WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$event) {
  echo '<div class="alert alert-warning">Event not found.</div>';
  exit;
}
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-8 col-xl-7">
      <div class="card shadow-sm border-0 rounded-4 p-4">
        <h2 class="mb-3 fw-bold text-primary">Edit Event</h2>

        <form action="event_update.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= (int)$event['id'] ?>">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
          <input type="hidden" name="old_image_path" value="<?= htmlspecialchars($event['image_path']) ?>">

          <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            <?php if(!empty($event['image_path'])): ?>
              <img src="<?= '../'.htmlspecialchars($event['image_path']) ?>" alt="" style="max-width:200px;border-radius:.5rem">
            <?php else: ?>
              <span class="text-muted">No image</span>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label class="form-label"><i class="bi bi-image"></i> Replace Image (310×300) – optional</label>
            <input type="file" name="image" class="form-control" id="imageInput" accept="image/*">
            <div class="form-text text-danger" id="imageError" style="display:none;"></div>
          </div>

          <div class="mb-3">
            <label class="form-label"><i class="bi bi-card-text"></i> Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($event['title']) ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label"><i class="bi bi-pencil-square"></i> Description</label>
            <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($event['description']) ?></textarea>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label"><i class="bi bi-calendar-event text-primary"></i> Event Date</label>
              <input type="date" name="event_date" class="form-control" value="<?= htmlspecialchars($event['event_date']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label"><i class="bi bi-clock text-primary"></i> Event Time</label>
              <input type="time" name="event_time" class="form-control" value="<?= htmlspecialchars($event['event_time']) ?>" required>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label"><i class="bi bi-geo-alt-fill"></i> Venue</label>
            <input type="text" name="venue" class="form-control" value="<?= htmlspecialchars($event['venue']) ?>" required>
          </div>

          <div class="d-flex gap-2">
            <a href="index.php?page=events_manage" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save me-1"></i> Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
const imageInput = document.getElementById('imageInput');
const imageError = document.getElementById('imageError');
imageInput?.addEventListener('change', function(){
  const file = this.files[0]; if(!file) return;
  const img = new Image(); img.src = URL.createObjectURL(file);
  img.onload = function(){
    const w = img.naturalWidth, h = img.naturalHeight;
    const reqW = 310, reqH = 300;
    if (w !== reqW || h !== reqH){
      imageError.style.display = "block";
      imageError.innerText = `Image must be exactly ${reqW}×${reqH}px. Current: ${w}×${h}px.`;
      imageInput.value = '';
    } else { imageError.style.display = "none"; }
  };
});
</script>
