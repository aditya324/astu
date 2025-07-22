<?php
// includes/header.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .header-menu-items {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-menu {
        flex: 1;
    }

    .header-menu ul {
        display: flex;
        flex-wrap: wrap;

        gap: 20px;
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .header-menu ul li {
        position: relative;
    }

    .donate-btn a {
        background-color: #138999;
        color: white;
        padding: 20px 50px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
    }
</style>

<body>
    <header class="header-area" id="sticky-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <div class="logo">
                        <a href="index.php">
                            <img src="assets/images/astu-logo.png" alt="Logo" />
                        </a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="header-menu-items">
                        <!-- Navigation Menu -->
                        <div class="header-menu">
                            <ul>
                                <li><a href="/">Home</a></li>
                                <li><a href="about.php">About</a></li>
                                <li><a href="donation.html">Donation</a></li>
                                <!-- <li>
                                    <a href="service.php">Service <i class="bi bi-chevron-down"></i></a>
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
                                </li> -->   
                                <li><a href="service.php">Service</li>
                                <li><a href="events.php">Events</li>
                                <li>
                                    <a href="blogs.php">Blogs <i class="bi bi-chevron-down"></i></a>
                                    <div class="sub-menu">
                                        <!-- <ul>
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="blog-details.html">Blog Details</a></li>
                  </ul> -->
                                    </div>
                                </li>
                                <li><a href="contact.html">Contacts</a></li>
                            </ul>
                        </div>

                        <!-- Donate Now Button -->
                        <div class="donate-btn ms-3">
                            <a href="donation.html">Donate Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

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
</body>

</html>