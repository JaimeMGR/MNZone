<?php
include '../esencial/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $duracion = $_POST['duracion'];
    $precio = $_POST['precio'];
    $foto = $_POST['foto'];

    // Procesar y guardar la foto
    if ($_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto = '../../imagenes/' . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
    } else {
        $foto = NULL; // Si no se sube foto, se deja como NULL
    }

    // Si ya existe una foto con ese nombre, cambiar el nombre
    if (file_exists("../../imagenes/$foto")) {
        $foto = time() . "_" . $foto;
    }

    // Preparar la consulta de inserción con parámetros
    $query = "INSERT INTO `servicio`(`descripcion`, `duracion`, `precio`, `imagen`) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);

    // Enlazar los parámetros (s: string, i: integer)
    $stmt->bind_param("siis", $nombre, $duracion, $precio, $foto);

    // Ejecutar la consulta e informar del resultado
    if ($stmt->execute()) {
        echo "Registro exitoso";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conexion->close();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Servicio - Atarfe Fighting</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="../../js/header.js" defer></script>
    <link rel="icon" type="image/ico" href="../../imagenes/Logo.ico" />
    <script src="../../js/añadirservicio.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include '../esencial/header.php' ?>
    <main>
        <h1>Nuevo servicio</h1>

        <form action="añadirservicio.php" method="post" enctype="multipart/form-data" style="width:500px; justify-self:center;">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" placeholder="Introduzca el título de la noticia">

            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" placeholder="Introduzca el precio de la tarifa">

            <label for="duracion">Duración:</label>
            <input type="number" name="duracion" id="duracion" placeholder="Introduzca la duración en minutos">

            <label for="foto">Imagen:</label>
            <input type="file" name="foto" id="foto" accept="image/*">

            <button type="submit" class="btn btn-warning" style="width:150px">Registrar</button>
        </form>
    </main>
    <?php include '../esencial/footer.php'; ?>
</body>

</html>