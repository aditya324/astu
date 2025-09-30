<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Rural Healthcare Infrastructure | Asthu Foundation</title>

  <!-- SEO -->
  <meta name="description" content="Asthu Foundation’s PHC Transformation Model: a standards-aligned, tiered upgrade path from basic health posts to CHCs to reduce preventable deaths and travel burden in rural India." />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="canonical" href="https://example.com/rural-health-infra.php" />

  <!-- Open Graph -->
  <meta property="og:title" content="Rural Healthcare Infrastructure | Asthu Foundation" />
  <meta property="og:description" content="Tiered PHC Transformation Model aligned to IPHS/NQAS/NABL/AERB/BIS standards." />
  <meta property="og:type" content="website" />

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="56x56" href="assets/images/fav-icon/icon.png" />

  <!-- Your stack CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/bootstrap-icons.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/responsive.css" />
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

  <style>
    :root {
      --brand: #df5311;
      --ink: #0f172a;
      --ink-2: #334155;
      --muted: #64748b;
      --line: #e5e7eb;
      --soft: #f8fafc;
    }

    body { color: var(--ink); }

    /* HERO */
    .hero {
      background:
        radial-gradient(800px 400px at 5% -10%, rgba(223, 83, 17, .08), transparent 50%),
        linear-gradient(180deg, #0c1320 0%, #131b2a 100%);
      color: #fff;
      padding: 72px 0 56px;
    }
    .hero .kicker { letter-spacing: .08em; text-transform: uppercase; font-size: .9rem; opacity: .85; }

    /* BREADCRUMB */
    .breadcrumb-wrap {
      background: #fff;
      border-bottom: 1px solid var(--line);
    }
    .breadcrumb { margin: 0; padding: .75rem 0; }

    /* LAYOUT */
    .section { padding: 56px 0; }
    .toc-sticky { position: sticky; top: 96px; }
    .toc {
      border: 1px solid var(--line);
      border-radius: 12px;
      background: #fff;
      padding: 12px;
    }
    .toc a {
      display: block; padding: 10px 12px; border-radius: 8px; color: var(--ink-2); text-decoration: none;
    }
    .toc a:hover, .toc a.active { background: #eef2ff; color: #27318b; }

    /* CARDS */
    .cardx {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 14px;
      box-shadow: 0 6px 20px rgba(2, 6, 23, .04);
      padding: 20px;
      height: 100%;
    }
    .metric {
      display: flex; gap: 12px; align-items: start;
    }
    .metric i { font-size: 1.25rem; color: var(--brand); }

    /* TIERS */
    .tier {
      border-left: 5px solid var(--brand);
      border-radius: 12px;
      padding: 22px;
      border: 1px solid var(--line);
      background: #fff;
    }
    .muted { color: var(--muted); }
    .table-sm td, .table-sm th { padding: .5rem .6rem; }
    .callout {
      background: var(--soft);
      border: 1px dashed var(--line);
      border-radius: 10px;
      padding: 12px 14px;
    }

    /* BUTTONS */
    .btn-primary { background: var(--brand); border-color: var(--brand); }
    .btn-primary:hover { background: #c24a10; border-color: #c24a10; }
    .btn-quiet { background: #fff; border: 1px solid var(--line); }

    /* UTIL */
    .divider { height: 1px; background: var(--line); margin: 28px 0; }

    /* PRINT */
    @media print {
      .hero, .breadcrumb-wrap, #tocCol, #backToTop { display: none !important; }
      .section { padding: 0; }
      a[href]:after { content: ""; }
      .btn { display: none; }
    }
  </style>

  <!-- Schema (minimal) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Rural Healthcare Infrastructure",
    "description": "Asthu Foundation’s tiered PHC Transformation Model.",
    "isPartOf": { "@type": "WebSite", "name": "Asthu Foundation" }
  }
  </script>
</head>

<body>
  <?php require "header.php"; ?>

  <!-- Breadcrumb -->
  <div class="breadcrumb-wrap">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
          <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Home</a></li>
          <li class="breadcrumb-item"><a href="./service.php" class="text-decoration-none">Services</a></li>
          <li class="breadcrumb-item active" aria-current="page">Rural Healthcare Infrastructure</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- HERO -->
  <header class="hero">
    <div class="container">
      <div class="row g-4 align-items-center">
        <div class="col-lg-9">
          <div class="kicker mb-2">Asthu Foundation</div>
          <h1 class="display-6 fw-semibold mb-2">Rural Healthcare Infrastructure</h1>
          <p class="lead mb-4">From healthcare deserts to medical oases — a standards-aligned, tiered model to deliver emergency readiness, maternal safety, diagnostics, and secondary care within reach.</p>
          
        </div>
      </div>
    </div>
  </header>

  <!-- BODY -->
  <main class="section">
    <div class="container">
      <div class="row g-5">
        <!-- TOC -->
        <aside id="tocCol" class="col-lg-3 d-none d-lg-block">
          <div class="toc-sticky">
            <nav class="toc" aria-label="On this page">
              <div class="fw-semibold small px-1 pb-1">On this page</div>
              <a href="#problem">Stark Reality</a>
              <a href="#model">PHC Transformation Model</a>
              <a href="#impact">Cumulative Impact</a>
              <a href="#engage">Partner With Asthu</a>
            </nav>
          </div>
        </aside>

        <!-- CONTENT -->
        <div class="col-lg-9">

          <!-- PROBLEM -->
          <section id="problem" tabindex="-1" aria-labelledby="problem-h">
            <h2 id="problem-h" class="h4 fw-bold mb-3">The Stark Reality</h2>
            <div class="row g-3">
              <div class="col-md-4">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-geo-alt-fill"></i>
                    <div>
                      <div class="fw-semibold">18,000+ villages</div>
                      <div class="small muted">No healthcare facility within 5 km</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-heart-pulse-fill"></i>
                    <div>
                      <div class="fw-semibold">70% of rural deaths</div>
                      <div class="small muted">Attributed to preventable causes</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-sign-turn-right"></i>
                    <div>
                      <div class="fw-semibold">22 km average</div>
                      <div class="small muted">Distance to nearest hospital</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <p class="small muted mt-3 mb-0">Distance and delay turn treatable conditions into tragedies. Our model addresses readiness, reach, and reliability.</p>
            <div class="divider"></div>
          </section>

          <!-- MODEL -->
          <section id="model" tabindex="-1" aria-labelledby="model-h">
            <h2 id="model-h" class="h4 fw-bold mb-4">Asthu PHC Transformation Model</h2>

            <!-- Tier 1 -->
            <article class="mb-4">
              <div class="tier">
                <h3 class="h5 fw-semibold mb-1">Tier 1: Basic Foundation Health Centers</h3>
                <div class="muted mb-3">Serving 3,000–20,000 population • Converting basic health posts into life-saving stations</div>
                <div class="row g-3">
                  <div class="col-md-7">
                    <ul class="mb-3 small">
                      <li><strong>Emergency Response:</strong> Resuscitation kit, AEDs</li>
                      <li><strong>Basic Equipment:</strong> Hospital bed & furniture, vital monitors, ECG, surgical essentials</li>
                      <li><strong>Maternal Safety:</strong> Delivery table (hydraulic), neonatal warmer, emergency C-section kit</li>
                      <li><strong>Diagnostics:</strong> POCT devices, digital microscopy, rapid pathogen detection</li>
                      <li><strong>Cold Chain:</strong> WHO-prequalified vaccine storage with IoT monitoring</li>
                      <li><strong>Power:</strong> Hybrid renewables with 72-hour backup</li>
                    </ul>
                    <div class="callout small">Outcome focus: immediate stabilization capacity, safe deliveries, essential diagnostics.</div>
                  </div>
                  <div class="col-md-5">
                    <table class="table table-sm align-middle mb-2">
                      <tbody>
                        <tr><th scope="row" class="fw-normal">Investment</th><td>₹8.5–12 Lakhs</td></tr>
                        <tr><th scope="row" class="fw-normal">ROI (Impact)</th><td>Up to 300% reduction in maternal mortality</td></tr>
                      </tbody>
                    </table>
                    <a href="./donation.php" class="btn btn-primary btn-sm w-100">Donate Now</a>
                  </div>
                </div>
              </div>
            </article>

            <!-- Tier 2 -->
            <article class="mb-4">
              <div class="tier">
                <h3 class="h5 fw-semibold mb-1">Tier 2: Standard PHCs</h3>
                <div class="muted mb-3">Population 20,000–30,000 • Enhanced Primary Healthcare (IPHS)</div>
                <div class="row g-3">
                  <div class="col-md-7">
                    <ul class="mb-3 small">
                      <li><strong>Equipment:</strong> Beds & bedside furniture, vital monitors, surgical essentials</li>
                      <li><strong>Lab:</strong> Semi-auto biochemistry, 3-part hematology, digital microscopy (NABL-guided)</li>
                      <li><strong>Diagnostics:</strong> 12-lead ISI ECG, digital Hb, automated urine analyzer</li>
                      <li><strong>Emergency:</strong> AED/defibrillator + multi-parameter monitor; 10L BIS oxygen concentrator</li>
                      <li><strong>Maternal:</strong> Fetal doppler, manual vacuum extractor, LED phototherapy</li>
                      <li><strong>Infrastructure:</strong> Telemedicine to higher centers; Ambulance Type B (AIS-125); IPD (6 beds)</li>
                      <li><strong>Utilities:</strong> 5KW solar (grid-tie), biogas STP, BMW Rules 2016 compliant</li>
                    </ul>
                    <div class="callout small">Outcome focus: reduced avoidable referrals; continuity of care at the primary level.</div>
                  </div>
                  <div class="col-md-5">
                    <table class="table table-sm align-middle mb-2">
                      <tbody>
                        <tr><th scope="row" class="fw-normal">Investment</th><td>₹25–40 Lakhs</td></tr>
                        <tr><th scope="row" class="fw-normal">Compliance</th><td>IPHS & NQAS</td></tr>
                      </tbody>
                    </table>
                    <a href="./donation.php" class="btn btn-primary btn-sm w-100">Donate Now</a>
                  </div>
                </div>
              </div>
            </article>

            <!-- Tier 3 -->
            <article class="mb-4">
              <div class="tier">
                <h3 class="h5 fw-semibold mb-1">Tier 3: Community Health Centers (CHC)</h3>
                <div class="muted mb-3">Population 80,000–1,20,000 • Secondary Healthcare (IPHS-CHC)</div>
                <div class="row g-3">
                  <div class="col-md-7">
                    <ul class="mb-3 small">
                      <li><strong>Critical Care:</strong> ICU (4 beds) with ventilators (BIS/CE), central monitoring, infusion pumps (ISI)</li>
                      <li><strong>Radiology:</strong> Digital X-ray 300mA (AERB), ultrasound, mobile C-arm, DICOM-compliant PACS</li>
                      <li><strong>Lab (NABL-ready):</strong> Biochemistry, hematology, automated urine analyzer, blood bank refrigerator, incubator</li>
                      <li><strong>Operation Theater:</strong> ISI hydraulic OT table, ISI/CE anesthesia, LED OT lights, ESU (ISI), 60L autoclave</li>
                      <li><strong>Specialties:</strong> Obstetrics (labor + CTG), Pediatrics (incubator, phototherapy), Medicine (ECG, portable echo), Surgery (cautery sets)</li>
                      <li><strong>Blood Bank:</strong> NACO standards, component separator, platelet agitator, plasma freezer (−30°C)</li>
                      <li><strong>Infra & Support:</strong> 25KW MNRE solar, PSA oxygen plant, Ambulance Type C (AIS-125), mortuary freezer, staff quarters (6), IPD (30 beds)</li>
                    </ul>
                    <div class="callout small">Outcome focus: fully embedded secondary care, fewer risky long-distance transfers.</div>
                  </div>
                  <div class="col-md-5">
                    <table class="table table-sm align-middle mb-2">
                      <tbody>
                        <tr><th scope="row" class="fw-normal">Investment</th><td>₹1.5–2.5 Crores</td></tr>
                        <tr><th scope="row" class="fw-normal">Performance Targets</th><td>150–200 OPD/day; 60–80 deliveries/month; 100–150 tests/day</td></tr>
                      </tbody>
                    </table>
                    <a href="./donation.php" class="btn btn-primary btn-sm w-100">Donate Now</a>
                  </div>
                </div>
              </div>
            </article>
          </section>

          <!-- IMPACT -->
          <section id="impact" class="mt-4" tabindex="-1" aria-labelledby="impact-h">
            <h2 id="impact-h" class="h4 fw-bold mb-3">Cumulative Impact (5-Year Plan)</h2>
            <div class="row g-3">
              <div class="col-md-4">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-people"></i>
                    <div>
                      <div class="fw-semibold">5,50,000+ lives</div>
                      <div class="small muted">Directly served</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-hospital"></i>
                    <div>
                      <div class="fw-semibold">200+ facilities</div>
                      <div class="small muted">Transformed across target geographies</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-geo-alt"></i>
                    <div>
                      <div class="fw-semibold">90% reduction</div>
                      <div class="small muted">Healthcare travel burden</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row g-3 mt-2">
              <div class="col-lg-6">
                <div class="cardx">
                  <div class="fw-semibold mb-2">Why this model works</div>
                  <ul class="small mb-0">
                    <li>Standards-aligned design (IPHS/NQAS/NABL/AERB/BIS)</li>
                    <li>Tiered scaling that matches population and budgets</li>
                    <li>Resilient power and cold-chain integrity built-in</li>
                    <li>Telemedicine + ambulance readiness reduce avoidable referrals</li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="cardx">
                  <div class="fw-semibold mb-2">Governance & Transparency</div>
                  <ul class="small mb-0">
                    <li>Outcome dashboards and commissioning checklists</li>
                    <li>Procurement mapped to compliance and warranties</li>
                    <li>Preventive maintenance and AMC coverage options</li>
                    <li>Audit-ready documentation and asset registry</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="divider"></div>
          </section>

          <!-- CTA -->
          <section id="engage" tabindex="-1" aria-labelledby="engage-h">
            <div class="cardx">
              <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                  <h2 id="engage-h" class="h5 fw-bold mb-1">Partner with Asthu Foundation</h2>
                  <p class="small muted mb-0">We co-create funding plans, procurement, training, and commissioning — end-to-end delivery.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                  <a href="/contact.php" class="btn btn-primary">Start a Conversation</a>
                </div>
              </div>
            </div>
          </section>

        </div>
      </div>
    </div>
  </main>

  <?php require "footer.php"; ?>

  <!-- Page scripts: smooth scroll, active TOC -->
  <script>
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(a => {
      a.addEventListener('click', e => {
        const id = a.getAttribute('href').slice(1);
        const el = document.getElementById(id);
        if (!el) return;
        e.preventDefault();
        window.scrollTo({ top: el.offsetTop - 80, behavior: 'smooth' });
      });
    });

    // Active TOC
    const links = Array.from(document.querySelectorAll('.toc a'));
    const sections = links.map(l => document.querySelector(l.getAttribute('href')));
    const obs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        const idx = sections.indexOf(entry.target);
        if (idx >= 0) {
          const link = links[idx];
          if (entry.isIntersecting) {
            links.forEach(x => x.classList.remove('active'));
            link.classList.add('active');
          }
        }
      });
    }, { rootMargin: '-40% 0px -55% 0px', threshold: 0.01 });

    sections.forEach(s => s && obs.observe(s));
  </script>
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
