<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión
$iniciar_sesion_texto = "Iniciar sesión";
$iniciar_sesion_url = "login.php"; // Redireccionamiento a login

if (isset($_SESSION["username"])) {
    // El usuario ha iniciado sesión
    $iniciar_sesion_texto = "Cerrar sesión";
    $iniciar_sesion_url = "logout.php";
}
$username = $_SESSION["username"];
// Verificar el rol del usuario
if (isset($_SESSION["rol"]) && $_SESSION["rol"] == 1) {
    // El usuario es administrador, puede eliminar herramientas
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_herramienta"])) {
        // Recupera el ID de la herramienta a eliminar
        $id_herramienta = $_POST["id_herramienta"];
        $admin_password = $_POST["admin_password"];

        // Incluye la conexión a la base de datos
        require('conexion.php');

          // Prepara la consulta para obtener la contraseña encriptada del administrador
          $sql = "SELECT contra FROM usuarios WHERE username = '$username'"; 

          if ($result = $mysqli->query($sql)) {
              if ($result->num_rows === 1) {
                  $row = $result->fetch_assoc();
                  $admin_password_db_hash = $row["contra"];
  
                  // Verifica la contraseña del administrador
                  if (password_verify($admin_password, $admin_password_db_hash)) {
                      // La contraseña es correcta, procede con la eliminación
                      $sql_delete = "DELETE FROM herramientas WHERE id = ?";
  
                      if ($stmt = $mysqli->prepare($sql_delete)) {
                          $stmt->bind_param("i", $id_herramienta);
  
                          if ($stmt->execute()) {
                              echo "La herramienta ha sido eliminada con éxito.";
                          } else {
                              echo "Error al eliminar la herramienta: " . $stmt->error;
                          }
  
                          $stmt->close();
                      } else {
                          echo "Error al preparar la sentencia: " . $mysqli->error;
                      }
                  } else {
                      echo "Contraseña de administrador incorrecta. No se permitió la eliminación de la herramienta.";
                  }
              } else {
                  echo "No se encontró al administrador en la base de datos.";
              }
  
              $result->free();
          } else {
              echo "Error al consultar la base de datos: " . $mysqli->error;
          }
  
          $mysqli->close();
      }
  } else {
      // El usuario no tiene permisos para eliminar herramientas
      echo "No tiene permisos para eliminar herramientas.";
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo_delherr.css">
    <title>Eliminar Herramienta</title>
</head>
<body>
<div class="navbar">
    <div class="container">
        <div class="logo">Logo</div>
        <div class="nav-buttons">
            <?php
            if (isset($_SESSION["username"])) {
                // El usuario ha iniciado sesión, mostrar el mensaje de bienvenida
                echo '<b><span class="welcome-message">Bienvenido, ' . $_SESSION["username"] . ' al Menú de Eliminación de Herramientas' . '</span>' . '</b>';
                echo '<form action="logout.php" method="POST" id="logout-form">
                <button type="submit" id="logout-button" class="button">Cerrar Sesión</button>
              </form>';

                // Verificar el rol del usuario
                if ($_SESSION["rol"] == 1) {
                    // Si el ID de usuario es 1 (Administrador), mostrar el formulario de eliminación de herramientas
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
    <div class="del-form">
        <h1>Eliminar Herramienta</h1>
        <form action="#" method="POST" id="del-form">
        <div class="form-group">
            <label for="id_herramienta">ID de la Herramienta a Eliminar:</label>
            <input type="text" name="id_herramienta" required>
        </div>
        <div class="form-group">
        <label for="admin_password">Contraseña de Administrador:</label>
        <input type="password" name="admin_password" required>
        </div>
        <div class="form-group">
            <button type="submit" id="delete-button" class="button">Eliminar Herramienta</button>
        </div>
        </form>
    </div>
</div>
</body>
</html>
