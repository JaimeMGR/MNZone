<?php
include '../esencial/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipos - MNZone</title>
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
        <h1>Nuestros equipos gamers</h1>
        <h6>En MNZone Club, contamos con un conjunto de equipos con alto rendimiento dedicados a ayudarte a alcanzar tu calidad de juego óptima. Cada uno de ellos aporta de la mejor tecnología para gaming a día de hoy, ofreciendo una experiencia gratificante para todos nuestros socios, sin importar su nivel. Aquí te sentirás como en casa.</h6>

        <div class="equipo-container">
            <?php
            // Preparar la consulta con una declaración preparada
            $query = "SELECT nombre, caracteristicas, foto FROM equipos";
            $stmt = $conexion->prepare($query);

            // Ejecutar la consulta
            $stmt->execute();

            // Enlazar las variables para recibir los resultados
            $stmt->bind_result($nombre, $caracteristicas, $foto);

            // Procesar los resultados
            if ($stmt->fetch()) {
                do {
                    echo "<div class='equipo-card'>";
                    echo "<div class='equipo-foto'><img src='" . "../../imagenes/".$foto . "' alt='Foto de " . $nombre . "'></div>";
                    echo "<div class='equipo-info'>";
                    echo "<h3>" . $nombre . "</h3>";
                    echo "<p><strong>Características:</strong><br> " . $caracteristicas . "</p>";
                    echo "</div>";
                    echo "</div>";
                } while ($stmt->fetch());
            } else {
                echo "<p>No hay equipos registrados.</p>";
            }

            // Cerrar la declaración y la conexión
            $stmt->close();
            $conexion->close();
            ?>

        </div>
    </main>
    <?php include '../esencial/footer.php' ?>

</body>

</html>