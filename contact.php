<?php
// contact.php

// Start session to show success/error messages
session_start();

// Use PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// --- HANDLE FORM SUBMISSION ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// 1. Load prerequisites
	require 'vendor/autoload.php'; // Composer autoloader

	// Load environment variables from .env file
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
	$dotenv->load();

	// Connect to the database	
	require_once 'db.php';

	// 2. Retrieve and sanitize form data
	$name = trim($_POST['name']);
	$email = trim($_POST['email']);
	$phone = trim($_POST['phone']);
	$website = trim($_POST['website']);
	$company_name = trim($_POST['company_name']);
	$message = trim($_POST['message']);

	// 3. Save to database
	$sql = "INSERT INTO contact_submissions (name, email, phone, website, company_name, message) VALUES (?, ?, ?, ?, ?, ?)";
	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("ssssss", $name, $email, $phone, $website, $company_name, $message);
		$stmt->execute();
		$stmt->close();
	}

	// 4. Send email notification
	$mail = new PHPMailer(true);
	try {
		// Server settings from .env
		$mail->isSMTP();
		$mail->Host       = $_ENV['SMTP_HOST'];
		$mail->SMTPAuth   = true;
		$mail->Username   = $_ENV['SMTP_USER'];
		$mail->Password   = $_ENV['SMTP_PASS'];
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		$mail->Port       = $_ENV['SMTP_PORT'];

		// Recipients
		$mail->setFrom($_ENV['SMTP_USER'], 'Your Website Contact Form');
		$mail->addAddress($_ENV['ADMIN_EMAIL'], 'Admin');
		$mail->addReplyTo($email, $name);

		// Content
		$mail->isHTML(true);
		$mail->Subject = 'New Contact Form Submission from ' . htmlspecialchars($name);
		$mail->Body    = "
            <h2 style='color:#0d5a66;'>New Contact Form Submission</h2>
            <p>You have received a new message from your website's contact form.</p>
            <table cellpadding='10' border='1' style='border-collapse: collapse; width: 100%;'>
                <tr><td style='background-color:#f2f2f2;width:150px;'><strong>Name:</strong></td><td>" . htmlspecialchars($name) . "</td></tr>
                <tr><td style='background-color:#f2f2f2;'><strong>Email:</strong></td><td>" . htmlspecialchars($email) . "</td></tr>
                <tr><td style='background-color:#f2f2f2;'><strong>Phone:</strong></td><td>" . htmlspecialchars($phone) . "</td></tr>
                <tr><td style='background-color:#f2f2f2;'><strong>Website:</strong></td><td>" . htmlspecialchars($website) . "</td></tr>
                <tr><td style='background-color:#f2f2f2;'><strong>Company Name:</strong></td><td>" . htmlspecialchars($company_name) . "</td></tr>
                <tr><td style='background-color:#f2f2f2;'><strong>Message:</strong></td><td>" . nl2br(htmlspecialchars($message)) . "</td></tr>
            </table>
        ";

		$mail->send();
		$_SESSION['form_status'] = ['type' => 'success', 'message' => 'Thank you! Your message has been sent.'];
	} catch (Exception $e) {
		$_SESSION['form_status'] = ['type' => 'danger', 'message' => 'Message could not be sent. Please try again.'];
	}

	$conn->close();

	// Redirect to the same page to show the status message
	header("Location: " . $_SERVER['PHP_SELF']);
	exit();
}
?>



<!DOCTYPE HTML>
<html lang="en-US">

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
</head>

