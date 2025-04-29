<?php
include '../esencial/conexion.php';

// Número máximo de noticias por página
$max_noticias_por_pagina = 3;

// Número de página actual (por defecto es 1)
// Determinar la página actual
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;

// Calcular el OFFSET para la consulta
$offset = ($pagina_actual - 1) * $max_noticias_por_pagina;

// Realizar la consulta para contar el total de noticias
$query_count = "SELECT COUNT(*) FROM noticia";
$result_count = $conexion->query($query_count);
$total_noticias = $result_count->fetch_row()[0];

// Calcular el total de páginas necesarias
$total_paginas = ceil($total_noticias / $max_noticias_por_pagina);

// Realizar la consulta para obtener las noticias de la página actual con límite y desplazamiento
$query = "SELECT id_noticia, titulo, contenido, imagen, fecha_publicacion FROM noticia ORDER BY fecha_publicacion DESC LIMIT $max_noticias_por_pagina OFFSET $offset";
$stmt = $conexion->prepare($query);
$stmt->execute();
$stmt->bind_result($id_noticia, $titulo, $contenido, $imagen, $fecha_publicacion);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias - MNZone</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="../../js/header.js" defer></script>
    <link rel="stylesheet" href="https://tailwindui.com/plus-assets/build/assets/app-V9ulzFuj.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include '../esencial/header.php';
    if (isset($_SESSION["nombre"]) && $pagina_actual == "noticias.php" && $_SESSION["tipo"] == "admin" || $_SESSION["tipo"] == "socio") {
    ?>
        <main>
            <h2 style="font-weight: bold;">Noticias</h2>
            <?php
            if (isset($_SESSION["nombre"]) && $pagina_actual == "noticias.php" && $_SESSION["tipo"] == "admin") {
            ?>
                <section style="text-align:center;">
                    <a class="btn btn-warning" href="añadirnoticia.php" class="btn">Redactar noticia</a>
                </section>
            <?php } ?>
            <br>

            <div class="noticias-container">
                <?php
                if ($stmt->fetch()) {
                    do {
                        echo "<div class='noticia-item'>";
                        echo "<div class='noticia-image' ><img loading='lazy' src='" . '../../imagenes/' . $imagen . "' alt='" . $titulo . "'></div>";
                        echo "<div class='btn' style='width:50%'>";
                        echo "<h3 class='noticia-title'>" . $titulo . "</h3>";
                        // Limitar el contenido de la noticia a 30 caracteres
                        $contenido_resumido = substr($contenido, 0, 30) . '...';
                        echo "<p style='color:white;'>" . $contenido_resumido . "</p>";
                        echo "<a style='color:white;' href='noticiaentera.php?id=$id_noticia'>Leer más...</a>";
                        echo "<br>";
                        echo "<small>Publicado el: " . $fecha_publicacion . "</small>";
                        echo "</div>";
                        echo "</div>";
                        echo "<br>";
                    } while ($stmt->fetch());
                } else {
                    echo "<p>No hay noticias disponibles.</p>";
                }
                $stmt->close();
                $conexion->close();
                ?>
            </div>

            <!-- Paginación -->
            <nav>
                <ul class="pagination justify-content-center">
                    <?php
                    $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                    if ($pagina_actual < 1) $pagina_actual = 1;
                    // Botón "Anterior"
                    if ($pagina_actual > 1): ?>
                        <li class="page-item">
                            <a class="btn btn-warning" href="?pagina=<?= $pagina_actual - 1 ?>">Anterior</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    // Mostrar siempre la primera página
                    if ($pagina_actual > 1): ?>
                        <li class="page-item">
                            <a class="btn btn-warning" href="?pagina=1">1</a>
                        </li>
                        <li class="page-item disabled">
                            <span class="">...</span>
                        </li>
                    <?php endif; ?>

                    <?php
                    // Mostrar la página anterior al actual, si existe
                    if ($pagina_actual>2): ?>
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
                            <a class="btn btn-warning" href="?pagina=<?= $pagina_actual + 1 ?>"><?=$pagina_actual + 1 ;?></a>
                        </li>
                    <?php endif; ?>

                    <?php
                    // Mostrar siempre la última página con puntos suspensivos
                    if ($pagina_actual < $total_paginas - 2): ?>
                        <li class="page-item disabled">
                            <span class="">...</span>
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
        </main>
    <?php
    } else {
        header("Refresh: 0,1; url=../../../../index.php");
    };
    include '../esencial/footer.php' ?>
</body>

</html>
<?php
