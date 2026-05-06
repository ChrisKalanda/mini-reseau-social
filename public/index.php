<?php
session_start();
require_once __DIR__ . '/../config/config.php';

/* ── Language detection ── */
if (isset($_GET['lang']) && in_array($_GET['lang'], ['fr', 'en'], true)) {
    $_SESSION['lang'] = $_GET['lang'];
}
require_once __DIR__ . '/../app/lang/i18n.php';

/* ── Routing ── */
$page = $_GET['page'] ?? 'feed';

$routes = [
    'feed'           => ['PostController',    'feed'],
    'create'         => ['PostController',    'create'],
    'show'           => ['PostController',    'show'],
    'edit'           => ['PostController',    'edit'],
    'delete'         => ['PostController',    'delete'],
    'add_comment'    => ['CommentController', 'add'],
    'delete_comment' => ['CommentController', 'delete'],
    'register'       => ['UserController',    'register'],
    'login'          => ['UserController',    'login'],
    'logout'         => ['UserController',    'logout'],
    'profile'        => ['UserController',    'profile'],
    'edit_profile'   => ['UserController',    'editProfile'],
];

if (!isset($routes[$page])) {
    http_response_code(404);
    echo '<!DOCTYPE html><html><body><h1>' . __('error.404') . '</h1></body></html>';
    exit;
}

[$controllerName, $method] = $routes[$page];
require_once __DIR__ . "/../app/controllers/{$controllerName}.php";

$controller = new $controllerName();
$controller->$method();
