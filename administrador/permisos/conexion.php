<?php
// Datos de conexión a la base de datos
$servername = "localhost:8080";
$username = "root";
$password = "Alberto321";
$dbname = "restaurante";

// Crear la conexión
$conexion = mysqli_connect($servername, $username, $password, $dbname);

// Comprobar la conexión
if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
?>
