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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles_catalogo.css">
    <title>Catalogo de </title>
</head>
<body>
<div class="navbar">
    <div class="container">
        <div class="logo">Logo</div>
        <div class="search-bar">
            <input type="text" placeholder="Buscar...">
            <button type="submit">Buscar</button>
        </div>
        <div class="nav-buttons">
            <?php
            if (isset($_SESSION["username"])) {
                // El usuario ha iniciado sesión, mostrar el mensaje de bienvenida
                echo '<b><span class="welcome-message">Bienvenido, ' . $_SESSION["username"] . '</span>' . '</b>';
                echo '<form action="logout.php" method="POST" id="logout-form">
                <button type="submit" id="logout-button" class="button">Cerrar Sesión</button>
              </form>';
                echo '<form action="miscursos.php" method="POST" id="logout-form">
                <button type="submit" id="logout-button" class="button">Mis Cursos</button>
              </form>';
                echo '<form action="index.php" method="POST" id="logout-form">
                <button type="submit" id="logout-button" class="button">Inicio</button>
              </form>';

                // Verificar el rol del usuario
                if ($_SESSION["rol"] == 1) {
                    // Si el ID de usuario es 1 (Administrador), mostrar el botón "Control de Herramientas"
                    echo '<form action="control_herr.php" method="POST" id="tools-form">
                    <button type="submit" id="tools-button" class="button">Control de Herramientas</button>
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

<main>
    <section class="jumbotron">
        <div class="texto">
            <h2>Memorias RAM 8GB marca Corsair 2x</h2>
            <p>Con estas 2 memorias de 8GB cada uno de la marca Corsair, usted puede regresar al mundo del gaming gracias a su poder de velocidad de frecuencia de 3200MHz, más rapido que
                las memorias estándar del mercado. Además, aproveche la oferta de 2, ya que así tendrá un total de 16GB de memoria, una total brutalidad si usted se va a dedicar 
                al gaming, diseño gráfico, programación, arquitectura, o cualquier otra actividad que demande muchos recursos de la computadora en torno a la memoria RAM. 
                Ofrecido con la última tecnología de Corsair.
            </p>
            <a href="#" class="btn">Comprar</a>
        </div>
        <div class="imagen">
            <img src="ram.jpg" alt="Memoria RAM Corsair 2x8GB">
        </div>
    </section>
    <?php 
// Incluir la conexión a la base de datos
require('conexion.php');

// Realizar la consulta para obtener las herramientas almacenadas
$sql = "SELECT nombre, descripcion, imagen, precio FROM herramientas";
$result = $mysqli->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $nombre = $row['nombre'];
        $descripcion = $row['descripcion'];
        $imagen = base64_encode($row['imagen']); // La imagen se almacena en formato BLOB, así que necesitas convertirla a base64
        $precio = $row['precio'];

        // Generar el HTML para mostrar la herramienta
        echo '<section class="jumbotron">';
        echo '<div class="texto">';
        echo '<h2>' . $nombre . '</h2>';
        echo '<p>' . $descripcion . '</p>';
        echo '<p>Precio: $' . $precio . '</p>';
        echo '<a href="#" class="btn">Comprar</a>';
        echo '</div>';
        echo '<div class="imagen">';
        echo '<img src="data:image/jpeg;base64,' . $imagen . '" alt="' . $nombre . '">';
        echo '</div>';
        echo '</section>';
    }

    // Liberar el resultado de la consulta
    $result->free();
} else {
    echo "Error al consultar la base de datos: " . $mysqli->error;
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>

</main>