<body>
	<!-- loder -->
	<div class="loader_bg">
		<div class="loader"></div>
	</div>

	<!--==================================================-->
	<!-- Start Topbar Area -->
	<!--==================================================-->
	<?php require "header.php" ?>
	<!--==================================================-->
	<!-- End Topbar Area -->
	<!--==================================================-->


	<!--==================================================-->
	<!-- Start Header Area -->
	<!--==================================================-->


	<!-- Nonprts Mobile Menu Area -->
	<div class="mobile-menu-area sticky-menu" id="navbar">
		<div class="mobile-menu">
			<div class="mobile-logo">
				<a href="index.html"><img src="assets/images/logo.png" alt=""></a>
			</div>
			<div class="side-menu-info">
				<div class="sidebar-menu">
					<a class="navSidebar-button" href="#"><i class="bi bi-justify-right"></i></a>
				</div>
			</div>
		</div>
	</div>
	<!--==================================================-->
	<!-- End Header Area -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Breatcome Area -->
	<!--==================================================-->
	<div class="breatcome-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="breatcome-content">
						<div class="breatcome-title">
							<h1>Contact</h1>
						</div>
						<div class="bratcome-text">
							<ul>
								<li><a href="index.html">Home</a></li>
								<li>Contact</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--==================================================-->
	<!-- End Breatcome Area -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Contact Area -->
	<!--==================================================-->
	<div class="contact-area wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="1s">
		<div class="container">
			<div class="row contact">
				<div class="col-lg-4 col-md-12">
					<div class="contact-single-box">
						<div class="contact-title">
							<h4>Contact Informatlon</h4>
						</div>
						<div class="contact-items">
							<div class="contact-icon">
								<i class="bi bi-geo-alt-fill"></i>
							</div>
							<div class="contact-content">
								<h4>Address</h4>
								<h6>7515 Carriage Court,</h6>
							</div>
						</div>
						<div class="contact-items">
							<div class="contact-icon">
								<i class="bi bi-phone-fill"></i>
							</div>
							<div class="contact-content">
								<h4>Contact Namber</h4>
								<h6>(+6656) 1598596969</h6>
							</div>
						</div>
						<div class="contact-items">
							<div class="contact-icon">
								<i class="bi bi-envelope-fill"></i>
							</div>
							<div class="contact-content">
								<h4>Email Us</h4>
								<h6>example@gmail.com</h6>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-8 col-md-12">
					<div class="contact-box">
						<div class="contact-box-title">
							<h4>Contact Us</h4>
						</div>
						<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="it-form">
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<div class="form-box">
										<input type="text" name="name" placeholder="Your Name" required>
									</div>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="form-box">
										<input type="email" name="email" placeholder="Email Address" required>
									</div>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="form-box">
										<input type="tel" name="phone" placeholder="Phone Number">
									</div>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="form-box">
										<input type="text" name="website" placeholder="Website (Optional)">
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-box">
										<input type="text" name="company_name" placeholder="Your Company Name (Optional)">
									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="form-box">
										<textarea name="message" id="message" cols="30" rows="10" placeholder="Write your question here" required></textarea>
									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="form-box-button">
										<button type="Submit">Send Message</button>
									</div>
								</div>
							</div>
						</form>
						<div id="status"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--==================================================-->
	<!-- End Contact Area -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start map Area -->
	<!--==================================================-->

	<div class="map-area wow fadeInUp" data-wow-delay="0.6s" data-wow-duration="1s">
		<div class="container-fluid p-0">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<iframe
						src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7496149.95373021!2d85.84621250756469!3d23.452185887261447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30adaaed80e18ba7%3A0xf2d28e0c4e1fc6b!2sBangladesh!5e0!3m2!1sen!2sbd!4v1635150422284!5m2!1sen!2sbd"
						width="1920" height="608" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
				</div>
			</div>
		</div>
	</div>

	<!--==================================================-->
	<!-- End map Area -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Sidebar Area -->
	<!--==================================================-->
	<?php require "footer.php" ?>
	<!--==================================================-->
	<!-- End Sidebar Area -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Footer Area -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- End Footer Area -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Search Popup Area -->
	<!--==================================================-->
	<div class="search-popup">
		<button class="close-search style-two"><span class="flaticon-multiply"><i
					class="far fa-times-circle"></i></span></button>
		<button class="close-search"><i class="fas fa-arrow-up"></i></button>
		<form method="post" action="#">
			<div class="form-group">
				<input type="search" name="search-field" value="" placeholder="Search Here" required="">
				<button type="submit"><i class="fa fa-search"></i></button>
			</div>
		</form>
	</div>
	<!--==================================================-->
	<!-- End Search Popup Area -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start scrollup section Area -->
	<!--==================================================-->
	<!-- scrollup section -->
	<div class="prgoress_scrollup">
		<svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
			<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
		</svg>
	</div>

	<!--==================================================-->
	<!-- End scrollup section Area -->
	<!--==================================================-->


	<!-- jquery js -->
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