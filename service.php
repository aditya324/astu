<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Nonprts-Nonprofit Charity HTML5 Template </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="56x56" href="assets/images/fav-icon/icon.png"> <!-- bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" media="all"> <!-- carousel CSS -->
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css" type="text/css" media="all"> <!-- animate CSS -->
    <link rel="stylesheet" href="assets/css/animate.css" type="text/css" media="all"> <!-- font-awesome CSS -->
    <link rel="stylesheet" href="assets/css/all.min.css" type="text/css" media="all"> <!-- font-flaticon CSS -->
    <link rel="stylesheet" href="assets/css/flaticon.css" type="text/css" media="all"> <!-- theme-default CSS -->
    <link rel="stylesheet" href="assets/css/theme-default.css" type="text/css" media="all"> <!-- meanmenu CSS -->
    <link rel="stylesheet" href="assets/css/meanmenu.min.css" type="text/css" media="all"> <!-- transitions CSS -->
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css" media="all"> <!-- venobox CSS -->
    <link rel="stylesheet" href="venobox/venobox.css" type="text/css" media="all"> <!-- bootstrap icons -->
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css" type="text/css" media="all"> <!-- Slick Slider -->
    <link rel="stylesheet" type="text/css" href="assets/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="assets/slick/slick-theme.css"> <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all"> <!-- Dropdown CSS -->
    <link rel="stylesheet" href="assets/css/dropdown.css" type="text/css" media="all"> <!-- responsive CSS -->
    <link rel="stylesheet" href="assets/css/responsive.css" type="text/css" media="all"> <!-- rangeslider CSS -->
    <link rel="stylesheet" href="assets/css/rangeslider.css" type="text/css" media="all"> <!-- modernizr js -->
    <script src="assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    
    <style>
        /* Add this to your assets/css/style.css file */
        .service-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .cta-area {
            background-color: #007bff;
            /* Example primary color */
            color: #fff;
        }

        .cta-area .btn-light {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #DF5311;
        }
    </style>
</head>

