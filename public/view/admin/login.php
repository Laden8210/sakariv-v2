<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Sakari Management Group</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f172a;
        }

        /* Left side - branding panel */
        .login-branding {
            flex: 1;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #312e81 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .login-branding::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 70%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 70% 30%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(1deg); }
            66% { transform: translate(-20px, 20px) rotate(-1deg); }
        }

        /* Floating orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
        }
        .orb-1 { width: 300px; height: 300px; background: #6366f1; top: 10%; left: 10%; animation: orb1 15s ease-in-out infinite; }
        .orb-2 { width: 200px; height: 200px; background: #8b5cf6; bottom: 20%; right: 10%; animation: orb2 12s ease-in-out infinite; }
        .orb-3 { width: 150px; height: 150px; background: #a78bfa; top: 60%; left: 30%; animation: orb3 18s ease-in-out infinite; }

        @keyframes orb1 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(40px, -40px); } }
        @keyframes orb2 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-30px, 30px); } }
        @keyframes orb3 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(20px, 20px); } }

        .login-branding .branding-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #fff;
        }

        .login-branding .branding-content img {
            height: 80px;
            margin-bottom: 32px;
            filter: drop-shadow(0 0 30px rgba(99, 102, 241, 0.3));
        }

        .login-branding .branding-content h1 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .login-branding .branding-content p {
            font-size: 1.05rem;
            opacity: 0.7;
            max-width: 350px;
            line-height: 1.6;
        }

        .branding-features {
            position: relative;
            z-index: 2;
            margin-top: 48px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .branding-feature {
            display: flex;
            align-items: center;
            gap: 14px;
            color: rgba(255,255,255,0.8);
            font-size: 0.92rem;
        }

        .branding-feature i {
            width: 36px;
            height: 36px;
            background: rgba(99, 102, 241, 0.2);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #a5b4fc;
        }

        /* Right side - login form */
        .login-form-side {
            width: 520px;
            min-width: 420px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            background: #ffffff;
        }

        .login-card {
            width: 100%;
            max-width: 380px;
        }

        .login-card .welcome-text {
            margin-bottom: 36px;
        }

        .login-card .welcome-text h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .login-card .welcome-text p {
            color: #64748b;
            font-size: 0.95rem;
        }

        .login-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.88rem;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s;
            outline: none;
            background: #f8fafc;
        }

        .input-wrapper input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            background: #fff;
        }

        .input-wrapper input:focus + i,
        .input-wrapper:focus-within i {
            color: #6366f1;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-family: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
            letter-spacing: 0.3px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .login-footer a {
            color: #64748b;
            font-size: 0.88rem;
            text-decoration: none;
            transition: color 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .login-footer a:hover {
            color: #6366f1;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .login-branding { display: none; }
            .login-form-side {
                width: 100%;
                min-width: unset;
                min-height: 100vh;
            }
        }
    </style>
</head>
<body>
    <!-- Left Panel -->
    <div class="login-branding">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <div class="branding-content">
            <img src="assets/img/logo.png" alt="Sakari Management Group">
            <h1>Sakari Admin</h1>
            <p>Manage your healthcare virtual staffing platform with ease</p>
        </div>

        <div class="branding-features">
            <div class="branding-feature">
                <i class="bi bi-journal-richtext"></i>
                <span>Manage blog posts & content</span>
            </div>
            <div class="branding-feature">
                <i class="bi bi-briefcase"></i>
                <span>Create & manage job postings</span>
            </div>
            <div class="branding-feature">
                <i class="bi bi-bar-chart-line"></i>
                <span>Track performance metrics</span>
            </div>
            <div class="branding-feature">
                <i class="bi bi-shield-check"></i>
                <span>Secure access control</span>
            </div>
        </div>
    </div>

    <!-- Right Panel - Login Form -->
    <div class="login-form-side">
        <div class="login-card">
            <div class="welcome-text">
                <h2>Welcome back 👋</h2>
                <p>Enter your credentials to access the admin panel</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="login-error">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <?php
                    $errors = [
                        'invalid' => 'Invalid username or password.',
                        'required' => 'Please fill in all fields.',
                        'session' => 'Your session has expired. Please login again.',
                    ];
                    echo htmlspecialchars($errors[$_GET['error']] ?? 'An error occurred.');
                    ?>
                </div>
            <?php endif; ?>

            <form action="forms/admin/login_handler.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <input type="text" id="username" name="username" placeholder="Enter your username" required autofocus>
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <i class="bi bi-lock"></i>
                    </div>
                </div>
                <button type="submit" class="btn-login">
                    Sign In <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <div class="login-footer">
                <a href="/">
                    <i class="bi bi-arrow-left"></i> Back to Website
                </a>
            </div>
        </div>
    </div>
</body>
</html>
