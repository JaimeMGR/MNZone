<?php
include '../esencial/conexion.php';
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getsocios'])) {
  include 'php\esencial\conexion.php';

  $query = "SELECT c.fecha, c.hora, s.nombre as socio, v.nombre as servicio 
              FROM reserva c
              JOIN socio s ON c.codigo_socio = s.id_socio
              JOIN servicio v ON c.codigo_servicio = v.codigo_servicio";

  $result = $conexion->query($query);

  $reservas = [];
  while ($row = $result->fetch_assoc()) {
    $reservas[] = $row;
  }

  header('Content-Type: application/json');
  echo json_encode($reservas);
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MNZone - Reservas</title>
  <link rel="stylesheet" href="../../css/styles.css">
  <script src="../../js/header.js" defer></script>
  <link rel="icon" type="image/ico" href="../../imagenes/Logo.ico" />
  <script src="../../js/crearreserva.js" defer></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php include '../esencial/header.php' ?>
  <main>
    <h1>Reservas</h1>

    <?php
    if (isset($_SESSION["nombre"]) && $pagina_actual == "reservas.php" && $_SESSION["tipo"] == "admin" && $_SESSION["nombre"] == "Admin") {
    ?>
      <form class="formbuscar" method="post" action="buscarcita.php">
        <label for="busqueda">
          <p>Buscar reserva:</p>
        </label>
        <div class="input-group">
          <input class="form-control" type="text" id="busqueda" name="busqueda" placeholder="Buscar por nombre, servicio o fecha..." required>
          <button class="btn btn-warning" type="button|submit">Buscar</button>
        </div>

      </form>

      <!-- Contenemos la estructura en un flex de dos columnas -->
      <div class="contenedor-reservas-calendario" style="margin-top: 100px; ">
        <div style="width:49%;" id="formulario">
          <h2 style="font-weight: bold;">Haz tu reserva</h2>
          <form action="crearreserva.php" style="background:white;border-radius:25px; padding:25px" method="post">
            <label for="socio">Socio:</label>
            <select name="socio" id="socio" class="form-select" required>
              <option value="" hidden>Seleccione un socio</option>
              <?php

              if (isset($_SESSION["nombre"]) && $pagina_actual == "reservas.php" && $_SESSION["tipo"] == "admin") {
                // Preparar la consulta con una declaración preparada
                $querysocios = "SELECT id_socio, nombre  FROM socio";
                $stmt = $conexion->prepare($querysocios);

                // Ejecutar la consulta
                $stmt->execute();

                // Enlazar las variables para recibir los resultados
                $stmt->bind_result($id_socio, $nombre);

                $contador = 0;

                // Procesar los resultados

                if ($stmt->fetch()) {
                  do {
                    $contador++;
                    echo "<option value='$id_socio'> $nombre </option>";
                  } while ($stmt->fetch());
                }
                // Cerrar la declaración y la conexión
                $stmt->close();
              }
              ?>
            </select>
            <label for="servicio">Servicio:</label>
            <select name="servicio" id="servicio" class="form-select" required>
              <option value="" hidden>Seleccione un servicio</option>
              <?php
              // Preparar la consulta con una declaración preparada
              $queryservicio = "SELECT codigo_servicio, nombre FROM servicio";
              $stmt = $conexion->prepare($queryservicio);

              // Ejecutar la consulta
              $stmt->execute();

              // Enlazar las variables para recibir los resultados
              $stmt->bind_result($codigo_servicio, $nombre);

              $contador = 0;

              // Procesar los resultados
              if ($stmt->fetch()) {
                do {
                  $contador++;
                  echo "<option value='$codigo_servicio'> $nombre </option>";
                } while ($stmt->fetch());
              }
              // Cerrar la declaración y la conexión
              $stmt->close();
              $conexion->close();
              ?>
            </select>
            <label for="fecha">Fecha:</label>
            <input type="date" class="form-control" name="fecha" id="fecha" required>
            <label for="horario">Hora de llegada:</label>
            <input type="time" name="hora" class="form-control" required>

            <input type="submit" class="btn btn-outline-secondary" value="Apuntarse">
          </form>
        </div>
        <div style="width:2%"></div>
        <div style="width:49%" id="boton">
          <?php include '../esencial/calendario.php'; ?>
        </div>


      </div>

    <?php

    } else if (isset($_SESSION["nombre"]) && $pagina_actual == "reservas.php" && $_SESSION["tipo"] == "socio") {
    ?>
      <form class="formbuscar" method="post" action="buscarcita.php">
        <label for="busqueda">
          <p>Buscar reserva:</p>
        </label>
        <div class="input-group">
          <input class="form-control" type="text" id="busqueda" name="busqueda" placeholder="Buscar por nombre, servicio o fecha..." required>
          <button class="btn btn-warning" type="button|submit">Buscar</button>
        </div>

      </form>
      <div class="contenedor-reservas-calendario" style="background:white;border-radius:25px;margin-top: 100px; ">
        <div style="width:49%" id="formulario">
          <h2 style="font-weight: bold;">Haz tu reserva</h2>
          <form action="crearreserva.php" style="background:white;border-radius:25px; padding:25px" method="post">
            <label for="Socio">Socio:</label>
            <select name="socio" id="socio" class="form-select" required>
              <option value="" hidden>Seleccione un socio</option>
              <?php
              // Obtener el ID del usuario actual desde la sesión
              $usuario_actual = $_SESSION["nombre"]; // Asegúrate de que el ID del usuario esté almacenado en la sesión

              // Preparar la consulta con una declaración preparada para obtener solo el usuario actual
              $querysocios = "SELECT id_socio, nombre, usuario FROM socio WHERE usuario = ?";
              $stmt = $conexion->prepare($querysocios);

              // Vincular el parámetro (ID del usuario actual)
              $stmt->bind_param("s", $usuario_actual);

              // Ejecutar la consulta
              $stmt->execute();

              // Enlazar las variables para recibir los resultados
              $stmt->bind_result($id_socio, $nombre, $usuario);

              // Procesar los resultados
              if ($stmt->fetch()) {
                echo "<option value='$id_socio'> $nombre </option>";
              }

              // Cerrar la declaración
              $stmt->close();
              ?>
            </select>
            <label for="servicio">Servicio:</label>
            <select name="servicio" id="servicio" class="form-select" required>
              <option value="" hidden>Seleccione un servicio</option>
              <?php
              // Preparar la consulta con una declaración preparada
              $queryservicio = "SELECT codigo_servicio, nombre FROM servicio";
              $stmt = $conexion->prepare($queryservicio);

              // Ejecutar la consulta
              $stmt->execute();

              // Enlazar las variables para recibir los resultados
              $stmt->bind_result($codigo_servicio, $nombre);

              $contador = 0;

              // Procesar los resultados
              if ($stmt->fetch()) {
                do {
                  $contador++;
                  echo "<option value='$codigo_servicio'> $nombre </option>";
                } while ($stmt->fetch());
              }
              // Cerrar la declaración y la conexión
              $stmt->close();
              $conexion->close();
              ?>
            </select>
            <label for="fecha">Fecha:</label>
            <input type="date" class="form-control" name="fecha" id="fecha" required>
            <label for="horario">Hora de llegada:</label>
            <input type="time" name="hora" class="form-control" required>


            <input type="submit" class="btn btn-outline-secondary" value="Apuntarse">
          </form>
        </div>
        <div style="width:2%"></div>
        <div style="width:49%" id="boton">
          <?php include '../esencial/calendario.php'; ?>
        </div>


      </div>
    <?php
    } else {
      header("Refresh: 0.01; url=../../index.php");
    }
    ?>



  </main>
  <?php include '../esencial/footer.php' ?>
</body>

</html>