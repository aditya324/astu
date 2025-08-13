<?php
require 'db.php';


$result = $conn->query("SELECT villages_served, blind_children_supported, patients_treated, women_empowered FROM stats LIMIT 1");
$stats = $result->fetch_assoc();
?>



<!DOCTYPE html>
<html lang="en-US">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Nonpro-Nonprofit Charity HTML5 Template</title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Favicon -->
  <link
    rel="icon"
    type="image/png"
    sizes="56x56"
    href="assets/images/fav-icon/icon.png" />
  <!-- bootstrap CSS -->
  <link
    rel="stylesheet"
    href="assets/css/bootstrap.min.css"
    type="text/css"
    media="all" />

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <!-- carousel CSS -->
  <link
    rel="stylesheet"
    href="assets/css/owl.carousel.min.css"
    type="text/css"
    media="all" />
  <!-- animate CSS -->
  <link
    rel="stylesheet"
    href="assets/css/animate.css"
    type="text/css"
    media="all" />
  <!-- font-awesome CSS -->
  <link
    rel="stylesheet"
    href="assets/css/all.min.css"
    type="text/css"
    media="all" />



  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <!-- font-flaticon CSS -->
  <link
    rel="stylesheet"
    href="assets/css/flaticon.css"
    type="text/css"
    media="all" />
  <!-- theme-default CSS -->
  <link
    rel="stylesheet"
    href="assets/css/theme-default.css"
    type="text/css"
    media="all" />
  <!-- meanmenu CSS -->
  <link
    rel="stylesheet"
    href="assets/css/meanmenu.min.css"
    type="text/css"
    media="all" />
  <!-- transitions CSS -->
  <link
    rel="stylesheet"
    href="assets/css/owl.transitions.css"
    type="text/css"
    media="all" />
  <!-- venobox CSS -->
  <link
    rel="stylesheet"
    href="venobox/venobox.css"
    type="text/css"
    media="all" />
  <!-- bootstrap icons -->
  <link
    rel="stylesheet"
    href="assets/css/bootstrap-icons.css"
    type="text/css"
    media="all" />
  <!-- Slick Slider -->
  <link rel="stylesheet" type="text/css" href="assets/slick/slick.css" />
  <link
    rel="stylesheet"
    type="text/css"
    href="assets/slick/slick-theme.css" />
  <!-- Main Style CSS -->
  <link
    rel="stylesheet"
    href="assets/css/style.css"
    type="text/css"
    media="all" />

  <link
    rel="stylesheet"
    href="./carusel.css"
    type="text/css"
    media="all" />
  <!-- Dropdown CSS -->
  <link
    rel="stylesheet"
    href="assets/css/dropdown.css"
    type="text/css"
    media="all" />
  <!-- responsive CSS -->
  <link
    rel="stylesheet"
    href="assets/css/responsive.css"
    type="text/css"
    media="all" />
  <!-- rangeslider CSS -->
  <link
    rel="stylesheet"
    href="assets/css/rangeslider.css"
    type="text/css"
    media="all" />
  <!-- modernizr js -->


  <link
    rel="stylesheet"
    href="./journey.css"
    type="text/css"
    media="all" />


  <link
    rel="stylesheet"
    href="./main.css"
    type="text/css"
    media="all" />

  <script src="assets/js/vendor/modernizr-3.5.0.min.js"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>

</head>

