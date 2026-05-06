<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'fr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniSocial</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css?v=3">
</head>
<body>
<?php
$currentPage = $_GET['page'] ?? 'feed';
$currentLang = $_SESSION['lang'] ?? 'fr';
$_frUrl = BASE_URL . '/index.php?' . http_build_query(array_merge($_GET, ['lang' => 'fr']));
$_enUrl = BASE_URL . '/index.php?' . http_build_query(array_merge($_GET, ['lang' => 'en']));
?>
<div class="app-shell">

<aside class="sidebar">
    <a href="<?= BASE_URL ?>/index.php?page=feed" class="sidebar-brand">
        <div class="brand-logo">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
        </div>
        <span class="brand-text">MiniSocial</span>
    </a>

    <nav class="sidebar-nav">
        <?php if (!empty($_SESSION['user'])): ?>
            <a href="<?= BASE_URL ?>/index.php?page=feed" class="<?= $currentPage === 'feed' ? 'nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span><?= __('nav.home') ?></span>
            </a>
            <a href="<?= BASE_URL ?>/index.php?page=create" class="<?= $currentPage === 'create' ? 'nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                <span><?= __('nav.create') ?></span>
            </a>
            <a href="<?= BASE_URL ?>/index.php?page=profile" class="<?= in_array($currentPage, ['profile', 'edit_profile']) ? 'nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span><?= __('nav.profile') ?></span>
            </a>
            <div class="nav-spacer"></div>
            <a href="<?= BASE_URL ?>/index.php?page=logout" class="nav-logout">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span><?= __('nav.logout') ?></span>
            </a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/index.php?page=login" class="<?= $currentPage === 'login' ? 'nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                <span><?= __('nav.login') ?></span>
            </a>
            <a href="<?= BASE_URL ?>/index.php?page=register" class="<?= $currentPage === 'register' ? 'nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                <span><?= __('nav.register') ?></span>
            </a>
        <?php endif; ?>
    </nav>

    <!-- Language switcher -->
    <div class="lang-switcher">
        <a href="<?= $_frUrl ?>" class="<?= $currentLang === 'fr' ? 'active' : '' ?>">FR</a>
        <span class="lang-sep">|</span>
        <a href="<?= $_enUrl ?>" class="<?= $currentLang === 'en' ? 'active' : '' ?>">EN</a>
    </div>
</aside>

<div class="main-wrap">
<main>
