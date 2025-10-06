<?php
// associate_form.php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// --- .env ---
if (class_exists('\\Dotenv\\Dotenv')) {
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->safeLoad();
}

// helper to read env (supports $_ENV/$_SERVER/getenv)
function envv($k, $d = null) {
  $v = getenv($k);
  if ($v === false && isset($_ENV[$k])) $v = $_ENV[$k];
  if ($v === false && isset($_SERVER[$k])) $v = $_SERVER[$k];
  return ($v === false || $v === null || $v === '') ? $d : $v;
}

// toggle SMTP transcript on the page while testing (set false in production)
$SHOW_SMTP_DEBUG = false;

// on submit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  require_once 'db.php';

  // sanitize
  $name   = trim($_POST['name']   ?? '');
  $email  = trim($_POST['email']  ?? '');
  $phone  = trim($_POST['phone']  ?? '');
  $type   = trim($_POST['type']   ?? '');
  $reason = trim($_POST['reason'] ?? '');

  // validate
  if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $phone === '' || $type === '' || $reason === '') {
    $_SESSION['form_status'] = ['type' => 'danger', 'message' => 'Please fill all required fields with valid information.'];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }

  // insert
  $sql = "INSERT INTO associates (name, email, phone, association_type, reason) VALUES (?, ?, ?, ?, ?)";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sssss", $name, $email, $phone, $type, $reason);
    $ok = $stmt->execute();
    $stmt->close();
  } else {
    $_SESSION['form_status'] = ['type' => 'danger', 'message' => 'Database error: unable to prepare statement.'];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }
  $conn->close();

  if (!$ok) {
    $_SESSION['form_status'] = ['type' => 'danger', 'message' => 'Database insert failed. Please try again.'];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }

  // ---- SMTP config (supports both naming styles) ----
  $smtp_host     = envv('SMTP_HOST', 'smtp.gmail.com');
  $smtp_port     = (int) envv('SMTP_PORT', 587);
  $smtp_username = trim(envv('SMTP_USERNAME', envv('SMTP_USER', '')));
  $smtp_password = trim(envv('SMTP_PASSWORD', envv('SMTP_PASS', '')));
  $admin_email   = envv('ADMIN_EMAIL', $smtp_username);

  // optional debug recipient
  $test_gmail    = trim(envv('TEST_GMAIL', ''));

  // helpers
  $safe = fn($v) => htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
  $when = date('F j, Y, g:i a');

  // Admin email body
  $adminHTML = "
<div style='font-family: Arial, sans-serif; line-height:1.6;'>
  <h2 style='color:#0d5a66;margin:0 0 8px;'>New Association Inquiry</h2>
  <p style='margin:0 0 12px;'>An inquiry was submitted on {$when} with the following details:</p>
  <table cellpadding='10' border='1' style='border-collapse: collapse; width: 100%;'>
    <tr style='background-color:#f2f2f2;'><td style='width: 180px;'><strong>Full Name</strong></td><td>{$safe($name)}</td></tr>
    <tr><td><strong>Email Address</strong></td><td>{$safe($email)}</td></tr>
    <tr style='background-color:#f2f2f2;'><td><strong>Phone Number</strong></td><td>{$safe($phone)}</td></tr>
    <tr><td><strong>Type of Association</strong></td><td>{$safe($type)}</td></tr>
    <tr style='background-color:#f2f2f2;'><td><strong>Reason to Associate</strong></td><td>" . nl2br($safe($reason)) . "</td></tr>
  </table>
</div>";
  $adminAlt = "New Association Inquiry\n\nName: {$name}\nEmail: {$email}\nPhone: {$phone}\nType: {$type}\nReason: " . str_replace(["\r", "\n"], [' ', ' '], $reason);

  // Applicant confirmation body
  $userHTML = "
<div style='font-family: Arial, sans-serif; line-height:1.6;'>
  <p>Hi {$safe($name)},</p>
  <p>Thank you for your interest in associating with <strong>Astu Foundation</strong>! We’ve received your submission and our team will get back to you shortly.</p>
  <p><strong>Your details</strong></p>
  <ul style='line-height:1.8;'>
    <li>Email: {$safe($email)}</li>
    <li>Phone: {$safe($phone)}</li>
    <li>Type of Association: {$safe($type)}</li>
  </ul>
  <p style='margin-top:12px;'>Warm regards,<br>Astu Foundation</p>
