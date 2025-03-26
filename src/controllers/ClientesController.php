<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/ClientesModel.php';

class ClientesController extends Controller {
    public function __construct($db) {
        parent::__construct(new ClientesModel($db));
    }

    public function getAll($params) {
        $clientes = $this->model->getAll();
        $this->sendResponse($clientes);
    }

    public function getById($params) {
        $cliente = $this->model->getById($params['id']);
        if ($cliente) {
            $this->sendResponse($cliente);
        } else {
            $this->sendResponse(['error' => 'Cliente no encontrado'], 404);
        }
    }

    public function create($params) {
        $data = $this->getRequestBody();
        if ($this->model->create($data)) {
            $this->sendResponse(['message' => 'Cliente creado correctamente'], 201);
        } else {
            $this->sendResponse(['error' => 'Error al crear cliente'], 400);
        }
    }

    public function update($params) {
        $data = $this->getRequestBody();
        if ($this->model->update($params['id'], $data)) {
            $this->sendResponse(['message' => 'Cliente actualizado correctamente']);
        } else {
            $this->sendResponse(['error' => 'Error al actualizar cliente'], 400);
        }
    }

    public function delete($params) {
        if ($this->model->delete($params['id'])) {
            $this->sendResponse(['message' => 'Cliente eliminado correctamente']);
        } else {
            $this->sendResponse(['error' => 'Error al eliminar cliente'], 400);
        }
    }
}