<body>
  <!-- loder -->



  <?php
  require_once 'db.php';
  require 'config.php';
  $today = date('Y-m-d');

  $current = $conn->query("SELECT * FROM events WHERE event_date = '$today'");
  $past = $conn->query("SELECT * FROM events WHERE event_date < '$today' ORDER BY event_date DESC");
  $upcoming = $conn->query("SELECT * FROM events WHERE event_date > '$today' ORDER BY event_date ASC");
  $stories = $conn->query("SELECT name, testimonial, image FROM testimonials WHERE status='approved' ORDER BY id DESC");

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

  <!--==================================================-->
  <!-- End Topbar Area -->
  <!--==================================================-->

  <!--==================================================-->
  <!-- Start Header Area -->
  <!--==================================================-->
  <?php require 'header.php'; ?>
  <!--==================================================-->
  <!-- End Header Area -->
  <!--==================================================-->

  <!--==================================================-->
  <!-- Start Banner Area -->
  <!--==================================================-->
  <div class="slider_list owl-carousel">
    <div class="slider-area d-flex align-items-center">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <div class="slider-content">
              <div class="slider-main-title">
                <h1
                  class="wow fadeInUp"
                  data-wow-delay="0.4s"
                  data-wow-duration="1s">
                  Fighting Cancer, Restoring Hope
                </h1>
              </div>
              <div class="slider-discription">
                <p
                  class="wow fadeInUp"
                  data-wow-delay="0.6s"
                  data-wow-duration="1s">
                  Asthu Foundation is dedicated to empowering women through
                  health and skill development programs, fostering
                  self-reliance and confidence.
                </p>
              </div>
              <div class="nontprts-btn slider1">
                <a
                  class="wow fadeInUp"
                  data-wow-delay="0.8s"
                  data-wow-duration="1s"
                  href="./donation.php">Donate Now<i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="nontprts-btn slider2">
                <a
                  class="wow fadeInUp"
                  data-wow-delay="0.8s"
                  data-wow-duration="1s"
                  href="./contact.php">Contact Now <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="slider-area two d-flex align-items-center">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <div class="slider-content">
              <div class="slider-main-title">
                <h1
                  class="wow fadeInUp"
                  data-wow-delay="0.4s"
                  data-wow-duration="1s">
                  Empowering Women, Transforming Lives
                </h1>
              </div>
              <div class="slider-discription">
                <p
                  class="wow fadeInUp"
                  data-wow-delay="0.6s"
                  data-wow-duration="1s">
                  Asthu Foundation is dedicated to uplifting women through skill development, health education, and self-employment programs. Our initiatives foster confidence, independence, and equal opportunities for women to lead empowered lives.
                </p>
              </div>
              <div class="nontprts-btn slider1">
                <a
                  class="wow fadeInUp"
                  data-wow-delay="0.8s"
                  data-wow-duration="1s"
                  href="./donation.php">Donate Now<i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="nontprts-btn slider2">
                <a
                  class="wow fadeInUp"
                  data-wow-delay="0.8s"
                  data-wow-duration="1s"
                  href="contact.html">Contact Now <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="slider-area three d-flex align-items-center">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <div class="slider-content">
              <div class="slider-sub-title"></div>
              <div class="slider-main-title">
                <h1
                  class="wow fadeInUp"
                  data-wow-delay="0.4s"
                  data-wow-duration="1s">
                  Lighting the Path for Every Child
                </h1>
              </div>
              <div class="slider-discription">
                <p
                  class="wow fadeInUp"
                  data-wow-delay="0.6s"
                  data-wow-duration="1s">
                  Asthu Foundation is devoted to supporting blind and visually impaired children by providing accessible education, assistive tools, and inclusive care. Our mission is to help every child thrive with dignity, confidence, and opportunity.
                </p>
              </div>
              <div class="nontprts-btn slider1">
                <a
                  class="wow fadeInUp"
                  data-wow-delay="0.8s"
                  data-wow-duration="1s"
                  href="./donation.php">Donate Now<i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="nontprts-btn slider2">
                <a
                  class="wow fadeInUp"
                  data-wow-delay="0.8s"
                  data-wow-duration="1s"
                  href="contact.html">Contact Now <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="slider-area four d-flex align-items-center">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <div class="slider-content">
              <div class="slider-sub-title"></div>
              <div class="slider-main-title">
                <h1
                  class="wow fadeInUp"
                  data-wow-delay="0.4s"
                  data-wow-duration="1s">
                  Caring for Elders, Honoring Their Journey
                </h1>
              </div>
              <div class="slider-discription">
                <p
                  class="wow fadeInUp"
                  data-wow-delay="0.6s"
                  data-wow-duration="1s">
                  Asthu Foundation is dedicated to providing compassionate elder care through health checkups, emotional support, and community engagement. We strive to ensure our seniors live with dignity, respect, and a sense of belonging.


                </p>
              </div>
              <div class="nontprts-btn slider1">
                <a
                  class="wow fadeInUp"
                  data-wow-delay="0.8s"
                  data-wow-duration="1s"
                  href="./donation.php">Donate Now<i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="nontprts-btn slider2">
                <a
                  class="wow fadeInUp"
                  data-wow-delay="0.8s"
                  data-wow-duration="1s"
                  href="contact.html">Contact Now <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="slider-area five d-flex align-items-center">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <div class="slider-content">
              <div class="slider-sub-title"></div>
              <div class="slider-main-title">
                <h1
                  class="wow fadeInUp"
                  data-wow-delay="0.4s"
                  data-wow-duration="1s">
                  Building Stronger Villages, Brick by Brick
                </h1>
              </div>
              <div class="slider-discription">
                <p
                  class="wow fadeInUp"
                  data-wow-delay="0.6s"
                  data-wow-duration="1s">
                  Asthu Foundation is committed to strengthening rural infrastructure by improving access to clean water, sanitation, roads, and community spaces. Our efforts aim to create sustainable, self-reliant villages with better living conditions and brighter futures.
                </p>
              </div>
              <div class="nontprts-btn slider1">
                <a
                  class="wow fadeInUp"
                  data-wow-delay="0.8s"
                  data-wow-duration="1s"
                  href="./donation.php">Donate Now<i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="nontprts-btn slider2">
                <a
                  class="wow fadeInUp"
                  data-wow-delay="0.8s"
                  data-wow-duration="1s"
                  href="contact.html">Contact Now <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--==================================================-->
  <!-- End Banner Area -->
  <!--==================================================-->

  <!--==================================================-->
  <!-- Start Feature Area -->
  <!--==================================================-->
  <!-- <section class="features-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7 text-center">
        <div class="section-title">
          <div class="section-sub-thumb">
            <img src="assets/images/slider/banner-icon.png" alt="" />
          </div>
          <div class="section-sub-titile">
            <h4>What We Do</h4>
          </div>
          <div class="section-main-title">
            <h2>Services We Provide For You</h2>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="feature-card">
          <div class="card-icon">
            <i class="bi bi-heart-pulse-fill"></i>
          </div>
          <h4 class="card-title">Healthy Food</h4>
          <p class="card-text">
            We provide nutritious meals to communities in need, ensuring
            everyone has access to healthy food.
          </p>
          <a href="#" class="read-more">Learn More <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="feature-card">
          <div class="card-icon">
            <i class="bi bi-book-fill"></i>
          </div>
          <h4 class="card-title">Pure Education</h4>
          <p class="card-text">
            Our programs support and provide essential learning resources to
            children for a much brighter future.
          </p>
          <a href="#" class="read-more">Learn More <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="feature-card">
          <div class="card-icon">
            <i class="bi bi-droplet-fill"></i>
          </div>
          <h4 class="card-title">Clean Water</h4>
          <p class="card-text">
            We implement projects that bring clean and safe drinking water to
            underserved and remote areas.
          </p>
          <a href="#" class="read-more">Learn More <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="feature-card">
          <div class="card-icon">
            <i class="bi bi-firstaid-fill"></i>
          </div>
          <h4 class="card-title">Medical Care</h4>
          <p class="card-text">
            Offering free medical check-ups and essential healthcare services to
            ensure community well-being.
          </p>
          <a href="#" class="read-more">Learn More <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</section> -->
  <!--==================================================-->
  <!-- End Feature Area -->
  <!--==================================================-->

  <!--==================================================-->
  <!-- Start About Area -->
  <!--==================================================-->
  <section class="editorial-canvas">

    <h1 class="hero-heading">Weaving Hope Into <span>Tomorrow.</span></h1>

    <div class="hero-image-container">
      <div class="hero-image-stack">
        <img src="./assets/images/2149243599.webp" alt="Hands holding soil with a young plant, representing growth and hope." id="img-default" class="active">
        <img src="./assets/images/2832.webp" alt="A doctor provides compassionate care to a patient." id="img-cancer">
        <img src="./assets/images/child-learning-braile (1).webp" alt="A hopeful child looking towards the future." id="img-blind">
        <img src="./assets/images/2148962325.webp" alt="Hands of an elderly person being held with care." id="img-elder">
        <img src="./assets/images/village-community (1).webp" alt="A vibrant village scene with a new community building." id="img-infra">
      </div>
    </div>

    <p class="hero-description">
      Asthu Foundation is not just an organization; it is a promise. A promise to stand with the vulnerable, to build stronger communities, and to transform lives through dedicated, compassionate action.
    </p>

    <nav class="causes-nav">
      <div class="causes-list-container">
        <a href="#" class="cause-link" data-image="img-cancer">
          <div class="cause-number">01</div>
          <div class="cause-details">
            <h3>Support For Cancer Patients</h3>
            <p>Providing critical care and restoring hope.</p>
          </div>
        </a>
        <a href="#" class="cause-link" data-image="img-blind">
          <div class="cause-number">02</div>
          <div class="cause-details">
            <h3>Vision For Blind Children</h3>
            <p>Empowering children through specialized education.</p>
          </div>
        </a>
        <a href="#" class="cause-link" data-image="img-elder">
          <div class="cause-number">03</div>
          <div class="cause-details">
            <h3>Dignified Elder Care</h3>
            <p>Honoring our seniors with compassion and support.</p>
          </div>
        </a>
        <a href="#" class="cause-link" data-image="img-infra">
          <div class="cause-number">04</div>
          <div class="cause-details">
            <h3>Rural Health Infrastructure</h3>
            <p>Building the foundations for a healthier future.</p>
          </div>
        </a>
      </div>
    </nav>

    <div class="donate-button-container">
      <a href="./donation.php" class="donate-button">Donate Now</a>
    </div>

  </section>







  <!--==================================================-->
  <!-- End About Area -->
  <!--==================================================-->

  <!-- <section class="what-we-do-section">
    <h2 class="section-title">Our Core Missions</h2>

    <div class="card-container">

      <div class="ngo-card">
        <div class="card-header"><i class="bi bi-book-half"></i></div>
        <div class="card-body">
          <h3 class="card-title">Enlighten</h3>
          <p class="card-description">Providing visually impaired children with access to specialized education and assistive technology.</p>
          <div class="card-button-wrapper"><a href="#" class="card-button">Learn More</a></div>
        </div>
      </div>

      <div class="ngo-card">
        <div class="card-header"><i class="bi bi-heart-pulse-fill"></i></div>
        <div class="card-body">
          <h3 class="card-title">Hope</h3>
          <p class="card-description">Offering comprehensive support and financial aid, ensuring no one faces the journey against cancer alone.</p>
          <div class="card-button-wrapper"><a href="#" class="card-button">Learn More</a></div>
        </div>
      </div>

      <div class="ngo-card">
        <div class="card-header"><i class="bi bi-house-heart-fill"></i></div>
        <div class="card-body">
          <h3 class="card-title">Cherish</h3>
          <p class="card-description">Ensuring our elders live their golden years with dignity through healthcare, companionship, and safe facilities.</p>
          <div class="card-button-wrapper"><a href="#" class="card-button">Learn More</a></div>
        </div>
      </div>

      <div class="ngo-card">
        <div class="card-header"><i class="bi bi-buildings-fill"></i></div>
        <div class="card-body">
          <h3 class="card-title">Build</h3>
          <p class="card-description">Developing essential rural infrastructure like clean water sources and schools to foster community growth.</p>
          <div class="card-button-wrapper"><a href="#" class="card-button">Learn More</a></div>
        </div>
      </div>

      <div class="ngo-card">
        <div class="card-header"><i class="bi bi-lightbulb-fill"></i></div>
        <div class="card-body">
          <h3 class="card-title">Empower</h3>
          <p class="card-description">Equipping women with vocational skills and financial literacy to become leaders and break cycles of poverty.</p>
          <div class="card-button-wrapper"><a href="#" class="card-button">Learn More</a></div>
        </div>
      </div>

    </div>
  </section> -->
  <!--==================================================-->
  <!-- Start Service Area -->
  <!--==================================================-->
  <div
    class="service-area wow fadeInUp"
    data-wow-delay="0.3s"
    data-wow-duration="1s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div
            class="section-title text-center wow fadeInUp"
            data-wow-delay="0.4s"
            data-wow-duration="1s">
            <div class="section-sub-thumb">
              <img src="assets/images/slider/banner-icon.png" alt="" />
            </div>
            <div class="section-sub-titile">
              <h4>Start donating them</h4>
            </div>
            <div class="section-sub-thumb">
              <img src="assets/images/slider/banner-icon.png" alt="" />
            </div>
            <div class="section-main-title">
              <h2>Find popular causes</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="row" id="servicesRow">

        <div class="col-lg-4 col-md-6">
          <div
            class="service-single-box wow fadeInUp"
            data-wow-delay="0.2s"
            data-wow-duration="1s">
            <div class="service-thumb">
              <img src="assets/images/2151064696.webp" alt="" />
            </div>
            <div class="service-content">

              <h4 class="service-title">
                <a href="#">Cancer Patient Support</a>
              </h4>
              <p class="service-discription">
                Our Cancer Patient Support program is dedicated to offering
                comprehensive assistance to those battling cancer. We aim to
                alleviate the challenges faced by patients and their families.
              </p>

              <div class="donate-btn d-flex justify-content-center m-3">
                <a href="./donation.php">Donate Now</a>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-4 col-md-6">
          <div
            class="service-single-box wow fadeInUp"
            data-wow-delay="0.4s"
            data-wow-duration="1s">
            <div class="service-thumb">
              <img src="assets/images/child-reading-in-braile.jpg" alt="" />
            </div>
            <div class="service-content">

              <h4 class="service-title">
                <a href="#">Support For Blind Children</a>
              </h4>
              <p class="service-discription">
                Empowering blind children with dedicated support,
                Fostering their unique journey to independence.
                Building skills for confident integration,
                Creating a future where every child can thrive.
              </p>

              <div class="donate-btn d-flex justify-content-center m-3">
                <a href="./donation.php">Donate Now</a>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-4 col-md-6">
          <div
            class="service-single-box wow fadeInUp"
            data-wow-delay="0.6s"
            data-wow-duration="1s">
            <div class="service-thumb">
              <img src="assets/images/elder-care-at-astu.jpg" alt="" />
            </div>
            <div class="service-content">

              <h4 class="service-title">
                <a href="#">Elder Care</a>
              </h4>
              <p class="service-discription">
                Our mission is to provide comprehensive support,
                To champion the dignity of every senior.
                Fostering a life of fulfillment and purpose,
                And honoring them with unwavering respect.
              </p>

              <div class="donate-btn d-flex justify-content-center m-3">
                <a href="./donation.php">Donate Now</a>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-4 col-md-6 extra-card mt-3">
          <div
            class="service-single-box wow fadeInUp"
            data-wow-delay="0.8s"
            data-wow-duration="1s">
            <div class="service-thumb">
              <img src="assets/images/rural-infra.jpg" alt="" />
            </div>
            <div class="service-content">

              <h4 class="service-title">
                <a href="#">Rural Healthcare Infrastructure</a>
              </h4>
              <p class="service-discription">
                Strengthening village healthcare systems through better access
                and facilities. Empowering rural communities with quality
                medical infrastructure
              </p>

              <div class="donate-btn d-flex justify-content-center m-3">
                <a href="./donation.php">Donate Now</a>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-4 col-md-6 extra-card mt-3">
          <div
            class="service-single-box wow fadeInUp"
            data-wow-delay="1s"
            data-wow-duration="1s">
            <div class="service-thumb">
              <img src="assets/images/wmen-empoerment.jpg" alt="" />
            </div>
            <div class="service-content">

              <h4 class="service-title">
                <a href="#">Women Empowerment</a>
              </h4>
              <p class="service-discription">
                Empowering women through education, opportunity, and equality.
                Building a future where every woman can lead and thrive.
              </p>

              <div class="donate-btn d-flex justify-content-center m-3">
                <a href="./donation.php">Donate Now</a>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="text-center mt-4">
        <button id="viewMoreBtn" class="view-morebtn">View More</button>
      </div>

    </div>
  </div>



  <div class="wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="1s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 mt-3">
          <div
            class="section-title text-center wow fadeInUp"
            data-wow-delay="0.4s"
            data-wow-duration="1s">
            <div class="section-sub-thumb">
              <img src="assets/images/slider/banner-icon.png" alt="" />
            </div>
            <div class="section-sub-titile">
              <h4>Question & answers</h4>
            </div>
            <div class="section-sub-thumb">
              <img src="assets/images/slider/banner-icon.png" alt="" />
            </div>
            <div class="section-main-title mt-3">
              <h2>Donors frequently asked questions?</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="tab_container">
            <div id="tab1" class="tab_content">
              <ul class="accordion">
                <li>
                  <a class="active"><span>
                      1. Is it Full Transport & Logistics Company?
                    </span>
                    <i class="bi bi-chevron-double-right"></i></a>
                  <p style="display: block">
                    The time it takes to repair a roof depends on the extent
                    of the damage. For minor repairs, it might take an hour or
                    two. For significant repairs, A or team might be at your
                    home for half a day.
                  </p>
                </li>
                <li>
                  <a><span> 2. How to Create my Project in Company? </span>
                    <i class="bi bi-chevron-double-right"></i></a>
                  <p>
                    The time it takes to repair a roof depends on the extent
                    of the damage. For minor repairs, it might take an hour or
                    two. For significant repairs, A or team might be at your
                    home for half a day.
                  </p>
                </li>
                <li>
                  <a><span>
                      3. How to Work in Process of Transport Company?
                    </span>
                    <i class="bi bi-chevron-double-right"></i></a>
                  <p>
                    The time it takes to repair a roof depends on the extent
                    of the damage. For minor repairs, it might take an hour or
                    two. For significant repairs, A or team might be at your
                    home for half a day.
                  </p>
                </li>
                <li>
                  <a><span>
                      4. What warranties do I have for installation?
                    </span>
                    <i class="bi bi-chevron-double-right"></i></a>
                  <p>
                    The time it takes to repair a roof depends on the extent
                    of the damage. For minor repairs, it might take an hour or
                    two. For significant repairs, A or team might be at your
                    home for half a day.
                  </p>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--==================================================-->
  <!-- End Service Area -->
  <!--==================================================-->

  <!--==================================================-->
  <!-- Start Events Area -->
  <!--==================================================-->
  <div
    class="events-area wow fadeInUp"
    data-wow-delay="0.3s"
    data-wow-duration="1s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div
            class="section-title wow fadeInUp"
            data-wow-delay="0.4s"
            data-wow-duration="1s">
            <div class="section-sub-thumb">
              <img src="assets/images/slider/banner-icon.png" alt="" />
            </div>
            <div class="section-sub-titile">
              <h4>Raising Your Helping Hands</h4>
            </div>
            <div class="section-main-title">
              <h2>Check Latest Upcoming Events</h2>
            </div>
          </div>
        </div>
      </div>
      <!-- Upcoming Events -->
      <section class="py-5 bg-light">
        <div class="container">


          <!-- Nav tabs -->
          <ul class="nav nav-tabs mb-4 justify-content-center" id="eventTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button
                class="nav-link active"
                id="upcoming-tab"
                data-bs-toggle="tab"
                data-bs-target="#upcoming"
                type="button"
                role="tab"
                aria-controls="upcoming"
                aria-selected="true">Upcoming</button>
            </li>
            <li class="nav-item" role="presentation">
              <button
                class="nav-link"
                id="current-tab"
                data-bs-toggle="tab"
                data-bs-target="#current"
                type="button"
                role="tab"
                aria-controls="current"
                aria-selected="false">Current</button>
            </li>
            <li class="nav-item" role="presentation">
              <button
                class="nav-link"
                id="past-tab"
                data-bs-toggle="tab"
                data-bs-target="#past"
                type="button"
                role="tab"
                aria-controls="past"
                aria-selected="false">Past</button>
            </li>
          </ul>

          <div class="tab-content" id="eventTabsContent">
            <!-- UPCOMING -->
            <div
              class="tab-pane fade show active"
              id="upcoming"
              role="tabpanel"
              aria-labelledby="upcoming-tab">
              <div class="row">
                <?php if ($upcoming->num_rows > 0): ?>
                  <?php $i = 0;
                  while ($row = $upcoming->fetch_assoc()): ?>
                    <?php $delay = 0.2 + ($i++ * 0.2); ?>
                    <div class="col-lg-6 col-md-12">
                      <div
                        class="events-single-box wow fadeInUp"
                        data-wow-delay="<?= $delay ?>s"
                        data-wow-duration="1s">
                        <div class="events-thumb">
                          <img
                            src="<?= BASE_URL . htmlspecialchars($row['image_path']) ?>"
                            alt="<?= htmlspecialchars($row['title']) ?>"
                            style="width:310px; height:250px; object-fit:cover;" />
                        </div>
                        <div class="events-content">
                          <h4 class="events-title">
                            <a href="event-details.php?id=<?= (int)$row['id'] ?>">
                              <?= htmlspecialchars($row['title']) ?>
                            </a>
                          </h4>
                          <div class="events-content-items">
                            <span>
                              <i class="bi bi-geo-alt"></i>
                              Location : <?= htmlspecialchars($row['venue']) ?>
                            </span>
                            <span>
                              <i class="bi bi-alarm"></i>
                              Office Time :
                              <?= date('D, d M Y', strtotime($row['event_date'])) ?>
                              <?= htmlspecialchars($row['event_time']) ?>
                            </span>
                          </div>
                          <div class="events-btn">
                            <a href="register-event.php?event_id=<?= (int)$row['id'] ?>">
                              register for this event
                            </a>

                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endwhile; ?>
                <?php else: ?>
                  <p class="text-muted text-center">No upcoming events.</p>
                <?php endif; ?>
              </div>

              <!-- VIEW MORE BUTTON -->
              <div class="events-btn text-center mt-4">
                <a href="events.php?tab=upcoming">View More</a>
              </div>
            </div>

            <!-- CURRENT -->
            <div
              class="tab-pane fade"
              id="current"
              role="tabpanel"
              aria-labelledby="current-tab">
              <div class="row">
                <?php if ($current->num_rows > 0): ?>
                  <?php $i = 0;
                  while ($row = $current->fetch_assoc()): ?>
                    <?php $delay = 0.2 + ($i++ * 0.2); ?>
                    <div class="col-lg-6 col-md-12">
                      <div
                        class="events-single-box wow fadeInUp"
                        data-wow-delay="<?= $delay ?>s"
                        data-wow-duration="1s">
                        <div class="events-thumb">
                          <img
                            src="<?= BASE_URL . htmlspecialchars($row['image_path']) ?>"
                            alt="<?= htmlspecialchars($row['title']) ?>"
                            style="width:310px; height:250px; object-fit:cover;" />
                        </div>
                        <div class="events-content">
                          <h4 class="events-title">
                            <a href="event-details.php?id=<?= (int)$row['id'] ?>">
                              <?= htmlspecialchars($row['title']) ?>
                            </a>
                          </h4>
                          <div class="events-content-items">
                            <span>
                              <i class="bi bi-geo-alt"></i>
                              Location : <?= htmlspecialchars($row['venue']) ?>
                            </span>
                            <span>
                              <i class="bi bi-alarm"></i>
                              Office Time :
                              <?= date('D, d M Y', strtotime($row['event_date'])) ?>
                              <?= htmlspecialchars($row['event_time']) ?>
                            </span>
                          </div>
                          <div class="events-btn">
                            <a href="event-details.php?id=<?= (int)$row['id'] ?>">
                              register for this event
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endwhile; ?>
                <?php else: ?>
                  <p class="text-muted text-center">No current events.</p>
                <?php endif; ?>
              </div>

              <!-- VIEW MORE BUTTON -->
              <div class="events-btn text-center mt-4">
                <a href="events.php?tab=current">View More</a>
              </div>
            </div>

            <!-- PAST -->
            <div
              class="tab-pane fade"
              id="past"
              role="tabpanel"
              aria-labelledby="past-tab">
              <div class="row">
                <?php if ($past->num_rows > 0): ?>
                  <?php $i = 0;
                  while ($row = $past->fetch_assoc()): ?>
                    <?php $delay = 0.2 + ($i++ * 0.2); ?>
                    <div class="col-lg-6 col-md-12">
                      <div
                        class="events-single-box wow fadeInUp"
                        data-wow-delay="<?= $delay ?>s"
                        data-wow-duration="1s">
                        <div class="events-thumb">
                          <img
                            src="<?= BASE_URL . htmlspecialchars($row['image_path']) ?>"
                            alt="<?= htmlspecialchars($row['title']) ?>"
                            style="width:310px; height:250px; object-fit:cover;" />
                        </div>
                        <div class="events-content">
                          <h4 class="events-title">
                            <a href="event-details.php?id=<?= (int)$row['id'] ?>">
                              <?= htmlspecialchars($row['title']) ?>
                            </a>
                          </h4>
                          <div class="events-content-items">
                            <span>
                              <i class="bi bi-geo-alt"></i>
                              Location : <?= htmlspecialchars($row['venue']) ?>
                            </span>
                            <span>
                              <i class="bi bi-alarm"></i>
                              Office Time :
                              <?= date('D, d M Y', strtotime($row['event_date'])) ?>
                              <?= htmlspecialchars($row['event_time']) ?>
                            </span>
                          </div>
                          <!-- <div class="events-btn">
                            <a href="event-details.php?id=<?= (int)$row['id'] ?>">
                              Details More
                            </a>
                          </div> -->
                        </div>
                      </div>
                    </div>
                  <?php endwhile; ?>
                <?php else: ?>
                  <p class="text-muted text-center">No past events.</p>
                <?php endif; ?>
              </div>

              <!-- VIEW MORE BUTTON -->
              <div class="events-btn text-center mt-4">
                <a href="events.php?tab=past">View More</a>
              </div>
            </div>
          </div>
        </div>
      </section>






      <!-- Current Events -->
      <div class="tab-pane fade" id="current" role="tabpanel">
        <div class="row">
          <?php if ($current->num_rows > 0): ?>
            <?php
            $i = 0;
            while ($row = $current->fetch_assoc()):
              $delay = 0.2 + ($i++ * 0.2);
            ?>
              <div class="col-lg-6 col-md-12">
                <div
                  class="events-single-box wow fadeInUp"
                  data-wow-delay="<?= $delay ?>s"
                  data-wow-duration="1s">
                  <div class="events-thumb">
                    <img
                      src="<?= BASE_URL . htmlspecialchars($row['image_path']) ?>"
                      alt="<?= htmlspecialchars($row['title']) ?>" />
                  </div>

                  <div class="events-content">
                    <h4 class="events-title">
                      <a href="event-details.php?id=<?= (int)$row['id'] ?>">
                        <?= htmlspecialchars($row['title']) ?>
                      </a>
                    </h4>

                    <div class="events-content-items">
                      <span>
                        <i class="bi bi-geo-alt"></i>
                        Location: <?= htmlspecialchars($row['venue']) ?>
                      </span>
                      <span>
                        <i class="bi bi-alarm"></i>
                        Office Time: <?= date('D, d M Y', strtotime($row['event_date'])) ?>
                        <?= htmlspecialchars($row['event_time']) ?>
                      </span>
                    </div>

                    <div class="events-btn">
                      <a href="event-details.php?id=<?= (int)$row['id'] ?>">
                        Details More
                      </a>
                    </div>
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
        <div class="row">
          <?php if ($past->num_rows > 0): ?>
            <?php
            $i = 0;
            while ($row = $past->fetch_assoc()):
              $delay = 0.2 + ($i++ * 0.2);
            ?>
              <div class="col-lg-6 col-md-12">
                <div
                  class="events-single-box wow fadeInUp"
                  data-wow-delay="<?= $delay ?>s"
                  data-wow-duration="1s">
                  <div class="events-thumb">
                    <img
                      src="<?= BASE_URL . htmlspecialchars($row['image_path']) ?>"
                      alt="<?= htmlspecialchars($row['title']) ?>" style="width:310px; height:300px; object-fit:cover;" />
                  </div>

                  <div class="events-content">
                    <h4 class="events-title">
                      <a href="event-details.php?id=<?= (int)$row['id'] ?>">
                        <?= htmlspecialchars($row['title']) ?>
                      </a>
                    </h4>

                    <div class="events-content-items">
                      <span>
                        <i class="bi bi-geo-alt"></i>
                        Location: <?= htmlspecialchars($row['venue']) ?>
                      </span>
                      <span>
                        <i class="bi bi-alarm"></i>
                        Office Time: <?= date('D, d M Y', strtotime($row['event_date'])) ?>
                        <?= htmlspecialchars($row['event_time']) ?>
                      </span>
                    </div>

                    <div class="events-btn">
                      <a href="event-details.php?id=<?= (int)$row['id'] ?>">
                        Details More
                      </a>
                    </div>
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
  <!--==================================================-->
  <!-- End Events Area -->
  <!--==================================================-->

  <!--==================================================-->
  <!-- Start Call Do Action Area -->
  <!--==================================================-->
  <!-- <div
      class="call-do-action-area d-flex align-items-center wow fadeInUp"
      data-wow-delay="0.3s"
      data-wow-duration="1s"
    >
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <div class="single-video text-center">
              <div class="video-icon">
                <a
                  class="video-vemo-icon venobox vbox-item"
                  data-vbtype="youtube"
                  data-autoplay="true"
                  href="https://youtu.be/BS4TUd7FJSg"
                  ><i class="bi bi-play"></i
                ></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
  <!--==================================================-->
  <!-- End Call Do Action Area -->
  <!--==================================================-->

  <!--==================================================-->
  <!-- Start Service Area -->
  <!--==================================================-->
  <div
    class="service-area style-two wow fadeInUp"
    data-wow-delay="0.3s"
    data-wow-duration="1s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div
            class="section-title text-center wow fadeInUp"
            data-wow-delay="0.4s"
            data-wow-duration="1s">
            <div class="section-sub-thumb">
              <img src="assets/images/slider/banner-icon.png" alt="" />
            </div>
            <div class="section-sub-titile">
              <h4>Raising Your Helping Hands</h4>
            </div>
            <div class="section-sub-thumb">
              <img src="assets/images/slider/banner-icon.png" alt="" />
            </div>
            <div class="section-main-title">
              <h2>Join Our Team</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6">
            <div
              class="service-items-box wow fadeInUp"
              data-wow-delay="0.2s"
              data-wow-duration="1s">
              <div class="service-icon-thumb">
                <img src="assets/images/service/service-icon1.png" alt="" />
              </div>
              <div class="service-items-content">
                <h4>
                  <a href="service-details.html">Join Us As A Volunter</a>
                </h4>
                <p>
                  Make a difference with Astu Foundation — empower lives,
                  uplift communities. Join hands with us to bring hope,
                  support, and change where it's needed most
                </p>
                <div class="service-item-btn">
                  <a href="./volunteer-form.php">Read More</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div
              class="service-items-box wow fadeInUp"
              data-wow-delay="0.4s"
              data-wow-duration="1s">
              <div class="service-icon-thumb">
                <img src="assets/images/service/service-icon2.png" alt="" />
              </div>
              <div class="service-items-content">
                <h4>
                  <a href="service-details.html">Become an associate</a>
                </h4>
                <p>
                  Partner with Astu Foundation to drive meaningful impact and
                  social change. Your support helps us reach more lives and
                  build a better tomorrow — together.
                </p>
                <div class="service-item-btn">
                  <a href="./associate_form.php">Read More</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div
              class="service-items-box wow fadeInUp"
              data-wow-delay="0.6s"
              data-wow-duration="1s">
              <div class="service-icon-thumb">
                <img src="assets/images/service/service-icon3.png" alt="" />
              </div>
              <div class="service-items-content">
                <h4>
                  <a href="service-details.html">Become A Donor </a>
                </h4>
                <p>
                  Your contribution can light up lives and create lasting
                  change. Support Astu Foundation and be the reason someone
                  believes in hope again.
                </p>
                <div class="service-item-btn">
                  <a href="./donation.php">Read More</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--==================================================-->
  <!-- End Service Area -->
  <!--==================================================-->

  <!--==================================================-->
  <!-- Start Contact Us Area -->
  <!--==================================================-->
  <!-- <div
    class="contact-us-area wow fadeInUp"
    data-wow-delay="0.3s"
    data-wow-duration="1s">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 col-md-12">
          <div class="section-title">
            <div class="section-sub-thumb">
              <img src="assets/images/slider/banner-icon.png" alt="" />
            </div>
            <div class="section-sub-titile contact">
              <h4>Raising Your Helping Hands</h4>
            </div>
            <div class="section-main-title contact">
              <h2>Join your hand with us for a better life and fut</h2>
            </div>
          </div>
          <div class="contact-discription">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
              eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis
              ipsum suspendisse ultrices gravida. Risus commodo viverra
              maecenas accu
            </p>
          </div>
          <div class="contact-social">
            <div class="contact-call">
              <div class="contact-call-icon">
                <i class="bi bi-telephone-plus"></i>
              </div>
              <div class="contact-call-title">
                <a href="#">Free contact 24/7 </a>
                <span><a href="#">936-668-36736</a></span>
              </div>
              <div class="nontprts-btn">
                <a href="service-details.html">Donatlon Now <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5 col-md-12">
          <div
            class="contact-items-box wow fadeInUp"
            data-wow-delay="0.2s"
            data-wow-duration="1s">
            <div class="contact-items-title">
              <h4>Interested Discussing</h4>
            </div>
            <form action="https://formspree.io/f/myyleorq" method="POST">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-box">
                    <input
                      type="text"
                      name="amount"
                      placeholder="Enter Donation Amount" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="form-box">
                    <input type="text" name="name" placeholder="Your Name" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="form-box">
                    <input
                      type="text"
                      name="email"
                      placeholder="Email Address" />
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-box">
                    <input
                      type="text"
                      name="phone"
                      placeholder="Phone Number" />
                  </div>
                </div>
                <div class="col-lg-12 col-md-12">
                  <div class="form-box">
                    <textarea
                      name="massage"
                      id="massage"
                      cols="30"
                      rows="10"
                      placeholder="Write Message"></textarea>
                  </div>
                </div>
                <div class="col-lg-12 col-md-12">
                  <div class="form-box-button inner2">
                    <button type="Submit">Send Message</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <!--==================================================-->
  <!-- End Contact Us Area -->
  <!--==================================================-->

  <!--==================================================-->
  <!-- Start Brand Area -->
  <!--==================================================-->
  <!-- <div
    class="brand-area wow fadeInUp"
    data-wow-delay="0.4s"
    data-wow-duration="1s">
    <div class="container-fluid">
      <div class="col-lg-7 col-md-12">
        <div class="row brand">
          <div class="col-lg-3 col-md-4">
            <div class="brand-thumb">
              <img src="assets/images/brand/brand1.png" alt="" />
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="brand-thumb">
              <img src="assets/images/brand/brand2.png" alt="" />
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="brand-thumb">
              <img src="assets/images/brand/brand3.png" alt="" />
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="brand-thumb">
              <img src="assets/images/brand/brand4.png" alt="" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <!--==================================================-->
  <!-- End Brand Area -->
  <!--==================================================-->

  <!--==================================================-->
  <!-- Start Testimonial Area -->
  <!--==================================================-->
  <div
    class="testimonial-area wow fadeInUp"
    data-wow-delay="0.3s"
    data-wow-duration="1s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div
            class="section-title text-center wow fadeInUp"
            data-wow-delay="0.4s"
            data-wow-duration="1s">
            <div class="section-sub-thumb">
              <img src="assets/images/slider/banner-icon.png" alt="" />
            </div>
            <div class="section-sub-titile">
              <h4>Raising Your Helping Hands</h4>
            </div>
            <div class="section-sub-thumb">
              <img src="assets/images/slider/banner-icon.png" alt="" />
            </div>
            <div class="section-main-title">
              <h2>We Provide Care & Love</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="testi_list owl-carousel">
          <div class="col-lg-12">
            <div
              class="testi-itmes-box wow fadeInUp"
              data-wow-delay="0.2s"
              data-wow-duration="1s">
              <div class="testi-icon">
                <i class="bi bi-quote"></i>
              </div>
              <div class="testi-content">
                <p>
                  Amazing Template is a responsive WordPress theme with a
                  modern design that is perfect for building any kind of
                  website. Charitable efforts can take many forms, including
                  monetary
                </p>
              </div>
              <div class="testi-title">
                <h4>Rosalina D. William</h4>
              </div>
              <div class="testi-thumb">
                <img src="assets/images/testimonial/testi1.png" alt="" />
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div
              class="testi-itmes-box wow fadeInUp"
              data-wow-delay="0.4s"
              data-wow-duration="1s">
              <div class="testi-icon">
                <i class="bi bi-quote"></i>
              </div>
              <div class="testi-content">
                <p>
                  Amazing Template is a responsive WordPress theme with a
                  modern design that is perfect for building any kind of
                  website. Charitable efforts can take many forms, including
                  monetary
                </p>
              </div>
              <div class="testi-title">
                <h4>Rosalina D. William</h4>
              </div>
              <div class="testi-thumb">
                <img src="assets/images/testimonial/testi2.png" alt="" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--==================================================-->
  <!-- End Testimonial Area -->
  <!--==================================================-->

  <!--==================================================-->
  <!-- Start Safe Life Area -->
  <!--==================================================-->
  <div
    class="safe-life-area wow fadeInUp"
    data-wow-delay="0.3s"
    data-wow-duration="1s">
    <div class="container">
      <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6 col-md-12">
          <div class="safe-content">
            <div class="section-title">
              <div class="section-sub-thumb">
                <img src="assets/images/resource/safe-life-icon.png" alt="" />
              </div>
              <div class="section-sub-titile safe">
                <h4>Lend a Hand, Light a Life</h4>
              </div>
              <div class="section-main-title safe">
                <h2>Empowering Lives. Creating Hope. Together with Astu</h2>
              </div>
              <div class="nontprts-btn safe">
                <a href="./donation.php">Donate Now <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--==================================================-->
  <!-- End Safe Life Area -->
  <!--==================================================-->
  <section id="stats" class="stats-section py-5">
    <div class="container">
      <div class="row">
        <!-- Stat 1 -->
        <div class="col-md-3 col-6 mb-4">
          <div class="stat-box text-center">
            <h2 class="stat-number">
              <span class="counter" data-target="<?= $stats['villages_served'] ?>">0</span>+
            </h2>
            <p class="stat-label">Villages Served</p>
          </div>
        </div>

        <!-- Stat 2 -->
        <div class="col-md-3 col-6 mb-4">
          <div class="stat-box text-center">
            <h2 class="stat-number">
              <span class="counter" data-target="<?= $stats['blind_children_supported'] ?>">0</span>+
            </h2>
            <p class="stat-label">Blind Children Supported</p>
          </div>
        </div>

        <!-- Stat 3 -->
        <div class="col-md-3 col-6 mb-4">
          <div class="stat-box text-center">
            <h2 class="stat-number">
              <span class="counter" data-target="<?= $stats['patients_treated'] ?>">0</span>
            </h2>
            <p class="stat-label">Patients Treated</p>
          </div>
        </div>

        <!-- Stat 4 -->
        <div class="col-md-3 col-6 mb-4">
          <div class="stat-box text-center">
            <h2 class="stat-number">
              <span class="counter" data-target="<?= $stats['women_empowered'] ?>">0</span>
            </h2>
            <p class="stat-label">Women Empowered</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--==================================================-->
  <!-- Start Blog Area -->
  <!--==================================================-->
  <div
    class="blog-area wow fadeInUp"
    data-wow-delay="0.3s"
    data-wow-duration="1s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div
            class="section-title text-center wow fadeInUp"
            data-wow-delay="0.4s"
            data-wow-duration="1s">
            <div class="section-sub-thumb">
              <img src="assets/images/slider/banner-icon.png" alt="" />
            </div>
            <div class="section-sub-thumb">
              <img src="assets/images/slider/banner-icon.png" alt="" />
            </div>
            <div class="section-sub-titile">
              <h4>Raising Your Helping Hands</h4>
            </div>
            <div class="section-main-title">
              <h2>Read Our Latest Articles</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div
            class="blog-items-box wow fadeInUp"
            data-wow-delay="0.2s"
            data-wow-duration="1s">
            <div class="blog-thumb">
              <img src="assets/images/blog/blog1.png" alt="" />
            </div>
            <div class="blog-content">
              <div class="blog-meta">
                <span><i class="bi bi-person-fill"></i> By Admin</span>
                <span><i class="bi bi-wechat"></i> {6}Comments</span>
              </div>
              <div class="blog-title">
                <h4>
                  <a href="blog-details.html">Retail banks wakeup to digital</a>
                </h4>
              </div>
              <div class="blog-button">
                <a href="#">Learn More <i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="blog-button two">
                <a href="#">Share Post <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div
            class="blog-items-box inner2 wow fadeInUp"
            data-wow-delay="0.4s"
            data-wow-duration="1s">
            <div class="blog-thumb">
              <img src="assets/images/blog/blog2.png" alt="" />
            </div>
            <div class="blog-content">
              <div class="blog-meta">
                <span><i class="bi bi-person-fill"></i> By Admin</span>
                <span><i class="bi bi-wechat"></i> {6}Comments</span>
              </div>
              <div class="blog-title">
                <h4>
                  <a href="blog-details.html">Retail banks wakeup to digital</a>
                </h4>
              </div>
              <div class="blog-button">
                <a href="#">Learn More <i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="blog-button two">
                <a href="#">Share Post <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div
            class="blog-items-box inner wow fadeInUp"
            data-wow-delay="0.4s"
            data-wow-duration="1s">
            <div class="blog-thumb">
              <img src="assets/images/blog/blog3.png" alt="" />
            </div>
            <div class="blog-content">
              <div class="blog-meta">
                <span><i class="bi bi-person-fill"></i> By Admin</span>
                <span><i class="bi bi-wechat"></i> {6}Comments</span>
              </div>
              <div class="blog-title">
                <h4>
                  <a href="blog-details.html">Retail banks wakeup to digital</a>
                </h4>
              </div>
              <div class="blog-button">
                <a href="#">Learn More <i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="blog-button two">
                <a href="#">Share Post <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--==================================================-->
  <!-- End Blog Area -->
  <!--==================================================-->

  <!--==================================================-->
  <!-- Start Sidebar Area -->
  <!--==================================================-->


  <!-- <section class="success-stories-section">

    <h2 class="section-title">Success Stories</h2>

    <div class="swiper">
      <div class="swiper-wrapper">

        <div class="swiper-slide">
          <div class="story-card-content">
            <div class="story-text">
              <h3>Ravi Devangan</h3>
              <p>Ravi's life was transformed through our prosthetic support program, allowing him to regain mobility and confidence.</p>
              <a href="#" class="story-button">Read More</a>
            </div>
            <div class="story-image" style="background-image: url('https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=1974&auto=format&fit=crop');"></div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="story-card-content">
            <div class="story-text">
              <h3>Ankit Gupta</h3>
              <p>With access to quality healthcare provided by our rural initiatives, Ankit's family now lives a healthier, happier life.</p>
              <a href="#" class="story-button">Read More</a>
            </div>
            <div class="story-image" style="background-image: url('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=1974&auto=format&fit=crop');"></div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="story-card-content">
            <div class="story-text">
              <h3>Maria Silva</h3>
              <p>Maria's journey began with uncertainty, but through vocational training, she now runs her own successful local business.</p>
              <a href="#" class="story-button">Read More</a>
            </div>
            <div class="story-image" style="background-image: url('https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=2070&auto=format&fit=crop');"></div>
          </div>
        </div>

      </div>
    </div>
  </section> -->



  <section class="success-stories-section">
    <h2 class="section-title">Success Stories</h2>

    <div class="swiper">
      <div class="swiper-wrapper">

        <?php while ($row = $stories->fetch_assoc()) { ?>
          <div class="swiper-slide">
            <div class="story-card-content">
              <div class="story-text">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p><?= nl2br(htmlspecialchars($row['testimonial'])) ?></p>
               
              </div>
              <div class="story-image" 
                   style="background-image: url('uploads/testimonials/<?= htmlspecialchars($row['image']) ?>');">
              </div>
            </div>
          </div>
        <?php } ?>

      </div>
    </div>
