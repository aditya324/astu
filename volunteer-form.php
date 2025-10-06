<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// ---------- .env ----------
if (class_exists('\\Dotenv\\Dotenv')) {
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->safeLoad();
}

// ---------- env helper ----------
function envv($k, $d = null) {
  $v = getenv($k);
  if ($v === false && isset($_ENV[$k])) $v = $_ENV[$k];
  if ($v === false && isset($_SERVER[$k])) $v = $_SERVER[$k];
  return ($v === false || $v === null || $v === '') ? $d : $v;
}

// Toggle to show SMTP transcript in the UI (set false after testing)
$SHOW_SMTP_DEBUG = false;

// ---------- handle form ----------
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  require_once 'db.php';

  // Sanitize inputs
  $fullName = trim($_POST['full_name'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $phone    = trim($_POST['phone'] ?? '');
  $city     = trim($_POST['city'] ?? '');
  $interest = trim($_POST['interest'] ?? '');
  $message  = trim($_POST['message'] ?? '');

  // Basic validation
  if ($fullName === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $phone === '' || $city === '' || $interest === '') {
    $_SESSION['form_status'] = ['type' => 'danger', 'message' => 'Please fill all required fields with valid information.'];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }

  // Insert into DB
  $sql = "INSERT INTO volunteers (full_name, email, phone, city, interest, message) VALUES (?, ?, ?, ?, ?, ?)";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ssssss", $fullName, $email, $phone, $city, $interest, $message);
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

  // ---------- SMTP config (supports both naming styles) ----------
  $smtp_host     = envv('SMTP_HOST', 'smtp.gmail.com');
  $smtp_port     = (int) envv('SMTP_PORT', 587);
  $smtp_username = trim(envv('SMTP_USERNAME', envv('SMTP_USER', '')));
  $smtp_password = trim(envv('SMTP_PASSWORD', envv('SMTP_PASS', '')));
  $admin_email   = envv('ADMIN_EMAIL', $smtp_username);

  // Optional: extra test recipient while debugging
  $test_gmail    = trim(envv('TEST_GMAIL', ''));

  // Helpers for message bodies
  $safe = fn($v) => htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
  $when = date('F j, Y, g:i a');

  $adminHTML = "
<div style='font-family: Arial, sans-serif; line-height:1.6;'>
  <h2 style='color:#0d5a66;margin:0 0 8px;'>New Volunteer Application</h2>
  <p style='margin:0 0 12px;'>A new application was submitted on {$when} with the following details:</p>
  <table cellpadding='10' border='1' style='border-collapse:collapse;width:100%;'>
    <tr style='background:#f6f6f6;'><td style='width:180px;'><strong>Full Name</strong></td><td>{$safe($fullName)}</td></tr>
    <tr><td><strong>Email Address</strong></td><td>{$safe($email)}</td></tr>
    <tr style='background:#f6f6f6;'><td><strong>Phone Number</strong></td><td>{$safe($phone)}</td></tr>
    <tr><td><strong>City</strong></td><td>{$safe($city)}</td></tr>
    <tr style='background:#f6f6f6;'><td><strong>Area of Interest</strong></td><td>{$safe($interest)}</td></tr>
    <tr><td><strong>Message</strong></td><td>" . nl2br($safe($message)) . "</td></tr>
  </table>
</div>";

  $adminAlt = "New Volunteer Application\n\nFull Name: {$fullName}\nEmail: {$email}\nPhone: {$phone}\nCity: {$city}\nArea of Interest: {$interest}\nMessage: " . str_replace(["\r","\n"], [' ', ' '], $message);

  $volHTML = "
<div style='font-family: Arial, sans-serif; line-height:1.6;'>
  <p>Hi {$safe($fullName)},</p>
  <p>Thank you for volunteering with <strong>Asthu Foundation</strong>! We’ve received your application and our team will get back to you shortly.</p>
  <p><strong>Your submission</strong></p>
  <ul style='line-height:1.8;'>
    <li>Email: {$safe($email)}</li>
    <li>Phone: {$safe($phone)}</li>
    <li>City: {$safe($city)}</li>
    <li>Interest: {$safe($interest)}</li>
  </ul>
  <p style='margin-top:12px;'>Warm regards,<br>Asthu Foundation</p>
</div>";

  $volAlt = "Hi {$fullName},\n\nThank you for volunteering with Asthu Foundation! We’ve received your application and will get back to you shortly.\n\n- Asthu Foundation";

  // Prepare a function to send emails (DRY)
  $sendMail = function(string $toEmail, string $toName, string $subject, string $html, string $alt) use (
    $smtp_host, $smtp_port, $smtp_username, $smtp_password, $SHOW_SMTP_DEBUG, $admin_email
  ) {
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

    // From must be the authenticated mailbox (GoDaddy/Gmail rule)
    $m->setFrom($smtp_username, 'Asthu Foundation');

    // Envelope sender (helps DMARC/bounces esp. on GoDaddy)
    $domain = substr(strrchr($smtp_username, "@"), 1);
    if ($domain) {
      $m->Sender = 'bounce@' . $domain; // ensure this is an allowed/valid sender on your domain
    }

    $m->addAddress($toEmail, $toName);
    // For volunteer confirmation, set a sensible reply-to to the foundation/admin
    $m->addReplyTo($admin_email ?: $smtp_username, 'Asthu Foundation');

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

    // --- 1) ADMIN NOTIFICATION ---
    $adminTrace = "";
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

    $mail->setFrom($smtp_username, 'Asthu Foundation');
    $domain = substr(strrchr($smtp_username, "@"), 1);
    if ($domain) {
      $mail->Sender = 'bounce@' . $domain;
    }

    if ($admin_email) $mail->addAddress($admin_email, 'Admin');
    if ($smtp_username && $smtp_username !== $admin_email) {
      $mail->addAddress($smtp_username, 'Admin Copy');
    }
    // Optional: extra debug recipient
    if ($test_gmail && filter_var($test_gmail, FILTER_VALIDATE_EMAIL)) {
      $mail->addAddress($test_gmail, 'Gmail Test Copy');
    }

    // Replies go to the volunteer
    $mail->addReplyTo($email, $fullName);

    $mail->isHTML(true);
    $mail->Subject = 'New Volunteer Application: ' . $safe($fullName);
    $mail->Body    = $adminHTML;
    $mail->AltBody = $adminAlt;
    $mail->send();

    // --- 2) VOLUNTEER CONFIRMATION ---
    $volTrace = $sendMail($email, $fullName, 'Thanks for volunteering with Asthu Foundation', $volHTML, $volAlt);

    if ($SHOW_SMTP_DEBUG) {
      $smtp_trace_all = "ADMIN MAIL:\n" . $adminTrace . "\n\nVOLUNTEER MAIL:\n" . $volTrace;
    }

    $msg = 'Thank you! Your application has been submitted successfully.';
    if ($SHOW_SMTP_DEBUG && $smtp_trace_all) {
      $msg .= "\n\nSMTP transcript:\n" . $smtp_trace_all;
    }
    $_SESSION['form_status'] = ['type' => 'success', 'message' => nl2br($msg)];
  } catch (Exception $e) {
    $err = 'Mail failed: ' . (isset($mail) && $mail->ErrorInfo ? $mail->ErrorInfo : $e->getMessage());
    if ($SHOW_SMTP_DEBUG && $smtp_trace_all) {
      $err .= "\n\nSMTP transcript:\n" . $smtp_trace_all;
    }
    $_SESSION['form_status'] = ['type' => 'danger', 'message' => nl2br($err)];
  }

  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Become a Volunteer | Asthu Foundation</title>
  <meta name="description" content="Partner with Asthu Foundation or volunteer as a professional to create measurable impact." />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="56x56" href="assets/images/fav-icon/icon.png" />
  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

  <!-- (Keep your existing includes if needed) -->
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/responsive.css" />

  <style>
    .brand-accent { color:#DF5311; }
    .bg-soft { background: linear-gradient(180deg, rgba(223,83,17,0.06) 0%, rgba(223,83,17,0.02) 100%); }
    .tier-card { border: 1px solid rgba(0,0,0,0.06); border-radius: 18px; transition: all .25s ease; background: #fff; }
    .tier-card:hover { transform: translateY(-4px); box-shadow: 0 14px 35px rgba(0,0,0,0.08); }
    .tier-cap { font-size:.9rem; background: rgba(223,83,17,.1); color:#DF5311; border-radius: 999px; padding: .35rem .7rem; display:inline-block; }
    .divider-dot { width:6px; height:6px; border-radius:50%; background:#DF5311; display:inline-block; margin:0 .5rem; opacity:.7; }
    .icon-bullet { width:1.35rem; height:1.35rem; border-radius:50%; background:rgba(223,83,17,.12); display:inline-flex; align-items:center; justify-content:center; margin-right:.6rem; flex:0 0 1.35rem; }
    .icon-bullet i { font-size:.8rem; color:#DF5311; }
    .list-clean li { margin-bottom:.5rem; }
    .stripe-top { height:6px; background:linear-gradient(90deg, #DF5311, #ff8c57); border-top-left-radius:18px; border-top-right-radius:18px; }
    .section-label { font-size:.85rem; letter-spacing:.12em; text-transform:uppercase; color:#6c757d; }
    .btn-accent { background:#DF5311; border-color:#DF5311; color:#fff; }
    .btn-accent:hover { background:#c8480f; border-color:#c8480f; color:#fff; }
  </style>
</head>

<body class="bg-light">
  <?php require "header.php" ?>

  <!-- ===== Partnership & Volunteers (Premium Section) ===== -->
  <section class="py-5 bg-soft" id="partnerships">
    <div class="container">
      <div class="text-center mb-4">
        <div class="section-label mb-2">Partner with Asthu Foundation</div>
        <h2 class="fw-bold mb-3">Partnership Opportunities</h2>
        <p class="text-muted mb-0">Choose a pathway to create measurable impact. <span class="divider-dot"></span>Transparent outcomes <span class="divider-dot"></span>Scalable programs</p>
      </div>

      <div class="row g-4">
        <div class="col-md-6 col-lg-4">
          <div class="tier-card h-100">
            <div class="stripe-top"></div>
            <div class="p-4">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h5 class="mb-0">Individual Champions</h5>
                <span class="tier-cap">₹1,000 – ₹10,00,000+</span>
              </div>
              <hr class="mt-3 mb-3">
              <ul class="list-unstyled list-clean mb-0">
                <li class="d-flex">
                  <span class="icon-bullet"><i class="fa-solid fa-heart"></i></span>
                  <span><strong>Healthcare Heroes</strong>: Monthly giving for sustained impact</span>
                </li>
                <li class="d-flex">
                  <span class="icon-bullet"><i class="fa-solid fa-stethoscope"></i></span>
                  <span><strong>Program Sponsors</strong>: Fund specific initiatives or equipment</span>
                </li>
                <li class="d-flex">
                  <span class="icon-bullet"><i class="fa-solid fa-seedling"></i></span>
                  <span><strong>Legacy Builders</strong>: Estate planning & endowments</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="tier-card h-100">
            <div class="stripe-top"></div>
            <div class="p-4">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h5 class="mb-0">Corporate Partners</h5>
                <span class="tier-cap">₹10,00,000 – ₹10,00,00,000+</span>
              </div>
              <hr class="mt-3 mb-3">
              <ul class="list-unstyled list-clean mb-0">
                <li class="d-flex">
                  <span class="icon-bullet"><i class="fa-solid fa-handshake-angle"></i></span>
                  <span><strong>Strategic Alliances</strong>: Long-term CSR with measurable outcomes</span>
                </li>
                <li class="d-flex">
                  <span class="icon-bullet"><i class="fa-solid fa-microchip"></i></span>
                  <span><strong>Innovation Collaborations</strong>: Co-develop & deploy technology</span>
                </li>
                <li class="d-flex">
                  <span class="icon-bullet"><i class="fa-solid fa-users"></i></span>
                  <span><strong>Employee Engagement</strong>: Volunteering & skill-based projects</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="tier-card h-100">
            <div class="stripe-top"></div>
            <div class="p-4">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h5 class="mb-0">Institutional Partners</h5>
                <span class="tier-cap">₹50,00,000 – ₹50,00,00,000+</span>
              </div>
              <hr class="mt-3 mb-3">
              <ul class="list-unstyled list-clean mb-0">
                <li class="d-flex">
                  <span class="icon-bullet"><i class="fa-solid fa-building-columns"></i></span>
                  <span><strong>Foundation Partnerships</strong>: Multi-year funding & capacity building</span>
                </li>
                <li class="d-flex">
                  <span class="icon-bullet"><i class="fa-solid fa-landmark-flag"></i></span>
                  <span><strong>Government Collaborations</strong>: Policy development & scaling</span>
                </li>
                <li class="d-flex">
                  <span class="icon-bullet"><i class="fa-solid fa-graduation-cap"></i></span>
                  <span><strong>Academic Alliances</strong>: Research & evidence generation</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Volunteer Excellence -->
      <div class="row g-4 mt-4" id="volunteer-excellence">
        <div class="col-lg-10 mx-auto">
          <div class="tier-card">
            <div class="stripe-top"></div>
            <div class="p-4 p-md-5">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <h3 class="mb-0">Volunteer Excellence Program</h3>
                <a href="#volunteer-form" class="btn btn-accent btn-sm">Become a Volunteer</a>
              </div>
              <p class="text-muted mb-4">Join a high-impact community of professionals strengthening rural healthcare, education, and empowerment.</p>
              <div class="row g-3">
                <div class="col-md-6 col-xl-3">
                  <div class="d-flex">
                    <span class="icon-bullet"><i class="fa-solid fa-user-doctor"></i></span>
                    <div><strong>Medical Professionals</strong><br><span class="text-muted">Clinical expertise & training delivery</span></div>
                  </div>
                </div>
                <div class="col-md-6 col-xl-3">
                  <div class="d-flex">
                    <span class="icon-bullet"><i class="fa-solid fa-code"></i></span>
                    <div><strong>Technology Experts</strong><br><span class="text-muted">Build digital health solutions</span></div>
                  </div>
                </div>
                <div class="col-md-6 col-xl-3">
                  <div class="d-flex">
                    <span class="icon-bullet"><i class="fa-solid fa-briefcase"></i></span>
                    <div><strong>Business Leaders</strong><br><span class="text-muted">Strategy & operational excellence</span></div>
                  </div>
                </div>
                <div class="col-md-6 col-xl-3">
                  <div class="d-flex">
                    <span class="icon-bullet"><i class="fa-solid fa-chalkboard-user"></i></span>
                    <div><strong>Educators</strong><br><span class="text-muted">Program design & delivery</span></div>
                  </div>
                </div>
              </div>
              <div class="mt-4 d-flex flex-wrap gap-2">
                <a href="./donation.php" class="btn btn-accent">Donate Now</a>
                <a href="#contact" class="btn btn-outline-dark">Discuss Partnerships</a>
              </div>
            </div>
          </div>
        </div>
      </div>x`

    </div>
  </section>
  <!-- ===== /Partnership & Volunteers ===== -->

  <!-- ===== Volunteer Form ===== -->
  <div class="container mt-5" id="volunteer-form">
    <div class="col-md-8 mx-auto">
      <h2 class="mb-4 text-center">Become a Volunteer</h2>

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
          <label for="fullName" class="form-label" style="color: black;">Full Name</label>
          <input type="text" class="form-control" name="full_name" id="fullName" required>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="email" class="form-label" style="color: black;">Email Address</label>
            <input type="email" class="form-control" name="email" id="email" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="phone" class="form-label" style="color: black;">Phone Number</label>
            <input type="tel" class="form-control" name="phone" id="phone" required>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="city" class="form-label" style="color: black;">City</label>
            <input type="text" class="form-control" name="city" id="city" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="interest" class="form-label" style="color: black;">Area of Interest</label>
            <select class="form-select" name="interest" id="interest" required>
              <option value="" disabled selected>Select an option</option>
              <option value="Event Planning">Event Planning</option>
              <option value="Fundraising">Fundraising</option>
              <option value="Community Outreach">Community Outreach</option>
              <option value="Administrative Support">Administrative Support</option>
              <option value="Other">Other</option>
            </select>
          </div>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label" style="color: black;">Message (Optional)</label>
          <textarea class="form-control" name="message" id="message" rows="4"></textarea>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary btn-lg" style="background-color:#DF5311">Submit Application</button>
        </div>
      </form>
    </div>
  </div>
  <!-- ===== /Volunteer Form ===== -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <?php require "footer.php" ?>
</body>
</html>
