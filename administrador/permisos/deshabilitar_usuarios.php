<?php
// Establecer la conexión con la base de datos
$conexion = mysqli_connect("localhost", "root", "", "restaurante");

// Comprobar si la conexión es exitosa
if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Obtener el ID del usuario a deshabilitar desde la URL
if (isset($_GET['id'])) {
    $idUsuario = $_GET['id'];

    // Realizar la actualización para deshabilitar al usuario
    $sql = "UPDATE usuarios SET activo = 0 WHERE id = $idUsuario";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        echo "Usuario deshabilitado con éxito.";
    } else {
        echo "Error al deshabilitar al usuario: " . mysqli_error($conexion);
    }
}

// Cerrar la conexión con la base de datos
mysqli_close($conexion);
?>
