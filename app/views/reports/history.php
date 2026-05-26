<?php require APP_ROOT . '/app/views/layouts/dashboard_header.php'; ?>
<div class="card border-0 shadow-soft">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
        <h5 class="fw-bold mb-0">Riwayat Laporan</h5>
        <a href="<?= url('user/reports/create') ?>" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Buat Laporan</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable align-middle">
                <thead><tr><th>Foto</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><img class="report-photo" src="<?= upload_url($report['foto']) ?>" alt="Foto laporan"></td>
                        <td class="fw-semibold"><?= $report['judul_laporan'] ?></td>
                        <td><?= $report['kategori'] ?></td>
                        <td><span class="badge badge-status <?= status_class($report['status']) ?>"><?= $report['status'] ?></span></td>
                        <td><?= date('d M Y', strtotime($report['created_at'])) ?></td>
                        <td><a class="btn btn-sm btn-outline-primary" href="<?= url('user/reports/' . $report['id']) ?>"><i class="bi bi-eye"></i></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require APP_ROOT . '/app/views/layouts/dashboard_footer.php'; ?>

