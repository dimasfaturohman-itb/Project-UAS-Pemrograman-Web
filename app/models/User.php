<?php

class User extends Model
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT id, nama, email, role, created_at FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function all(): array
    {
        return $this->db->query('SELECT id, nama, email, role, created_at FROM users ORDER BY created_at DESC')->fetchAll();
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)');
        return $stmt->execute([
            $data['nama'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role'] ?? 'user',
        ]);
    }

    public function updateProfile(int $id, array $data): bool
    {
        if (!empty($data['password'])) {
            $stmt = $this->db->prepare('UPDATE users SET nama = ?, email = ?, password = ? WHERE id = ?');
            return $stmt->execute([$data['nama'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT), $id]);
        }

        $stmt = $this->db->prepare('UPDATE users SET nama = ?, email = ? WHERE id = ?');
        return $stmt->execute([$data['nama'], $data['email'], $id]);
    }

    public function updatePasswordHash(int $id, string $password): bool
    {
        $stmt = $this->db->prepare('UPDATE users SET password = ? WHERE id = ?');
        return $stmt->execute([password_hash($password, PASSWORD_DEFAULT), $id]);
    }

    public function updateRole(int $id, string $role): bool
    {
        $stmt = $this->db->prepare('UPDATE users SET role = ? WHERE id = ?');
        return $stmt->execute([$role, $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = ? AND role != "admin"');
        return $stmt->execute([$id]);
    }
}
