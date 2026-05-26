<?php

class AuthController extends Controller
{
    public function login(): void
    {
        $this->view('auth/login', ['title' => 'Login']);
    }

    public function processLogin(): void
    {
        Security::verifyCsrf();
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (!$email || $password === '') {
            flash('error', 'Email atau password tidak valid.');
            $this->redirect('login');
        }

        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);

        $validPassword = $user && password_verify($password, $user['password']);
        $legacySeedPassword = $user && hash_equals($user['password'], hash('sha256', $password));

        if (!$validPassword && !$legacySeedPassword) {
            flash('error', 'Email atau password salah.');
            $this->redirect('login');
        }

        if ($legacySeedPassword) {
            $userModel->updatePasswordHash((int) $user['id'], $password);
        }

        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'nama' => $user['nama'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        $target = match ($user['role']) {
            'admin' => 'admin/dashboard',
            'petugas' => 'petugas/dashboard',
            default => 'user/dashboard',
        };

        flash('success', 'Selamat datang, ' . $user['nama'] . '.');
        $this->redirect($target);
    }

    public function register(): void
    {
        $this->view('auth/register', ['title' => 'Register']);
    }

    public function processRegister(): void
    {
        Security::verifyCsrf();
        $nama = Security::clean($_POST['nama'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        if ($nama === '' || !$email || strlen($password) < 6) {
            flash('error', 'Nama, email, dan password minimal 6 karakter wajib diisi.');
            $this->redirect('register');
        }

        $userModel = $this->model('User');
        if ($userModel->findByEmail($email)) {
            flash('error', 'Email sudah digunakan.');
            $this->redirect('register');
        }

        $userModel->create([
            'nama' => $nama,
            'email' => $email,
            'password' => $password,
            'role' => 'user',
        ]);

        flash('success', 'Registrasi berhasil. Silakan login.');
        $this->redirect('login');
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        header('Location: ' . url('/'));
        exit;
    }
}
