<?php
include '../esencial/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto - Atarfe Fighting</title>
    <script src="../../js/header.js" defer></script>
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="../../js/añadirproducto.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="background:#f4f4f9">
    <?php include '../esencial/header.php'; ?>
    <main>

        <h1>Añadir Nuevo Producto</h1>


        <form action="api/agregar.php" method="POST" enctype="multipart/form-data">
            <label for="nombre_producto">Nombre:</label>
            <input type="text" name="nombre_producto" id="nombre_producto" placeholder="Introduce el nombre del producto" required>

            <label for="compania">Compañía:</label>
            <input type="text" name="compania" id="compania" placeholder="Introduce la compañía del producto" required>

            <label for="precio">Precio (€):</label>
            <input type="number" step="0.01" name="precio" id="precio" placeholder="Introduce el precio" required>

            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="imagen/*" required>

            <label for="categoria">Categoria:</label>
            <select name="categoria" id="categoria">
                <option value="Todos">Todos</option>
                <option value="Guantes">Guantes</option>
                <option value="Pantalones">Pantalones</option>
                <option value="Rodilleras">Rodilleras</option>
                <option value="Zapatillas">Zapatillas</option>
                <option value="Tobilleras">Tobilleras</option>
                <option value="Bucales">Bucales</option>
                <option value="Suplementos">Suplementos</option>
            </select>

            <button type="submit" class="add">Añadir producto</button>
        </form>

        <a style="color:darkgreen" href="tienda.php">Volver al listado</a>

    </main>

    <?php include '../esencial/footer.php'; ?>
</body>

</html>