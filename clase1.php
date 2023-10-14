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
if (isset($_POST["agregar_al_carrito"]) ) {
    
    // Obtener información del producto desde la base de datos
    $sql = "SELECT imagen, nombre, descripcion, precio FROM herramientas WHERE id = '24'";
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles_catalogo.css">
    <title>Primera Clase - Electrónica Fundamental</title>
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
                    echo '<form action="control_herramienta.php" method="POST" id="tools-form">
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
<div class="container mt-4">
        <div class="row">
            <div class="col-lg-6">
                <h1>Bienvenido a la primera clase</h1>
            </div>
            <div class="col-lg-6">
                <!-- Imagen de bienvenida -->
                <img src="elec1.png" alt="Imagen de bienvenida" class="img-fluid float-right">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-6">
                <h2>Electrónica fundamental</h2>
                <h3>Aplicación en el área de la informática</h3>
                <p align="justify">La electrónica es la ciencia y tecnología que se ocupa de la creación de circuitos eléctricos y sus componentes, utilizados para controlar la corriente eléctrica y producir efectos como la amplificación o generación de señales.</p>
                <p align="justify">Es fundamental en la informática y las telecomunicaciones, permitiendo el procesamiento y transmisión de la información. Los dispositivos electrónicos como microprocesadores y chips, son esenciales en computadoras y sistemas de comunicaciones modernos. También se utiliza en dispositivos como teléfonos móviles, sistemas GPS y routers de redes. En síntesis, la electrónica es crucial para los sistemas informáticos indispensables en la sociedad actual.</p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-4">
                <!-- Imagen 1 -->
                <img src="c1_1.jpg" alt="Imagen 1" class="img-fluid">
            </div>
            <div class="col-lg-4">
                <!-- Imagen 2 -->
                <img src="c1_2.jpg" alt="Imagen 2" class="img-fluid">
            </div>
            <div class="col-lg-4">
                <!-- Imagen 3 -->
                <img src="c1_3.jpg" alt="Imagen 3" class="img-fluid">
            </div>
        </div>
    </div>
    
    
    <div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-3 bg-light text-dark py-4 px-5 rounded">
      <h3>Electrónica Analógica</h3>
      <p align="justify">La electrónica puede dividirse en 2 categorías: analógica y digital. La electrónica analógica se enfoca en el procesamiento de señales continuas, que pueden tomar cualquier valor en un rango determinado. Por ejemplo, una señal de audio es una señal analógica, ya que varía continuamente en amplitud y frecuencia. Los circuitos analógicos utilizan componentes como resistores, capacitores e inductores para manipular y procesar estas señales.</p>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2 bg-light text-dark py-4 px-5 rounded">
      <h3>Electrónica Digital</h3>
      <p align="justify">Por otro lado, la electrónica digital se enfoca en el procesamiento de señales discretas que solo pueden tomar valores específicos, como 0 o 1. Los circuitos digitales utilizan componentes como compuertas lógicas, flip-flops y microcontroladores para manipular y procesar estas señales. La electrónica digital se utiliza ampliamente en la electrónica de computadoras y de comunicaciones.</p>
      <div class="row">
        <div class="col-md-6">
          <img src="ed1.jpg" alt="Imagen 1" class="img-fluid">
        </div>
        <div class="col-md-6">
          <img src="ed2.jpg" alt="Imagen 2" class="img-fluid">
        </div>
      </div>
      <p align="justify">En resumen, la principal diferencia entre la electrónica analógica y la digital es que la primera procesa señales continuas mientras que la segunda procesa señales discretas.</p>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <h3>1.2 Corriente Eléctrica</h3>
      <p align="justify">La corriente eléctrica es el flujo de carga eléctrica que circula a través de un conductor y se mide en amperios (A).</p>
      <p align="justify">Es fundamental para el funcionamiento de diferentes dispositivos, ya que proporciona la energía necesaria para que sus componentes puedan operar. Si la corriente eléctrica no es constante o no es suficiente para alimentar adecuadamente los componentes electrónicos, el rendimiento de los dispositivos se puede ver afectado. Por ejemplo, en el caso de una computadora, una corriente eléctrica inestable puede provocar errores en el sistema operativo, bloqueos y fallos en el hardware. En el caso de un teléfono celular, una corriente eléctrica insuficiente puede hacer que la batería se descargue más rápido o que el teléfono no pueda cargar completamente. Por lo tanto, es importante asegurarse que estén conectados a una fuente de energía estable y adecuada para su correcto funcionamiento.</p>
      <img src="ce.jpg" alt="Imagen Ilustrativa" class="img-fluid">
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2 mt-5">
      <h3 class="text-center">Corriente Alterna</h3>
      <p align="justify">La corriente eléctrica alterna (AC) es una corriente eléctrica que cambia su dirección y magnitud periódicamente.</p>
      <p align="justify">Su característica principal es que el flujo de electrones va de un lado al otro cambiando su polaridad, alrededor de 50 o 60 veces por segundo según el país. La corriente alterna se utiliza en dispositivos informáticos y de comunicación porque es fácilmente transformable en diferentes niveles de voltaje, lo que permite su uso en distintas aplicaciones. Además, la corriente alterna se puede transmitir a largas distancias con menos pérdidas de energía que la corriente directa, lo que la hace más eficiente en la transmisión de energía eléctrica a través de redes eléctricas.</p>
      <div class="text-center">
        <img src="ac.png" class="img-fluid rounded" alt="Imagen de referencia">
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2 mt-5">
      <h3 class="text-center">Corriente Directa</h3>
      <p align="justify">La corriente eléctrica directa (DC) es una corriente eléctrica que fluye en una sola dirección.</p>
      <p align="justify">Es altamente importante para energizar dispositivos informáticos porque muchos de los componentes electrónicos en estos dispositivos requieren una fuente de alimentación de corriente continua para funcionar adecuadamente. Los componentes electrónicos, como los microprocesadores y los circuitos integrados, son sensibles a las fluctuaciones de voltaje y requieren una fuente de alimentación estable y confiable para evitar errores y fallos en el sistema. Además, la corriente directa es utilizada en baterías, lo que permite que los dispositivos informáticos sean portátiles y se puedan utilizar en cualquier lugar sin necesidad de estar conectados a la red eléctrica.</p>
      <div class="text-center">
        <img src="cc.png" class="img-fluid rounded" alt="Imagen de referencia">
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2 mt-5">
      <h3 class="text-center">Voltaje</h3>
      <p align="justify">Es la diferencia de potencial eléctrico entre dos puntos en un circuito eléctrico. Se mide en voltios (V) y representa la cantidad de energía eléctrica que se requiere para mover una carga eléctrica de un punto a otro en el circuito. En términos simples, el voltaje es la fuerza que impulsa el flujo de corriente eléctrica a través de un circuito. También es llamado Tensión o Fuerza Electromotriz (FEM).</p>
      <p align="justify">El voltaje es una medida fundamental en la industria informática, ya que los componentes electrónicos utilizados como los microprocesadores, las memorias y los circuitos integrados, requieren una fuente de alimentación estable y precisa para funcionar adecuadamente. La alimentación eléctrica se proporciona a estos componentes mediante un suministro de voltaje, que se convierte y se regula a través de fuentes de alimentación y reguladores de voltaje. El voltaje también es utilizado en la comunicación de datos, donde los niveles de voltaje se utilizan para representar los unos y ceros binarios que conforman la información digital.</p>
      <div class="row">
        <div class="col-md-6">
          <div class="text-center">
            <img src="v1.jpg" class="img-fluid rounded" alt="Imagen ilustrativa 1">
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-center">
            <img src="v2.jpg" class="img-fluid rounded" alt="Imagen ilustrativa 2">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2 mt-5">
      <div class="alert alert-warning text-center" role="alert">
        <h4>¡Adquiere el curso completo para acceder a todas las clases!</h4>
        <p align="justify">No te pierdas el contenido exclusivo y completo del curso. Obtén acceso ilimitado a todas las lecciones, materiales adicionales y soporte personalizado. ¡No esperes más, mejora tus habilidades en electrónica hoy mismo!</p>
        <form action="#" method="POST">
        <button type="submit" name="agregar_al_carrito" class="btn">Comprar curso completo</button>
      </div>
    </div>
  </div>
</div>
</main>





    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
