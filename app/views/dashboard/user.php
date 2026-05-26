<?php require APP_ROOT . '/app/views/layouts/dashboard_header.php'; ?>
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stat-card border-0 shadow-soft"><div class="card-body"><i class="bi bi-clipboard2-data text-primary fs-3"></i><div class="h3 fw-bold mt-2"><?= count($reports) ?></div><span class="text-muted">Total laporan saya</span></div></div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card border-0 shadow-soft"><div class="card-body"><i class="bi bi-hourglass-split text-info fs-3"></i><div class="h3 fw-bold mt-2"><?= count(array_filter($reports, fn($r) => in_array($r['status'], ['Diproses', 'Dalam Perbaikan'], true))) ?></div><span class="text-muted">Sedang diproses</span></div></div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card border-0 shadow-soft"><div class="card-body"><i class="bi bi-check-circle text-success fs-3"></i><div class="h3 fw-bold mt-2"><?= count(array_filter($reports, fn($r) => $r['status'] === 'Selesai')) ?></div><span class="text-muted">Selesai</span></div></div>
    </div>
</div>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-soft">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <h5 class="fw-bold mb-0">Laporan Terbaru</h5>
                <a href="<?= url('user/reports/create') ?>" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Buat Laporan</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead><tr><th>Judul</th><th>Kategori</th><th>Status</th><th>Tanggal</th></tr></thead>
                        <tbody>
                        <?php foreach (array_slice($reports, 0, 6) as $report): ?>
                            <tr>
                                <td><a class="fw-semibold" href="<?= url('user/reports/' . $report['id']) ?>"><?= $report['judul_laporan'] ?></a></td>
                                <td><?= $report['kategori'] ?></td>
                                <td><span class="badge badge-status <?= status_class($report['status']) ?>"><?= $report['status'] ?></span></td>
                                <td><?= date('d M Y', strtotime($report['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-soft">
            <div class="card-header bg-white border-0 py-3"><h5 class="fw-bold mb-0">Notifikasi</h5></div>
            <div class="card-body">
                <?php if (!$notifications): ?>
                    <p class="text-muted mb-0">Belum ada notifikasi.</p>
                <?php endif; ?>
                <?php foreach ($notifications as $note): ?>
                    <div class="border-bottom pb-3 mb-3">
                        <div class="fw-semibold"><?= $note['message'] ?></div>
                        <small class="text-muted"><?= date('d M Y H:i', strtotime($note['created_at'])) ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php require APP_ROOT . '/app/views/layouts/dashboard_footer.php'; ?>

