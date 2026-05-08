<?php
require_once __DIR__ . '/../../../database/init.php';
$db = getDB();
$baseUrl = $GLOBALS['baseUrl'] ?? '/';

// Fetch all assets
$assets = $db->query("SELECT * FROM assets ORDER BY created_at DESC")->fetchAll();
$totalSize = array_sum(array_column($assets, 'file_size'));

// Get unique folders for filter
$folders = $db->query("SELECT DISTINCT folder FROM assets ORDER BY folder ASC")->fetchAll(PDO::FETCH_COLUMN);
?>

<!-- Page Header -->
<div class="page-header-bar">
    <div>
        <p class="page-subtitle"><?= count($assets) ?> files · <?= formatBytes($totalSize) ?> total</p>
    </div>
    <button class="btn-admin btn-admin-primary" onclick="openUploadModal()">
        <i class="bi bi-cloud-upload"></i> Upload Files
    </button>
</div>

<!-- Filter Bar -->
<div class="asset-filter-bar">
    <div class="asset-filter-group">
        <button class="asset-filter-btn active" data-folder="all" onclick="filterAssets('all', this)">
            <i class="bi bi-grid-3x3-gap"></i> All
        </button>
        <?php foreach ($folders as $f): ?>
        <button class="asset-filter-btn" data-folder="<?= htmlspecialchars($f) ?>" onclick="filterAssets('<?= htmlspecialchars($f) ?>', this)">
            <i class="bi bi-folder"></i> <?= ucfirst(htmlspecialchars($f)) ?>
        </button>
        <?php endforeach; ?>
    </div>
    <div class="asset-search-box">
        <i class="bi bi-search"></i>
        <input type="text" id="assetSearch" placeholder="Search files..." oninput="debounceSearch()">
    </div>
</div>

<!-- Assets Grid -->
<?php if (empty($assets)): ?>
    <div class="empty-state">
        <i class="bi bi-cloud-upload"></i>
        <h4>No assets uploaded yet</h4>
        <p>Upload your first image to get started</p>
    </div>
<?php else: ?>
<div class="assets-grid" id="assetsGrid">
    <?php foreach ($assets as $asset): ?>
    <div class="asset-card" data-id="<?= $asset['id'] ?>" data-folder="<?= htmlspecialchars($asset['folder']) ?>" data-name="<?= htmlspecialchars($asset['original_name']) ?>">
        <div class="asset-card__preview" onclick="openAssetDetail(<?= htmlspecialchars(json_encode($asset), ENT_QUOTES, 'UTF-8') ?>)">
            <img src="<?= $baseUrl ?>uploads/<?= htmlspecialchars($asset['filename']) ?>" alt="<?= htmlspecialchars($asset['alt_text']) ?>" loading="lazy">
            <div class="asset-card__overlay">
                <i class="bi bi-eye"></i>
            </div>
        </div>
        <div class="asset-card__info">
            <span class="asset-card__name" title="<?= htmlspecialchars($asset['original_name']) ?>"><?= htmlspecialchars(mb_strimwidth($asset['original_name'], 0, 25, '...')) ?></span>
            <span class="asset-card__size"><?= formatBytes($asset['file_size']) ?></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Upload Modal -->
<div class="admin-modal-overlay" id="uploadModal">
    <div class="admin-modal" style="max-width: 560px;">
        <div class="admin-modal__header">
            <h3><i class="bi bi-cloud-upload"></i> Upload Files</h3>
            <button class="admin-modal__close" onclick="closeModal('uploadModal')">&times;</button>
        </div>
        <form method="POST" action="<?= $baseUrl ?>forms/admin/asset_handler.php" enctype="multipart/form-data" id="uploadForm">
            <input type="hidden" name="action" value="upload">
            <div class="admin-modal__body">
                <!-- Drag & Drop Zone -->
                <div class="upload-dropzone" id="dropzone">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <h4>Drag & drop files here</h4>
                    <p>or click to browse</p>
                    <span class="upload-dropzone__hint">JPG, PNG, GIF, WebP, SVG · Max 5MB each</span>
                    <input type="file" name="files[]" id="fileInput" multiple accept="image/*" class="upload-dropzone__input">
                </div>

                <!-- Preview Area -->
                <div class="upload-preview" id="uploadPreview" style="display: none;">
                    <div class="upload-preview__list" id="previewList"></div>
                </div>

                <!-- Folder Selection -->
                <div class="form-row" style="margin-top: 16px;">
                    <label class="form-label">Folder</label>
                    <select name="folder" class="form-input">
                        <option value="general">General</option>
                        <option value="blog">Blog</option>
                        <option value="team">Team</option>
                        <option value="careers">Careers</option>
                        <option value="branding">Branding</option>
                    </select>
                </div>
            </div>
            <div class="admin-modal__footer">
                <button type="button" class="btn-admin btn-admin-secondary" onclick="closeModal('uploadModal')">Cancel</button>
                <button type="submit" class="btn-admin btn-admin-primary" id="uploadBtn" disabled>
                    <i class="bi bi-upload"></i> Upload
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Asset Detail Modal -->
<div class="admin-modal-overlay" id="detailModal">
    <div class="admin-modal" style="max-width: 720px;">
        <div class="admin-modal__header">
            <h3><i class="bi bi-image"></i> Asset Details</h3>
            <button class="admin-modal__close" onclick="closeModal('detailModal')">&times;</button>
        </div>
        <div class="admin-modal__body">
            <div class="asset-detail">
                <div class="asset-detail__preview">
                    <img id="detailImg" src="" alt="">
                </div>
                <div class="asset-detail__info">
                    <div class="asset-detail__row">
                        <label>Filename</label>
                        <span id="detailName"></span>
                    </div>
                    <div class="asset-detail__row">
                        <label>Dimensions</label>
                        <span id="detailDims"></span>
                    </div>
                    <div class="asset-detail__row">
                        <label>Size</label>
                        <span id="detailSize"></span>
                    </div>
                    <div class="asset-detail__row">
                        <label>Type</label>
                        <span id="detailType"></span>
                    </div>
                    <div class="asset-detail__row">
                        <label>Uploaded</label>
                        <span id="detailDate"></span>
                    </div>

                    <!-- URL Copy -->
                    <div class="asset-detail__url-box">
                        <label>Image URL</label>
                        <div class="asset-detail__url-input">
                            <input type="text" id="detailUrl" readonly>
                            <button type="button" class="btn-admin btn-admin-sm btn-admin-primary" onclick="copyUrl()">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="asset-detail__actions">
                        <a id="detailDownload" href="" download class="btn-admin btn-admin-sm btn-admin-edit">
                            <i class="bi bi-download"></i> Download
                        </a>
                        <form method="POST" action="<?= $baseUrl ?>forms/admin/asset_handler.php" style="display:inline;" onsubmit="return confirm('Delete this asset permanently?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" id="detailDeleteId" value="">
                            <button type="submit" class="btn-admin btn-admin-sm btn-admin-delete">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function formatBytes($bytes, $precision = 1) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    return round($bytes / pow(1024, $pow), $precision) . ' ' . $units[$pow];
}
?>

