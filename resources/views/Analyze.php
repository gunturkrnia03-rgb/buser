<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();
$user = getCurrentUser();
$result = null;
$analyzedContent = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $analyzedContent = sanitize($_POST['content']);
    
    if (!empty($analyzedContent)) {
        $isFakta = analyzeContent($analyzedContent);
        $result = $isFakta ? 'Fakta ✅' : 'Hoaks ❌';
        $resultClass = $isFakta ? 'fakta' : 'hoax';
        $score = $isFakta ? 100 : 0;
        
        // Save to database
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO scores (user_id, activity_type, analyzed_content, analysis_result, score) VALUES (?, 'analysis', ?, ?, ?)");
        $stmt->execute([$user['id'], $analyzedContent, $isFakta, $score]);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis - <?= SITE_NAME ?></title>
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
        <h1 style="margin-bottom: 1rem; color: white;">🔍 Analisis Posting</h1>
        <p style="margin-bottom: 2rem; color: white; opacity: 0.9;">Tulis atau paste konten yang ingin Anda analisis. Sistem akan membantu menentukan apakah itu hoaks atau fakta.</p>

        <div class="card" style="max-width: 800px; margin: 0 auto;">
            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Konten Posting</label>
                    <textarea name="content" class="form-control" rows="6" required 
                              placeholder="Tulis atau paste konten yang ingin dianalisis..."><?= htmlspecialchars($analyzedContent) ?></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">🔍 Analisis Konten</button>
            </form>
        </div>

        <?php if ($result): ?>
            <div class="card" style="max-width: 800px; margin: 2rem auto;">
                <div class="analysis-result">
                    <div class="analysis-badge <?= $resultClass ?>">
                        <?= $result ?>
                    </div>
                    <p style="font-size: 1.1rem; margin-top: 1rem; color: var(--gray-600);">
                        <?= $resultClass === 'fakta' ? 'Konten ini terlihat seperti fakta berdasarkan analisis sederhana.' : 'Konten ini mengindikasikan hoaks berdasarkan kata kunci yang terdeteksi.' ?>
                    </p>
                    <p style="margin-top: 1rem; color: var(--gray-600); font-size: 0.875rem;">
                        <em>Catatan: Ini adalah analisis sederhana. Selalu verifikasi dari sumber terpercaya!</em>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <div class="card" style="max-width: 800px; margin: 2rem auto;">
            <h3 style="margin-bottom: 1rem; color: var(--dark-color);">💡 Tips Mengenali Hoaks</h3>
            <ul style="line-height: 2; color: var(--gray-600);">
                <li>Cek sumber informasi - apakah dari media terpercaya?</li>
                <li>Waspadai judul provokatif atau clickbait</li>
                <li>Cari informasi dari multiple sumber</li>
                <li>Periksa tanggal publikasi</li>
                <li>Gunakan fact-checking situs seperti Turnbackhoax.id</li>
                <li>Waspada konten yang tidak ada bukti ilmiah</li>
            </ul>
        </div>
    </div>
</body>
</html>