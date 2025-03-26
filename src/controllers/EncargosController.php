<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/EncargosModel.php';

class EncargosController extends Controller {
    public function __construct($db) {
        parent::__construct(new EncargosModel($db));
    }

    public function getAll($params) {
        $encargos = $this->model->getAll();
        $this->sendResponse($encargos);
    }

    public function getById($params) {
        $encargo = $this->model->getById($params['id']);
        if ($encargo) {
            $this->sendResponse($encargo);
        } else {
            $this->sendResponse(['error' => 'Encargo no encontrado'], 404);
        }
    }

    public function create($params) {
        $data = $this->getRequestBody();
        if ($this->model->create($data)) {
            $this->sendResponse(['message' => 'Encargo creado correctamente'], 201);
        } else {
            $this->sendResponse(['error' => 'Error al crear encargo'], 400);
        }
    }

    public function update($params) {
        $data = $this->getRequestBody();
        if ($this->model->update($params['id'], $data)) {
            $this->sendResponse(['message' => 'Encargo actualizado correctamente']);
        } else {
            $this->sendResponse(['error' => 'Error al actualizar encargo'], 400);
        }
    }

    public function delete($params) {
        if ($this->model->delete($params['id'])) {
            $this->sendResponse(['message' => 'Encargo eliminado correctamente']);
        } else {
            $this->sendResponse(['error' => 'Error al eliminar encargo'], 400);
        }
    }
}