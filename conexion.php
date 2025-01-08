<?php
$servidor = "localhost"; // Cambia según tu configuración
$usuario = "root"; // Usuario de tu base de datos
$contrasena = ""; // Contraseña de tu base de datos
$base_datos = "jar"; // Nombre de tu base de datos

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
