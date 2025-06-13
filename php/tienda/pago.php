<?php
include '../esencial/conexion.php';  // Aquí dentro está session_start();

$productos_json = $_GET['productos'] ?? '[]';
$total = $_GET['total'] ?? 0;
$productos = json_decode($productos_json, true);

$id_socio = null;

// Obtener el id_socio a partir del usuario en sesión (campo usuario = nickname)
if (isset($_SESSION['nombre'])) {
  $usuario = $conexion->real_escape_string($_SESSION['nombre']);
  $sql = "SELECT id_socio FROM socio WHERE usuario = '$usuario' LIMIT 1";
  $resultado = $conexion->query($sql);
  if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $id_socio = $fila['id_socio'];
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pago - MNZone</title>
  <link rel="stylesheet" href="../../css/styles.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="styles.css" />
  <script src="../../js/header.js" defer></script>
</head>

<body>
  <?php include '../esencial/header.php'; ?>
  <main>
    <?php
    if (isset($_SESSION["nombre"]) && ($_SESSION["tipo"] == "admin" || $_SESSION["tipo"] == "socio")) {
    ?>
      <section class="container">
        <h1 class="text-center my-4">Resumen de tu compra</h1>
        <div class="row">
          <div class="col-md-8 offset-md-2">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th>Producto</th>
                  <th>Precio (€)</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($productos as $producto): ?>
                  <tr>
                    <td>
                      <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre_producto']) ?>" class="img-thumbnail" style="width: 50px; height: 50px;">
                    </td>
                    <td><?= htmlspecialchars($producto['nombre_producto']) ?></td>
                    <td><?= htmlspecialchars($producto['precio']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <h3>Total: <?= htmlspecialchars($total) ?> €</h3>
          </div>
        </div>

        <div class="text-center my-4">
          <form id="formularioPago">
            <input type="hidden" id="productos" value='<?= htmlspecialchars($productos_json) ?>'>
            <input type="hidden" id="total" value='<?= htmlspecialchars($total) ?>'>
            <button type="button" id="confirmarPago" class="btn btn-success">Confirmar Pago</button>
          </form>
        </div>
      </section>

    <?php
    } else {
      echo "<p>No tienes permiso para acceder.</p>";
    }
    ?>
  </main>

  <script>
    document.getElementById('confirmarPago').addEventListener('click', function() {
      const productos = JSON.parse(document.getElementById('productos').value);
      const idSocio = <?= json_encode($id_socio) ?>;
      const nombre = <?= json_encode($_SESSION['nombre'] ?? '') ?>;
      const total = document.getElementById('total').value;

      if (!idSocio || !nombre) {
        alert("Error: Usuario no identificado.");
        return;
      }

      let errores = [];

      Promise.all(productos.map(producto => {
          const url = `http://localhost/MNZone/php/contadores/api_crud/api.php?id_socio=${idSocio}&nombre=${encodeURIComponent(nombre)}&id_producto=${producto.id_producto}`;
          return fetch(url)
            .then(response => {
              if (!response.ok) {
                errores.push(`Error al procesar el producto: ${producto.nombre_producto}`);
              }
              return response.text();
            })
            .catch(() => {
              errores.push(`Error de red con el producto: ${producto.nombre_producto}`);
            });
        }))
        .then(() => {
          if (errores.length > 0) {
            alert("Se produjeron errores:\n" + errores.join("\n"));
          } else {
            const formData = new FormData();
            formData.append("productos", JSON.stringify(productos));
            formData.append("total", total);

            fetch("generar_ticket.php", {
                method: "POST",
                body: formData
              })
              .then(response => {
                if (!response.ok) throw new Error("Error al generar el ticket.");
                return response.blob();
              })
              .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = "ticket_MNZone.pdf";
                document.body.appendChild(a);
                a.click();
                a.remove();

                window.URL.revokeObjectURL(url);

                // Redirigir a tienda.php tras descarga
                header("Location: ../tienda.php");
              })
          }
        });
    });
  </script>

  <?php include '../esencial/footer.php'; ?>
</body>

</html>
