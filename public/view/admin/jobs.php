<?php
require_once __DIR__ . '/../../../database/init.php';
$db = getDB();
$baseUrl = $GLOBALS['baseUrl'] ?? '/';
$jobs = $db->query("SELECT * FROM jobs ORDER BY created_at DESC")->fetchAll();
$published = array_filter($jobs, fn($j) => $j['status'] === 'published');
$drafts = array_filter($jobs, fn($j) => $j['status'] === 'draft');
?>

<!-- Page Header -->
<div class="page-header-bar">
    <div>
        <p class="page-subtitle"><?= count($jobs) ?> total · <?= count($published) ?> active · <?= count($drafts) ?> drafts</p>
    </div>
    <button class="btn-admin btn-admin-primary" onclick="openModal('jobModal'); resetJobForm();">
        <i class="bi bi-plus-lg"></i> New Job
    </button>
</div>

<!-- Job Cards Grid -->
<?php if (empty($jobs)): ?>
    <div class="empty-state">
        <i class="bi bi-briefcase"></i>
        <h4>No job postings yet</h4>
        <p>Create your first job posting to get started</p>
    </div>
<?php else: ?>
<div class="content-cards-grid content-cards-grid--jobs">
    <?php foreach ($jobs as $job): ?>
    <div class="content-card content-card--job">
        <!-- Card Header with type badge -->
        <div class="content-card__job-header">
            <div class="content-card__badges">
                <span class="badge badge-<?= strtolower(str_replace('-', '', $job['type'])) ?>"><?= htmlspecialchars($job['type']) ?></span>
                <span class="badge badge-<?= $job['status'] ?>"><?= $job['status'] ?></span>
            </div>
            <span class="content-card__date"><?= date('M d, Y', strtotime($job['created_at'])) ?></span>
        </div>

        <!-- Card Body -->
        <div class="content-card__body">
            <span class="content-card__category"><?= htmlspecialchars(ucfirst($job['category'] === 'admin' ? 'Administrative' : $job['category'])) ?></span>
            <h3 class="content-card__title"><?= htmlspecialchars($job['title']) ?></h3>
            <p class="content-card__excerpt"><?= htmlspecialchars(mb_strimwidth($job['description'] ?? '', 0, 120, '...')) ?></p>

            <div class="content-card__job-details">
                <span><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($job['location'] ?: 'Remote') ?></span>
                <span><i class="bi bi-clock"></i> <?= htmlspecialchars($job['shift'] ?: 'Flexible') ?></span>
                <?php if ($job['salary']): ?>
                    <span><i class="bi bi-cash"></i> <?= htmlspecialchars($job['salary']) ?></span>
                <?php endif; ?>
            </div>

            <?php if (!empty($job['tags'])): ?>
            <div class="content-card__tags">
                <?php foreach (array_slice(explode(',', $job['tags']), 0, 3) as $tag): ?>
                    <span class="job-tag-sm"><?= htmlspecialchars(trim($tag)) ?></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Card Actions -->
        <div class="content-card__actions">
            <button class="btn-admin btn-admin-sm btn-admin-edit" onclick="editJob(<?= htmlspecialchars(json_encode($job), ENT_QUOTES, 'UTF-8') ?>)">
                <i class="bi bi-pencil"></i> Edit
            </button>
            <form method="POST" action="<?= $baseUrl ?>forms/admin/job_handler.php" style="display:inline;" onsubmit="return confirm('Delete this job posting?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $job['id'] ?>">
                <button type="submit" class="btn-admin btn-admin-sm btn-admin-delete">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Job Modal -->
