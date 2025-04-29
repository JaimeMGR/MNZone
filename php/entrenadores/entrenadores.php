<?php
include '../esencial/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miembros - MNZone</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="js/app.js" defer></script>
    <script src="../../js/header.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include '../esencial/header.php' ?>
    <main>
        <h2 style="font-weight: bold;">Entrenadores</h2>
        <p>En MNZone Club, contamos con un equipo de entrenadores altamente capacitados y dedicados a ayudarte a alcanzar tus metas deportivas. Cada uno de ellos aporta su experiencia y pasión por las artes marciales y el entrenamiento físico, ofreciendo una guía personalizada para todos nuestros socios, sin importar su nivel o categoría. Aquí podrás conocer a nuestros entrenadores, las categorías que lideran y un poco más sobre su rol en el club. ¡Estamos aquí para apoyarte en tu camino hacia el éxito y el crecimiento personal!</p>

        <div class="entrenador-container">
            <?php
            // Preparar la consulta con una declaración preparada
            $query = "SELECT nombre, categorias, foto FROM entrenadores";
            $stmt = $conexion->prepare($query);

            // Ejecutar la consulta
            $stmt->execute();

            // Enlazar las variables para recibir los resultados
            $stmt->bind_result($nombre, $categorias, $foto);

            // Procesar los resultados
            if ($stmt->fetch()) {
                do {
                    echo "<div class='entrenador-card'>";
                    echo "<div class='entrenador-foto'><img src='" . "../../imagenes/".$foto . "' alt='Foto de " . $nombre . "'></div>";
                    echo "<div class='entrenador-info'>";
                    echo "<h3>" . $nombre . "</h3>";
                    echo "<p><strong>Especializado en:</strong> " . $categorias . "</p>";
                    echo "</div>";
                    echo "</div>";
                } while ($stmt->fetch());
            } else {
                echo "<p>No hay socios registrados.</p>";
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