<?php
$servername = "localhost";
$username = "root";  
$password = "";
$database = "tienda_ropa";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT nombre_marca, ventas FROM marcas ORDER BY ventas DESC LIMIT 3";
$result = $conn->query($sql);

$marcas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $marcas[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($marcas);
?>
