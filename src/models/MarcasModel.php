<?php
require_once __DIR__ . '/Model.php';

class MarcasModel extends Model {
    protected $table = 'marcas';

    public function create($data) {
        // Validación de campos obligatorios
        if (empty($data['nombre_marca'])) {
            throw new Exception("El nombre de la marca es obligatorio");
        }
    
        $query = "INSERT INTO " . $this->table . " 
                  (nombre_marca, cantidad_prendas, ventas) 
                  VALUES (:nombre, :cantidad, :ventas)";
        
        $stmt = $this->db->prepare($query);
        
        // Asigna valores por defecto si no están presentes
        $nombre = $data['nombre_marca'];
        $cantidad = $data['cantidad_prendas'] ?? 0;
        $ventas = $data['ventas'] ?? 0;
        
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':ventas', $ventas);
        
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET nombre_marca = :nombre, cantidad_prendas = :cantidad, ventas = :ventas WHERE id_marca = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nombre', $data['nombre_marca']);
        $stmt->bindParam(':cantidad', $data['cantidad_prendas']);
        $stmt->bindParam(':ventas', $data['ventas']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    
}