<?php
include '../esencial/conexion.php';

// Obtener la búsqueda desde el formulario
$busqueda = $_POST['busqueda'];

// Número máximo de socios por página
$max_socios_por_pagina = 6;

// Número de página actual (por defecto es 1)
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcular el desplazamiento para la paginación
$offset = ($pagina_actual - 1) * $max_socios_por_pagina;

// Realizar la consulta para contar el total de socios que coinciden con la búsqueda
$query_count = "SELECT COUNT(*) FROM socio WHERE (nombre LIKE '%$busqueda%' OR usuario LIKE '%$busqueda%' OR telefono LIKE '%$busqueda%') AND tipo = 'socio'";

$result_count = $conexion->query($query_count);
$total_socios = $result_count->fetch_row()[0];

// Calcular el total de páginas necesarias
$total_paginas = ceil($total_socios / $max_socios_por_pagina);

// Realizar la consulta para obtener los socios de la página actual con límite y desplazamiento
$query = "SELECT nombre, usuario, edad, telefono, foto 
          FROM socio 
          WHERE (nombre LIKE '%$busqueda%' 
                 OR usuario LIKE '%$busqueda%' 
                 OR telefono LIKE '%$busqueda%') 
          AND tipo = 'socio' 
          LIMIT $max_socios_por_pagina OFFSET $offset";
$stmt = $conexion->prepare($query);
$stmt->execute();
$stmt->bind_result($nombre, $usuario, $edad, $telefono, $foto);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miembros - Atarfe Fighting</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="../../js/header.js" defer></script>
    <link rel="icon" type="image/ico" href="../../imagenes/Logo.ico" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <?php include '../esencial/header.php' ?>
    <main>
        <h1 style="font-weight: bold;">Socios</h1>
        <section style="text-align:center">
            <a class="btn btn-warning" href="register.php">Añadir socio</a>
        </section>

        <form method="post" action="buscasocio.php">
            <label for="busqueda">Buscar socio:</label>
            <input type="text" id="busqueda" name="busqueda" placeholder="Buscar por nombre, usuario, edad, teléfono...">
            <button class="btn btn-warning" type="submit">Buscar</button>
        </form>

        <div class="socio-container">
            <?php
            while ($stmt->fetch()) {
                echo "<div class='socio-card'>";
                echo "<div class='socio-foto'><img loading='lazy' src='" . "../../imagenes/" . $foto . "' alt='Foto de " . $nombre . "'></div>";
                echo "<div class='socio-info'>";
                echo "<h3>" . $nombre . "</h3>";
                echo "<p><strong>Edad:</strong> " . $edad . "</p>";
                echo "<p><strong>Teléfono:</strong> " . $telefono . "</p>";
                echo "</div>";
                echo "</div>";
            }
            $stmt->close();
            $conexion->close();
            ?>
        </div>
        <br>

        <!-- Paginación -->
        <nav>
            <ul class="pagination justify-content-center">
                <!-- Botón "Anterior" -->
                <?php if ($pagina_actual > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?busqueda=<?= $busqueda ?>&pagina=<?= $pagina_actual - 1 ?>">Anterior</a>
                    </li>
                <?php endif; ?>

                <!-- Mostrar primera página con puntos suspensivos si es necesario -->
                <?php if ($pagina_actual > 3): ?>
                    <li class="page-item">
                        <a class="page-link" href="?busqueda=<?= $busqueda ?>&pagina=1">1</a>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>

                <!-- Páginas cercanas a la página actual -->
                <?php if ($pagina_actual > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?busqueda=<?= $busqueda ?>&pagina=<?= $pagina_actual - 1 ?>"><?= $pagina_actual - 1 ?></a>
                    </li>
                <?php endif; ?>

                <li class="page-item active">
                    <span class="page-link"><?= $pagina_actual ?></span>
                </li>

                <?php if ($pagina_actual < $total_paginas): ?>
                    <li class="page-item">
                        <a class="page-link" href="?busqueda=<?= $busqueda ?>&pagina=<?= $pagina_actual + 1 ?>"><?= $pagina_actual + 1 ?></a>
                    </li>
                <?php endif; ?>

                <!-- Mostrar última página con puntos suspensivos si es necesario -->
                <?php if ($pagina_actual < $total_paginas - 2): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?busqueda=<?= $busqueda ?>&pagina=<?= $total_paginas ?>"><?= $total_paginas ?></a>
                    </li>
                <?php endif; ?>

                <!-- Botón "Siguiente" -->
                <?php if ($pagina_actual < $total_paginas): ?>
                    <li class="page-item">
                        <a class="page-link" href="?busqueda=<?= $busqueda ?>&pagina=<?= $pagina_actual + 1 ?>">Siguiente</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </main>
</body>
<?php include '../esencial/footer.php'; ?>

</html>