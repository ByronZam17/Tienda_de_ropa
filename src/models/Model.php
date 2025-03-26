<?php
abstract class Model {
    protected $db;
    protected $table;

    public function __construct($db) {
        $this->db = $db->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_" . substr($this->table, 0, -1) . " = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_" . substr($this->table, 0, -1) . " = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }
}