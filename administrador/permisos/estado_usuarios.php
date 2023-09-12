<?php
// Establecer la conexión con la base de datos
$conexion = mysqli_connect("localhost:8080", "root", "Alberto321", "restaurante");

// Comprobar si la conexión es exitosa
if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Obtener el ID del usuario a cambiar de estado desde la solicitud POST
if (isset($_POST['id'])) {
    $idUsuario = $_POST['id'];

    // Verificar el estado actual del usuario
    $sqlEstadoActual = "SELECT activo FROM usuarios WHERE id = $idUsuario";
    $resultadoEstado = mysqli_query($conexion, $sqlEstadoActual);

    if ($resultadoEstado) {
        $fila = mysqli_fetch_assoc($resultadoEstado);
        $estadoActual = $fila['activo'];

        // Cambiar el estado del usuario en la base de datos
        $nuevoEstado = ($estadoActual == 1) ? 0 : 1;
        $sql = "UPDATE usuarios SET activo = $nuevoEstado WHERE id = $idUsuario";
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            echo "success"; // Devuelve "success" si la actualización es exitosa
        } else {
            echo "Error al cambiar el estado del usuario: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al obtener el estado actual del usuario.";
    }
} else {
    echo "ID de usuario no proporcionado en la solicitud.";
}

// Cerrar la conexión con la base de datos
mysqli_close($conexion);
?>