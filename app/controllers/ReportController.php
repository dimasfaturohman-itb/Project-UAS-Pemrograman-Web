<?php

class ReportController extends Controller
{
    public function create(): void
    {
        Middleware::role(['user']);
        $this->view('reports/create', [
            'title' => 'Buat Laporan',
            'categories' => $this->model('Category')->all(),
        ]);
    }

    public function store(): void
    {
        Middleware::role(['user']);
        Security::verifyCsrf();

        $foto = $this->uploadImage($_FILES['foto'] ?? null, 'reports');
        if ($foto === null) {
            flash('error', 'Foto wajib diunggah dalam format JPG, PNG, atau WebP maksimal 2MB.');
            $this->redirect('user/reports/create');
        }

        $data = [
            'user_id' => current_user()['id'],
            'kategori_id' => (int) ($_POST['kategori_id'] ?? 0),
            'judul_laporan' => Security::clean($_POST['judul_laporan'] ?? ''),
            'deskripsi' => Security::clean($_POST['deskripsi'] ?? ''),
            'foto' => $foto,
            'latitude' => ($_POST['latitude'] ?? '') !== '' ? (float) $_POST['latitude'] : null,
            'longitude' => ($_POST['longitude'] ?? '') !== '' ? (float) $_POST['longitude'] : null,
            'alamat' => Security::clean($_POST['alamat'] ?? ''),
        ];

        if (!$data['kategori_id'] || $data['judul_laporan'] === '' || $data['deskripsi'] === '' || $data['alamat'] === '') {
            flash('error', 'Semua data laporan wajib diisi.');
            $this->redirect('user/reports/create');
        }

        $this->model('Report')->create($data);
        flash('success', 'Laporan berhasil dikirim dan menunggu verifikasi.');
        $this->redirect('user/reports');
    }

    public function history(): void
    {
        Middleware::role(['user']);
        $this->view('reports/history', [
            'title' => 'Riwayat Laporan',
            'reports' => $this->model('Report')->byUser((int) current_user()['id']),
        ]);
    }

    public function show(int $id): void
    {
        Middleware::auth();
        $report = $this->model('Report')->find($id);
        if (!$report || (current_user()['role'] === 'user' && (int) $report['user_id'] !== (int) current_user()['id'])) {
            http_response_code(404);
            exit('Laporan tidak ditemukan.');
        }

        $this->view('reports/show', ['title' => 'Detail Laporan', 'report' => $report]);
    }

    private function uploadImage(?array $file, string $folder): ?string
    {
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            return null;
        }

        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $mime = mime_content_type($file['tmp_name']);
        if (!isset($allowed[$mime])) {
            return null;
        }

        $name = $folder . '/' . date('YmdHis') . '_' . bin2hex(random_bytes(6)) . '.' . $allowed[$mime];
        $target = UPLOAD_PATH . $name;
        if (!is_dir(dirname($target))) {
            mkdir(dirname($target), 0775, true);
        }

        return move_uploaded_file($file['tmp_name'], $target) ? $name : null;
    }
}
