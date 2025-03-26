<?php

require_once __DIR__ . '/../db/Database.php';

class Auth {
    private $db;

    public function __construct() {
        // Inicializa la conexión a la base de datos
        $this->db = Database::connect();
    }

    /**
     * Verifica si el token enviado es válido y no ha expirado.
     */
    public function verificarToken() {
        // Obtiene los encabezados de la solicitud
        $headers = getallheaders();

        // Verifica si el encabezado Authorization está presente
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(["error" => "No autorizado: Token faltante"]);
            exit();
        }

        // Extrae el token del encabezado y lo valida
        $token = str_replace('Bearer ', '', $headers['Authorization']);
        if (!$this->esTokenValido($token)) {
            http_response_code(403);
            echo json_encode(["error" => "Token inválido o expirado"]);
            exit();
        }
    }

    /**
     * Verifica si el token existe y no ha expirado.
     */
    private function esTokenValido($token) {
        $stmt = $this->db->prepare("
            SELECT id_token FROM tokens 
            WHERE token = ? AND expires_at > NOW()
        ");
        $stmt->execute([$token]);
        return $stmt->fetch() ? true : false;
    }
}
?>
