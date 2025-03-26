<?php
// http://localhost/tienda_de_ropa/public/index.php/productos
// http://localhost/tienda_de_ropa/public/index.php/marcas

require_once 'controllers/RopaController.php';
require_once "utils/Auth.php";

// Seguridad con token (descomentar si es necesario)
// $auth = new Auth();
// $auth->verificarToken();

// Obtener el método de la solicitud
$method = $_SERVER['REQUEST_METHOD'];

// Obtener la ruta solicitada y quitar 'public' si es necesario
$requestUri = trim(str_replace('/tienda_de_ropa/public', '', $_SERVER['REQUEST_URI']), '/');

// Separar la ruta en segmentos
$requestUriWithoutQuery = strtok($requestUri, '?');
$segments = explode('/', $requestUriWithoutQuery);

// Obtener parámetros de la URL (si los hay)
$queryString = $_SERVER['QUERY_STRING'] ?? '';
parse_str($queryString, $queryParams);
$id = $queryParams['id'] ?? null;

if (isset($segments[0]) && $segments[0] == "productos") {
    $ropaController = new RopaController();

    switch ($method) {
        case 'GET':
            // Ejemplo: 
            // http://localhost/tienda_de_ropa/public/index.php/productos?id=5
            // http://localhost/tienda_de_ropa/public/index.php/productos
            if ($id != null) {
                $ropaController->obtenerProducto($id);
            } else {
                $ropaController->obtenerTodos();
            }
            break;

        case 'POST':
            $ropaController->crearProducto();
            break;

        case 'PUT':
            $ropaController->actualizarProducto($id);
            break;

        case 'DELETE':
            $ropaController->eliminarProducto($id);
            break;

        default:
            // Método no permitido
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            break;
    }
}

// Manejo de la ruta "marcas"
if (isset($segments[0]) && $segments[0] == "marcas") {
    switch ($method) {
        case 'GET':
            echo json_encode(['Mensaje' => 'Listado de marcas']);
            break;
        case 'POST':
            echo json_encode(['Mensaje' => 'Nueva marca creada']);
            break;
        default:
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            break;
    }
}
?>
