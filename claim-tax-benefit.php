<?php
// claim-tax-benefit.php
session_start();
require 'db.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;
use Dompdf\Options;

// ---------- .env ----------
if (class_exists('\\Dotenv\\Dotenv')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
}

// ---------- helpers ----------
function e($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function clean($v){ return trim((string)$v); }
function inr_words($num){
    $num = (int)round($num);
    if ($num === 0) return "Zero Rupees Only";
    $ones=["","One","Two","Three","Four","Five","Six","Seven","Eight","Nine","Ten","Eleven","Twelve","Thirteen","Fourteen","Fifteen","Sixteen","Seventeen","Eighteen","Nineteen"];
    $tens=["","","Twenty","Thirty","Forty","Fifty","Sixty","Seventy","Eighty","Ninety"];
    $scales=["","Thousand","Lakh","Crore"];
    $s=str_pad((string)$num,3,'0',STR_PAD_LEFT);
    $h=intval(substr($s,-3)); $rest=substr($s,0,-3);
    $groups=[]; while(strlen($rest)>0){ $groups[] = intval(substr($rest,-2)); $rest=substr($rest,0,-2); }
    $get2=function($x)use($ones,$tens){ if($x<20) return $ones[$x]; return trim($tens[intval($x/10)]." ".$ones[$x%10]); };
    $parts=[]; $i=0;
    foreach($groups as $g){ if($g){ $parts[]=$get2($g)." ".$scales[++$i]; } else { $i++; } }
    if($h){
        $hund=intval($h/100); $last=$h%100;
        if($hund) $parts[]=$ones[$hund]." Hundred".($last?" and":"");
        if($last) $parts[]=$get2($last);
    }
    return trim(implode(" ", array_reverse($parts)))." Rupees Only";
}

// ---------- org config ----------
$ORG_NAME     = $_ENV['NGO_NAME']         ?? 'Asthu Foundation';
$ORG_PAN      = $_ENV['NGO_PAN']          ?? 'AABTC9908N';
$ORG_REG_NO   = $_ENV['NGO_REG_NO']       ?? 'BMH-4-00385-2016-17';
$ORG_80G_TEXT = $_ENV['NGO_80G_APPROVAL'] ??
"Donation are eligible for 50% deduction from taxable income under section 80G(5)(vi) of the Income Tax Act 1961 vide approval no. CIT (E) BLR/80G/P-275/{$ORG_PAN}/ITO (E) -1/Vol 2016-2017 dated 07/12/2016, subject to realization of donation.";

// ---------- fetch by payment_id ----------
$payment_id  = $_GET['payment_id'] ?? '';
$errors      = [];
$amount      = '';
$date        = '';
$displayDate = null;

if ($payment_id) {
    $stmt = $conn->prepare("SELECT amount, donated_at FROM donations WHERE razorpay_payment_id = ?");
    $stmt->bind_param("s", $payment_id);
    $stmt->execute();
    $stmt->bind_result($dbAmount, $dbDate);
    if ($stmt->fetch()) {
        $amount      = $dbAmount;
        $date        = date('Y-m-d', strtotime($dbDate));
        $displayDate = date('d-M-Y', strtotime($dbDate)); // e.g. 05-Dec-2024
    } else {
        $errors[] = "Invalid payment ID.";
    }
    $stmt->close();
} else {
    $errors[] = "Missing payment ID in URL.";
}

// ---------- handle POST ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)) {
    $name    = clean($_POST['name'] ?? '');
    $email   = clean($_POST['email'] ?? '');
    $pan     = strtoupper(clean($_POST['pan'] ?? ''));
    $address = clean($_POST['address'] ?? '');

    if ($name==='') $errors[]="Name is required.";
    if ($email==='' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[]="Valid email is required.";
    if ($pan==='') $errors[]="PAN is required.";
    if ($address==='') $errors[]="Address is required.";
    if ($amount==='' || !is_numeric($amount)) $errors[]="Donation amount missing/invalid.";

    if (empty($errors)) {
        $dateForDB   = date('Y-m-d', strtotime($date ?: 'now'));
        $displayDate = $displayDate ?? date('d-M-Y', strtotime($dateForDB));

        // save claim
        $stmt = $conn->prepare("INSERT INTO donor_tax_claims (payment_id, name, email, pan, address, amount, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $amtStr = (string)$amount;
        $stmt->bind_param("sssssss", $payment_id, $name, $email, $pan, $address, $amtStr, $dateForDB);
        $stmt->execute();
        $stmt->close();

        // ---------- generate PDF (SVG logo + colored header) ----------
        $svgFile = __DIR__ . '/assets/images/astu-logo (2).svg';
        $logoTag = "<div style='font-weight:800;font-size:22px;color:#0f172a'>{$ORG_NAME}</div>";
        if (is_file($svgFile)) {
            $svg = file_get_contents($svgFile);
            // Normalize SVG so Dompdf shows it reliably
            $svg = preg_replace('/<\?xml.*?\?>\s*/', '', $svg);
            if (!preg_match('/viewBox\s*=\s*"[0-9.\s-]+"/i', $svg)) {
                if (preg_match('/width\s*=\s*"(\d+)(px)?"/i', $svg, $mw) &&
                    preg_match('/height\s*=\s*"(\d+)(px)?"/i', $svg, $mh)) {
                    $vw = (int)$mw[1]; $vh = (int)$mh[1];
                    if ($vw > 0 && $vh > 0) {
                        $svg = preg_replace('/<svg\b/i', '<svg viewBox="0 0 '.$vw.' '.$vh.'"', $svg, 1);
                    }
                }
            }
            if (preg_match('/<svg\b[^>]*>/i', $svg, $m)) {
                $open = $m[0];
                $open = preg_replace('/\s(width|height)\s*=\s*"[^"]*"/i', '', $open);
                $open = preg_replace('/>$/', ' width="180" height="60" preserveAspectRatio="xMidYMid meet" style="display:block">', $open);
                $svg  = preg_replace('/<svg\b[^>]*>/i', $open, $svg, 1);
            }
            $logoTag = "<div style='width:180px;height:60px;display:flex;align-items:center'>{$svg}</div>";
        }

        $amountFloat     = (float)$amount;
        $amountFormatted = number_format($amountFloat, 2);
        $amountWords     = inr_words($amountFloat);
        $modeOfPayment   = "UPI"; // adjust if you store the exact mode

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans'); // supports ₹
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
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
  .foot{margin-top:10px;font-size:11px;color:#555}
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
      We confirm the receipt of donation from Mr/Mrs <strong>{$name}</strong> {$modeOfPayment} <strong>Rs.{$amountFormatted}/-</strong><br>
      <span class="d2">Dated <strong>{$displayDate}</strong></span>
    </div>

    <div class="table-wrap">
      <table class="meta">
        <tr><td>Receipt Number</td><td>{$payment_id}</td></tr>
        <tr><td>Total Donation</td><td>INR {$amountFormatted}/-</td></tr>
        <tr><td>Receipt Date</td><td>{$displayDate}</td></tr>
        <tr><td>PAN Details of Donor</td><td>{$pan}</td></tr>
        <tr><td>Mode of Payment</td><td>{$modeOfPayment}</td></tr>
        <tr><td>Amount in words</td><td>{$amountWords}</td></tr>
      </table>
    </div>

    <div class="note">
      <strong>Note:</strong>
      {$ORG_80G_TEXT}
    </div>

    <div class="foot">
      This is a system-generated receipt. No physical signature is required.
    </div>
  </div>
</body>
</html>
HTML;

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfOutput = $dompdf->output();

        $certFolder = __DIR__ . "/certificates";
        if (!is_dir($certFolder)) mkdir($certFolder, 0755, true);
        $pdfFilePath = $certFolder . "/{$payment_id}.pdf";
        file_put_contents($pdfFilePath, $pdfOutput);

        // ---------- email ----------
        $mail = new PHPMailer(true);
        try{
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USER'] ?? '';
            $mail->Password   = $_ENV['SMTP_PASS'] ?? '';
            $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'] ?? PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = (int)($_ENV['SMTP_PORT'] ?? 587);

            $fromEmail = $_ENV['SMTP_FROM'] ?? ($_ENV['SMTP_USER'] ?? 'no-reply@example.org');
            $fromName  = $_ENV['SMTP_FROM_NAME'] ?? ($ORG_NAME.' Receipts');

            $mail->setFrom($fromEmail, $fromName);
            $mail->addAddress($email, $name);
            $mail->Subject = "Your 80G Donation Receipt - {$payment_id}";
            $mail->Body    = "Dear {$name},\n\nThank you for your generous donation of Rs.{$amountFormatted}/- on {$displayDate}.\nPlease find your 80G donation receipt attached.\n\nWarm regards,\n{$ORG_NAME}";
            $mail->AltBody = $mail->Body;
            $mail->addAttachment($pdfFilePath);
            $mail->send();

            $_SESSION['success'] = "Your 80G certificate has been generated and emailed successfully!";
            header("Location: " . $_SERVER['PHP_SELF'] . "?payment_id=" . urlencode($payment_id));
            exit;
        } catch (Exception $ex){
            $errors[] = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
    body{background:#f4f6f8;font-family:Inter,system-ui,Arial,sans-serif}
    .container{max-width:720px;margin:48px auto}
    .card{border:none;border-radius:14px;box-shadow:0 10px 25px rgba(16,24,40,.08)}
    .card-header{border:0;border-radius:14px 14px 0 0;background:linear-gradient(90deg,#1e4764,#2a5d84);color:#fff}
    .badge-gd{background:rgba(255,255,255,.2);font-weight:500}
    .floating .form-control, .floating .form-select{border-radius:10px}
    .readonly{background:#f8fafc}
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
        <span class="badge badge-gd rounded-pill px-3 py-2">
          GD: <?= e(strtoupper($GD_STATUS)) ?>
        </span>
      </div>

      <div class="card-body p-4">
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach ($errors as $err) echo "<li>".e($err)."</li>"; ?>
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
                <input type="text" id="name" name="name" class="form-control" placeholder="Full Name" value="<?= e($_POST['name'] ?? '') ?>" required>
                <label for="name">Full Name *</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" value="<?= e($_POST['email'] ?? '') ?>" required>
                <label for="email">Email Address *</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating">
                <input type="text" id="pan" name="pan" class="form-control" placeholder="PAN" maxlength="10"
                       value="<?= e($_POST['pan'] ?? '') ?>" required pattern="[A-Za-z]{5}\d{4}[A-Za-z]{1}" title="Format: 5 letters, 4 digits, 1 letter">
                <label for="pan">PAN Number *</label>
                <div class="form-text">Format: ABCDE1234F</div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating">
                <textarea id="address" name="address" class="form-control" style="height: 100px" placeholder="Address" required><?= e($_POST['address'] ?? '') ?></textarea>
                <label for="address">Address *</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating">
                <input type="text" class="form-control readonly" placeholder="Amount" value="<?= e($amount !== '' ? number_format((float)$amount, 2) : '') ?>" readonly>
                <label>Donation Amount (INR)</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating">
                <input type="text" class="form-control readonly" placeholder="Payment ID" value="<?= e($payment_id) ?>" readonly>
                <label>Payment ID</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating">
                <input type="text" class="form-control readonly" placeholder="Donation Date" value="<?= e($displayDate ?? date('d-M-Y')) ?>" readonly>
                <label>Donation Date</label>
              </div>
            </div>
          </div>

          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">Submit & Get Certificate</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Make PAN uppercase automatically
    const pan = document.getElementById('pan');
    if (pan) {
      pan.addEventListener('input', () => { pan.value = pan.value.toUpperCase(); });
    }

    // Disable submit to avoid double-clicks
    const form = document.getElementById('claimForm');
    const btn  = document.getElementById('submitBtn');
    if (form && btn) {
      form.addEventListener('submit', () => {
        btn.setAttribute('disabled', 'disabled');
        btn.textContent = 'Generating Certificate...';
      });
    }
  </script>
</body>
</html>
