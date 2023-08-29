<?php
date_default_timezone_set('Europe/Madrid');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["nombre"];
    $password = md5($_POST["passw"]);

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "restaurante");

    // Verificar la conexión
    if (!$conexion) {
        die("La conexión ha fallado: " . mysqli_connect_error());
    }
    // Consulta SQL para buscar el usuario
    $sql = "SELECT * FROM usuarios WHERE nombre = '$usuario'";
    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $sql);
    // Comprobar si el usuario existe en la base de datos
    if (mysqli_num_rows($resultado) > 0) {
        // Obtener los datos del usuario
        $fila = mysqli_fetch_assoc($resultado);
        $nombre = $fila["nombre"];
        $password_encriptada = $fila["contrasena"];
	  $idusuario = $fila["id"];
        // Comprobar si la contraseña es correcta
        if ($password_encriptada == $password) {
            // Iniciar sesión y redireccionar al usuario a la página de inicio
            session_start();
		$_SESSION["idusuario"] = $idusuario;
            $_SESSION["usuario"] = $usuario;
            $_SESSION["nombre"] = $nombre;
		$root_path = $_SERVER['DOCUMENT_ROOT'] . '/paginawebrestaurante/';
		
            header("location: /paginawebrestaurante/trabajadores/inicio.php");
            exit;
        } else {
            header("location: ../index.html");
        }
    } else {
        header("location: ../index.html");
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}
?>
