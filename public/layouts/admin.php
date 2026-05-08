<?php $baseUrl = $GLOBALS['baseUrl'] ?? '/'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin') ?> | Sakari Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/css/admin.css" rel="stylesheet">
</head>
<body class="admin-body">

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <img src="<?= $baseUrl ?>assets/img/logo.png" alt="Sakari">
            <div>
                <h3>Sakari</h3>
                <span>Admin Panel</span>
            </div>
        </div>

        <nav>
            <div class="nav-section">Main</div>
            <a href="<?= $baseUrl ?>admin-dashboard" class="nav-link <?= ($request ?? '') === 'admin-dashboard' ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>

            <div class="nav-section">Content</div>
            <a href="<?= $baseUrl ?>admin-blogs" class="nav-link <?= ($request ?? '') === 'admin-blogs' ? 'active' : '' ?>">
                <i class="bi bi-journal-richtext"></i> Blog Posts
            </a>
            <a href="<?= $baseUrl ?>admin-jobs" class="nav-link <?= ($request ?? '') === 'admin-jobs' ? 'active' : '' ?>">
                <i class="bi bi-briefcase-fill"></i> Job Postings
            </a>

            <div class="nav-section">Pages</div>
            <a href="<?= $baseUrl ?>" class="nav-link" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i> View Website
            </a>
            <a href="<?= $baseUrl ?>blog" class="nav-link" target="_blank">
                <i class="bi bi-file-earmark-text"></i> View Blog
            </a>
            <a href="<?= $baseUrl ?>careers" class="nav-link" target="_blank">
                <i class="bi bi-file-earmark-person"></i> View Careers
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= $baseUrl ?>admin-logout" class="nav-link">
                <i class="bi bi-box-arrow-left"></i> Logout
            </a>
        </div>
    </aside>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Main Content -->
    <div class="admin-main">
        <header class="admin-header">
            <div style="display:flex;align-items:center;gap:12px;">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <div class="page-title-header">
                    <h1><?= htmlspecialchars($title ?? 'Dashboard') ?></h1>
                </div>
            </div>
            <div class="header-actions">
                <a href="<?= $baseUrl ?>" target="_blank" class="header-link" title="View Website">
                    <i class="bi bi-globe2"></i>
                </a>
                <div class="user-info">
                    <div class="avatar"><?= strtoupper(substr($_SESSION['admin']['name'] ?? 'A', 0, 1)) ?></div>
                    <span><?= htmlspecialchars($_SESSION['admin']['name'] ?? 'Admin') ?></span>
                </div>
            </div>
        </header>

        <div class="admin-content">
            <?php if (isset($_SESSION['flash_success'])): ?>
                <div class="admin-alert admin-alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['flash_error'])): ?>
                <div class="admin-alert admin-alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
                </div>
            <?php endif; ?>

            <?php require_once $content; ?>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }
        function closeSidebar() {
            document.getElementById('adminSidebar').classList.remove('active');
            document.getElementById('sidebarOverlay').classList.remove('active');
        }
    </script>
</body>
</html>
