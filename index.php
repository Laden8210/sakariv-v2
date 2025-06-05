<?php

try {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', $_SERVER['HTTP_HOST'] !== 'localhost');
    ini_set('session.use_strict_mode', 1);
    session_start();

    $isLocal = $_SERVER['HTTP_HOST'] === 'localhost';
    $baseUrl = $isLocal ? 'http://localhost/sakari-v2' : '';
    $request = trim(preg_replace('/[^a-zA-Z0-9_-]/', '', str_replace('/sakari-v2/', '', explode('?', $_SERVER['REQUEST_URI'])[0])), '/');

    $routes = [
        '' => ['file' => 'home.php', 'title' => 'Login', 'auth_required' => false],
        'apply' => ['file' => 'apply.php', 'title' => 'Apply Now', 'auth_required' => false],

    ];

    $layout = 'app.php';

    if ($request === 'logout') {
        session_unset();
        session_destroy();
        header('Location: login');
        exit;
    }

    if (!isset($routes[$request])) {
        http_response_code(404);
        include 'public/view/error/404.php';
        exit;
    }

    $route = $routes[$request];

    if ($route['auth_required']) {
        if (!isset($_SESSION['auth'])) {
            header('Location: login');
            exit;
        }

        if ($_SESSION['auth']['ip_address'] !== $_SERVER['REMOTE_ADDR'] || $_SESSION['auth']['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
            session_unset();
            session_destroy();
            header('Location: login?error=session_tampered');
            exit;
        }

        $user = $userModel->getCurrentUser();
        $name = $user['first_name'] . ' ' . $user['last_name'];
        $role = $user['role'];
    }



    $title = $route['title'];
    $content = __DIR__ . '/public/view/' . $route['file'];
    require_once __DIR__ . '/public/layouts/' . ($route['layout'] ?? $layout);
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    include 'public/view/error/500.php';
    exit;
}
