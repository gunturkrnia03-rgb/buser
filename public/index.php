<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());

if (Auth::check()) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - Simulasi Literasi Digital & Anti Hoaks</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container navbar-content">
            <a href="index.php" class="logo">🔍 <?= SITE_NAME ?></a>
            <ul class="nav-links">
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php" class="btn btn-primary">Daftar Sekarang</a></li>
            </ul>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <h1>🛡️ Simulasi Literasi Digital & Anti Hoaks</h1>
            <p>Belajar mengenali hoaks, memahami etika digital, dan meningkatkan literasi digital Anda melalui simulasi interaktif</p>
            <a href="register.php" class="btn btn-primary" style="font-size: 1.25rem; padding: 1rem 2rem;">Mulai Belajar Sekarang</a>
        </div>
    </section>

    <div class="container" style="padding: 4rem 2rem; color: white;">
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-number">🎯</div>
                <h3 style="color: var(--dark-color); margin: 1rem 0;">Tebak Hoaks/Fakta</h3>
                <p style="color: rgba(255,255,255,0.9);">Uji kemampuan Anda membedakan berita palsu dan fakta</p>
            </div>
            <div class="stat-card">
                <div class="stat-number">📱</div>
                <h3 style="color: var(--dark-color); margin: 1rem 0;">Simulasi Media Sosial</h3>
                <p style="color: rgba(255,255,255,0.9);">Feed media sosial palsu untuk latihan mengenali hoaks</p>
            </div>
            <div class="stat-card">
                <div class="stat-number">📊</div>
                <h3 style="color: var(--dark-color); margin: 1rem 0;">Skor Literasi</h3>
                <p style="color: rgba(255,255,255,0.9);">Penilaian otomatis dan tracking progress Anda</p>
            </div>
            <div class="stat-card">
                <div class="stat-number">🎓</div>
                <h3 style="color: var(--dark-color); margin: 1rem 0;">Edukasi Digital</h3>
                <p style="color: rgba(255,255,255,0.9);">Materi keamanan digital dan etika online</p>
            </div>
        </div>
    </div>

    <footer style="background: white; padding: 2rem; text-align: center; color: var(--gray-600);">
        <div class="container">
            <p>&copy; 2026 <?= SITE_NAME ?> - Perlombaan Tingkat Nasional</p>
        </div>
    </footer>
</body>
</html>