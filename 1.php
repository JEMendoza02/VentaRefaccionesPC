<?php
// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"]) && isset($_POST["descripcion"]) && isset($_POST["precio"]) && isset($_FILES["imagen"])) {
    //Recupera los datos del formulario 
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];

    // Procesa la imagen
    $imagen_binaria = null; // Inicializa la variable imagen_binaria

    if (isset($_FILES["imagen"])) {
        // Abre el archivo de imagen para lectura
        $imagen = fopen($_FILES["imagen"]["tmp_name"], 'rb');

        // Convierte la imagen en una cadena binaria
        $imagen_binaria = fread($imagen, filesize($_FILES["imagen"]["tmp_name"]));

        // Cierra el archivo de imagen
        fclose($imagen);
    }

    //Inlcuir la conexion a la base de datos
    require('conexion.php');

    //Realizar la consulta
    $sql = "INSERT INTO herramientas (nombre, descripcion, imagen, precio) VALUES ('$nombre','$descripcion','$imagen_binaria','$precio')";

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
<div class="container">
    <div class="add-form">
      <div class="logo">
        <img src="ruta/logo.png" alt="Logo del negocio">
      </div>
       <!-- <h1>Administrar Herramientas</h1>-->
        <form action="#" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre de la Herramienta</label>
                <input type="text" class="form-control" name="nombre" placeholder="Nombre de la Herramienta">
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" class="form-control" name="descripcion" placeholder="Descripcion"></textarea>
            </div>

            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" name="precio" step="0.01" required>
            </div>

            <button type="submit" class="btn btn-primary">Añadir Herramienta</button>
        </form>
    </div>
</div>
</body>
</html>