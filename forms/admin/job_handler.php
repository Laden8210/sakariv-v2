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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $baseUrl . 'admin-jobs');
    exit;
}

$db = getDB();
$action = $_POST['action'] ?? '';
$id = $_POST['id'] ?? '';

try {
    switch ($action) {
        case 'create':
            $stmt = $db->prepare("INSERT INTO jobs (title, description, type, category, location, shift, salary, tags, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                trim($_POST['title']),
                trim($_POST['description'] ?? ''),
                $_POST['type'] ?? 'Full-time',
                $_POST['category'] ?? 'clinical',
                trim($_POST['location'] ?? 'Remote (Philippines)'),
                trim($_POST['shift'] ?? ''),
                trim($_POST['salary'] ?? ''),
                trim($_POST['tags'] ?? ''),
                $_POST['status'] ?? 'published',
            ]);
            $_SESSION['flash_success'] = 'Job posting created successfully!';
            break;

        case 'update':
            $stmt = $db->prepare("UPDATE jobs SET title=?, description=?, type=?, category=?, location=?, shift=?, salary=?, tags=?, status=?, updated_at=CURRENT_TIMESTAMP WHERE id=?");
            $stmt->execute([
                trim($_POST['title']),
                trim($_POST['description'] ?? ''),
                $_POST['type'] ?? 'Full-time',
                $_POST['category'] ?? 'clinical',
                trim($_POST['location'] ?? 'Remote (Philippines)'),
                trim($_POST['shift'] ?? ''),
                trim($_POST['salary'] ?? ''),
                trim($_POST['tags'] ?? ''),
                $_POST['status'] ?? 'published',
                $id,
            ]);
            $_SESSION['flash_success'] = 'Job posting updated successfully!';
            break;

        case 'delete':
            $stmt = $db->prepare("DELETE FROM jobs WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['flash_success'] = 'Job posting deleted successfully!';
            break;

        default:
            $_SESSION['flash_error'] = 'Unknown action.';
    }
} catch (Exception $e) {
    $_SESSION['flash_error'] = 'Error: ' . $e->getMessage();
}

header('Location: ' . $baseUrl . 'admin-jobs');
exit;
