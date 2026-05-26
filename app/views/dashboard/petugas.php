<?php require APP_ROOT . '/app/views/layouts/dashboard_header.php'; ?>
<div class="row g-4 mb-4">
    <div class="col-md-3"><div class="card stat-card border-0 shadow-soft"><div class="card-body"><i class="bi bi-stack text-primary fs-3"></i><div class="h3 fw-bold mt-2"><?= $stats['total'] ?></div><span class="text-muted">Total</span></div></div></div>
    <div class="col-md-3"><div class="card stat-card border-0 shadow-soft"><div class="card-body"><i class="bi bi-arrow-repeat text-info fs-3"></i><div class="h3 fw-bold mt-2"><?= $stats['diproses'] ?></div><span class="text-muted">Diproses</span></div></div></div>
    <div class="col-md-3"><div class="card stat-card border-0 shadow-soft"><div class="card-body"><i class="bi bi-check2-circle text-success fs-3"></i><div class="h3 fw-bold mt-2"><?= $stats['selesai'] ?></div><span class="text-muted">Selesai</span></div></div></div>
    <div class="col-md-3"><div class="card stat-card border-0 shadow-soft"><div class="card-body"><i class="bi bi-x-circle text-danger fs-3"></i><div class="h3 fw-bold mt-2"><?= $stats['ditolak'] ?></div><span class="text-muted">Ditolak</span></div></div></div>
</div>
<div class="card border-0 shadow-soft">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Laporan Perlu Ditangani</h5>
        <a href="<?= url('petugas/reports') ?>" class="btn btn-primary btn-sm">Lihat semua</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Judul</th><th>Kategori</th><th>Lokasi</th><th>Status</th></tr></thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                    <tr><td class="fw-semibold"><?= $report['judul_laporan'] ?></td><td><?= $report['kategori'] ?></td><td><?= $report['alamat'] ?></td><td><span class="badge badge-status <?= status_class($report['status']) ?>"><?= $report['status'] ?></span></td></tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require APP_ROOT . '/app/views/layouts/dashboard_footer.php'; ?>

