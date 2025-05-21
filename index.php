<?php
include 'php\esencial\conexion.php';
require_once "utilidades.php";


$query = "SELECT c.fecha, c.hora, s.nombre as alumno, v.descripcion as clase 
              FROM reservas c
              JOIN socio s ON c.codigo_socio = s.id_socio
              JOIN servicio v ON c.codigo_servicio = v.codigo_servicio";

$result = $conexion->query($query);

$reservas = [];
while ($row = $result->fetch_assoc()) {
  // Convertir la fecha y hora al formato deseado
  $formattedDate = date("d/m/Y", strtotime($row['fecha']));
  $formattedTime = date("H", strtotime($row['hora']));
  $reservas[] = [
    'fecha' => $formattedDate,
    'hora' => $formattedTime,
    'alumno' => $row['alumno'],
    'clase' => $row['clase']
  ];
}


$mensaje_enviado = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nombre = $_POST['nombre'];
  $email = $_POST['email'];
  $mensaje = $_POST['mensaje'];

  // Guardar mensaje en la base de datos (opcional)
  $query = "INSERT INTO mensajes_contacto (nombre, email, mensaje) VALUES (?, ?, ?)";
  $stmt = $conexion->prepare($query);
  $stmt->bind_param("sss", $nombre, $email, $mensaje);

  if ($stmt->execute()) {
    $mensaje_enviado = true;
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MNZone</title>
  <link rel="icon" type="image/ico" href="imagenes/Logo.ico" />
  <script src="js/header.js" defer></script>
  <link rel="stylesheet" href="css/styles.css">
  <script src="js/app.js" defer></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- llama a u -->
</head>

<body>
  <?php
  if (isset($_GET["error"])) {
    $error = $_GET['error'];
  } else {
    $error = 0;
  }
  ?>
  <header class="text-white">
    <nav class="navbar navbar-expand-lg navbar-dark container">
      <a class="navbar-brand" href="#">
        <img loading='lazy' class="logo" src="imagenes/Logo.png" alt="Logo MNZone">
      </a>
      <div id="menu">

      </div>


      <?php
      if (isset($_GET["error"])) {
        $error = $_GET['error'];
      } else {
        $error = 0;
      }
      ?>
      <div class="header-content">
        <?php

        session_start();
        require_once "utilidades.php";
        $pagina_actual = basename($_SERVER['PHP_SELF']);




        ?>
      </div>
      </div>
    </nav>



    <?php

    if (isset($_SESSION["nombre"])) {
      echo formulario_sesion_iniciada($_SESSION["nombre"]);
    } else {
      echo   "<div class='login-container'>
      <form class='login-form' action='iniciar_sesion.php' method='POST'>
          <label for='username'>Usuario:</label>
          <input type='text' id='username' name='username'  placeholder='Introduce tu usuario'>
          <label for='password'>Contraseña:</label>
          <input type='password' id='password' name='password'  placeholder='Introduce tu contraseña'>
          <input type='hidden' id='origen' name='origen' value='$pagina_actual'>
          <a href='php/socios/register.php'>¿No tienes cuenta?</a>";
      if ($error == 1) {
        echo "<p class='error' style='background:white; color:red'>Usuario o contraseña erróneos</p>
              <button style='border-radius:5%'type='submit'>Iniciar sesión</button>";
      } else if ($error == 2) {
        echo "<p class='error' style='background:white; color:red'>Falta usuario o contraseña</p>
              <button style='border-radius:5%'type='submit'>Iniciar sesión</button>";
      } else {
        echo "<button type='submit'>Iniciar sesión</button>";
      }

      echo "</form>
      </div>";;
    }



    if (isset($_GET["error"])) {
      $error = $_GET['error'];
    } else {
      $error = 0;
    }
    ?>
    <br>

  </header>

  <nav id="enlaces" class="navbar navbar-expand-lg navbar-dark bg-dark" style="justify-content:center">
    <div class="container-fluid" style="justify-content: center;">
      <button class="navbar-toggler" id="abrirmenu" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav" aria-controls="menuNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menuNav" style="text-align:center">
        <!-- Haz unbotón para cerrar el menú -->
        <button class="btn navbar-toggler" id="Cerrarmenu" type="button">Cerrar menú</button>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="#" class="nav-link">Inicio</a>
          </li>
          <?php if (isset($_SESSION["nombre"])) { ?>
            <li class="nav-item">
              <a href="php/noticia/noticias.php" class="nav-link">Noticias</a>
            </li>
          <?php } ?>
          <?php if (isset($_SESSION["nombre"])) { ?>
            <li class="nav-item">
              <a href="php/reservas/reservas.php" class="nav-link">Reservas</a>
            </li>
          <?php } ?>
          <?php if (isset($_SESSION["nombre"])) { ?>
            <li class="nav-item">
              <a href="php/tienda/tienda.php" class="nav-link">Tienda</a>
            </li>
          <?php } ?>
          <li class="nav-item">
            <a href="php/servicio/servicios.php" class="nav-link">Servicios</a>
          </li>
          <li class="nav-item">
            <a href="php/equipos/equipos.php" class="nav-link">Equipos</a>
          </li>
          <?php if (isset($_SESSION["nombre"])) { ?>
            <li class="nav-item">
              <a href="php/recetas/recetas.php" class="nav-link">Recetas</a>
            </li>
          <?php } ?>
          <?php if (isset($_SESSION["nombre"])) { ?>
            <li class="nav-item">
              <a href="php/socios/socios.php" class="nav-link"><?php if (isset($_SESSION["nombre"]) && $_SESSION["tipo"] == "socio") {
                                                                  echo "Mi perfil";
                                                                } else {
                                                                  echo "Socios";
                                                                }
                                                                ?></a>
            </li>
          <?php } ?>
          <?php if (isset($_SESSION["nombre"])) { ?>
            <li class="nav-item">
              <a href="php/contacto/contacto.php" class="nav-link">Contacto</a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>


<main>
    <!-- Sobre Nosotros -->
    <section style="text-align: center;">
      <h1>MNZone</h1>
      <p>Centro E-Sports y Gaming en Granada
        Una experiencia de otro nivel para gamers en Granada. Disfruta de los ordenadores más potentes y el ping más bajo para jugar a máximo rendimiento</p>
    </section>
    <section>
      <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
          <?php
          // Consulta con límite de 3 noticias
          $query = "SELECT id_noticia, titulo, contenido, imagen, fecha_publicacion FROM noticia ORDER BY fecha_publicacion DESC LIMIT 3";
          $stmt = $conexion->prepare($query);
          $stmt->execute();
          $stmt->bind_result($id_noticia, $titulo, $contenido, $imagen, $fecha_publicacion);

          $index = 0; // Índice para los indicadores
          while ($stmt->fetch()) {
            echo "<button type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide-to='{$index}'" .
              ($index === 0 ? " class='active' aria-current='true'" : "") .
              " aria-label='Slide " . ($index + 1) . "'></button>";
            $index++;
          }
          $stmt->close();
          ?>
        </div>
        <div class="carousel-inner" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
          <?php
          // Ejecutar nuevamente la consulta para las diapositivas con el mismo límite
          $stmt = $conexion->prepare($query);
          $stmt->execute();
          $stmt->bind_result($id_noticia, $titulo, $contenido, $imagen, $fecha_publicacion);

          $index = 0;
          while ($stmt->fetch()) {
            echo "<div class='carousel-item " . ($index === 0 ? "active" : "") . "'>";
            echo "  <img loading='lazy' src='" . "imagenes/" . $imagen . "' class='d-block w-100' alt='" . htmlspecialchars($titulo) . "'>";
            echo "  <div style:background:'#ff00ff' class='carousel-caption d-none d-  md-block'>";
            echo "  </div>";

            echo "<div class='btn' style='background:#ff0000;border-radius:0;width:100%'>";
            echo "    <h5 style='color:white'>" . htmlspecialchars($titulo) . "</h5>";
            $contenido = substr($contenido, 0, 100) . '...';
            echo "    <p style='color:white'>" . htmlspecialchars($contenido) . "</p>";
            if (isset($_SESSION["nombre"])) {
              echo "<a style='color:white;' href='php/noticia/noticiaentera.php?id=$id_noticia'>Leer más...</a>";
            }
            echo " </br>";
            echo "    <small style='color:white'>Publicado el: " . htmlspecialchars($fecha_publicacion) . "</small>";
            echo "</div>";
            echo "</div>";
            $index++;
          }
          $stmt->close();
          ?>
        </div>
        <br>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

    </section>
    <section style="text-align: center;">
      <h2>Precios</h2>
      <div>

        <div>
          <table class="tablaprecios">
            <thead>
              <tr>
                <th>Tiempo</th>
                <th>Sala principal</th>
                <th>Sala VIP</th>
                <th>PS5</th>
                <th>Volante</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-weight: 700;">1h</td>
                <td class="precio">3€</td>
                <td class="precio">5€</td>
                <td class="precio">3€</td>
                <td class="precio">3€</td>
              </tr>
              <tr>
                <td style="font-weight: 700;">2h</td>
                <td class="precio">5€</td>
                <td class="precio">8€</td>
                <td class="precio">5€</td>
                <td class="precio">5€</td>
              </tr>
              <tr>
                <td style="font-weight: 700;">5h</td>
                <td class="precio">10€</td>
                <td class="precio">15€</td>
                <td class="precio">10€</td>
                <td class="precio">10€</td>
              </tr>
              <tr>
                <td style="font-weight: 700;">12h</td>
                <td class="precio">20€</td>
                <td class="precio">30€</td>
                <td class="precio">20€</td>
                <td class="precio">20€</td>
              </tr>
              <tr>
                <td style="font-weight: 700;">24h</td>
                <td class="precio">40€</td>
                <td class="precio">60€</td>
                <td class="precio">40€</td>
                <td class="precio">40€</td>
              </tr>
            </tbody>
          </table>



        </div>
    </section>

    <br>
    <!-- Testimonios de Miembros -->
    <section>
      <h2>Testimonios</h2>

      <div class="testimonio-container">
        <?php
        $query = "SELECT testimonio.contenido, testimonio.fecha, socio.nombre, socio.usuario AS autor FROM testimonio JOIN socio ON testimonio.autor = socio.id_socio ORDER BY RAND() DESC LIMIT 3";
        $result = $conexion->query($query);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<div class='testimonio-card'>
            <div class='testimonio-info'>
            <blockquote class='testimonio-content' style='background:white';>" . '"' . $row['contenido'] . '"' . ' | ' . $row['autor'] . " | " . $row['fecha'] . "</blockquote>
            </div>
            </div>";
          }
        } else {
          echo "<p>No hay testimonios registrados.</p>";
        }
        if (isset($_SESSION["nombre"]) && $pagina_actual == "index.php" && $_SESSION["tipo"] == "socio") {
        ?>
          <div style="background:white; padding:15px; border-radius: 15px;">
            <p>Añadir un testimonio</p>
            <form action="php/testimonios/creartestimonio.php" method="post" enctype="multipart/form-data">
              <label for="contenido">Contenido:</label>
              <input type="text" name="contenido" id="contenido" placeholder="Escriba aquí">

              <label for="socio">Socio:</label>
              <select name="socio" id="socio" class="form-select" required>
                <option value="" hidden>Seleccione un socio</option>

                <?php

                $nombreactual = $_SESSION['nombre'];
                $query = "SELECT id_socio, nombre, usuario  FROM socio WHERE usuario = '$nombreactual'";
                $stmt = $conexion->prepare($query);

                // Ejecutar la consulta
                $stmt->execute();

                // Enlazar las variables para recibir los resultados
                $stmt->bind_result($id_socio, $nombre, $usuario);

                $contador = 0;

                // Procesar los resultados
                if ($stmt->fetch()) {
                  do {
                    $contador++;
                    echo "<option value='$id_socio'> $usuario </option>";
                  } while ($stmt->fetch());
                }
                ?>
              </select>

              <button class="btn btn-warning" type="submit">Añadir testimonio</button>
            <?php
            // Cerrar la declaración y la conexión
            $stmt->close();
          } else if (isset($_SESSION["nombre"]) && $pagina_actual == "index.php" && $_SESSION["tipo"] == "admin") { 
             
              } else {
              }

                ?>

                </form>
              </div>
    </section>

    <!-- Galería de Imágenes -->
    <section>
      <h2>Galería</h2>
      <div class="gallery">
        <img loading="lazy" src="https://virtualboxingym.com/wp-content/uploads/2023/09/Sin-titulo-8-1.png" alt="Entrenamiento en el club">
        <img loading="lazy" src="https://muaythaigranada.es/wp-content/uploads/2022/01/MuaythaiClasesTodosNiveles-1.jpg" alt="Competencia de kickboxing">
        <img loading="lazy" src="https://i.blogs.es/bed467/boxeo-entrenamiento/840_560.jpg" alt="Miembros entrenando">
      </div>
    </section>
    <section>
      <h2>Contacto</h2>
      <div class='lista-servicios'>

        <div class="formulario" style="background:#f8f8f8;border-radius:5px;padding:20px">
          <?php if ($mensaje_enviado): ?>
            <p>Gracias por tu mensaje, <?php echo htmlspecialchars($nombre); ?>. Nos pondremos en contacto contigo pronto.</p>
          <?php else: ?>

            <p>Si quieres más información, completa el siguuiente formulario y nos pondremos en contacto contigo próximamente</p>
            <form action="index.php" method="POST">
              <label for="nombre">Nombre:</label>
              <input type="text" id="nombre" name="nombre" required>

              <label for="email">Correo electrónico:</label>
              <input type="email" id="email" name="email" required>

              <label for="mensaje">Mensaje:</label>
              <textarea id="mensaje" name="mensaje" rows="5" required></textarea>

              <input type="submit" class="btn btn-outline-secondary" value="Enviar">
            </form>
          <?php endif; ?>
        </div>
        <div class="formulario">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12716.530302999345!2d-3.619716512841848!3d37.1733202!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71fcbe0a2e22af%3A0x33bdec6485ad91a!2sArena%20Gaming!5e0!3m2!1ses!2ses!4v1746551479161!5m2!1ses!2ses" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </section>
    <br>
    <section style="text-align:center">
      <a class="btn btn-warning" href="php/socios/register.php">¡Inscríbete ya!</a>
    </section>
    </main>
    <footer class="bg text-white text-center text-lg-start">
      <!-- Grid container -->
      <div class="container">
        <!--Grid row-->
        <div class="row">
          <!--Grid column-->
          <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
            <div class="logocontainer" style="text-align:center;">
              <img loading='lazy' src="imagenes/logo.png">
            </div>
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div id="enlaces_footer" class="col-lg-4 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase">Enlaces</h5>

            <ul class="list-unstyled mb-0">
              <li class="nav-item">
                <a href="#" class="nav-link">Inicio</a>
              </li>
              <?php if (isset($_SESSION["nombre"])) { ?>
                <li class="nav-item">
                  <a href="php/noticia/noticias.php" class="nav-link">Noticias</a>
                </li>
              <?php } ?>
              <?php if (isset($_SESSION["nombre"])) { ?>
                <li class="nav-item">
                  <a href="php/reservas/reservas.php" class="nav-link">Reservas</a>
                </li>
              <?php } ?>
              <?php if (isset($_SESSION["nombre"])) { ?>
                <li class="nav-item">
                  <a href="php/tienda/tienda.php" class="nav-link">Tienda</a>
                </li>
              <?php } ?>
              <li class="nav-item">
                <a href="php/servicio/servicios.php" class="nav-link">Servicios</a>
              </li>
              <li class="nav-item">
                <a href="php/equipos/equipos.php" class="nav-link">Equipos</a>
              </li>
              <?php if (isset($_SESSION["nombre"])) { ?>
                <li class="nav-item">
                  <a href="php/recetas/recetas.php" class="nav-link">Recetas</a>
                </li>
              <?php } ?>
              <?php if (isset($_SESSION["nombre"])) { ?>
                <li class="nav-item">
                  <a href="php/socios/socios.php" class="nav-link">Socios</a>
                </li>
              <?php } ?>
              <?php if (isset($_SESSION["nombre"])) { ?>
                <li class="nav-item">
                  <a href="php/contacto/contacto.php" class="nav-link">Contacto</a>
                </li>
              <?php } ?>
            </ul>
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div id="contacto" class="col-lg-3 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase mb-0">Contacto</h5>

            <ul class="list-unstyled">
              <li>
                <h7><strong>Dirección:</strong> Calle Don Óscar 48,<br>Maracena, España</h7>
              </li>
              <br>
              <li>
                <h7><strong>Teléfono:</strong> +34 668533704 </h7>
              </li>
            </ul>
          </div>
          <!--Grid column-->
        </div>
        <!--Grid row-->
      </div>
      <!-- Grid container -->
      <br><br>
      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2025 Copyright:
        <a class="text-white">MNZone</a>
      </div>
      <!-- Copyright -->
       
    </footer>
</body>

</html>