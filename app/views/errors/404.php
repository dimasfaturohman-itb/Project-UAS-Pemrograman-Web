<?php http_response_code(404); ?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Halaman tidak ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh">
    <main class="container text-center">
        <h1 class="display-4 fw-bold text-primary">404</h1>
        <p class="lead">Halaman yang Anda cari tidak ditemukan.</p>
        <a class="btn btn-primary" href="<?= url('/') ?>">Kembali ke beranda</a>
    </main>
</body>
</html>
