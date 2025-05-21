<footer class="bg text-white text-center text-lg-start">
    <!-- Grid container -->
    <div class="container">
      <!--Grid row-->
      <div class="row">
        <!--Grid column-->
        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
          <div class="logocontainer" style="text-align:center;">
            <img loading='lazy' src="../../imagenes/logo.png">
          </div>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div id="enlaces_footer" class="col-lg-4 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Enlaces</h5>

          <ul class="list-unstyled mb-0">
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
                <a href="../recetas/recetas.php" class="nav-link">Recetas</a>
              </li>
            <?php } ?>
            <?php if (isset($_SESSION["nombre"])) { ?>
              <li class="nav-item">
                <a href="../socios/socios.php" class="nav-link">Socios</a>
              </li>
            <?php } ?>
            <?php if (isset($_SESSION["nombre"])) { ?>
              <li class="nav-item">
                <a href="../contacto/contacto.php" class="nav-link">Contacto</a>
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