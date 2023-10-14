<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión
$iniciar_sesion_texto = "Iniciar sesión";
$iniciar_sesion_url = "login.php"; // Redireccionamiento a la página de inicio de sesión

if (isset($_SESSION["username"])) {
    // El usuario ha iniciado sesión
    $iniciar_sesion_texto = "Cerrar sesión";
    $iniciar_sesion_url = "logout.php";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <title>Clase de Demostración</title>
</head>

<body>

  <!-- Barra de navegación -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container" style="background-color: orange;">
    <a class="navbar-brand" href="#">Logo</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <input class="form-control" type="text" placeholder="Buscar...">
        </li>
        <li class="nav-item">
          <button class="btn btn-primary" type="button">Buscar</button>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">Iniciar sesión</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Registrarse</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Carrito de compras</a>
        </li>
      </ul>
    </div>
  </div>
</nav>



  <!-- Sección de bienvenida -->
  <section class="jumbotron text-center">
    <h1 class="display-4">¡Bienvenido/a a nuestra Clase de Demostración!</h1>
    <p class="lead">Descubre los contenidos y metodología de nuestro curso de Reparación de PC.</p>
    <a href="clase1.php" class="btn btn-primary btn-lg">Empezar Clase Gratuita</a>
  </section>

  <!-- Resto del contenido de la página -->
  <section class="benefits-section">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <img src="elec.jpg" alt="Ilustración" class="img-fluid">
      </div>
      <div class="col-md-6">
        <h2>Por qué la Electrónica es fundamental</h2>
        <ul>
          <li>Aprenderás los conceptos básicos de la electrónica y su importancia en la tecnología moderna.</li>
          <li>Comprenderás cómo funcionan los componentes electrónicos y cómo se interconectan.</li>
          <li>Descubrirás las aplicaciones prácticas de la electrónica en la vida cotidiana y en diversos campos.</li>
          <li>Explorarás las oportunidades profesionales y laborales relacionadas con la electrónica.</li>
        </ul>
        <a href="clase1.php" class="btn btn-primary">Comenzar la clase gratuita</a>
      </div>
    </div>
  </div>
</section>


  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
