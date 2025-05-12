<?php
include '../esencial/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas - MNZone</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="js/app.js" defer></script>
    <link rel="icon" type="image/ico" href="../../imagenes/Logo.ico" />
    <script src="../../js/header.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <?php include '../esencial/header.php' ?>
    <?php
    $nombre = $_SESSION["nombre"];
    // nombre de servicio o fecha de reserva
    if (isset($_SESSION["nombre"]) && $pagina_actual == "buscarreserva.php" && $_SESSION["tipo"] == "admin") {
        $busqueda = $_POST['busqueda'];
        $query = "SELECT c.id_reserva, s.nombre, s.telefono, ss.descripcion, c.fecha, c.hora 
FROM reservas c 
INNER JOIN socio s ON c.codigo_socio = s.id_socio 
INNER JOIN servicio ss ON c.codigo_servicio = ss.codigo_servicio 
WHERE s.nombre LIKE '%$busqueda%' OR ss.descripcion LIKE '%$busqueda%' OR c.fecha LIKE '%$busqueda%' ORDER BY `c`.`id_reserva` ASC";
    } else {
        $query = "SELECT c.id_reserva, s.nombre, s.telefono, ss.descripcion, c.fecha, c.hora
    FROM reservas c
    INNER JOIN socio s ON c.codigo_socio = s.id_socio
    INNER JOIN servicio ss ON c.codigo_servicio = ss.codigo_servicio
    WHERE s.usuario = '$nombre' ORDER BY `c`.`id_reserva` ASC";
    };

    $stmt = $conexion->prepare($query);

    $stmt->execute();

    $stmt->bind_result($codigo_reserva, $nombre, $telefono, $descripcion, $fecha, $hora);

    // Cerrar la conexión
    ?>
    <main>
        <h1 style="font-weight: bold;">Reservas</h1>
        <?php if (isset($_SESSION["nombre"]) && $pagina_actual == "buscarreserva.php" && $_SESSION["tipo"] == "admin") {
        ?>
            <form method="post" action="buscarreserva.php">
                <label for="busqueda">Buscar reserva:</label>
                <input type="text" id="busqueda" name="busqueda" placeholder="Buscar por nombre...">
                <button class="btn btn-warning" type="button|submit">Buscar</button>
            </form>
        <?php
        } ?>

        <div class="socio-container">
            <?php

            while ($stmt->fetch()) {
                echo "<div class='reserva-item'>";
                echo "<div class='reserva-content'>";
                echo "<h3 class='reserva-title'>Reserva # $codigo_reserva </h3>";
                echo "<p class='reserva-title'><strong>Servicio:</strong>  $descripcion </p>";
                echo "<p><strong>Socio:</strong>  $nombre </p>";
                echo "<p><strong>Teléfono:</strong> $telefono</p>";
                echo "<p class='reserva-timetable'> Reservas el día  $fecha a las $hora </p>";
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
    .reserva-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
        padding: 1rem;
        background: #fff;
        border-radius: 5px;
    }

    .reserva-item {
        background: #fff;
        border-radius: 5px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .reserva-item:hover {
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .reserva-title {
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .reserva-timetable {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .reserva-content {
        display: flex;
        flex-direction: column;
    }
</style>
<?php include '../esencial/footer.php';

exit();
?>

</html>