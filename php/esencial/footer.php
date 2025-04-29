<footer class="bg text-white text-center text-lg-start">
    <!-- Grid container -->
    <div class="container p-3">
        <!--Grid row-->
        <div class="row">
            <!--Grid column-->
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                <div class="logocontainer" style="text-align:center;">
                    <img loading='lazy' src="../../imagenes/logo.png">
                </div>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Enlaces</h5>

                <ul class="list-unstyled mb-0">
                    <li>
                        <a href="../../index.php" class="nav-link">Inicio</a>
                    </li>
                    <?php if (isset($_SESSION["nombre"])) { ?>
                        <li>
                            <a href="../noticia/noticias.php" class="nav-link">Noticias</a>
                        </li>
                    <?php } ?>
                    <?php if (isset($_SESSION["nombre"])) { ?>
                        <li>
                            <a href="../cita/clases.php" class="nav-link">Citas</a>
                        </li>
                    <?php } ?>
                    <?php if (isset($_SESSION["nombre"])) { ?>
                        <li>
                            <a href="../tienda/tienda.php" class="nav-link">Tienda</a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="../servicio/servicios.php" class="nav-link">Servicios</a>
                    </li>
                    <li>
                        <a href="../entrenadores/entrenadores.php" class="nav-link">Entrenadores</a>
                    </li>
                    <?php if (isset($_SESSION["nombre"])) { ?>
                        <li>
                            <a href="../recetas/recetas.php" class="nav-link">Recetas</a>
                        </li>
                    <?php } ?>
                    <?php if (isset($_SESSION["nombre"])) { ?>
                        <li>
                            <a href="../socios/socios.php" class="nav-link">Socios</a>
                        </li>
                    <?php } ?>
                    <?php if (isset($_SESSION["nombre"])) { ?>
                        <li>
                            <a href="../contacto/contacto.php" class="nav-link">Contactos</a>
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
        <a class="text-white">MNZone</a>
    </div>
    <!-- Copyright -->
</footer>