<?php
include '../esencial/conexion.php';

$id_socio = $_GET['id'];

// Obtén el id del usuario que está visitando la página y guardala en una variable

// Preparar la consulta con una declaración preparada
$query = "SELECT telefono, nombre, contrasena, usuario, edad, foto FROM socio WHERE id_socio = $id_socio";
$stmt = $conexion->prepare($query);

// Ejecutar la consulta
$stmt->execute();

// Enlazar las variables para recibir los resultados
$stmt->bind_result($telefono, $nombre, $contrasena, $usuario, $edad, $imagen);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miembros - Atarfe Fighting</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="../../js/modificarsocio.js" defer></script>
    <script src="../../js/header.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include '../esencial/header.php';

    ?>
    <main>
        <h1 style="font-weight: bold; text-align:center">Modificar datos del usuario</h1>
        <?php if ($stmt->fetch()) {
            if (isset($_SESSION["nombre"]) && $pagina_actual == "modificarsocio.php" && isset($_SESSION["tipo"]) == "admin") {
                do {
                    // Procesar los resultados

                    echo "<div class='socio-card-modificar'>";
                    echo "<div class='socio-foto'><img loading='lazy' src='" . "../../imagenes/" . $imagen . "' alt='Imagen de " . $nombre . "'></div>";
                    echo "<div class='socio-info'>";
                    echo "<h4 class='text-md-center'>" . $nombre . "</h4>";
                    echo "<h3 class='text-md-center'> " . $usuario . "</h3>";
                    echo "<h3 class='text-md-center'>Edad: " . $edad . "</h3>";
                    echo "<h3 class='text-md-center'> " . $telefono . "</h3>";

                    echo "<hr>";

                    echo "<form action='modificar_datos_socio.php?id=$id_socio' method='post' enctype='multipart/form-data'>";
                    echo "<label  for='nombre'>Nombre</label> ";
                    echo "<input type='hidden' id='id_socio' name='id_socio' value='" . $id_socio . "'>";
                    echo "<input type='text' id='nombre' name='nombre' placeholder='$nombre'>";
                    echo "<label  for='usuario'>Usuario</label> ";
                    echo "<input type='text' id='usuario' name='usuario' placeholder='$usuario'>";
                    echo "<label for='edad' >Edad</label>";
                    echo "<input type='number' id='edad' name='edad' placeholder='$edad'>";
                    echo "<label  for='telefono'>Teléfono</label> ";
                    echo "<input type='text' id='telefono' name='telefono' placeholder='$telefono'>";
                    echo "<label  for='imagen'>Contraseña</label> ";
                    echo "<input type='password' id='contraseña' name='contraseña'>";
                    echo "<label  for='imagen'>imagen</label> ";
                    echo "<input type='file' id='imagen' name='imagen'>";
                    echo "<hr>";
                    echo "<button class='btn btn-warning' type='submit'>Modificar</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                } while ($stmt->fetch());
            } else if (isset($_SESSION["nombre"]) && $pagina_actual == "modificarsocio.php" && $_SESSION["tipo"] == "socio" && $_SESSION["nombre"] == $usuario) {
                do {
                    // Procesar los resultados

                    echo "<div class='socio-card-modificar'>";
                    echo "<div class='socio-foto'><img loading='lazy' src='" . "../../imagenes/" . $imagen . "' alt='Imagen de " . $nombre . "'></div>";
                    echo "<div class='socio-info'>";
                    echo "<h4 class='text-md-center'>" . $nombre . "</h4>";
                    echo "<h3 class='text-md-center'> " . $usuario . "</h3>";
                    echo "<h3 class='text-md-center'>Edad: " . $edad . "</h3>";
                    echo "<h3 class='text-md-center'> " . $telefono . "</h3>";

                    echo "<hr>";

                    echo "<form action='modificar_datos_socio.php?id=$id_socio' method='post' enctype='multipart/form-data'>";
                    echo "<label  for='nombre'>Nombre</label> ";
                    echo "<input type='hidden' id='id_socio' name='id_socio' value='" . $id_socio . "'>";
                    echo "<input type='text' id='nombre' name='nombre' placeholder='$nombre'>";
                    echo "<label  for='usuario'>Usuario</label> ";
                    echo "<input type='text' id='usuario' name='usuario' placeholder='$usuario'>";
                    echo "<label for='edad' >Edad</label>";
                    echo "<input type='number' id='edad' name='edad' placeholder='$edad'>";
                    echo "<label  for='telefono'>Teléfono</label> ";
                    echo "<input type='text' id='telefono' name='telefono' placeholder='$telefono'>";
                    echo "<label  for='imagen'>Contraseña</label> ";
                    echo "<input type='password' id='contraseña' name='contraseña'>";
                    echo "<label  for='imagen'>imagen</label> ";
                    echo "<input type='file' id='imagen' name='imagen'>";
                    echo "<hr>";
                    echo "<button class='btn btn-warning' type='submit'>Modificar</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                } while ($stmt->fetch());
            } else {
                header("Location:../../index.php");
            }
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