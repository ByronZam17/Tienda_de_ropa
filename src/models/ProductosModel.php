<?php
require_once __DIR__ . '/Model.php';

class ProductosModel extends Model {
    protected $table = 'productos';

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (nombre_producto, descripcion, precio, stock, id_marca) VALUES (:nombre, :descripcion, :precio, :stock, :id_marca)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nombre', $data['nombre_producto']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':precio', $data['precio']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':id_marca', $data['id_marca']);
        
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET nombre_producto = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, id_marca = :id_marca WHERE id_producto = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nombre', $data['nombre_producto']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':precio', $data['precio']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':id_marca', $data['id_marca']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}