<?php
abstract class Controller {
    protected $model;

    public function __construct($model) {
        $this->model = $model;
    }

    protected function sendResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode($data);
    }

    protected function getRequestBody() {
        return json_decode(file_get_contents('php://input'), true);
    }
}