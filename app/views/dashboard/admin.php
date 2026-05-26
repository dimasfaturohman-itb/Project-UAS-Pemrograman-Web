<?php require APP_ROOT . '/app/views/layouts/dashboard_header.php'; ?>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-soft">
            <div class="card-body">
                <i class="bi bi-stack text-primary fs-3"></i>
                <div class="h3 fw-bold mt-2"><?= $stats['total'] ?></div>
                <span class="text-muted">Total Laporan</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-soft">
            <div class="card-body">
                <i class="bi bi-arrow-repeat text-info fs-3"></i>
                <div class="h3 fw-bold mt-2"><?= $stats['diproses'] ?></div>
                <span class="text-muted">Diproses</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-soft">
            <div class="card-body">
                <i class="bi bi-check2-circle text-success fs-3"></i>
                <div class="h3 fw-bold mt-2"><?= $stats['selesai'] ?></div>
                <span class="text-muted">Selesai</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-soft">
            <div class="card-body">
                <i class="bi bi-x-circle text-danger fs-3"></i>
                <div class="h3 fw-bold mt-2"><?= $stats['ditolak'] ?></div>
                <span class="text-muted">Ditolak</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4 align-items-stretch">
    <div class="col-lg-4">
        <div class="card border-0 shadow-soft chart-card h-100">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Status Laporan</h5>
                <div class="chart-wrap">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-soft chart-card h-100">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Kategori Kerusakan</h5>
                <div class="chart-wrap">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-soft chart-card h-100">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Laporan Bulanan</h5>
                <div class="chart-wrap">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-soft mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
            <h5 class="fw-bold mb-0">Peta Monitoring Kerusakan</h5>

            <div class="d-flex gap-2">
                <select id="mapCategory" class="form-select form-select-sm">
                    <option value="">Semua kategori</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= $category['nama'] ?></option>
                    <?php endforeach; ?>
                </select>

                <select id="mapStatus" class="form-select form-select-sm">
                    <option value="">Semua status</option>
                    <?php foreach ($statuses as $status): ?>
                        <option value="<?= $status ?>"><?= $status ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div id="monitorMap" class="map-box"></div>
    </div>
</div>

<div class="card border-0 shadow-soft">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Laporan Terbaru</h5>
        <a href="<?= url('admin/reports') ?>" class="btn btn-outline-primary btn-sm">Kelola semua</a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable align-middle">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td><?= $report['judul_laporan'] ?></td>
                            <td><?= $report['pelapor'] ?></td>
                            <td><?= $report['kategori'] ?></td>
                            <td>
                                <span class="badge badge-status <?= status_class($report['status']) ?>">
                                    <?= $report['status'] ?>
                                </span>
                            </td>
                            <td><?= date('d M Y', strtotime($report['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php ob_start(); ?>
<script>
new Chart(document.getElementById('statusChart'), {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_keys($statusChart)) ?>,
        datasets: [{
            data: <?= json_encode(array_values($statusChart)) ?>,
            backgroundColor: ['#f59e0b', '#0d6efd', '#06b6d4', '#22c55e', '#ef4444'],
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    boxWidth: 14,
                    padding: 14
                }
            }
        }
    }
});

new Chart(document.getElementById('categoryChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($categoryChart, 'nama')) ?>,
        datasets: [{
            label: 'Laporan',
            data: <?= json_encode(array_map('intval', array_column($categoryChart, 'total'))) ?>,
            backgroundColor: '#14b8a6',
            borderRadius: 8
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});

new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode(array_column($monthlyChart, 'bulan')) ?>,
        datasets: [{
            label: 'Laporan',
            data: <?= json_encode(array_map('intval', array_column($monthlyChart, 'total'))) ?>,
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, .12)',
            fill: true,
            tension: .35,
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});

const markerColors = {
    'Menunggu Verifikasi': 'orange',
    'Diproses': 'blue',
    'Dalam Perbaikan': 'cyan',
    'Selesai': 'green',
    'Ditolak': 'red'
};

const map = L.map('monitorMap').setView([-6.7645, 108.4780], 11);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
}).addTo(map);

let layer = L.layerGroup().addTo(map);

function markerIcon(status) {
    return L.divIcon({
        className: '',
        html: `<span style="background:${markerColors[status] || 'gray'};width:18px;height:18px;border-radius:50%;display:block;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,.3)"></span>`
    });
}

function loadMap() {
    const params = new URLSearchParams({
        status: document.getElementById('mapStatus').value,
        kategori: document.getElementById('mapCategory').value
    });

    fetch('<?= url('admin/map-data') ?>?' + params)
        .then(response => response.json())
        .then(({ data }) => {
            layer.clearLayers();

            data.forEach(item => {
                if (!item.latitude || !item.longitude) return;

                L.marker([item.latitude, item.longitude], {
                    icon: markerIcon(item.status)
                })
                .addTo(layer)
                .bindPopup(`
                    <strong>${item.judul_laporan}</strong><br>
                    ${item.kategori}<br>
                    <span class="badge ${statusBadge(item.status)}">${item.status}</span>
                `);
            });
        });
}

document.getElementById('mapStatus').addEventListener('change', loadMap);
document.getElementById('mapCategory').addEventListener('change', loadMap);

loadMap();
</script>
<?php
$extraScripts = ob_get_clean();
require APP_ROOT . '/app/views/layouts/dashboard_footer.php';
?>