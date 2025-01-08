<?php
// Incluye la conexión a la base de datos
include('conexion.php'); // Incluir el archivo de conexión

$query_proveedores = "SELECT idmarca, marca FROM marcas";
$result_proveedores = $conexion->query($query_proveedores); // Cambiar $conn por $conexion
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de Productos</title>
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

        /* Estilo para el texto del modal */
        #modalAlerta .modal-body {
            color: #343a40; /* Texto oscuro para contraste con el fondo blanco */
        }

        #modalAlerta .modal-header {
            background-color: #ffc107; /* Fondo amarillo para la cabecera */
            color: #212529; /* Texto oscuro en el encabezado */
        }

        #modalAlerta .modal-footer {
            background-color: #f8f9fa; /* Fondo gris claro para el pie del modal */
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


    <!-- Contenido principal -->
    <div class="container mt-5">
        <div class="section">
            <h2>Agregar Producto</h2>
            <form id="formIngreso">
                <div class="row g-3">
                    <div class="col-md-2">
                        <input type="text" class="form-control" placeholder="Modelo" name="modelo" id="modeloInput" readonly>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" placeholder="Código" name="codigo" id="codigoInput">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" placeholder="Color" name="color">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" placeholder="Taco" name="taco">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" placeholder="Talla" name="talla">
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <select class="form-select" name="proveedor" id="marcaSelect">
                            <?php while ($row = $result_proveedores->fetch_assoc()) { ?>
                                <option value="<?= $row['idmarca'] ?>"><?= $row['marca'] ?></option>
                            <?php } ?>
                        </select>
                        <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#modalMarca">+</button>
                    </div>
                </div>
                <div class="col-md-2 mt-3">
                    <button type="submit" class="btn btn-warning w-100">Agregar</button>
                </div>
            </form>

            <!-- Nueva tabla para mostrar los registros agregados -->
            <div class="container mt-5">
                <h3>Registros de Productos</h3>
                <table class="table" id="tablaRegistros">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Modelo</th>
                            <th>Color</th>
                            <th>Taco</th>
                            <th>Talla</th>
                            <th>Marca</th>
                            <th>Eliminar</th> <!-- Nueva columna para Eliminar -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se agregarán los registros -->
                    </tbody>
                </table>
            </div>

            <!-- Caja para Costo y Precio -->
<div class="container mt-4">
    <div class="row g-3">
        <div class="col-md-2">
            <input type="text" class="form-control" id="costoInput" placeholder="Costo" />
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control" id="precioInput" placeholder="Precio" />
        </div>
    </div>
    <div class="mt-3">
        <button type="button" class="btn btn-success" id="guardarIngreso">Guardar Ingreso</button>
        <a href="index.php" class="btn btn-primary ms-2">Ir al Inicio</a>
    </div>
</div>

