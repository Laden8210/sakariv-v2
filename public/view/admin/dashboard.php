<?php
require_once __DIR__ . '/../../../database/init.php';
$db = getDB();

$totalBlogs = $db->query("SELECT COUNT(*) FROM blog_posts")->fetchColumn();
$publishedBlogs = $db->query("SELECT COUNT(*) FROM blog_posts WHERE status='published'")->fetchColumn();
$draftBlogs = $totalBlogs - $publishedBlogs;
$totalJobs = $db->query("SELECT COUNT(*) FROM jobs")->fetchColumn();
$publishedJobs = $db->query("SELECT COUNT(*) FROM jobs WHERE status='published'")->fetchColumn();
$draftJobs = $totalJobs - $publishedJobs;

$recentBlogs = $db->query("SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT 5")->fetchAll();
$recentJobs = $db->query("SELECT * FROM jobs ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>

<!-- Welcome Banner -->
<div style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border-radius: 16px; padding: 32px 36px; margin-bottom: 32px; color: #fff; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -30px; right: -30px; width: 200px; height: 200px; background: rgba(255,255,255,0.08); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -40px; right: 60px; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
    <div style="position: relative; z-index: 1;">
        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 8px;">Welcome back, <?= htmlspecialchars($_SESSION['admin']['name'] ?? 'Admin') ?>! 👋</h2>
        <p style="opacity: 0.85; font-size: 0.95rem; margin: 0;">Here's an overview of your website content and activity.</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="stat-cards">
    <div class="stat-card">
        <div class="stat-card-icon blue"><i class="bi bi-journal-richtext"></i></div>
        <div class="stat-card-info">
            <h3><?= $totalBlogs ?></h3>
            <p>Total Blog Posts</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon green"><i class="bi bi-check-circle"></i></div>
        <div class="stat-card-info">
            <h3><?= $publishedBlogs ?></h3>
            <p>Published Posts</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon purple"><i class="bi bi-briefcase"></i></div>
        <div class="stat-card-info">
            <h3><?= $totalJobs ?></h3>
            <p>Total Job Postings</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon orange"><i class="bi bi-megaphone"></i></div>
        <div class="stat-card-info">
            <h3><?= $publishedJobs ?></h3>
            <p>Active Job Listings</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div style="display: flex; gap: 12px; margin-bottom: 32px; flex-wrap: wrap;">
    <a href="admin-blogs" class="btn-admin btn-admin-primary" style="text-decoration:none;">
        <i class="bi bi-plus-lg"></i> New Blog Post
    </a>
    <a href="admin-jobs" class="btn-admin btn-admin-outline" style="text-decoration:none;">
        <i class="bi bi-plus-lg"></i> New Job Posting
    </a>
    <a href="/" target="_blank" class="btn-admin btn-admin-outline" style="text-decoration:none;">
        <i class="bi bi-globe2"></i> View Website
    </a>
</div>

<!-- Recent Content -->
<div class="dashboard-grid">
    <!-- Recent Blogs -->
    <div class="admin-card">
        <div class="card-header">
            <h3><i class="bi bi-journal-richtext" style="margin-right: 8px; color: var(--admin-info);"></i>Recent Blog Posts</h3>
            <a href="admin-blogs" class="btn-admin btn-admin-sm btn-admin-outline" style="text-decoration:none;">View All</a>
        </div>
        <div class="card-body">
            <?php if (empty($recentBlogs)): ?>
                <div class="empty-state">
                    <i class="bi bi-journal-x"></i>
                    <h4>No posts yet</h4>
                    <p>Create your first blog post</p>
                </div>
            <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentBlogs as $blog): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars(mb_strimwidth($blog['title'], 0, 35, '...')) ?></strong></td>
                                <td><span class="badge badge-<?= $blog['status'] ?>"><?= $blog['status'] ?></span></td>
                                <td style="color:var(--admin-text-muted);font-size:0.82rem;"><?= date('M d, Y', strtotime($blog['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Jobs -->
    <div class="admin-card">
        <div class="card-header">
            <h3><i class="bi bi-briefcase-fill" style="margin-right: 8px; color: var(--admin-accent);"></i>Recent Job Postings</h3>
            <a href="admin-jobs" class="btn-admin btn-admin-sm btn-admin-outline" style="text-decoration:none;">View All</a>
        </div>
        <div class="card-body">
            <?php if (empty($recentJobs)): ?>
                <div class="empty-state">
                    <i class="bi bi-briefcase"></i>
                    <h4>No jobs yet</h4>
                    <p>Create your first job posting</p>
                </div>
            <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentJobs as $job): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars(mb_strimwidth($job['title'], 0, 30, '...')) ?></strong></td>
                                <td><span class="badge badge-<?= strtolower(str_replace('-', '', $job['type'])) ?>"><?= $job['type'] ?></span></td>
                                <td><span class="badge badge-<?= $job['status'] ?>"><?= $job['status'] ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Content Summary -->
<div class="admin-card" style="margin-top: 24px;">
    <div class="card-header">
        <h3><i class="bi bi-pie-chart" style="margin-right: 8px; color: var(--admin-warning);"></i>Content Summary</h3>
    </div>
    <div class="card-body" style="padding: 24px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px;">
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 12px;">
                <div style="font-size: 2rem; font-weight: 800; color: var(--admin-success);"><?= $publishedBlogs ?></div>
                <div style="font-size: 0.82rem; color: var(--admin-text-muted); margin-top: 4px;">Published Posts</div>
            </div>
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 12px;">
                <div style="font-size: 2rem; font-weight: 800; color: var(--admin-warning);"><?= $draftBlogs ?></div>
                <div style="font-size: 0.82rem; color: var(--admin-text-muted); margin-top: 4px;">Draft Posts</div>
            </div>
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 12px;">
                <div style="font-size: 2rem; font-weight: 800; color: var(--admin-success);"><?= $publishedJobs ?></div>
                <div style="font-size: 0.82rem; color: var(--admin-text-muted); margin-top: 4px;">Active Jobs</div>
            </div>
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 12px;">
                <div style="font-size: 2rem; font-weight: 800; color: var(--admin-warning);"><?= $draftJobs ?></div>
                <div style="font-size: 0.82rem; color: var(--admin-text-muted); margin-top: 4px;">Draft Jobs</div>
            </div>
        </div>
    </div>
</div>
