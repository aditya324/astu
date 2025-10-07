<?php

require_once '../db.php';
require_once '../config.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function e($v){ return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8'); }
function inr($n){ $s=number_format((float)$n,2); return preg_replace('/\.00$/','',$s); }

if (empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32));
$CSRF=$_SESSION['csrf'];

// ---------- Data ----------
$q=trim($_GET['q']??'');
$min=trim($_GET['min']??'');
$max=trim($_GET['max']??'');
$sort=$_GET['sort']??'newest';
$page=max(1,(int)($_GET['page']??1));
$per=12; $offset=($page-1)*$per;

$where=[]; $types=''; $args=[];
if($q!==''){ $where[]="name LIKE CONCAT('%', ?, '%')"; $types.='s'; $args[]=$q; }
if($min!==''&&is_numeric($min)){ $where[]="amount >= ?"; $types.='d'; $args[]=(float)$min; }
if($max!==''&&is_numeric($max)){ $where[]="amount <= ?"; $types.='d'; $args[]=(float)$max; }
$whereSql=$where?'WHERE '.implode(' AND ',$where):'';

switch($sort){
  case 'oldest':$orderSql="ORDER BY created_at ASC,id ASC";break;
  case 'amount_desc':$orderSql="ORDER BY amount DESC,id DESC";break;
  case 'amount_asc':$orderSql="ORDER BY amount ASC,id ASC";break;
  default:$orderSql="ORDER BY created_at DESC,id DESC";
}

$r=$conn->query("SELECT COALESCE(SUM(amount),0)s,COUNT(*)c FROM sponsors")->fetch_assoc();
$totalSum=(float)$r['s']; $totalCount=(int)$r['c'];

$sqlC="SELECT COUNT(*)c FROM sponsors $whereSql";
$stC=$conn->prepare($sqlC);
if($types) $stC->bind_param($types,...$args);
$stC->execute();
$filteredCount=(int)$stC->get_result()->fetch_assoc()['c'];
$totalPages=max(1,(int)ceil($filteredCount/$per));

$sqlL="SELECT id,name,amount,image,created_at FROM sponsors $whereSql $orderSql LIMIT ? OFFSET ?";
$stL=$conn->prepare($sqlL);
if($types){$types2=$types.'ii';$params=array_merge($args,[$per,$offset]);$stL->bind_param($types2,...$params);}
else{$stL->bind_param('ii',$per,$offset);}
$stL->execute();
$list=$stL->get_result()->fetch_all(MYSQLI_ASSOC);

