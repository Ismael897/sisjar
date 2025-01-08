<?php
// Incluimos la conexión a la base de datos
include('conexion.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- QRScanner JS -->
    <script src="https://unpkg.com/qr-scanner/qr-scanner.umd.min.js"></script>
    <style>
        body {
            background-color: #212529;
            color: #ffffff;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand img {
            height: 40px;
        }

        .nav-link {
            color: #343a40 !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #ffc107 !important;
        }

        #productDetails {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background-color: #333;
            border-radius: 5px;
        }

        #scannerContainer {
            margin-top: 20px;
            width: 100%;
            height: 300px;
            background-color: #000;
        }
    </style>
</head>
<body>
    <!-- Menú de navegación -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="Img/logo.png" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="almacen.php">Almacén</a></li>
                    <li class="nav-item"><a class="nav-link" href="ingreso.php">Ingreso</a></li>
                    <li class="nav-item"><a class="nav-link" href="qr.php">QR CODE</a></li>
                    <li class="nav-item"><a class="nav-link" href="ventas.php">Ventas</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <h1>Escanear Producto</h1>
        
        <!-- Botón de escanear -->
        <button id="scanButton" class="btn btn-primary">Abrir cámara para escanear QR</button>

        <!-- Contenedor para la cámara -->
        <div id="scannerContainer"></div>

        <!-- Mostrar detalles del producto -->
        <div id="productDetails" class="alert alert-info">
            <h3>Detalles del Producto</h3>
            <p><strong>Nombre:</strong> <span id="productName"></span></p>
            <p><strong>Descripción:</strong> <span id="productDescription"></span></p>
            <p><strong>Precio:</strong> <span id="productPrice"></span></p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let scanner;

        // Función para iniciar el escáner QR al presionar el botón
        document.getElementById('scanButton').addEventListener('click', function() {
            // Mostrar un mensaje de que la cámara está siendo iniciada
            document.getElementById('scannerContainer').innerHTML = "<p>Iniciando cámara...</p>";

            // Verificamos si estamos en HTTPS (requerido por algunos navegadores para acceder a la cámara)
            if (window.location.protocol !== "https:") {
                alert("Por favor, asegúrate de que estás utilizando HTTPS para acceder a la cámara.");
                return;
            }

            // Crear un nuevo objeto QRScanner en el contenedor adecuado
            scanner = new QRScanner(document.getElementById('scannerContainer'), function(result) {
                // Una vez escaneado, obtener el 'idprod' y buscar el producto
                const productId = result.data;
                fetchProductDetails(productId);
            });

            // Iniciar el escáner de QR
            scanner.start().catch(function(error) {
                console.error("Error al iniciar el escáner QR:", error);
                alert("Hubo un error al intentar acceder a la cámara. Asegúrate de permitir el acceso a la cámara.");
            });
        });

        // Función para obtener los detalles del producto
        function fetchProductDetails(productId) {
            fetch('get_product_details.php?idprod=' + productId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('productName').textContent = data.product.name;
                        document.getElementById('productDescription').textContent = data.product.description;
                        document.getElementById('productPrice').textContent = data.product.price;
                        document.getElementById('productDetails').style.display = 'block';
                    } else {
                        alert('Producto no encontrado');
                    }
                })
                .catch(error => {
                    console.error('Error al obtener los datos del producto:', error);
                });
        }
    </script>
</body>
</html>
