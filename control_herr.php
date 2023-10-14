<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión
$iniciar_sesion_texto = "Iniciar sesión";
$iniciar_sesion_url = "login.php"; //Redireccionamiento a login

if (isset($_SESSION["username"])) {
    // El usuario ha iniciado sesión
    $iniciar_sesion_texto = "Cerrar sesión";
    $iniciar_sesion_url = "logout.php"; 
}

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"]) && isset($_POST["descripcion"]) && isset($_POST["precio"]) && isset($_FILES["imagen"])) {
    //Recupera los datos del formulario 
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];

    // Procesa la imagen
    $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));

    //Inlcuir la conexion a la base de datos
    require('conexion.php');

    //Realizar la consulta
    $sql = "INSERT INTO herramientas (nombre, descripcion, imagen, precio) VALUES ('$nombre','$descripcion','$imagen','$precio')";

    // Ejecutar la consulta
    if ($mysqli->query($sql) === TRUE) {
        echo "Registro exitoso. Los datos han sido insertados en la base de datos.";
    } else {
        echo "Error al registrar los datos: " . $mysqli->error;
    }

    // Cerrar la conexión a la base de datos
    $mysqli->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo_addherr.css">
    <title>Catalogo de Herramientas</title>
</head>
<body>
<div class="navbar">
    <div class="container">
        <div class="logo">Logo</div>
        <div class="nav-buttons">
            <?php
            if (isset($_SESSION["username"])) {
                // El usuario ha iniciado sesión, mostrar el mensaje de bienvenida
                echo '<b><span class="welcome-message">Bienvenido, ' . $_SESSION["username"] . ' al Menu de control de herramientas' . '</span>' . '</b>';
                echo '<form action="logout.php" method="POST" id="logout-form">
                <button type="submit" id="logout-button" class="button">Cerrar Sesión</button>
              </form>';
               

                // Verificar el rol del usuario
                if ($_SESSION["rol"] == 1) {
                    // Si el ID de usuario es 1 (Administrador), mostrar el botón "Control de Herramientas"
                  echo '<form action="mod_herr.php" method="POST" id="modtools-form">
                  <button type="submit" id="modtools-button" class="button">Modificar</button>
                </form>';
                echo '<form action="del_herr.php" method="POST" id="deltools-form">
                  <button type="submit" id="deltools-button" class="button">Eliminar</button>
                </form>';
                  echo '<form action="catalogo_herr.php" method="POST" id="back-button">
                  <button type="submit" id="back-button" class="button">Regresar</button>
                </form>';
                }
            } else {
                // El usuario no ha iniciado sesión, mostrar los botones de "Iniciar sesión" y "Registrarse"
                echo '<button class="button"><a href="' . $iniciar_sesion_url . '">' . $iniciar_sesion_texto . '</a></button>';
                echo '<button class="button" href="registrarse.php">Registrarse</button>';
                echo '<button class="button">Carrito de compras</button>';
            }
            ?>
        </div>
    </div>
</div>
<br><br><br>
  <div class="container">
    <div class="add-form">
      <div class="logo">
        <img src="ruta/logo.png" alt="Logo del negocio">
      </div>
        <h1>Agregar Herramientas</h1>
        <form action="#" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="nombre">Nombre de la Herramienta</label>
        <input type="text" class="form-control" name="nombre" placeholder="Nombre de la Herramienta">
    </div>

    <div class="form-group">
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" class="form-control" name="descripcion" placeholder="Descripción"></textarea>
    </div>

    <div class="form-group">
        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" accept="image/*" required>
    </div>

    <div class="form-group">
        <label for="precio">Precio</label>
        <input type="number" name="precio" step="0.01" required>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Añadir Herramienta</button>
        </form>
        </div>
    </div>
</body>
</html>