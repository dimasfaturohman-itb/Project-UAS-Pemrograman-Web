<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Dashboard' ?> - <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css" rel="stylesheet">
    <link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet">
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
</head>
<body>
<div class="dashboard-layout">
    <?php require APP_ROOT . '/app/views/layouts/sidebar.php'; ?>
    <main class="main-content">
        <nav class="topbar d-flex align-items-center px-3 px-lg-4 sticky-top">
            <button class="btn btn-light d-lg-none me-3" data-sidebar-toggle aria-label="Toggle menu"><i class="bi bi-list"></i></button>
            <div>
                <div class="fw-bold"><?= $title ?? 'Dashboard' ?></div>
                <small class="text-muted">Kelola laporan fasilitas umum secara cepat dan transparan</small>
            </div>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="badge bg-primary-subtle text-primary-emphasis"><?= ucfirst(current_user()['role']) ?></span>
                <div class="fw-semibold d-none d-sm-block"><?= current_user()['nama'] ?></div>
            </div>
        </nav>
        <section class="content-wrap">

