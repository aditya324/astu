<?php
// claim-tax-benefit.php
session_start();
require 'db.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;
use Dompdf\Options;

// ---------- .env (for SMTP etc.) ----------
if (class_exists('\\Dotenv\\Dotenv')) {
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->safeLoad();
}

// ---------- helpers ----------
function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function clean($v) { return trim((string)$v); }
function envv($k, $d=null) {
  $v = getenv($k);
  if ($v === false && isset($_ENV[$k])) $v = $_ENV[$k];
  if ($v === false && isset($_SERVER[$k])) $v = $_SERVER[$k];
  return ($v === false || $v === null || $v === '') ? $d : $v;
}
function inr_words($num) {
  $num = (int)round($num);
  if ($num === 0) return "Zero Rupees Only";
  $ones = ["","One","Two","Three","Four","Five","Six","Seven","Eight","Nine","Ten","Eleven","Twelve","Thirteen","Fourteen","Fifteen","Sixteen","Seventeen","Eighteen","Nineteen"];
  $tens = ["","","Twenty","Thirty","Forty","Fifty","Sixty","Seventy","Eighty","Ninety"];
  $scales = ["","Thousand","Lakh","Crore"];
  $s = str_pad((string)$num, 3, '0', STR_PAD_LEFT);
  $h = intval(substr($s, -3));
  $rest = substr($s, 0, -3);
  $groups = [];
  while (strlen($rest) > 0) { $groups[] = intval(substr($rest, -2)); $rest = substr($rest, 0, -2); }
  $get2 = function($x) use($ones,$tens){ if($x<20) return $ones[$x]; return trim($tens[intval($x/10)]." ".$ones[$x%10]); };
  $parts=[]; $i=0;
  foreach($groups as $g){ if($g){ $parts[] = $get2($g)." ".$scales[++$i]; } else { $i++; } }
  if($h){ $hund=intval($h/100); $last=$h%100; if($hund) $parts[]=$ones[$hund]." Hundred".($last?" and":""); if($last) $parts[]=$get2($last); }
  return trim(implode(" ", array_reverse($parts)))." Rupees Only";
}

// ---------- org config ----------
$ORG_NAME   = 'Asthu Foundation';
$ORG_PAN    = 'AABTC9908N';
$ORG_REG_NO = 'BMH-4-00385-2016-17';
$ORG_80G_TEXT = "Donation are eligible for 50% deduction from taxable income under section 80G(5)(vi) of the Income Tax Act 1961 vide approval no. CIT (E) BLR/80G/P-275/AABTC9908N/ITO (E) -1/Vol 2016-2017 dated 07/12/2016, subject to realization of donation.";
$SIGN_NAME       = 'Authorized Signatory';
$SIGN_TITLE      = $ORG_NAME;
$SIGN_IMAGE_PATH = __DIR__ . '/assets/images/signature.png';

// ---------- fetch by payment_id ----------
$payment_id  = $_GET['payment_id'] ?? '';
$errors      = [];
$amount      = '';
$date        = '';
$displayDate = null;

if ($payment_id) {
  $stmt = $conn->prepare("SELECT amount, donated_at FROM donations WHERE razorpay_payment_id = ?");
  if (!$stmt) {
    $errors[] = "DB error: " . $conn->error;
  } else {
    $stmt->bind_param("s", $payment_id);
    $stmt->execute();
    $stmt->bind_result($dbAmount, $dbDate);
    if ($stmt->fetch()) {
      $amount      = $dbAmount;
      $date        = date('Y-m-d', strtotime($dbDate));
      $displayDate = date('d-M-Y', strtotime($dbDate));
    } else {
      $errors[] = "Invalid payment ID.";
    }
    $stmt->close();
  }
} else {
  $errors[] = "Missing payment ID in URL.";
}

// ---------- SMTP helper ----------
function make_mailer(string $host, int $port, string $user, string $pass, string $fromName): PHPMailer {
  $m = new PHPMailer(true);
  $m->isSMTP();
  $m->Host       = $host;
  $m->SMTPAuth   = true;
  $m->Username   = $user;
  $m->Password   = $pass;
  $m->SMTPSecure = ($port === 465) ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
  $m->Port       = $port ?: 587;
  $m->CharSet    = 'UTF-8';
  $m->SMTPAutoTLS = true;
  // From must be the authenticated mailbox
  $m->setFrom($user, $fromName);
  // Envelope sender for DMARC/bounces
  $domain = substr((string)strrchr($user, "@"), 1) ?: '';
  if ($domain) $m->Sender = 'bounce@' . $domain;
  return $m;
}

