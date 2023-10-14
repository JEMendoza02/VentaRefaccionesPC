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

// Incluir la conexión a la base de datos
require('conexion.php');
// Verificar si se ha agregado un producto al carrito
if (isset($_POST["agregar_al_carrito"]) && isset($_POST["producto_id"])) {
    $producto_id = $_POST["producto_id"];
    
    // Obtener información del producto desde la base de datos
    $sql = "SELECT imagen, nombre, descripcion, precio FROM herramientas WHERE id = '$producto_id'";
    $result = $mysqli->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        $nombre = $row['nombre'];
        $descripcion = $row['descripcion'];
        $precio = $row['precio'];
        $imagen = base64_encode($row['imagen']);

        // Agregar el producto al carrito (puedes guardar los productos en un arreglo en la sesión)
        $_SESSION["carrito"][$producto_id] = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'imagen' => $imagen,
        );
    }
    
    // Redirigir al carrito
    header("Location: carrito.php");
    exit();
}

// Función para verificar si un producto está en el carrito
function estaEnCarrito($producto_id) {
    return isset($_SESSION["carrito"][$producto_id]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles_catalogo.css">
    <title>Catalogo de Herramientas</title>
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

                // Verificar el rol del usuario
                if ($_SESSION["rol"] == 1) {
                    // Si el ID de usuario es 1 (Administrador), mostrar el botón "Control de Herramientas"
                    echo '<form action="control_herr.php" method="POST" id="tools-form">
                    <button type="submit" id="tools-button" class="button">Control de Herramientas</button>
                  </form>';
                }
                // Agrega la sección del carrito
                echo '<form action="carrito.php" method="POST" id="cart-form">';
                 echo '<button type="submit" id="cart-button" class="button">';
                 if (isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
                    $numArticulos = count($_SESSION['carrito']);
                    echo '<span class="num-articulos">' . $numArticulos . '</span>';
                } else {
                    echo '<span class="num-articulos">0</span>';
                }
                echo 'Carrito</button>';
                echo '</form>';
               
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
    <?php 
    

    // Realizar la consulta para obtener las herramientas almacenadas
    $sql = "SELECT id, nombre, descripcion, imagen, precio FROM herramientas";
    $result = $mysqli->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $producto_id = $row['id'];
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
            
            if (isset($_SESSION["username"])) {
                // Si el usuario ha iniciado sesión, mostrar el botón de "Comprar" solo si el producto no está en el carrito
                if (estaEnCarrito($producto_id)) {
                    echo '<p>Ya en el carrito</p>';
                } else {
                    echo '<form action="catalogo_herr.php" method="POST">';
                    echo '<input type="hidden" name="producto_id" value="' . $producto_id . '">';
                    echo '<button type="submit" name="agregar_al_carrito" class="btn">Comprar</button>';
                    echo '</form>';
                }
            }
            
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
</body>
</html>
