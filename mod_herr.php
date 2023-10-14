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

// Incluir la conexión a la base de datos
require('conexion.php');

// Verificar si se ha enviado el nombre o el ID de la herramienta a modificar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre_o_id"])) {
    $nombre_o_id = $_POST["nombre_o_id"];

    // Realizar la consulta para obtener la información de la herramienta
    $sql = "SELECT nombre, descripcion, imagen, precio FROM herramientas WHERE nombre = '$nombre_o_id' OR id = '$nombre_o_id'";
    $result = $mysqli->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $nombre = $row['nombre'];
        $descripcion = $row['descripcion'];
        $imagen = base64_encode($row['imagen']); // La imagen se almacena en formato BLOB, así que necesitas convertirla a base64
        $precio = $row['precio'];
    } else {
        echo "Error al consultar la base de datos: " . $mysqli->error;
    }
}

// Verificar si se ha enviado el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"]) && isset($_POST["descripcion"]) && isset($_POST["precio"]) && isset($_FILES["imagen"])) {
    // Recuperar los datos del formulario
    $nuevo_nombre = $_POST["nombre"];
    $nueva_descripcion = $_POST["descripcion"];
    $nuevo_precio = $_POST["precio"];

    // Verificar si se ha seleccionado una nueva imagen
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["size"] > 0) {
    // Procesa la nueva imagen
    $nueva_imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
} else {
    // Mantén la imagen existente sin cambios
    $nueva_imagen = $imagen; // Donde $imagen_existente es la imagen actual de la herramienta en la base de datos
}

// Realizar la actualización en la base de datos
    $sql = "UPDATE herramientas SET nombre = '$nuevo_nombre', descripcion = '$nueva_descripcion', imagen = '$nueva_imagen', precio = '$nuevo_precio' WHERE nombre = '$nombre'";
    
    if ($mysqli->query($sql) === TRUE) {
        echo "Herramienta modificada exitosamente.";
    } else {
        echo "Error al modificar la herramienta: " . $mysqli->error;
    }
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo_modherr.css">
    <title>Modificar Herramienta</title>
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
                  echo '<form action="control_herr.php" method="POST" id="modtools-form">
                  <button type="submit" id="modtools-button" class="button">Agregar</button>
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
    <?php
    if (isset($nombre)) {
        // Mostrar el formulario prellenado con los detalles de la herramienta
        echo '<div class="mod-form">';
        echo '<h1>Modificar Herramienta</h1>';
        echo '<form action="#" method="POST" enctype="multipart/form-data">';
        echo '<input type="hidden" name="nombre_o_id" value="' . $nombre_o_id . '">';
        echo '<div class="form-group">';
        echo '<label for="nombre">Nombre de la Herramienta</label>';
        echo '<input type="text" class="form-control" name="nombre" placeholder="Nombre de la Herramienta" value="' . $nombre . '">';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="descripcion">Descripción</label>';
        echo '<textarea id="descripcion" class="form-control" name="descripcion" placeholder="Descripción">' . $descripcion . '</textarea>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="imagen">Cargar Nueva Imagen (Opcional)</label>';
        echo '<input type="file" name="imagen" accept="image/*">';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="precio">Precio</label>';
        echo '<input type="number" name="precio" step="0.01" value="' . $precio . '">';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary">Guardar Cambios</button>';
        echo '</form>';
        echo '</div>';
    } else {
        // Mostrar el formulario para ingresar el nombre o ID de la herramienta a modificar
        echo '<div class="mod-form">';
        echo '<h1>Modificar Herramienta</h1>';
        echo '<form action="#" method="POST">';
        echo '<div class="form-group">';
        echo '<label for="nombre_o_id">Nombre o ID de la Herramienta</label>';
        echo '<input type="text" class="form-control" name="nombre_o_id" placeholder="Nombre o ID de la Herramienta">';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary">Buscar Herramienta</button>';
        echo '</form>';
        echo '</div>';
    }
    ?>
</div>
</body>
</html>

