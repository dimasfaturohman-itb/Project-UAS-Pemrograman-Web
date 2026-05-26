<?php

class Notification extends Model
{
    public function create(int $userId, string $message): bool
    {
        $stmt = $this->db->prepare('INSERT INTO notifications (user_id, message) VALUES (?, ?)');
        return $stmt->execute([$userId, $message]);
    }

    public function latestForUser(int $userId, int $limit = 5): array
    {
        $stmt = $this->db->prepare('SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT ' . (int) $limit);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function markRead(int $userId): void
    {
        $stmt = $this->db->prepare('UPDATE notifications SET is_read = 1 WHERE user_id = ?');
        $stmt->execute([$userId]);
    }
}

