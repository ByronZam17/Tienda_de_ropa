<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "tienda_ropa";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


$sql = "SELECT id_producto, nombre_producto, stock FROM productos WHERE stock > 0"; // Cambia la condición si es necesario
$result = $conn->query($sql);


$productos = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}


header('Content-Type: application/json');
echo json_encode($productos);


$conn->close();
?>