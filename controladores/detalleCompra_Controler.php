<?php
require_once("controladores/conexion.php");
require_once("modelos/Detalle.php");
require_once("modelos/detalle_compras.php");
require_once("modelos/Compra.php");


class Detalle_controller extends conexion {
    public function listar($id_usuario) {
        $sql = "SELECT * FROM detalle WHERE id_usuario = '$id_usuario'";
        $rs = $this->ejecutarSQL($sql);
        $resultado = [];
        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = $fila;
        }
        return $resultado;
    }

    public function obtenerDetallePorProductoYUsuario($id_producto, $id_usuario) {
        $sql = "SELECT * FROM detalle WHERE id_producto = $id_producto AND id_usuario = $id_usuario";
        $rs = $this->ejecutarSQL($sql);
        return $rs->fetch_assoc();
    }

    public function agregarCompra($compra) {
        $sql = "INSERT INTO compras (total, fecha) VALUES ('".$compra->getTotal()."', '".$compra->getFecha()."')";
        $this->ejecutarSQL($sql);
    }

    public function agregarDetalleCompra($detalleCompra) {
        $sql = "INSERT INTO detalle_compras (id_compra, id_producto, cantidad, precio, subtotal) VALUES (
                    '".$detalleCompra->getIdCompra()."',
                    '".$detalleCompra->getIdProducto()."',
                    '".$detalleCompra->getCantidad()."',
                    '".$detalleCompra->getPrecio()."',
                    '".$detalleCompra->getSubtotal()."'
                )";
         
        $this->ejecutarSQL($sql);
    }
    

    public function obtenerUltimoIdCompra() {
        $sql = "SELECT MAX(id) AS ultimo_id FROM compras";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return $fila['ultimo_id'];
    }

    public function guardarCompraConDetalles($compra, $detalles) {
        // Insertamos la compra en la tabla de compras
        $sqlCompra = "INSERT INTO compras (total, fecha) VALUES ('".$compra->getTotal()."', '".$compra->getFecha()."')";
        $this->ejecutarSQL($sqlCompra);
        
        // Obtener el último id de compra insertado
        $idCompra = $this->obtenerUltimoIdCompra();
         
    
        // Recorremos cada detalle y los asociamos con la compra
        foreach ($detalles as $detalle) {
            $subtotal = $detalle['cantidad'] * $detalle['precio'];
            $detalleCompra = new DetalleCompra(
                $idCompra, // Usamos el mismo id_compra para todos los detalles
                $detalle['id_producto'],
                $detalle['cantidad'],
                $detalle['precio'],
                $subtotal // Calculamos el subtotal
            );
    
           
            
            $this->agregarDetalleCompra($detalleCompra);
        }
    }

    public function generarPDF($id_compra){
        require('Librerias\fpdf/fpdf.php');

        // Iniciar el almacenamiento en búfer de salida
        ob_start();

        // Crear instancia de FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);

        // Título del documento
        $pdf->Cell(190, 10, 'Detalles de la Compra', 0, 1, 'C');
        $pdf->Ln(10); // Línea en blanco

        // Obtener los detalles de la compra
        $sql = "SELECT * FROM detalle_compras WHERE id_compra = $id_compra";
        $rs = $this->ejecutarSQL($sql);
        $compraDetalles = [];
        while ($fila = $rs->fetch_assoc()) {
            $compraDetalles[] = $fila;
        }

        // Agregar encabezados de tabla
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(40, 10, 'ID Producto', 1);
        $pdf->Cell(40, 10, 'Cantidad', 1);
        $pdf->Cell(40, 10, 'Precio', 1);
        $pdf->Cell(40, 10, 'Subtotal', 1);
        $pdf->Ln();

        // Agregar datos de los detalles
        $pdf->SetFont('Arial','',12);
        foreach ($compraDetalles as $detalle) {
            $pdf->Cell(40, 10, $detalle['id_producto'], 1);
            $pdf->Cell(40, 10, $detalle['cantidad'], 1);
            $pdf->Cell(40, 10, number_format($detalle['precio'], 2), 1);
            $pdf->Cell(40, 10, number_format($detalle['subtotal'], 2), 1);
            $pdf->Ln();
        }

        // Limpiar el búfer de salida y generar el PDF
        ob_end_clean();
        $pdf->Output();
    }
    
    

    public function agregarODetalle($detalle) {
        $existente = $this->obtenerDetallePorProductoYUsuario($detalle->getIdProducto(), $detalle->getIdUsuario());
        if ($existente) {
            $nuevaCantidad = $existente['cantidad'] + $detalle->getCantidad();
            $nuevoSubtotal = $existente['sub_total'] + $detalle->getSubTotal();
            $sql = "UPDATE detalle SET cantidad = $nuevaCantidad, sub_total = $nuevoSubtotal WHERE id = ".$existente['id'];
        } else {
            $sql = "INSERT INTO detalle (id_producto, id_usuario, precio, cantidad, sub_total) VALUES (
                        '".$detalle->getIdProducto()."',
                        '".$detalle->getIdUsuario()."',
                        '".$detalle->getPrecio()."',
                        '".$detalle->getCantidad()."',
                        '".$detalle->getSubTotal()."'
                    )";
        }
        $this->ejecutarSQL($sql);

        // Actualizar la cantidad del producto en el inventario
        $producto_controller = new Producto_controller();
        $producto_controller->RestarCantidadProducto($detalle->getIdProducto(), $detalle->getCantidad());
    }

    public function eliminarDetalle($id) {
        $sql = "DELETE FROM detalle WHERE id = '$id'";
        $this->ejecutarSQL($sql);
    }

    public function eliminar($id) {
        // Obtener el detalle de compra antes de eliminarlo
        $detalle = $this->obtenerPorId($id);
        if ($detalle) {
            // Actualizar la cantidad del producto en el inventario
            $producto_controller = new Producto_controller();
            $producto_controller->revertirCantidadProducto($detalle->getIdProducto(), $detalle->getCantidad());
            
            // Eliminar el detalle de compra
            $this->eliminarDetalle($id);
        }
    }


    public function vaciarDetalle($idusuario) {
        $sql = "DELETE FROM detalle WHERE id_usuario = '$idusuario'";
        $this->ejecutarSQL($sql);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM detalle WHERE id = $id";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return new Detalle(
            $fila["id"],
            $fila["id_producto"],
            $fila["id_usuario"],
            $fila["precio"],
            $fila["cantidad"],
            $fila["sub_total"]
        );
    }

    

    public function obtenerTotalPorUsuario($id_usuario) {
        $sql = "SELECT SUM(sub_total) AS Total FROM detalle WHERE id_usuario = $id_usuario";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return $fila['Total'];
    }

    public function verificarDisponibilidadProducto($productoId, $cantidad) {
        $sql = "SELECT cantidad FROM productos WHERE id = '$productoId'";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        $cantidadDisponible = $fila['cantidad'];
        if ($cantidadDisponible >= $cantidad) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerCompra($idCompra){
        $sql = "SELECT c.*, d.* FROM compras c 
        INNER JOIN detalle_compras d ON c.id = d.id_compra 
        WHERE c.id = $idCompra";
        $rs = $this->ejecutarSQL($sql);
        $resultado = [];
        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = $fila;
        }
        return $resultado;
    }

    
    public function AnularCompra($id) {
        // Obtener los detalles de la compra
        $compra = $this->obtenerPorIdCompra($id);

        // Verificar si la compra ya está anulada
        if ($compra->getEstado() == 0) {
            return; // Si ya está anulada, no hacer nada
        }

        // Obtener los detalles de la compra (productos y cantidades)
        $detallesCompra = $this->obtenerCompra($id);

        // Revertir la cantidad de los productos
        foreach ($detallesCompra as $detalle) {
            $productoId = $detalle["id_producto"];
            $cantidadComprada = $detalle["cantidad"];

            // Obtener el producto
            $producto = $this->obtenerPorIdProducto($productoId);
            $nuevaCantidad = $producto["cantidad"] - $cantidadComprada;

            // Actualizar la cantidad del producto
            
            
            $this->actualizarCantidad($productoId,$nuevaCantidad);
        }

        // Cambiar el estado de la compra a inactivo (0)
        $this->ActualizarEstado($id);
    }

    public function ActualizarEstado($id) {
        $sql = "UPDATE compras SET estado = 0 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function obtenerPorIdCompra($id) {
        $sql = "SELECT * FROM compras WHERE id = $id";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return new Compra(
            $fila["id"],
            $fila["total"],
            $fila["fecha"],
            $fila["estado"]
        );
    }

    public function actualizar($compra) {
        $sql = "UPDATE compras SET 
                    total = '".$compra->getTotal()."', 
                    fecha = '".$compra->getFecha()."', 
                    estado = '".$compra->getEstado()."'
                WHERE id = '".$compra->getId()."'";
        $this->ejecutarSQL($sql);
    }

    public function revertirCantidadProducto($productoId, $cantidad) {
        $producto = $this->obtenerPorIdProducto($productoId);
        $nuevaCantidad = $producto['cantidad'] + $cantidad;
        $this->actualizarCantidad($productoId, $nuevaCantidad);
    }

    public function RestarCantidadProducto($productoId, $cantidad) {
        $producto = $this->obtenerPorIdProducto($productoId);
        $nuevaCantidad = $producto['cantidad'] - $cantidad;
        $this->actualizarCantidad($productoId, $nuevaCantidad);
    }

    public function obtenerPorIdProducto($productoId) {
        $sql = "SELECT * FROM productos WHERE id = $productoId";
        $rs = $this->ejecutarSQL($sql);
        return $rs->fetch_assoc();
    }

    public function actualizarCantidad($productoId, $nuevaCantidad) {
        $sql = "UPDATE productos SET cantidad = $nuevaCantidad WHERE id = $productoId";
        $this->ejecutarSQL($sql);
    }
}





?>