<div class="admin-modal-overlay" id="jobModal">
    <div class="admin-modal admin-modal--lg">
        <div class="modal-header">
            <div>
                <h3 id="jobModalTitle">New Job Posting</h3>
                <p class="modal-subtitle">Fill in the details to create a new job listing</p>
            </div>
            <button class="modal-close" onclick="closeModal('jobModal')"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="jobForm" method="POST" action="<?= $baseUrl ?>forms/admin/job_handler.php">
            <input type="hidden" name="action" id="jobAction" value="create">
            <input type="hidden" name="id" id="jobId" value="">
            <div class="modal-body">

                <!-- Section: Job Info -->
                <div class="form-section">
                    <div class="form-section__header">
                        <i class="bi bi-briefcase"></i>
                        <h4>Job Information</h4>
                    </div>
                    <div class="form-group">
                        <label for="jobTitle">Job Title <span class="required">*</span></label>
                        <input type="text" name="title" id="jobTitle" class="form-control" required placeholder="e.g. Virtual Utilization Management Nurse">
                    </div>
                    <div class="form-group">
                        <label for="jobDescription">Description <span class="required">*</span></label>
                        <textarea name="description" id="jobDescription" class="form-control" rows="4" required placeholder="Describe the role responsibilities, requirements, and what the ideal candidate looks like..."></textarea>
                    </div>
                </div>

                <!-- Section: Job Details -->
                <div class="form-section">
                    <div class="form-section__header">
                        <i class="bi bi-gear"></i>
                        <h4>Job Details</h4>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="jobType">Employment Type</label>
                            <select name="type" id="jobType" class="form-control">
                                <option value="Full-time">🕐 Full-time</option>
                                <option value="Part-time">⏰ Part-time</option>
                                <option value="Contract">📋 Contract</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jobCategory">Department</label>
                            <select name="category" id="jobCategory" class="form-control">
                                <option value="clinical">🏥 Clinical</option>
                                <option value="admin">📁 Administrative</option>
                                <option value="sales">📈 Sales & Marketing</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="jobLocation">Location</label>
                            <input type="text" name="location" id="jobLocation" class="form-control" value="Remote (Philippines)" placeholder="Remote (Philippines)">
                        </div>
                        <div class="form-group">
                            <label for="jobShift">Work Schedule</label>
                            <input type="text" name="shift" id="jobShift" class="form-control" placeholder="e.g. Night Shift (US Hours)">
                        </div>
                    </div>
                </div>

                <!-- Section: Compensation -->
                <div class="form-section">
                    <div class="form-section__header">
                        <i class="bi bi-cash-coin"></i>
                        <h4>Compensation & Tags</h4>
                    </div>
                    <div class="form-group">
                        <label for="jobSalary">Salary Range</label>
                        <input type="text" name="salary" id="jobSalary" class="form-control" placeholder="e.g. ₱40,000 - ₱55,000/mo">
                    </div>
                    <div class="form-group">
                        <label for="jobTags">Required Skills / Tags</label>
                        <input type="text" name="tags" id="jobTags" class="form-control" placeholder="e.g. RN License, MCG/InterQual, UM Experience">
                        <small class="form-help">Separate tags with commas. These appear as skill badges on the listing.</small>
                    </div>
                </div>

                <!-- Section: Publishing -->
                <div class="form-section">
                    <div class="form-section__header">
                        <i class="bi bi-send"></i>
                        <h4>Publishing</h4>
                    </div>
                    <div class="form-group">
                        <label for="jobStatus">Status</label>
                        <select name="status" id="jobStatus" class="form-control">
                            <option value="published">✅ Published — Visible on careers page</option>
                            <option value="draft">📝 Draft — Hidden from public</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-admin btn-admin-outline" onclick="closeModal('jobModal')">Cancel</button>
                <button type="submit" class="btn-admin btn-admin-primary" id="jobSubmitBtn"><i class="bi bi-check-lg"></i> Create Job</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('active'); document.body.style.overflow='hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('active'); document.body.style.overflow=''; }
function resetJobForm() {
    document.getElementById('jobForm').reset();
    document.getElementById('jobAction').value = 'create';
    document.getElementById('jobId').value = '';
    document.getElementById('jobModalTitle').textContent = 'New Job Posting';
    document.querySelector('#jobModal .modal-subtitle').textContent = 'Fill in the details to create a new job listing';
    document.getElementById('jobSubmitBtn').innerHTML = '<i class="bi bi-check-lg"></i> Create Job';
    document.getElementById('jobLocation').value = 'Remote (Philippines)';
}
function editJob(job) {
    document.getElementById('jobAction').value = 'update';
    document.getElementById('jobId').value = job.id;
    document.getElementById('jobTitle').value = job.title || '';
    document.getElementById('jobDescription').value = job.description || '';
    document.getElementById('jobType').value = job.type || 'Full-time';
    document.getElementById('jobCategory').value = job.category || 'clinical';
    document.getElementById('jobLocation').value = job.location || '';
    document.getElementById('jobShift').value = job.shift || '';
    document.getElementById('jobSalary').value = job.salary || '';
    document.getElementById('jobTags').value = job.tags || '';
    document.getElementById('jobStatus').value = job.status || 'published';
    document.getElementById('jobModalTitle').textContent = 'Edit Job Posting';
    document.querySelector('#jobModal .modal-subtitle').textContent = 'Update the job details below';
    document.getElementById('jobSubmitBtn').innerHTML = '<i class="bi bi-check-lg"></i> Update Job';
    openModal('jobModal');
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal('jobModal'); });
</script>