<script>
// ── Upload Modal ───────────────────────────────
function openUploadModal() {
    openModal('uploadModal');
    resetUpload();
}

function resetUpload() {
    document.getElementById('fileInput').value = '';
    document.getElementById('previewList').innerHTML = '';
    document.getElementById('uploadPreview').style.display = 'none';
    document.getElementById('uploadBtn').disabled = true;
}

// Drag & drop
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('fileInput');

dropzone.addEventListener('click', () => fileInput.click());

dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('dragover');
});

dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('dragover');
});

dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    fileInput.files = e.dataTransfer.files;
    showPreviews(fileInput.files);
});

fileInput.addEventListener('change', () => {
    showPreviews(fileInput.files);
});

function showPreviews(files) {
    const list = document.getElementById('previewList');
    const preview = document.getElementById('uploadPreview');
    list.innerHTML = '';

    if (files.length === 0) {
        preview.style.display = 'none';
        document.getElementById('uploadBtn').disabled = true;
        return;
    }

    preview.style.display = 'block';
    document.getElementById('uploadBtn').disabled = false;

    Array.from(files).forEach(file => {
        const item = document.createElement('div');
        item.className = 'upload-preview__item';

        const reader = new FileReader();
        reader.onload = (e) => {
            item.innerHTML = `
                <img src="${e.target.result}" alt="">
                <div class="upload-preview__info">
                    <strong>${file.name}</strong>
                    <span>${(file.size / 1024).toFixed(1)} KB</span>
                </div>
            `;
        };
        reader.readAsDataURL(file);
        list.appendChild(item);
    });
}

// ── Asset Detail ───────────────────────────────
function openAssetDetail(asset) {
    const baseUrl = '<?= $baseUrl ?>';
    const url = baseUrl + 'uploads/' + asset.filename;

    document.getElementById('detailImg').src = url;
    document.getElementById('detailName').textContent = asset.original_name;
    document.getElementById('detailDims').textContent = asset.width && asset.height ? asset.width + ' × ' + asset.height + ' px' : 'N/A';
    document.getElementById('detailSize').textContent = formatBytesJS(asset.file_size);
    document.getElementById('detailType').textContent = asset.mime_type;
    document.getElementById('detailDate').textContent = new Date(asset.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    document.getElementById('detailUrl').value = window.location.origin + url;
    document.getElementById('detailDownload').href = url;
    document.getElementById('detailDeleteId').value = asset.id;

    openModal('detailModal');
}

function copyUrl() {
    const input = document.getElementById('detailUrl');
    input.select();
    navigator.clipboard.writeText(input.value).then(() => {
        const btn = input.nextElementSibling;
        btn.innerHTML = '<i class="bi bi-check-lg"></i>';
        btn.classList.add('copied');
        setTimeout(() => {
            btn.innerHTML = '<i class="bi bi-clipboard"></i>';
            btn.classList.remove('copied');
        }, 2000);
    });
}

function formatBytesJS(bytes) {
    if (bytes === 0) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
}

// ── Filter & Search ────────────────────────────
function filterAssets(folder, btn) {
    document.querySelectorAll('.asset-filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.asset-card').forEach(card => {
        if (folder === 'all' || card.dataset.folder === folder) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

let searchTimeout;
function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        const q = document.getElementById('assetSearch').value.toLowerCase();
        document.querySelectorAll('.asset-card').forEach(card => {
            const name = card.dataset.name.toLowerCase();
            card.style.display = name.includes(q) ? '' : 'none';
        });
    }, 250);
}
</script>
