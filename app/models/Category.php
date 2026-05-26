<?php

class Category extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM categories ORDER BY nama ASC')->fetchAll();
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO categories (nama, icon, warna) VALUES (?, ?, ?)');
        return $stmt->execute([$data['nama'], $data['icon'], $data['warna']]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE categories SET nama = ?, icon = ?, warna = ? WHERE id = ?');
        return $stmt->execute([$data['nama'], $data['icon'], $data['warna'], $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM categories WHERE id = ?');
        return $stmt->execute([$id]);
    }
}

