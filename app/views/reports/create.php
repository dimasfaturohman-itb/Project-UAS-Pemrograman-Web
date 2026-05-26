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

                    <input type="hidden" name="alamat" id="alamat" required>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" id="latitude" class="form-control" readonly required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" id="longitude" class="form-control" readonly required>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3 mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Lokasi laporan akan diambil otomatis dari GPS perangkat Anda.
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <button type="button" class="btn btn-outline-primary" id="getLocation">
                            <i class="bi bi-crosshair me-2"></i>Ambil Lokasi Otomatis
                        </button>

                        <button class="btn btn-primary" id="submitReport" disabled>
                            <i class="bi bi-send me-2"></i>Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-soft">
            <div class="card-body p-4">
                <h5 class="fw-bold">Preview Lokasi</h5>
                <p class="text-muted small mb-3">Marker akan muncul setelah GPS berhasil diambil.</p>
                <div id="createMap" class="map-box"></div>
            </div>
        </div>
    </div>
</div>

<?php ob_start(); ?>
<script>
let map = L.map('createMap').setView([-6.7645, 108.4780], 12);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
}).addTo(map);

let marker;

const latitudeInput = document.getElementById('latitude');
const longitudeInput = document.getElementById('longitude');
const alamatInput = document.getElementById('alamat');
const submitButton = document.getElementById('submitReport');
const getLocationButton = document.getElementById('getLocation');

function setFallbackAddress(lat, lng) {
    alamatInput.value = `Lokasi GPS: ${lat}, ${lng}`;
}

function reverseGeocode(lat, lng) {
    setFallbackAddress(lat, lng);

    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`, {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data && data.display_name) {
            alamatInput.value = data.display_name;
        }
    })
    .catch(() => {
        setFallbackAddress(lat, lng);
    });
}

getLocationButton.addEventListener('click', () => {
    if (!navigator.geolocation) {
        Swal.fire({
            icon: 'warning',
            title: 'GPS tidak tersedia',
            text: 'Browser Anda tidak mendukung geolocation.',
            confirmButtonColor: '#0d6efd'
        });
        return;
    }

    getLocationButton.disabled = true;
    getLocationButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengambil lokasi...';

    navigator.geolocation.getCurrentPosition((position) => {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

        latitudeInput.value = lat;
        longitudeInput.value = lng;

        reverseGeocode(lat, lng);

        map.setView([lat, lng], 16);

        if (marker) {
            marker.remove();
        }

        marker = L.marker([lat, lng])
            .addTo(map)
            .bindPopup('Lokasi laporan otomatis')
            .openPopup();

        submitButton.disabled = false;

        getLocationButton.disabled = false;
        getLocationButton.innerHTML = '<i class="bi bi-crosshair me-2"></i>Ambil Ulang Lokasi';

        Swal.fire({
            icon: 'success',
            title: 'Lokasi berhasil diambil',
            text: 'Koordinat GPS sudah tersimpan untuk laporan ini.',
            confirmButtonColor: '#0d6efd'
        });
    }, () => {
        submitButton.disabled = true;

        getLocationButton.disabled = false;
        getLocationButton.innerHTML = '<i class="bi bi-crosshair me-2"></i>Ambil Lokasi Otomatis';

        Swal.fire({
            icon: 'error',
            title: 'Gagal mengambil lokasi',
            text: 'Izinkan akses lokasi pada browser lalu coba lagi.',
            confirmButtonColor: '#0d6efd'
        });
    }, {
        enableHighAccuracy: true,
        timeout: 15000,
        maximumAge: 0
    });
});

document.getElementById('reportForm').addEventListener('submit', (event) => {
    if (!latitudeInput.value || !longitudeInput.value || !alamatInput.value) {
        event.preventDefault();

        Swal.fire({
            icon: 'warning',
            title: 'Lokasi belum diambil',
            text: 'Klik tombol Ambil Lokasi Otomatis terlebih dahulu.',
            confirmButtonColor: '#0d6efd'
        });
    }
});
</script>
<?php
$extraScripts = ob_get_clean();
require APP_ROOT . '/app/views/layouts/dashboard_footer.php';
?>
