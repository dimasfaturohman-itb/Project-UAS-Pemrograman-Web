<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= url('/') ?>"><i class="bi bi-buildings me-2"></i>Pelaporan Fasilitas</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="nav">
            <div class="ms-auto d-flex gap-2 mt-3 mt-lg-0">
                <a class="btn btn-outline-light" href="<?= url('login') ?>">Login</a>
                <a class="btn btn-light text-primary" href="<?= url('register') ?>">Daftar</a>
            </div>
        </div>
    </div>
</nav>

<header class="hero d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge bg-light text-primary mb-3 px-3 py-2">Layanan pengaduan fasilitas umum</span>
                <h1>Sistem Pelaporan Fasilitas Umum Rusak</h1>
                <p class="lead my-4">Laporkan kerusakan bangku taman, trotoar, drainase, halte, lampu jalan, dan jalan berlubang langsung dari lokasi Anda.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= url('user/reports/create') ?>" class="btn btn-light btn-lg text-primary"><i class="bi bi-send me-2"></i>Laporkan Sekarang</a>
                    <a href="#cara-kerja" class="btn btn-outline-light btn-lg"><i class="bi bi-info-circle me-2"></i>Cara Kerja</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="glass-panel p-4 shadow-soft">
                    <div class="row g-3">
                        <div class="col-6"><div class="h2 fw-bold"><?= $stats['total'] ?></div><small>Total laporan</small></div>
                        <div class="col-6"><div class="h2 fw-bold"><?= $stats['diproses'] ?></div><small>Sedang diproses</small></div>
                        <div class="col-6"><div class="h2 fw-bold"><?= $stats['selesai'] ?></div><small>Selesai</small></div>
                        <div class="col-6"><div class="h2 fw-bold"><?= count($categories) ?></div><small>Kategori fasilitas</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<footer class="bg-white border-top py-4">
    <div class="container d-flex flex-wrap justify-content-between gap-2 text-muted small">
        <span>&copy; <?= date('Y') ?> <?= APP_NAME ?> - Kabupaten Cirebon</span>
        <span>Pelaporan fasilitas umum rusak berbasis masyarakat</span>
    </div>
</footer>
<main>
    <section id="cara-kerja" class="py-5">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Cara Kerja Sistem</h2>
                <p class="text-muted">Alur pelaporan dibuat sederhana agar masyarakat bisa bergerak cepat.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-soft h-100 p-3">
                        <div class="card-body"><div class="feature-icon mb-3"><i class="bi bi-camera"></i></div><h5 class="fw-bold">Ambil Foto</h5><p class="text-muted mb-0">Unggah bukti kerusakan dan isi detail singkat.</p></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-soft h-100 p-3">
                        <div class="card-body"><div class="feature-icon mb-3"><i class="bi bi-geo-alt"></i></div><h5 class="fw-bold">Kirim Lokasi</h5><p class="text-muted mb-0">GPS otomatis menyimpan koordinat agar petugas mudah menemukan titiknya.</p></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-soft h-100 p-3">
                        <div class="card-body"><div class="feature-icon mb-3"><i class="bi bi-check2-circle"></i></div><h5 class="fw-bold">Pantau Progress</h5><p class="text-muted mb-0">Status laporan dapat dipantau dari dashboard pengguna.</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h2 class="fw-bold">Kategori kerusakan yang bisa dilaporkan</h2>
                    <p class="text-muted">Pilih kategori yang paling sesuai agar laporan masuk ke monitoring dengan rapi.</p>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        <?php foreach ($categories as $category): ?>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-4">
                                    <i class="bi <?= $category['icon'] ?> fs-4" style="color:<?= $category['warna'] ?>"></i>
                                    <span class="fw-semibold"><?= $category['nama'] ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

