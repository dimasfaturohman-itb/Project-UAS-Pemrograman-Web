<?php require APP_ROOT . '/app/views/layouts/dashboard_header.php'; ?>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-soft">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Tambah Kategori</h5>
                <form method="post" action="<?= url('admin/categories/store') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3"><label class="form-label">Nama</label><input name="nama" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Icon Bootstrap</label><input name="icon" class="form-control" value="bi-tools" required></div>
                    <div class="mb-3"><label class="form-label">Warna</label><input name="warna" type="color" class="form-control form-control-color" value="#0d6efd"></div>
                    <button class="btn btn-primary w-100"><i class="bi bi-plus-circle me-2"></i>Tambah</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-soft">
            <div class="card-header bg-white border-0 py-3"><h5 class="fw-bold mb-0">Daftar Kategori</h5></div>
            <div class="card-body">
                <?php $categoryModals = ''; ?>
                <div class="table-responsive">
                    <table class="table datatable align-middle">
                        <thead><tr><th>Icon</th><th>Nama</th><th>Warna</th><th>Aksi</th></tr></thead>
                        <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><i class="bi <?= $category['icon'] ?> fs-4" style="color:<?= $category['warna'] ?>"></i></td>
                                <td class="fw-semibold"><?= $category['nama'] ?></td>
                                <td><span class="badge" style="background:<?= $category['warna'] ?>"><?= $category['warna'] ?></span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#category<?= $category['id'] ?>"><i class="bi bi-pencil"></i></button>
                                </td>
                            </tr>
                            <?php ob_start(); ?>
                            <div class="modal fade" id="category<?= $category['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form method="post" action="<?= url('admin/categories/' . $category['id'] . '/update') ?>">
                                            <?= csrf_field() ?>
                                            <div class="modal-header border-0"><h5 class="fw-bold mb-0">Edit Kategori</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                            <div class="modal-body">
                                                <div class="mb-3"><label class="form-label">Nama</label><input name="nama" class="form-control" value="<?= $category['nama'] ?>" required></div>
                                                <div class="mb-3"><label class="form-label">Icon</label><input name="icon" class="form-control" value="<?= $category['icon'] ?>" required></div>
                                                <div class="mb-3"><label class="form-label">Warna</label><input name="warna" type="color" class="form-control form-control-color" value="<?= $category['warna'] ?>"></div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button formaction="<?= url('admin/categories/' . $category['id'] . '/delete') ?>" class="btn btn-outline-danger" onclick="return confirm('Hapus kategori?')"><i class="bi bi-trash me-2"></i>Hapus</button>
                                                <button class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php $categoryModals .= ob_get_clean(); ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?= $categoryModals ?>
            </div>
        </div>
    </div>
</div>
<?php require APP_ROOT . '/app/views/layouts/dashboard_footer.php'; ?>
