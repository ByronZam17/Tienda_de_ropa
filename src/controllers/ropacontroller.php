<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductosController {
    private $model;

    public function __construct() {
        $this->model = new Producto();
    }

    // Obtener todos los productos
    public function obtenerTodos() {
        $productos = $this->model->obtenerTodos();
        echo json_encode($productos);
    }

    // Obtener un producto por ID
    public function obtenerProducto($id) {
        echo json_encode($this->model->buscarPorID($id));
    }

    // Crear un nuevo producto
    public function crearProducto() {
        $data = json_decode(file_get_contents("php://input"), true);
        $resultado = $this->model->crear($data);
        echo json_encode($resultado);
    }

    // Actualizar un producto por ID
    public function actualizarProducto($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $resultado = $this->model->actualizar($id, $data);
        echo json_encode(["resultado" => $resultado]);
    }

    // Eliminar un producto por ID
    public function eliminarProducto($id) {
        echo json_encode($this->model->eliminar($id));
    }
}
?>
