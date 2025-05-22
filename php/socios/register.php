<?php
include '../esencial/conexion.php';

$errores = [];

if (!isset($_SESSION['nombre'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recibir y sanitizar datos
        $nombre = trim($_POST['nombre']);
        $usuario = trim($_POST['usuario']);
        $edad = trim($_POST['edad']);
        $contrasena = $_POST['contrasena'];
        $telefono = trim($_POST['telefono']);
        $foto = $_FILES['foto'];

        // Validaciones
        if (!preg_match('/^[a-zA-Z\s]{4,50}$/', $nombre)) {
            $errores['nombre'] = "El nombre debe contener solo letras, entre 4 y 50 caracteres.";
        }

        //El nombre no puede ser ni admin ni administrador
        if (strtolower($nombre) == "admin" || strtolower($nombre) == "administrador") {
            $errores['nombre'] = "El nombre no puede ser 'admin' o 'administrador'.";
        }

        //El username no puede ser ni admin ni administrador ni root
        if (strtolower($usuario) == "admin" || strtolower($usuario) == "administrador" || strtolower($usuario) == "root") {
            $errores['usuario'] = "El nombre de usuario no puede ser 'admin', 'administrador' o 'root'.";
        }

        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9]{4,19}$/', $usuario)) {
            $errores['usuario'] = "El usuario debe empezar con letra y tener entre 5 y 20 caracteres.";
        }

        if (!filter_var($edad, FILTER_VALIDATE_INT) || $edad < 18 || $edad > 100) {
            $errores['edad'] = "Debes tener entre 18 y 100 años.";
        }

        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]{7,15}$/', $contrasena)) {
            $errores['contrasena'] = "La contraseña debe empezar con letra, contener letras, números o '_', y tener entre 8 y 16 caracteres.";
        }

        if (!preg_match('/^\+34\d{9}$/', $telefono)) {
            $errores['telefono'] = "El teléfono debe tener formato +34 seguido de 9 dígitos.";
        }

        // Validar la foto
        if ($foto['error'] != UPLOAD_ERR_OK) {
            $errores['foto'] = "Es obligatorio subir una foto.";
        } elseif ($foto['type'] !== "image/jpeg") {
            $errores['foto'] = "La foto debe ser un archivo JPEG.";
        } elseif ($foto['size'] > 5 * 1024 * 1024) {
            $errores['foto'] = "La foto no debe superar los 5MB.";
        }

        // Verificar si el usuario o el teléfono ya existen en la base de datos
        $query_check = "SELECT * FROM socio WHERE usuario = ? OR telefono = ?";
        $stmt_check = $conexion->prepare($query_check);
        $stmt_check->bind_param("ss", $usuario, $telefono);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['usuario'] == $usuario) {
                    $errores['usuario'] = "El nombre de usuario ya está en uso.";
                }
                if ($row['telefono'] == $telefono) {
                    $errores['telefono'] = "El número de teléfono ya está registrado.";
                }
            }
        }
        $stmt_check->close();

        // Si no hay errores, insertar en la base de datos
        if (empty($errores)) {
            // Hashear contraseña
            $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

            // Guardar la foto con un nombre único
            $fotoNombre = time() . "_" . basename($foto['name']);
            move_uploaded_file($foto['tmp_name'], "../../imagenes/$fotoNombre");

            // Insertar en la base de datos
            $query = "INSERT INTO socio (nombre, edad, contrasena, usuario, telefono, foto) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("sissss", $nombre, $edad, $contrasenaHash, $usuario, $telefono, $fotoNombre);

            if ($stmt->execute()) {
                header("Location: ../../index.php");
                exit();
            } else {
                $errores['general'] = "Error en el registro: " . $stmt->error;
            }

            // hacer un query para sacar el nuevo id del socio
            // y crear los contadores por defecto
            $query2 = "SELECT id_socio FROM socio WHERE usuario = ?";
            $stmt2 = $conexion->prepare($query2);
            $stmt2->bind_param("s", $usuario);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                $id_socio = $row2['id_socio'];
            } else {
                $errores['general'] = "Error al obtener el ID del socio: " . $stmt2->error;
            }
            $stmt2->close();

            // Crear contadores por defecto
            // Se crean 4 contadores por defecto
            $query3 = "INSERT INTO contador (id_socio, tipo, valor) VALUES (?, 'Sala_principal', 0), (?, 'Sala_VIP', 0), (?, 'Play_Station_5', 0), (?, 'Simulador_coches', 0)";
            $stmt3 = $conexion->prepare($query3);
            $stmt3->bind_param("iiii", $id_socio, $id_socio, $id_socio, $id_socio);
            if (!$stmt3->execute()) {
                $errores['contadores'] = "Error al crear contadores: " . $stmt3->error;
            }
            $stmt3->close();
            // Cerrar conexión
            $stmt->close();
            $conexion->close();
        }
    }
?>



    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro - Atarfe Fighting</title>
        <link rel="stylesheet" href="../../css/styles.css">
        <script src="../../js/register.js" defer></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <?php include '../esencial/header.php'; ?>
        <main>
            <h2 style="font-weight: bold;">Registro de Socio</h2>
            <form action="register.php" method="post" enctype="multipart/form-data">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>
                <p class="error"><?= $errores['nombre'] ?? '' ?></p>

                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>" required>
                <p class="error"><?= $errores['usuario'] ?? '' ?></p>

                <label for="edad">Edad:</label>
                <input type="number" name="edad" id="edad" value="<?= htmlspecialchars($_POST['edad'] ?? '') ?>" required>
                <p class="error"><?= $errores['edad'] ?? '' ?></p>

                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" required>
                <p class="error"><?= $errores['contrasena'] ?? '' ?></p>

                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>" required>
                <p class="error"><?= $errores['telefono'] ?? '' ?></p>

                <label for="foto">Foto:</label>
                <input type="file" name="foto" id="foto" accept="image/jpeg" required>
                <p class="error"><?= $errores['foto'] ?? '' ?></p>

                <button type="submit">Registrar</button>
            </form>


        </main>
        <?php include '../esencial/footer.php'; ?>
    </body>

    </html>

<?php
} else {
    header("Location: ../../index.php");
    exit();
}
?>