<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();

$user = getCurrentUser();
$literacyScore = getUserLiteracyScore($user['id']);
$quizProgress = getUserQuizProgress($user['id']);
$analysisHistory = getUserAnalysisHistory($user['id'], 5);
$literacyLevel = calculateLiteracyLevel($literacyScore);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container navbar-content">
            <a href="dashboard.php" class="logo">🔍 <?= SITE_NAME ?></a>
            <ul class="nav-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="feed.php">Feed</a></li>
                <li><a href="quiz.php">Quiz</a></li>
                <li><a href="analyze.php">Analisis</a></li>
                <li><a href="materials.php">Materi</a></li>
                <?php if ($user['role'] === 'admin'): ?>
                    <li><a href="admin/index.php">Admin</a></li>
                <?php endif; ?>
                <li><a href="logout.php" class="btn btn-danger">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="padding: 2rem;">
        <h1 style="margin-bottom: 2rem; color: white;">Halo, <?= htmlspecialchars($user['full_name']) ?>! 👋</h1>
        
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="score-circle" style="background: conic-gradient(var(--primary-color) <?= $literacyScore ?>%, var(--gray-200) <?= $literacyScore ?>%);">
                    <div class="score-text"><?= round($literacyScore) ?></div>
                </div>
                <h3 style="color: var(--dark-color);">Skor Literasi</h3>
                <p style="color: var(--gray-600);"><?= $literacyLevel ?></p>
            </div>
            
            <div class="stat-card">
                <div class="stat-number"><?= $quizProgress['completed_quizzes'] ?? 0 ?></div>
                <div class="stat-label">Quiz Selesai</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-number"><?= round($quizProgress['avg_score'] ?? 0) ?></div>
                <div class="stat-label">Rata-rata Skor Quiz</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-number"><?= count($analysisHistory) ?></div>
                <div class="stat-label">Analisis Posting</div>
            </div>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <div class="card-header">
                <h2 class="card-title">📊 Riwayat Analisis</h2>
            </div>
            <?php if (empty($analysisHistory)): ?>
                <p style="color: var(--gray-600); text-align: center; padding: 2rem;">Belum ada riwayat analisis. Coba analisis posting di halaman <a href="analyze.php" style="color: var(--primary-color);">Analisis</a></p>
            <?php else: ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 2px solid var(--gray-200);">
                            <th style="padding: 1rem;">Konten</th>
                            <th style="padding: 1rem;">Hasil</th>
                            <th style="padding: 1rem;">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($analysisHistory as $history): ?>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 1rem;"><?= htmlspecialchars(substr($history['analyzed_content'], 0, 50)) ?>...</td>
                                <td style="padding: 1rem;">
                                    <span class="analysis-badge <?= $history['analysis_result'] ? 'fakta' : 'hoax' ?>" 
                                          style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                                        <?= $history['analysis_result'] ? '✅ Fakta' : '❌ Hoaks' ?>
                                    </span>
                                </td>
                                <td style="padding: 1rem;"><?= date('d M Y', strtotime($history['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 2rem;">
            <a href="quiz.php" class="btn btn-primary" style="text-align: center; padding: 1.5rem;">🎯 Mulai Quiz</a>
            <a href="feed.php" class="btn btn-secondary" style="text-align: center; padding: 1.5rem;">📱 Akses Feed</a>
            <a href="analyze.php" class="btn btn-success" style="text-align: center; padding: 1.5rem;">🔍 Analisis Posting</a>
            <a href="materials.php" class="btn btn-outline" style="text-align: center; padding: 1.5rem;">📚 Belajar Materi</a>
        </div>
    </div>
</body>
</html>