<?php
session_start();
require_once __DIR__ . '/../../database/init.php';

$isLocal = $_SERVER['HTTP_HOST'] === 'localhost';
$baseUrl = $isLocal ? '/sakari-v2/' : '/';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $baseUrl . 'admin-login');
    exit;
}

$db = getDB();
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    header('Location: ' . $baseUrl . 'admin-login?error=required');
    exit;
}

$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    header('Location: ' . $baseUrl . 'admin-login?error=invalid');
    exit;
}

$_SESSION['admin'] = [
    'id' => $user['id'],
    'username' => $user['username'],
    'name' => $user['name'],
    'ip_address' => $_SERVER['REMOTE_ADDR'],
    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
];

header('Location: ' . $baseUrl . 'admin-dashboard');
exit;
