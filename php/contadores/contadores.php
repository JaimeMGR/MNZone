<?php
include '../esencial/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Descarga la aplicación de contadores de MNZone para gestionar tus tiempos de juego">
  <title>MNZone | Descargas</title>
  <link rel="icon" type="image/ico" href="../../imagenes/Logo.ico" />
  <script src="../../js/header.js" defer></script>
  <link rel="stylesheet" href="../../css/styles.css">
  <script src="js../../app.js" defer></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php include '../esencial/header.php'; ?>

  <main class="container my-5">
    <section class="download-section">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center mb-5">
          <h1 class="display-4 fw-bold mb-3 text-primary">Descarga la App de MNZone</h1>
          <p class="lead text-muted">Controla los tiempos de uso de las salas desde tu ordenador</p>
        </div>
      </div>

      <div class="row g-4">
        <!-- Tarjeta de descarga -->
        <div class="col-md-6">
          <div class="download-card h-100 p-4 border rounded shadow-lg">
            <div class="text-center">
              <i class="download-icon fas fa-desktop fa-3x text-primary mb-3"></i>
              <h2 class="text-secondary">Versión para Windows</h2>
              <p class="mb-4 text-muted">Aplicación de escritorio compatible con Windows 10/11</p>

              <div class="d-grid gap-2 col-md-8 mx-auto">
                <a href="../../Files/App.zip" class="btn btn-primary download-btn" download="MNZone_App.zip">
                  <i class="fas fa-download me-2"></i> Descargar (v1.0)
                </a>
              </div>

              <div class="mt-4 text-muted small">
                <p>Tamaño: ~15MB | Última actualización: <?php echo date("d/m/Y"); ?></p>
              </div>
            </div>
          </div>
        </div>

        <!-- Características y requisitos del sistema -->
        <div class="col-md-6">
          <div class="h-100">
            <h2 class="text-primary mb-3">Características principales</h2>
            <ul class="features-list list-unstyled">
              <li><i class="fas fa-check-circle text-success me-2"></i>Control de tiempos por sala en tiempo real</li>
              <li><i class="fas fa-check-circle text-success me-2"></i>Interfaz intuitiva y fácil de usar</li>
              <li><i class="fas fa-check-circle text-success me-2"></i>Sistema de inicio/pausa de contadores</li>
              <li><i class="fas fa-check-circle text-success me-2"></i>Visualización del tiempo restante</li>
              <li><i class="fas fa-check-circle text-success me-2"></i>Registro de uso por usuario</li>
              <li><i class="fas fa-check-circle text-success me-2"></i>Notificaciones de tiempo agotado</li>
            </ul>

            <div class="system-requirements mt-4">
              <h2 class="text-primary mb-3">Requisitos del sistema</h2>
              <ul class="features-list list-unstyled">
                <li><i class="fas fa-cogs text-muted me-2"></i>Sistema operativo: Windows 10/11 (64-bit)</li>
                <li><i class="fas fa-cogs text-muted me-2"></i>Procesador: 1 GHz o superior</li>
                <li><i class="fas fa-cogs text-muted me-2"></i>Memoria RAM: 2 GB mínimo</li>
                <li><i class="fas fa-cogs text-muted me-2"></i>Espacio en disco: 50 MB disponibles</li>
                <li><i class="fas fa-cogs text-muted me-2"></i>Conexión a Internet para actualizaciones</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-12">
          <div class="card border-0 shadow-sm rounded">
            <div class="card-body">
              <h4 class="card-title mb-4 text-primary">Instrucciones de instalación</h4>
              <div class="row">
                <div class="col-md-4 mb-3">
                  <div class="d-flex">
                    <div class="me-3 text-primary">
                      <i class="fas fa-download fa-2x"></i>
                    </div>
                    <div>
                      <h5>Paso 1</h5>
                      <p class="mb-0">Descarga el archivo .zip haciendo clic en el botón superior</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 mb-3">
                  <div class="d-flex">
                    <div class="me-3 text-primary">
                      <i class="fas fa-file-archive fa-2x"></i>
                    </div>
                    <div>
                      <h5>Paso 2</h5>
                      <p class="mb-0">Extrae el contenido del archivo ZIP en una carpeta</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 mb-3">
                  <div class="d-flex">
                    <div class="me-3 text-primary">
                      <i class="fas fa-rocket fa-2x"></i>
                    </div>
                    <div>
                      <h5>Paso 3</h5>
                      <p class="mb-0">Ejecuta el archivo "MNZone.exe" para iniciar la aplicación</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include '../esencial/footer.php'; ?>
</body>

</html>