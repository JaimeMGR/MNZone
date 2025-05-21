<?php
include '../esencial/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contadores - MNZone</title>
  <link rel="stylesheet" href="../../css/styles.css">
  <script src="../../js/header.js" defer></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css" />
  <!-- font-awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
  <!-- styles css -->
</head>

<body>
  <?php include '../esencial/header.php' ?>
  <main>
    <?php
    $usuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : null;
    $categoria = $_POST['categoria'] ?? null;
    $apiUrl = "http://localhost/MNZone/php/contadores/api_crud/api.php?nombre=$usuario";

    $lista = [];
    ?>
    <h2 class="fw-bold">Contadores</h2>

    <?php
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $respuesta = json_decode(curl_exec($ch), true);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
      $SalaPrincipal = $respuesta["tiempos"]["Sala_principal"] ?: 0;
      $SalaVip = $respuesta["tiempos"]["Sala_VIP"] ?: 0;
      $PS5 = $respuesta["tiempos"]['Play_Station_5'] ?: 0;
      $SimCoches = $respuesta["tiempos"]['Simulador_coches'] ?: 0;

      $SalaPrincipal = $SalaPrincipal / 60;
      $SalaVip = $SalaVip / 60;
      $PS5 = $PS5 / 60;
      $SimCoches = $SimCoches / 60;

      // Añadir los valores a javascript
      echo "<script>
              var SalaPrincipal = $SalaPrincipal;
              var SalaVip = $SalaVip;
              var PS5 = $PS5;
              var SimCoches = $SimCoches;
            </script>";
    ?>
      <div class="container mt-4">
        <div class="row">
          <?php if ($SalaPrincipal > 0): ?>
            <div class="col-md-6 mb-4">
              <div class="card border-primary">
                <div class="card-body">
                  <h5 class="card-title text-primary fw-bold">Sala Principal</h5>
                  <p class="card-text fw-semibold">Tiempo total: <?= $SalaPrincipal ?> minutos</p>
                </div>
              </div>
            </div>
          <?php else: ?>
            <div class="col-12">
              <div class="alert alert-danger fw-bold">No se encontraron tiempos para Sala Principal</div>
            </div>
          <?php endif; ?>

          <?php if ($SalaVip > 0): ?>
            <div class="col-md-6 mb-4">
              <div class="card border-warning">
                <div class="card-body">
                  <h5 class="card-title text-warning fw-bold">Sala VIP</h5>
                  <p class="card-text fw-semibold">Tiempo total: <?= $SalaVip ?> minutos</p>
                </div>
              </div>
            </div>
          <?php else: ?>
            <div class="col-12">
              <div class="alert alert-danger fw-bold">No se encontraron tiempos para Sala VIP</div>
            </div>
          <?php endif; ?>

          <?php if ($PS5 > 0): ?>
            <div class="col-md-6 mb-4">
              <div class="card border-success">
                <div class="card-body">
                  <h5 class="card-title text-success fw-bold">Play Station 5</h5>
                  <p class="card-text fw-semibold">Tiempo total: <?= $PS5 ?> minutos</p>
                </div>
              </div>
            </div>
          <?php else: ?>
            <div class="col-12">
              <div class="alert alert-danger fw-bold">No se encontraron tiempos para Play Station 5</div>
            </div>
          <?php endif; ?>

          <?php if ($SimCoches > 0): ?>
            <div class="col-md-6 mb-4">
              <div class="card border-info">
                <div class="card-body">
                  <h5 class="card-title text-info fw-bold">Simulador de Coches</h5>
                  <p class="card-text fw-semibold">Tiempo total: <?= $SimCoches ?> minutos</p>
                </div>
              </div>
            </div>
          <?php else: ?>
            <div class="col-12">
              <div class="alert alert-danger fw-bold">No se encontraron tiempos para Simulador de Coches</div>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <section class="contadores"></section>

      <div class="container mt-4">
        <form id="form-sala" class="mb-4">
          <div class="row g-3 align-items-center">
            <div class="col-auto">
              <label for="sala" class="col-form-label fw-bold">Selecciona una sala:</label>
            </div>
            <div class="col-auto">
              <select class="form-select" id="sala" required>
                <option value="">-- Elige una sala --</option>
                <option value="Sala_principal">Sala Principal</option>
                <option value="Sala_VIP">Sala VIP</option>
                <option value="Play_Station_5">Play Station 5</option>
                <option value="Simulador_coches">Simulador de Coches</option>
              </select>
            </div>
            <div class="col-auto">
              <button type="submit" class="btn btn-success">Iniciar sesión</button>
            </div>
          </div>
        </form>

        <div id="contador" class="alert alert-info d-none fw-bold"></div>
      </div>

      <!--alert-->
      <div class="alerta"></div>

      </section>
  </main>

  <script>
    // Cuando se envia el formulario para elegir la sala, debe de comenzar un contador para restar el tiempo a la categoria elegida
    document.getElementById("form-sala").addEventListener("submit", function(event) {
      event.preventDefault();
      const sala = document.getElementById("sala").value;
      const contador = document.getElementById("contador");
      const alerta = document.querySelector(".alerta");
      // Hay 4 variables que contienen el tiempo total de cada sala, por lo que se debe de restar el tiempo a la sala elegida
      let tiempoRestante = 0;
      if (sala === "Sala_principal") {
        tiempoRestante = SalaPrincipal;
      } else if (sala === "Sala_VIP") {
        tiempoRestante = SalaVip;
      } else if (sala === "Play_Station_5") {
        tiempoRestante = PS5;
      } else if (sala === "Simulador_coches") {
        tiempoRestante = SimCoches;
      }
      let tiempo = tiempoRestante * 60; // Convertir a segundos
      let intervalo;
      contador.classList.remove("d-none");
      contador.innerHTML = `Tiempo restante: ${tiempoRestante} minutos`;
      alerta.innerHTML = `<div class="alert alert-info">Has iniciado sesión en ${sala}</div>`;
      alerta.classList.remove("d-none");
      // Iniciar el contador
      intervalo = setInterval(function() {
        tiempo -= 1;
        contador.innerHTML = `Tiempo restante: ${Math.floor(tiempo / 60)} minutos y ${tiempo % 60} segundos`;
        if (tiempo <= 0) {
          clearInterval(intervalo);
          contador.innerHTML = "Tiempo agotado";
          alerta.innerHTML = `<div class="alert alert-danger">Tu tiempo ha terminado en ${sala}</div>`;
          alerta.classList.remove("d-none");
        }
        // Aquí puedes hacer una llamada AJAX para restar el tiempo en el servidor
        fetch("restar_tiempo.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            sala: sala,
            tiempoRestante: tiempo
          })
        })
        .then(response => response.json())
          .then(data => {
            if (data.success) {
              console.log("Tiempo restado en el servidor");
            } else {
              console.error("Error al restar tiempo en el servidor");
            }
          })
          .catch(error => {
            console.error("Error:", error);
          });
      }, 1000);
    });

  </script>
<?php
    } else {
      echo "<p class='text-danger fw-bold'>No se encontraron tiempos para el usuario</p>";
    }
?>
</main>
<?php include '../esencial/footer.php' ?>
</body>

</html>