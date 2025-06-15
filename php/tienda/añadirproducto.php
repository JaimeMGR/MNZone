<?php
include '../esencial/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto - MNZone</title>
    <script src="../../js/header.js" defer></script>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="icon" type="image/ico" href="../../imagenes/Logo.ico" />
    <script src="../../js/añadirproducto.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include '../esencial/header.php'; ?>
    <main>

        <h1>Añadir Nuevo Producto</h1>


        <form action="api/agregar.php" method="POST" enctype="multipart/form-data" style="width:500px; justify-self:center;">
            <label for="nombre_producto">Nombre:</label>
            <input type="text" name="nombre_producto" id="nombre_producto" placeholder="Introduce el nombre del producto" required>

            <label for="compania">Compañía:</label>
            <input type="text" name="compania" id="compania" placeholder="Introduce la compañía del producto" required>

            <label for="precio">Precio (€):</label>
            <input type="number" name="precio" id="precio" placeholder="Introduce el precio" required>

            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="imagen/*" required>

            <label for="categoria">Categoria:</label>
            <select name="categoria" id="categoria">
                <option value="Todos">Todos</option>
                <option value="Bebida">Bebida</option>
                <option value="Comida">Comida</option>
                <option value="Play_Station_5">Play Station 5</option>
                <option value="Sala_VR">Sala VR</option>
                <option value="Sala_VIP">Sala VIP</option>
                <option value="Sala_principal">Sala principal</option>
                <option value="Simulador_coches">Simulador de coches</option>

            </select>

            <button type="submit" class="add btn btn-warning" style="width:150px">Añadir producto</button>
        </form>

        <a style="color:darkgreen" href="tienda.php">Volver al listado</a>

    </main>

    <?php include '../esencial/footer.php'; ?>
</body>

</html>