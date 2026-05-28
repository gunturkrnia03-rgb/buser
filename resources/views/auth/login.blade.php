<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

$error = '';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];
    
    if (login($username, $password)) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Username atau password salah';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h1 class="auth-title">🔍 <?= SITE_NAME ?></h1>
            <p class="auth-subtitle">Login untuk memulai</p>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Username atau Email</label>
                    <input type="text" name="username" class="form-control" required 
                           placeholder="Masukkan username atau email">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required 
                           placeholder="Masukkan password">
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </form>
            
            <p style="text-align: center; margin-top: 1.5rem; color: var(--gray-600);">
                Belum punya akun? <a href="register.php" style="color: var(--primary-color); font-weight: 600;">Daftar</a>
            </p>
            
            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--gray-200);">
                <p style="text-align: center; color: var(--gray-600); font-size: 0.875rem;">
                    <strong>Demo Login:</strong><br>
                    Username: siswa1 | Password: password123
                </p>
            </div>
        </div>
    </div>
</body>
</html>