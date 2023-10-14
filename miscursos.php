<?php
// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION["username"])) {
    // Si no ha iniciado sesión, redirige al usuario a la página de inicio de sesión
    header("Location: login.php");
    exit;
}

// Aquí va el código para mostrar la tabla de cursos del usuario
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Cursos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo_miscursos.css">
</head>
<body>
    <script src="logout.js"></script>
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
                <button type="submit" id="logout-button" class="button">Cerrar sesión</button>
              </form>';
                echo '<form action="carrito.php" method="POST">
                <button type="submit" class="button">Carrito</button>
              </form>';
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

    <div class="container mt-5">
        <div class="login-form">
            <h1 class="text-center">Mis Cursos</h1>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID Curso</th>
                        <th>Nombre del curso</th>
                        <th>Descripción del curso</th>
                        <th>Acceder</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí va el código PHP para mostrar los cursos del usuario -->
                    <!-- Puedes utilizar un bucle para recorrer los cursos y mostrarlos en la tabla -->
                    <?php
                    // Aquí va el código para obtener los cursos del usuario y mostrarlos en la tabla
                    // Puedes utilizar una consulta a la base de datos para obtener los cursos del usuario
                    // y luego un bucle para recorrer los resultados y mostrarlos en la tabla
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
