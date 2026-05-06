<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-page">
    <div class="auth-logo">
        <div class="auth-logo-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
        </div>
        <span class="auth-logo-text">MiniSocial</span>
    </div>

    <div class="auth-card">
        <p class="auth-subtitle"><?= __('auth.register.subtitle') ?></p>

        <?php if (!empty($errors)): ?>
            <ul class="errors">
                <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username"
                   placeholder="<?= htmlspecialchars(__('auth.register.username')) ?>"
                   required autocomplete="username"
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            <input type="email" name="email"
                   placeholder="<?= htmlspecialchars(__('auth.login.email')) ?>"
                   required autocomplete="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            <input type="password" name="password"
                   placeholder="<?= htmlspecialchars(__('auth.register.password')) ?>"
                   required autocomplete="new-password">
            <button type="submit"><?= __('auth.register.submit') ?></button>
        </form>
    </div>

    <div class="auth-switch">
        <?= __('auth.register.has_account') ?>&nbsp;<a href="<?= BASE_URL ?>/index.php?page=login"><?= __('auth.register.login') ?></a>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