<body>
  <?php require "header.php" ?>

  <!-- Breadcrumb -->
  <div class="breatcome-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="breatcome-content">
            <div class="breatcome-title">
              <h1>Service</h1>
            </div>
            <div class="bratcome-text">
              <ul>
                <li><a href="/">Home </a></li>
                <li>Service</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Intro (keep as-is) -->
  <div class="service-intro-area text-center bg-light py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="section-title">
            <span class="short-title">OUR COMMITMENT</span>
            <h2 class="title">Our Commitment to India</h2>
            <p class="description">
              At Asthu Foundation, we don't just heal individuals—we heal communities, regions, and ultimately, our nation. Every
              life we save, every sight we restore, every woman we empower, every elder we care for, and every rural community we
              transform contributes to building a stronger, healthier, more equitable India.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ====== REPLACEMENT STARTS HERE (swap for your five feature sections) ====== -->

  <!-- Brand helpers -->
  <style>
    :root { --brand:#DF5311; }
    .text-brand { color: var(--brand)!important; }
    .bg-brand { background: var(--brand)!important; }
    .btn-brand { background: var(--brand); border-color: var(--brand); color:#fff; }
    .btn-brand:hover { opacity:.9; color:#fff; }
    .pillars-badge {
      display:inline-block; padding:.35rem .6rem; border-radius:50px;
      font-size:.75rem; letter-spacing:.02em; background:#fff; color:#333;
      box-shadow:0 1px 2px rgba(0,0,0,.06)
    }
    .stat {
      background:#fff; border-radius:12px; box-shadow:0 6px 24px rgba(0,0,0,.06);
      padding:1.25rem;
    }
    .stat .num { font-weight:800; font-size:1.75rem; }
    .feature-card {
      background:#fff; border:1px solid #f1f1f1; border-radius:14px;
      padding:1.25rem; height:100%; transition:all .25s ease;
    }
    .feature-card:hover { transform:translateY(-4px); box-shadow:0 10px 26px rgba(0,0,0,.07); }
    .feature-card .bi { font-size:1.5rem; }
    .section-sub { text-transform:uppercase; letter-spacing:.12em; font-size:.8rem; color:#6c757d; }
  </style>

  <!-- Pillars overview -->
  <section id="pillars" class="py-5 bg-light">
    <div class="container">
      <div class="row justify-content-center text-center mb-4">
        <div class="col-lg-8">
          <span class="section-sub d-block mb-2">Our Strategic Focus</span>
          <h2 class="mb-3">Asthu’s 5 Impact Pillars</h2>
          <p class="text-muted mb-0">From access to outcomes—rural healthcare, cancer care, pediatric vision, dignified aging, and women’s empowerment.</p>
        </div>
      </div>

      <div class="row g-3 g-md-4">
        <div class="col-6 col-lg">
          <div class="feature-card text-center">
            <div class="mb-2 text-brand"><i class="bi bi-hospital"></i></div>
            <h6 class="mb-1">Rural Health Infra</h6>
            <p class="small text-muted mb-2">PHC/CHC upgrades in tiers</p>
            <a class="pillars-badge" href="./Rural-Health-Infra.php">Explore</a>
          </div>
        </div>
        <div class="col-6 col-lg">
          <div class="feature-card text-center">
            <div class="mb-2 text-brand"><i class="bi bi-clipboard2-pulse"></i></div>
            <h6 class="mb-1">Precision Cancer Care</h6>
            <p class="small text-muted mb-2">Screening → Treatment → Rehab</p>
            <a class="pillars-badge" href="./Cancer-care.php">Explore</a>
          </div>
        </div>
        <div class="col-6 col-lg">
          <div class="feature-card text-center">
            <div class="mb-2 text-brand"><i class="bi bi-eyeglasses"></i></div>
            <h6 class="mb-1">Pediatric Vision</h6>
            <p class="small text-muted mb-2">Sight-restoring surgeries & EdTech</p>
            <a class="pillars-badge" href="./Blind-Care.php">Explore</a>
          </div>
        </div>
        <div class="col-6 col-lg">
          <div class="feature-card text-center">
            <div class="mb-2 text-brand"><i class="bi bi-person-heart"></i></div>
            <h6 class="mb-1">Geriatric Care</h6>
            <p class="small text-muted mb-2">Preventive & tech-enabled aging</p>
            <a class="pillars-badge" href="./Elder-care.php">Explore</a>
          </div>
        </div>
        <div class="col-12 col-lg">
          <div class="feature-card text-center">
            <div class="mb-2 text-brand"><i class="bi bi-gender-female"></i></div>
            <h6 class="mb-1">Women’s Empowerment</h6>
            <p class="small text-muted mb-2">Health, safety & livelihoods</p>
            <a class="pillars-badge" href="./Women-empowerment.php">Explore</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Impact counters -->
  <section id="impact-stats" class="py-5">
    <div class="container">
      <div class="row justify-content-center text-center mb-4">
        <div class="col-lg-8">
          <span class="section-sub d-block mb-2">Measured Outcomes</span>
          <h2 class="mb-3">Impact We’re Building</h2>
        </div>
      </div>
      <div class="row g-3 g-md-4">
        <div class="col-6 col-lg-3">
          <div class="stat text-center">
            <div class="num text-brand">5,50,000+</div>
            <div class="small text-muted">Lives Served (Target)</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat text-center">
            <div class="num text-brand">200+</div>
            <div class="small text-muted">Facilities Transformed</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat text-center">
            <div class="num text-brand">25,000+</div>
            <div class="small text-muted">Cancer Patients Supported</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat text-center">
            <div class="num text-brand">12,500+</div>
            <div class="small text-muted">Children Reached (Vision)</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Highlight rows -->
  <section id="pillar-highlights" class="py-5 bg-light">
    <div class="container">
      <!-- Rural Infra -->
      <div class="row align-items-center g-4 mb-5">
        <div class="col-lg-6">
          <img class="img-fluid rounded shadow-sm" src="./assets/images/rural-infra.jpg" alt="Rural healthcare infrastructure upgrade">
        </div>
        <div class="col-lg-6">
          <span class="section-sub">Pillar 1</span>
          <h3 class="mt-1">Rural Healthcare Infrastructure Revolution</h3>
          <ul class="text-muted mb-3">
            <li>Tiered model: Basic → PHC → CHC (IPHS-compliant)</li>
            <li>Emergency kits, diagnostics, telemedicine & renewable power</li>
            <li>Target: 90% reduction in travel burden in 5 years</li>
          </ul>
          <a href="./Rural-Health-Infra.php" class="btn btn-brand">See the Model</a>
        </div>
      </div>
      <!-- Cancer Care -->
      <div class="row align-items-center g-4 mb-5">
        <div class="col-lg-6 order-lg-2">
          <img class="img-fluid rounded shadow-sm" src="./assets/images/cancer-care.jpg" alt="Cancer care support">
        </div>
        <div class="col-lg-6 order-lg-1">
          <span class="section-sub">Pillar 2</span>
          <h3 class="mt-1">Precision Cancer Care Ecosystem</h3>
          <ul class="text-muted mb-3">
            <li>AI-enabled screening, hospital tie-ups, drug access</li>
            <li>Holistic rehab: psycho-oncology, nutrition, livelihoods</li>
            <li>Goal: 18,000+ treatments; ₹200 Cr costs covered</li>
          </ul>
          <a href="./Cancer-care.php" class="btn btn-brand">Explore Cancer Care</a>
        </div>
      </div>
      <!-- Pediatric Vision -->
      <div class="row align-items-center g-4 mb-5">
        <div class="col-lg-6">
          <img class="img-fluid rounded shadow-sm" src="./assets/images/child-learning-braile (1).webp" alt="Pediatric vision & learning tech">
        </div>
        <div class="col-lg-6">
          <span class="section-sub">Pillar 3</span>
          <h3 class="mt-1">Pediatric Vision Restoration & Empowerment</h3>
          <ul class="text-muted mb-3">
            <li>Sight-restoring surgeries & advanced assistive tech</li>
            <li>Braille innovation, mobility & independence training</li>
            <li>95% school integration target</li>
          </ul>
          <a href="./Blind-Care.php" class="btn btn-brand">Support Vision</a>
        </div>
      </div>
      <!-- Geriatric Care -->
      <div class="row align-items-center g-4 mb-5">
        <div class="col-lg-6 order-lg-2">
          <img class="img-fluid rounded shadow-sm" src="./assets/images/elder-care.jpg" alt="Geriatric care & aging innovation">
        </div>
        <div class="col-lg-6 order-lg-1">
          <span class="section-sub">Pillar 4</span>
          <h3 class="mt-1">Geriatric Care Excellence & Aging Innovation</h3>
          <ul class="text-muted mb-3">
            <li>Preventive clinics, telemedicine & smart home safety</li>
            <li>Memory care, rehab & mental health support</li>
            <li>Goal: 50% fewer hospitalizations</li>
          </ul>
          <a href="./Elder-care.php" class="btn btn-brand">Dignify Aging</a>
        </div>
      </div>
      <!-- Women Empowerment -->
      <div class="row align-items-center g-4">
        <div class="col-lg-6">
          <img class="img-fluid rounded shadow-sm" src="./assets/images/women-empowerment.jpg" alt="Women's health & livelihoods">
        </div>
        <div class="col-lg-6">
          <span class="section-sub">Pillar 5</span>
          <h3 class="mt-1">Women’s Health & Economic Empowerment</h3>
          <ul class="text-muted mb-3">
            <li>Health, rights, safety + micro-enterprise ecosystems</li>
            <li>Digital literacy, e-commerce, and financial inclusion</li>
            <li>80% household income lift target</li>
          </ul>
          <a href="./Women-empowerment.php" class="btn btn-brand">Empower Women</a>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-5 bg-brand text-white">
    <div class="container">
      <div class="row align-items-center g-3">
        <div class="col-lg-8">
          <h3 class="mb-1">Help turn blueprints into better lives.</h3>
          <p class="mb-0">Donate, volunteer, or partner with us to accelerate impact across all five pillars.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="./donation.php" class="btn btn-light me-2">Donate</a>
          <a href="./contact.php" class="btn btn-outline-light">Partner</a>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQs -->
<!-- ===== UNIVERSAL FAQ (works with BS4 or BS5) ===== -->
<section id="faqs" class="py-5">
  <div class="container">
    <div class="row justify-content-center text-center mb-4">
      <div class="col-lg-8">
        <span class="d-block text-uppercase small text-muted mb-2">Questions</span>
        <h2 class="mb-3">Frequently Asked</h2>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="accordion" id="faqAccordion">
          <!-- Item 1 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="q1">
              <button class="accordion-button"
                      type="button"
                      data-bs-toggle="collapse" data-toggle="collapse"
                      data-bs-target="#a1" data-target="#a1"
                      aria-expanded="true" aria-controls="a1">
                How are donations allocated across pillars?
              </button>
            </h2>
            <div id="a1" class="accordion-collapse collapse show" aria-labelledby="q1" data-bs-parent="#faqAccordion" data-parent="#faqAccordion">
              <div class="accordion-body">
                We maintain ring-fenced budgets per pillar with audited reporting. You can earmark a donation to a specific pillar on the donation page.
              </div>
            </div>
          </div>

          <!-- Item 2 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="q2">
              <button class="accordion-button collapsed"
                      type="button"
                      data-bs-toggle="collapse" data-toggle="collapse"
                      data-bs-target="#a2" data-target="#a2"
                      aria-expanded="false" aria-controls="a2">
                Do you meet IPHS/NQAS standards for facilities?
              </button>
            </h2>
            <div id="a2" class="accordion-collapse collapse" aria-labelledby="q2" data-bs-parent="#faqAccordion" data-parent="#faqAccordion">
              <div class="accordion-body">
                Yes—our Rural Health Infra roadmap maps directly to IPHS tiers, and our quality systems aim for NQAS readiness during each upgrade cycle.
              </div>
            </div>
          </div>

          <!-- Item 3 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="q3">
              <button class="accordion-button collapsed"
                      type="button"
                      data-bs-toggle="collapse" data-toggle="collapse"
                      data-bs-target="#a3" data-target="#a3"
                      aria-expanded="false" aria-controls="a3">
                Can corporate partners support specific equipment or districts?
              </button>
            </h2>
            <div id="a3" class="accordion-collapse collapse" aria-labelledby="q3" data-bs-parent="#faqAccordion" data-parent="#faqAccordion">
              <div class="accordion-body">
                Absolutely. We offer CAPEX/CSR packages—e.g., neonatal warmers for Tier-1 centers, AI screening vans for Cancer Care, or smart-home kits for Geriatric Care.
              </div>
            </div>
          </div>

          <!-- Item 4 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="q4">
              <button class="accordion-button collapsed"
                      type="button"
                      data-bs-toggle="collapse" data-toggle="collapse"
                      data-bs-target="#a4" data-target="#a4"
                      aria-expanded="false" aria-controls="a4">
                Do you provide 80G tax receipts?
              </button>
            </h2>
            <div id="a4" class="accordion-collapse collapse" aria-labelledby="q4" data-bs-parent="#faqAccordion" data-parent="#faqAccordion">
              <div class="accordion-body">
                Yes—instant 80G receipts are issued after successful payment and emailed automatically. You can also claim them from your account later.
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Auto-loader: pick BS4 or BS5 JS depending on what's present -->
  <script>
    (function () {
      // Already have BS5 JS? (window.bootstrap exists with Collapse)
      var hasBS5 = !!(window.bootstrap && window.bootstrap.Collapse);
      // Already have BS4 JS? (jQuery + $.fn.collapse)
      var hasjQ = !!window.jQuery;
      var hasBS4 = hasjQ && !!(jQuery.fn && jQuery.fn.collapse);

      if (hasBS5 || hasBS4) return; // JS already good; nothing to load.

      // If jQuery is present but no collapse, we assume BS4 CSS -> load BS4 JS
      if (hasjQ) {
        var pop = document.createElement('script');
        pop.src = "https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js";
        var bs4 = document.createElement('script');
        bs4.src = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js";
        document.body.appendChild(pop);
        pop.onload = function(){ document.body.appendChild(bs4); };
        return;
      }

      // Otherwise load BS5 bundle (includes Popper)
      var s = document.createElement('script');
      s.src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js";
      s.crossOrigin = "anonymous";
      document.body.appendChild(s);
    })();
  </script>

  <!-- Fallback manual toggle if no Bootstrap JS could run -->
  <script>
    document.addEventListener('click', function(e){
      var btn = e.target.closest('[data-bs-toggle="collapse"],[data-toggle="collapse"]');
      if (!btn) return;

      // If Bootstrap is present, let it handle
      if ((window.bootstrap && window.bootstrap.Collapse) || (window.jQuery && jQuery.fn && jQuery.fn.collapse)) return;

      var sel = btn.getAttribute('data-bs-target') || btn.getAttribute('data-target');
      var pane = sel ? document.querySelector(sel) : null;
      if (!pane) return;

      pane.classList.toggle('show');       // show/hide
      btn.classList.toggle('collapsed');   // button state
      e.preventDefault();
    });
  </script>
</section>



  <!-- ====== REPLACEMENT ENDS HERE ====== -->

  <?php require "footer.php" ?>
</body>
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

</html>