<?php
require_once __DIR__ . '/../config/Database.php';

class Producto {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function obtenerTodos() {
        $stmt = $this->db->query("
            SELECT 
                p.id_producto, 
                p.nombre_producto, 
                p.descripcion, 
                p.precio, 
                p.stock, 
                p.id_marca,
                m.nombre_marca 
            FROM productos p
            LEFT JOIN marcas m ON p.id_marca = m.id_marca
        ");
        return $stmt->fetchAll();
    }

    public function buscarPorID($id) {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id_producto = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function crear($data) {
        $stmt = $this->db->prepare("
            INSERT INTO productos (nombre_producto, descripcion, precio, stock, id_marca) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['nombre_producto'], 
            $data['descripcion'], 
            $data['precio'], 
            $data['stock'], 
            $data['id_marca']
        ]);
        return ['id' => $this->db->lastInsertId()];
    }

    public function actualizar($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE productos 
            SET nombre_producto = ?, descripcion = ?, precio = ?, stock = ?, id_marca = ? 
            WHERE id_producto = ?
        ");
        $stmt->execute([
            $data['nombre_producto'], 
            $data['descripcion'], 
            $data['precio'], 
            $data['stock'], 
            $data['id_marca'], 
            $id
        ]);
        return ['success' => true];
    }

    public function eliminar($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM productos WHERE id_producto = ?");
            $stmt->execute([$id]);
            return ['Eliminado' => true];
        } catch (Exception $e) {
            return ['Eliminado' => false, 'error' => $e->getMessage()];
        }
    }
}
?>
