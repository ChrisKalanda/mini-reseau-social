<?php require __DIR__ . '/../layouts/header.php'; ?>

<a href="<?= BASE_URL ?>/index.php?page=feed" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    <?= __('post.back_feed') ?>
</a>

<article class="post-detail" data-post-id="<?= $post['id'] ?>">
    <div class="post-header">
        <div class="post-avatar"><?= strtoupper(mb_substr($post['username'], 0, 1)) ?></div>
        <div>
            <div class="post-user"><?= htmlspecialchars($post['username']) ?></div>
            <div style="font-size:.75rem;color:var(--text-3)"><?= htmlspecialchars($post['created_at']) ?></div>
        </div>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] === (int)$post['user_id']): ?>
            <div class="post-detail-actions">
                <a href="<?= BASE_URL ?>/index.php?page=edit&id=<?= $post['id'] ?>" class="btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px;height:15px"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    <?= __('post.edit_btn') ?>
                </a>
                <a href="<?= BASE_URL ?>/index.php?page=delete&id=<?= $post['id'] ?>"
                   onclick="return confirm('<?= htmlspecialchars(__('post.delete_confirm')) ?>')" class="btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px;height:15px"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    <?= __('post.delete_btn') ?>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($post['image']) ?>" alt="Post">

    <div class="post-actions">
        <button class="post-action-btn like-btn" type="button" title="<?= htmlspecialchars(__('feed.like')) ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </button>
    </div>

    <?php if ($post['description']): ?>
        <p class="post-desc">
            <strong><?= htmlspecialchars($post['username']) ?></strong><?= nl2br(htmlspecialchars($post['description'])) ?>
        </p>
    <?php endif; ?>
</article>

<section class="comments-section">
    <div class="comments-head"><?= __('comments.title') ?> (<?= count($comments) ?>)</div>

    <div class="comment-list">
        <?php foreach ($comments as $c): ?>
            <div class="comment">
                <div class="comment-avatar"><?= strtoupper(mb_substr($c['username'], 0, 1)) ?></div>
                <div class="comment-body">
                    <strong><?= htmlspecialchars($c['username']) ?></strong><span class="comment-text"><?= nl2br(htmlspecialchars($c['content'])) ?></span>
                    <div class="comment-meta">
                        <span class="comment-date"><?= htmlspecialchars($c['created_at']) ?></span>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] === (int)$c['user_id']): ?>
                            <a href="<?= BASE_URL ?>/index.php?page=delete_comment&id=<?= $c['id'] ?>&post_id=<?= $post['id'] ?>"
                               onclick="return confirm('<?= htmlspecialchars(__('comments.delete_confirm')) ?>')"
                               class="comment-delete"><?= __('comments.delete') ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($_SESSION['user'])): ?>
        <form method="POST" action="<?= BASE_URL ?>/index.php?page=add_comment" class="comment-form-row">
            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
            <textarea name="content" placeholder="<?= htmlspecialchars(__('comments.add_placeholder')) ?>" required></textarea>
            <button type="submit" class="btn-comment-submit"><?= __('comments.publish') ?></button>
        </form>
    <?php else: ?>
        <p class="comment-login-prompt">
            <a href="<?= BASE_URL ?>/index.php?page=login"><?= __('comments.login_link') ?></a>
            <?= __('comments.login_prompt') ?>
        </p>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
