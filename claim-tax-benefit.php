<?php
// claim-tax-benefit.php  (FPDI Letterhead Version - cleaned recipient + raised footer text)
session_start();
require 'db.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use setasign\Fpdi\Fpdi;

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
// FPDF needs Latin-1/Win-1252. This helps avoid crash on unicode names/addresses.
function pdfs($s) {
  $out = @iconv('UTF-8', 'windows-1252//TRANSLIT//IGNORE', (string)$s);
  return $out !== false ? $out : preg_replace('/[^\x20-\x7E]/', '?', (string)$s);
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
// You pointed this to a JPG; keep it if you intend to show a stamp/logo here.
// If you have an actual signature PNG, switch to that path.
$SIGN_IMAGE_PATH = __DIR__ . '/assets/images/astu-logo.jpg';

// === Letterhead PDF path (adjust if you place it elsewhere) ===
$LETTERHEAD_PDF  = __DIR__ . '/assets/letterheads/Asthu Foundation_Letter Head_01.pdf';

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
  $m->setFrom($user, $fromName);
  $domain = substr((string)strrchr($user, "@"), 1) ?: '';
  if ($domain) $m->Sender = 'bounce@' . $domain;
  return $m;
}

// ---------- PDF generator on Letterhead (FPDI) ----------
function generateReceiptOnLetterheadPDF(
  string $templatePdf,
  string $savePath,
  array $data,
  ?string $signaturePng = null
){
  if (!is_file($templatePdf)) {
    throw new RuntimeException("Letterhead PDF not found at: " . $templatePdf);
  }

  $pdf = new Fpdi('P', 'mm', 'A4');
  $pdf->AddPage();

  // Import letterhead template
  $pdf->setSourceFile($templatePdf);
  $tplId = $pdf->importPage(1);
  $pdf->useTemplate($tplId, 0, 0, 210, 297);

  $pdf->SetAutoPageBreak(false);
  $pdf->SetTextColor(17,17,17);
  $pdf->SetDrawColor(0,0,0);

  // --- Header Title ---
  $pdf->SetFont('Arial','B',14);
  $pdf->SetXY(20, 60);
  $pdf->Cell(170, 8, pdfs('DONATION RECEIPT'), 0, 1, 'C');

  // --- PAN Line ---
  $pdf->SetFont('Arial','B',11);
  $pdf->SetXY(20, 70);
  $pdf->Cell(170, 6, pdfs('PAN - ' . $GLOBALS['ORG_PAN']), 0, 1, 'C');

  // --- Confirmation ---
  $pdf->SetFont('Arial','',11);
  $pdf->SetXY(20, 84);
  $confirm = sprintf(
    'We confirm the receipt of donation from Mr/Mrs %s Rs.%s/-',
    $data['name'], $data['amount']
  );
  $pdf->MultiCell(170, 6, pdfs($confirm), 0, 'C');
  $pdf->SetXY(20, 96);
  $pdf->Cell(170, 6, pdfs('Dated ' . $data['display_date']), 0, 1, 'C');

  // ---------- Recipient Table (ONLY this section has borders) ----------
  $leftX = 25;
  $y = 108;           // start position
  $lineH = 8;         // row height
  $colW1 = 85;        // left column width
  $colW2 = 90;        // right column width

  $rows = [
    ['Receipt Number',        $data['payment_id']],
    ['Total Donation',        'INR '.$data['amount'].'/-'],
    ['Receipt Date',          $data['display_date']],
    ['PAN Details of Donor',  $data['pan']],
    ['Amount in words',       $data['amount_words']],
  ];

  $pdf->SetFont('Arial','',11);
  foreach ($rows as $r) {
    $pdf->SetXY($leftX, $y);
    $pdf->Cell($colW1, $lineH, pdfs($r[0]), 1, 0, 'L');
    $pdf->Cell($colW2, $lineH, pdfs($r[1]), 1, 1, 'L');
    $y += $lineH;
  }

  // --- Note ---
  $pdf->SetXY(25, $y + 8);
  $pdf->SetFont('Arial','B',11);
  $pdf->Cell(0, 6, pdfs('Note:'), 0, 1, 'L');

  $pdf->SetFont('Arial','',10);
  $pdf->SetXY(25, $pdf->GetY());
  $pdf->MultiCell(165, 5, pdfs($GLOBALS['ORG_80G_TEXT']), 0, 'L');

  // --- Signature Image ---
  if ($signaturePng && is_file($signaturePng)) {
    $pdf->Image($signaturePng, 148, 208, 40, 0, 'PNG'); // adjust Y if needed
  }

  // --- Signatory Labels ---
  $pdf->SetXY(150, 224);
  $pdf->SetFont('Arial','',10);
  $pdf->Cell(45, 5, pdfs($GLOBALS['SIGN_NAME']), 0, 2, 'C');
  $pdf->Cell(45, 5, pdfs($GLOBALS['SIGN_TITLE']), 0, 2, 'C');

  // --- Date & Thank-you Lines ---
  $pdf->SetFont('Arial','',10);
  $pdf->SetXY(25, 218);
  $pdf->Cell(120, 5, pdfs('Date: ' . $data['display_date']), 0, 1, 'L');

  $pdf->SetXY(25, 225);
  $pdf->MultiCell(120, 5, pdfs('Thank you for your generosity. We appreciate your support!'), 0, 'L');

  // --- Save File ---
  if (!is_dir(dirname($savePath))) {
    @mkdir(dirname($savePath), 0755, true);
  }
  $pdf->Output('F', $savePath);
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
      // ---------- generate PDF on letterhead (FPDI) ----------
      $amountFloat     = (float)$amount;
      $amountFormatted = number_format($amountFloat, 2);
      $amountWords     = inr_words($amountFloat);

      $certFolder = __DIR__ . "/certificates";
      if (!is_dir($certFolder)) mkdir($certFolder, 0755, true);
      $pdfFilePath = $certFolder . "/{$payment_id}.pdf";

      try {
        generateReceiptOnLetterheadPDF(
          $LETTERHEAD_PDF,
          $pdfFilePath,
          [
            'name'          => $name,
            'payment_id'    => $payment_id,
            'display_date'  => $displayDate,
            'pan'           => $pan,
            'amount'        => $amountFormatted,
            'amount_words'  => $amountWords,
          ],
          // signature (PNG/JPG). Pass null to skip.
          is_file($SIGN_IMAGE_PATH) ? $SIGN_IMAGE_PATH : null
        );
      } catch (\Throwable $t) {
        $errors[] = "PDF generation failed: " . $t->getMessage();
      }

      // ---------- email (donor + admin) ----------
      if (empty($errors)) {
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

          // 2) Admin notification
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
}

// handy flag so you know if GD is on locally (not required by FPDI, but useful)
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
