<?php
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../../config/config.php';

class CommentController
{
    private Comment $commentModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
    }

    public function add(): void
    {
        $this->requireAuth();

        $postId  = (int)($_POST['post_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');

        if ($postId && $content !== '') {
            $this->commentModel->add($postId, (int)$_SESSION['user']['id'], $content);
        }

        header('Location: ' . BASE_URL . '/index.php?page=show&id=' . $postId);
        exit;
    }

    public function delete(): void
    {
        $this->requireAuth();

        $commentId = (int)($_GET['id']      ?? 0);
        $postId    = (int)($_GET['post_id'] ?? 0);

        $this->commentModel->delete($commentId, (int)$_SESSION['user']['id']);

        header('Location: ' . BASE_URL . '/index.php?page=show&id=' . $postId);
        exit;
    }

    private function requireAuth(): void
    {
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/index.php?page=login');
            exit;
        }
    }
}
