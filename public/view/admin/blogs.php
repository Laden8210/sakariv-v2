<?php
require_once __DIR__ . '/../../../database/init.php';
$db = getDB();
$baseUrl = $GLOBALS['baseUrl'] ?? '/';
$blogs = $db->query("SELECT * FROM blog_posts ORDER BY created_at DESC")->fetchAll();
$published = array_filter($blogs, fn($b) => $b['status'] === 'published');
$drafts = array_filter($blogs, fn($b) => $b['status'] === 'draft');
?>

<!-- Page Header -->
<div class="page-header-bar">
    <div>
        <p class="page-subtitle"><?= count($blogs) ?> total · <?= count($published) ?> published · <?= count($drafts) ?> drafts</p>
    </div>
    <button class="btn-admin btn-admin-primary" onclick="openModal('blogModal'); resetForm();">
        <i class="bi bi-plus-lg"></i> New Post
    </button>
</div>

<!-- Blog Cards Grid -->
<?php if (empty($blogs)): ?>
    <div class="empty-state">
        <i class="bi bi-journal-x"></i>
        <h4>No blog posts yet</h4>
        <p>Create your first blog post to get started</p>
    </div>
<?php else: ?>
<div class="content-cards-grid">
    <?php foreach ($blogs as $blog): ?>
    <div class="content-card">
        <!-- Card Image -->
        <div class="content-card__img">
            <?php if ($blog['image_url']): ?>
                <img src="<?= htmlspecialchars($blog['image_url']) ?>" alt="<?= htmlspecialchars($blog['title']) ?>">
            <?php else: ?>
                <div class="content-card__img-placeholder"><i class="bi bi-image"></i></div>
            <?php endif; ?>
            <div class="content-card__badges">
                <span class="badge badge-<?= $blog['status'] ?>"><?= $blog['status'] ?></span>
                <?php if ($blog['is_featured']): ?>
                    <span class="badge badge-featured">★ Featured</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Card Body -->
        <div class="content-card__body">
            <span class="content-card__category"><?= htmlspecialchars($blog['category']) ?></span>
            <h3 class="content-card__title"><?= htmlspecialchars($blog['title']) ?></h3>
            <p class="content-card__excerpt"><?= htmlspecialchars(mb_strimwidth($blog['excerpt'] ?? '', 0, 100, '...')) ?></p>

            <div class="content-card__meta">
                <?php if ($blog['author_img']): ?>
                    <img src="<?= htmlspecialchars($blog['author_img']) ?>" alt="" class="content-card__avatar">
                <?php endif; ?>
                <div>
                    <strong><?= htmlspecialchars($blog['author_name'] ?: 'Unknown') ?></strong>
                    <span><?= date('M d, Y', strtotime($blog['created_at'])) ?> · <?= htmlspecialchars($blog['read_time'] ?: '5 min read') ?></span>
                </div>
            </div>
        </div>

        <!-- Card Actions -->
        <div class="content-card__actions">
            <button class="btn-admin btn-admin-sm btn-admin-edit" onclick="editBlog(<?= htmlspecialchars(json_encode($blog), ENT_QUOTES, 'UTF-8') ?>)">
                <i class="bi bi-pencil"></i> Edit
            </button>
            <form method="POST" action="<?= $baseUrl ?>forms/admin/blog_handler.php" style="display:inline;" onsubmit="return confirm('Delete this post?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $blog['id'] ?>">
                <button type="submit" class="btn-admin btn-admin-sm btn-admin-delete">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Blog Modal -->
