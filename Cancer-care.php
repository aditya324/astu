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
  <section id="precision-cancer" tabindex="-1" aria-labelledby="precision-h" class="mt-4">
  <h2 id="precision-h" class="h4 fw-bold mb-3">Pillar 2: Precision Cancer Care Ecosystem</h2>
  <p class="muted mb-3">
    Redefining cancer care through technology and compassion — prevention & early detection, treatment excellence,
    recovery & rehabilitation, and research-driven innovation.
  </p>

  <!-- Crisis metrics -->
  <div class="row g-3 mb-3">
    <div class="col-md-6 col-xl-3">
      <div class="cardx h-100">
        <div class="metric">
          <i class="bi bi-bar-chart-line"></i>
          <div>
            <div class="fw-semibold">1.4 million</div>
            <div class="small muted">New cases annually in India</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-3">
      <div class="cardx h-100">
        <div class="metric">
          <i class="bi bi-activity"></i>
          <div>
            <div class="fw-semibold">70%</div>
            <div class="small muted">Diagnosed at advanced stages</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-3">
      <div class="cardx h-100">
        <div class="metric">
          <i class="bi bi-hourglass-split"></i>
          <div>
            <div class="fw-semibold">~6 months</div>
            <div class="small muted">Rural diagnostic delay</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-3">
      <div class="cardx h-100">
        <div class="metric">
          <i class="bi bi-currency-rupee"></i>
          <div>
            <div class="fw-semibold">₹5–20 lakhs</div>
            <div class="small muted">Avg. treatment cost / patient</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Prevention & Early Detection -->
  <article class="tier mb-3" aria-labelledby="p2-prevent-h">
    <h3 id="p2-prevent-h" class="h5 fw-semibold mb-1">Prevention & Early Detection Matrix</h3>
    <div class="muted mb-2">AI-Powered Screening Network</div>
    <div class="row g-3">
      <div class="col-md-7">
        <ul class="small mb-3">
          <li><strong>Mobile Diagnostic Labs:</strong> 50+ vehicles with mammography, cervical screening, biomarker testing</li>
          <li><strong>Machine Learning Diagnostics:</strong> ~95% accuracy in early-stage detection via image analysis</li>
          <li><strong>Genetic Risk Assessment:</strong> BRCA testing & hereditary counseling</li>
          <li><strong>Community Health Workforce:</strong> 2,000+ trained screeners using smartphone-based tools</li>
        </ul>
        <div class="callout small">Outcome focus: earlier detection, faster referral, lower stage at diagnosis.</div>
      </div>
      <div class="col-md-5">
        <table class="table table-sm align-middle mb-2">
          <tbody>
            <tr><th scope="row" class="fw-normal">Coverage</th><td>Urban & rural clusters; high-risk cohorts</td></tr>
            <tr><th scope="row" class="fw-normal">Quality</th><td>Standardized protocols, QC audits, data privacy</td></tr>
            <tr><th scope="row" class="fw-normal">Throughput</th><td>Target 5,00,000+ screenings / year</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </article>

  <!-- Treatment Excellence -->
  <article class="tier mb-3" aria-labelledby="p2-treat-h">
    <h3 id="p2-treat-h" class="h5 fw-semibold mb-1">Treatment Excellence Program</h3>
    <div class="muted mb-2">Financial Shield Initiative</div>
    <div class="row g-3">
      <div class="col-md-7">
        <ul class="small mb-3">
          <li><strong>Direct Hospital Partnerships:</strong> Access via 200+ oncology centers</li>
          <li><strong>Medicine Access Program:</strong> Free targeted therapies worth ₹50+ crores annually</li>
          <li><strong>Surgery Support:</strong> Full funding for complex oncological procedures</li>
          <li><strong>Radiation Therapy Access:</strong> Treatment within 48 hours of prescription (SLA)</li>
        </ul>
        <div class="callout small">Outcome focus: reduced abandonment, faster time-to-therapy, improved survival.</div>
      </div>
      <div class="col-md-5">
        <table class="table table-sm align-middle mb-2">
          <tbody>
            <tr><th scope="row" class="fw-normal">Network</th><td>Tier-1/2 cities + regional hubs</td></tr>
            <tr><th scope="row" class="fw-normal">Eligibility</th><td>Socio-economic triage + clinical priority</td></tr>
            <tr><th scope="row" class="fw-normal">SLAs</th><td>48h radiation; 72h drug approval; 7d surgery scheduling</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </article>

  <!-- Recovery & Rehabilitation -->
  <article class="tier mb-3" aria-labelledby="p2-rehab-h">
    <h3 id="p2-rehab-h" class="h5 fw-semibold mb-1">Recovery & Rehabilitation Ecosystem</h3>
    <div class="muted mb-2">Holistic Healing Approach</div>
    <div class="row g-3">
      <div class="col-md-7">
        <ul class="small mb-3">
          <li><strong>Survivorship Clinics:</strong> Long-term follow-up & late-effects management</li>
          <li><strong>Psychological Oncology:</strong> Trauma-informed therapy for patients & families</li>
          <li><strong>Nutritional Rehabilitation:</strong> Specialized diet during & post-treatment</li>
          <li><strong>Vocational Reintegration:</strong> Skills training & employment support</li>
        </ul>
        <div class="callout small">Outcome focus: adherence, functional recovery, return to livelihood.</div>
      </div>
      <div class="col-md-5">
        <table class="table table-sm align-middle mb-2">
          <tbody>
            <tr><th scope="row" class="fw-normal">Follow-up</th><td>Structured schedules with digital reminders</td></tr>
            <tr><th scope="row" class="fw-normal">Psycho-oncology</th><td>CBT, family therapy, support groups</td></tr>
            <tr><th scope="row" class="fw-normal">Reintegration</th><td>Placement partners; micro-entrepreneurship</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </article>

  <!-- Innovation Lab -->
  <article class="tier mb-3" aria-labelledby="p2-innov-h">
    <h3 id="p2-innov-h" class="h5 fw-semibold mb-1">Innovation Laboratory</h3>
    <div class="muted mb-2">Translational & Precision Medicine</div>
    <div class="row g-3">
      <div class="col-md-7">
        <ul class="small mb-3">
          <li><strong>Liquid Biopsy Programs:</strong> Non-invasive monitoring via blood tests</li>
          <li><strong>Precision Medicine:</strong> Genomic profiling for personalized treatment</li>
          <li><strong>Immunotherapy Access:</strong> Clinical trials & advanced therapies</li>
        </ul>
        <div class="callout small">Outcome focus: earlier relapse detection, therapy optimization, access to innovation.</div>
      </div>
      <div class="col-md-5">
        <table class="table table-sm align-middle mb-2">
          <tbody>
            <tr><th scope="row" class="fw-normal">Data</th><td>Consent-driven, anonymized registries</td></tr>
            <tr><th scope="row" class="fw-normal">Compliance</th><td>Ethics review, trial governance, safety boards</td></tr>
            <tr><th scope="row" class="fw-normal">Partners</th><td>Academic labs, CROs, device & pharma</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </article>

  <!-- Outcomes -->
  <div class="cardx mb-3">
    <h3 class="h6 fw-semibold mb-2">Transformative Outcomes (5-Year Plan)</h3>
    <div class="row g-3">
      <div class="col-6 col-md-3">
        <div class="metric">
          <i class="bi bi-people"></i>
          <div>
            <div class="fw-semibold">25,000+</div>
            <div class="small muted">Patients supported</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="metric">
          <i class="bi bi-hospital"></i>
          <div>
            <div class="fw-semibold">18,000+</div>
            <div class="small muted">Treatments completed</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="metric">
          <i class="bi bi-heart-pulse"></i>
          <div>
            <div class="fw-semibold">85%</div>
            <div class="small muted">Five-year survival (target)</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="metric">
          <i class="bi bi-currency-rupee"></i>
          <div>
            <div class="fw-semibold">₹200 crores</div>
            <div class="small muted">Treatment costs covered</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- CTA -->
  <div class="cardx">
    <div class="row g-3 align-items-center">
      <div class="col-lg-8">
        <h3 class="h6 fw-bold mb-1">Partner with Asthu Foundation</h3>
        <p class="small muted mb-0">Help expand screening fleets, fund therapies, and open survivorship clinics across India.</p>
      </div>
      <div class="col-lg-4 text-lg-end">
        <a href="/contact.php" class="btn btn-primary">Start a Conversation</a>
      </div>
    </div>
  </div>
</section>

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
</html>
a