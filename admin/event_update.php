<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: ../login.php?error=auth");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: index.php?page=events_manage");
  exit;
}

if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
  http_response_code(403);
  exit('Invalid CSRF token.');
}

require_once '../db.php';

// Helpers
function isPathInside($base, $path) {
  $realBase = realpath($base);
  $realPath = realpath($path);
  return $realBase && $realPath && str_starts_with($realPath, $realBase);
}

$id          = (int)($_POST['id'] ?? 0);
$title       = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$event_date  = $_POST['event_date'] ?? '';
$event_time  = $_POST['event_time'] ?? '';
$venue       = trim($_POST['venue'] ?? '');
$old_image   = trim($_POST['old_image_path'] ?? '');

if (!$id || !$title || !$description || !$event_date || !$event_time || !$venue) {
  header("Location: index.php?page=event_edit&id={$id}&err=missing");
  exit;
}

$newPath = $old_image;

// Optional image upload
if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
  $tmp = $_FILES['image']['tmp_name'];
  $info = getimagesize($tmp);
  if ($info === false) {
    header("Location: index.php?page=event_edit&id={$id}&err=imgtype");
    exit;
  }
  // (Optional) Server-side dimension check
  if ($info[0] != 310 || $info[1] != 300) {
    header("Location: index.php?page=event_edit&id={$id}&err=imgsize");
    exit;
  }

  $ext = image_type_to_extension($info[2], true); // e.g., .jpg
  $allowed = ['.jpg','.jpeg','.png','.webp'];
  if (!in_array(strtolower($ext), $allowed)) {
    header("Location: index.php?page=event_edit&id={$id}&err=imgext");
    exit;
  }

  // Save file
  $uploadDir = dirname(__DIR__) . '/uploads/events';
  if (!is_dir($uploadDir)) { mkdir($uploadDir, 0775, true); }

  $fname = 'event_' . $id . '_' . time() . $ext;
  $destAbs = $uploadDir . '/' . $fname;

  if (!move_uploaded_file($tmp, $destAbs)) {
    header("Location: index.php?page=event_edit&id={$id}&err=savefail");
    exit;
  }

  // Build relative path to store in DB (e.g., uploads/events/xxx.jpg)
  $newPath = 'uploads/events/' . $fname;

  // Delete old file if inside uploads/events
  if (!empty($old_image)) {
    $oldAbs = dirname(__DIR__) . '/' . $old_image;
    if (file_exists($oldAbs) && isPathInside(dirname(__DIR__) . '/uploads/events', $oldAbs)) {
      @unlink($oldAbs);
    }
  }
}

$stmt = $conn->prepare("UPDATE events SET title=?, description=?, event_date=?, event_time=?, venue=?, image_path=?, updated_at=NOW() WHERE id=?");
$stmt->bind_param("ssssssi", $title, $description, $event_date, $event_time, $venue, $newPath, $id);
$stmt->execute();
$stmt->close();

$conn->close();
header("Location: index.php?page=events_manage&msg=Event updated");
exit;
