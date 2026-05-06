<?php require __DIR__ . '/../layouts/header.php'; ?>

<a href="<?= BASE_URL ?>/index.php?page=feed" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    <?= __('post.back_feed') ?>
</a>

<p class="section-title"><?= __('post.new') ?></p>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<div class="form-card">
    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label><?= __('post.image') ?></label>
            <div class="upload-zone" id="uploadZone">
                <input type="file" id="image" name="image"
                       accept="image/jpeg,image/png,image/gif,image/webp" required>
                <div id="uploadContent">
                    <div class="upload-zone-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                    <p class="upload-zone-text">
                        <strong><?= __('post.upload_click') ?></strong> <?= __('post.upload_drag') ?>
                    </p>
                    <p class="upload-zone-sub"><?= __('post.file_hint') ?></p>
                </div>
                <img class="upload-preview" id="uploadPreview" alt="">
            </div>
        </div>

        <div class="form-group">
            <label for="description"><?= __('post.description') ?></label>
            <textarea id="description" name="description"
                      placeholder="<?= htmlspecialchars(__('post.desc_placeholder')) ?>"></textarea>
        </div>

        <button type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:17px;height:17px;display:inline;vertical-align:middle;margin-right:.4rem"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            <?= __('post.publish') ?>
        </button>

    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
