<div class="card border-0 shadow-soft">
    <div class="card-header bg-white border-0 py-3">
        <form class="row g-2 align-items-end" method="get">
            <div class="col-md-4">
                <label class="form-label">Filter Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua status</option>
                    <?php foreach ($statuses as $status): ?><option value="<?= $status ?>" <?= ($_GET['status'] ?? '') === $status ? 'selected' : '' ?>><?= $status ?></option><?php endforeach; ?>
                </select>
            </div>
            <?php if (!empty($categories)): ?>
            <div class="col-md-4">
                <label class="form-label">Filter Kategori</label>
                <select name="kategori" class="form-select">
                    <option value="">Semua kategori</option>
                    <?php foreach ($categories as $category): ?><option value="<?= $category['id'] ?>" <?= ($_GET['kategori'] ?? '') == $category['id'] ? 'selected' : '' ?>><?= $category['nama'] ?></option><?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-md-2"><button class="btn btn-primary w-100"><i class="bi bi-funnel me-2"></i>Filter</button></div>
        </form>
    </div>
    <div class="card-body">
        <?php $reportModals = ''; ?>
        <div class="table-responsive">
            <table class="table datatable align-middle">
                <thead><tr><th>Foto</th><th>Judul</th><th>Pelapor</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><img class="report-photo" src="<?= upload_url($report['foto']) ?>" alt="Foto"></td>
                        <td><div class="fw-semibold"><?= $report['judul_laporan'] ?></div><small class="text-muted"><?= date('d M Y H:i', strtotime($report['created_at'])) ?></small></td>
                        <td><?= $report['pelapor'] ?></td>
                        <td><?= $report['kategori'] ?></td>
                        <td><span class="badge badge-status <?= status_class($report['status']) ?>"><?= $report['status'] ?></span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#statusModal<?= $report['id'] ?>"><i class="bi bi-pencil-square"></i></button>
                        </td>
                    </tr>
                    <?php ob_start(); ?>
                    <div class="modal fade" id="statusModal<?= $report['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <form method="post" action="<?= url(current_user()['role'] === 'admin' ? 'admin/reports/' . $report['id'] . '/status' : 'petugas/reports/' . $report['id'] . '/status') ?>" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <div class="modal-header border-0"><h5 class="fw-bold mb-0">Update Status</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <h6><?= $report['judul_laporan'] ?></h6>
                                        <p class="text-muted"><?= $report['alamat'] ?></p>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <?php foreach ($statuses as $status): ?><option value="<?= $status ?>" <?= $report['status'] === $status ? 'selected' : '' ?>><?= $status ?></option><?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Catatan</label>
                                            <textarea name="catatan_petugas" class="form-control" rows="3"><?= $report['catatan_petugas'] ?></textarea>
                                        </div>
                                        <?php if (current_user()['role'] === 'petugas'): ?>
                                        <div class="mb-3">
                                            <label class="form-label">Upload Bukti Perbaikan</label>
                                            <input type="file" name="bukti_perbaikan" class="form-control" accept="image/jpeg,image/png,image/webp">
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="modal-footer border-0"><button class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php $reportModals .= ob_get_clean(); ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?= $reportModals ?>
    </div>
</div>
