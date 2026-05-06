<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../../config/config.php';

class PostController
{
    private Post    $postModel;
    private Comment $commentModel;

    public function __construct()
    {
        $this->postModel    = new Post();
        $this->commentModel = new Comment();
    }

    public function feed(): void
    {
        $this->requireAuth();
        $posts = $this->postModel->getAll();
        require __DIR__ . '/../views/post/feed.php';
    }

    public function create(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = trim($_POST['description'] ?? '');
            $image = $this->handleUpload($_FILES['image'] ?? []);

            if (!$image) {
                $error = __('error.invalid_image');
                require __DIR__ . '/../views/post/create.php';
                return;
            }

            $this->postModel->create($_SESSION['user']['id'], $image, $description);
            header('Location: ' . BASE_URL . '/index.php?page=feed');
            exit;
        }
        require __DIR__ . '/../views/post/create.php';
    }

    public function show(): void
    {
        $this->requireAuth();
        $id   = (int)($_GET['id'] ?? 0);
        $post = $this->postModel->findById($id);
        if (!$post) {
            http_response_code(404);
            echo '<h1>' . __('error.post_not_found') . '</h1>';
            return;
        }
        $comments = $this->commentModel->getByPost($id);
        require __DIR__ . '/../views/post/show.php';
    }

    public function edit(): void
    {
        $this->requireAuth();
        $id   = (int)($_GET['id'] ?? 0);
        $post = $this->postModel->findById($id);

        if (!$post || $post['user_id'] !== $_SESSION['user']['id']) {
            header('Location: ' . BASE_URL . '/index.php?page=feed');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = trim($_POST['description'] ?? '');
            $this->postModel->update($id, $_SESSION['user']['id'], $description);
            header('Location: ' . BASE_URL . '/index.php?page=show&id=' . $id);
            exit;
        }
        require __DIR__ . '/../views/post/edit.php';
    }

    public function delete(): void
    {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $this->postModel->delete($id, $_SESSION['user']['id']);
        header('Location: ' . BASE_URL . '/index.php?page=feed');
        exit;
    }

    private function handleUpload(array $file): string|false
    {
        if (empty($file['tmp_name']) || $file['size'] > MAX_FILE_SIZE) return false;
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, ALLOWED_TYPES, true)) return false;

        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('post_', true) . '.' . $ext;
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
