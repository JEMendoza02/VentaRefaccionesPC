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
if (isset($_POST["eliminar_seleccionados"])) {
    if (isset($_POST["eliminar_producto"]) && is_array($_POST["eliminar_producto"])) {
        foreach ($_POST["eliminar_producto"] as $producto_id) {
            // Verificar si el producto existe en el carrito antes de eliminarlo
            if (isset($_SESSION["carrito"][$producto_id])) {
                // Eliminar el producto del carrito
                unset($_SESSION["carrito"][$producto_id]);
            }
        }
    }
    // Redirigir nuevamente a la página del carrito
    header("Location: carrito.php");
    exit();
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles_carrito.css">
    <title>Resumen del Carrito</title>
</head>
<body>
<!-- Barra de navegación -->
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
                    echo '<form action="catalogo_herr.php" method="POST" id="tools-form">
                    <button type="submit" id="tools-button" class="button">Regresar</button>
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
</div>

<main>
    <section class="container">
        <h1>Resumen del Carrito</h1>
        <form action="#" method="POST">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Imagen</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Seleccionar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (isset($_SESSION["carrito"]) && is_array($_SESSION["carrito"])) {
                            foreach ($_SESSION["carrito"] as $producto_id => $producto) {
                                echo '<tr>';
                                echo '<td>' . $producto['nombre'] . '</td>';
                                echo '<td><img src="data:image/jpeg;base64,' . $producto['imagen'] . '" alt="' . $producto['nombre'] . '" witdh="200" height="200">';
                                echo '<td>' . $producto['descripcion'] . '</td>';
                                echo '<td>$' . $producto['precio'] . '</td>';
                                echo '<td>';
                                echo '<input type="checkbox" name="eliminar_producto[]" value="' . $producto_id . '">'; // Checkbox
                                echo '</td>';
                                echo '</tr>';
                            }
                        
                        } else {
                            echo '<p>El carrito está vacío.</p>';
                        }
                        
                    ?>
                </tbody>
            </table>
            <?php 
             echo '<button type="submit" name="eliminar_seleccionados">Eliminar Seleccionados</button>';
             echo '</form>';
                   $total = 0;
            if (isset($_SESSION["carrito"]) && is_array($_SESSION["carrito"])) {
                // Calcular el total
                foreach ($_SESSION["carrito"] as $producto_id => $producto) {
                    $total += $producto['precio'];
                }
            
            }
            
            ?>
            <form action="procesar_pago.php" method="POST">
            <div class="total">
                <p>Total: <?php echo $total; ?></p>
            </div>

            <button type="submit" class="btn btn-primary">Pagar</button>
        </form>
    </section>
</main>
</body>
</html>
