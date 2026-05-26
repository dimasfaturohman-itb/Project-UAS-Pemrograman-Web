<?php

class Middleware
{
    public static function auth(): void
    {
        if (empty($_SESSION['user'])) {
            flash('warning', 'Silakan login terlebih dahulu.');
            header('Location: ' . url('login'));
            exit;
        }
    }

    public static function role(array $roles): void
    {
        self::auth();
        if (!in_array($_SESSION['user']['role'], $roles, true)) {
            http_response_code(403);
            exit('Akses ditolak.');
        }
    }
}

