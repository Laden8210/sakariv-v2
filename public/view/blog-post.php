<?php
require_once __DIR__ . '/../../database/init.php';
$db = getDB();
$baseUrl = $GLOBALS['baseUrl'] ?? '/';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: ' . $baseUrl . 'blog');
    exit;
}

$stmt = $db->prepare("SELECT * FROM blog_posts WHERE id = ? AND status = 'published'");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    header('Location: ' . $baseUrl . 'blog');
    exit;
}

// Get related posts (same category, exclude current)
$relatedStmt = $db->prepare("SELECT * FROM blog_posts WHERE status='published' AND id != ? AND category = ? ORDER BY created_at DESC LIMIT 3");
$relatedStmt->execute([$id, $post['category']]);
$related = $relatedStmt->fetchAll();

// If not enough related by category, fill with recent
if (count($related) < 3) {
    $excludeIds = array_merge([$id], array_column($related, 'id'));
    $placeholders = implode(',', array_fill(0, count($excludeIds), '?'));
    $limit = 3 - count($related);
    $moreStmt = $db->prepare("SELECT * FROM blog_posts WHERE status='published' AND id NOT IN ($placeholders) ORDER BY created_at DESC LIMIT $limit");
    $moreStmt->execute($excludeIds);
    $related = array_merge($related, $moreStmt->fetchAll());
}
?>

<!-- Page Title -->
<section class="page-title dark-background" id="page-title" style="background-image: url('<?= htmlspecialchars($post['image_url']) ?>');">
    <div class="container position-relative">
        <div class="blog-post-hero">
            <span class="blog-post-hero__badge<?= $post['badge_color'] ? ' blog-card__badge--' . htmlspecialchars($post['badge_color']) : '' ?>"><?= htmlspecialchars($post['category']) ?></span>
            <h1><?= htmlspecialchars($post['title']) ?></h1>
            <div class="blog-post-hero__meta">
                <div class="blog-post-hero__author">
                    <img src="<?= $baseUrl . htmlspecialchars($post['author_img']) ?>" alt="<?= htmlspecialchars($post['author_name']) ?>">
                    <div>
                        <strong><?= htmlspecialchars($post['author_name']) ?></strong>
                        <span><?= htmlspecialchars($post['author_role']) ?></span>
                    </div>
                </div>
                <div class="blog-post-hero__details">
                    <span><i class="bi bi-calendar3"></i> <?= date('F d, Y', strtotime($post['created_at'])) ?></span>
                    <span><i class="bi bi-clock"></i> <?= htmlspecialchars($post['read_time']) ?></span>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="<?= $baseUrl ?>">Home</a></li>
                <li><a href="<?= $baseUrl ?>blog">Blog</a></li>
                <li class="current"><?= htmlspecialchars(mb_strimwidth($post['title'], 0, 40, '...')) ?></li>
            </ol>
        </nav>
    </div>
</section>

<!-- Blog Post Content -->
<section class="blog-post section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <article class="blog-post__article" data-aos="fade-up">
                    <!-- Featured Image -->
                    <div class="blog-post__featured-img">
                        <img src="<?= htmlspecialchars($post['image_url']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="img-fluid">
                    </div>

                    <!-- Content -->
                    <div class="blog-post__content">
                        <?= nl2br(htmlspecialchars($post['content'])) ?>
                    </div>

                    <!-- Tags / Share -->
                    <div class="blog-post__footer">
                        <div class="blog-post__tags">
                            <span class="blog-post__tag"><i class="bi bi-tag"></i> <?= htmlspecialchars($post['category']) ?></span>
                        </div>
                        <div class="blog-post__share">
                            <span>Share:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" target="_blank" rel="noopener" title="Share on Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="https://twitter.com/intent/tweet?text=<?= urlencode($post['title']) ?>&url=<?= urlencode((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" target="_blank" rel="noopener" title="Share on Twitter"><i class="bi bi-twitter-x"></i></a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" target="_blank" rel="noopener" title="Share on LinkedIn"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>

                    <!-- Author Box -->
                    <div class="blog-post__author-box">
                        <img src="<?= $baseUrl . htmlspecialchars($post['author_img']) ?>" alt="<?= htmlspecialchars($post['author_name']) ?>" class="blog-post__author-avatar">
                        <div>
                            <h4><?= htmlspecialchars($post['author_name']) ?></h4>
                            <span class="blog-post__author-role"><?= htmlspecialchars($post['author_role']) ?></span>
                            <p class="blog-post__author-bio">Part of the Sakari Management Group leadership team, dedicated to transforming healthcare through innovative virtual staffing solutions.</p>
                        </div>
                    </div>

                    <!-- Back to Blog -->
                    <div class="text-center mt-4">
                        <a href="<?= $baseUrl ?>blog" class="blog-post__back-btn">
                            <i class="bi bi-arrow-left"></i> Back to Blog
                        </a>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <aside class="blog-post__sidebar">
                    <!-- Related Posts -->
                    <?php if (!empty($related)): ?>
                    <div class="blog-sidebar__widget">
                        <h3 class="blog-sidebar__title">Related Posts</h3>
                        <?php foreach ($related as $rel): ?>
                        <a href="<?= $baseUrl ?>blog-post?id=<?= $rel['id'] ?>" class="blog-sidebar__post">
                            <div class="blog-sidebar__post-img">
                                <img src="<?= htmlspecialchars($rel['image_url']) ?>" alt="<?= htmlspecialchars($rel['title']) ?>">
                            </div>
                            <div class="blog-sidebar__post-info">
                                <h4><?= htmlspecialchars($rel['title']) ?></h4>
                                <span><i class="bi bi-calendar3"></i> <?= date('M d, Y', strtotime($rel['created_at'])) ?></span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- CTA Widget -->
                    <div class="blog-sidebar__cta">
                        <i class="bi bi-headset"></i>
                        <h4>Need Healthcare Staffing?</h4>
                        <p>Get in touch with our team to learn how we can support your organization.</p>
                        <a href="https://calendly.com/junettecacho-sakarimanagement/30min" target="_blank" class="blog-sidebar__cta-btn">
                            Schedule a Call <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
