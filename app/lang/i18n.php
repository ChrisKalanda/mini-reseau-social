<?php
/**
 * Translate a key, optionally replacing :placeholder tokens.
 * Language strings are loaded once from session-selected lang file.
 *
 * Usage:  __('nav.home')
 *         __('footer.text', ['year' => 2025])
 */
function __($key, array $params = []): string
{
    static $strings = null;
    if ($strings === null) {
        $lang    = $_SESSION['lang'] ?? 'fr';
        $file    = __DIR__ . '/' . $lang . '.php';
        $strings = file_exists($file) ? require $file : [];
    }

    $text = $strings[$key] ?? $key;

    foreach ($params as $k => $v) {
        $text = str_replace(':' . $k, (string) $v, $text);
    }

    return $text;
}
