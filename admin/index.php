<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php?error=auth");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" sizes="56x56" href="../assets/images/fav-icon/icon.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap-icons.css" />
    <style>
        :root {
            --sidebar: #0f172a;
            --sidebar-text: #cbd5e1;
        }

        body {
            background: #f7f9fc;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: var(--sidebar);
            color: var(--sidebar-text);
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 1.25rem;
        }

        .sidebar .brand {
            font-weight: 700;
            color: #fff;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .sidebar a {
            color: var(--sidebar-text);
            text-decoration: none;
            display: block;
            padding: .6rem .75rem;
            border-radius: .5rem;
            margin: .15rem 0;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #1e293b;
            color: #fff;
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: .75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page {
            padding: 1.25rem;
        }

        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                z-index: 1000;
                transform: translateX(-100%);
                transition: transform .3s
            }

            .sidebar.open {
                transform: none
            }
        }

        .menu-btn {
            display: none
        }

        @media(max-width:992px) {
            .menu-btn {
                display: inline-flex
            }
        }
    </style>
</head>

<body>
    <div class="layout">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="brand"><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</div>
            <div class="mb-2 text-uppercase small opacity-75">Events</div>
            <a href="?page=events_add" class="<?= (($_GET['page'] ?? 'events_add') === 'events_add') ? 'active' : '' ?>">
                <i class="bi bi-plus-circle me-2"></i>Add Event
            </a>
            <a href="?page=events_manage" class="<?= (($_GET['page'] ?? '') === 'events_manage') ? 'active' : '' ?>">
                <i class="bi bi-calendar3 me-2"></i>Manage Events
            </a>
            <a href="?page=volunteer_pending" class="<?= (($_GET['page'] ?? '') === 'volunteer_pending') ? 'active' : '' ?>">
                <i class="bi bi-people me-2"></i>Volunteer
            </a>
            <a href="?page=associate_pending" class="<?= (($_GET['page'] ?? '') === 'associate_pending') ? 'active' : '' ?>">
                <i class="bi bi-people me-2"></i>Associates
            </a>
            <a href="?page=edit_stats" class="<?= (($_GET['page'] ?? '') === 'edit_stats') ? 'active' : '' ?>">
                <i class="bi bi-bar-chart me-2"></i>Stats
            </a>

            <a href="?page=testimonials" class="<?= (($_GET['page'] ?? '') === 'testimonials') ? 'active' : '' ?>">
                <i class="bi bi-chat-dots me-2"></i>testimonials
            </a>
            <a href="?page=donations" class="<?= (($_GET['page'] ?? '') === 'donations') ? 'active' : '' ?>">
                <i class="bi bi-cash me-2"></i>donations
            </a>
            <a href="?page=certificateDownloads" class="<?= (($_GET['page'] ?? '') === 'certificateDownloads') ? 'active' : '' ?>">
                <i class="bi bi-cash me-2"></i>certificateDownloads
            </a>


            <div class="mt-3 text-uppercase small opacity-75">Account</div>
            <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
        </nav>


        <div class="content">
            <div class="topbar">
                <button class="btn btn-outline-secondary menu-btn" onclick="document.getElementById('sidebar').classList.toggle('open')">
                    <i class="bi bi-list"></i>
                </button>
                <div class="fw-semibold">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></div>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="../">View Site</a>
                </div>
            </div>

            <main class="page">
                <?php
                $page = $_GET['page'] ?? 'events_add';
                $allowed = ['events_add', 'events_manage', 'event_edit', 'volunteer_pending', 'associate_pending', 'edit_stats', 'testimonials', 'donations', 'certificateDownloads'];
                if (!in_array($page, $allowed)) $page = 'events_add';
                require __DIR__ . "/{$page}.php";
                ?>
            </main>
        </div>
    </div>
    <script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>