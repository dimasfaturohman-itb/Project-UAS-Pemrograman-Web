<?php require APP_ROOT . '/app/views/layouts/dashboard_header.php'; ?>
<div class="card border-0 shadow-soft">
    <div class="card-header bg-white border-0 py-3"><h5 class="fw-bold mb-0">Kelola User</h5></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable align-middle">
                <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Terdaftar</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="fw-semibold"><?= $user['nama'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><span class="badge bg-primary-subtle text-primary-emphasis"><?= ucfirst($user['role']) ?></span></td>
                        <td><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                        <td>
                            <div class="d-flex gap-2">
                                <form method="post" action="<?= url('admin/users/' . $user['id'] . '/role') ?>" class="d-flex gap-2">
                                    <?= csrf_field() ?>
                                    <select name="role" class="form-select form-select-sm">
                                        <?php foreach (['admin', 'petugas', 'user'] as $role): ?><option value="<?= $role ?>" <?= $user['role'] === $role ? 'selected' : '' ?>><?= ucfirst($role) ?></option><?php endforeach; ?>
                                    </select>
                                    <button class="btn btn-sm btn-outline-primary"><i class="bi bi-save"></i></button>
                                </form>
                                <?php if ($user['role'] !== 'admin'): ?>
                                <form method="post" action="<?= url('admin/users/' . $user['id'] . '/delete') ?>" onsubmit="return confirm('Hapus user ini?')">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require APP_ROOT . '/app/views/layouts/dashboard_footer.php'; ?>

