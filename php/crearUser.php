<?php
date_default_timezone_set('Europe/Madrid');
// Establecer la conexión con la base de datos
$conexion = mysqli_connect("localhost", "root", "", "restaurante");

// Comprobar si la conexión es exitosa
if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Recoger los valores del formulario HTML
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$contrasena = md5($_POST["contraseña"]);  // Corregido "passw" a "contraseña"
$rol = $_POST['rol'];

// Crear la consulta SQL para insertar un nuevo usuario en la tabla "usuarios"
$sql = "INSERT INTO usuarios (nombre, apellido, contrasena, rol) VALUES ('$nombre','$apellido','$contrasena','$rol')";

// Ejecutar la consulta SQL
if (mysqli_query($conexion, $sql)) {
    // Si la creación del usuario es exitosa, redirigir al usuario a una página de inicio de sesión
    header("location: /paginawebrestaurante/administrador/agregar.php");
    exit();
} else {
    // Si la creación falla, mostrar un mensaje de error en la página del formulario de creación de usuario
    echo "Error al crear el usuario: " . mysqli_error($conexion);
}

// Cerrar la conexión con la base de datos
mysqli_close($conexion);
?>
