<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="feed-top">
    <h1><?= __('feed.title') ?></h1>
    <a href="<?= BASE_URL ?>/index.php?page=create" class="btn-outline">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <?= __('feed.create') ?>
    </a>
</div>

<?php if (empty($posts)): ?>
    <div class="feed-empty">
        <div class="feed-empty-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        </div>
        <p><?= __('feed.empty') ?></p>
        <a href="<?= BASE_URL ?>/index.php?page=create"><?= __('feed.be_first') ?></a>
    </div>
<?php else: ?>

<?php
/* Build unique story users from posts (max 8) */
$storyUsers = [];
$seenUsers  = [];
foreach ($posts as $p) {
    if (!in_array($p['user_id'], $seenUsers)) {
        $seenUsers[]  = $p['user_id'];
        $storyUsers[] = $p;
        if (count($storyUsers) >= 8) break;
    }
}
?>

<!-- Stories bar -->
<div class="stories-bar">
    <?php foreach ($storyUsers as $su): ?>
    <a class="story-item" href="<?= BASE_URL ?>/index.php?page=show&id=<?= $su['id'] ?>">
        <div class="story-avatar-wrap">
            <div class="story-avatar-inner">
                <div class="story-avatar-placeholder">
                    <?= strtoupper(mb_substr($su['username'], 0, 1)) ?>
                </div>
            </div>
        </div>
        <span class="story-name"><?= htmlspecialchars($su['username']) ?></span>
    </a>
    <?php endforeach; ?>
</div>

<div class="feed">
    <?php foreach ($posts as $post): ?>
        <article class="post-card" data-post-id="<?= $post['id'] ?>">

            <div class="post-header">
                <div class="post-avatar"><?= strtoupper(mb_substr($post['username'], 0, 1)) ?></div>
                <div><div class="post-user"><?= htmlspecialchars($post['username']) ?></div></div>
                <span class="post-date"><?= htmlspecialchars($post['created_at']) ?></span>
            </div>

            <div class="post-image-wrap">
                <a href="<?= BASE_URL ?>/index.php?page=show&id=<?= $post['id'] ?>">
                    <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($post['image']) ?>"
                         alt="<?= htmlspecialchars($post['username']) ?>" loading="lazy">
                </a>
            </div>

            <div class="post-actions">
                <button class="post-action-btn like-btn" type="button" title="<?= htmlspecialchars(__('feed.like')) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </button>
                <a class="post-action-btn" href="<?= BASE_URL ?>/index.php?page=show&id=<?= $post['id'] ?>" title="<?= htmlspecialchars(__('feed.comment')) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </a>
            </div>

            <?php if ($post['description']): ?>
                <p class="post-desc">
                    <strong><?= htmlspecialchars($post['username']) ?></strong><?= nl2br(htmlspecialchars($post['description'])) ?>
                </p>
            <?php endif; ?>

            <a href="<?= BASE_URL ?>/index.php?page=show&id=<?= $post['id'] ?>" class="post-view-comments">
                <?= __('feed.view_post') ?>
            </a>

        </article>
    <?php endforeach; ?>
</div>

<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
