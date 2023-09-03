<?php
// Incluye el archivo de conexión a la base de datos
include('../administrador/permisos/conexion.php');

// Verifica si se recibió el ID del usuario a eliminar
if (isset($_GET['id'])) {
    $idUsuario = $_GET['id'];

    // Consulta SQL para eliminar al usuario por su ID
    $sql = "DELETE FROM usuarios WHERE id = $idUsuario";

    if (mysqli_query($conexion, $sql)) {
        // Éxito: Usuario eliminado correctamente
        header("Location: ../administrador/agregar.php"); // Redirige de nuevo a la lista de usuarios
        exit;
    } else {
        // Error: No se pudo eliminar al usuario
        echo "Error al eliminar el usuario: " . mysqli_error($conexion);
    }
} else {
    // Error: No se proporcionó el ID del usuario a eliminar
    echo "ID de usuario no proporcionado.";
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>

header("Location: ../administrador/agregar.php"); // Redirige de nuevo a la lista de usuarios
        exit;
