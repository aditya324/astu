<?php
session_start();
require 'db.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$payment_id = $_GET['payment_id'] ?? '';
$amount = '';
$date = '';
$errors = [];

// Fetch donation details from database
if ($payment_id) {
    $stmt = $conn->prepare("SELECT amount, donated_at FROM donations WHERE razorpay_payment_id = ?");
    $stmt->bind_param("s", $payment_id);
    $stmt->execute();
    $stmt->bind_result($dbAmount, $dbDate);
    if ($stmt->fetch()) {
        $amount = $dbAmount;
        $date = date('Y-m-d', strtotime($dbDate)); // MySQL format for insert
        $displayDate = date('d-m-Y', strtotime($dbDate)); // Display format in form
    } else {
        $errors[] = "Invalid payment ID.";
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $pan = strtoupper(htmlspecialchars($_POST['pan']));
    $address = htmlspecialchars($_POST['address']);
    $amount = htmlspecialchars($_POST['amount']);
    $payment_id = htmlspecialchars($_POST['payment_id']);
    $date = htmlspecialchars($_POST['date']);

    // Validation
    if (!$name) $errors[] = "Name is required.";
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (!$pan) $errors[] = "PAN is required.";
    if (!$address) $errors[] = "Address is required.";

    if (empty($errors)) {
        // Convert date to MySQL format if needed
        $dateForDB = date('Y-m-d', strtotime($date));

        // Insert into donor_tax_claims table
        $stmt = $conn->prepare("INSERT INTO donor_tax_claims (payment_id, name, email, pan, address, amount, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        // CORRECT
        $stmt->bind_param("sssssss", $payment_id, $name, $email, $pan, $address, $amount, $dateForDB);

        $stmt->execute();
        $stmt->close();

        // Generate PDF
        $dompdf = new Dompdf();
        $html = "
        <div style='text-align:center;font-family:Arial,sans-serif;'>
            <img src='logo.png' alt='NGO Logo' style='width:120px;margin-bottom:15px;'>
            <h1>80G Donation Certificate</h1>
            <p>Certificate No: {$payment_id}</p>
            <hr>
            <p>This is to certify that <strong>{$name}</strong>, PAN <strong>{$pan}</strong>, has made a donation of <strong>₹{$amount}</strong> on <strong>{$displayDate}</strong> to <strong>YOUR NGO NAME</strong>.</p>
            <p>The donation qualifies for tax deduction under Section 80G of the Income Tax Act.</p>
            <br><br>
            <p style='text-align:right;margin-right:50px;'>Authorized Signatory</p>
        </div>
        ";
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfOutput = $dompdf->output();
        $certFolder = __DIR__ . "/certificates";
        if (!is_dir($certFolder)) mkdir($certFolder, 0755, true);
        $pdfFilePath = $certFolder . "/{$payment_id}.pdf";
        file_put_contents($pdfFilePath, $pdfOutput);

        // Send Email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
            $mail->Port = $_ENV['SMTP_PORT'];

            $mail->setFrom($_ENV['SMTP_USER'], $_ENV['SMTP_FROM_NAME']);
            $mail->addAddress($email, $name);

            $mail->Subject = "Your 80G Donation Certificate";
            $mail->Body = "Dear {$name},\n\nThank you for your generous donation. Please find attached your 80G certificate.\n\nRegards,\nYOUR NGO NAME";

            $mail->addAttachment($pdfFilePath);
            $mail->send();

            $_SESSION['success'] = "Your 80G certificate has been generated and emailed successfully!";
            header("Location: " . $_SERVER['PHP_SELF'] . "?payment_id=" . $payment_id);
            exit;
        } catch (Exception $e) {
            $errors[] = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim 80G Tax Benefit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f8;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2a5d84;
        }

        .btn-primary {
            background: #2a5d84;
            border: none;
        }

        .btn-primary:hover {
            background: #1e4764;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Claim Your 80G Tax Benefit</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0"><?php foreach ($errors as $err) echo "<li>{$err}</li>"; ?></ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success'];
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address *</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="pan" class="form-label">PAN Number *</label>
                <input type="text" id="pan" name="pan" class="form-control" maxlength="10" placeholder="ABCDE1234F" value="<?= htmlspecialchars($_POST['pan'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address *</label>
                <textarea id="address" name="address" class="form-control" rows="3" required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Donation Amount (INR) *</label>
                <input type="number" id="amount" name="amount" class="form-control" readonly value="<?= htmlspecialchars($amount); ?>">
            </div>

            <div class="mb-3">
                <label for="payment_id" class="form-label">Payment ID *</label>
                <input type="text" id="payment_id" name="payment_id" class="form-control" readonly value="<?= htmlspecialchars($payment_id); ?>">
            </div>

            <div class="mb-3">
                <label for="displayDate" class="form-label">Donation Date *</label>
                <input type="text" id="displayDate" class="form-control" readonly value="<?= htmlspecialchars($displayDate ?? date('d-m-Y')); ?>">
                <input type="hidden" name="date" value="<?= htmlspecialchars($date ?? date('Y-m-d')); ?>">
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit & Get Certificate</button>
        </form>
    </div>
</body>

</html>