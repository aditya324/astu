<?php
require_once '../db.php';
require_once '../config.php';
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-8 col-xl-7">
      <div class="card shadow-sm border-0 rounded-4 p-4">
        <h2 class="mb-3 fw-bold text-primary">Add New Event</h2>

        <form action="../submit_events.php" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-image"></i> Event Image (310×300)</label>
            <input type="file" name="image" class="form-control" id="imageInput" accept="image/*" required>
            <div class="form-text text-danger" id="imageError" style="display:none;"></div>
          </div>

          <div class="mb-3">
            <label class="form-label"><i class="bi bi-card-text"></i> Event Title</label>
            <input type="text" name="title" class="form-control" placeholder="e.g., Health Camp for Women" required>
          </div>

          <div class="mb-3">
            <label class="form-label"><i class="bi bi-pencil-square"></i> Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Describe the event..." required></textarea>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label"><i class="bi bi-calendar-event text-primary"></i> Event Date</label>
              <input type="date" name="event_date" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label"><i class="bi bi-clock text-primary"></i> Event Time</label>
              <input type="time" name="event_time" class="form-control" required>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label"><i class="bi bi-geo-alt-fill"></i> Venue</label>
            <input type="text" name="venue" class="form-control" placeholder="e.g., Community Hall, Sector 21" required>
          </div>

          <div class="text-end">
            <button type="submit" name="submit" class="btn btn-primary">
              <i class="bi bi-plus-circle me-1"></i> Add Event
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Optional: quick preview of upcoming -->
    <div class="col-lg-4 col-xl-5 mt-4 mt-lg-0">
      <?php
      $today = date('Y-m-d');
      $upcoming = $conn->query("SELECT id,title,event_date,event_time,venue,image_path FROM events WHERE event_date >= '$today' ORDER BY event_date ASC LIMIT 6");
      ?>
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
          <h5 class="fw-semibold mb-3"><i class="bi bi-calendar2-week me-2"></i>Upcoming</h5>
          <?php if($upcoming && $upcoming->num_rows): ?>
            <div class="list-group">
              <?php while($e=$upcoming->fetch_assoc()): ?>
                <div class="list-group-item d-flex align-items-start">
                  <div class="me-3" style="width:56px;height:56px;overflow:hidden;border-radius:.5rem;background:#f1f5f9">
                    <?php if(!empty($e['image_path'])): ?>
                      <img src="<?= '../'.htmlspecialchars($e['image_path']) ?>" alt="" style="width:100%;height:100%;object-fit:cover">
                    <?php endif; ?>
                  </div>
                  <div class="flex-fill">
                    <div class="fw-semibold"><?= htmlspecialchars($e['title']) ?></div>
                    <div class="small text-muted">
                      <?= htmlspecialchars($e['event_date']) ?> · <?= htmlspecialchars($e['event_time']) ?>
                    </div>
                    <div class="small"><?= htmlspecialchars($e['venue']) ?></div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          <?php else: ?>
            <div class="text-muted">No upcoming events.</div>
          <?php endif; ?>
        </div>
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
