<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Inicializar las variables de producto
$productData = null;

// Verificar si se ha pasado un ID de producto en el URL (desde el código QR)
if (isset($_GET['idprod'])) {
    $idprod = $_GET['idprod'];

    // Consulta SQL para obtener los detalles del producto
    $query = "SELECT * FROM producto WHERE idprod = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idprod);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $productData = $result->fetch_assoc();
    } else {
        $productData = "Producto no encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lectura de QR - Producto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <style>
        /* Estilo general */
        body {
            background-color: #212529; /* Fondo oscuro elegante */
            color: #ffffff; /* Texto claro */
        }

        .container {
            margin-top: 20px;
        }

        /* Mostrar información del producto */
        .product-info {
            background-color: #333;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }

        .product-info h3 {
            color: #ffc107;
        }

        .product-info p {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <!-- Menú de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="almacen.php">Almacén</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ingreso.php">Ingreso</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="qr.php">QR CODE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ventas.php">Ventas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido de la página -->
    <div class="container">
        <h2 class="text-center text-white">Escanea un código QR para ver los detalles del producto</h2>

        <!-- Aquí se muestra el área de escaneo -->
        <div id="reader" style="width: 100%; height: 400px;"></div>

        <!-- Mostrar los datos del producto si el QR ha sido escaneado -->
        <?php if ($productData): ?>
            <div class="product-info">
                <?php if (is_array($productData)): ?>
                    <h3><?php echo $productData['nombre']; ?></h3>
                    <p><strong>ID Producto:</strong> <?php echo $productData['idprod']; ?></p>
                    <p><strong>Descripción:</strong> <?php echo $productData['descripcion']; ?></p>
                    <p><strong>Precio:</strong> $<?php echo $productData['precio']; ?></p>
                    <p><strong>Cantidad:</strong> <?php echo $productData['cantidad']; ?></p>
                <?php else: ?>
                    <p><?php echo $productData; ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Configuración del lector de QR
        function onScanSuccess(decodedText, decodedResult) {
            // El código QR contiene el idprod
            window.location.href = 'qr.php?idprod=' + decodedText; // Redirigir a la misma página con el ID
        }

        function onScanError(errorMessage) {
            // Puedes manejar errores aquí si es necesario
        }

        // Iniciar el escáner de QR en la página
        const html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
            { facingMode: "environment" }, // Usar la cámara trasera del dispositivo
            {
                fps: 10,    // 10 frames por segundo
                qrbox: 250  // Tamaño del área de escaneo
            },
            onScanSuccess,
            onScanError
        );
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
