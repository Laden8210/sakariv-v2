<?php

try {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', $_SERVER['HTTP_HOST'] !== 'localhost');
    ini_set('session.use_strict_mode', 1);
    session_start();

    // Initialize database
    require_once __DIR__ . '/database/init.php';
    $db = getDB();

    $isLocal = $_SERVER['HTTP_HOST'] === 'localhost';
    $baseUrl = $isLocal ? '/sakari-v2/' : '/';
    // Make baseUrl available to all views
    $GLOBALS['baseUrl'] = $baseUrl;
    $request = trim(preg_replace('/[^a-zA-Z0-9_-]/', '', str_replace('/sakari-v2/', '', explode('?', $_SERVER['REQUEST_URI'])[0])), '/');
    $GLOBALS['currentRoute'] = $request;

    $routes = [
        '' => ['file' => 'home.php', 'title' => 'Home', 'auth_required' => false],
        'apply' => ['file' => 'apply.php', 'title' => 'Apply Now', 'auth_required' => false],
        'blog' => ['file' => 'blog.php', 'title' => 'Blog & Insights', 'auth_required' => false],
        'blog-post' => ['file' => 'blog-post.php', 'title' => 'Blog Post', 'auth_required' => false],
        'careers' => ['file' => 'careers.php', 'title' => 'Career Opportunities', 'auth_required' => false],

        // Admin routes
        'admin-login' => ['file' => 'admin/login.php', 'title' => 'Admin Login', 'auth_required' => false, 'layout' => 'none'],
        'admin-dashboard' => ['file' => 'admin/dashboard.php', 'title' => 'Dashboard', 'auth_required' => 'admin', 'layout' => 'admin.php'],
        'admin-blogs' => ['file' => 'admin/blogs.php', 'title' => 'Blog Posts', 'auth_required' => 'admin', 'layout' => 'admin.php'],
        'admin-jobs' => ['file' => 'admin/jobs.php', 'title' => 'Job Postings', 'auth_required' => 'admin', 'layout' => 'admin.php'],
    ];

    $layout = 'app.php';

    // Handle admin logout
    if ($request === 'admin-logout') {
        unset($_SESSION['admin']);
        header('Location: ' . $baseUrl . 'admin-login');
        exit;
    }

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

    // Admin auth check
    if (($route['auth_required'] ?? false) === 'admin') {
        if (!isset($_SESSION['admin'])) {
            header('Location: ' . $baseUrl . 'admin-login?error=session');
            exit;
        }
    } elseif ($route['auth_required']) {
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

    // Handle layout
    $routeLayout = $route['layout'] ?? $layout;
    if ($routeLayout === 'none') {
        // Standalone page (like login), include directly
        include $content;
    } else {
        require_once __DIR__ . '/public/layouts/' . $routeLayout;
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    include 'public/view/error/500.php';
    exit;
}
