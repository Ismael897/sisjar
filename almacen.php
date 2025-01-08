<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Variables para los filtros de búsqueda
$filtros = [];
$parametros = [];

// Verificar si se ha enviado el formulario de búsqueda
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET)) {
    if (!empty($_GET['codigo'])) {
        $filtros[] = "p.codigo LIKE ?";
        $parametros[] = "%" . $_GET['codigo'] . "%";
    }
    if (!empty($_GET['modelo'])) {
        $filtros[] = "p.modelo LIKE ?";
        $parametros[] = "%" . $_GET['modelo'] . "%";
    }
    if (!empty($_GET['color'])) {
        $filtros[] = "p.color LIKE ?";
        $parametros[] = "%" . $_GET['color'] . "%";
    }
    if (!empty($_GET['taco'])) {
        $filtros[] = "p.taco LIKE ?";
        $parametros[] = "%" . $_GET['taco'] . "%";
    }
}

// Construir la consulta SQL
$sql_base = "SELECT 
                p.codigo, 
                p.color, 
                p.taco, 
                COUNT(*) AS stock, 
                MAX(a.fecha_ing) AS fecha
             FROM 
                productos p
             JOIN 
                almacen a ON p.idprod = a.idprod
             WHERE 
                p.estado = 'A'";

// Agregar filtros si existen
if (!empty($filtros)) {
    $sql_base .= " AND " . implode(" AND ", $filtros);
    $titulo_seccion = "Resultados de la Búsqueda";
} else {
    $titulo_seccion = "Últimos Ingresos";
}

// Agregar cláusulas GROUP BY y ORDER BY
$sql_base .= " GROUP BY p.codigo, p.color, p.taco ORDER BY p.codigo, p.color, p.taco";

// Preparar la consulta
$stmt = $conexion->prepare($sql_base);
if (!empty($parametros)) {
    $stmt->bind_param(str_repeat('s', count($parametros)), ...$parametros);
}

// Ejecutar la consulta
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almacén</title>
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

    <div class="container mt-5">
        <!-- Sección 1: Buscar -->
        <div class="section">
            <h2>Buscar Productos</h2>
            <form method="GET" action="almacen.php">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="Código" name="codigo" value="<?= htmlspecialchars($_GET['codigo'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="Modelo" name="modelo" value="<?= htmlspecialchars($_GET['modelo'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="Color" name="color" value="<?= htmlspecialchars($_GET['color'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="Taco" name="taco" value="<?= htmlspecialchars($_GET['taco'] ?? '') ?>">
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-warning w-100">Buscar</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sección 2: Resultados -->
        <div class="section mt-4">
            <h2><?= $titulo_seccion ?></h2>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Color</th>
                        <th>Taco</th>
                        <th>Stock</th>
                        <th>Última Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado->num_rows > 0) {
                        while ($fila = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($fila['codigo']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['color']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['taco']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['stock']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['fecha']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No se encontraron resultados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