</div>";
  $userAlt = "Hi {$name},\n\nThank you for your interest in associating with Astu Foundation! We’ll get back to you shortly.\n\n- Astu Foundation";

  // function to send a single email
  $sendOne = function(string $toEmail, string $toName, string $subject, string $html, string $alt, bool $replyToAdmin = true) use ($smtp_host, $smtp_port, $smtp_username, $smtp_password, $admin_email, $SHOW_SMTP_DEBUG) {
    $trace = '';
    $m = new PHPMailer(true);
    $m->isSMTP();
    $m->Host       = $smtp_host;
    $m->SMTPAuth   = true;
    $m->Username   = $smtp_username;
    $m->Password   = $smtp_password;
    $m->SMTPSecure = ($smtp_port === 465) ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
    $m->Port       = $smtp_port ?: 587;
    $m->CharSet    = 'UTF-8';
    $m->SMTPAutoTLS = true;

    if ($SHOW_SMTP_DEBUG) {
      $m->SMTPDebug = 2;
      $m->Debugoutput = function($str, $level) use (&$trace) {
        $trace .= "[$level] $str\n";
      };
    }

    // From must equal the authenticated mailbox
    $m->setFrom($smtp_username, 'Astu Foundation');

    // Helpful for DMARC/bounces (ensure this exists/accepted on your domain)
    $domain = substr(strrchr($smtp_username, "@"), 1);
    if ($domain) $m->Sender = 'bounce@' . $domain;

    $m->addAddress($toEmail, $toName);

    if ($replyToAdmin) {
      $m->addReplyTo($admin_email ?: $smtp_username, 'Astu Foundation');
    }

    $m->isHTML(true);
    $m->Subject = $subject;
    $m->Body    = $html;
    $m->AltBody = $alt;

    $m->send();
    return $trace;
  };

  $smtp_trace_all = "";

  try {
    if (!$smtp_username || !$smtp_password) {
      throw new Exception('SMTP not configured: missing SMTP_USERNAME/SMTP_PASSWORD (or SMTP_USER/SMTP_PASS).');
    }

    // 1) Admin notification (and optional test copy)
    $adminTrace = '';
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $smtp_host;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtp_username;
    $mail->Password   = $smtp_password;
    $mail->SMTPSecure = ($smtp_port === 465) ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $smtp_port ?: 587;
    $mail->CharSet    = 'UTF-8';
    $mail->SMTPAutoTLS = true;

    if ($SHOW_SMTP_DEBUG) {
      $mail->SMTPDebug = 2;
      $mail->Debugoutput = function($str, $level) use (&$adminTrace) {
        $adminTrace .= "[$level] $str\n";
      };
    }

    $mail->setFrom($smtp_username, 'Astu Foundation');
    $domain = substr(strrchr($smtp_username, "@"), 1);
    if ($domain) $mail->Sender = 'bounce@' . $domain;

    if ($admin_email) $mail->addAddress($admin_email, 'Admin');
    if ($smtp_username && $smtp_username !== $admin_email) {
      $mail->addAddress($smtp_username, 'Admin Copy');
    }
    if (!empty($test_gmail) && filter_var($test_gmail, FILTER_VALIDATE_EMAIL)) {
      $mail->addAddress($test_gmail, 'Test Copy');
    }

    // replies go to the applicant
    $mail->addReplyTo($email, $name);

    $mail->isHTML(true);
    $mail->Subject = 'New Association Inquiry from: ' . $safe($name);
    $mail->Body    = $adminHTML;
    $mail->AltBody = $adminAlt;

    $mail->send();

    // 2) Applicant confirmation
    $userTrace = $sendOne($email, $name, 'Thank you for associating with Astu Foundation', $userHTML, $userAlt, true);

    if ($SHOW_SMTP_DEBUG) {
      $smtp_trace_all = "ADMIN MAIL:\n" . $adminTrace . "\n\nAPPLICANT MAIL:\n" . $userTrace;
    }

    $msg = 'Thank you! Your form has been submitted successfully.';
    if ($SHOW_SMTP_DEBUG && $smtp_trace_all) {
      $msg .= "\n\nSMTP transcript:\n" . $smtp_trace_all;
    }
    $_SESSION['form_status'] = ['type' => 'success', 'message' => nl2br($msg)];
  } catch (Exception $e) {
    $err = 'Mail failed: ' . (isset($mail) && $mail->ErrorInfo ? $mail->ErrorInfo : $e->getMessage());
    if ($SHOW_SMTP_DEBUG && $smtp_trace_all) {
      $err .= "\n\nSMTP transcript:\n" . $smtp_trace_all;
    }
    $_SESSION['form_status'] = ['type' => 'warning', 'message' => nl2br("Your form was saved, but emails could not be sent.\n\n$err")];
  }

  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Nonprts-Nonprofit Charity HTML5 Template </title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Favicon -->
	<link rel="icon" type="image/png" sizes="56x56" href="assets/images/fav-icon/icon.png">
	<!-- bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" media="all">
	<!-- carousel CSS -->
	<link rel="stylesheet" href="assets/css/owl.carousel.min.css" type="text/css" media="all">
	<!-- animate CSS -->
	<link rel="stylesheet" href="assets/css/animate.css" type="text/css" media="all">
	<!-- font-awesome CSS -->
	<link rel="stylesheet" href="assets/css/all.min.css" type="text/css" media="all">
	<!-- font-flaticon CSS -->
	<link rel="stylesheet" href="assets/css/flaticon.css" type="text/css" media="all">
	<!-- theme-default CSS -->
	<link rel="stylesheet" href="assets/css/theme-default.css" type="text/css" media="all">
	<!-- meanmenu CSS -->
	<link rel="stylesheet" href="assets/css/meanmenu.min.css" type="text/css" media="all">
	<!-- transitions CSS -->
	<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css" media="all">
	<!-- venobox CSS -->
	<link rel="stylesheet" href="venobox/venobox.css" type="text/css" media="all">
	<!-- bootstrap icons -->
	<link rel="stylesheet" href="assets/css/bootstrap-icons.css" type="text/css" media="all">
	<!-- Slick Slider -->
	<link rel="stylesheet" type="text/css" href="assets/slick/slick.css">
	<link rel="stylesheet" type="text/css" href="assets/slick/slick-theme.css">
	<!-- Main Style CSS -->
	<link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all">
	<!-- Dropdown CSS -->
	<link rel="stylesheet" href="assets/css/dropdown.css" type="text/css" media="all">
	<!-- responsive CSS -->
	<link rel="stylesheet" href="assets/css/responsive.css" type="text/css" media="all">
	<!-- rangeslider CSS -->
	<link rel="stylesheet" href="assets/css/rangeslider.css" type="text/css" media="all">
	<!-- modernizr js -->
	<script src="assets/js/vendor/modernizr-3.5.0.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