<!-- Modal de alerta para mostrar los mensajes de error -->
<div class="modal fade" id="modalAlerta" tabindex="-1" aria-labelledby="modalAlertaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAlertaLabel">Advertencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="mensajeAlerta">
                <!-- El mensaje de alerta será insertado aquí -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


        </div>
    </div>

    <!-- Modal para buscar productos -->
    <div class="modal fade" id="modalBuscarProducto" tabindex="-1" aria-labelledby="modalBuscarProductoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBuscarProductoLabel">Buscar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="codigoModal" placeholder="Código" oninput="buscarProducto()">
                    <input type="text" class="form-control mt-2" id="modeloModal" placeholder="Modelo" oninput="buscarProducto()">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Modelo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tablaProductos"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar marca -->
    <div class="modal fade" id="modalMarca" tabindex="-1" aria-labelledby="modalMarcaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMarcaLabel">Agregar Nueva Marca</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formMarca">
                        <div class="mb-3">
                            <h2>Nueva Marca</h2>
                            <label for="nombreMarca" class="form-label">Nombre de la Marca</label>
                            <input type="text" class="form-control" id="nombreMarca" placeholder="Ingrese Marca" name="nombreMarca" required>
                        </div>
                        <button type="button" class="btn btn-success" id="guardarMarca">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    $(document).ready(function () {
        // Mostrar el modal de búsqueda de producto al hacer clic en el modelo
        $('#modeloInput').click(function () {
            $('#modalBuscarProducto').modal('show');
        });
});
        // Función para realizar la búsqueda de productos
        function buscarProducto() {
            var codigo = $('#codigoModal').val().trim();
            var modelo = $('#modeloModal').val().trim();

            $.ajax({
                url: 'buscar_productos.php',
                method: 'GET',
                data: { codigo: codigo, modelo: modelo },
                success: function (response) {
                    var productos = JSON.parse(response);
                    var tabla = $('#tablaProductos');
                    tabla.empty(); // Limpiar tabla

                    if (productos.length > 0) {
                        // Si hay productos, agregar las filas
                        productos.forEach(function (producto) {
                            tabla.append(`<tr>
                                <td>${producto.codigo}</td>
                                <td>${producto.modelo}</td>
                                <td><button class="btn btn-success seleccionarBtn" data-codigo="${producto.codigo}" data-modelo="${producto.modelo}">Seleccionar</button></td>
                            </tr>`);
                        });
                    } else {
                        // Si no hay productos, mostrar mensaje
                        tabla.append(`<tr><td colspan="3">No se encontraron productos.</td></tr>`);
                    }
                }
            });
        }

        // Manejo de clic en los botones "Seleccionar" en el modal de búsqueda
        $(document).on('click', '.seleccionarBtn', function () {
            var codigo = $(this).data('codigo');
            var modelo = $(this).data('modelo');

            // Rellenar los campos del formulario principal
            $('#codigoInput').val(codigo);
            $('#modeloInput').val(modelo);
            $('#modalBuscarProducto').modal('hide');
        });

        // Función para agregar el producto a la tablaRegistros
    $('#formIngreso').submit(function (e) {
        e.preventDefault(); // Evitar el comportamiento por defecto del formulario

        var codigo = $('#codigoInput').val();
        var modelo = $('#modeloInput').val();
        var color = $('input[name="color"]').val();
        var taco = $('input[name="taco"]').val();
        var talla = $('input[name="talla"]').val();
        var marca = $('#marcaSelect option:selected').text(); // Obtener el nombre de la marca

        // Agregar la nueva fila a la tabla tablaRegistros con el botón de eliminar
        $('#tablaRegistros tbody').append(`
            <tr>
                <td>${codigo}</td>
                <td>${modelo}</td>
                <td>${color}</td>
                <td>${taco}</td>
                <td>${talla}</td>
                <td>${marca}</td>
                <td><button class="btn btn-danger eliminarBtn">Eliminar</button></td> <!-- Botón de eliminar -->
            </tr>
        `);
    });

    // Función para guardar el ingreso
    $('#guardarIngreso').click(function () {
        // Validar si hay campos vacíos en la tabla
        var hayCamposVacios = false;
        $('#tablaRegistros tbody tr').each(function () {
            $(this).find('td').each(function () {
                if ($(this).text().trim() === "") {
                    hayCamposVacios = true;
                    return false; // Detener la búsqueda
                }
            });
            if (hayCamposVacios) return false; // Salir del loop si encontramos un campo vacío
        });

        // Validar que los campos de Costo y Precio no estén vacíos
        var costo = $('#costoInput').val().trim();
        var precio = $('#precioInput').val().trim();

        if (hayCamposVacios) {
            $('#mensajeAlerta').text("Los registros no pueden contener campos vacíos.");
            $('#modalAlerta').modal('show');
            return;
        }

        if (costo === "" || precio === "") {
            $('#mensajeAlerta').text("Costo o Precio están vacíos.");
            $('#modalAlerta').modal('show');
            return;
        }

        // Validar que el Costo no sea mayor que el Precio
        if (parseFloat(costo) > parseFloat(precio)) {
            $('#mensajeAlerta').text("El costo no puede ser mayor que el precio.");
            $('#modalAlerta').modal('show');
            return;
        }

        // Aquí puedes hacer la lógica para guardar en la base de datos, etc.
        $('#mensajeAlerta').text("Ingreso guardado correctamente.");
        $('#modalAlerta').modal('show');
    });

    // Eliminar la fila al hacer clic en el botón "Eliminar"
    $(document).on('click', '.eliminarBtn', function () {
        $(this).closest('tr').remove(); // Elimina la fila correspondiente
    });


    
    </script>
</body>
</html>
