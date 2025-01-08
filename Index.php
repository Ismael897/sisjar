<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Responsive</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilo general */
        body {
            background-color: #212529; /* Fondo oscuro elegante */
            color: #ffffff; /* Texto claro */
        }

        /* Navbar con fondo blanco */
        .navbar {
            background-color: #ffffff; /* Fondo blanco para el menú */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra sutil */
        }
        .navbar-brand img {
            height: 40px; /* Ajusta el tamaño del logo */
        }
        .nav-link {
            color: #343a40 !important; /* Texto oscuro */
            font-weight: 500;
        }
        .nav-link:hover {
            color: #ffc107 !important; /* Amarillo elegante al pasar el cursor */
        }
    </style>
</head>
<body>
    <!-- Menú de navegación -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="Img/logo.png" alt="Logo">
            </a>
            <!-- Botón para menú colapsado -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Enlaces del menú -->
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
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Inventario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Reportes</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido de la página -->
    <div class="container mt-5">
        <h1>Bienvenido al Sistema</h1>
        <p>Aquí va el contenido principal de la página.</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
