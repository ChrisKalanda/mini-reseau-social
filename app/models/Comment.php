<?php
require_once __DIR__ . '/Database.php';

class Comment
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function getByPost(int $postId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT c.*, u.username, u.avatar
             FROM comments c
             JOIN users u ON c.user_id = u.id
             WHERE c.post_id = :post_id
             ORDER BY c.created_at ASC'
        );
        $stmt->execute([':post_id' => $postId]);
        return $stmt->fetchAll();
    }

    public function add(int $postId, int $userId, string $content): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO comments (post_id, user_id, content) VALUES (:post_id, :user_id, :content)'
        );
        return $stmt->execute([
            ':post_id' => $postId,
            ':user_id' => $userId,
            ':content' => $content,
        ]);
    }

    public function delete(int $id, int $userId): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM comments WHERE id = :id AND user_id = :user_id'
        );
        return $stmt->execute([':id' => $id, ':user_id' => $userId]);
    }
}
