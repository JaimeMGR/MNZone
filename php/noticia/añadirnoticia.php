<?php
include '../esencial/conexion.php';
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Noticia - Atarfe Fighting</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="../../js/añadirnoticia.js" defer></script>
    <script src="../../js/header.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="background:#f4f4f9">

<?php include '../esencial/header.php';?>
<?php
    if (isset($_SESSION["nombre"]) && $pagina_actual == "añadirnoticia.php" &&  $_SESSION["tipo"] == "admin") {?>
    <main>
        <h2 style="font-weight: bold;">Redactar noticia</h2>

        <form action="crearnoticia.php" method="post" enctype="multipart/form-data">
            <label for="titulo">Titulo:</label>
            <input type="text" name="titulo" id="titulo">

            <label for="contenido">Contenido:</label>
            <input type="text" name="contenido" id="contenido">

            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="*.jpeg">

            <button type="submit">Registrar</button>
        </form>
    </main>
    <?php }else{
        header("Location:../../index.php");
    }; ?>
<?php include '../esencial/footer.php' ?>
</body>

</html>