<?php
function verificarSiEsAdminPredeterminado()
{
  // Verificar si el usuario es el administrador predeterminado
  if (isset($_SESSION["usuario"]) && $_SESSION["usuario"] == "admin" && isset($_SESSION["es_admin_predeterminado"]) && $_SESSION["es_admin_predeterminado"]) {
    return true;
  }

  return false;
}
session_start();
error_reporting(0);
$varsesion = $_SESSION['usuario'];
if ($varsesion == null || $varsesion = '') {
  header("location: ../index.html");
  die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Site Metas -->
  <title>Empresa</title>
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Site Icons -->
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="/paginawebrestaurante/css2/bootstrap.min.css">
  <!-- Site CSS -->
  <link rel="stylesheet" href="/paginawebrestaurante/css2/style.css">
  <!-- Responsive CSS -->
  <link rel="stylesheet" href="/paginawebrestaurante/css2/responsive.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="/paginawebrestaurante/css2/custom.css">

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="permisos/estado.css">
  <link rel="stylesheet" href="/paginawebrestaurante/css/tabla.css">

</head>

<body>
  <header class="top-navbar">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="index.html">
          <img src="../images/logo.png" alt="" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-rs-food"
          aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbars-rs-food">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="/paginawebrestaurante/administrador/inicio.php">Inicio</a>
            </li>
            <li class="nav-item active dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">Personal</a>
              <div class="dropdown-menu" aria-labelledby="dropdown-a">
                <a class="dropdown-item" href="/paginawebrestaurante/administrador/listado.php">Lista de usuarios</a>
                <a class="dropdown-item active" href="/paginawebrestaurante/administrador/agregar.php">Registrar</a>
              </div>
            </li>
            <li>
              <?php
              date_default_timezone_set('Europe/Madrid');
              session_start();
              if (isset($_SESSION['usuario'])) {
                echo '<a class="nav-link" href="/paginawebrestaurante/php/cerrarsesion.php">Cerrar sesión</a>';
                echo '<li class="nav-link">';
                echo 'Nombre:   ';
                echo $_SESSION['nombre'] . "<br> ";
                echo 'Rol:   ';
                echo $_SESSION['rol'];
                echo '</li>';
              }
              ?>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <div class="container-fluid row">
    <form action="../php/crearUser.php" method="post" class="col-4 p-5">
      <h1 class="text-center p-3">Agregar Personal</h1>
      <label for="nombre">Nombre:</label>
      <input type="text" id="nombre" name="nombre" required>

      <label for="apellido">Apellido:</label>
      <input type="text" id="apellido" name="apellido" required>

      <label for="rol">Rol:</label>
      <select id="rol" name="rol">
        <option value="1">Administrador</option>
        <option value="2">Camarero</option>
        <option value="3">Cocinero</option>
      </select>

      <label for="contraseña">Contraseña:</label>
      <input type="password" id="contraseña" name="contraseña" required>

      <input type="submit" value="Agregar Usuario">
    </form>
    <?php
    include('permisos/conexion.php');

    // Crear la consulta SQL para obtener los usuarios y sus roles
    $sql = "SELECT usuarios.id, usuarios.nombre, usuarios.apellido, cargo.nombre AS rol_nombre
        FROM usuarios
        INNER JOIN cargo ON usuarios.rol = cargo.id_cargo";

    // Ejecutar la consulta SQL
    $resultado = mysqli_query($conexion, $sql);
    ?>

    <div class="col-8 p-5">
      <br>
      <h1 class="text-center p-3">Lista de trabajadores</h1>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Rol</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Obtener el ID del usuario que ha iniciado sesión desde la variable de sesión
          $userEnSesion = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
          $esAdminPredeterminado = verificarSiEsAdminPredeterminado(); // Debes implementar esta función
          
          while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<th scope='row'>" . $fila['id'] . "</th>";
            echo "<td>" . $fila['nombre'] . "</td>";
            echo "<td>" . $fila['apellido'] . "</td>";
            echo "<td>" . $fila['rol_nombre'] . "</td>";

            // Botones de modificar y eliminar
            echo "<td>";

            if ($esAdminPredeterminado || $userEnSesion != $fila['id']) {
              // Muestra el botón de eliminar solo si es el administrador predeterminado o no es el usuario en sesión
              if ($esAdminPredeterminado || ($fila['rol_nombre'] == 'camarero' || $fila['rol_nombre'] == 'cocinero')) {
                $btnClass = ($fila['activo'] == 1) ? 'btn-deshabilitar' : 'btn-habilitar';
                $btnText = ($fila['activo'] == 1) ? 'Deshabilitado' : 'Habilitado';

                echo "<a href='#'><img src='../images/modificar.png' alt='Modificar'></a> ";

                if ($esAdminPredeterminado) {
                  // El administrador predeterminado puede eliminar a cualquier usuario
                  echo "<a href='../php/eliminar_usuario.php?id=" . $fila['id'] . "'><img src='../images/eliminar.png' alt='Eliminar'></a><span style='margin-right: 10px;'></span>";
                } elseif ($_SESSION['rol'] == 'administrador') {
                  // Verificar si el usuario en sesión es un administrador registrado en la base de datos
                  // Mostrar el botón de eliminar solo para camareros y cocineros
                  if ($fila['rol_nombre'] == 'camarero' || $fila['rol_nombre'] == 'cocinero') {
                    echo "<a href='../php/eliminar_usuario.php?id=" . $fila['id'] . "'><img src='../images/eliminar.png' alt='Eliminar'></a><span style='margin-right: 10px;'></span>";
                  }
                }

                echo "<button class='cambiar_estado $btnClass' data-id='" . $fila['id'] . "'>$btnText</button>";
              } else {
                // Si es un administrador, simplemente muestra un mensaje o deja el espacio en blanco
                echo "Administrador";
              }
            } else {
              // Si el usuario en sesión es el mismo que el usuario en la fila, muestra un mensaje o deja el espacio en blanco
              echo "Tú";
            }

            echo "</td>";
            echo "</tr>";
          }
          ?>


        </tbody>
      </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function () {
        // Función para cambiar el estado (habilitar/deshabilitar) y el color del botón
        $(".cambiar_estado").click(function () {
          var idUsuario = $(this).data("id");
          var btn = $(this);

          // Realizar una solicitud AJAX para cambiar el estado
          $.ajax({
            type: "POST",
            url: "../administrador/permisos/estado_usuarios.php",
            data: { id: idUsuario },
            success: function (response) {
              if (response === "success") {
                // Cambio de estado exitoso, actualizar el botón y su estilo
                if (btn.hasClass("btn-habilitar")) {
                  btn.removeClass("btn-habilitar").addClass("btn-deshabilitar").text("Deshabilitado");
                } else {
                  btn.removeClass("btn-deshabilitar").addClass("btn-habilitar").text("Habilitado");
                }
              } else {
                alert("Error al cambiar el estado del usuario.");
              }
            },
          });
        });
      });
    </script>
    <?php
    // Cerrar la conexión con la base de datos
    mysqli_close($conexion);
    ?>
  </div>
  <script src="../js2/jquery-3.2.1.min.js"></script>
  <script src="../js2/popper.min.js"></script>
  <script src="../js2/bootstrap.min.js"></script>
  <script src="../js2/script.js"></script>
</body>

</html>