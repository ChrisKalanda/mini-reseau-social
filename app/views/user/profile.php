<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="profile-header">
    <div class="avatar-ring">
        <div class="avatar-inner">
            <?php if (!empty($user['avatar'])): ?>
                <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar">
            <?php else: ?>
                <div class="avatar-placeholder-lg">👤</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="profile-username"><?= htmlspecialchars($user['username']) ?></div>

    <div class="profile-stats">
        <div class="profile-stat">
            <span class="stat-num"><?= count($posts) ?></span>
            <span class="stat-label"><?= __('profile.posts') ?></span>
        </div>
    </div>

    <p class="profile-bio"><?= nl2br(htmlspecialchars($user['bio'] ?? __('profile.no_bio'))) ?></p>

    <a href="<?= BASE_URL ?>/index.php?page=edit_profile" class="btn-outline"><?= __('profile.edit_btn') ?></a>
</div>

<?php if (empty($posts)): ?>
    <p class="profile-empty"><?= __('profile.no_posts') ?></p>
<?php else: ?>
    <div class="posts-grid">
        <?php foreach ($posts as $post): ?>
            <a href="<?= BASE_URL ?>/index.php?page=show&id=<?= $post['id'] ?>">
                <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($post['image']) ?>" alt="Post" loading="lazy">
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