</head>

<body class="bg-light">
  <?php require "header.php" ?>

  <div class="container mt-5">
    <div class="col-md-8 mx-auto">
      <h2 class="mb-4 text-center">Associate with Astu Foundation</h2>

      <?php
      if (isset($_SESSION['form_status'])) {
        $status = $_SESSION['form_status'];
        echo '<div class="alert alert-' . htmlspecialchars($status['type']) . ' alert-dismissible fade show" role="alert" style="white-space:pre-wrap;">'
          . ($status['message']) .
          '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['form_status']);
      }
      ?>

      <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" style="margin-bottom: 10px;">
        <div class="mb-3">
          <label for="name" class="form-label" style="color: black;">Full Name</label>
          <input type="text" class="form-control" name="name" id="name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label" style="color: black;">Email ID</label>
          <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label" style="color: black;">Phone Number</label>
          <input type="tel" class="form-control" name="phone" id="phone" required>
        </div>
        <div class="mb-3">
          <label for="type" class="form-label" style="color: black;">Type of Association</label>
          <select class="form-select" name="type" id="type" required>
            <option value="" disabled selected>Select an option</option>
            <option value="Individual">Individual</option>
            <option value="Organization">Organization</option>
            <option value="Corporate">Corporate</option>
            <option value="NGO">NGO</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="reason" class="form-label" style="color: black;">Why do you want to associate?</label>
          <textarea class="form-control" name="reason" id="reason" rows="4" required></textarea>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-success btn-lg" style="background-color:#DF5311">Submit Form</button>
        </div>
      </form>
    </div>
  </div>

  <?php require "footer.php" ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/vendor/jquery-3.6.2.min.js"></script>

	<script src="assets/js/popper.min.js"></script>

	<!-- bootstrap js -->
	<script src="assets/js/bootstrap.min.js"></script>

	<!-- carousel js -->
	<script src="assets/js/owl.carousel.min.js"></script>

	<!-- counterup js -->
	<script src="assets/js/jquery.counterup.min.js"></script>

	<!-- waypoints js -->
	<script src="assets/js/waypoints.min.js"></script>

	<!-- wow js -->
	<script src="assets/js/wow.min.js"></script>

	<!-- imagesloaded js -->
	<script src="assets/js/imagesloaded.pkgd.min.js"></script>

	<!-- venobox js -->
	<script src="venobox/venobox.js"></script>

	<!--  animated-text js -->
	<script src="assets/js/animated-text.js"></script>

	<!-- venobox min js -->
	<script src="venobox/venobox.min.js"></script>

	<!-- isotope js -->
	<script src="assets/js/isotope.pkgd.min.js"></script>

	<!-- jquery meanmenu js -->
	<script src="assets/js/jquery.meanmenu.js"></script>

	<!-- jquery scrollup js -->
	<script src="assets/js/jquery.scrollUp.js"></script>

	<!-- Slick Slider -->
	<script src="assets/slick/slick.min.js"></script>

	<script src="assets/js/jquery.barfiller.js"></script>
	<!-- jquery js -->

	<!-- ragrslider js -->
	<script src="assets/js/rangeslider.js"></script>

	<!-- ragrslider js -->
	<script src="assets/js/mixitup.min.js"></script>

	<!-- theme js -->
	<script src="assets/js/theme.js"></script>

	<!-- scroll js -->
	<script src="assets/js/script.js"></script>
</body>
</html>
