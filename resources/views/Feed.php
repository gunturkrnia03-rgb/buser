<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();
$user = getCurrentUser();
$posts = getPosts(10);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed - <?= SITE_NAME ?></title>
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
        <h1 style="margin-bottom: 1rem; color: white;">📱 Feed Media Sosial Simulasi</h1>
        <p style="margin-bottom: 2rem; color: white; opacity: 0.9;">Tebak apakah posting ini Hoaks atau Fakta! Klik tombol untuk mengecek jawaban.</p>

        <?php foreach ($posts as $post): ?>
            <div class="feed-item">
                <div class="feed-header">
                    <div class="feed-avatar"><?= strtoupper(substr($post['user_name'], 0, 1)) ?></div>
                    <div class="feed-user">
                        <div class="feed-name"><?= htmlspecialchars($post['user_name']) ?></div>
                        <div class="feed-time"><?= date('d M Y, H:i', strtotime($post['created_at'])) ?></div>
                    </div>
                </div>
                
                <div class="feed-content">
                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                </div>
                
                <div class="feed-actions">
                    <button class="action-btn" onclick="checkAnswer(<?= $post['id'] ?>, true)">
                        ✅ Fakta
                    </button>
                    <button class="action-btn" onclick="checkAnswer(<?= $post['id'] ?>, false)">
                        ❌ Hoaks
                    </button>
                    <span id="result-<?= $post['id'] ?>" style="margin-left: auto; font-weight: 600;"></span>
                </div>
                
                <div id="explanation-<?= $post['id'] ?>" style="display: none; padding: 1rem; background: var(--gray-100); border-top: 1px solid var(--gray-200);">
                    <strong>Penjelasan:</strong> <span id="explanation-text-<?= $post['id'] ?>"></span>
                    <form method="POST" style="margin-top: 1rem;" action="save_score.php">
                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                        <input type="hidden" name="user_answer" id="user-answer-<?= $post['id'] ?>">
                        <input type="hidden" name="is_correct" id="is-correct-<?= $post['id'] ?>">
                        <button type="submit" class="btn btn-primary btn-sm" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Simpan Skor</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
    function checkAnswer(postId, isFakta) {
        const posts = <?= json_encode($posts) ?>;
        const post = posts.find(p => p.id === postId);
        const isActuallyFakta = !post.is_hoax;
        const isCorrect = isFakta === isActuallyFakta;
        
        const resultEl = document.getElementById(`result-${postId}`);
        const explanationEl = document.getElementById(`explanation-${postId}`);
        const explanationTextEl = document.getElementById(`explanation-text-${postId}`);
        
        if (isCorrect) {
            resultEl.innerHTML = '<span style="color: var(--success-color);">✅ Benar!</span>';
            resultEl.setAttribute('data-correct', '1');
        } else {
            resultEl.innerHTML = '<span style="color: var(--danger-color);">❌ Salah!</span>';
            resultEl.setAttribute('data-correct', '0');
        }
        
        explanationTextEl.textContent = isActuallyFakta ? 'Ini adalah fakta yang benar.' : 'Ini adalah hoaks/berita palsu.';
        explanationEl.style.display = 'block';
        
        // Store answer for submission
        document.getElementById(`user-answer-${postId}`).value = isFakta ? 1 : 0;
        document.getElementById(`is-correct-${postId}`).value = isCorrect ? 1 : 0;
    }
    </script>
</body>
</html>