<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/MarcasModel.php';

class MarcasController extends Controller {
    public function __construct($db) {
        parent::__construct(new MarcasModel($db));
    }

    public function getAll($params) {
        $marcas = $this->model->getAll();
        $this->sendResponse($marcas);
    }

    public function getById($params) {
        $marca = $this->model->getById($params['id']);
        if ($marca) {
            $this->sendResponse($marca);
        } else {
            $this->sendResponse(['error' => 'Marca no encontrada'], 404);
        }
    }

    public function create($params) {
        $data = $this->getRequestBody();
        if ($this->model->create($data)) {
            $this->sendResponse(['message' => 'Marca creada correctamente'], 201);
        } else {
            $this->sendResponse(['error' => 'Error al crear marca'], 400);
        }
    }

    public function update($params) {
        $data = $this->getRequestBody();
        if ($this->model->update($params['id'], $data)) {
            $this->sendResponse(['message' => 'Marca actualizada correctamente']);
        } else {
            $this->sendResponse(['error' => 'Error al actualizar marca'], 400);
        }
    }

    public function delete($params) {
        if ($this->model->delete($params['id'])) {
            $this->sendResponse(['message' => 'Marca eliminada correctamente']);
        } else {
            $this->sendResponse(['error' => 'Error al eliminar marca'], 400);
        }
    }
}