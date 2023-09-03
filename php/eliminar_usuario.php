<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $idUsuario = $_POST['id'];

    // Establecer la conexión con la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "restaurante");

    // Comprobar si la conexión es exitosa
    if (!$conexion) {
        die("Error al conectar a la base de datos: " . mysqli_connect_error());
    }

    // Consulta SQL para eliminar el usuario por su ID
    $sql = "DELETE FROM usuarios WHERE id = $idUsuario";

    // Ejecutar la consulta SQL
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        echo "success"; // Respuesta de éxito
    } else {
        echo "error"; // Respuesta de error
    }

    // Cerrar la conexión con la base de datos
    mysqli_close($conexion);
} else {
    echo "No se proporcionó un ID de usuario válido.";
}
?>
