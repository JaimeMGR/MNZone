<?php
include '../esencial/conexion.php';
// En la url se encuentra la id de la noticia, necesito almacenarlo en una variable llamada $id_noticia, una url de ejemplo es la siguiente: http://localhost/atarfe%20fighting/php/noticia/noticiaentera.php?id=16 saca de ahí la id

$id_noticia = $_GET['id'];


// Preparar la consulta con una declaración preparada
$query = "SELECT id_noticia, titulo, contenido, imagen, fecha_publicacion FROM noticia WHERE id_noticia = $id_noticia ORDER BY fecha_publicacion DESC;";
$stmt = $conexion->prepare($query);

// Ejecutar la consulta
$stmt->execute();

// Enlazar las variables para recibir los resultados
$stmt->bind_result($id_noticia, $titulo, $contenido, $imagen, $fecha_publicacion);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias - MNZone</title>
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
        <?php

        // Procesar los resultados
        if ($stmt->fetch()) {
            do {
                echo " <div class='card' style='width: 100%;'>";
                echo " <img loading='lazy' src='../../imagenes/$imagen.' class='card-img-top' alt='$titulo'>";
                echo " <div class='card-body'>";
                echo " <h5 class='card-title'>$titulo</h5>";
                echo " <p class='card-text'>$contenido</p>";
                echo "<small>Publicado el: " . $fecha_publicacion . "</small>";
                echo "</div>";
                echo "</div>";
                echo "<section class='noticia-section'>";
            } while ($stmt->fetch());
        } else {
            echo "<p>No hay noticias disponibles.</p>";
        }
        ?>
        </section>
    </main>
    <?php include '../esencial/footer.php' ?>
</body>

</html>