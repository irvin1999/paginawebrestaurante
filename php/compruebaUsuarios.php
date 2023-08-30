<?php
date_default_timezone_set('Europe/Madrid');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["nombre"];
    $password = md5($_POST["passw"]);

    // Conexión a la base de datos
    $host = "localhost";
    $port = "5432";
    $dbname = "restaurante";
    $user = "postgres";
    $password_db = "Alberto321";
    
    $conexion = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password_db");

    // Verificar la conexión
    if (!$conexion) {
        die("La conexión ha fallado: " . pg_last_error());
    }

    // Consulta SQL para buscar el usuario (con uso de consulta preparada)
    $query = "SELECT * FROM usuarios WHERE nombre = $1";
    $result = pg_query_params($conexion, $query, array($usuario));

    // Comprobar si el usuario existe en la base de datos
    if (pg_num_rows($result) > 0) {
        // Obtener los datos del usuario
        $fila = pg_fetch_assoc($result);
        $nombre = $fila["nombre"];
        $hashedPassword = $fila["contrasena"];
        $idusuario = $fila["id"];
        $id_cargo = $fila["rol"]; // Agregamos el campo del cargo del usuario

        // Comprobar si la contraseña es correcta
        if ($hashedPassword == $password) {
            // Iniciar sesión y redireccionar al usuario según su cargo
            session_start();
            $_SESSION["idusuario"] = $idusuario;
            $_SESSION["usuario"] = $usuario;
            $_SESSION["nombre"] = $nombre;

            if ($id_cargo == 1) {
                header("location: /paginawebrestaurante/administrador/inicio.php");
            } elseif ($id_cargo == 2) {
                header("location: /paginawebrestaurante/trabajadores/camarero.php");
            } elseif ($id_cargo == 3) {
                header("location: /paginawebrestaurante/trabajadores/cocinero.php");
            } else {
                // Redirigir a una página por defecto o mostrar un mensaje de error
                header("location: ../index.html");
            }
            exit;
        } else {
            header("location: ../index.html");
        }
    } else {
        header("location: ../index.html");
    }

    // Cerrar la conexión
    pg_close($conexion);
}
?>