<?php
session_start();
unset($_SESSION['carrito']);
echo json_encode(['status' => 'ok']);
?>
