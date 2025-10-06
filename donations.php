<?php
// donations.php — full page (Asthu Foundation Donor Wall)

// ====== CONFIG ======
$OK_STATUS = 'success';           // your success status per DB
$PER_PAGE  = 20;                  // rows per page
$CURRENCY  = '₹';                 // currency symbol
$GOAL_INR  = 500000;              // campaign goal; set 0 to hide goal module

// ====== HELPERS ======
function e($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function safe_name($n){ $n = trim((string)$n); return $n !== '' ? $n : 'Anonymous'; }

// Indian currency formatting (e.g., 12,34,567.89)
function inr_format($num){
  $x = number_format((float)$num, 2, '.', '');
  [$int,$dec] = array_pad(explode('.', $x, 2), 2, '00');
  $l = strlen($int);
  if($l <= 3) return $int.'.'.$dec;
  $last3 = substr($int, $l-3);
  $rest = substr($int, 0, $l-3);
  $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
  return $rest . ',' . $last3 . '.' . $dec;
}

// Relative time text
function time_ago($ts){
  $t = $ts ? strtotime($ts) : false;
  if(!$t) return '';
  $diff = time() - $t;
  if($diff < 60) return $diff."s ago";
  if($diff < 3600) return floor($diff/60)."m ago";
  if($diff < 86400) return floor($diff/3600)."h ago";
  if($diff < 30*86400) return floor($diff/86400)."d ago";
  return date('d M Y', $t);
}
// Name initials for avatars
function initials($name){
  $n = trim((string)$name);
  if($n==='') return 'AN';
  $parts = preg_split('/\s+/',$n);
  $ini = strtoupper(mb_substr($parts[0],0,1,'UTF-8'));
  if(count($parts)>1){ $ini .= strtoupper(mb_substr(end($parts),0,1,'UTF-8')); }
  return $ini;
}

// ====== INPUTS ======
$page   = isset($_GET['page']) ? max(1,(int)$_GET['page']) : 1;
$offset = ($page - 1) * $PER_PAGE;

// ====== DB CONNECT ======
require_once __DIR__ . '/db.php';

// ====== TOTALS ======
$totalAmount = 0; $totalCount = 0; $totalDonors = 0;

// Total Raised
$sql = "SELECT COALESCE(SUM(amount),0) FROM donations WHERE status=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $OK_STATUS);
$stmt->execute(); $stmt->bind_result($totalAmount); $stmt->fetch(); $stmt->close();

// Total Rows
$sql = "SELECT COUNT(*) FROM donations WHERE status=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $OK_STATUS);
$stmt->execute(); $stmt->bind_result($totalCount); $stmt->fetch(); $stmt->close();

// Unique Donors by name (blank -> Anonymous)
$sql = "SELECT COUNT(*) FROM (
          SELECT DISTINCT COALESCE(NULLIF(TRIM(name),''),'Anonymous') AS dn
          FROM donations
          WHERE status=?
        ) t";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $OK_STATUS);
$stmt->execute(); $stmt->bind_result($totalDonors); $stmt->fetch(); $stmt->close();

$totalPages = max(1, (int)ceil($totalCount / $PER_PAGE));

// ====== RECENT DONATIONS (paged) ======
$sql = "SELECT name, amount, donated_at
        FROM donations
        WHERE status=?
        ORDER BY donated_at DESC
        LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sii', $OK_STATUS, $offset, $PER_PAGE);
$stmt->execute(); $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();

// ====== TOP DONORS (sum by donor name) ======
$topRows = [];
$sql = "SELECT COALESCE(NULLIF(TRIM(name),''),'Anonymous') AS donor,
               SUM(amount) AS total_amt,
               MAX(donated_at) AS last_at
        FROM donations
        WHERE status=?
        GROUP BY donor
        ORDER BY total_amt DESC
        LIMIT 8";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $OK_STATUS);
$stmt->execute(); $topRows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();

// ====== PAGINATION URL BUILDER ======
$qs = $_GET; unset($qs['page']);
$base = strtok($_SERVER['REQUEST_URI'],'?'); $qstr = http_build_query($qs);
$mk = function($p) use($base,$qstr){ return $base . ($qstr ? "?$qstr&" : "?") . "page=$p"; };

