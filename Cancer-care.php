<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Precision Cancer Care Ecosystem | Asthu Foundation</title>

  <!-- SEO -->
  <meta name="description" content="Asthu Foundation’s Pillar 2: a precision cancer care ecosystem spanning prevention, AI screening, treatment access, rehabilitation, and innovation." />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="canonical" href="https://example.com/precision-cancer-care.php" />

  <!-- Open Graph -->
  <meta property="og:title" content="Precision Cancer Care Ecosystem | Asthu Foundation" />
  <meta property="og:description" content="Redefining cancer care through technology and compassion — AI-powered screening, treatment access, survivorship care, and innovation." />
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
    .toc a { display: block; padding: 10px 12px; border-radius: 8px; color: var(--ink-2); text-decoration: none; }
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
    .metric { display: flex; gap: 12px; align-items: start; }
    .metric i { font-size: 1.25rem; color: var(--brand); }

    /* BANNERS / STRIPS */
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
    .badge-soft {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 999px;
      padding: .25rem .6rem;
      font-size: .8rem;
      color: var(--ink-2);
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
    "name": "Precision Cancer Care Ecosystem",
    "description": "Asthu Foundation’s Pillar 2: Prevention, AI screening, treatment access, rehabilitation, and innovation in oncology.",
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
          <li class="breadcrumb-item"><a href="/initiatives.php" class="text-decoration-none">Initiatives</a></li>
          <li class="breadcrumb-item active" aria-current="page">Precision Cancer Care Ecosystem</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- HERO -->
  <header class="hero">
    <div class="container">
      <div class="row g-4 align-items-center">
        <div class="col-lg-9">
          <div class="kicker mb-2">Pillar 2 • Asthu Foundation</div>
          <h1 class="display-6 fw-semibold mb-2">Precision Cancer Care Ecosystem</h1>
          <p class="lead mb-3">Redefining cancer care through technology and compassion — from prevention and AI-led screening to equitable treatment access, survivorship, and innovation.</p>
          <div class="d-flex gap-2 flex-wrap">
            <span class="badge-soft">AI Screening</span>
            <span class="badge-soft">Treatment Access</span>
            <span class="badge-soft">Rehabilitation</span>
            <span class="badge-soft">Innovation Lab</span>
          </div>
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
              <a href="#crisis">The Cancer Crisis in Numbers</a>
              <a href="#prevention">Prevention & Early Detection</a>
              <a href="#treatment">Treatment Excellence & Financial Shield</a>
              <a href="#recovery">Recovery & Rehabilitation</a>
              <a href="#innovation">Innovation Laboratory</a>
              <a href="#impact">Transformative Outcomes</a>
              <a href="#engage">Partner With Asthu</a>
            </nav>
          </div>
        </aside>

        <!-- CONTENT -->
        <div class="col-lg-9">

          <!-- CRISIS -->
          <section id="crisis" tabindex="-1" aria-labelledby="crisis-h">
            <h2 id="crisis-h" class="h4 fw-bold mb-3">The Cancer Crisis in Numbers</h2>
            <div class="row g-3">
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-bar-chart-line-fill"></i>
                    <div>
                      <div class="fw-semibold">1.4 million</div>
                      <div class="small muted">New cases annually in India</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-search-heart-fill"></i>
                    <div>
                      <div class="fw-semibold">70%</div>
                      <div class="small muted">Diagnosed at advanced stages</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-clock-history"></i>
                    <div>
                      <div class="fw-semibold">~6 months</div>
                      <div class="small muted">Rural diagnostic delays</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-currency-rupee"></i>
                    <div>
                      <div class="fw-semibold">₹5–20 lakhs</div>
                      <div class="small muted">Average treatment cost / patient</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <p class="small muted mt-3 mb-0">We close gaps in detection, affordability, and continuity of care across the oncology journey.</p>
            <div class="divider"></div>
          </section>

          <!-- PREVENTION & EARLY DETECTION -->
          <section id="prevention" tabindex="-1" aria-labelledby="prevention-h">
            <h2 id="prevention-h" class="h4 fw-bold mb-3">Prevention &amp; Early Detection Matrix</h2>

            <article class="tier mb-3">
              <h3 class="h6 fw-semibold mb-2">AI-Powered Screening Network</h3>
              <div class="row g-3">
                <div class="col-md-7">
                  <ul class="small mb-3">
                    <li><strong>Mobile Diagnostic Labs:</strong> 50+ vehicles with mammography, cervical screening, and biomarker testing.</li>
                    <li><strong>Machine Learning Diagnostics:</strong> ~95% early-stage accuracy via image analysis pipelines.</li>
                    <li><strong>Genetic Risk Assessment:</strong> BRCA testing & hereditary counseling.</li>
                    <li><strong>Community Health Workers:</strong> 2,000+ trained screeners using smartphone diagnostic tools.</li>
                  </ul>
                  <div class="callout small">Goal: Downstage detection by shifting from late to early presentation, especially in rural belts.</div>
                </div>
                <div class="col-md-5">
                  <table class="table table-sm align-middle mb-2">
                    <tbody>
                      <tr><th scope="row" class="fw-normal">Coverage</th><td>10M+ screening opportunities / 5 yrs</td></tr>
                      <tr><th scope="row" class="fw-normal">Turnaround</th><td>&lt;48 hrs triage, e-referrals</td></tr>
                    </tbody>
                  </table>
                  <a href="#engage" class="btn btn-primary btn-sm w-100">Deploy a Mobile Lab</a>
                </div>
              </div>
            </article>
          </section>

          <!-- TREATMENT & FINANCIAL SHIELD -->
          <section id="treatment" tabindex="-1" aria-labelledby="treatment-h">
            <h2 id="treatment-h" class="h4 fw-bold mb-3">Treatment Excellence Program &amp; Financial Shield</h2>

            <article class="tier mb-3">
              <div class="row g-3">
                <div class="col-md-7">
                  <ul class="small mb-3">
                    <li><strong>Direct Hospital Partnerships:</strong> Access at 200+ oncology centers via Asthu coordination.</li>
                    <li><strong>Medicine Access Program:</strong> Free targeted therapy drugs worth ₹50+ crores annually.</li>
                    <li><strong>Surgery Support:</strong> Complete funding for complex oncological procedures.</li>
                    <li><strong>Radiation Therapy Access:</strong> Slot assurance within 48 hours of prescription.</li>
                  </ul>
                  <div class="callout small">Aim: No eligible patient is denied optimal therapy due to cost or logistics.</div>
                </div>
                <div class="col-md-5">
                  <table class="table table-sm align-middle mb-2">
                    <tbody>
                      <tr><th scope="row" class="fw-normal">Financial Shield</th><td>Catastrophic expense mitigation</td></tr>
                      <tr><th scope="row" class="fw-normal">Utilization</th><td>25,000+ patients in 5 yrs</td></tr>
                    </tbody>
                  </table>
                  <a href="#engage" class="btn btn-primary btn-sm w-100">Activate Patient Support</a>
                </div>
              </div>
            </article>
          </section>

          <!-- RECOVERY & REHAB -->
          <section id="recovery" tabindex="-1" aria-labelledby="recovery-h">
            <h2 id="recovery-h" class="h4 fw-bold mb-3">Recovery &amp; Rehabilitation Ecosystem</h2>

            <div class="row g-3">
              <div class="col-lg-6">
                <div class="cardx h-100">
                  <div class="fw-semibold mb-2">Holistic Healing Approach</div>
                  <ul class="small mb-0">
                    <li><strong>Survivorship Clinics:</strong> Long-term follow-up & late-effects management.</li>
                    <li><strong>Psychological Oncology:</strong> Trauma-informed therapy for patients & families.</li>
                    <li><strong>Nutritional Rehabilitation:</strong> Specialized programs during & post-treatment.</li>
                    <li><strong>Vocational Reintegration:</strong> Skills training and employment support.</li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="cardx h-100">
                  <div class="fw-semibold mb-2">Continuity & Navigation</div>
                  <ul class="small mb-0">
                    <li>Care navigators for appointments, transport, housing.</li>
                    <li>Tele-oncology follow-ups and adverse-event triage.</li>
                    <li>Rehab partnerships (lymphedema, physio, speech/OT).</li>
                    <li>Peer support & caregiver education circles.</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="divider"></div>
          </section>

          <!-- INNOVATION LAB -->
          <section id="innovation" tabindex="-1" aria-labelledby="innovation-h">
            <h2 id="innovation-h" class="h4 fw-bold mb-3">Innovation Laboratory</h2>

            <article class="tier mb-3">
              <div class="row g-3">
                <div class="col-md-7">
                  <ul class="small mb-3">
                    <li><strong>Liquid Biopsy Programs:</strong> Non-invasive monitoring via blood tests.</li>
                    <li><strong>Precision Medicine:</strong> Genomic profiling for personalized regimens.</li>
                    <li><strong>Immunotherapy Access:</strong> Clinical trial participation & advanced options.</li>
                  </ul>
                  <div class="callout small">Pipeline: Translate cutting-edge science into equitable access for Indian contexts.</div>
                </div>
                <div class="col-md-5">
                  <table class="table table-sm align-middle mb-2">
                    <tbody>
                      <tr><th scope="row" class="fw-normal">Trials Network</th><td>National partners + IRB oversight</td></tr>
                      <tr><th scope="row" class="fw-normal">Data Stack</th><td>Federated registries & outcomes dashboards</td></tr>
                    </tbody>
                  </table>
                  <a href="#engage" class="btn btn-primary btn-sm w-100">Collaborate on Research</a>
                </div>
              </div>
            </article>
          </section>

          <!-- IMPACT -->
          <section id="impact" class="mt-4" tabindex="-1" aria-labelledby="impact-h">
            <h2 id="impact-h" class="h4 fw-bold mb-3">Transformative Outcomes (5-Year Horizon)</h2>
            <div class="row g-3">
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-people-fill"></i>
                    <div>
                      <div class="fw-semibold">25,000+</div>
                      <div class="small muted">Patients supported</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-clipboard2-check-fill"></i>
                    <div>
                      <div class="fw-semibold">18,000+</div>
                      <div class="small muted">Treatments completed</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-heart-pulse-fill"></i>
                    <div>
                      <div class="fw-semibold">85%</div>
                      <div class="small muted">Five-year survival (target)</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-cash-coin"></i>
                    <div>
                      <div class="fw-semibold">₹200 crores</div>
                      <div class="small muted">Treatment costs covered</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row g-3 mt-2">
              <div class="col-lg-6">
                <div class="cardx">
                  <div class="fw-semibold mb-2">Why this ecosystem works</div>
                  <ul class="small mb-0">
                    <li>Early detection shifts outcomes dramatically.</li>
                    <li>Financial Shield eliminates catastrophic spend.</li>
                    <li>Integrated rehab sustains quality of life.</li>
                    <li>Innovation translates into accessible care.</li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="cardx">
                  <div class="fw-semibold mb-2">Governance & Transparency</div>
                  <ul class="small mb-0">
                    <li>Clinical pathways and commissioning checklists.</li>
                    <li>Drug provenance, warranties, and audit trails.</li>
                    <li>Outcome dashboards, data privacy, and consent.</li>
                    <li>Preventive maintenance & AMC for equipment uptime.</li>
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
                  <p class="small muted mb-0">Co-create screening networks, therapy access, rehab hubs, and research pilots with us.</p>
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
</html>
