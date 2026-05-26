<?php

class ProfileController extends Controller
{
    public function index(): void
    {
        Middleware::auth();
        $this->view('profile/index', [
            'title' => 'Profil Saya',
            'user' => $this->model('User')->find((int) current_user()['id']),
        ]);
    }

    public function update(): void
    {
        Middleware::auth();
        Security::verifyCsrf();
        $data = [
            'nama' => Security::clean($_POST['nama'] ?? ''),
            'email' => filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL),
            'password' => $_POST['password'] ?? '',
        ];

        if ($data['nama'] === '' || !$data['email']) {
            flash('error', 'Nama dan email wajib valid.');
            $this->redirect('user/profile');
        }

        $this->model('User')->updateProfile((int) current_user()['id'], $data);
        $_SESSION['user']['nama'] = $data['nama'];
        $_SESSION['user']['email'] = $data['email'];
        flash('success', 'Profil berhasil diperbarui.');
        $this->redirect('user/profile');
    }
}

