<?php require APP_ROOT . '/app/views/layouts/dashboard_header.php'; ?>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-soft">
            <img src="<?= upload_url($report['foto']) ?>" class="card-img-top" style="max-height:420px;object-fit:cover" alt="Foto laporan">
            <div class="card-body p-4">
                <span class="badge badge-status <?= status_class($report['status']) ?> mb-3"><?= $report['status'] ?></span>
                <h4 class="fw-bold"><?= $report['judul_laporan'] ?></h4>
                <p class="text-muted"><?= $report['kategori'] ?> oleh <?= $report['pelapor'] ?> pada <?= date('d M Y H:i', strtotime($report['created_at'])) ?></p>
                <p><?= nl2br($report['deskripsi']) ?></p>
                <div class="p-3 bg-light rounded-4"><i class="bi bi-geo-alt text-primary me-2"></i><?= $report['alamat'] ?></div>
                <?php if ($report['catatan_petugas']): ?>
                    <div class="alert alert-info mt-3 mb-0"><strong>Catatan:</strong> <?= $report['catatan_petugas'] ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-soft mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold">Lokasi Kerusakan</h5>
                <div id="detailMap" class="map-box"></div>
            </div>
        </div>
        <?php if ($report['bukti_perbaikan']): ?>
            <div class="card border-0 shadow-soft">
                <div class="card-body p-4">
                    <h5 class="fw-bold">Bukti Perbaikan</h5>
                    <img src="<?= upload_url($report['bukti_perbaikan']) ?>" class="img-fluid rounded-4" alt="Bukti perbaikan">
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php ob_start(); ?>
<script>
const lat = <?= json_encode((float) $report['latitude']) ?>;
const lng = <?= json_encode((float) $report['longitude']) ?>;
const map = L.map('detailMap').setView([lat || -6.7645, lng || 108.4780], lat && lng ? 16 : 11);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);
if (lat && lng) L.marker([lat, lng]).addTo(map).bindPopup(<?= json_encode($report['judul_laporan']) ?>).openPopup();
</script>
<?php $extraScripts = ob_get_clean(); require APP_ROOT . '/app/views/layouts/dashboard_footer.php'; ?>

