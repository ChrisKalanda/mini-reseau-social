<?php
require_once __DIR__ . '/Database.php';

class User
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function findByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function findByUsername(string $username): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = :username LIMIT 1');
        $stmt->execute([':username' => $username]);
        return $stmt->fetch();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function register(string $username, string $email, string $password): bool
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)'
        );
        return $stmt->execute([
            ':username' => $username,
            ':email'    => $email,
            ':password' => $hash,
        ]);
    }

    public function login(string $email, string $password): array|false
    {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function updateProfile(int $id, string $bio, ?string $avatar): bool
    {
        if ($avatar) {
            $stmt = $this->pdo->prepare(
                'UPDATE users SET bio = :bio, avatar = :avatar WHERE id = :id'
            );
            return $stmt->execute([':bio' => $bio, ':avatar' => $avatar, ':id' => $id]);
        }
        $stmt = $this->pdo->prepare('UPDATE users SET bio = :bio WHERE id = :id');
        return $stmt->execute([':bio' => $bio, ':id' => $id]);
    }
}
