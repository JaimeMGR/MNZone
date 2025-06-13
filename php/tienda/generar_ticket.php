<?php
require '../../vendor/autoload.php';
use Dompdf\Dompdf;

session_start();

if (!isset($_POST['productos']) || !isset($_POST['total'])) {
    die("Datos incompletos.");
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
    $html .= "<tr><td>{$producto['nombre_producto']}</td><td>{$producto['precio']}</td></tr>";
}

$html .= "</table><h3>Total: {$total} €</h3>";

// Crear el PDF con Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', orientation: 'portrait');
$dompdf->render();

// Vaciar el carrito (esto depende de cómo lo tengas implementado; aquí es vía sesión)
unset($_SESSION['carrito']); // si usabas $_SESSION['carrito']

// Enviar el PDF al navegador
$dompdf->stream("Ticket_Compra_MNZone.pdf", ["Attachment" => false]); // Cambia a true si quieres forzar descarga
exit;


