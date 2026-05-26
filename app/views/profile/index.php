<?php require APP_ROOT . '/app/views/layouts/dashboard_header.php'; ?>
<div class="card border-0 shadow-soft" style="max-width:720px">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Profil Saya</h5>
        <form method="post" action="<?= url('user/profile') ?>">
            <?= csrf_field() ?>
            <div class="mb-3"><label class="form-label">Nama</label><input name="nama" class="form-control" value="<?= $user['nama'] ?>" required></div>
            <div class="mb-3"><label class="form-label">Email</label><input name="email" type="email" class="form-control" value="<?= $user['email'] ?>" required></div>
            <div class="mb-3"><label class="form-label">Password Baru</label><input name="password" type="password" class="form-control" placeholder="Kosongkan jika tidak diubah"></div>
            <button class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan Profil</button>
        </form>
    </div>
</div>
<?php require APP_ROOT . '/app/views/layouts/dashboard_footer.php'; ?>

