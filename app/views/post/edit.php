<?php require __DIR__ . '/../layouts/header.php'; ?>

<a href="<?= BASE_URL ?>/index.php?page=show&id=<?= $post['id'] ?>" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    <?= __('post.back_post') ?>
</a>

<p class="section-title"><?= __('post.edit_title') ?></p>

<div class="form-card">
    <form method="POST">
        <div class="form-group">
            <label for="description"><?= __('post.description') ?></label>
            <textarea id="description" name="description"
                      placeholder="<?= htmlspecialchars(__('post.desc_placeholder')) ?>"><?= htmlspecialchars($post['description'] ?? '') ?></textarea>
        </div>
        <button type="submit"><?= __('post.edit_submit') ?></button>
    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
