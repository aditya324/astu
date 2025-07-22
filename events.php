<?php
// FILE: events.php

// Setup: Includes and initial variables
require_once 'db.php';
require 'config.php';

// --- PHP LOGIC FOR PAGINATION & TABS ---

// 1. Determine active tab
$valid_tabs = ['upcoming', 'current', 'past'];
$active_tab = isset($_GET['tab']) && in_array($_GET['tab'], $valid_tabs) ? $_GET['tab'] : 'upcoming';

// 2. Pagination variables
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 4; // A smaller number of events per page looks better with this design
$offset = ($page - 1) * $limit;
$today = date('Y-m-d');

// 3. Build queries based on the active tab
$sql_where = "";
$count_sql_where = "";

switch ($active_tab) {
    case 'current':
        $sql_where = "WHERE event_date = ? ORDER BY event_time ASC LIMIT ? OFFSET ?";
        $count_sql_where = "WHERE event_date = ?";
        break;
    case 'past':
        $sql_where = "WHERE event_date < ? ORDER BY event_date DESC, event_time DESC LIMIT ? OFFSET ?";
        $count_sql_where = "WHERE event_date < ?";
        break;
    default:
        $sql_where = "WHERE event_date > ? ORDER BY event_date ASC, event_time ASC LIMIT ? OFFSET ?";
        $count_sql_where = "WHERE event_date > ?";
        break;
}

// 4. Get total event count for pagination
$count_stmt = $conn->prepare("SELECT COUNT(id) as total FROM events " . $count_sql_where);
$count_stmt->bind_param("s", $today);
$count_stmt->execute();
$count_result = $count_stmt->get_result()->fetch_assoc();
$total_events = $count_result['total'];
$total_pages = ceil($total_events / $limit);

// 5. Fetch events for the current page
$stmt = $conn->prepare("SELECT * FROM events " . $sql_where);
$stmt->bind_param("sii", $today, $limit, $offset);
$stmt->execute();
$events = $stmt->get_result();

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
    <link rel="stylesheet" href="/events.css">
	<!-- modernizr js -->
	<script src="assets/js/vendor/modernizr-3.5.0.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
</head>
<body>

    <?php require "header.php"; ?>

    <div class="breatcome-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="breatcome-content">
						<div class="breatcome-title">
							<h1>Events</h1>
						</div>
						<div class="bratcome-text">
							<ul>
								<li><a href="/">Home</a></li>
								<li>Events</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <div class="events-page-area py-5">
        <div class="container">

            <ul class="nav nav-tabs events-nav-tabs mb-5 justify-content-center" role="tablist">
                <li class="nav-item"><a class="nav-link <?= $active_tab == 'upcoming' ? 'active' : '' ?>" href="?tab=upcoming">Upcoming</a></li>
                <li class="nav-item"><a class="nav-link <?= $active_tab == 'current' ? 'active' : '' ?>" href="?tab=current">Current</a></li>
                <li class="nav-item"><a class="nav-link <?= $active_tab == 'past' ? 'active' : '' ?>" href="?tab=past">Past</a></li>
            </ul>

            <div class="row">
                <?php if ($events->num_rows > 0): ?>
                    <?php 
                    $i = 0; // Initialize counter for animation delay
                    while ($row = $events->fetch_assoc()): 
                    ?>
                        <div class="col-lg-10 offset-lg-1 col-md-12">
                            <div class="events-card-vertical" style="--animation-delay: <?= $i * 150 ?>ms;">
                                <div class="event-card-inner">
                                    <div class="event-image-wrapper">
                                        <div class="event-date-vertical">
                                           <p><?= date('d', strtotime($row['event_date'])) ?></p>
                                           <span><?= date('M', strtotime($row['event_date'])) ?></span>
                                        </div>
                                        <a href="event-details.php?id=<?= (int)$row['id'] ?>">
                                            <img src="<?= BASE_URL . htmlspecialchars($row['image_path']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                                        </a>
                                    </div>
                                    <div class="event-content-wrapper">
                                        <h3 class="event-title-vertical">
                                            <a href="event-details.php?id=<?= (int)$row['id'] ?>"><?= htmlspecialchars($row['title']) ?></a>
                                        </h3>
                                        <div class="event-meta-vertical">
                                            <span><i class="bi bi-clock"></i> <?= htmlspecialchars($row['event_time']) ?></span>
                                            <span><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($row['venue']) ?></span>
                                        </div>
                                        <p class="event-description">Join us for this exciting event. Your participation and support are vital for our cause and help us make a significant impact.</p>
                                        <a href="event-details.php?id=<?= (int)$row['id'] ?>" class="details-btn-vertical">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                    $i++; // Increment counter
                    endwhile; 
                    ?>
                <?php else: ?>
                    <div class="col-12 text-center mt-4">
                        <p class="fs-5 text-muted">No <?= htmlspecialchars($active_tab) ?> events found. Please check back later! 📅</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($total_pages > 1): ?>
            <div class="row pt-4">
                <div class="col-lg-12">
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="?tab=<?= $active_tab ?>&page=<?= $page - 1 ?>">Previous</a></li>
                            <?php for ($p_i = 1; $p_i <= $total_pages; $p_i++): ?>
                            <li class="page-item <?= ($page == $p_i) ? 'active' : '' ?>"><a class="page-link" href="?tab=<?= $active_tab ?>&page=<?= $p_i ?>"><?= $p_i ?></a></li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>"><a class="page-link" href="?tab=<?= $active_tab ?>&page=<?= $page + 1 ?>">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>

    <?php
    // If you have a footer file, include it here
    require "footer.php"; 
    ?>
    
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</body>
</html>