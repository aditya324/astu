<?php
// verify_payment.php
declare(strict_types=1);

header('Content-Type: application/json');

require 'vendor/autoload.php';
require 'db.php';

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ---- Load .env ----
if (class_exists('\\Dotenv\\Dotenv')) {
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->safeLoad();
}

// ---- env helper (reads getenv/$_ENV/$_SERVER) ----
function envv(string $k, ?string $d=null): ?string {
  $v = getenv($k);
  if ($v === false && isset($_ENV[$k]))   $v = $_ENV[$k];
  if ($v === false && isset($_SERVER[$k]))$v = $_SERVER[$k];
  if ($v === false) $v = null;
  return ($v === null || $v === '') ? $d : $v;
}

// ---- small escaper ----
function e(string $v): string {
  return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

// ---- SMTP settings (support both naming styles) ----
$smtp_host     = envv('SMTP_HOST', 'smtp.gmail.com');
$smtp_port     = (int) (envv('SMTP_PORT', '587'));
$smtp_username = trim((string) envv('SMTP_USERNAME', envv('SMTP_USER', '')));
$smtp_password = trim((string) envv('SMTP_PASSWORD', envv('SMTP_PASS', '')));
$admin_email   = envv('ADMIN_EMAIL', $smtp_username);
$from_name     = envv('SMTP_FROM_NAME', 'Asthu Foundation');

$app_url       = rtrim((string) envv('APP_URL', ''), '/'); // required for claim link
$razor_key     = envv('RAZORPAY_KEY_ID');
$razor_secret  = envv('RAZORPAY_KEY_SECRET');

// ---- helper: create configured PHPMailer ----
function make_mailer(
  string $host, int $port, string $user, string $pass, string $fromName
): PHPMailer {
  $m = new PHPMailer(true);
  $m->isSMTP();
  $m->Host       = $host;
  $m->SMTPAuth   = true;
  $m->Username   = $user;
  $m->Password   = $pass;

  // Map port → encryption
  $m->SMTPSecure = ($port === 465) ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
  $m->Port       = $port ?: 587;
  $m->CharSet    = 'UTF-8';
  $m->SMTPAutoTLS = true;

  // From must equal authenticated mailbox
  $m->setFrom($user, $fromName);

  // Envelope sender (helps DMARC/bounces)
  $domain = substr((string)strrchr($user, "@"), 1) ?: '';
  if ($domain) {
    $m->Sender = 'bounce@' . $domain; // ensure allowed on your domain
  }

  return $m;
}

// ---- helper: send donor email ----
function sendDonorEmail(
  string $toEmail, string $toName, string $paymentId, string $claimUrl,
  string $host, int $port, string $user, string $pass, string $fromName, ?string $replyTo=null
): bool {
  $mail = make_mailer($host, $port, $user, $pass, $fromName);

  if ($replyTo) {
    $mail->addReplyTo($replyTo, $fromName);
  }

  $mail->addAddress($toEmail, $toName);
  $mail->isHTML(true);
  $mail->Subject = "Payment Successful — Thank you for your donation";

  $mail->Body = "
    <div style='font-family:Arial,sans-serif;line-height:1.6;color:#111'>
      <h2 style='margin:0 0 8px'>Thank you for your donation!</h2>
      <p style='margin:0 0 10px'>We have received your payment successfully.</p>
      <p style='margin:0 0 12px'>Your Razorpay Payment ID is:
        <strong>".e($paymentId)."</strong>
      </p>
      <p style='margin:0 0 14px'>You can claim your 80G tax benefit using the button below:</p>
      <p style='margin:0'>
        <a href='".e($claimUrl)."' style='display:inline-block;padding:10px 20px;color:#fff;background:#28a745;text-decoration:none;border-radius:6px;font-weight:600'>
          Claim Tax Benefit
        </a>
      </p>
    </div>
  ";

  $mail->AltBody = "Thank you for your donation!\nPayment ID: {$paymentId}\nClaim your 80G tax benefit: {$claimUrl}";

  try {
    $mail->send();
    return true;
  } catch (Exception $e) {
    error_log("Donor mail failed: " . $mail->ErrorInfo);
    return false;
  }
}

// ---- helper: send admin notification ----
function sendAdminEmail(
  string $adminEmail, array $payload, string $host, int $port, string $user, string $pass, string $fromName
): bool {
  $mail = make_mailer($host, $port, $user, $pass, $fromName);

  $mail->addAddress($adminEmail, 'Admin');
  if (strcasecmp($adminEmail, $user) !== 0) {
    $mail->addAddress($user, 'Admin Copy');
  }

  $mail->isHTML(true);
  $mail->Subject = "New Donation: " . e((string)($payload['razorpay_payment_id'] ?? ''));

  $name  = e((string)($payload['name'] ?? ''));
  $email = e((string)($payload['email'] ?? ''));
  $phone = e((string)($payload['phone'] ?? ''));
  $amount= e(number_format((float)($payload['amount'] ?? 0), 2));
  $payId = e((string)($payload['razorpay_payment_id'] ?? ''));
  $ordId = e((string)($payload['razorpay_order_id'] ?? ''));

  $mail->Body = "
    <div style='font-family:Arial,sans-serif;line-height:1.6;color:#111'>
      <h3 style='margin:0 0 10px'>New Donation Recorded</h3>
      <table cellpadding='10' border='1' style='border-collapse:collapse;width:100%'>
        <tr><td><strong>Name</strong></td><td>{$name}</td></tr>
        <tr><td><strong>Email</strong></td><td>{$email}</td></tr>
        <tr><td><strong>Phone</strong></td><td>{$phone}</td></tr>
        <tr><td><strong>Amount (INR)</strong></td><td>{$amount}</td></tr>
        <tr><td><strong>Payment ID</strong></td><td>{$payId}</td></tr>
        <tr><td><strong>Order ID</strong></td><td>{$ordId}</td></tr>
      </table>
    </div>
  ";

  $mail->AltBody = "New Donation\nName: {$name}\nEmail: {$email}\nPhone: {$phone}\nAmount: INR {$amount}\nPayment ID: {$payId}\nOrder ID: {$ordId}";

  try {
    $mail->send();
    return true;
  } catch (Exception $e) {
    error_log("Admin mail failed: " . $mail->ErrorInfo);
    return false;
  }
}

// ---- Read JSON input from Razorpay handler on your frontend ----
$input = json_decode(file_get_contents('php://input'), true) ?? [];

$success = false;
$error   = "Payment failed";

try {
  if (!empty($input['razorpay_payment_id']) && !empty($input['razorpay_order_id']) && !empty($input['razorpay_signature'])) {
    if (!$razor_key || !$razor_secret) {
      throw new RuntimeException("Razorpay not configured");
    }
    $api = new Api($razor_key, $razor_secret);

    // Verify signature
    $attributes = [
      'razorpay_order_id'   => $input['razorpay_order_id'],
      'razorpay_payment_id' => $input['razorpay_payment_id'],
      'razorpay_signature'  => $input['razorpay_signature'],
    ];
    $api->utility->verifyPaymentSignature($attributes);
    $success = true;
  } else {
    $error = "Missing Razorpay fields";
  }
} catch (SignatureVerificationError $e) {
  $success = false;
  $error   = 'Razorpay Error: ' . $e->getMessage();
} catch (Throwable $t) {
  $success = false;
  $error   = 'Server Error: ' . $t->getMessage();
}

if ($success) {
  // Collect donor details
  $name       = trim((string)($input['name']   ?? ''));
  $email      = trim((string)($input['email']  ?? ''));
  $phone      = trim((string)($input['phone']  ?? ''));
  $amount     = (float)($input['amount'] ?? 0);
  $payment_id = (string)($input['razorpay_payment_id'] ?? '');
  $order_id   = (string)($input['razorpay_order_id']   ?? '');

  // Save donation
  $sql = "INSERT INTO donations (name, email, phone, amount, razorpay_payment_id, razorpay_order_id, status)
          VALUES (?, ?, ?, ?, ?, ?, 'success')";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sssdss", $name, $email, $phone, $amount, $payment_id, $order_id);
    $stmt->execute();
    $stmt->close();
  } else {
    error_log("DB prepare failed: " . $conn->error);
  }

  // Build claim link
  if (!$app_url) {
    // Fallback to relative link (still usable)
    $claimUrl = "/claim-tax-benefit.php?payment_id=" . urlencode($payment_id);
  } else {
    $claimUrl = $app_url . "/claim-tax-benefit.php?payment_id=" . urlencode($payment_id);
  }

  // Send emails (donor + admin)
  $donorOK = true;
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $donorOK = sendDonorEmail(
      $email, $name ?: 'Donor', $payment_id, $claimUrl,
      $smtp_host, $smtp_port, $smtp_username, $smtp_password, $from_name,
      $admin_email ?: $smtp_username
    );
  }
  $adminOK = true;
  if ($admin_email) {
    $adminOK = sendAdminEmail(
      $admin_email,
      [
        'name' => $name, 'email' => $email, 'phone' => $phone,
        'amount' => $amount, 'razorpay_payment_id' => $payment_id, 'razorpay_order_id' => $order_id
      ],
      $smtp_host, $smtp_port, $smtp_username, $smtp_password, $from_name
    );
  }

  echo json_encode([
    'status' => 'success',
    'email'  => ['donor' => $donorOK, 'admin' => $adminOK],
  ]);
} else {
  echo json_encode(['status' => 'error', 'message' => $error]);
}

$conn->close();
