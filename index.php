<?php

require_once 'config/config.php';
require_once 'controllers/MovieController.php';
require_once 'controllers/FavoriteController.php';

// En-têtes : réponses JSON + autorisation cross-origin
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Routeur
if ($path === '/' || $path === '') {
    echo json_encode(['message' => 'API Films opérationnelle']);
    exit;
}

if ($method === 'GET' && $path === '/movies/search') {
    MovieController::search($_GET['query'] ?? '');
    exit;
}

if ($method === 'GET' && preg_match('#^/movies/(\d+)$#', $path, $m)) {
    MovieController::show((int) $m[1]);
    exit;
}

if ($method === 'GET' && $path === '/movies') {
    MovieController::list($_GET['type'] ?? 'popular');
    exit;
}

if ($method === 'GET' && $path === '/favorites') {
    FavoriteController::index();
    exit;
}

if ($method === 'POST' && $path === '/favorites') {
    FavoriteController::store();
    exit;
}

if ($method === 'DELETE' && preg_match('#^/favorites/(\d+)$#', $path, $m)) {
    FavoriteController::destroy((int) $m[1]);
    exit;
}

// Aucune route trouvée
http_response_code(404);
echo json_encode(['error' => 'Route inconnue']);
