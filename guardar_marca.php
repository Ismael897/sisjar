<?php
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombreMarca'])) {
    $nombreMarca = $conexion->real_escape_string($_POST['nombreMarca']);

    $query = "INSERT INTO marcas (marca) VALUES ('$nombreMarca')";
    if ($conexion->query($query)) {
        $id = $conexion->insert_id;
        echo json_encode(['success' => true, 'id' => $id]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
