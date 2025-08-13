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

// Get image_path first
$id = (int)($_POST['id'] ?? 0);
if (!$id) {
  header("Location: index.php?page=events_manage&msg=Invalid+ID");
  exit;
}

$stmt = $conn->prepare("SELECT image_path FROM events WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($image_path);
$stmt->fetch();
$stmt->close();

// Delete row
$stmt = $conn->prepare("DELETE FROM events WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Safe unlink image
function isPathInside($base, $path) {
  $realBase = realpath($base);
  $realPath = realpath($path);
  return $realBase && $realPath && str_starts_with($realPath, $realBase);
}
if (!empty($image_path)) {
  $abs = dirname(__DIR__) . '/' . $image_path;
  $uploadBase = dirname(__DIR__) . '/uploads/events';
  if (file_exists($abs) && isPathInside($uploadBase, $abs)) {
    @unlink($abs);
  }
}

$conn->close();
header("Location: index.php?page=events_manage&msg=Event+deleted");
exit;
