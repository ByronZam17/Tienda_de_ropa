<?php
require_once __DIR__ . '/db/database.php';
require_once __DIR__ . '/controllers/ClientesController.php';
require_once __DIR__ . '/controllers/ProductosController.php';
require_once __DIR__ . '/controllers/MarcasController.php';
require_once __DIR__ . '/controllers/EncargosController.php';
require_once __DIR__ . '/controllers/ReportesController.php';

class Router {
    private $routes = [];

    public function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch($method, $uri) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $uri)) {
                $handler = $route['handler'];
                $params = $this->extractParams($route['path'], $uri);
                call_user_func($handler, $params);
                return;
            }
        }
        
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint no encontrado']);
    }

    private function matchPath($routePath, $requestUri) {
        $routeParts = explode('/', trim($routePath, '/'));
        $uriParts = explode('/', trim($requestUri, '/'));
        
        if (count($routeParts) !== count($uriParts)) {
            return false;
        }
        
        foreach ($routeParts as $index => $part) {
            if (strpos($part, '{') === 0) {
                continue;
            }
            if ($part !== $uriParts[$index]) {
                return false;
            }
        }
        
        return true;
    }

    private function extractParams($routePath, $requestUri) {
        $params = [];
        $routeParts = explode('/', trim($routePath, '/'));
        $uriParts = explode('/', trim($requestUri, '/'));
        
        foreach ($routeParts as $index => $part) {
            if (strpos($part, '{') === 0) {
                $paramName = trim($part, '{}');
                $params[$paramName] = $uriParts[$index];
            }
        }
        
        return $params;
    }
}

$router = new Router();
$db = new Database();

// Inicialización de controladores
$clientesController = new ClientesController($db);
$productosController = new ProductosController($db);
$marcasController = new MarcasController($db);
$encargosController = new EncargosController($db);
$reportesController = new ReportesController($db);

// Rutas para Clientes
$router->addRoute('GET', '/api/clientes', [$clientesController, 'getAll']);
$router->addRoute('GET', '/api/clientes/{id}', [$clientesController, 'getById']);
$router->addRoute('POST', '/api/clientes', [$clientesController, 'create']);
$router->addRoute('PUT', '/api/clientes/{id}', [$clientesController, 'update']);
$router->addRoute('DELETE', '/api/clientes/{id}', [$clientesController, 'delete']);

// Rutas para Productos
$router->addRoute('GET', '/api/productos', [$productosController, 'getAll']);
$router->addRoute('GET', '/api/productos/{id}', [$productosController, 'getById']);
$router->addRoute('POST', '/api/productos', [$productosController, 'create']);
$router->addRoute('PUT', '/api/productos/{id}', [$productosController, 'update']);
$router->addRoute('DELETE', '/api/productos/{id}', [$productosController, 'delete']);

// Rutas para Marcas (CORRECCIÓN: estaba 'marcas' en algunos lugares)
$router->addRoute('GET', '/api/marcas', [$marcasController, 'getAll']);
$router->addRoute('GET', '/api/marcas/{id}', [$marcasController, 'getById']);
$router->addRoute('POST', '/api/marcas', [$marcasController, 'create']);
$router->addRoute('PUT', '/api/marcas/{id}', [$marcasController, 'update']);
$router->addRoute('DELETE', '/api/marcas/{id}', [$marcasController, 'delete']);

// Rutas para Encargos
$router->addRoute('GET', '/api/encargos', [$encargosController, 'getAll']);
$router->addRoute('GET', '/api/encargos/{id}', [$encargosController, 'getById']);
$router->addRoute('POST', '/api/encargos', [$encargosController, 'create']);
$router->addRoute('PUT', '/api/encargos/{id}', [$encargosController, 'update']);
$router->addRoute('DELETE', '/api/encargos/{id}', [$encargosController, 'delete']);

// Rutas para Reportes
$router->addRoute('GET', '/api/reportes/marcas-con-ventas', [$reportesController, 'marcasConVentas']);
$router->addRoute('GET', '/api/reportes/prendas-vendidas-stock', [$reportesController, 'prendasVendidasStock']);
$router->addRoute('GET', '/api/reportes/top-marcas-vendidas', [$reportesController, 'topMarcasVendidas']);