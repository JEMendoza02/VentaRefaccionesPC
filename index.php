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

<!-- index.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Tu página de reparación de computadoras</title>
</head>
<body>
<script src="logout.js"></script>
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
                echo '<button class="button" id="logout-button"><a href="logout.php">Cerrar sesión</a></button>';
                echo '<button class="button"><a href="miscursos.php">Mis Cursos</a></button>';
                echo '<form action="catalogo_herr.php" method="POST" id="logout-form">
                <button type="submit" id="logout-button" class="button">Herramientas</button>
              </form>';
            } else {
                // El usuario no ha iniciado sesión, mostrar los botones de "Iniciar sesión" y "Registrarse"
                echo '<button class="button"><a href="' . $iniciar_sesion_url . '">' . $iniciar_sesion_texto . '</a></button>';
                echo '<button class="button"><a href="registrarse.php">Registrarse</a></button>';
                echo '<button class="button">Carrito de compras</button>';
            }
            ?>
        </div>
    </div>
</div>
    <section class="course-section">
  <div class="container">
    <div class="course-info">
      <h2>Curso profesional de Reparación de PC</h2>
      <p class="course-description">Aprende montaje, reparación, detección de fallas, limpieza, eliminación de virus, optimización y ¡mucho más! Avalado por 500 estudiantes satisfechos.</p>
    </div>
    <div class="course-preview">
      <div class="course-preview-description">
        <h3>Aprende todo sobre reparación de PC</h3>
        <p>Ideal para emprender un negocio propio o bien para conseguir un empleo con alta demanda. Diseñado para amantes de la informática, gamers, emprendedores y cualquier persona interesada en las computadoras.</p>
        <a href="demostracion.php" class="btn">Ver más del curso</a>
      </div>
    </div>
  </div>
</section>
<div class="course-details-section">
  <h2>Detalles del curso</h2>
  <div class="course-details-content">
    <p>En este curso profesional recibirás todo el conocimiento de manera teórica y práctica a través de nuestra plataforma por reconocidos profesores,
      <strong>te enseñaremos fundamentos esenciales para diagnosticar y solucionar fallas en computadoras, optimizar su rendimiento y mantenerlos en perfecto estado,</strong>
      para que puedas aplicarlo en tu ambiente de trabajo, conseguir empleo o bien emprender como técnico, con tu propio taller de reparación.</p>
  </div>
</div>
<br><br>
<div class="benefits-section">
  <h2>Aprender Reparación de PC</h2>
  <p>Te brinda un conjunto de habilidades valiosas, te ahorra dinero, te abre puertas profesionales, te brinda autonomía y te ayuda a entender mejor la tecnología en la que confiamos en nuestra vida cotidiana. Es una inversión en conocimientos que puede</p>
  <h3 class="benefits-title">GENERAR GRANDES BENEFICIOS!</h3>
  <div class="benefits-container">
    <div class="benefit">
      <img src="laboral.jpg" alt="Beneficio 1">
      <h4>Alta Demanda laboral</h4>
      <p>En un mundo cada vez más digitalizado, la necesidad de técnicos especializados en la reparación de computadoras nunca ha sido mayor. Con el crecimiento constante del uso de la tecnología, siempre habrá personas y empresas que necesiten de tus servicios.</p>
    </div>
    <div class="benefit">
      <img src="emprendimiento.png" alt="Beneficio 2">
      <h4>Oportunidad de emprendimiento</h4>
      <p>¿Siempre has soñado con ser tu propio jefe y manejar tu propio negocio? La reparación de computadoras ofrece la oportunidad perfecta para emprender.</p>
    </div>
    <div class="benefit">
      <img src="flexibilidad.png" alt="Beneficio 3">
      <h4>Flexibilidad y movilidad</h4>
      <p>Una vez que adquieras los conocimientos necesarios podrás ejercer tus habilidades en cualquier lugar. La reparación de computadoras te brinda la flexibilidad de trabajar desde casa, abrir una tienda física o incluso ofrecer servicios a domicilio, adaptándose a tus necesidades y preferencias.</p>
    </div>
    <div class="benefit">
      <img src="ingresos.png" alt="Beneficio 4">
      <h4>Potencial de ingresos</h4>
      <p>La reparación de computadoras puede ser un campo lucrativo. A medida que adquieras experiencia y te especialices en áreas específicas, como la reparación de hardware o eliminación de malware, podrás aumentar tus tarifas y generar mayores ingresos. Además, al emprender tu propio negocio, podrás establecer tus precios y decidir tu propia rentabilidad.</p>
    </div>
  </div>  
</div>

<footer>
  <div class="footer-info">
    <div class="footer-section">
      <div class="footer-box">
        <h3>Fecha</h3>
        <p>Inicio: Curso disponible todo el año.<br>Días: 24/7 acceso total</p>
      </div>
      <div class="footer-box">
        <h3>Horario de Clase</h3>
        <p>Libre, puedes adaptar tus horarios a nuestras clases</p>
      </div>
      <div class="footer-box">
        <h3>Modalidad</h3>
        <p>100% Online</p>
      </div>
      <div class="footer-box">
        <h3>¿Y si me pierdo mi clase?</h3>
        <p>Están grabadas para que las veas cuando puedas</p>
      </div>
    </div>
    <div class="footer-pricing">
      <button class="enroll-button">Inscríbeme ahora</button>
      <p class="pricing-details">Precio regular: <span class="regular-price">$2500</span> <br>Precio de promoción: <span class="promotion-price"> $1500</span></p>
    </div>
  </div>
</footer>
<div class="certificate-section">
  <div class="certificate-image">
    <img src="thumbs.png" alt="Imagen del certificado">
  </div>
  <div class="certificate-description">
    <h3>Al finalizar el curso, obtendrás un certificado con validez curricular</h3>
    <p>Acredita los conocimientos obtenidos por nuestra Academia, apto para adjuntar a tu currículum, subir en Linkedin e Imprimirlo.</p>
    <ul>
      <li>Crece intelectualmente aprendiendo todo sobre computación.</li>
      <li>Repara y optimiza sin tener que buscar técnicos.</li>
      <li>Monta tu PC Gamer con éxito.</li>
      <li>Obtén ingresos reparando computadoras y laptops.</li>
    </ul>
    <h3>¿Dudas? Contáctanos!</h3>
    <p>Nuestros teléfonos: <br>55-5555-1111<br>55-2222-5555</p>
  </div>
</div>

</body>

</html>
