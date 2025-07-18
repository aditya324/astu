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

	<?php
	require_once 'db.php'; // your connection file
	require 'config.php';

	$today = date('Y-m-d');

	// Upcoming Events
	$upcoming = $conn->query("SELECT * FROM events WHERE event_date > '$today' ORDER BY event_date ASC");

	// Current Events (today's date)
	$current = $conn->query("SELECT * FROM events WHERE event_date = '$today'");

	// Past Events
	$past = $conn->query("SELECT * FROM events WHERE event_date < '$today' ORDER BY event_date DESC");



	if (!$upcoming || !$current || !$past) {
		echo "Error fetching events: " . $conn->error;
	}
	?>



	<div class="loader_bg">
		<div class="loader"></div>
	</div>

	<!--==================================================-->
	<!-- Start Topbar Area -->
	<!--==================================================-->
	<div class="topbar-area">
		<div class="topbar-inner">
			<div class="container">
				<div class="row">
					<div class="col-lg-9">
						<div class="topbar-items">
							<ul>
								<li><i class="bi bi-geo-alt"></i> <a href="#">Location : 12W Profession Str Hobert, CA</a></li>
								<li><i class="bi bi-envelope"></i> <a href="#">Our Email : helpus24@gmail.com</a></li>
								<li class="inner"><a href="#"><i class="bi bi-alarm"></i> Office Time : Mon - Fri 8:00 - 6:30</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="topbar-social">
							<h4>Follow on:</h4>
							<ul>
								<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
								<li><a href="#"><i class="fab fa-twitter"></i></a></li>
								<li><a href="#"><i class="fab fa-vimeo-v"></i></a></li>
								<li><a href="#"><i class="fab fa-instagram"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--==================================================-->
	<!-- End Topbar Area -->
	<!--==================================================-->


	<!--==================================================-->
	<!-- Start Header Area -->
	<!--==================================================-->
	<header class="header-area" id="sticky-header">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-3">
					<div class="logo">
						<a href="index.html"><img src="assets/images/logo.png" alt=""></a>
					</div>
				</div>
				<div class="col-lg-9">
					<div class="header-menu-items">
						<div class="header-menu">
							<ul>
								<li><a href="#">Home <i class="bi bi-chevron-down"></i></a>
									<div class="sub-menu">
										<ul>
											<li><a href="index.html">Home </a></li>
											<li><a href="landing.html">Home Landing</a></li>
											<li><a href="video.html">Home Video</a></li>
										</ul>
									</div>
								</li>
								<li><a href="about.html">About</a></li>
								<li><a href="donation.html">Donation</a></li>
								<li><a href="#">Pages <i class="bi bi-chevron-down"></i></a>
									<div class="sub-menu">
										<ul>
											<li><a href="service.html">Service</a></li>
											<li><a href="service-details.html">Service Details</a></li>
											<li><a href="team.html">Team</a></li>
											<li><a href="team-detials.html">Team Details</a></li>
											<li><a href="faq.html">Faq Page</a></li>
											<li><a href="contact.html">Contact</a></li>
											<li><a href="error.html">Error Page</a></li>
										</ul>
									</div>
								</li>
								<li><a href="#">News <i class="bi bi-chevron-down"></i></a>
									<div class="sub-menu">
										<ul>
											<li><a href="blog.html">Blog</a></li>
											<li><a href="blog-details.html">Blog Details</a></li>
										</ul>
									</div>
								</li>
								<li><a href="contact.html">Contacts</a></li>
							</ul>
						</div>
						<div class="header-social">
							<div class="header-call">
								<div class="header-call-icon">
									<i class="bi bi-telephone-plus"></i>
								</div>
								<div class="header-call-title">
									<a href="#">Free contact 24/7 </a>
									<span><a href="#">936-668-36736</a></span>
								</div>
								<div class="header-search">
									<a class="search-box-btn search-box-outer" href="#"><i class="bi bi-search"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<section class="py-5" style="background-color: #f9fafb;">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="card shadow-lg border-0 rounded-4 p-4">
						<h2 class="text-center mb-4 fw-bold text-primary">🎉 Add New Event</h2>
						<form action="submit_events.php" method="POST" enctype="multipart/form-data">
							<!-- Event Image -->
							<div class="mb-3">
								<label class="form-label"><i class="bi bi-image"></i> Event Image (800×600)</label>
								<input type="file" name="image" class="form-control" id="imageInput" accept="image/*" required>
								<div class="form-text text-danger" id="imageError" style="display: none;"></div>
							</div>

							<!-- Event Title -->
							<div class="mb-3">
								<label class="form-label"><i class="bi bi-card-text"></i> Event Title</label>
								<input type="text" name="title" class="form-control" placeholder="e.g., Health Camp for Women" required>
							</div>

							<!-- Description -->
							<div class="mb-3">
								<label class="form-label"><i class="bi bi-pencil-square"></i> Description</label>
								<textarea name="description" class="form-control" rows="4" placeholder="Describe the event..." required></textarea>
							</div>

							<!-- Date & Time Row -->
							<div class="row">
								<div class="col-md-6 mb-3">
									<label class="form-label"><i class="bi bi-calendar-event text-primary"></i> Event Date</label>
									<input type="date" name="event_date" class="form-control" required>
								</div>
								<div class="col-md-6 mb-3">
									<label class="form-label"><i class="bi bi-clock test-primary"></i> Event Time</label>
									<input type="time" name="event_time" class="form-control" required>
								</div>
							</div>

							<!-- Venue -->
							<div class="mb-4">
								<label class="form-label"><i class="bi bi-geo-alt-fill"></i> Venue</label>
								<input type="text" name="venue" class="form-control" placeholder="e.g., Community Hall, Sector 21" required>
							</div>

							<!-- Submit Button -->
							<div class="text-center">
								<button type="submit" name="submit" class="btn btn-lg btn-primary px-5">
									<i class="bi bi-plus-circle-fill me-2"></i>Add Event
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="py-5 bg-light">
	<div class="container">
		<h2 class="text-center fw-bold mb-4">📅 Events</h2>

		<ul class="nav nav-tabs mb-4 justify-content-center" id="eventTabs" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button" role="tab">Upcoming</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="current-tab" data-bs-toggle="tab" data-bs-target="#current" type="button" role="tab">Current</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past" type="button" role="tab">Past</button>
			</li>
		</ul>

		<div class="tab-content" id="eventTabsContent">

			<!-- Upcoming Events -->
			<div class="tab-pane fade show active" id="upcoming" role="tabpanel">
				<div class="row g-4">
					<?php if ($upcoming->num_rows > 0): ?>
						<?php while ($row = $upcoming->fetch_assoc()): ?>
							<div class="col-md-6 col-lg-4">
								<div class="card h-100 shadow-sm">
									<img src="<?= BASE_URL . htmlspecialchars($row['image_path']) ?>" class="card-img-top" alt="Event Image">
									<div class="card-body">
										<h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
										<p class="card-text"><?= nl2br(htmlspecialchars($row['description'])) ?></p>
										<p class="mb-1"><strong>Date:</strong> <?= $row['event_date'] ?></p>
										<p class="mb-1"><strong>Time:</strong> <?= $row['event_time'] ?></p>
										<p class="mb-0"><strong>Venue:</strong> <?= htmlspecialchars($row['venue']) ?></p>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
					<?php else: ?>
						<p class="text-muted text-center">No upcoming events.</p>
					<?php endif; ?>
				</div>
			</div>

			<!-- Current Events -->
			<div class="tab-pane fade" id="current" role="tabpanel">
				<div class="row g-4">
					<?php if ($current->num_rows > 0): ?>
						<?php while ($row = $current->fetch_assoc()): ?>
							<div class="col-md-6 col-lg-4">
								<div class="card h-100 shadow-sm">
									<img src="<?= BASE_URL . htmlspecialchars($row['image_path']) ?>" class="card-img-top" alt="Event Image">
									<div class="card-body">
										<h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
										<p class="card-text"><?= nl2br(htmlspecialchars($row['description'])) ?></p>
										<p class="mb-1"><strong>Time:</strong> <?= $row['event_time'] ?></p>
										<p class="mb-1"><strong>Date:</strong> <?= $row['event_date'] ?></p>
										<p class="mb-0"><strong>Venue:</strong> <?= htmlspecialchars($row['venue']) ?></p>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
					<?php else: ?>
						<p class="text-muted text-center">No current events.</p>
					<?php endif; ?>
				</div>
			</div>

			<!-- Past Events -->
			<div class="tab-pane fade" id="past" role="tabpanel">
				<div class="row g-4">
					<?php if ($past->num_rows > 0): ?>
						<?php while ($row = $past->fetch_assoc()): ?>
							<div class="col-md-6 col-lg-4">
								<div class="card h-100 shadow-sm">
									<img src="<?= BASE_URL . htmlspecialchars($row['image_path']) ?>" class="card-img-top" alt="Event Image">
									<div class="card-body">
										<h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
										<p class="card-text"><?= nl2br(htmlspecialchars($row['description'])) ?></p>
										<p class="mb-1"><strong>Date:</strong> <?= $row['event_date'] ?></p>
										<p class="mb-1"><strong>Time:</strong> <?= $row['event_time'] ?></p>
										<p class="mb-0"><strong>Venue:</strong> <?= htmlspecialchars($row['venue']) ?></p>
									</div>
								</div>
							</div>
						<?php endwhile; ?>	
					<?php else: ?>
						<p class="text-muted text-center">No past events.</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>




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
<script>
	const imageInput = document.getElementById('imageInput');
	const imageError = document.getElementById('imageError');

	imageInput.addEventListener('change', function() {
		const file = this.files[0];
		if (!file) return;

		const img = new Image();
		img.src = URL.createObjectURL(file);

		img.onload = function() {
			const width = img.naturalWidth;
			const height = img.naturalHeight;


			const requiredWidth =310;
			const requiredHeight = 300;

			if (width !== requiredWidth || height !== requiredHeight) {
				imageError.style.display = "block";
				imageError.innerText = `Image must be exactly ${requiredWidth}×${requiredHeight}px. Current size: ${width}×${height}px.`;
				imageInput.value = '';
			} else {
				imageError.style.display = "none";
			}
		};
	});
</script>

</html>