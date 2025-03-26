<?php
require_once __DIR__ . '/Controller.php';

class ReportesController extends Controller {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConnection();
    }

    public function marcasConVentas($params) {
        $query = "SELECT * FROM marcas WHERE ventas > 0";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->sendResponse($marcas);
    }

    public function prendasVendidasStock($params) {
        $query = "SELECT p.nombre_producto, SUM(e.cantidad) AS total_vendido, p.stock 
                 FROM productos p
                 JOIN encargos e ON p.id_producto = e.id_producto
                 GROUP BY p.id_producto";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $prendas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->sendResponse($prendas);
    }

    public function topMarcasVendidas($params) {
        $query = "SELECT nombre_marca, ventas 
                 FROM marcas 
                 ORDER BY ventas DESC 
                 LIMIT 5";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->sendResponse($marcas);
    }
}