</section>

  <!--==================================================-->
  <!-- End Sidebar Area -->
  <!--==================================================-->

  <!--==================================================-->
  <!-- Start Footer Area -->
  <!--==================================================-->
  <?php require "footer.php"  ?>
  <!--==================================================-->
  <!-- End Footer Area -->
  <!--==================================================-->

  <!--==================================================-->
  <!-- Start Search Popup Area -->
  <!--==================================================-->
  <div class="search-popup">
    <button class="close-search style-two">
      <span class="flaticon-multiply"><i class="far fa-times-circle"></i></span>
    </button>
    <button class="close-search"><i class="fas fa-arrow-up"></i></button>
    <form method="post" action="#">
      <div class="form-group">
        <input
          type="search"
          name="search-field"
          value=""
          placeholder="Search Here"
          required="" />
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
    <svg
      class="progress-circle svg-content"
      width="100%"
      height="100%"
      viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
  </div>

  <!--==================================================-->
  <!-- End scrollup section Area -->
  <!--==================================================-->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <script>
    var swiper = new Swiper(".swiper", {
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: "auto",
      loop: true,
      coverflowEffect: {
        rotate: 0, // Set rotate to 0 for a flat, non-3D look
        stretch: 80,
        depth: 200,
        modifier: 1,
        slideShadows: true,
      },
      // Optional: Add navigation buttons if you want them
      // navigation: {
      //   nextEl: '.swiper-button-next',
      //   prevEl: '.swiper-button-prev',
      // },
    });
  </script>
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

  <script>
    document
      .getElementById("viewMoreBtn")
      .addEventListener("click", function() {
        document.querySelectorAll(".extra-card").forEach(function(card) {
          card.style.display = "block";
        });
        this.style.display = "none";
      });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const counters = document.querySelectorAll(".counter");
      const speed = 100;

      counters.forEach((counter) => {
        const updateCount = () => {
          const target = +counter.getAttribute("data-target");
          const count = +counter.innerText;
          // calculate increment
          const increment = Math.ceil(target / speed);

          if (count < target) {
            counter.innerText = count + increment;
            setTimeout(updateCount, 20);
          } else {
            counter.innerText = target;
          }
        };

        updateCount();
      });
    });
  </script>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const causeLinks = document.querySelectorAll('.cause-link');
      const imageStack = document.querySelector('.hero-image-stack');
      const defaultImage = document.getElementById('img-default');

      causeLinks.forEach(link => {
        const targetImageId = link.dataset.image;
        const targetImage = document.getElementById(targetImageId);

        if (targetImage) {
          link.addEventListener('mouseenter', () => {
            imageStack.querySelectorAll('img').forEach(img => img.classList.remove('active'));
            targetImage.classList.add('active');
          });

          link.addEventListener('mouseleave', () => {
            imageStack.querySelectorAll('img').forEach(img => img.classList.remove('active'));
            defaultImage.classList.add('active');
          });
        }
      });
    });
  </script>
</body>

</html>