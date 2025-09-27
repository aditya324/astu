<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Pediatric Vision Restoration & Empowerment | Asthu Foundation</title>

  <!-- SEO -->
  <meta name="description" content="Pillar 3: Pediatric Vision Restoration & Empowerment — surgical excellence, education tech, independence training, and Vision AI to transform children’s futures." />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="canonical" href="https://example.com/pediatric-vision.php" />

  <!-- Open Graph -->
  <meta property="og:title" content="Pediatric Vision Restoration & Empowerment | Asthu Foundation" />
  <meta property="og:description" content="Illuminating futures through surgical excellence and technology—cataract, glaucoma, retina, cornea, reconstructive care + AI learning tools." />
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
    .breadcrumb-wrap { background: #fff; border-bottom: 1px solid var(--line); }
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

    /* HIGHLIGHTED SECTIONS */
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
    "name": "Pediatric Vision Restoration & Empowerment",
    "description": "Asthu Foundation’s Pillar 3: Surgical excellence, education technology, independence training, and Vision AI for children.",
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
          <li class="breadcrumb-item active" aria-current="page">Pediatric Vision Restoration &amp; Empowerment</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- HERO -->
  <header class="hero">
    <div class="container">
      <div class="row g-4 align-items-center">
        <div class="col-lg-9">
          <div class="kicker mb-2">Pillar 3 • Asthu Foundation</div>
          <h1 class="display-6 fw-semibold mb-2">Pediatric Vision Restoration &amp; Empowerment</h1>
          <p class="lead mb-3">Illuminating futures through surgical excellence and technology—restoring sight, enabling learning, and building independent lives.</p>
          <div class="d-flex gap-2 flex-wrap">
            <span class="badge-soft">Surgical Excellence</span>
            <span class="badge-soft">Edu Tech</span>
            <span class="badge-soft">Life Skills</span>
            <span class="badge-soft">Vision AI</span>
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
              <a href="#crisis">The Vision Crisis</a>
              <a href="#surgery">Surgical Excellence Centers</a>
              <a href="#edtech">Educational Technology Integration</a>
              <a href="#independence">Independence & Life Skills Academy</a>
              <a href="#innovation">Innovation Showcase: Vision AI</a>
              <a href="#impact">Life-Changing Results</a>
              <a href="#engage">Partner With Asthu</a>
            </nav>
          </div>
        </aside>

        <!-- CONTENT -->
        <div class="col-lg-9">

          <!-- CRISIS -->
          <section id="crisis" tabindex="-1" aria-labelledby="crisis-h">
            <h2 id="crisis-h" class="h4 fw-bold mb-3">The Vision Crisis</h2>
            <div class="row g-3">
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-eye-fill"></i>
                    <div>
                      <div class="fw-semibold">1.6 million</div>
                      <div class="small muted">Children visually impaired (India)</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-shield-check"></i>
                    <div>
                      <div class="fw-semibold">80%</div>
                      <div class="small muted">Childhood blindness preventable</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-mortarboard-fill"></i>
                    <div>
                      <div class="fw-semibold">Only 30%</div>
                      <div class="small muted">Blind children attend school</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-currency-rupee"></i>
                    <div>
                      <div class="fw-semibold">₹25,000 cr</div>
                      <div class="small muted">Annual productivity loss</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <p class="small muted mt-3 mb-0">Our ecosystem tackles preventable causes, expands access to schooling, and restores functional independence.</p>
            <div class="divider"></div>
          </section>

          <!-- SURGICAL EXCELLENCE -->
          <section id="surgery" tabindex="-1" aria-labelledby="surgery-h">
            <h2 id="surgery-h" class="h4 fw-bold mb-3">Surgical Excellence Centers</h2>

            <article class="tier mb-3">
              <h3 class="h6 fw-semibold mb-2">State-of-the-Art Interventions</h3>
              <div class="row g-3">
                <div class="col-md-7">
                  <ul class="small mb-3">
                    <li><strong>Pediatric Cataract Program:</strong> Microsurgical techniques with premium IOL implantation.</li>
                    <li><strong>Glaucoma Management:</strong> Advanced drainage procedures with continuous monitoring.</li>
                    <li><strong>Retinal Disorders:</strong> Vitreoretinal surgery and anti-VEGF therapy.</li>
                    <li><strong>Corneal Transplantation:</strong> Eye banking network with tissue matching programs.</li>
                    <li><strong>Complex Reconstructive Surgery:</strong> Orbital and oculoplastic procedures.</li>
                  </ul>
                  <div class="callout small">Goal: Restore vision early, prevent amblyopia, and reduce lifelong disability.</div>
                </div>
                <div class="col-md-5">
                  <table class="table table-sm align-middle mb-2">
                    <tbody>
                      <tr><th scope="row" class="fw-normal">Network</th><td>Centers of Excellence + partner hospitals</td></tr>
                      <tr><th scope="row" class="fw-normal">Quality</th><td>Pediatric anesthesia, infection control, outcomes registry</td></tr>
                    </tbody>
                  </table>
                  <a href="#engage" class="btn btn-primary btn-sm w-100">Refer a Child for Surgery</a>
                </div>
              </div>
            </article>
          </section>

          <!-- EDUCATIONAL TECHNOLOGY -->
          <section id="edtech" tabindex="-1" aria-labelledby="edtech-h">
            <h2 id="edtech-h" class="h4 fw-bold mb-3">Educational Technology Integration</h2>
            <article class="tier mb-3">
              <h3 class="h6 fw-semibold mb-2">21st Century Learning Tools</h3>
              <div class="row g-3">
                <div class="col-md-7">
                  <ul class="small mb-3">
                    <li><strong>Braille Innovation:</strong> 3D-printed tactile learning materials & smart Braille displays.</li>
                    <li><strong>Audio-Visual Systems:</strong> Immersive classrooms with spatial audio.</li>
                    <li><strong>AI-Powered Assistance:</strong> Real-time object recognition & environment description.</li>
                    <li><strong>Adaptive Technology:</strong> Customized devices matched to learning styles.</li>
                  </ul>
                  <div class="callout small">Outcome: Higher school retention and grade-level progression post-restoration.</div>
                </div>
                <div class="col-md-5">
                  <table class="table table-sm align-middle mb-2">
                    <tbody>
                      <tr><th scope="row" class="fw-normal">School Integration</th><td>IEP support + teacher training</td></tr>
                      <tr><th scope="row" class="fw-normal">Access</th><td>Device lending library & maintenance</td></tr>
                    </tbody>
                  </table>
                  <a href="#engage" class="btn btn-primary btn-sm w-100">Deploy Classroom Kits</a>
                </div>
              </div>
            </article>
          </section>

          <!-- INDEPENDENCE & LIFE SKILLS -->
          <section id="independence" tabindex="-1" aria-labelledby="independence-h">
            <h2 id="independence-h" class="h4 fw-bold mb-3">Independence &amp; Life Skills Academy</h2>
            <div class="row g-3">
              <div class="col-lg-6">
                <div class="cardx h-100">
                  <div class="fw-semibold mb-2">Comprehensive Empowerment Program</div>
                  <ul class="small mb-0">
                    <li><strong>Orientation &amp; Mobility:</strong> GPS-enabled training and smart cane technology.</li>
                    <li><strong>Daily Living Skills:</strong> Adaptive techniques for self-care & household tasks.</li>
                    <li><strong>Vocational Excellence:</strong> Programming, music production, entrepreneurship.</li>
                    <li><strong>Sports &amp; Recreation:</strong> Paralympic training and adaptive sports facilities.</li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="cardx h-100">
                  <div class="fw-semibold mb-2">Continuity & Social Inclusion</div>
                  <ul class="small mb-0">
                    <li>Peer mentors, caregiver education, and psychosocial support.</li>
                    <li>Internships, apprenticeships, and micro-enterprise incubation.</li>
                    <li>Transport & hostel support for out-station trainees.</li>
                    <li>Certification + placement navigation.</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="divider"></div>
          </section>

          <!-- INNOVATION SHOWCASE -->
          <section id="innovation" tabindex="-1" aria-labelledby="innovation-h">
            <h2 id="innovation-h" class="h4 fw-bold mb-3">Innovation Showcase: Vision AI Project</h2>
            <article class="tier mb-3">
              <div class="row g-3">
                <div class="col-md-7">
                  <ul class="small mb-3">
                    <li><strong>Smart Glasses:</strong> Real-time scene description and obstacle detection.</li>
                    <li><strong>Mobile Apps:</strong> Navigation assistance and text-to-speech conversion.</li>
                    <li><strong>Social Integration Platforms:</strong> Video communication with audio descriptions.</li>
                    <li><strong>Employment Portals:</strong> Job matching & workplace accommodation services.</li>
                  </ul>
                  <div class="callout small">Pipeline: Low-cost, ruggedized devices for Indian contexts with multilingual support.</div>
                </div>
                <div class="col-md-5">
                  <table class="table table-sm align-middle mb-2">
                    <tbody>
                      <tr><th scope="row" class="fw-normal">Trials</th><td>Usability pilots in schools & rehab centers</td></tr>
                      <tr><th scope="row" class="fw-normal">Data Ethics</th><td>Consent, privacy, and safety-by-design</td></tr>
                    </tbody>
                  </table>
                  <a href="#engage" class="btn btn-primary btn-sm w-100">Join the Pilot</a>
                </div>
              </div>
            </article>
          </section>

          <!-- IMPACT -->
          <section id="impact" class="mt-4" tabindex="-1" aria-labelledby="impact-h">
            <h2 id="impact-h" class="h4 fw-bold mb-3">Life-Changing Results (5-Year Horizon)</h2>
            <div class="row g-3">
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-people-fill"></i>
                    <div>
                      <div class="fw-semibold">12,500+</div>
                      <div class="small muted">Children served</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-eyeglasses"></i>
                    <div>
                      <div class="fw-semibold">8,000+</div>
                      <div class="small muted">Sight-restoring surgeries</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="cardx h-100">
                    <div class="metric">
                      <i class="bi bi-mortarboard"></i>
                      <div>
                        <div class="fw-semibold">95%</div>
                        <div class="small muted">School integration rate</div>
                      </div>
                    </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="cardx h-100">
                  <div class="metric">
                    <i class="bi bi-briefcase-fill"></i>
                    <div>
                      <div class="fw-semibold">78%</div>
                      <div class="small muted">Employment rate (graduates)</div>
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
                    <li>Timely pediatric surgery prevents permanent visual loss.</li>
                    <li>Assistive and adaptive tech unlocks classroom success.</li>
                    <li>Life-skills training converts capability into independence.</li>
                    <li>Vision AI bridges mobility, literacy, and employability.</li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="cardx">
                  <div class="fw-semibold mb-2">Governance & Transparency</div>
                  <ul class="small mb-0">
                    <li>Clinical pathways, anesthesia safety, infection control.</li>
                    <li>Device provenance, warranties, maintenance logs.</li>
                    <li>Outcome dashboards; privacy-preserving data collection.</li>
                    <li>Scholarships & sponsorship audits for equity.</li>
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
                  <p class="small muted mb-0">Co-create surgical camps, school integration labs, life-skills academies, and Vision-AI pilots with us.</p>
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
