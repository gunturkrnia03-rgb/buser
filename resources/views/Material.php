<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();
$user = getCurrentUser();
$materials = getMaterials();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi - <?= SITE_NAME ?></title>
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
        <h1 style="margin-bottom: 1rem; color: white;">📚 Materi Edukasi Keamanan Digital</h1>
        <p style="margin-bottom: 2rem; color: white; opacity: 0.9;">Pelajari materi literasi digital, etika online, dan keamanan digital</p>

        <?php foreach ($materials as $material): ?>
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <span style="background: var(--primary-color); color: white; padding: 0.25rem 0.75rem; border-radius: var(--radius-sm); font-size: 0.875rem; text-transform: uppercase;">
                        <?= str_replace('_', ' ', $material['category']) ?>
                    </span>
                    <h2 class="card-title" style="margin-top: 0.5rem;"><?= htmlspecialchars($material['title']) ?></h2>
                </div>
                
                <div style="line-height: 1.8; color: var(--gray-800);">
                    <?= nl2br(htmlspecialchars($material['content'])) ?>
                </div>
                
                <?php if ($material['quiz_question']): ?>
                    <div style="background: var(--gray-100); padding: 1.5rem; border-radius: var(--radius-sm); margin-top: 1.5rem;">
                        <h3 style="margin-bottom: 1rem;">🎯 Kuis Mini</h3>
                        <p style="font-weight: 600; margin-bottom: 1rem;"><?= htmlspecialchars($material['quiz_question']) ?></p>
                        
                        <?php 
                        $options = json_decode($material['quiz_options'], true);
                        $correctAnswer = $material['correct_answer'];
                        ?>
                        
                        <div class="quiz-options">
                            <?php foreach ($options as $index => $option): ?>
                                <div class="quiz-option" onclick="checkMaterialQuiz(this, <?= ($index + 1) == $correctAnswer ? 'true' : 'false' ?>, <?= $material['id'] ?>)">
                                    <?= chr(65 + $index) ?>. <?= htmlspecialchars($option) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div id="material-result-<?= $material['id'] ?>" style="margin-top: 1rem;"></div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
    function checkMaterialQuiz(element, isCorrect, materialId) {
        const options = element.parentElement.querySelectorAll('.quiz-option');
        options.forEach(opt => opt.style.pointerEvents = 'none');
        
        if (isCorrect) {
            element.classList.add('correct');
            document.getElementById(`material-result-${materialId}`).innerHTML = 
                '<div class="alert alert-success">✅ Benar! Anda mendapatkan 100 poin.</div>';
            
            // Save score
            fetch('save_score.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `material_id=${materialId}&is_correct=1&activity_type=material&score=100`
            });
        } else {
            element.classList.add('incorrect');
            options.forEach(opt => {
                if (opt.textContent.includes('A.') || opt.textContent.includes('