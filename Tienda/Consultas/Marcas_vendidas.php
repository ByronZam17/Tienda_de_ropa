<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "tienda_ropa";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


$sql = "SELECT id_marca, nombre_marca, ventas FROM marcas WHERE ventas > 0 ORDER BY ventas DESC";
$result = $conn->query($sql);


$marcas = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $marcas[] = $row;
    }
}


header('Content-Type: application/json');
echo json_encode($marcas);


$conn->close();
?>