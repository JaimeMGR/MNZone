<footer class="site-footer">
  <div class="site-footer-inner">
    <div class="footer-brand">
      <img loading="lazy" src="../../imagenes/logo.png" alt="MNZone E-sport Gaming">
      <p>Centro eSports &amp; Gaming</p>
      <span>Juega, reserva y compite desde una misma plataforma.</span>
    </div>

    <div class="footer-links">
      <h5>Enlaces</h5>
      <ul class="list-unstyled mb-0">
        <li><a href="../../index.php" class="nav-link">Inicio</a></li>
        <?php if (isset($_SESSION["nombre"])) { ?>
          <li><a href="../noticia/noticias.php" class="nav-link">Noticias</a></li>
          <li><a href="../reservas/reservas.php" class="nav-link">Reservas</a></li>
          <li><a href="../tienda/tienda.php" class="nav-link">Tienda</a></li>
        <?php } ?>
        <li><a href="../servicio/servicios.php" class="nav-link">Servicios</a></li>
        <li><a href="../equipos/equipos.php" class="nav-link">Equipos</a></li>
        <?php if (isset($_SESSION["nombre"])) { ?>
          <li><a href="../contadores/contadores.php" class="nav-link">Contadores</a></li>
          <li><a href="../socios/socios.php" class="nav-link">Socios</a></li>
          <li><a href="../contacto/contacto.php" class="nav-link">Contacto</a></li>
        <?php } ?>
      </ul>
    </div>

    <div class="footer-contact">
      <h5>Contacto</h5>
      <div class="footer-contact-item">
        <strong>Dirección</strong>
        <span>Calle Don Óscar 48,<br>Maracena, España</span>
      </div>
      <div class="footer-contact-item">
        <strong>Teléfono</strong>
        <a href="tel:+34668533704">+34 668 533 704</a>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="footer-bottom-inner">
      <span>© 2025 MNZone</span>
      <span>Centro eSports &amp; Gaming</span>
    </div>
  </div>
</footer>
