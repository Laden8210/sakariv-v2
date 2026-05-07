<?php
require_once __DIR__ . '/../../database/init.php';
$db = getDB();

$featured = $db->query("SELECT * FROM blog_posts WHERE status='published' AND is_featured=1 ORDER BY created_at DESC LIMIT 1")->fetch();
$posts = $db->query("SELECT * FROM blog_posts WHERE status='published' AND is_featured=0 ORDER BY created_at DESC")->fetchAll();
?>

    <!-- Page Title -->
    <section class="page-title dark-background" id="page-title" style="background-image: url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1920&q=80');">
        <div class="container position-relative">
            <h1>Blog & Insights</h1>
            <p style="font-size: 1.1rem; max-width: 600px; margin: 10px auto 0;">Stay updated with the latest in healthcare outsourcing, virtual staffing, and industry best practices.</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Home</a></li>
                    <li class="current">Blog</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Blog Section -->
    <section id="blog" class="blog section">
        <div class="container" data-aos="fade-up">

            <?php if ($featured): ?>
            <!-- Featured Post -->
            <div class="row mb-5">
                <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
                    <article class="blog-card blog-card--featured">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="blog-card__image blog-card__image--featured">
                                    <img src="<?= htmlspecialchars($featured['image_url']) ?>" alt="<?= htmlspecialchars($featured['title']) ?>" class="img-fluid">
                                    <span class="blog-card__badge">Featured</span>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center">
                                <div class="blog-card__body blog-card__body--featured">
                                    <div class="blog-card__meta">
                                        <span class="blog-card__category"><?= htmlspecialchars($featured['category']) ?></span>
                                        <span class="blog-card__date"><i class="bi bi-calendar3"></i> <?= date('F d, Y', strtotime($featured['created_at'])) ?></span>
                                        <span class="blog-card__read-time"><i class="bi bi-clock"></i> <?= htmlspecialchars($featured['read_time']) ?></span>
                                    </div>
                                    <h2 class="blog-card__title"><?= htmlspecialchars($featured['title']) ?></h2>
                                    <p class="blog-card__excerpt"><?= htmlspecialchars($featured['excerpt']) ?></p>
                                    <div class="blog-card__author">
                                        <img src="<?= htmlspecialchars($featured['author_img']) ?>" alt="<?= htmlspecialchars($featured['author_name']) ?>" class="blog-card__author-img">
                                        <div>
                                            <strong><?= htmlspecialchars($featured['author_name']) ?></strong>
                                            <span><?= htmlspecialchars($featured['author_role']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            <?php endif; ?>

            <!-- Blog Grid -->
            <?php if (!empty($posts)): ?>
            <div class="row gy-4">
                <?php foreach ($posts as $i => $post): ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= (($i % 3) + 1) * 100 ?>">
                    <article class="blog-card">
                        <div class="blog-card__image">
                            <img src="<?= htmlspecialchars($post['image_url']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="img-fluid">
                            <span class="blog-card__badge<?= $post['badge_color'] ? ' blog-card__badge--' . htmlspecialchars($post['badge_color']) : '' ?>"><?= htmlspecialchars($post['category']) ?></span>
                        </div>
                        <div class="blog-card__body">
                            <div class="blog-card__meta">
                                <span class="blog-card__date"><i class="bi bi-calendar3"></i> <?= date('F d, Y', strtotime($post['created_at'])) ?></span>
                                <span class="blog-card__read-time"><i class="bi bi-clock"></i> <?= htmlspecialchars($post['read_time']) ?></span>
                            </div>
                            <h3 class="blog-card__title"><?= htmlspecialchars($post['title']) ?></h3>
                            <p class="blog-card__excerpt"><?= htmlspecialchars($post['excerpt']) ?></p>
                            <div class="blog-card__author">
                                <img src="<?= htmlspecialchars($post['author_img']) ?>" alt="<?= htmlspecialchars($post['author_name']) ?>" class="blog-card__author-img">
                                <div>
                                    <strong><?= htmlspecialchars($post['author_name']) ?></strong>
                                    <span><?= htmlspecialchars($post['author_role']) ?></span>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <p style="color:#666;">No blog posts available at the moment. Check back soon!</p>
            </div>
            <?php endif; ?>

        </div>
    </section>
