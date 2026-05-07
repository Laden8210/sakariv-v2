<?php
require_once __DIR__ . '/../../database/init.php';
$db = getDB();
$jobs = $db->query("SELECT * FROM jobs WHERE status='published' ORDER BY created_at DESC")->fetchAll();
?>

    <!-- Page Title -->
    <section class="page-title dark-background" id="page-title" style="background-image: url('https://images.unsplash.com/photo-1551836022-4c4c79ecde51?auto=format&fit=crop&w=1920&q=80');">
        <div class="container position-relative">
            <h1>Career Opportunities</h1>
            <p style="font-size: 1.1rem; max-width: 600px; margin: 10px auto 0;">Join Sakari Management Group and make a meaningful impact in healthcare from anywhere in the world.</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Home</a></li>
                    <li class="current">Careers</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Why Join Us Section -->
    <section class="careers-why section light-background">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Careers</h2>
                <p>Why Join Sakari?</p>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="careers-perk">
                        <div class="careers-perk__icon">
                            <i class="bi bi-globe2"></i>
                        </div>
                        <h4>Work From Anywhere</h4>
                        <p>Enjoy the flexibility of remote work while making a real difference in patient care worldwide.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="careers-perk">
                        <div class="careers-perk__icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h4>Growth & Development</h4>
                        <p>Access continuous training, mentorship from U.S.-trained clinicians, and clear career progression paths.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="careers-perk">
                        <div class="careers-perk__icon">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        <h4>Meaningful Work</h4>
                        <p>Contribute directly to improving healthcare outcomes and supporting patients across the United States.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="careers-perk">
                        <div class="careers-perk__icon">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                        <h4>Competitive Pay</h4>
                        <p>Earn competitive compensation with performance bonuses, paid time off, and benefits that value your talent.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Job Listings Section -->
    <section id="careers" class="careers section">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Open Positions</h2>
                <p>Current Job Openings</p>
            </div>

            <?php
            // Get unique categories for filter buttons
            $categories = array_unique(array_column($jobs, 'category'));
            ?>

            <!-- Filter Tags -->
            <div class="careers-filters" data-aos="fade-up" data-aos-delay="100">
                <button class="careers-filter active" data-filter="all">All Positions</button>
                <?php foreach ($categories as $cat): ?>
                    <button class="careers-filter" data-filter="<?= htmlspecialchars($cat) ?>">
                        <?= htmlspecialchars(ucfirst($cat === 'admin' ? 'Administrative' : $cat)) ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Job Listings -->
            <?php if (!empty($jobs)): ?>
            <div class="row gy-4 mt-2">
                <?php foreach ($jobs as $i => $job): ?>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="<?= (($i % 2) + 1) * 100 ?>" data-category="<?= htmlspecialchars($job['category']) ?>">
                    <div class="job-card">
                        <div class="job-card__header">
                            <div class="job-card__type job-card__type--<?= strtolower(str_replace('-', '', $job['type'])) ?>"><?= htmlspecialchars($job['type']) ?></div>
                            <div class="job-card__posted">Posted <?= date('M d, Y', strtotime($job['created_at'])) ?></div>
                        </div>
                        <h3 class="job-card__title"><?= htmlspecialchars($job['title']) ?></h3>
                        <p class="job-card__company"><i class="bi bi-building"></i> Sakari Management Group</p>
                        <p class="job-card__description"><?= htmlspecialchars($job['description']) ?></p>
                        <div class="job-card__details">
                            <span><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($job['location']) ?></span>
                            <span><i class="bi bi-clock"></i> <?= htmlspecialchars($job['shift']) ?></span>
                            <span><i class="bi bi-cash"></i> <?= htmlspecialchars($job['salary']) ?></span>
                        </div>
                        <?php if (!empty($job['tags'])): ?>
                        <div class="job-card__tags">
                            <?php foreach (explode(',', $job['tags']) as $tag): ?>
                                <span class="job-tag"><?= htmlspecialchars(trim($tag)) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <a href="https://calendly.com/junettecacho-sakarimanagement/30min" target="_blank" class="job-card__apply">Apply Now <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <p style="color:#666;">No job openings available at the moment. Check back soon!</p>
            </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- CTA Section -->
    <section class="careers-cta section dark-background">
        <div class="container text-center" data-aos="zoom-in">
            <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem;">Don't see the right role?</h2>
            <p style="font-size: 1.1rem; max-width: 600px; margin: 0 auto 2rem; opacity: 0.85;">We're always looking for talented healthcare professionals. Send us your resume and we'll reach out when a matching position opens.</p>
            <a href="https://calendly.com/junettecacho-sakarimanagement/30min" target="_blank" class="btn btn-primary" style="font-size: 1rem;">
                <i class="fas fa-paper-plane"></i> Submit Your Resume
            </a>
        </div>
    </section>

    <script>
        // Job filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filters = document.querySelectorAll('.careers-filter');
            const jobs = document.querySelectorAll('[data-category]');

            filters.forEach(filter => {
                filter.addEventListener('click', function() {
                    filters.forEach(f => f.classList.remove('active'));
                    this.classList.add('active');

                    const category = this.getAttribute('data-filter');

                    jobs.forEach(job => {
                        if (category === 'all' || job.getAttribute('data-category') === category) {
                            job.style.display = '';
                            job.style.animation = 'fadeInUp 0.5s ease forwards';
                        } else {
                            job.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
