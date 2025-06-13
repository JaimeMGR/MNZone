<?php
require '../../vendor/autoload.php';
use Dompdf\Dompdf;

session_start();

if (!isset($_POST['productos']) || !isset($_POST['total'])) {
    http_response_code(400);
    echo "Datos incompletos.";
    exit;
}

$productos = json_decode($_POST['productos'], true);
$total = $_POST['total'];
$nombre_usuario = $_SESSION['nombre'] ?? 'Invitado';
$fecha = date("d/m/Y H:i");

// Generar HTML del ticket
$html = "
<h2>Ticket de Compra - MNZone</h2>
<p><strong>Cliente:</strong> {$nombre_usuario}</p>
<p><strong>Fecha:</strong> {$fecha}</p>
<table border='1' cellspacing='0' cellpadding='5'>
<tr><th>Producto</th><th>Precio (€)</th></tr>";

foreach ($productos as $producto) {
    $nombre = htmlspecialchars($producto['nombre_producto']);
    $precio = htmlspecialchars($producto['precio']);
    $html .= "<tr><td>{$nombre}</td><td>{$precio}</td></tr>";
}

$html .= "</table><h3>Total: {$total} €</h3>";

// Crear el PDF con Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Vaciar el carrito si usas sesión
unset($_SESSION['carrito']);

// Enviar el PDF al navegador
$dompdf->stream("Ticket_Compra_MNZone.pdf", ["Attachment" => false]);

exit;