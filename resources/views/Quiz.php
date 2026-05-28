<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();
$user = getCurrentUser();
$quizzes = getQuizzes(20);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - <?= SITE_NAME ?></title>
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
        <h1 style="margin-bottom: 1rem; color: white;">🎯 Quiz Tebak Hoaks/Fakta</h1>
        <p style="margin-bottom: 2rem; color: white; opacity: 0.9;">Tebak apakah berita ini Hoaks atau Fakta!</p>

        <?php foreach ($quizzes as $index => $quiz): ?>
            <div class="quiz-container" style="margin-bottom: 2rem; <?= $index > 0 ? 'margin-top: 2rem;' : '' ?>">
                <div class="quiz-question"><?= ($index + 1) ?>. <?= htmlspecialchars($quiz['question']) ?></div>
                
                <?php if ($quiz['post_content']): ?>
                    <div style="background: var(--gray-100); padding: 1.5rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; font-style: italic;">
                        "<?= htmlspecialchars($quiz['post_content']) ?>"
                    </div>
                <?php endif; ?>
                
                <div class="quiz-options">
                    <div class="quiz-option" onclick="submitQuiz(<?= $quiz['id'] ?>, true, this)">
                        ✅ Ini Fakta
                    </div>
                    <div class="quiz-option" onclick="submitQuiz(<?= $quiz['id'] ?>, false, this)">
                        ❌ Ini Hoaks
                    </div>
                </div>
                
                <div id="quiz-result-<?= $quiz['id'] ?>" style="margin-top: 1.5rem; display: none;"></div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
    function submitQuiz(quizId, isFakta, element) {
        const quizzes = <?= json_encode($quizzes) ?>;
        const quiz = quizzes.find(q => q.id === quizId);
        const isActuallyFakta = !quiz.is_hoax;
        const isCorrect = isFakta === isActuallyFakta;
        
        const resultEl = document.getElementById(`quiz-result-${quizId}`);
        const options = element.parentElement.querySelectorAll('.quiz-option');
        
        options.forEach(opt => {
            opt.style.pointerEvents = 'none';
            if ((isActuallyFakta && opt.textContent.includes('Fakta')) || 
                (!isActuallyFakta && opt.textContent.includes('Hoaks'))) {
                opt.classList.add('correct');
            }
        });
        
        if (!isCorrect) {
            element.classList.add('incorrect');
        }
        
        resultEl.style.display = 'block';
        resultEl.innerHTML = `
            <div class="alert ${isCorrect ? 'alert-success' : 'alert-danger'}">
                <strong>${isCorrect ? '✅ Benar!' : '❌ Salah!'}</strong><br>
                ${quiz.explanation}
            </div>
        `;
        
        // Save score
        fetch('save_score.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `quiz_id=${quizId}&user_answer=${isFakta ? 1 : 0}&is_correct=${isCorrect ? 1 : 0}&activity_type=quiz`
        });
    }
    </script>
</body>
</html>