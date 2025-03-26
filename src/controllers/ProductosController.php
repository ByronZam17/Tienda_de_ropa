<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/ProductosModel.php';

class ProductosController extends Controller {
    public function __construct($db) {
        parent::__construct(new ProductosModel($db));
    }

    public function getAll($params) {
        $productos = $this->model->getAll();
        $this->sendResponse($productos);
    }

    public function getById($params) {
        $producto = $this->model->getById($params['id']);
        if ($producto) {
            $this->sendResponse($producto);
        } else {
            $this->sendResponse(['error' => 'Producto no encontrado'], 404);
        }
    }

    public function create($params) {
        $data = $this->getRequestBody();
        if ($this->model->create($data)) {
            $this->sendResponse(['message' => 'Producto creado correctamente'], 201);
        } else {
            $this->sendResponse(['error' => 'Error al crear producto'], 400);
        }
    }

    public function update($params) {
        $data = $this->getRequestBody();
        if ($this->model->update($params['id'], $data)) {
            $this->sendResponse(['message' => 'Producto actualizado correctamente']);
        } else {
            $this->sendResponse(['error' => 'Error al actualizar producto'], 400);
        }
    }

    public function delete($params) {
        if ($this->model->delete($params['id'])) {
            $this->sendResponse(['message' => 'Producto eliminado correctamente']);
        } else {
            $this->sendResponse(['error' => 'Error al eliminar producto'], 400);
        }
    }
}