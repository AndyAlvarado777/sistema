<?php
require_once("controladores/conexion.php");

class VentasController extends conexion {
    public function listarVenta() {
        $sql = "SELECT * FROM ventas";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Venta(
                $fila["id"],
                $fila["id_usuario"],
                $fila["id_cliente"],
                $fila["total"],
                $fila["fecha"],
                $fila["hora"],
                $fila["estado"],
                $fila["apertura"]
            );
        }
        return $resultado;
    }



    public function desactivar($id) {
        $sql = "UPDATE ventas SET estado = 0 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function activar($id) {
        $sql = "UPDATE ventas SET estado = 1 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function agregarVenta($venta) {
        $sql = "INSERT INTO ventas (id_usuario, id_cliente, total, fecha, hora, estado, apertura)
                VALUES ('".$venta->getIdUsuario()."', '".$venta->getIdCliente()."', '".$venta->getTotal()."', '".$venta->getFecha()."', '".$venta->getHora()."', '".$venta->getEstado()."', '".$venta->getApertura()."')";
        $this->ejecutarSQL($sql);
    }

    public function eliminarVenta($id) {
        $sql = "DELETE FROM ventas WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function obtenerPorIdVenta($id) {
        $sql = "SELECT * FROM ventas WHERE id = $id";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return new Venta(
            $fila["id"],
            $fila["id_usuario"],
            $fila["id_cliente"],
            $fila["total"],
            $fila["fecha"],
            $fila["hora"],
            $fila["estado"],
            $fila["apertura"]
        );
    }

    public function actualizarVenta($venta) {
        $sql = "UPDATE ventas SET 
                    id_usuario = '".$venta->getIdUsuario()."', 
                    id_cliente = '".$venta->getIdCliente()."', 
                    total = '".$venta->getTotal()."', 
                    fecha = '".$venta->getFecha()."', 
                    hora = '".$venta->getHora()."', 
                    estado = '".$venta->getEstado()."', 
                    apertura = '".$venta->getApertura()."'
                WHERE id = '".$venta->getId()."'";
        $this->ejecutarSQL($sql);
    }

    public function listarDetalle($id_usuario) {
        $sql = "SELECT * FROM detalle_temp WHERE id_usuario = '$id_usuario'";
        $rs = $this->ejecutarSQL($sql);
        $resultado = [];
        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = $fila;
        }
        return $resultado;
    }

    public function obtenerDetallePorProductoYUsuario($id_producto, $id_usuario) {
        $sql = "SELECT * FROM detalle_temp WHERE id_producto = $id_producto AND id_usuario = $id_usuario";
        $rs = $this->ejecutarSQL($sql);
        return $rs->fetch_assoc();
    }

    public function agregarDetalleVenta($detalleVenta) {
        $sql = "INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio, sub_total) VALUES (
                    '".$detalleVenta->getIdVenta()."',
                    '".$detalleVenta->getIdProducto()."',
                    '".$detalleVenta->getCantidad()."',
                    '".$detalleVenta->getPrecio()."',
                    '".$detalleVenta->getSubtotal()."'
                )";
       
        $this->ejecutarSQL($sql);
    }
    

    public function obtenerUltimoIdVenta() {
        $sql = "SELECT MAX(id) AS ultimo_id FROM ventas";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return $fila['ultimo_id'];
    }

    public function guardarVentaConDetalles($compra, $detalles) {
        
        // Insertamos la compra en la tabla de compras
        $sqlCompra = "INSERT INTO ventas (id_usuario, id_cliente, total, fecha) VALUES ('".$compra->getIdUsuario()."','".$compra->getIdCliente()."','".$compra->getTotal()."', '".$compra->getFecha()."')";
        $this->ejecutarSQL($sqlCompra);
        
        // Obtener el último id de compra insertado
        $cierreCajaController = new CierreCaja_controller();
        $cierreCajaController->actualizarMontos($compra->getIdUsuario());
        $idVenta = $this->obtenerUltimoIdVenta();
        
    
        // Recorremos cada detalle y los asociamos con la compra
        foreach ($detalles as $detalle) {
            $subtotal = $detalle['cantidad'] * $detalle['precio'];
            $detalleVenta = new DetalleVenta(
                $idVenta, // Usamos el mismo id_venta para todos los detalles
                $detalle['id_producto'],
                $detalle['cantidad'],
                $detalle['precio'],
                $subtotal // Calculamos el subtotal
            );
    
            
            
            $this->agregarDetalleVenta($detalleVenta);
        }
    }
    
    public function obtenerPorIdCajaVerificar($id) {
        $sql = "SELECT * FROM cierre_caja WHERE id_usuario = $id AND estado = 1";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()) { 
            $resultado[] = new CierreCaja(
                $fila["id"],
                $fila["id_usuario"],
                $fila["monto_inicial"],
                $fila["monto_final"],
                $fila["fecha_apertura"],
                $fila["fecha_cierre"],
                $fila["total_ventas"],
                $fila["monto_total"],
                $fila["estado"]
            );
        }
        return $resultado;
    }
    
    public function agregarODetalle($detalle) {
        // Verificar si la caja está abierta
        $cierreCaja = $this->obtenerPorIdCajaVerificar($detalle->getIdUsuario());
        if (empty($cierreCaja)) {
            // La caja no está abierta, mostrar SweetAlert de error
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Caja cerrada. No se puede realizar la venta.'
                    });
                 </script>";
            return;
        }
    
        // Si la caja está abierta, proceder con la operación
        $existente = $this->obtenerDetallePorProductoYUsuario($detalle->getIdProducto(), $detalle->getIdUsuario());
        if ($existente) {
            $nuevaCantidad = $existente['cantidad'] + $detalle->getCantidad();
            $nuevoSubtotal = $existente['sub_total'] + $detalle->getSubTotal();
            $sql = "UPDATE detalle_temp SET cantidad = $nuevaCantidad, sub_total = $nuevoSubtotal WHERE id = ".$existente['id'];
        } else {
            $sql = "INSERT INTO detalle_temp (id_producto, id_usuario, precio, cantidad, sub_total) VALUES (
                        '".$detalle->getIdProducto()."',
                        '".$detalle->getIdUsuario()."',
                        '".$detalle->getPrecio()."',
                        '".$detalle->getCantidad()."',
                        '".$detalle->getSubTotal()."'
                    )";
        }
        $this->ejecutarSQL($sql);
    
        // Actualizar la cantidad del producto en el inventario
        $this->RestarCantidadProducto($detalle->getIdProducto(), $detalle->getCantidad());
    }
    

    public function obtenerDetallePorId($id) {
        $sql = "SELECT * FROM detalle_temp WHERE id = $id";
        $result = $this->ejecutarSQL($sql);
        return $result->fetch_assoc(); // Suponiendo que usas MySQLi
    }
    
    // Ejemplo de actualizarDetalle_Temp
    public function actualizarDetalle_Temp($desc, $id, $precio) {
        // Verificar que el descuento no sea mayor al 50% del precio del producto
        $maxDescuento = $precio * 0.5;
        if ($desc > $maxDescuento) {
            $desc = $maxDescuento;
        }
    
        $sql = "UPDATE detalle_temp SET descuento = $desc WHERE id = $id";
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

    public function eliminarDetalle($id) {
        $sql = "DELETE FROM detalle_temp WHERE id = '$id'";
        $this->ejecutarSQL($sql);
    }

    public function eliminar($id) {
        // Obtener el detalle de compra antes de eliminarlo
        $detalle = $this->obtenerPorIdDetalle($id);
        if ($detalle) {
            // Actualizar la cantidad del producto en el inventario
            
            $this->revertirCantidadProducto($detalle->getIdProducto(), $detalle->getCantidad());
            
            // Eliminar el detalle de compra
            $this->eliminarDetalle($id);
        }
    }
    public function obtenerPorIdDetalle($id) {
        $sql = "SELECT * FROM detalle_temp WHERE id = $id";
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

    public function obtenerVenta($idVenta){
        $sql = "SELECT * FROM detalle_ventas WHERE id_venta = '".$idVenta."'";
        $rs = $this->ejecutarSQL($sql);
        $result = array();
        while ($fila = $rs->fetch_assoc()) {
            $result[] = $fila;
        }
        return $result;
    }

    public function obtenerTotalPorUsuario($id_usuario) {
        $sql = "SELECT SUM(sub_total) AS Total FROM detalle_temp WHERE id_usuario = $id_usuario";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return $fila['Total'];
    }

    public function vaciarDetalle($idusuario) {
        $sql = "DELETE FROM detalle_temp WHERE id_usuario = '$idusuario'";
        $this->ejecutarSQL($sql);
    }

    public function AnularVenta($id) {
        // Obtener el detalle de la venta
        $detalles = $this->obtenerVenta($id);
        // Revertir las cantidades de los productos
        foreach ($detalles as $detalle) {
            $this->revertirCantidadProducto($detalle['id_producto'], $detalle['cantidad']);
        }
        // Cambiar el estado de la venta a 0
        $this->desactivar($id);
    }

    public function ActualizarEstado($id) {
        $sql = "UPDATE compras SET estado = 0 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }
}

?>
