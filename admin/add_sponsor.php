<?php
// admin/add_sponsor.php — pure POST handler (PRG safe redirect)

session_start();
require_once '../db.php';
require_once '../config.php';

// ---------- Helpers ----------
function e($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function safe_redirect(string $url){
    if (!headers_sent()) {
        header("Location: $url", true, 303); // 303 = See Other (PRG)
        exit;
    }
    $u = e($url);
    echo "<script>window.location.replace('{$u}');</script>";
    echo "<noscript><meta http-equiv='refresh' content='0;url={$u}'></noscript>";
    exit;
}

$redirectTo = dirname($_SERVER['PHP_SELF']) . '/admin_sponsors.php';

// ---------- CSRF ----------
if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
if ($_SERVER['REQUEST_METHOD'] !== 'POST') safe_redirect($redirectTo);
if (!isset($_POST['csrf']) || !hash_equals($_SESSION['csrf'], $_SESSION['csrf'])) {
    $_SESSION['flash_error'] = 'Invalid CSRF token.';
    safe_redirect($redirectTo);
}

// ---------- Upload utility ----------
$UPLOAD_DIR = __DIR__ . '/uploads/sponsers/';
$PUBLIC_DIR = 'uploads/sponsers/';
if (!is_dir($UPLOAD_DIR)) mkdir($UPLOAD_DIR, 0777, true);

function save_upload($field, $UPLOAD_DIR, $PUBLIC_DIR){
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
    $tmp = $_FILES[$field]['tmp_name'];
    $info = @getimagesize($tmp);
    if ($info === false) return null;
    if ($_FILES[$field]['size'] > 3*1024*1024) return null; // 3MB
    $ext = image_type_to_extension($info[2], true) ?: '.jpg';
    $base = preg_replace('/[^a-zA-Z0-9_\-]/','', pathinfo($_FILES[$field]['name'], PATHINFO_FILENAME)) ?: 'sponsor';
    $final = time().'_'.$base.$ext;
    $dest  = rtrim($UPLOAD_DIR,'/\\').DIRECTORY_SEPARATOR.$final;
    if (!move_uploaded_file($tmp, $dest)) return null;
    return rtrim($PUBLIC_DIR,'/').'/'.$final;
}

// ---------- ACTIONS ----------
try {
    $action = $_POST['action'] ?? $_POST['__action'] ?? '';

    if ($action === 'create') {
        $name   = trim($_POST['name'] ?? '');
        $amount = (float)($_POST['amount'] ?? 0);
        $img    = save_upload('image', $UPLOAD_DIR, $PUBLIC_DIR);
        if ($name==='' || $amount<=0 || !$img){
            $_SESSION['flash_error'] = 'Please provide valid name, amount and image.';
            safe_redirect($redirectTo);
        }
        $stmt = $conn->prepare("INSERT INTO sponsors (name, amount, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $name, $amount, $img);
        $stmt->execute();
        $_SESSION['flash_success'] = 'Sponsor added.';
        safe_redirect($redirectTo);
    }

    if ($action === 'update') {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $amount = (float)($_POST['amount'] ?? 0);
        if ($id<=0 || $name==='' || $amount<=0){
            $_SESSION['flash_error'] = 'Invalid update data.';
            safe_redirect($redirectTo);
        }
        $stmt = $conn->prepare("SELECT image FROM sponsors WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $old = $stmt->get_result()->fetch_assoc();

        $newImg = save_upload('image', $UPLOAD_DIR, $PUBLIC_DIR);
        if ($newImg){
            $stmt = $conn->prepare("UPDATE sponsors SET name=?, amount=?, image=? WHERE id=?");
            $stmt->bind_param("sdsi", $name, $amount, $newImg, $id);
            $stmt->execute();
            if ($old && !empty($old['image'])) {
                $oldFile = __DIR__ . '/' . $old['image'];
                if (is_file($oldFile)) @unlink($oldFile);
            }
        } else {
            $stmt = $conn->prepare("UPDATE sponsors SET name=?, amount=? WHERE id=?");
            $stmt->bind_param("sdi", $name, $amount, $id);
            $stmt->execute();
        }
        $_SESSION['flash_success'] = 'Sponsor updated.';
        safe_redirect($redirectTo);
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id<=0){
            $_SESSION['flash_error'] = 'Invalid sponsor ID.';
            safe_redirect($redirectTo);
        }
        $stmt = $conn->prepare("SELECT image FROM sponsors WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $old = $stmt->get_result()->fetch_assoc();

        $stmt = $conn->prepare("DELETE FROM sponsors WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($old && !empty($old['image'])) {
            $oldFile = __DIR__ . '/' . $old['image'];
            if (is_file($oldFile)) @unlink($oldFile);
        }

        $_SESSION['flash_success'] = 'Sponsor deleted.';
        safe_redirect($redirectTo);
    }

    $_SESSION['flash_error'] = 'Unknown action.';
    safe_redirect($redirectTo);

} catch (Throwable $e) {
    $_SESSION['flash_error'] = $e->getMessage();
    safe_redirect($redirectTo);
}
