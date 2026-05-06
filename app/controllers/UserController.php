<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../config/config.php';

class UserController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email    = trim($_POST['email']    ?? '');
            $password =      $_POST['password'] ?? '';

            $errors = [];
            if (empty($username))                                          $errors[] = __('error.username_required');
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = __('error.email_invalid');
            if (strlen($password) < 6)                                     $errors[] = __('error.password_too_short');
            if ($this->userModel->findByUsername($username))               $errors[] = __('error.username_taken');
            if ($this->userModel->findByEmail($email))                     $errors[] = __('error.email_taken');

            if (empty($errors)) {
                $this->userModel->register($username, $email, $password);
                header('Location: ' . BASE_URL . '/index.php?page=login');
                exit;
            }
            require __DIR__ . '/../views/user/register.php';
            return;
        }
        require __DIR__ . '/../views/user/register.php';
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email']    ?? '');
            $password =      $_POST['password'] ?? '';

            $user = $this->userModel->login($email, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: ' . BASE_URL . '/index.php?page=feed');
                exit;
            }
            $error = __('error.wrong_credentials');
            require __DIR__ . '/../views/user/login.php';
            return;
        }
        require __DIR__ . '/../views/user/login.php';
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: ' . BASE_URL . '/index.php?page=login');
        exit;
    }

    public function profile(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user']['id'];
        $user   = $this->userModel->findById($userId);

        require_once __DIR__ . '/../models/Post.php';
        $postModel = new Post();
        $posts = $postModel->getByUser($userId);

        require __DIR__ . '/../views/user/profile.php';
    }

    public function editProfile(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user']['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bio    = trim($_POST['bio'] ?? '');
            $avatar = null;

            if (!empty($_FILES['avatar']['name'])) {
                $avatar = $this->handleUpload($_FILES['avatar']);
                if (!$avatar) {
                    $error = __('error.invalid_file');
                    $user  = $this->userModel->findById($userId);
                    require __DIR__ . '/../views/user/edit_profile.php';
                    return;
                }
            }

            $this->userModel->updateProfile($userId, $bio, $avatar);
            header('Location: ' . BASE_URL . '/index.php?page=profile');
            exit;
        }
        $user = $this->userModel->findById($userId);
        require __DIR__ . '/../views/user/edit_profile.php';
    }

    private function handleUpload(array $file): string|false
    {
        if ($file['size'] > MAX_FILE_SIZE) return false;
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, ALLOWED_TYPES, true)) return false;

        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('avatar_', true) . '.' . $ext;
        move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $filename);
        return $filename;
    }

    private function requireAuth(): void
    {
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/index.php?page=login');
            exit;
        }
    }
}
