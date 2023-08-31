<?php
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
  <title>Gestiones</title>
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
            <li class="nav-item active"><a class="nav-link" href="/paginawebrestaurante/administrador/inicio.php">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Menu</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Sobre Nosotros</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">Personal</a>
              <div class="dropdown-menu" aria-labelledby="dropdown-a">
                <a class="dropdown-item" href="/paginawebrestaurante/administrador/listado.php">Lista de personal</a>
                <a class="dropdown-item" href="/paginawebrestaurante/administrador/agregar.php">Registrar</a>
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
  <div class="about-section-box">
    <div id="slides" class="cover-slides">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 text-center">
            <div class="inner-column">
              <h1>Bienvenido <span>Administrador@</span></h1>
              <!--<h4>Little Story</h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque auctor suscipit feugiat. Ut at
                pellentesque ante, sed convallis arcu. Nullam facilisis, eros in eleifend luctus, odio ante sodales
                augue, eget lacinia lectus erat et sem. </p> -->
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12">
            <img src="../images/about-img.jpg" alt="" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../js2/jquery-3.2.1.min.js"></script>
  <script src="../js2/popper.min.js"></script>
  <script src="../js2/bootstrap.min.js"></script>
  <!-- ALL PLUGINS -->
  <script src="../js2/jquery.superslides.min.js"></script>
  <script src="../js2/images-loded.min.js"></script>
  <script src="../js2/isotope.min.js"></script>
  <script src="../js2/baguetteBox.min.js"></script>
  <script src="../js2/form-validator.min.js"></script>
  <script src="../js2/contact-form-script.js"></script>
  <script src="../js2/custom.js"></script>
  <script src="../js2/script.js"></script>
</body>

</html>