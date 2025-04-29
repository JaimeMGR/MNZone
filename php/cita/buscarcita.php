<?php
include '../esencial/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas - MNZone</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="js/app.js" defer></script>
    <script src="../../js/header.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <?php include '../esencial/header.php' ?>
    <?php
    $nombre = $_SESSION["nombre"];
    // nombre de servicio o fecha de cita
    if (isset($_SESSION["nombre"]) && $pagina_actual == "buscarcita.php" && $_SESSION["tipo"] == "admin") {
        $busqueda = $_POST['busqueda'];
        $query = "SELECT c.id_cita, s.nombre, s.telefono, ss.descripcion, c.fecha, c.hora 
FROM cita c 
INNER JOIN socio s ON c.codigo_socio = s.id_socio 
INNER JOIN servicio ss ON c.codigo_servicio = ss.codigo_servicio 
WHERE s.nombre LIKE '%$busqueda%' OR ss.descripcion LIKE '%$busqueda%' OR c.fecha LIKE '%$busqueda%' ORDER BY `c`.`id_cita` ASC";
    } else {
        $query = "SELECT c.id_cita, s.nombre, s.telefono, ss.descripcion, c.fecha, c.hora
    FROM cita c
    INNER JOIN socio s ON c.codigo_socio = s.id_socio
    INNER JOIN servicio ss ON c.codigo_servicio = ss.codigo_servicio
    WHERE s.usuario = '$nombre' ORDER BY `c`.`id_cita` ASC";
    };

    $stmt = $conexion->prepare($query);

    $stmt->execute();

    $stmt->bind_result($codigo_cita, $nombre, $telefono, $descripcion, $fecha, $hora);

    // Cerrar la conexión
    ?>
    <main>
        <h2 style="font-weight: bold;">Citas</h2>
        <?php if (isset($_SESSION["nombre"]) && $pagina_actual == "buscarcita.php" && $_SESSION["tipo"] == "admin") {
        ?>
            <form method="post" action="buscarcita.php">
                <label for="busqueda">Buscar cita:</label>
                <input type="text" id="busqueda" name="busqueda" placeholder="Buscar por nombre...">
                <button class="btn btn-warning" type="button|submit">Buscar</button>
            </form>
        <?php
        } ?>

        <div class="socio-container">
            <?php

            while ($stmt->fetch()) {
                echo "<div class='cita-item'>";
                echo "<div class='cita-content'>";
                echo "<h3 class='cita-title'>Cita # $codigo_cita </h3>";
                echo "<p class='cita-title'><strong>Servicio:</strong>  $descripcion </p>";
                echo "<p><strong>Socio:</strong>  $nombre </p>";
                echo "<p><strong>Teléfono:</strong> $telefono</p>";
                echo "<p class='cita-timetable'> Clases el día  $fecha a las $hora </p>";
                echo "</div>";
                echo "</div>";
            }

            $stmt->close();
            $conexion->close();
            ?>

        </div>
    </main>
</body>
<style>
    .cita-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
        padding: 1rem;
        background: #fff;
        border-radius: 5px;
    }

    .cita-item {
        background: #fff;
        border-radius: 5px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .cita-item:hover {
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .cita-title {
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .cita-timetable {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .cita-content {
        display: flex;
        flex-direction: column;
    }
</style>
<?php include '../esencial/footer.php';

exit();
?>

</html>