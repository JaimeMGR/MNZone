<?php
include '../esencial/conexion.php';

if (isset($_SESSION["nombre"]) && $pagina_actual == "modificarservicio.php" && $_SESSION["tipo"] == "admin") {

$id_socio = $_GET['id'];

// Preparar la consulta con una declaración preparada
$query = "SELECT codigo_servicio, descripcion, precio, duracion, imagen FROM servicio WHERE codigo_servicio = $id_socio";
$stmt = $conexion->prepare($query);

// Ejecutar la consulta
$stmt->execute();

// Enlazar las variables para recibir los resultados
$stmt->bind_result($codigo_servicio, $descripcion, $precio, $duracion, $imagen);

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
        <h1>Modificar datos del servicio</h1>
        <?php if ($stmt->fetch()) {
            do {

                // Procesar los resultados

                echo "<div class='socio-card-modificar'>
                <br>
                <div class='socio-foto'><img loading='lazy' src='"  . $imagen . "' alt='Imagen de " . $descripcion . "'></div>
                <div class='socio-info'>
                <h4 class='text-md-center'>" . $descripcion . "</h4>
                <h3 class='text-md-center'>Precio: " . $precio . "€</h3>
                <h3 class='text-md-center'>Duración: " . $duracion .  " minutos</h3>

                <hr>

                <form action='modificar_datos_servicio.php?id=$id_socio' method='post' enctype='multipart/form-data'>
                <label  for='descripcion'>Nombre</label> 
                <input type='hidden' id='id_socio' name='id_socio' value='". $id_socio. "'>
                <input type='text' id='descripcion' name='descripcion' placeholder='$descripcion'>
                <label  for='Precio'>Precio</label> 
                <input type='text' id='Precio' name='Precio' placeholder='$precio'>
                <label for='duracion' >Duracion</label>
                <input type='number' id='duracion' name='duracion' placeholder='$duracion'>
                <label  for='imagen'>imagen</label> 
                <input type='file' id='imagen' name='imagen'>
                <hr>
                <button class='btn btn-warning' type='submit'>Modificar</button>
                </form>
                </div>
                </div>";
                
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
<?php
}else{
    header("Location:servicios.php");
}