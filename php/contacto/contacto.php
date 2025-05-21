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
    <title>Contacto - MNZone</title>
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
        <h1>Contacto</h1>
        <div class='lista-servicios'>

            <div class="formulario" style="background:#f8f8f8;border-radius:5px;padding:20px">
                <?php if ($mensaje_enviado): ?>
                    <p>Gracias por tu mensaje, <?php echo htmlspecialchars($nombre); ?>. Nos pondremos en contacto contigo pronto.</p>
                <?php else: ?>

                    <p>Si quieres más información, completa el siguuiente formulario y nos pondremos en contacto contigo próximamente</p>
                    <form action="contacto.php" method="POST">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>

                        <label for="email">Correo electrónico:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="mensaje">Mensaje:</label>
                        <textarea id="mensaje" name="mensaje" rows="5" required></textarea>

                        <input type="submit" class="btn btn-outline-secondary" value="Enviar">
                    </form>
                <?php endif; ?>
            </div>
            <div class="formulario">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12716.530302999345!2d-3.619716512841848!3d37.1733202!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71fcbe0a2e22af%3A0x33bdec6485ad91a!2sArena%20Gaming!5e0!3m2!1ses!2ses!4v1746551479161!5m2!1ses!2ses" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </main>
    <?php include '../esencial/footer.php' ?>

</body>

</html>