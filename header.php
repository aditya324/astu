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
                            <a href="./donation.php">Donate Now</a>
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





    <div class="sidebar-group info-group">
        <div class="sidebar-widget">
            <div class="sidebar-widget-container">
                <div class="widget-heading">
                    <a href="#" class="close-side-widget">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
                <div class="sidebar-textwidget">
                    <div class="sidebar-info-contents">
                        <div class="content-inner">
                            <div class="sidebar-logo">
                                <a href="index.html"><img src="assets/images/footer-logo.png" alt="logo"></a>
                            </div>
                            <div class="sidebar-widget-menu">
                                <ul>
                                    <li class="dropdown"><a href="#" data-toggle="dropdown">Home <i
                                                class="icon-arrow"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="index.html">Home </a></li>
                                            <li><a href="landing.html">Home Landing</a></li>
                                            <li><a href="video.html">Home Video</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a href="about.html" data-toggle="dropdown">About</a></li>
                                    <li class="dropdown"><a href="donation.html" data-toggle="dropdown">Donation</a></li>
                                    <li class="dropdown"><a href="#project" data-toggle="dropdown">Pages <i class="icon-arrow"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="service.html">Service</a></li>
                                            <li><a href="service-details.html">Service Details</a></li>
                                            <li><a href="team.html">Team</a></li>
                                            <li><a href="team-detials.html">Team Details</a></li>
                                            <li><a href="faq.html">Faq Page</a></li>
                                            <li><a href="contact.html">Contact</a></li>
                                            <li><a href="error.html">Error Page</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a href="#" data-toggle="dropdown">News <i class="icon-arrow"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="blog-details.html">Blog Details</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a href="contact.html" data-toggle="dropdown">Contacts</a></li>
                                </ul>
                            </div>
                            <div class="contact-info">
                                <h2>Contact Info</h2>
                                <ul class="list-style-one">
                                    <li><i class="bi bi-geo-alt-fill"></i>6391 Elgin St. Celina, Delaware</li>
                                    <li><i class="bi bi-telephone-fill"></i>(+001) 123-456-789</li>
                                    <li><i class="bi bi-envelope"></i> info@example.com</li>
                                    <li><i class="bi bi-alarm-fill"></i> Week Days: 08.00 to 10.00
                                    </li>
                                </ul>
                            </div>
                            <ul class="social-box">
                                <li class="facebook"><a href="#" class="fab fa-facebook-f"></a></li>
                                <li class="twitter"><a href="#" class="fab fa-instagram"></a></li>
                                <li class="linkedin"><a href="#" class="fab fa-twitter"></a></li>
                                <li class="instagram"><a href="#" class="fab fa-pinterest-p"></a></li>
                                <li class="youtube"><a href="#" class="fab fa-linkedin-in"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>