<div class="admin-modal-overlay" id="blogModal">
    <div class="admin-modal admin-modal--lg">
        <div class="modal-header">
            <div>
                <h3 id="blogModalTitle">New Blog Post</h3>
                <p class="modal-subtitle">Fill in the details below to create a new post</p>
            </div>
            <button class="modal-close" onclick="closeModal('blogModal')"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="blogForm" method="POST" action="<?= $baseUrl ?>forms/admin/blog_handler.php">
            <input type="hidden" name="action" id="blogAction" value="create">
            <input type="hidden" name="id" id="blogId" value="">
            <div class="modal-body">

                <!-- Section: Basic Info -->
                <div class="form-section">
                    <div class="form-section__header">
                        <i class="bi bi-info-circle"></i>
                        <h4>Basic Information</h4>
                    </div>
                    <div class="form-group">
                        <label for="blogTitle">Title <span class="required">*</span></label>
                        <input type="text" name="title" id="blogTitle" class="form-control" required placeholder="Enter a compelling blog post title">
                    </div>
                    <div class="form-group">
                        <label for="blogExcerpt">Excerpt <span class="required">*</span></label>
                        <textarea name="excerpt" id="blogExcerpt" class="form-control" rows="2" required placeholder="Brief summary that appears on the blog listing page"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="blogContent">Full Content</label>
                        <textarea name="content" id="blogContent" class="form-control" rows="5" placeholder="Write the full blog post content here..."></textarea>
                    </div>
                </div>

                <!-- Section: Classification -->
                <div class="form-section">
                    <div class="form-section__header">
                        <i class="bi bi-tags"></i>
                        <h4>Classification</h4>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="blogCategory">Category</label>
                            <select name="category" id="blogCategory" class="form-control">
                                <option value="Healthcare">Healthcare</option>
                                <option value="Industry Trends">Industry Trends</option>
                                <option value="Best Practices">Best Practices</option>
                                <option value="Cost Savings">Cost Savings</option>
                                <option value="Leadership">Leadership</option>
                                <option value="Guides">Guides</option>
                                <option value="General">General</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="blogBadgeColor">Badge Color</label>
                            <div class="color-picker-row">
                                <select name="badge_color" id="blogBadgeColor" class="form-control">
                                    <option value="">Default (Accent)</option>
                                    <option value="blue">Blue</option>
                                    <option value="green">Green</option>
                                    <option value="purple">Purple</option>
                                    <option value="orange">Orange</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="blogStatus">Status</label>
                            <select name="status" id="blogStatus" class="form-control">
                                <option value="published">✅ Published</option>
                                <option value="draft">📝 Draft</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="blogFeatured">Featured Post</label>
                            <select name="is_featured" id="blogFeatured" class="form-control">
                                <option value="0">No</option>
                                <option value="1">⭐ Yes — Show as featured</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section: Media -->
                <div class="form-section">
                    <div class="form-section__header">
                        <i class="bi bi-image"></i>
                        <h4>Media</h4>
                    </div>
                    <div class="form-group">
                        <label for="blogImageUrl">Cover Image URL</label>
                        <input type="url" name="image_url" id="blogImageUrl" class="form-control" placeholder="https://images.unsplash.com/photo-...">
                        <small class="form-help">Use a direct link to an image (recommended: 800×500px)</small>
                    </div>
                    <div class="form-group">
                        <label for="blogReadTime">Read Time</label>
                        <input type="text" name="read_time" id="blogReadTime" class="form-control" value="5 min read" placeholder="5 min read">
                    </div>
                </div>

                <!-- Section: Author -->
                <div class="form-section">
                    <div class="form-section__header">
                        <i class="bi bi-person"></i>
                        <h4>Author</h4>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="blogAuthorName">Name</label>
                            <input type="text" name="author_name" id="blogAuthorName" class="form-control" placeholder="Van Cacho FNP-BC">
                        </div>
                        <div class="form-group">
                            <label for="blogAuthorRole">Role</label>
                            <input type="text" name="author_role" id="blogAuthorRole" class="form-control" placeholder="CEO & Co-Founder">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="blogAuthorImg">Author Image Path</label>
                        <input type="text" name="author_img" id="blogAuthorImg" class="form-control" placeholder="assets/img/team/van.jpg">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-admin btn-admin-outline" onclick="closeModal('blogModal')">Cancel</button>
                <button type="submit" class="btn-admin btn-admin-primary" id="blogSubmitBtn"><i class="bi bi-check-lg"></i> Create Post</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('active'); document.body.style.overflow='hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('active'); document.body.style.overflow=''; }
function resetForm() {
    document.getElementById('blogForm').reset();
    document.getElementById('blogAction').value = 'create';
    document.getElementById('blogId').value = '';
    document.getElementById('blogModalTitle').textContent = 'New Blog Post';
    document.querySelector('#blogModal .modal-subtitle').textContent = 'Fill in the details below to create a new post';
    document.getElementById('blogSubmitBtn').innerHTML = '<i class="bi bi-check-lg"></i> Create Post';
}
function editBlog(blog) {
    document.getElementById('blogAction').value = 'update';
    document.getElementById('blogId').value = blog.id;
    document.getElementById('blogTitle').value = blog.title || '';
    document.getElementById('blogExcerpt').value = blog.excerpt || '';
    document.getElementById('blogContent').value = blog.content || '';
    document.getElementById('blogCategory').value = blog.category || 'General';
    document.getElementById('blogBadgeColor').value = blog.badge_color || '';
    document.getElementById('blogImageUrl').value = blog.image_url || '';
    document.getElementById('blogAuthorName').value = blog.author_name || '';
    document.getElementById('blogAuthorRole').value = blog.author_role || '';
    document.getElementById('blogAuthorImg').value = blog.author_img || '';
    document.getElementById('blogReadTime').value = blog.read_time || '5 min read';
    document.getElementById('blogStatus').value = blog.status || 'published';
    document.getElementById('blogFeatured').value = blog.is_featured || '0';
    document.getElementById('blogModalTitle').textContent = 'Edit Blog Post';
    document.querySelector('#blogModal .modal-subtitle').textContent = 'Update the details below';
    document.getElementById('blogSubmitBtn').innerHTML = '<i class="bi bi-check-lg"></i> Update Post';
    openModal('blogModal');
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal('blogModal'); });
</script>
