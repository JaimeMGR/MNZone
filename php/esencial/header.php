<?php
session_start();
if (isset($_GET["error"])) {
  $error = $_GET['error'];
} else {
  $error = 0;
}
?>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark container">
      <a class="navbar-brand" href="../../index.php">
        <img loading='lazy' class="logo" src="../../imagenes/Logo.png" alt="Logo MNZone">
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
      <form class='login-form' action='../../iniciar_sesion.php' method='POST'>
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

<nav id="enlaces" class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid" style="justify-content: center;">
    <button class="navbar-toggler" id="abrirmenu" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav" aria-controls="menuNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menuNav" style="text-align:center">
      <!-- Haz unbotón para cerrar el menú -->
      <button class="btn btn-danger navbar-toggler" id="Cerrarmenu" type="button">Cerrar menú</button>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="../../index.php" class="nav-link">Inicio</a>
        </li>
        <?php if (isset($_SESSION["nombre"])) { ?>
        <li class="nav-item">
          <a href="../noticia/noticias.php" class="nav-link">Noticias</a>
        </li>
        <?php } ?>
        <?php if (isset($_SESSION["nombre"])) { ?>
          <li class="nav-item">
            <a href="../reservas/reservas.php" class="nav-link">Reservas</a>
          </li>
        <?php } ?>
        <?php if (isset($_SESSION["nombre"])) { ?>
        <li class="nav-item">
          <a href="../tienda/tienda.php" class="nav-link">Tienda</a>
        </li>
        <?php } ?>
        <li class="nav-item">
          <a href="../servicio/servicios.php" class="nav-link">Servicios</a>
        </li>
        <li class="nav-item">
          <a href="../equipos/equipos.php" class="nav-link">Equipos</a>
        </li>
        <?php if (isset($_SESSION["nombre"])) { ?>
        <li class="nav-item">
          <a href="../contadores/contadores.php" class="nav-link">Contadores</a>
        </li>
        <?php } ?>
        <?php if (isset($_SESSION["nombre"])) { ?>
          <li class="nav-item">
            <a href="../socios/socios.php" class="nav-link"><?php if (isset($_SESSION["nombre"]) && $_SESSION["tipo"] == "socio") { 
              echo "Mi perfil";
            } else{
              echo "Socios";
            }
            ?></a>
          </li>
        <?php } ?>
        <?php if (isset($_SESSION["nombre"])) { ?>
        <li class="nav-item">
          <a href="../contacto/contacto.php" class="nav-link">Contacto</a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>