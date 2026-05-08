<?php
session_start();
require_once __DIR__ . '/../../database/init.php';

$isLocal = $_SERVER['HTTP_HOST'] === 'localhost';
$baseUrl = $isLocal ? '/sakari-v2/' : '/';

// Auth check
if (!isset($_SESSION['admin'])) {
    header('Location: ' . $baseUrl . 'admin-login?error=session');
    exit;
}

$db = getDB();
$uploadDir = __DIR__ . '/../../uploads/';
$maxFileSize = 5 * 1024 * 1024; // 5MB
$allowedTypes = [
    'image/jpeg'  => 'jpg',
    'image/png'   => 'png',
    'image/gif'   => 'gif',
    'image/webp'  => 'webp',
    'image/svg+xml' => 'svg',
];

// Handle AJAX requests (for API-style responses)
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

function jsonResponse($data, $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {
    switch ($action) {
        // ── Upload ─────────────────────────────────
        case 'upload':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method.');
            }

            if (empty($_FILES['files'])) {
                throw new Exception('No files selected.');
            }

            $files = $_FILES['files'];
            $folder = trim($_POST['folder'] ?? 'general');
            $uploadCount = 0;
            $errors = [];

            // Normalize files array for multiple uploads
            $fileCount = is_array($files['name']) ? count($files['name']) : 1;

            for ($i = 0; $i < $fileCount; $i++) {
                $name     = is_array($files['name']) ? $files['name'][$i] : $files['name'];
                $tmpName  = is_array($files['tmp_name']) ? $files['tmp_name'][$i] : $files['tmp_name'];
                $error    = is_array($files['error']) ? $files['error'][$i] : $files['error'];
                $size     = is_array($files['size']) ? $files['size'][$i] : $files['size'];
                $type     = is_array($files['type']) ? $files['type'][$i] : $files['type'];

                if ($error !== UPLOAD_ERR_OK) {
                    $errors[] = "$name: Upload error (code $error)";
                    continue;
                }

                if ($size > $maxFileSize) {
                    $errors[] = "$name: File too large (max 5MB)";
                    continue;
                }

                // Verify MIME type
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $realType = finfo_file($finfo, $tmpName);
                finfo_close($finfo);

                if (!isset($allowedTypes[$realType])) {
                    $errors[] = "$name: Invalid file type ($realType). Allowed: JPG, PNG, GIF, WebP, SVG";
                    continue;
                }

                $ext = $allowedTypes[$realType];
                $uniqueName = uniqid('asset_', true) . '.' . $ext;
                $destPath = $uploadDir . $uniqueName;

                if (!move_uploaded_file($tmpName, $destPath)) {
                    $errors[] = "$name: Failed to save file.";
                    continue;
                }

                // Get image dimensions
                $width = null;
                $height = null;
                if ($realType !== 'image/svg+xml') {
                    $dims = @getimagesize($destPath);
                    if ($dims) {
                        $width = $dims[0];
                        $height = $dims[1];
                    }
                }

                // Save to database
                $stmt = $db->prepare("INSERT INTO assets (filename, original_name, mime_type, file_size, width, height, alt_text, folder, uploaded_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $uniqueName,
                    $name,
                    $realType,
                    $size,
                    $width,
                    $height,
                    pathinfo($name, PATHINFO_FILENAME), // Default alt text from filename
                    $folder,
                    $_SESSION['admin']['id'] ?? null,
                ]);

                $uploadCount++;
            }

            if ($isAjax) {
                jsonResponse([
                    'success' => $uploadCount > 0,
                    'uploaded' => $uploadCount,
                    'errors' => $errors,
                ]);
            }

            if ($uploadCount > 0) {
                $_SESSION['flash_success'] = "$uploadCount file(s) uploaded successfully!" . (!empty($errors) ? ' Some files had errors.' : '');
            }
            if (!empty($errors)) {
                $_SESSION['flash_error'] = implode(' | ', $errors);
            }
            break;

        // ── Delete ─────────────────────────────────
        case 'delete':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method.');
            }

            $id = intval($_POST['id'] ?? 0);
            if ($id <= 0) throw new Exception('Invalid asset ID.');

            $stmt = $db->prepare("SELECT filename FROM assets WHERE id = ?");
            $stmt->execute([$id]);
            $asset = $stmt->fetch();

            if (!$asset) throw new Exception('Asset not found.');

            // Delete file from disk
            $filePath = $uploadDir . $asset['filename'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete from database
            $db->prepare("DELETE FROM assets WHERE id = ?")->execute([$id]);

            if ($isAjax) {
                jsonResponse(['success' => true, 'message' => 'Asset deleted.']);
            }

            $_SESSION['flash_success'] = 'Asset deleted successfully!';
            break;

        // ── Update alt text ────────────────────────
        case 'update_alt':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method.');
            }

            $id = intval($_POST['id'] ?? 0);
            $altText = trim($_POST['alt_text'] ?? '');

            $db->prepare("UPDATE assets SET alt_text = ? WHERE id = ?")->execute([$altText, $id]);

            if ($isAjax) {
                jsonResponse(['success' => true]);
            }

            $_SESSION['flash_success'] = 'Alt text updated!';
            break;

        // ── List (AJAX) ────────────────────────────
        case 'list':
            $folder = $_GET['folder'] ?? '';
            $search = $_GET['search'] ?? '';

            $sql = "SELECT * FROM assets WHERE 1=1";
            $params = [];

            if ($folder && $folder !== 'all') {
                $sql .= " AND folder = ?";
                $params[] = $folder;
            }
            if ($search) {
                $sql .= " AND (original_name LIKE ? OR alt_text LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }

            $sql .= " ORDER BY created_at DESC";

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $assets = $stmt->fetchAll();

            // Add URL to each asset
            foreach ($assets as &$a) {
                $a['url'] = $baseUrl . 'uploads/' . $a['filename'];
            }

            jsonResponse(['success' => true, 'assets' => $assets]);
            break;

        default:
            throw new Exception('Unknown action.');
    }
} catch (Exception $e) {
    if ($isAjax) {
        jsonResponse(['success' => false, 'error' => $e->getMessage()], 400);
    }
    $_SESSION['flash_error'] = 'Error: ' . $e->getMessage();
}

header('Location: ' . $baseUrl . 'admin-assets');
exit;
