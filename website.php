<?php

$title = 'Website Saya';
$description = 'Contoh halaman website sederhana dengan PHP.';
$menuItems = ['Beranda', 'Tentang', 'Kontak'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f3f4f6; color: #111; }
        header { background: #2563eb; color: #fff; padding: 2rem 1rem; text-align: center; }
        nav a { color: #fff; margin: 0 0.75rem; text-decoration: none; }
        main { max-width: 900px; margin: 2rem auto; padding: 0 1rem; }
        section { margin-bottom: 2rem; }
        footer { text-align: center; padding: 1rem 0; background: #e5e7eb; color: #374151; }
    </style>
</head>
<body>
    <header>
        <h1><?= htmlspecialchars($title) ?></h1>
        <p><?= htmlspecialchars($description) ?></p>
        <nav>
            <?php foreach ($menuItems as $item): ?>
                <a href="#<?= strtolower($item) ?>"><?= htmlspecialchars($item) ?></a>
            <?php endforeach; ?>
        </nav>
    </header>
    <main>
        <section id="beranda">
            <h2>Selamat Datang</h2>
            <p>Ini adalah contoh website sederhana yang dibuat dengan PHP dan HTML.</p>
        </section>
        <section id="tentang">
            <h2>Tentang</h2>
            <p>Website ini menampilkan konten statis dengan PHP sebagai template.</p>
        </section>
        <section id="kontak">
            <h2>Kontak</h2>
            <p>Hubungi kami via email: <a href="mailto:halo@example.com">halo@example.com</a></p>
        </section>
    </main>
    <footer>
        <p>&copy; <?= date('Y') ?> Website Saya</p>
    </footer>
</body>
</html>
