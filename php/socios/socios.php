<?php
include '../esencial/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miembros - Atarfe Fighting</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="js/app.js" defer></script>
    <link rel="icon" type="image/ico" href="../../imagenes/Logo.ico" />
    <script src="../../js/header.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include '../esencial/header.php' ?>
    <main>
        <?php if (isset($_SESSION["nombre"]) && $pagina_actual == "socios.php" && $_SESSION["tipo"] == "socio") {

            ?><div class="socio-container"><?php
            $nombre_usuario = $_SESSION["nombre"];
            $query = "SELECT id_socio, usuario, nombre, edad, telefono, foto FROM socio WHERE usuario = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("s", $nombre_usuario);
            $stmt->execute();
            $stmt->bind_result($id_socio, $usuario, $nombre, $edad, $telefono, $foto);

            $socio_data = [];
            if ($stmt->fetch()) {
                $socio_data = compact('id_socio', 'usuario', 'nombre', 'edad', 'telefono', 'foto');
            }
            $stmt->close();

            if (!empty($socio_data)) {
                echo "<div class='socio-card'>";
                echo "<div class='socio-foto'><img loading='lazy' src='../../imagenes/{$socio_data['foto']}' alt='Foto de {$socio_data['nombre']}'></div>";
                echo "<div class='socio-info'>";
                echo "<h3>{$socio_data['nombre']}</h3>";
                echo "<p><strong>Usuario:</strong> {$socio_data['usuario']}</p>";
                echo "<p><strong>Edad:</strong> {$socio_data['edad']}</p>";
                echo "<p><strong>Teléfono:</strong> {$socio_data['telefono']}</p>";


                $query_tiempos = "SELECT categoria, tiempo_total FROM tiempos_sala WHERE id_socio = ?";
                $stmt_tiempos = $conexion->prepare($query_tiempos);
                $stmt_tiempos->bind_param("i", $socio_data['id_socio']);
                $stmt_tiempos->execute();
                $stmt_tiempos->bind_result($categoria, $tiempo_total);

                echo "<div class='socio-contadores'>";

                echo "<table class='table table-bordered' style='max-width: 600px; margin: 0 auto'>";

                echo "</div></div>";
                $hay_datos = false;
                while ($stmt_tiempos->fetch()) {
                    $hay_datos = true;
                    $horas = floor($tiempo_total / 3600);
                    $minutos = floor(($tiempo_total % 3600) / 60);
                    $tiempo_formateado = "{$horas}h {$minutos}min";
                    echo "<p><strong>" . htmlspecialchars(str_replace("_", " ", $categoria)) . ": </strong>$tiempo_formateado</p>";
                }
                echo "<a href='modificarsocio.php?id={$socio_data['id_socio']}' type='button' class='btn btn-outline-success'>Modificar datos</a>";
                if (!$hay_datos) {
                    echo "<tr><td colspan='2'>No hay tiempos registrados.</td></tr>";
                }

                echo "</tbody></table></div>";
                $stmt_tiempos->close();
            } else {
                echo "<p>No se encontraron datos del usuario.</p>";
            }
            ?></div><?php
        } else if (isset($_SESSION["nombre"]) && $pagina_actual == "socios.php" && $_SESSION["tipo"] == "admin") {

    echo '<a class="btn btn-warning" href="register.php">Añadir socio</a>';
    echo '</section>';

    /* ─ Buscador ─ */
    ?>
    <form class="formbuscar" method="post" action="buscasocio.php">
        <label for="busqueda">Buscar socio:</label>
        <input class="form-control" type="text" id="busqueda" name="busqueda"
               placeholder="Buscar por nombre, usuario, edad, teléfono...">
        <button class="btn btn-warning" type="submit">Buscar</button>
    </form>
    <?php

    /* ─ Parámetros de paginación ─ */
    $resultados_por_pagina = 6;
    $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    if ($pagina_actual < 1) $pagina_actual = 1;
    $offset = ($pagina_actual - 1) * $resultados_por_pagina;

    /* ─ Total de socios ─ */
    $total_socios = $conexion->query("SELECT COUNT(*) AS total FROM socio WHERE tipo='socio'")
                             ->fetch_assoc()['total'];
    $total_paginas = ceil($total_socios / $resultados_por_pagina);

    /* ─ Obtener socios de esta página ─ */
    $query = "SELECT id_socio, usuario, nombre, edad, telefono, foto
              FROM socio
              WHERE tipo = 'socio'
              LIMIT ? OFFSET ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ii", $resultados_por_pagina, $offset);
    $stmt->execute();
    $stmt->bind_result($id_socio, $usuario, $nombre, $edad, $telefono, $foto);

    /* ─ Guardar resultados en array ─ */
    $listado_socios = [];
    while ($stmt->fetch()) {
        $listado_socios[] = compact('id_socio', 'usuario', 'nombre', 'edad', 'telefono', 'foto');
    }
    $stmt->close();   // 🔑 cerramos la consulta antes de lanzar otra

    echo '<div class="socio-container">';

    if (!$listado_socios) {
        echo '<p>No hay socios registrados.</p>';
    } else {
        /* ─ Mostrar cada socio + sus contadores ─ */
        foreach ($listado_socios as $s) {
            echo "<div class='socio-card'>";
            echo "<div class='socio-foto'>
                    <img loading='lazy' src='../../imagenes/{$s['foto']}'
                         alt='Foto de {$s['nombre']}'>
                  </div>";
            echo "<div class='socio-info'>";
            echo "<h3>".htmlspecialchars($s['nombre'])."</h3>";
            echo "<p><strong>Usuario:</strong> ".htmlspecialchars($s['usuario'])."</p>";
            echo "<p><strong>Edad:</strong> ".htmlspecialchars($s['edad'])."</p>";
            echo "<p><strong>Teléfono:</strong> ".htmlspecialchars($s['telefono'])."</p>";

            /* Botón modificar */
            echo "<a class='btn btn-outline-success'
                     href='modificarsocio.php?id={$s['id_socio']}'>
                     Modificar datos
                  </a>";

            /* ─ Contadores del socio ─ */
            $qCnt = "SELECT categoria, tiempo_total
                     FROM tiempos_sala
                     WHERE id_socio = ?";
            $stCnt = $conexion->prepare($qCnt);
            $stCnt->bind_param("i", $s['id_socio']);
            $stCnt->execute();
            $stCnt->bind_result($categoria, $tiempo_total);

            echo "<div class='socio-contadores mt-3'>";
            echo "<h5>Contadores de uso</h5>";

            $hayCnt = false;
            while ($stCnt->fetch()) {
                $hayCnt = true;
                $h = floor($tiempo_total / 3600);
                $m = floor(($tiempo_total % 3600) / 60);
                $tFmt = "{$h}h {$m}min";
                echo "<p><strong>".htmlspecialchars(str_replace('_',' ',$categoria)).":</strong> $tFmt</p>";
            }
            if (!$hayCnt) {
                echo "<p>No hay tiempos registrados.</p>";
            }
            echo "</div>";   // .socio-contadores
            $stCnt->close();

            echo "</div>";   // .socio-info
            echo "</div>";   // .socio-card
        }
    }
    echo '</div><br>';

    /* ─ Paginación (igual que antes) ─ */
    ?>
    <nav>
      <ul class="pagination justify-content-center">
        <?php if ($pagina_actual > 1): ?>
          <li class="page-item">
            <a class="btn btn-warning" href="?pagina=<?= $pagina_actual-1 ?>">Anterior</a>
          </li>
        <?php endif; ?>

        <?php if ($pagina_actual > 3): ?>
          <li class="page-item"><a class="btn btn-warning" href="?pagina=1">1</a></li>
          <li class="page-item disabled"><span class="btn btn-warning">...</span></li>
        <?php endif; ?>

        <?php if ($pagina_actual > 1): ?>
          <li class="page-item">
            <a class="btn btn-warning" href="?pagina=<?= $pagina_actual-1 ?>"><?= $pagina_actual-1 ?></a>
          </li>
        <?php endif; ?>

        <li class="page-item active">
          <span class="btn btn-danger"><?= $pagina_actual ?></span>
        </li>

        <?php if ($pagina_actual < $total_paginas): ?>
          <li class="page-item">
            <a class="btn btn-warning" href="?pagina=<?= $pagina_actual+1 ?>"><?= $pagina_actual+1 ?></a>
          </li>
        <?php endif; ?>

        <?php if ($pagina_actual < $total_paginas - 2): ?>
          <li class="page-item disabled"><span class="btn btn-warning">...</span></li>
          <li class="page-item">
            <a class="btn btn-warning" href="?pagina=<?= $total_paginas ?>"><?= $total_paginas ?></a>
          </li>
        <?php endif; ?>

        <?php if ($pagina_actual < $total_paginas): ?>
          <li class="page-item">
            <a class="btn btn-warning" href="?pagina=<?= $pagina_actual+1 ?>">Siguiente</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
<?php } else {
            header("Location:../../index.php");
        }
        ?>
    </main>
    <?php include '../esencial/footer.php' ?>
</body>

</html>