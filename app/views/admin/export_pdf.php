<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; }
        @media print { .no-print { display:none; } }
    </style>
</head>
<body class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Rekap Laporan Fasilitas Umum Rusak</h2>
            <p class="text-muted mb-0">Dicetak pada <?= date('d M Y H:i') ?></p>
        </div>
        <button class="btn btn-primary no-print" onclick="window.print()">Cetak / Simpan PDF</button>
    </div>
    <table class="table table-bordered table-sm">
        <thead class="table-light"><tr><th>No</th><th>Judul</th><th>Pelapor</th><th>Kategori</th><th>Status</th><th>Alamat</th><th>Tanggal</th></tr></thead>
        <tbody>
            <?php foreach ($reports as $index => $report): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $report['judul_laporan'] ?></td>
                    <td><?= $report['pelapor'] ?></td>
                    <td><?= $report['kategori'] ?></td>
                    <td><?= $report['status'] ?></td>
                    <td><?= $report['alamat'] ?></td>
                    <td><?= date('d M Y', strtotime($report['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

