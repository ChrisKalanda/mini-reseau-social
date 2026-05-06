</main>
</div><!-- /.main-wrap -->
</div><!-- /.app-shell -->

<!-- Mobile Bottom Navigation -->
<nav class="mobile-nav">
    <div class="mobile-nav-inner">
        <?php if (!empty($_SESSION['user'])): ?>
            <a href="<?= BASE_URL ?>/index.php?page=feed" class="<?= ($currentPage ?? '') === 'feed' ? 'nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span><?= __('nav.home') ?></span>
            </a>
            <a href="<?= BASE_URL ?>/index.php?page=create" class="<?= ($currentPage ?? '') === 'create' ? 'nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                <span><?= __('nav.create') ?></span>
            </a>
            <a href="<?= BASE_URL ?>/index.php?page=profile" class="<?= in_array($currentPage ?? '', ['profile', 'edit_profile']) ? 'nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span><?= __('nav.profile') ?></span>
            </a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/index.php?page=login">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                <span><?= __('nav.login') ?></span>
            </a>
            <a href="<?= BASE_URL ?>/index.php?page=register">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                <span><?= __('nav.register') ?></span>
            </a>
        <?php endif; ?>
    </div>
</nav>

<footer class="site-footer">
    <p><?= __('footer.text', ['year' => date('Y')]) ?></p>
</footer>

<script>
/* Like button toggle with localStorage */
document.querySelectorAll('.like-btn').forEach(btn => {
    const card = btn.closest('[data-post-id]');
    const pid  = card ? card.dataset.postId : null;
    if (pid && localStorage.getItem('liked_' + pid) === '1') {
        btn.classList.add('liked');
    }
    btn.addEventListener('click', function () {
        this.classList.toggle('liked');
        if (pid) {
            this.classList.contains('liked')
                ? localStorage.setItem('liked_' + pid, '1')
                : localStorage.removeItem('liked_' + pid);
        }
    });
});

/* Auto-resize comment textarea */
document.querySelectorAll('.comment-form-row textarea').forEach(ta => {
    ta.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 110) + 'px';
    });
});

/* Upload zone: drag-and-drop + preview */
const uploadZone    = document.getElementById('uploadZone');
const uploadInput   = document.getElementById('image');
const uploadPreview = document.getElementById('uploadPreview');
const uploadContent = document.getElementById('uploadContent');

if (uploadZone && uploadInput) {
    uploadInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file && uploadPreview) {
            const reader = new FileReader();
            reader.onload = e => {
                uploadPreview.src = e.target.result;
                uploadPreview.style.display = 'block';
                if (uploadContent) uploadContent.style.opacity = '0.5';
            };
            reader.readAsDataURL(file);
        }
    });

    uploadZone.addEventListener('dragover', e => {
        e.preventDefault();
        uploadZone.classList.add('dragover');
    });
    uploadZone.addEventListener('dragleave', () => {
        uploadZone.classList.remove('dragover');
    });
    uploadZone.addEventListener('drop', e => {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        if (e.dataTransfer.files[0]) {
            const dt = new DataTransfer();
            dt.items.add(e.dataTransfer.files[0]);
            uploadInput.files = dt.files;
            uploadInput.dispatchEvent(new Event('change'));
        }
    });
}

/* Avatar preview in edit profile */
const avatarInput   = document.getElementById('avatar');
const avatarPreview = document.getElementById('avatarPreview');
if (avatarInput && avatarPreview) {
    avatarInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                avatarPreview.src = e.target.result;
                avatarPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
}
</script>
</body>
</html>
