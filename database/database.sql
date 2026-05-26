CREATE DATABASE IF NOT EXISTS db_pelaporan_fasilitas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_pelaporan_fasilitas;

DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS reports;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'petugas', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(120) NOT NULL,
    icon VARCHAR(80) NOT NULL DEFAULT 'bi-tools',
    warna VARCHAR(20) NOT NULL DEFAULT '#0d6efd',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    kategori_id INT NOT NULL,
    judul_laporan VARCHAR(160) NOT NULL,
    deskripsi TEXT NOT NULL,
    foto VARCHAR(255) NOT NULL,
    latitude DECIMAL(10, 8) NULL,
    longitude DECIMAL(11, 8) NULL,
    alamat TEXT NOT NULL,
    status ENUM('Menunggu Verifikasi', 'Diproses', 'Dalam Perbaikan', 'Selesai', 'Ditolak') NOT NULL DEFAULT 'Menunggu Verifikasi',
    catatan_petugas TEXT NULL,
    bukti_perbaikan VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_reports_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_reports_category FOREIGN KEY (kategori_id) REFERENCES categories(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message VARCHAR(255) NOT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_notifications_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO users (id, nama, email, password, role) VALUES
(1, 'Administrator', 'admin@gmail.com', SHA2('admin123', 256), 'admin'),
(2, 'Petugas Lapangan', 'petugas@gmail.com', SHA2('petugas123', 256), 'petugas'),
(3, 'Masyarakat Demo', 'user@gmail.com', SHA2('user123', 256), 'user');

INSERT INTO categories (id, nama, icon, warna) VALUES
(1, 'Bangku taman rusak', 'bi-tree', '#14b8a6'),
(2, 'Trotoar rusak', 'bi-signpost-split', '#0d6efd'),
(3, 'Drainase tersumbat', 'bi-water', '#06b6d4'),
(4, 'Halte rusak', 'bi-bus-front', '#7c3aed'),
(5, 'Lampu jalan mati', 'bi-lightbulb-off', '#f59e0b'),
(6, 'Jalan berlubang', 'bi-cone-striped', '#ef4444');

INSERT INTO reports
(user_id, kategori_id, judul_laporan, deskripsi, foto, latitude, longitude, alamat, status, catatan_petugas, created_at)
VALUES
(3, 6, 'Jalan berlubang dekat pertigaan pasar', 'Lubang cukup dalam dan membahayakan pengendara motor saat malam hari.', 'reports/sample-road.svg', -6.20000000, 106.81666600, 'Jl. Medan Merdeka Selatan, Jakarta Pusat', 'Diproses', 'Sudah diteruskan ke tim perbaikan jalan.', DATE_SUB(NOW(), INTERVAL 6 DAY)),
(3, 5, 'Lampu jalan mati di area taman', 'Tiga lampu jalan mati sehingga area menjadi gelap.', 'reports/sample-light.svg', -6.17539200, 106.82715300, 'Area Monas, Jakarta Pusat', 'Dalam Perbaikan', 'Petugas sedang mengecek jaringan listrik.', DATE_SUB(NOW(), INTERVAL 4 DAY)),
(3, 3, 'Drainase tersumbat setelah hujan', 'Air menggenang karena saluran penuh sampah.', 'reports/sample-drain.svg', -6.22972800, 106.68943100, 'Ciledug, Tangerang', 'Menunggu Verifikasi', NULL, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(3, 1, 'Bangku taman patah', 'Bangku taman tidak bisa digunakan dan memiliki bagian besi tajam.', 'reports/sample-bench.svg', -6.30244500, 106.89515600, 'Taman Mini, Jakarta Timur', 'Selesai', 'Bangku sudah diganti.', DATE_SUB(NOW(), INTERVAL 20 DAY)),
(3, 2, 'Trotoar retak dan tidak rata', 'Pejalan kaki kesulitan lewat, terutama pengguna kursi roda.', 'reports/sample-sidewalk.svg', -6.24430000, 106.79910000, 'Jl. Sudirman, Jakarta Selatan', 'Ditolak', 'Lokasi masuk area perbaikan proyek berjalan.', DATE_SUB(NOW(), INTERVAL 12 DAY));

INSERT INTO notifications (user_id, message, is_read) VALUES
(3, 'Status laporan "Jalan berlubang dekat pertigaan pasar" diperbarui menjadi Diproses.', 0),
(3, 'Status laporan "Bangku taman patah" diperbarui menjadi Selesai.', 0);
