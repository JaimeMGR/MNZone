<?php
include '../esencial/conexion.php';

$mensaje_enviado = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Guardar mensaje en la base de datos (opcional)
    $query = "INSERT INTO mensajes_contacto (nombre, email, mensaje) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sss", $nombre, $email, $mensaje);

    if ($stmt->execute()) {
        $mensaje_enviado = true;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Atarfe Fighting</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="js/app.js" defer></script>
    <script src="../../js/header.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="background:#f4f4f9">
    <?php include '../esencial/header.php' ?>
    <main>
        <h2 style="font-weight: bold;">Contacto</h2>

        <?php if ($mensaje_enviado): ?>
            <p>Gracias por tu mensaje, <?php echo htmlspecialchars($nombre); ?>. Nos pondremos en contacto contigo pronto.</p>
        <?php else: ?>
            <form action="contacto.php" method="POST" style="padding:20px">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>

                <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" rows="5" required></textarea>

                <input type="submit" class="btn btn-outline-secondary" value="Enviar">
            </form>
        <?php endif; ?>
    </main>
    <?php include '../esencial/footer.php' ?>

</body>

</html>