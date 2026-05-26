<?php

class Report extends Model
{
    public const STATUSES = [
        'Menunggu Verifikasi',
        'Diproses',
        'Dalam Perbaikan',
        'Selesai',
        'Ditolak',
    ];

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO reports (user_id, kategori_id, judul_laporan, deskripsi, foto, latitude, longitude, alamat, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );

        return $stmt->execute([
            $data['user_id'],
            $data['kategori_id'],
            $data['judul_laporan'],
            $data['deskripsi'],
            $data['foto'],
            $data['latitude'],
            $data['longitude'],
            $data['alamat'],
            'Menunggu Verifikasi',
        ]);
    }

    public function all(?string $status = null, ?int $kategoriId = null): array
    {
        $sql = 'SELECT reports.*, users.nama AS pelapor, categories.nama AS kategori, categories.icon, categories.warna
                FROM reports
                JOIN users ON users.id = reports.user_id
                JOIN categories ON categories.id = reports.kategori_id
                WHERE 1=1';
        $params = [];

        if ($status) {
            $sql .= ' AND reports.status = ?';
            $params[] = $status;
        }

        if ($kategoriId) {
            $sql .= ' AND reports.kategori_id = ?';
            $params[] = $kategoriId;
        }

        $sql .= ' ORDER BY reports.created_at DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function byUser(int $userId): array
    {
        $stmt = $this->db->prepare(
            'SELECT reports.*, categories.nama AS kategori, categories.icon, categories.warna
             FROM reports
             JOIN categories ON categories.id = reports.kategori_id
             WHERE reports.user_id = ?
             ORDER BY reports.created_at DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT reports.*, users.nama AS pelapor, users.email, categories.nama AS kategori, categories.icon, categories.warna
             FROM reports
             JOIN users ON users.id = reports.user_id
             JOIN categories ON categories.id = reports.kategori_id
             WHERE reports.id = ?'
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function updateStatus(int $id, string $status, ?string $catatan, ?string $bukti): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE reports SET status = ?, catatan_petugas = ?, bukti_perbaikan = COALESCE(?, bukti_perbaikan), updated_at = NOW() WHERE id = ?'
        );
        return $stmt->execute([$status, $catatan, $bukti, $id]);
    }

    public function stats(): array
    {
        $total = (int) $this->db->query('SELECT COUNT(*) FROM reports')->fetchColumn();
        $byStatus = [];
        foreach (self::STATUSES as $status) {
            $stmt = $this->db->prepare('SELECT COUNT(*) FROM reports WHERE status = ?');
            $stmt->execute([$status]);
            $byStatus[$status] = (int) $stmt->fetchColumn();
        }

        return [
            'total' => $total,
            'diproses' => $byStatus['Diproses'] + $byStatus['Dalam Perbaikan'],
            'selesai' => $byStatus['Selesai'],
            'ditolak' => $byStatus['Ditolak'],
            'status' => $byStatus,
        ];
    }

    public function categoryChart(): array
    {
        return $this->db->query(
            'SELECT categories.nama, COUNT(reports.id) AS total
             FROM categories
             LEFT JOIN reports ON reports.kategori_id = categories.id
             GROUP BY categories.id, categories.nama
             ORDER BY categories.nama'
        )->fetchAll();
    }

    public function monthlyChart(): array
    {
        return $this->db->query(
            'SELECT DATE_FORMAT(created_at, "%Y-%m") AS bulan, COUNT(*) AS total
             FROM reports
             WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 11 MONTH)
             GROUP BY DATE_FORMAT(created_at, "%Y-%m")
             ORDER BY bulan'
        )->fetchAll();
    }
}

