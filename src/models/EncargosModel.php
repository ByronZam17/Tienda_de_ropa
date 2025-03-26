<?php
require_once __DIR__ . '/Model.php';

class EncargosModel extends Model {
    protected $table = 'encargos';

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (id_cliente, id_producto, fecha_encargo, cantidad) VALUES (:id_cliente, :id_producto, :fecha, :cantidad)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id_cliente', $data['id_cliente']);
        $stmt->bindParam(':id_producto', $data['id_producto']);
        $stmt->bindParam(':fecha', $data['fecha_encargo']);
        $stmt->bindParam(':cantidad', $data['cantidad']);
        
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET id_cliente = :id_cliente, id_producto = :id_producto, fecha_encargo = :fecha, cantidad = :cantidad WHERE id_encargo = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id_cliente', $data['id_cliente']);
        $stmt->bindParam(':id_producto', $data['id_producto']);
        $stmt->bindParam(':fecha', $data['fecha_encargo']);
        $stmt->bindParam(':cantidad', $data['cantidad']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}