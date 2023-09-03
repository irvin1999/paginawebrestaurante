<?php
date_default_timezone_set('Europe/Madrid');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["nombre"];
    $password = $_POST["passw"];

    // Verificar si el usuario y la contraseña son los del administrador predeterminado
    $usuario_admin = "admin";
    $password_admin = "admin"; // Cambia "contraseña_admin" por la contraseña que desees

    if ($usuario == $usuario_admin && $password == $password_admin) {
        // Iniciar sesión y redireccionar al usuario administrador
        session_start();
        $_SESSION["idusuario"] = 1; // Puedes asignar un valor único para el usuario administrador
        $_SESSION["usuario"] = $usuario;
        $_SESSION["nombre"] = "Administrador";
        $_SESSION["rol"] = "administrador"; // El nombre del cargo para el administrador
        $_SESSION["es_admin_predeterminado"] = true;
        header("location: /paginawebrestaurante/administrador/inicio.php");
        exit;
    }

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "restaurante");

    // Verificar la conexión
    if (!$conexion) {
        die("La conexión ha fallado: " . mysqli_connect_error());
    }

    // Consulta SQL para buscar el usuario
    $sql = "SELECT u.*, c.nombre as nombre_cargo FROM usuarios u JOIN cargo c ON u.rol = c.id_cargo WHERE u.nombre = '$usuario'";
    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $sql);

    // Comprobar si el usuario existe en la base de datos
    if (mysqli_num_rows($resultado) > 0) {
        // Obtener los datos del usuario
        $fila = mysqli_fetch_assoc($resultado);
        $nombre = $fila["nombre"];
        $password_encriptada = $fila["contrasena"];
        $idusuario = $fila["id"];
        $nombre_cargo = $fila["nombre_cargo"]; // Nombre del cargo

        $root_path = $_SERVER['DOCUMENT_ROOT'] . '/paginawebrestaurante/';

        // Comprobar si el usuario es el administrador (nombre del cargo = 'administrador')
        if ($nombre_cargo == 'administrador' && $password_encriptada == md5($password)) {
            // Iniciar sesión y redireccionar al usuario administrador
            session_start();
            $_SESSION["idusuario"] = $idusuario;
            $_SESSION["usuario"] = $usuario;
            $_SESSION["nombre"] = $nombre;
            $_SESSION["rol"] = "administrador"; // Nombre del cargo para el administrador
            header("location: /paginawebrestaurante/administrador/inicio.php");
            exit;
        }

        // Comprobar si la contraseña es correcta
        if (md5($password) == $password_encriptada) {
            // Iniciar sesión y redireccionar al usuario según su cargo
            session_start();
            $_SESSION["idusuario"] = $idusuario;
            $_SESSION["usuario"] = $usuario;
            $_SESSION["nombre"] = $nombre;
            $_SESSION["rol"] = $nombre_cargo; // Nombre del cargo en lugar del número de rol
            $_SESSION["activo"] = $fila["activo"]; // Agregamos el estado del usuario a la sesión

            if ($fila["activo"] == 0) {
                // Si el usuario está inactivo, redirigir a una página de error o mostrar un mensaje
                header("location: ../index.html");
            } else {
                if ($nombre_cargo == 'camarero') {
                    header("location: /paginawebrestaurante/trabajadores/camarero.php");
                } elseif ($nombre_cargo == 'cocinero') {
                    header("location: /paginawebrestaurante/trabajadores/cocinero.php");
                } else {
                    // Redirigir a una página por defecto o mostrar un mensaje de error
                    header("location: usuario_no_autorizado.php");
                }
                exit;
            }
        } else {
            header("location: usuario_no_autenticado.php");
        }
    } else {
        header("location: usuario_no_autenticado.php");
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}
?>
