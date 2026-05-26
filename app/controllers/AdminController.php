<?php

class AdminController extends Controller
{
    public function dashboard(): void
    {
        Middleware::role(['admin']);
        $reportModel = $this->model('Report');
        $this->view('dashboard/admin', [
            'title' => 'Dashboard Admin',
            'stats' => $reportModel->stats(),
            'statusChart' => $reportModel->stats()['status'],
            'categoryChart' => $reportModel->categoryChart(),
            'monthlyChart' => $reportModel->monthlyChart(),
            'reports' => $reportModel->all(),
            'categories' => $this->model('Category')->all(),
            'statuses' => Report::STATUSES,
        ]);
    }

    public function reports(): void
    {
        Middleware::role(['admin']);
        $this->view('admin/reports', [
            'title' => 'Kelola Laporan',
            'reports' => $this->model('Report')->all($_GET['status'] ?? null, isset($_GET['kategori']) ? (int) $_GET['kategori'] : null),
            'categories' => $this->model('Category')->all(),
            'statuses' => Report::STATUSES,
        ]);
    }

    public function updateStatus(int $id): void
    {
        Middleware::role(['admin']);
        Security::verifyCsrf();
        $status = $_POST['status'] ?? '';
        if (!in_array($status, Report::STATUSES, true)) {
            flash('error', 'Status tidak valid.');
            $this->redirect('admin/reports');
        }

        $reportModel = $this->model('Report');
        $report = $reportModel->find($id);
        $reportModel->updateStatus($id, $status, Security::clean($_POST['catatan_petugas'] ?? ''), null);
        if ($report) {
            $this->model('Notification')->create((int) $report['user_id'], 'Admin mengubah status laporan "' . $report['judul_laporan'] . '" menjadi ' . $status . '.');
        }
        flash('success', 'Status laporan berhasil diperbarui.');
        $this->redirect('admin/reports');
    }

    public function users(): void
    {
        Middleware::role(['admin']);
        $this->view('admin/users', ['title' => 'Kelola User', 'users' => $this->model('User')->all()]);
    }

    public function updateUserRole(int $id): void
    {
        Middleware::role(['admin']);
        Security::verifyCsrf();
        $role = $_POST['role'] ?? 'user';
        if (in_array($role, ['admin', 'petugas', 'user'], true)) {
            $this->model('User')->updateRole($id, $role);
            flash('success', 'Role user diperbarui.');
        }
        $this->redirect('admin/users');
    }

    public function deleteUser(int $id): void
    {
        Middleware::role(['admin']);
        Security::verifyCsrf();
        $this->model('User')->delete($id);
        flash('success', 'User berhasil dihapus.');
        $this->redirect('admin/users');
    }

    public function categories(): void
    {
        Middleware::role(['admin']);
        $this->view('admin/categories', ['title' => 'Kelola Kategori', 'categories' => $this->model('Category')->all()]);
    }

    public function storeCategory(): void
    {
        Middleware::role(['admin']);
        Security::verifyCsrf();
        $this->model('Category')->create([
            'nama' => Security::clean($_POST['nama'] ?? ''),
            'icon' => Security::clean($_POST['icon'] ?? 'bi-tools'),
            'warna' => Security::clean($_POST['warna'] ?? '#0d6efd'),
        ]);
        flash('success', 'Kategori berhasil ditambahkan.');
        $this->redirect('admin/categories');
    }

    public function updateCategory(int $id): void
    {
        Middleware::role(['admin']);
        Security::verifyCsrf();
        $this->model('Category')->update($id, [
            'nama' => Security::clean($_POST['nama'] ?? ''),
            'icon' => Security::clean($_POST['icon'] ?? 'bi-tools'),
            'warna' => Security::clean($_POST['warna'] ?? '#0d6efd'),
        ]);
        flash('success', 'Kategori berhasil diperbarui.');
        $this->redirect('admin/categories');
    }

    public function deleteCategory(int $id): void
    {
        Middleware::role(['admin']);
        Security::verifyCsrf();
        try {
            $this->model('Category')->delete($id);
            flash('success', 'Kategori berhasil dihapus.');
        } catch (PDOException $exception) {
            flash('error', 'Kategori tidak bisa dihapus karena masih digunakan laporan.');
        }
        $this->redirect('admin/categories');
    }

    public function mapData(): void
    {
        Middleware::role(['admin', 'petugas']);
        $this->json(['data' => $this->model('Report')->all($_GET['status'] ?? null, isset($_GET['kategori']) ? (int) $_GET['kategori'] : null)]);
    }

    public function exportPdf(): void
    {
        Middleware::role(['admin']);
        $reports = $this->model('Report')->all();
        $this->view('admin/export_pdf', ['title' => 'Export Laporan', 'reports' => $reports]);
    }
}
