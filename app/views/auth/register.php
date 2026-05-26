<?php require APP_ROOT . '/app/views/layouts/auth_header.php'; ?>
<main class="container d-flex align-items-center justify-content-center py-5" style="min-height:100vh">
    <div class="card border-0 shadow-soft w-100" style="max-width:520px">
        <div class="card-body p-4 p-md-5">
            <a href="<?= url('/') ?>" class="text-primary fw-bold d-inline-flex align-items-center mb-4"><i class="bi bi-arrow-left me-2"></i>Beranda</a>
            <h1 class="h3 fw-bold">Buat Akun Masyarakat</h1>
            <p class="text-muted">Daftar untuk mengirim dan memantau laporan.</p>
            <form action="<?= url('register') ?>" method="post" class="mt-4">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control form-control-lg" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" minlength="6" required>
                </div>
                <button class="btn btn-primary btn-lg w-100"><i class="bi bi-person-plus me-2"></i>Register</button>
            </form>
            <p class="text-center text-muted mt-4 mb-0">Sudah punya akun? <a href="<?= url('login') ?>">Login</a></p>
        </div>
    </div>
</main>
<?php require APP_ROOT . '/app/views/layouts/auth_footer.php'; ?>

