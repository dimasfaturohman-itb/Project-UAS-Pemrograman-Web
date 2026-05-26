<?php require APP_ROOT . '/app/views/layouts/dashboard_header.php'; ?>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-soft">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Form Laporan Kerusakan</h5>
                <form action="<?= url('user/reports/store') ?>" method="post" enctype="multipart/form-data" id="reportForm">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">Pilih kategori</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>"><?= $category['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul Laporan</label>
                        <input type="text" name="judul_laporan" class="form-control" maxlength="150" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto Kerusakan</label>
                        <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp" required>
                        <small class="text-muted">Format JPG, PNG, WebP. Maksimal 2MB.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Lokasi</label>
                        <textarea name="alamat" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Latitude</label><input type="text" name="latitude" id="latitude" class="form-control" readonly></div>
                        <div class="col-md-6"><label class="form-label">Longitude</label><input type="text" name="longitude" id="longitude" class="form-control" readonly></div>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <button type="button" class="btn btn-outline-primary" id="getLocation"><i class="bi bi-crosshair me-2"></i>Ambil GPS</button>
                        <button class="btn btn-primary"><i class="bi bi-send me-2"></i>Kirim Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-soft">
            <div class="card-body p-4">
                <h5 class="fw-bold">Preview Lokasi</h5>
                <div id="createMap" class="map-box"></div>
            </div>
        </div>
    </div>
</div>
<?php ob_start(); ?>
<script>
let map = L.map('createMap').setView([-6.7645, 108.4780], 12);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);
let marker;
document.getElementById('getLocation').addEventListener('click', () => {
    if (!navigator.geolocation) {
        Swal.fire('GPS tidak tersedia', 'Browser Anda tidak mendukung geolocation.', 'warning');
        return;
    }
    navigator.geolocation.getCurrentPosition((pos) => {
        const lat = pos.coords.latitude;
        const lng = pos.coords.longitude;
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        map.setView([lat, lng], 16);
        if (marker) marker.remove();
        marker = L.marker([lat, lng]).addTo(map).bindPopup('Lokasi laporan').openPopup();
    }, () => Swal.fire('Gagal mengambil GPS', 'Izinkan akses lokasi lalu coba lagi.', 'error'));
});
</script>
<?php $extraScripts = ob_get_clean(); require APP_ROOT . '/app/views/layouts/dashboard_footer.php'; ?>

