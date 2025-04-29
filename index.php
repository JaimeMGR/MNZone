<?php
include 'php\esencial\conexion.php';
require_once "utilidades.php";


$query = "SELECT c.fecha, c.hora, s.nombre as alumno, v.descripcion as clase 
              FROM cita c
              JOIN socio s ON c.codigo_socio = s.id_socio
              JOIN servicio v ON c.codigo_servicio = v.codigo_servicio";

$result = $conexion->query($query);

$citas = [];
while ($row = $result->fetch_assoc()) {
  // Convertir la fecha y hora al formato deseado
  $formattedDate = date("d/m/Y", strtotime($row['fecha']));
  $formattedTime = date("H", strtotime($row['hora']));
  $citas[] = [
    'fecha' => $formattedDate,
    'hora' => $formattedTime,
    'alumno' => $row['alumno'],
    'clase' => $row['clase']
  ];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atarfe Fighting</title>
  <script src="js/header.js" defer></script>
  <link rel="stylesheet" href="css/styles.css">
  <script src="js/app.js" defer></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- llama a u -->
</head>

<body style="background:#f4f4f9">
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
        <img loading='lazy' class="logo" src="imagenes/Logo.png" alt="Logo Atarfe Fighting">
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
          }else{
          echo "<button type='submit'>Iniciar sesión</button>";
          }
          
      echo"</form>
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
        <button class="btn btn-danger navbar-toggler" id="Cerrarmenu" type="button">Cerrar menú</button>
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
              <a href="php/cita/clases.php" class="nav-link">Citas</a>
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
            <a href="php/entrenadores/entrenadores.php" class="nav-link">Entrenadores</a>
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
            } else{
              echo "Socios";
            }
            ?></a>
            </li>
          <?php } ?>
          <?php if (isset($_SESSION["nombre"])) { ?>
            <li class="nav-item">
              <a href="php/contacto/contacto.php" class="nav-link">Contactos</a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>


  <main>


    <!-- Sobre Nosotros -->
    <section>
      <p>Atarfe Fighting es un club dedicado al arte del combate, con un enfoque en disciplina, fuerza y técnica. Nos especializamos en entrenamientos de boxeo, Muay Thai, y otras disciplinas de combate. Únete a nosotros para mejorar tus habilidades, entrenar con profesionales y competir en torneos.</p>
    </section>
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

          echo "<div class='btn btn-danger' style='border-radius:0;width:100%'>";
          echo "    <h5>" . htmlspecialchars($titulo) . "</h5>";
          $contenido = substr($contenido, 0, 100) . '...';
          echo "    <p style='color:white'>" . htmlspecialchars($contenido) . "</p>";
          if (isset($_SESSION["nombre"])) {
            echo "<a style='color:white;' href='php/noticia/noticiaentera.php?id=$id_noticia'>Leer más...</a>";
          }
          echo " </br>";
          echo "    <small>Publicado el: " . htmlspecialchars($fecha_publicacion) . "</small>";
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

    <!-- Beneficios de Unirse -->
    <section>
      <h1>Beneficios de Unirse</h1>
      <ul>
        <li>Acceso a entrenadores certificados y con experiencia</li>
        <li>Programas de entrenamiento personalizados</li>
        <li>Ambiente inclusivo y motivador</li>
        <li>Oportunidades para competir en torneos locales y nacionales</li>
      </ul>
    </section>
    <br>
    <!-- Testimonios de Miembros -->
    <section>
      <h1>Testimonios</h1>

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
          echo "<p>No hay socios registrados.</p>";
        }
        if (isset($_SESSION["nombre"]) && $pagina_actual == "index.php" && $_SESSION["tipo"] == "socio") {
        ?>
          <h2>Añadir un testimonio</h2>
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
        } else if (isset($_SESSION["nombre"]) && $pagina_actual == "index.php" && $_SESSION["tipo"] == "admin") { ?>
            <h2>Añadir un testimonio</h2>
            <form action="php/testimonios/creartestimonio.php" method="post" enctype="multipart/form-data">
              <select name="socio" id="socio" class="form-select" required>
                <option value="" hidden>Seleccione un socio</option>

                <?php

                $query = "SELECT id_socio, nombre, usuario  FROM socio";
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
              <label for="contenido">Contenido:</label>
              <div class="input-group">
                <input type="text" name="contenido" id="contenido" placeholder="Escriba aquí">


                <button class="btn btn-warning" type="submit">Añadir testimonio</button>
              </div>
            <?php
            // Cerrar la declaración y la conexión
          } else {
          }

            ?>

            </form>

    </section>

    <!-- Galería de Imágenes -->
    <section>
      <h1>Galería</h1>
      <div class="gallery">
        <img loading="lazy" src="https://virtualboxingym.com/wp-content/uploads/2023/09/Sin-titulo-8-1.png" alt="Entrenamiento en el club">
        <img loading="lazy" src="https://muaythaigranada.es/wp-content/uploads/2022/01/MuaythaiClasesTodosNiveles-1.jpg" alt="Competencia de kickboxing">
        <img loading="lazy" src="https://i.blogs.es/bed467/boxeo-entrenamiento/840_560.jpg" alt="Miembros entrenando">
      </div>
    </section>
    <br>
    <section style="text-align:center">
      <a class="btn btn-warning" href="php/socios/register.php">¡Inscríbete ya!</a>
    </section>
  </main>
  <footer class="bg text-white text-center text-lg-start">
    <!-- Grid container -->
    <div class="container p-3">
      <!--Grid row-->
      <div class="row">
        <!--Grid column-->
        <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
          <div class="logocontainer" style="text-align:center;">
            <img loading='lazy' src="imagenes/logo.png">
          </div>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
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
                <a href="php/cita/clases.php" class="nav-link">Citas</a>
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
              <a href="php/entrenadores/entrenadores.php" class="nav-link">Entrenadores</a>
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
                <a href="php/contacto/contacto.php" class="nav-link">Contactos</a>
              </li>
            <?php } ?>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
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

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2025 Copyright:
      <a class="text-white">Atarfe Fighting</a>
    </div>
    <!-- Copyright -->
  </footer>
</body>

</html>