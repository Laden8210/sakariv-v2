<?php
session_start();
require_once __DIR__ . '/../../database/init.php';

// Auth check
if (!isset($_SESSION['admin'])) {
    header('Location: /admin-login?error=session');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin-blogs');
    exit;
}

$db = getDB();
$action = $_POST['action'] ?? '';
$id = $_POST['id'] ?? '';

try {
    switch ($action) {
        case 'create':
            $stmt = $db->prepare("INSERT INTO blog_posts (title, excerpt, content, category, badge_color, image_url, author_name, author_role, author_img, read_time, is_featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                trim($_POST['title']),
                trim($_POST['excerpt'] ?? ''),
                trim($_POST['content'] ?? ''),
                $_POST['category'] ?? 'General',
                $_POST['badge_color'] ?? '',
                trim($_POST['image_url'] ?? ''),
                trim($_POST['author_name'] ?? ''),
                trim($_POST['author_role'] ?? ''),
                trim($_POST['author_img'] ?? ''),
                $_POST['read_time'] ?? '5 min read',
                intval($_POST['is_featured'] ?? 0),
                $_POST['status'] ?? 'published',
            ]);
            $_SESSION['flash_success'] = 'Blog post created successfully!';
            break;

        case 'update':
            $stmt = $db->prepare("UPDATE blog_posts SET title=?, excerpt=?, content=?, category=?, badge_color=?, image_url=?, author_name=?, author_role=?, author_img=?, read_time=?, is_featured=?, status=?, updated_at=CURRENT_TIMESTAMP WHERE id=?");
            $stmt->execute([
                trim($_POST['title']),
                trim($_POST['excerpt'] ?? ''),
                trim($_POST['content'] ?? ''),
                $_POST['category'] ?? 'General',
                $_POST['badge_color'] ?? '',
                trim($_POST['image_url'] ?? ''),
                trim($_POST['author_name'] ?? ''),
                trim($_POST['author_role'] ?? ''),
                trim($_POST['author_img'] ?? ''),
                $_POST['read_time'] ?? '5 min read',
                intval($_POST['is_featured'] ?? 0),
                $_POST['status'] ?? 'published',
                $id,
            ]);
            $_SESSION['flash_success'] = 'Blog post updated successfully!';
            break;

        case 'delete':
            $stmt = $db->prepare("DELETE FROM blog_posts WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['flash_success'] = 'Blog post deleted successfully!';
            break;

        default:
            $_SESSION['flash_error'] = 'Unknown action.';
    }
} catch (Exception $e) {
    $_SESSION['flash_error'] = 'Error: ' . $e->getMessage();
}

header('Location: /admin-blogs');
exit;
