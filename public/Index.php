<?php
// Configuración CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Manejo de OPTIONS para CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type");
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/routes.php';

// Obtener la URL desde .htaccess
$requestUri = isset($_GET['url']) ? '/api/' . $_GET['url'] : '/';
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Enrutamiento
$router->dispatch($requestMethod, $requestUri);