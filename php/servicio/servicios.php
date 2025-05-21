<?php
include '../esencial/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - Atarfe Fighting</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="icon" type="image/ico" href="../../imagenes/Logo.ico" />
    <script src="js/app.js" defer></script>
    <script src="../../js/header.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</head>

<body>
    <?php include '../esencial/header.php' ?>
    <main>
        <h1>Servicios</h1>
        <?php
        if (isset($_SESSION["nombre"]) && $pagina_actual == "servicios.php" && $_SESSION["tipo"] == "admin") {
        ?>
            <section style="text-align:center">
                <a class="btn btn-warning" href="añadirservicio.php">Añadir servicio</a>
            </section>
        <?php
        }
        ?>
        <form class="formbuscar" method="post" action="buscarservicio.php">
            <label for="busqueda">Buscar servicio:</label>
            <input class="form-control" type="text" id="busqueda" name="busqueda" placeholder="Buscar por nombre...">
            <button class="btn btn-warning" type="button|submit">Buscar</button>
        </form>
        <br>
        <?php
        // Preparar la consulta con una declaración preparada
        $query = "SELECT codigo_servicio, nombre, descripcion, imagen FROM servicio";
        $stmt = $conexion->prepare($query);

        // Ejecutar la consulta
        $stmt->execute();

        // Enlazar las variables para recibir los resultados
        $stmt->bind_result($codigo_servicio, $nombre, $descripcion, $imagen);

        $contador = 0;
        // Procesar los resultados
        if ($stmt->fetch()) {
            echo "<div class='lista-servicios'>";
            do {
                $contador++;
        ?>
                <!-- Tu contenido de tarjeta o "accordion" -->
                <div class="accordion" id="accordion<?php echo $contador ?>">
                    <div class="header_servicio">
                        <h2 class='servicio-title' style="text-transform:uppercase;"><?php echo $nombre ?></h2>
                    </div>
                    <div style="background:#ffffff; margin-left:10%;width:80%" class="accordion-collapse" aria-labelledby="heading<?php echo $contador ?>" data-bs-parent="#accordionExample">
                        <div class="accordion-body" style="width:95%;justify-self:center;">
                            <div class='servicio-image' style="width:100%;"><img loading='lazy' style="width:100%;height:300px" src="<?php echo $imagen ?>" alt='<?php echo $nombre ?>'></div>
                            <div class='servicio-content' style="text-align:center;width:auto">
                                <h6 class='text-md-center'><?php echo $descripcion ?></h6>
                                <?php if (isset($_SESSION["nombre"]) && $pagina_actual == "servicios.php" && $_SESSION["tipo"] == "admin") { ?>
                                    <a style='color:black; width:60%;margin-left: 20%;margin-right:20%' href='modificarservicio.php?id=<?php echo $codigo_servicio ?>' type='button' class='btn btn-outline-success'>Modificar datos</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            } while ($stmt->fetch());
            echo "</div>"; // cierre del grid-container
        } else {
            echo "<p>No hay noticias disponibles.</p>";
        }


        // Cerrar la declaración y la conexión
        $stmt->close();
        $conexion->close();
        ?>

    </main>
    <?php include '../esencial/footer.php' ?>
</body>

</html>