<?php
// Conexión a la base de datos
include('conexion.php');

// Verificar que el parámetro 'idprod' esté presente
if (isset($_GET['idprod'])) {
    $idprod = $_GET['idprod'];

    // Consulta SQL para obtener los detalles del producto
    $query = "SELECT * FROM productos WHERE idprod = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idprod);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        // Devolver los datos del producto en formato JSON
        echo json_encode([
            'success' => true,
            'product' => [
                'name' => $product['nombre'],
                'description' => $product['descripcion'],
                'price' => $product['precio']
            ]
        ]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false]);
}

$conn->close();
?>
