<?php
include '../esencial/conexion.php';

// codigo para haceer funcionar el formulario de búsqueda de usuario sin utilizar bind_param

if (isset($_POST['busqueda'])) {
    $busqueda = $_POST['busqueda'];
    $query = "SELECT codigo_servicio, descripcion, precio, duracion, imagen FROM servicio WHERE descripcion LIKE '%$busqueda%'";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $stmt->bind_result($codigo_servicio, $descripcion, $precio, $duracion, $imagen);
} else {
    header("Location:servicios.php");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - Atarfe Fighting</title>
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
        <h2 style="font-weight: bold;">Servicios</h2>
        <?php
        if (isset($_SESSION["nombre"]) && $pagina_actual == "buscarservicio.php" && $_SESSION["tipo"] == "admin") {
        ?>
            <section style="text-align:center">
                <a class="btn btn-warning" href="añadirservicio.php">Añadir servicios</a>
            </section>
        <?php
        }
        ?>

        <form method="post" action="buscarservicio.php">
            <label for="busqueda">Buscar servicio:</label>
            <input type="text" id="busqueda" name="busqueda" placeholder="Buscar por nombre...">
            <button class="btn btn-warning" type="button|submit">Buscar</button>
        </form>

        <div class="socio-container">
            <?php

            while ($stmt->fetch()) {
                echo "<div class='servicio-item'>
                    <div class='servicio-image'><img loading='lazy' src='" . $imagen . "' alt='" . $descripcion . "'></div>
                    
                    <div class='btn btn-danger' style='width:60%;'>
                    
                    <h3 class='servicio-title'><br><br>" . $descripcion . "</h3>
                    <p style='color:white'> Precio: " . $precio . "€</p>
                    <p style='color:white'> Duración: " . $duracion . " minutos</p>";
                if (isset($_SESSION["nombre"]) && $pagina_actual == "index.php" && $_SESSION["tipo"] == "admin") { ?>
                    <a href='modificarservicio.php?id=$codigo_servicio' type='button' class='btn btn-success'>Modificar datos</a>
            <?php
                }

                echo "</div>
                    </div>";
            }

            $stmt->close();
            $conexion->close();
            ?>

        </div>
    </main>
</body>
<?php include '../esencial/footer.php';
exit();
?>

</html>