<?php require APP_ROOT . '/app/views/layouts/auth_header.php'; ?>
<main class="container d-flex align-items-center justify-content-center py-5" style="min-height:100vh">
    <div class="card border-0 shadow-soft w-100" style="max-width:460px">
        <div class="card-body p-4 p-md-5">
            <a href="<?= url('/') ?>" class="text-primary fw-bold d-inline-flex align-items-center mb-4"><i class="bi bi-arrow-left me-2"></i>Beranda</a>
            <h1 class="h3 fw-bold">Masuk ke Sistem</h1>
            <p class="text-muted">Gunakan akun admin, petugas, atau masyarakat.</p>
            <form action="<?= url('login') ?>" method="post" class="mt-4">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" required>
                </div>
                <button class="btn btn-primary btn-lg w-100"><i class="bi bi-box-arrow-in-right me-2"></i>Login</button>
            </form>
            <p class="text-center text-muted mt-4 mb-0">Belum punya akun? <a href="<?= url('register') ?>">Daftar</a></p>
        </div>
    </div>
</main>
<?php require APP_ROOT . '/app/views/layouts/auth_footer.php'; ?>

