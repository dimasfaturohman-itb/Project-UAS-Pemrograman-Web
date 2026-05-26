<?php

function url(string $path = ''): string
{
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function upload_url(string $path): string
{
    return rtrim(str_replace('/public', '', BASE_URL), '/') . '/uploads/' . ltrim($path, '/');
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . Security::csrfToken() . '">';
}

function flash(?string $type = null, ?string $message = null): ?array
{
    if ($type !== null && $message !== null) {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
        return null;
    }

    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_active(string $path): string
{
    $current = trim($_GET['url'] ?? 'home', '/');
    return str_starts_with($current, trim($path, '/')) ? 'active' : '';
}

function rupiah_number(int $number): string
{
    return number_format($number, 0, ',', '.');
}

function status_class(string $status): string
{
    return match ($status) {
        'Menunggu Verifikasi' => 'bg-warning-subtle text-warning-emphasis',
        'Diproses' => 'bg-primary-subtle text-primary-emphasis',
        'Dalam Perbaikan' => 'bg-info-subtle text-info-emphasis',
        'Selesai' => 'bg-success-subtle text-success-emphasis',
        'Ditolak' => 'bg-danger-subtle text-danger-emphasis',
        default => 'bg-secondary-subtle text-secondary-emphasis',
    };
}
