<?php require __DIR__ . '/../layouts/header.php'; ?>

<a href="<?= BASE_URL ?>/index.php?page=profile" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    <?= __('profile.back') ?>
</a>

<p class="section-title"><?= __('profile.edit_title') ?></p>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<div class="form-card">
    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="bio"><?= __('profile.bio_label') ?></label>
            <textarea id="bio" name="bio"
                      placeholder="<?= htmlspecialchars(__('profile.bio_placeholder')) ?>"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="avatar"><?= __('profile.avatar_label') ?></label>
            <?php if (!empty($user['avatar'])): ?>
                <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($user['avatar']) ?>"
                     alt="Avatar" class="edit-avatar-preview" id="avatarPreview">
            <?php else: ?>
                <img src="" alt="" class="edit-avatar-preview" id="avatarPreview" style="display:none">
            <?php endif; ?>
            <input type="file" id="avatar" name="avatar" class="file-input-plain"
                   accept="image/jpeg,image/png,image/gif,image/webp">
            <small><?= __('profile.avatar_hint') ?></small>
        </div>

        <button type="submit"><?= __('profile.save') ?></button>

    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
