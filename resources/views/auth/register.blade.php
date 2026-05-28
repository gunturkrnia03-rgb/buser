<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

$error = '';
$success = '';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = sanitize($_POST['full_name']);
    $school = sanitize($_POST['school']);
    
    if ($password !== $confirm_password) {
        $error = 'Password tidak sama';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter';
    } else {
        if (register($username, $email, $password, $full_name, $school)) {
            $success = 'Registrasi berhasil! Silakan login.';
        } else {
            $error = 'Username atau email sudah digunakan';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h1 class="auth-title">🔍 <?= SITE_NAME ?></h1>
            <p class="auth-subtitle">Daftar akun baru</p>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required 
                           placeholder="Masukkan username">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required 
                           placeholder="Masukkan email">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="full_name" class="form-control" required 
                           placeholder="Masukkan nama lengkap">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Sekolah</label>
                    <input type="text" name="school" class="form-control" required 
                           placeholder="Masukkan nama sekolah">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required 
                           placeholder="Minimal 6 karakter">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" class="form-control" required 
                           placeholder="Ulangi password">
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Daftar</button>
            </form>
            
            <p style="text-align: center; margin-top: 1.5rem; color: var(--gray-600);">
                Sudah punya akun? <a href="login.php" style="color: var(--primary-color); font-weight: 600;">Login</a>
            </p>
        </div>
    </div>
</body>
</html>