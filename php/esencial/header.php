<?php
if (isset($_GET["error"])) {
  $error = $_GET['error'];
} else {
  $error = 0;
}
?>
<header class="text-white">
  <nav class="navbar navbar-expand-lg navbar-dark container">
    <a class="navbar-brand" href="../../index.php">
      <img loading='lazy' class="logo" src="../../imagenes/Logo.png" alt="Logo Atarfe Fighting">
    </a>


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
  </nav>



  <?php

  if (isset($_SESSION["nombre"])) {
    echo formulario_sesion_iniciada($_SESSION["nombre"]);
  } else {
    echo formulario_para_iniciar_sesion($pagina_actual, $error);
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
            <a href="../cita/clases.php" class="nav-link">Citas</a>
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
          <a href="../entrenadores/entrenadores.php" class="nav-link">Entrenadores</a>
        </li>
        <?php if (isset($_SESSION["nombre"])) { ?>
        <li class="nav-item">
          <a href="../recetas/recetas.php" class="nav-link">Recetas</a>
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
          <a href="../contacto/contacto.php" class="nav-link">Contactos</a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>