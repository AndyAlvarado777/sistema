<?php
require_once 'controladores/productos_controller.php';

if (isset($_POST['idProducto'])) {
    $productoId = $_POST['idProducto'];
    $producto_controller = new Producto_controller();
    $producto = $producto_controller->obtenerPorId($productoId);
    echo json_encode($producto);
    exit;
}
?>
