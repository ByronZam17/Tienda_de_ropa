<?php
require_once __DIR__ . '/Model.php';

class ClientesModel extends Model {
    protected $table = 'clientes_frecuentes';

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (nombre, correo, telefono, direccion) VALUES (:nombre, :correo, :telefono, :direccion)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':correo', $data['correo']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':direccion', $data['direccion']);
        
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET nombre = :nombre, correo = :correo, telefono = :telefono, direccion = :direccion WHERE id_cliente = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':correo', $data['correo']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}