// ---------- handle POST ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)) {
  $name    = clean($_POST['name'] ?? '');
  $email   = clean($_POST['email'] ?? '');
  $pan     = strtoupper(clean($_POST['pan'] ?? ''));
  $address = clean($_POST['address'] ?? '');

  if ($name === '') $errors[] = "Name is required.";
  if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
  if ($pan === '') $errors[] = "PAN is required.";
  if ($address === '') $errors[] = "Address is required.";
  if ($amount === '' || !is_numeric($amount)) $errors[] = "Donation amount missing/invalid.";

  if (empty($errors)) {
    $dateForDB   = date('Y-m-d', strtotime($date ?: 'now'));
    $displayDate = $displayDate ?? date('d-M-Y', strtotime($dateForDB));

    // save claim
    $stmt = $conn->prepare("INSERT INTO donor_tax_claims (payment_id, name, email, pan, address, amount, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
      $errors[] = "DB error: " . $conn->error;
    } else {
      $amtStr = (string)$amount;
      $stmt->bind_param("sssssss", $payment_id, $name, $email, $pan, $address, $amtStr, $dateForDB);
      $stmt->execute();
      $stmt->close();
    }

    if (empty($errors)) {
      // ---------- generate PDF ----------
      $svgFile = __DIR__ . '/assets/images/astu-logo (2).svg';
      $logoTag = "<div style='font-weight:800;font-size:22px;color:#0f172a'>{$ORG_NAME}</div>";
      if (is_file($svgFile)) {
        $svg = file_get_contents($svgFile);
        if (!preg_match('/\sxmlns=/', $svg)) $svg = preg_replace('/<svg\b/i', '<svg xmlns="http://www.w3.org/2000/svg"', $svg, 1);
        if (!preg_match('/viewBox\s*=\s*"[0-9.\s-]+"/i', $svg)) {
          if (preg_match('/width\s*=\s*"(\d+)(px)?"/i', $svg, $mw) && preg_match('/height\s*=\s*"(\d+)(px)?"/i', $svg, $mh)) {
            $vw = (int)$mw[1]; $vh = (int)$mh[1];
            if ($vw > 0 && $vh > 0) $svg = preg_replace('/<svg\b/i', '<svg viewBox="0 0 '.$vw.' '.$vh.'"', $svg, 1);
          }
        }
        $svg = preg_replace('/<\?xml.*?\?>\s*/', '', $svg);
        $dataUri = 'data:image/svg+xml;base64,' . base64_encode($svg);
        $logoTag = "<img src=\"{$dataUri}\" alt=\"{$ORG_NAME} Logo\" style=\"width:180px;height:auto;display:block;\" />";
      }

      $signImgTag = '';
      if (is_file($SIGN_IMAGE_PATH)) {
        $ext = strtolower(pathinfo($SIGN_IMAGE_PATH, PATHINFO_EXTENSION));
        $mime = ($ext === 'svg') ? 'image/svg+xml' : (($ext === 'png') ? 'image/png' : 'image/jpeg');
        $signData = base64_encode(file_get_contents($SIGN_IMAGE_PATH));
        $signImgTag = '<img src="data:' . $mime . ';base64,' . $signData . '" style="width:140px;height:auto;display:block;margin:0 auto 4px;" alt="Signature" />';
      }

      $amountFloat     = (float)$amount;
      $amountFormatted = number_format($amountFloat, 2);
      $amountWords     = inr_words($amountFloat);

      $options = new Options();
      $options->set('defaultFont', 'DejaVu Sans');
      $options->set('isRemoteEnabled', true);
      $options->set('isHtml5ParserEnabled', true);
      $options->setChroot(__DIR__);
      $dompdf = new Dompdf($options);

      $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  @page { margin: 24px; }
  *{box-sizing:border-box}
  body{font-family:DejaVu Sans,Arial,sans-serif;color:#111;font-size:12px}
  .page{max-width:800px;margin:0 auto}
  .band{height:70px;background:#DF5311;}
  .head{display:flex;align-items:center;gap:14px;padding:16px 20px 6px}
  .brand h1{margin:0;font-size:22px;letter-spacing:.3px}
  .reg{margin-top:4px;color:#555;font-size:12px}
  .title{margin:16px 0 4px;text-align:center;font-weight:700;letter-spacing:.06em}
  .pan{text-align:center;margin-bottom:10px;font-weight:700}
  .confirm{text-align:center;line-height:1.55}
  .confirm .d2{margin-top:6px}
  .table-wrap{margin:24px auto 16px;max-width:620px}
  table.meta{width:100%;border-collapse:collapse}
  table.meta td{border:1px solid #333;padding:12px 14px;vertical-align:middle}
  table.meta td:nth-child(1){width:45%}
  .note{margin-top:18px;border-top:1px solid #000;padding-top:10px}
  .note strong{display:block;margin-bottom:6px}
  .signatory{display:flex;justify-content:space-between;align-items:flex-end;margin-top:30px}
  .sig-left{font-size:12px;color:#333}
  .sig-right{text-align:center}
</style>
</head>
<body>
  <div class="page">
    <div class="band"></div>
    <div class="head">
      {$logoTag}
      <div class="brand">
        <h1>{$ORG_NAME}</h1>
        <div class="reg">Reg No : {$ORG_REG_NO}</div>
      </div>
    </div>

    <div class="title">DONATION RECEIPT</div>
    <div class="pan">PAN-{$ORG_PAN}</div>

    <div class="confirm">
      We confirm the receipt of donation from Mr/Mrs <strong>{$name} Rs.{$amountFormatted}/-</strong><br>
      <span class="d2">Dated <strong>{$displayDate}</strong></span>
    </div>

    <div class="table-wrap">
      <table class="meta">
        <tr><td>Receipt Number</td><td>{$payment_id}</td></tr>
        <tr><td>Total Donation</td><td>INR {$amountFormatted}/-</td></tr>
        <tr><td>Receipt Date</td><td>{$displayDate}</td></tr>
        <tr><td>PAN Details of Donor</td><td>{$pan}</td></tr>
        <tr><td>Amount in words</td><td>{$amountWords}</td></tr>
      </table>
    </div>

    <div class="note">
      <strong>Note:</strong>
      {$ORG_80G_TEXT}
    </div>

    <div class="signatory">
      <div class="sig-right" style="text-align:left">
        {$signImgTag}
        <div class="sig-name">{$SIGN_NAME}</div>
      </div>
      <div class="sig-left" style="text-align:right">
        <div><strong>Date:</strong> {$displayDate}</div>
        <div style="margin-top:8px">Thank you for your generosity. We appreciate your support!</div>
      </div>
    </div>
  </div>
</body>
</html>
HTML;

      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();
      $pdfOutput = $dompdf->output();

      // Save PDF
      $certFolder = __DIR__ . "/certificates";
      if (!is_dir($certFolder)) mkdir($certFolder, 0755, true);
      $pdfFilePath = $certFolder . "/{$payment_id}.pdf";
      file_put_contents($pdfFilePath, $pdfOutput);

      // ---------- email (donor + admin) ----------
      $smtp_host     = envv('SMTP_HOST', 'smtp.gmail.com');
      $smtp_port     = (int) envv('SMTP_PORT', '587');
      $smtp_username = trim((string) envv('SMTP_USERNAME', envv('SMTP_USER', '')));
      $smtp_password = trim((string) envv('SMTP_PASSWORD', envv('SMTP_PASS', '')));
      $admin_email   = envv('ADMIN_EMAIL', $smtp_username);
      $from_name     = envv('SMTP_FROM_NAME', $ORG_NAME . ' Receipts');

      try {
        if (!$smtp_username || !$smtp_password) throw new Exception('SMTP not configured.');

        // 1) Donor receipt
        $mail = make_mailer($smtp_host, $smtp_port, $smtp_username, $smtp_password, $from_name);
        $mail->addAddress($email, $name);
        if ($admin_email) $mail->addReplyTo($admin_email, $ORG_NAME);
        $mail->Subject = "Your 80G Donation Receipt - {$payment_id}";
        $mail->Body    = "Dear {$name},\n\nThank you for your generous donation of Rs.{$amountFormatted}/- on {$displayDate}.\nPlease find your 80G donation receipt attached.\n\nWarm regards,\n{$ORG_NAME}";
        $mail->AltBody = $mail->Body;
        $mail->addAttachment($pdfFilePath, "Receipt-{$payment_id}.pdf");
        $mail->send();

        // 2) Admin notification (attach same PDF)
        if ($admin_email) {
          $admin = make_mailer($smtp_host, $smtp_port, $smtp_username, $smtp_password, $from_name);
          $admin->addAddress($admin_email, 'Admin');
          if (strcasecmp($admin_email, $smtp_username) !== 0) {
            $admin->addAddress($smtp_username, 'Admin Copy');
          }
          $admin->Subject = "New 80G Receipt Generated — {$payment_id}";
          $admin->isHTML(true);
          $admin->Body = "
            <div style='font-family:Arial,sans-serif;line-height:1.6'>
              <h3 style='margin:0 0 8px'>80G Receipt Generated</h3>
              <table cellpadding='8' border='1' style='border-collapse:collapse;width:100%'>
                <tr><td><strong>Name</strong></td><td>".e($name)."</td></tr>
                <tr><td><strong>Email</strong></td><td>".e($email)."</td></tr>
                <tr><td><strong>Amount</strong></td><td>INR ".e($amountFormatted)."</td></tr>
                <tr><td><strong>Payment ID</strong></td><td>".e($payment_id)."</td></tr>
                <tr><td><strong>Receipt Date</strong></td><td>".e($displayDate)."</td></tr>
              </table>
            </div>";
          $admin->AltBody = "80G Receipt Generated\nName: {$name}\nEmail: {$email}\nAmount: INR {$amountFormatted}\nPayment ID: {$payment_id}\nDate: {$displayDate}";
          $admin->addAttachment($pdfFilePath, "Receipt-{$payment_id}.pdf");
          $admin->send();
        }

        $_SESSION['success'] = "Your 80G certificate has been generated and emailed successfully!";
        header("Location: " . $_SERVER['PHP_SELF'] . "?payment_id=" . urlencode($payment_id));
        exit;
      } catch (Exception $ex) {
        $errors[] = "Email could not be sent. Mailer Error: " . ($mail->ErrorInfo ?? $ex->getMessage());
      }
    }
  }
}

// handy flag so you know if GD is on locally
$GD_STATUS = extension_loaded('gd') ? 'enabled' : 'disabled';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Claim 80G Tax Benefit</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#f4f6f8; font-family: Inter, system-ui, Arial, sans-serif }
    .container { max-width: 720px; margin: 48px auto }
    .card { border: none; border-radius: 14px; box-shadow: 0 10px 25px rgba(16,24,40,.08) }
    .card-header { border:0; border-radius:14px 14px 0 0; background:linear-gradient(90deg,#1e4764,#2a5d84); color:#fff }
    .floating .form-control, .floating .form-select { border-radius:10px }
    .readonly { background:#f8fafc }
    .note-block { margin-top:20px; font-size:14px }
    .sign-block { text-align:right; margin-top:16px }
    .sig-img { max-width:160px; height:auto; display:block; margin-left:auto }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="card-header p-4 d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-0">Claim Your 80G Tax Benefit</h4>
          <small class="opacity-75">Receipt will be generated & emailed after submission</small>
        </div>
      </div>

      <div class="card-body p-4">
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach ($errors as $err) echo "<li>" . e($err) . "</li>"; ?>
            </ul>
          </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
          <div class="alert alert-success">
            <?= e($_SESSION['success']); unset($_SESSION['success']); ?>
          </div>
        <?php endif; ?>

        <form method="POST" novalidate class="floating" id="claimForm">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="form-floating">
                <input type="text" id="name" name="name" class="form-control" placeholder="Full Name"
                  value="<?= e($_POST['name'] ?? '') ?>" required>
                <label for="name">Full Name *</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email Address"
                  value="<?= e($_POST['email'] ?? '') ?>" required>
                <label for="email">Email Address *</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating">
                <input type="text" id="pan" name="pan" class="form-control" placeholder="PAN" maxlength="10"
                  value="<?= e($_POST['pan'] ?? '') ?>"
                  required pattern="[A-Za-z]{5}\d{4}[A-Za-z]{1}"
                  title="Format: 5 letters, 4 digits, 1 letter">
                <label for="pan">PAN Number *</label>
                <div class="form-text">Format: ABCDE1234F</div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating">
                <textarea id="address" name="address" class="form-control" style="height: 100px"
                  placeholder="Address" required><?= e($_POST['address'] ?? '') ?></textarea>
                <label for="address">Address *</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating">
                <input type="text" class="form-control readonly" placeholder="Amount"
                  value="<?= e($amount !== '' ? number_format((float)$amount, 2) : '') ?>" readonly>
                <label>Donation Amount (INR)</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating">
                <input type="text" class="form-control readonly" placeholder="Payment ID"
                  value="<?= e($payment_id) ?>" readonly>
                <label>Payment ID</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating">
                <input type="text" class="form-control readonly" placeholder="Donation Date"
                  value="<?= e($displayDate ?? date('d-M-Y')) ?>" readonly>
                <label>Donation Date</label>
              </div>
            </div>
          </div>

          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">Submit & Get Certificate</button>
          </div>
        </form>

        <div class="note-block">
          <strong>Note:</strong><br>
          <?= e($ORG_80G_TEXT) ?>
        </div>

        <div class="sign-block">
          <?php if (is_file($SIGN_IMAGE_PATH)): ?>
            <img class="sig-img" src="<?= 'assets/images/' . basename($SIGN_IMAGE_PATH) ?>" alt="Signature">
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>

  <script>
    // Make PAN uppercase automatically
    const pan = document.getElementById('pan');
    if (pan) { pan.addEventListener('input', () => { pan.value = pan.value.toUpperCase(); }); }

    // Disable submit to avoid double-clicks
    const form = document.getElementById('claimForm');
    const btn = document.getElementById('submitBtn');
    if (form && btn) {
      form.addEventListener('submit', () => {
        btn.setAttribute('disabled', 'disabled');
        btn.textContent = 'Generating Certificate...';
      });
    }
  </script>
</body>
</html>