$lr=$conn->query("SELECT name,amount FROM sponsors ORDER BY created_at DESC,id DESC LIMIT 1");
$latestName='-';$latestAmt=0;
if($lr&&$lr->num_rows){$x=$lr->fetch_assoc();$latestName=$x['name'];$latestAmt=$x['amount'];}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sponsors Admin</title>
<style>
:root{--brand:#0ea5a0;--bg:#fff;--card:#fff;--border:#e5e7eb;--text:#111827;--muted:#6b7280;--chip:#f8fafc;}
body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;margin:0;background:var(--bg);color:var(--text);}
.wrap{max-width:1240px;margin:32px auto;padding:0 16px;}
h1{margin:0 0 16px;}
.alert{margin:12px 0;padding:10px 12px;border-radius:10px;font-weight:600;border:1px solid transparent;}
.alert.success{background:#ecfdf5;border-color:#a7f3d0;color:#065f46;}
.alert.error{background:#fef2f2;border-color:#fecaca;color:#991b1b;}
.kpis{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin:16px 0 24px;}
.kpi{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:16px;box-shadow:0 8px 20px rgba(0,0,0,.04);}
.kpi .label{font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;}
.kpi .val{font-size:24px;font-weight:800;margin-top:8px;}
.grid{display:grid;grid-template-columns:380px 1fr;gap:24px;}
@media(max-width:1000px){.grid{grid-template-columns:1fr;}}
.card{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:16px;box-shadow:0 8px 20px rgba(0,0,0,.04);}
label{display:block;font-size:13px;color:var(--muted);margin-bottom:6px;}
input,select{width:100%;padding:12px;border:1px solid var(--border);border-radius:10px;background:#fff;color:var(--text);}
.row{display:flex;gap:12px}.row>*{flex:1}
.btn{padding:10px 14px;border:0;border-radius:10px;cursor:pointer;font-weight:700}
.btn-primary{background:#0ea5a0;color:#fff}
.btn-ghost{background:#fff;color:#111827;border:1px solid var(--border)}
.btn-danger{background:#ef4444;color:#fff}
.cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:18px;margin-top:12px}
.card-sponsor{background:var(--card);border:1px solid var(--border);border-radius:16px;overflow:hidden;box-shadow:0 8px 20px rgba(0,0,0,.04);display:flex;flex-direction:column}
.cover{width:100%;aspect-ratio:16/10;object-fit:cover;background:#f3f4f6;border-bottom:1px solid var(--border)}
.body{padding:14px;display:grid;gap:6px}
.name{font-weight:800;font-size:18px}
.amount{font-weight:900}
.meta{color:var(--muted);font-size:12px}
.actions{display:flex;gap:8px;padding:12px;border-top:1px solid var(--border);margin-top:auto}
.chip{display:inline-block;font-size:12px;padding:4px 8px;border-radius:999px;background:var(--chip);border:1px solid var(--border);color:#374151}
details.edit{border-top:1px dashed var(--border);padding:0 14px 14px}
details.edit summary{cursor:pointer;list-style:none;padding:12px 0;color:#0ea5a0}
.pager{display:flex;gap:8px;align-items:center;justify-content:flex-end;margin-top:16px}
.pager a,.pager span{padding:8px 10px;border-radius:10px;border:1px solid var(--border);text-decoration:none;color:#111827;background:#fff}
.pager .active{background:#0ea5a0;color:#fff;border-color:#0ea5a0}
</style>
</head>
<body>
<div class="wrap">
<h1>Sponsors</h1>

<?php
if(!empty($_SESSION['flash_success'])){ echo "<div class='alert success'>".e($_SESSION['flash_success'])."</div>"; unset($_SESSION['flash_success']); }
if(!empty($_SESSION['flash_error'])){   echo "<div class='alert error'>".e($_SESSION['flash_error'])."</div>";     unset($_SESSION['flash_error']); }
?>

<div class="kpis">
  <div class="kpi"><div class="label">Total Sponsors</div><div class="val"><?= (int)$totalCount ?></div></div>
  <div class="kpi"><div class="label">Total Donations</div><div class="val">₹ <?= inr($totalSum) ?></div></div>
  <div class="kpi"><div class="label">Latest Sponsor</div><div class="val"><?= e($latestName) ?> • ₹ <?= inr($latestAmt) ?></div></div>
</div>

<div class="grid">
  <div class="card">
    <h2>Add Sponsor</h2>
    <form method="POST" action="add_sponsor.php" enctype="multipart/form-data">
      <input type="hidden" name="csrf" value="<?= e($CSRF) ?>">
      <input type="hidden" name="action" value="create">
      <div class="row">
        <div><label>Name</label><input type="text" name="name" required></div>
        <div><label>Donation (₹)</label><input type="number" step="0.01" name="amount" required></div>
      </div>
      <div><label>Image (≤3MB)</label><input type="file" name="image" accept="image/*" required></div>
      <button class="btn btn-primary" type="submit">Add</button>
    </form>
  </div>

  <div class="card">
    <h2>All Sponsors</h2>

    <form method="GET" style="margin-bottom:12px">
      <div class="row">
        <input type="text" name="q" value="<?= e($q) ?>" placeholder="Search name">
        <input type="number" step="0.01" name="min" value="<?= e($min) ?>" placeholder="Min ₹">
        <input type="number" step="0.01" name="max" value="<?= e($max) ?>" placeholder="Max ₹">
        <select name="sort">
          <option value="newest"<?= $sort==='newest'?' selected':''?>>Newest</option>
          <option value="oldest"<?= $sort==='oldest'?' selected':''?>>Oldest</option>
          <option value="amount_desc"<?= $sort==='amount_desc'?' selected':''?>>High→Low</option>
          <option value="amount_asc"<?= $sort==='amount_asc'?' selected':''?>>Low→High</option>
        </select>
      </div>
      <div style="margin-top:8px;display:flex;gap:8px">
        <button class="btn btn-ghost">Apply</button>
        <a class="btn btn-ghost" href="?">Reset</a>
      </div>
    </form>

    <?php if(!$list): ?>
      <p>No sponsors yet.</p>
    <?php else: ?>
    <div class="cards">
      <?php foreach($list as $r): $id=(int)$r['id']; ?>
      <div class="card-sponsor">
        <?php if(!empty($r['image'])): ?><img class="cover" src="<?= e($r['image']) ?>" alt="<?= e($r['name']) ?>"><?php endif; ?>
        <div class="body">
          <div class="name"><?= e($r['name']) ?></div>
          <div><span class="chip">ID #<?= $id ?></span></div>
          <div class="amount">₹ <?= inr($r['amount']) ?></div>
          <div class="meta">Added: <?= e($r['created_at']) ?></div>
        </div>
        <div class="actions">
          <a class="btn btn-ghost btn-sm" href="#edit-<?= $id ?>" onclick="toggleEdit(<?= $id ?>);return false;">Edit</a>
          <form method="POST" action="add_sponsor.php" onsubmit="return confirm('Delete this sponsor?');" style="margin-left:auto">
            <input type="hidden" name="csrf" value="<?= e($CSRF) ?>">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= $id ?>">
            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
          </form>
        </div>
        <details id="edit-<?= $id ?>" class="edit">
          <summary>Edit details</summary>
          <form class="edit-form" method="POST" action="add_sponsor.php" enctype="multipart/form-data">
            <input type="hidden" name="csrf" value="<?= e($CSRF) ?>">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="row">
              <div><label>Name</label><input type="text" name="name" value="<?= e($r['name']) ?>" required></div>
              <div><label>Donation (₹)</label><input type="number" step="0.01" name="amount" value="<?= e($r['amount']) ?>" required></div>
            </div>
            <div><label>Replace image (optional)</label><input type="file" name="image" accept="image/*"></div>
            <div style="display:flex;gap:8px;justify-content:flex-end">
              <button type="button" class="btn btn-ghost" onclick="toggleEdit(<?= $id ?>)">Cancel</button>
              <button class="btn btn-primary" type="submit">Save</button>
            </div>
          </form>
        </details>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="pager" style="margin-top:16px">
      <?php
        $qs=$_GET; $qs['page']=1; $first='?'.http_build_query($qs);
        $qs['page']=max(1,$page-1); $prev='?'.http_build_query($qs);
        $qs['page']=min($totalPages,$page+1); $next='?'.http_build_query($qs);
        $qs['page']=$totalPages; $last='?'.http_build_query($qs);
      ?>
      <a href="<?= e($first) ?>">« First</a>
      <a href="<?= e($prev) ?>">&lsaquo; Prev</a>
      <span class="active">Page <?= $page ?> / <?= $totalPages ?></span>
      <a href="<?= e($next) ?>">Next &rsaquo;</a>
      <a href="<?= e($last) ?>">Last »</a>
    </div>
    <?php endif; ?>
  </div>
</div>
</div>

<script>
function toggleEdit(id){
  var d=document.getElementById('edit-'+id);
  if(!d) return;
  d.open=!d.open;
  if(d.open){
    document.querySelectorAll('details.edit').forEach(x=>{ if(x!==d) x.open=false; });
    d.scrollIntoView({behavior:'smooth',block:'nearest'});
  }
}
// Anti double-submit
document.querySelectorAll('form').forEach(f=>{
  f.addEventListener('submit',()=>{
    const btn=f.querySelector('button[type="submit"]');
    if(btn){ btn.disabled=true; btn.style.opacity='0.7'; }
  });
});
</script>
</body>
</html>
