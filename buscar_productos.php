<?php
// Incluye la conexión a la base de datos
include('conexion.php');

$código = isset($_GET['codigo']) ? $_GET['codigo'] : '';
$modelo = isset($_GET['modelo']) ? $_GET['modelo'] : '';

// Consulta de búsqueda de productos con límite de 3 y ordenados por idprod descendente
$query = "SELECT codigo, modelo FROM productos 
          WHERE codigo LIKE '%$código%' AND modelo LIKE '%$modelo%' 
          ORDER BY idprod DESC LIMIT 3";
$result = $conexion->query($query);

$productos = [];

// Si hay productos, agregarlos al array
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

// Devolver resultados como JSON
echo json_encode($productos);
?>