// ====== PROGRESS % ======
$progressPct = $GOAL_INR > 0 ? min(100, (int)floor(($totalAmount / $GOAL_INR) * 100)) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Asthu Foundation — Donor Wall</title>
	<meta name="description" content="Recent donations and supporters of Asthu Foundation.">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" sizes="56x56" href="assets/images/fav-icon/icon.png">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/owl.carousel.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/animate.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/all.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/flaticon.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/theme-default.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/meanmenu.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css" media="all">
	<link rel="stylesheet" href="venobox/venobox.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/bootstrap-icons.css" type="text/css" media="all">
	<link rel="stylesheet" type="text/css" href="assets/slick/slick.css">
	<link rel="stylesheet" type="text/css" href="assets/slick/slick-theme.css">
	<link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/dropdown.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/responsive.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/rangeslider.css" type="text/css" media="all">
	<script src="assets/js/vendor/modernizr-3.5.0.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

  <style>
    /* --- Donor Wall styling (scoped) --- */
    .donor-hero {
      background: radial-gradient(140% 140% at 0% 0%, #fff 0%, #f7f9ff 55%, #eef3ff 100%);
      border: 1px solid #eef2ff;
      border-radius: 18px;
      padding: 28px;
    }
    .stat-card {
      border: 1px solid #eef1f7;
      border-radius: 16px;
      overflow: hidden;
      background: #fff;
    }
    .stat-card .icon {
      width: 44px; height: 44px; border-radius: 12px;
      display:flex; align-items:center; justify-content:center;
      background: #f2f6ff;
    }
    .rupee {
      font-variant-numeric: tabular-nums;
      letter-spacing: .2px;
    }
    .progress.soft {
      height: 12px;
      background: #f1f3f9;
      border-radius: 999px;
      overflow: hidden;
    }
    .progress.soft .progress-bar {
      background: linear-gradient(90deg, #ef4323 0%, #ff7a59 100%);
    }
    .donor-card {
      border: 1px solid #eef1f7;
      border-radius: 14px;
      background:#fff;
      transition: transform .15s ease, box-shadow .15s ease;
    }
    .donor-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(20,20,60,.06); }
    .avatar {
      width: 42px; height: 42px; border-radius: 50%;
      display:flex; align-items:center; justify-content:center;
      font-weight: 700; background:#eef2ff; color:#3949ab;
    }
    .badge-soft {
      background: #f7f3ff;
      color: #5b2f91;
      border: 1px solid #efe9ff;
      font-weight: 500;
    }
    .top-donor {
      display:flex; align-items:center; justify-content:space-between;
      padding:10px 0; border-bottom:1px dashed #edf0f7;
    }
    .top-donor:last-child { border-bottom:0; }
    .pill {
      padding: 6px 10px; border-radius: 999px; font-size: .82rem; background:#f6faf7; border:1px solid #e6f3e8; color:#137333;
    }
    @media (max-width: 991.98px){
      .border-lg-start { border-left: 0 !important; }
    }
  </style>
</head>

<body class="bg-light">
  <?php require "header.php" ?>

  <section class="container my-5">
    <!-- Hero -->
    <div class="donor-hero mb-4">
      <div class="d-flex flex-wrap align-items-center gap-3">
        <div class="icon p-2 rounded-3" style="background:#fff0eb;border:1px solid #ffe3da;">
          <i class="bi bi-heart-fill" style="color:#ef4323;font-size:24px;"></i>
        </div>
        <div>
          <h3 class="mb-1">Together we’re making care reachable.</h3>
          <div class="text-muted">Thanks to our donors, Asthu Foundation runs health camps, supplies, and community programs.</div>
        </div>
      </div>

      <?php if ($GOAL_INR > 0): ?>
      <div class="mt-3">
        <div class="d-flex justify-content-between small mb-1">
          <span>Campaign progress</span>
          <span class="rupee fw-semibold"><?= e($CURRENCY).' '.inr_format($totalAmount) ?> / <?= e($CURRENCY).' '.inr_format($GOAL_INR) ?> (<?= $progressPct ?>%)</span>
        </div>
        <div class="progress soft">
          <div class="progress-bar" role="progressbar" style="width: <?= $progressPct ?>%" aria-valuenow="<?= $progressPct ?>" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <!-- Stats row -->
    <div class="row g-3 mb-4">
      <div class="col-12 col-md-4">
        <div class="stat-card p-3 h-100">
          <div class="d-flex align-items-center gap-3">
            <div class="icon"><i class="bi bi-cash-coin"></i></div>
            <div>
              <div class="text-muted small">Total Raised</div>
              <div class="fs-4 fw-bold rupee"><?= e($CURRENCY).' '.inr_format($totalAmount) ?></div>
              <span class="pill mt-1 d-inline-block">Live</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="stat-card p-3 h-100">
          <div class="d-flex align-items-center gap-3">
            <div class="icon"><i class="bi bi-people"></i></div>
            <div>
              <div class="text-muted small">Unique Donors</div>
              <div class="fs-4 fw-bold"><?= (int)$totalDonors ?></div>
              <div class="small text-muted">and counting</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="stat-card p-3 h-100">
          <div class="d-flex align-items-center gap-3">
            <div class="icon"><i class="bi bi-clipboard-check"></i></div>
            <div>
              <div class="text-muted small">Donations Logged</div>
              <div class="fs-4 fw-bold"><?= (int)$totalCount ?></div>
              <div class="small text-muted">successful transactions</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Content: Recent + Top -->
    <div class="row g-4">
      <div class="col-lg-8">
        <?php if (!$rows): ?>
          <div class="p-5 text-center donor-card">
            <div class="mb-2"><i class="bi bi-emoji-smile" style="font-size:28px;color:#ef4323;"></i></div>
            <h5 class="mb-1">No donations yet</h5>
            <div class="text-muted">Be the first to support this cause today.</div>
          </div>
        <?php else: ?>
          <?php foreach ($rows as $r): ?>
            <div class="donor-card p-3 mb-3">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                  <div class="avatar"><?= e(initials($r['name'] ?? '')) ?></div>
                  <div>
                    <div class="fw-semibold"><?= e(safe_name($r['name'] ?? '')) ?></div>
                    <div class="small text-muted">
                      <i class="bi bi-clock me-1"></i>
                      <?= e(time_ago($r['donated_at'] ?? '')) ?>
                    </div>
                  </div>
                </div>
                <div class="text-end">
                  <div class="fw-bold rupee" style="font-size:1.15rem;"><?= e($CURRENCY).' '.inr_format($r['amount'] ?? 0) ?></div>
                  <span class="badge badge-soft rounded-pill">success</span>
                </div>
              </div>
            </div>
          <?php endforeach; ?>

          <!-- Pagination -->
          <?php if($totalPages > 1): ?>
          <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="small text-muted">Page <?= (int)$page ?> of <?= (int)$totalPages ?></div>
            <nav aria-label="Donations pagination">
              <ul class="pagination mb-0">
                <li class="page-item <?= $page<=1?'disabled':'' ?>">
                  <a class="page-link" href="<?= $page>1?e($mk($page-1)):'#' ?>">Previous</a>
                </li>
                <?php
                  $start = max(1, $page-2);
                  $end   = min($totalPages, $page+2);
                  if ($start > 1) {
                    echo '<li class="page-item"><a class="page-link" href="'.e($mk(1)).'">1</a></li>';
                    if ($start > 2) echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                  }
                  for ($i=$start; $i<=$end; $i++) {
                    $active = $i === $page ? 'active' : '';
                    echo '<li class="page-item '.$active.'"><a class="page-link" href="'.e($mk($i)).'">'.(int)$i.'</a></li>';
                  }
                  if ($end < $totalPages) {
                    if ($end < $totalPages - 1) echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                    echo '<li class="page-item"><a class="page-link" href="'.e($mk($totalPages)).'">'.(int)$totalPages.'</a></li>';
                  }
                ?>
                <li class="page-item <?= $page>=$totalPages?'disabled':'' ?>">
                  <a class="page-link" href="<?= $page<$totalPages?e($mk($page+1)):'#' ?>">Next</a>
                </li>
              </ul>
            </nav>
          </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>

      <!-- Top donors -->
      <div class="col-lg-4">
        <div class="donor-card p-3 h-100">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="mb-0">Top Donors</h6>
            <i class="bi bi-trophy-fill" style="color:#ef4323;"></i>
          </div>
          <?php if (!$topRows): ?>
            <div class="text-muted small">No donors yet.</div>
          <?php else: foreach ($topRows as $trow): ?>
            <div class="top-donor">
              <div class="d-flex align-items-center gap-2">
                <div class="avatar" style="width:36px;height:36px;"><?= e(initials($trow['donor'])) ?></div>
                <div>
                  <div class="fw-semibold"><?= e($trow['donor']) ?></div>
                  <div class="small text-muted">Last gift: <?= e(time_ago($trow['last_at'])) ?></div>
                </div>
              </div>
              <div class="fw-semibold rupee"><?= e($CURRENCY).' '.inr_format($trow['total_amt']) ?></div>
            </div>
          <?php endforeach; endif; ?>
          <div class="small text-muted mt-2">We’re grateful to every contributor — big and small.</div>
        </div>
      </div>
    </div>

    <div class="text-muted small mt-3">
      * Only successful payments are shown. Names left blank appear as “Anonymous”.
    </div>
  </section>

  <?php require "footer.php" ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/vendor/jquery-3.6.2.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	<script src="assets/js/jquery.counterup.min.js"></script>
	<script src="assets/js/waypoints.min.js"></script>
	<script src="assets/js/wow.min.js"></script>
	<script src="assets/js/imagesloaded.pkgd.min.js"></script>
	<script src="venobox/venobox.js"></script>
	<script src="assets/js/animated-text.js"></script>
	<script src="venobox/venobox.min.js"></script>
	<script src="assets/js/isotope.pkgd.min.js"></script>
	<script src="assets/js/jquery.meanmenu.js"></script>
	<script src="assets/js/jquery.scrollUp.js"></script>
	<script src="assets/slick/slick.min.js"></script>
	<script src="assets/js/jquery.barfiller.js"></script>
	<script src="assets/js/rangeslider.js"></script>
	<script src="assets/js/mixitup.min.js"></script>
	<script src="assets/js/theme.js"></script>
	<script src="assets/js/script.js"></script>
</body>
</html>
