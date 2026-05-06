<?php
require_once __DIR__ . '/Database.php';

class Post
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT p.*, u.username, u.avatar
             FROM posts p
             JOIN users u ON p.user_id = u.id
             ORDER BY p.created_at DESC'
        );
        return $stmt->fetchAll();
    }

    public function getByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC'
        );
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->pdo->prepare(
            'SELECT p.*, u.username, u.avatar
             FROM posts p
             JOIN users u ON p.user_id = u.id
             WHERE p.id = :id LIMIT 1'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function create(int $userId, string $image, string $description): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO posts (user_id, image, description) VALUES (:user_id, :image, :description)'
        );
        return $stmt->execute([
            ':user_id'     => $userId,
            ':image'       => $image,
            ':description' => $description,
        ]);
    }

    public function update(int $id, int $userId, string $description): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE posts SET description = :description WHERE id = :id AND user_id = :user_id'
        );
        return $stmt->execute([
            ':description' => $description,
            ':id'          => $id,
            ':user_id'     => $userId,
        ]);
    }

    public function delete(int $id, int $userId): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM posts WHERE id = :id AND user_id = :user_id'
        );
        return $stmt->execute([':id' => $id, ':user_id' => $userId]);
    }
}
