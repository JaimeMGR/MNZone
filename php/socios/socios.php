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
        <h1><?php if (isset($_SESSION["nombre"]) && $pagina_actual == "socios.php" && $_SESSION["tipo"] == "socio") { echo "Mi perfil";}else{ echo "Socios"; } ?></h1>
        <section style="text-align:center">
            <?php
            if (isset($_SESSION["nombre"]) && $pagina_actual == "socios.php" && $_SESSION["tipo"] == "socio") {
            ?>
                <div class="socio-container">
                    <?php
                    $nombre_usuario = $_SESSION["nombre"];
                    // Número máximo de resultados por página
                    $resultados_por_pagina = 6;

                    // Determinar la página actual
                    $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                    if ($pagina_actual < 1) $pagina_actual = 1;

                    // Calcular el OFFSET para la consulta
                    $offset = ($pagina_actual - 1) * $resultados_por_pagina;

                    // Obtener el número total de socios
                    $query_total = "SELECT COUNT(*) FROM socio";
                    $stmt_total = $conexion->prepare($query_total);
                    $stmt_total->execute();
                    $stmt_total->bind_result($total_socios);
                    $stmt_total->fetch();
                    $stmt_total->close();

                    // Calcular el número total de páginas
                    $total_paginas = ceil($total_socios / $resultados_por_pagina);

                    // Preparar la consulta con LIMIT y OFFSET
                    $query = "SELECT id_socio, usuario, nombre, edad, telefono, foto FROM socio where usuario = ?";
                    $stmt = $conexion->prepare($query);
                    $stmt->bind_param("s", $nombre_usuario);

                    // Ejecutar la consulta
                    $stmt->execute();
                    $stmt->bind_result($id_socio, $usuario, $nombre, $edad, $telefono, $foto);

                    // Procesar los resultados
                    if ($stmt->fetch()) {
                        do {
                            echo "<div class='socio-card'>";
                            echo "<div class='socio-foto'><img loading='lazy' src='" . "../../imagenes/" . $foto . "' alt='Foto de " . $nombre . "'></div>";
                            echo "<div class='socio-info'>";
                            echo "<h3>" . $nombre . "</h3>";
                            echo "<p><strong>Usuario:</strong> " . $usuario . "</p>";
                            echo "<p><strong>Edad:</strong> " . $edad . "</p>";
                            echo "<p><strong>teléfono:</strong> " . $telefono . "</p>";
                            echo "<a href='modificarsocio.php?id=$id_socio' type='button' class='btn btn-outline-success'>Modificar datos</a>";
                            echo "</div>";
                            echo "</div>";
                        } while ($stmt->fetch());
                    } else {
                        echo "<p>No hay socios registrados.</p>";
                    }

                    // Cerrar la declaración
                    $stmt->close();
                    $conexion->close();
                    ?>
                </div>
                <br>
            <?php
            } else if (isset($_SESSION["nombre"]) && $pagina_actual == "socios.php" && $_SESSION["tipo"] == "admin") {
            ?>
            <a class="btn btn-warning" href="register.php">Añadir socio</a>
        </section>
        <form class="formbuscar" method="post" action="buscasocio.php">
            <label for="busqueda">Buscar socio:</label>
            <input class="form-control" type="text" id="busqueda" name="busqueda" placeholder="Buscar por nombre, usuario, edad, teléfono...">
            <button class="btn btn-warning" type="button|submit">Buscar</button>
        </form>
        <div class="socio-container">
            <?php
            // Número máximo de resultados por página
            $resultados_por_pagina = 6;

            // Determinar la página actual
            $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            if ($pagina_actual < 1) $pagina_actual = 1;

            // Calcular el OFFSET para la consulta
            $offset = ($pagina_actual - 1) * $resultados_por_pagina;

            // Obtener el número total de socios
            $query_total = "SELECT COUNT(*) FROM socio";
            $stmt_total = $conexion->prepare($query_total);
            $stmt_total->execute();
            $stmt_total->bind_result($total_socios);
            $stmt_total->fetch();
            $stmt_total->close();

            // Calcular el número total de páginas
            $total_paginas = ceil($total_socios / $resultados_por_pagina);

            // Preparar la consulta con LIMIT y OFFSET
            $query = "SELECT id_socio, usuario, nombre, edad, telefono, foto, tipo FROM socio WHERE tipo = 'socio' LIMIT ? OFFSET ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("ii", $resultados_por_pagina, $offset);

            // Ejecutar la consulta
            $stmt->execute();
            $stmt->bind_result($id_socio, $usuario, $nombre, $edad, $telefono, $foto, $tipo);

            // Procesar los resultados
            if ($stmt->fetch()) {
                do {
                    echo "<div class='socio-card'>";
                    echo "<div class='socio-foto'><img loading='lazy' src='" . "../../imagenes/" . $foto . "' alt='Foto de " . $nombre . "'></div>";
                    echo "<div class='socio-info'>";
                    echo "<h3>" . $nombre . "</h3>";
                    echo "<p><strong>Usuario:</strong> " . $usuario . "</p>";
                    echo "<p><strong>Edad:</strong> " . $edad . "</p>";
                    echo "<p><strong>teléfono:</strong> " . $telefono . "</p>";
                    echo "<a href='modificarsocio.php?id=$id_socio' type='button' class='btn btn-outline-success'>Modificar datos</a>";
                    echo "</div>";
                    echo "</div>";
                } while ($stmt->fetch());
            } else {
                echo "<p>No hay socios registrados.</p>";
            }

            // Cerrar la declaración
            $stmt->close();
            $conexion->close();
            ?>
        </div>
        <br>

        <!-- Paginación -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php
                // Botón "Anterior"
                if ($pagina_actual > 1): ?>
                    <li class="page-item">
                        <a class="btn btn-warning" href="?pagina=<?= $pagina_actual - 1 ?>">Anterior</a>
                    </li>
                <?php endif; ?>

                <?php
                // Mostrar siempre la primera página
                if ($pagina_actual > 3): ?>
                    <li class="page-item">
                        <a class="btn btn-warning" href="?pagina=1">1</a>
                    </li>
                    <li class="page-item disabled">
                        <span class="btn btn-warning">...</span>
                    </li>
                <?php endif; ?>

                <?php
                // Mostrar la página anterior al actual, si existe
                if ($pagina_actual > 1): ?>
                    <li class="page-item">
                        <a class="btn btn-warning" href="?pagina=<?= $pagina_actual - 1 ?>"><?= $pagina_actual - 1 ?></a>
                    </li>
                <?php endif; ?>

                <?php
                // Mostrar la página actual
                ?>
                <li class="page-item active">
                    <span class="btn btn-danger"><?= $pagina_actual ?></span>
                </li>

                <?php
                // Mostrar la página posterior al actual, si existe
                if ($pagina_actual < $total_paginas): ?>
                    <li class="page-item">
                        <a class="btn btn-warning" href="?pagina=<?= $pagina_actual + 1 ?>"><?= $pagina_actual + 1 ?></a>
                    </li>
                <?php endif; ?>

                <?php
                // Mostrar siempre la última página con puntos suspensivos
                if ($pagina_actual < $total_paginas - 2): ?>
                    <li class="page-item disabled">
                        <span class="btn btn-warning">...</span>
                    </li>
                    <li class="page-item">
                        <a class="btn btn-warning" href="?pagina=<?= $total_paginas ?>"><?= $total_paginas ?></a>
                    </li>
                <?php endif; ?>

                <?php
                // Botón "Siguiente"
                if ($pagina_actual < $total_paginas): ?>
                    <li class="page-item">
                        <a class="btn btn-warning" href="?pagina=<?= $pagina_actual + 1 ?>">Siguiente</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
            <?php
            } else{
                header("Location:../../index.php" );
            }
            ?>
    </main>
    <?php include '../esencial/footer.php' ?>
</body>

</html>