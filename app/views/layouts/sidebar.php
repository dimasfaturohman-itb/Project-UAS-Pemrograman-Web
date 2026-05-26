<?php $role = current_user()['role']; ?>
<aside class="sidebar">
    <a href="<?= url('/') ?>" class="sidebar-brand">
        <span class="feature-icon"><i class="bi bi-buildings"></i></span>
        <span>Pelaporan<br>Fasilitas</span>
    </a>
    <nav class="nav flex-column">
        <?php if ($role === 'admin'): ?>
            <a class="nav-link <?= is_active('admin/dashboard') ?>" href="<?= url('admin/dashboard') ?>"><i class="bi bi-grid-1x2"></i> Dashboard</a>
            <a class="nav-link <?= is_active('admin/reports') ?>" href="<?= url('admin/reports') ?>"><i class="bi bi-clipboard-data"></i> Kelola Laporan</a>
            <a class="nav-link <?= is_active('admin/users') ?>" href="<?= url('admin/users') ?>"><i class="bi bi-people"></i> Kelola User</a>
            <a class="nav-link <?= is_active('admin/categories') ?>" href="<?= url('admin/categories') ?>"><i class="bi bi-tags"></i> Kategori</a>
            <a class="nav-link" href="<?= url('admin/export-pdf') ?>" target="_blank"><i class="bi bi-filetype-pdf"></i> Export PDF</a>
        <?php elseif ($role === 'petugas'): ?>
            <a class="nav-link <?= is_active('petugas/dashboard') ?>" href="<?= url('petugas/dashboard') ?>"><i class="bi bi-grid-1x2"></i> Dashboard</a>
            <a class="nav-link <?= is_active('petugas/reports') ?>" href="<?= url('petugas/reports') ?>"><i class="bi bi-tools"></i> Laporan Masuk</a>
        <?php else: ?>
            <a class="nav-link <?= is_active('user/dashboard') ?>" href="<?= url('user/dashboard') ?>"><i class="bi bi-grid-1x2"></i> Dashboard</a>
            <a class="nav-link <?= is_active('user/reports/create') ?>" href="<?= url('user/reports/create') ?>"><i class="bi bi-plus-circle"></i> Buat Laporan</a>
            <a class="nav-link <?= is_active('user/reports') ?>" href="<?= url('user/reports') ?>"><i class="bi bi-clock-history"></i> Riwayat</a>
            <a class="nav-link <?= is_active('user/profile') ?>" href="<?= url('user/profile') ?>"><i class="bi bi-person"></i> Profil</a>
        <?php endif; ?>
        <hr class="border-light opacity-25">
        <a class="nav-link" href="<?= url('logout') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </nav>
</aside>

