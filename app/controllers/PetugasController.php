<?php

class PetugasController extends Controller
{
    public function dashboard(): void
    {
        Middleware::role(['petugas']);
        $reportModel = $this->model('Report');
        $this->view('dashboard/petugas', [
            'title' => 'Dashboard Petugas',
            'stats' => $reportModel->stats(),
            'reports' => array_slice($reportModel->all(), 0, 8),
        ]);
    }

    public function reports(): void
    {
        Middleware::role(['petugas']);
        $this->view('petugas/reports', [
            'title' => 'Laporan Masuk',
            'reports' => $this->model('Report')->all($_GET['status'] ?? null),
            'statuses' => Report::STATUSES,
        ]);
    }

    public function updateStatus(int $id): void
    {
        Middleware::role(['petugas']);
        Security::verifyCsrf();
        $this->saveStatus($id);
        flash('success', 'Status laporan berhasil diperbarui.');
        $this->redirect('petugas/reports');
    }

    protected function saveStatus(int $id): void
    {
        $status = $_POST['status'] ?? '';
        if (!in_array($status, Report::STATUSES, true)) {
            flash('error', 'Status tidak valid.');
            $this->redirect('petugas/reports');
        }

        $bukti = $this->uploadRepairProof($_FILES['bukti_perbaikan'] ?? null);
        $catatan = Security::clean($_POST['catatan_petugas'] ?? '');
        $reportModel = $this->model('Report');
        $report = $reportModel->find($id);
        $reportModel->updateStatus($id, $status, $catatan, $bukti);

        if ($report) {
            $this->model('Notification')->create((int) $report['user_id'], 'Status laporan "' . $report['judul_laporan'] . '" diperbarui menjadi ' . $status . '.');
        }
    }

    private function uploadRepairProof(?array $file): ?string
    {
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $mime = mime_content_type($file['tmp_name']);
        if (($file['size'] ?? 0) > 2 * 1024 * 1024 || !isset($allowed[$mime])) {
            return null;
        }

        $name = 'repairs/' . date('YmdHis') . '_' . bin2hex(random_bytes(6)) . '.' . $allowed[$mime];
        return move_uploaded_file($file['tmp_name'], UPLOAD_PATH . $name) ? $name : null;
    }
}

