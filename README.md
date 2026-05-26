# Sistem Pelaporan Fasilitas Umum Rusak

Project web full stack PHP Native MVC + MySQL + Bootstrap 5 untuk pelaporan fasilitas umum rusak oleh masyarakat, petugas, dan admin.

## Fitur Utama

- Landing page modern dan responsif.
- Login, register, logout, session, role middleware, CSRF protection.
- Role: Admin, Petugas, Masyarakat/User.
- User dapat membuat laporan, upload foto, ambil GPS otomatis, melihat riwayat, tracking status, dan notifikasi.
- Petugas dapat melihat laporan masuk, update status, upload bukti perbaikan, dan menambah catatan.
- Admin dapat mengelola laporan, user, kategori, statistik, grafik Chart.js, peta Leaflet OpenStreetMap, filter, dan export PDF sederhana via print browser.
- DataTables untuk pencarian, pagination, dan tabel responsif.
- SweetAlert2 untuk alert.
- Query database memakai PDO prepared statement.

## Struktur Folder

```text
app/
  controllers/
  core/
  models/
  views/
config/
database/
public/
  assets/
uploads/
  reports/
  repairs/
```

## Instalasi di XAMPP

Kebutuhan minimum: PHP 8.0+, MySQL/MariaDB, ekstensi PDO MySQL, dan Apache `mod_rewrite` aktif.

1. Salin folder project ini ke:

```text
C:\xampp\htdocs\pelaporan-fasilitas
```

2. Buka XAMPP Control Panel, jalankan Apache dan MySQL.

3. Buka phpMyAdmin:

```text
http://localhost/phpmyadmin
```

4. Import file:

```text
database/database.sql
```

5. Sesuaikan konfigurasi bila perlu di:

```text
config/database.php
config/config.php
```

Default `BASE_URL` sudah disiapkan untuk:

```php
http://localhost/pelaporan-fasilitas/public
```

6. Buka aplikasi:

```text
http://localhost/pelaporan-fasilitas/public
```

## Instalasi di Laragon

1. Salin folder project ke:

```text
C:\laragon\www\pelaporan-fasilitas
```

2. Jalankan Laragon, aktifkan Apache/Nginx dan MySQL.

3. Import `database/database.sql` melalui HeidiSQL/phpMyAdmin/Adminer.

4. Buka:

```text
http://localhost/pelaporan-fasilitas/public
```

Jika memakai pretty host Laragon seperti `http://pelaporan-fasilitas.test`, ubah `BASE_URL` di `config/config.php`.

## Akun Default

```text
Admin
Email: admin@gmail.com
Password: admin123

Petugas
Email: petugas@gmail.com
Password: petugas123

User
Email: user@gmail.com
Password: user123
```

Catatan: akun default di SQL memakai hash awal yang otomatis di-upgrade menjadi `password_hash()` saat login pertama. Akun baru dari register langsung memakai `password_hash()`.

## Catatan Upload

Pastikan folder berikut bisa ditulis oleh server:

```text
uploads/reports
uploads/repairs
```

Format foto yang diterima: JPG, PNG, WebP dengan ukuran maksimal 2MB.

## Export PDF

Masuk sebagai admin, buka menu `Export PDF`, lalu gunakan tombol `Cetak / Simpan PDF` dari browser.
