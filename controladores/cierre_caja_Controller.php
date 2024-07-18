<?php
require_once("controladores/conexion.php");

class CierreCaja_controller extends conexion {
    public function listar() {
        $sql = "SELECT * FROM cierre_caja";
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

    public function MontoInicial($id_usuario) {
        $sql = "SELECT * FROM cierre_caja WHERE id_usuario = $id_usuario AND estado = 1";
        $rs = $this->ejecutarSQL($sql);
        $dato = $rs->fetch_assoc();
        return $dato["monto_inicial"];
    }

    public function montoTotal($id_usuario){
        $id_usuario = $id_usuario;
            $sqlMontoTotal = "SELECT SUM(total) AS monto_total FROM ventas WHERE id_usuario = '$id_usuario' AND estado = 1 AND apertura = 1";
            $rsMontoTotal = $this->ejecutarSQL($sqlMontoTotal);
            $filaMontoTotal = $rsMontoTotal->fetch_assoc();
            return $filaMontoTotal['monto_total'];
    }

    public function TotalVentas($id_usuario) {
            $sqlTotalVentas = "SELECT COUNT(*) AS total_ventas FROM ventas WHERE id_usuario = '$id_usuario' AND estado = 1 AND apertura = 1";
            $rsTotalVentas = $this->ejecutarSQL($sqlTotalVentas);
            $filaTotalVentas = $rsTotalVentas->fetch_assoc();
            return $filaTotalVentas['total_ventas'];
    }

    public function agregar($cierreCaja) {
        // Verifica si ya existe un registro con id_usuario y estado 1
        $verificar = "SELECT * FROM cierre_caja WHERE id_usuario = '".$cierreCaja->getIdUsuario()."' AND estado = 1";
        $result = $this->ejecutarSQL($verificar);

        if ($result->num_rows > 0) {
            // Si ya existe un registro con estado 1, retorna un mensaje de error
            echo ("Ya existe un registro activo para este usuario.");
        } else {
            // Obtiene el monto_total y total_ventas
            $id_usuario = $cierreCaja->getIdUsuario();
            $sqlMontoTotal = "SELECT SUM(total) AS monto_total FROM ventas WHERE id_usuario = '$id_usuario' AND estado = 1 AND apertura = 1";
            $rsMontoTotal = $this->ejecutarSQL($sqlMontoTotal);
            $filaMontoTotal = $rsMontoTotal->fetch_assoc();
            $monto_total = $filaMontoTotal['monto_total'];

            $sqlTotalVentas = "SELECT COUNT(*) AS total_ventas FROM ventas WHERE id_usuario = '$id_usuario' AND estado = 1 AND apertura = 1";
            $rsTotalVentas = $this->ejecutarSQL($sqlTotalVentas);
            $filaTotalVentas = $rsTotalVentas->fetch_assoc();
            $total_ventas = $filaTotalVentas['total_ventas'];

            // Si no existe un registro activo, procede con la inserción del nuevo registro
            $sql = "INSERT INTO cierre_caja (id_usuario, monto_inicial, monto_final, fecha_apertura, fecha_cierre, total_ventas, monto_total)
                    VALUES (
                        '".$cierreCaja->getIdUsuario()."', 
                        '".$cierreCaja->getMontoInicial()."', 
                        '".$cierreCaja->getMontoFinal()."', 
                        '".$cierreCaja->getFechaApertura()."', 
                        '".$cierreCaja->getFechaCierre()."', 
                        '$total_ventas', 
                        '$monto_total')";
            $this->ejecutarSQL($sql);
        }
    }

    public function actualizarMontos($id_usuario) {
        // Recalcula el monto_total y total_ventas para el usuario
        $sqlMontoTotal = "SELECT SUM(total) AS monto_total FROM ventas WHERE id_usuario = '$id_usuario' AND estado = 1";
        $rsMontoTotal = $this->ejecutarSQL($sqlMontoTotal);
        $filaMontoTotal = $rsMontoTotal->fetch_assoc();
        $monto_total = $filaMontoTotal['monto_total'];

        $sqlTotalVentas = "SELECT COUNT(*) AS total_ventas FROM ventas WHERE id_usuario = '$id_usuario' AND estado = 1";
        $rsTotalVentas = $this->ejecutarSQL($sqlTotalVentas);
        $filaTotalVentas = $rsTotalVentas->fetch_assoc();
        $total_ventas = $filaTotalVentas['total_ventas'];

        // Actualiza los campos en la tabla cierre_caja
        $sqlActualizar = "UPDATE cierre_caja SET 
                            total_ventas = '$total_ventas', 
                            monto_total = '$monto_total'
                          WHERE id_usuario = '$id_usuario' AND estado = 1";
        $this->ejecutarSQL($sqlActualizar);
    }

    public function eliminar($id) {
        $sql = "UPDATE cierre_caja SET estado = 0 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function activar($id) {
        $sql = "UPDATE cierre_caja SET estado = 1 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
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

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM cierre_caja WHERE id_usuario = $id";
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

    public function actualizar($cierreCaja) {
        $sql = "UPDATE cierre_caja SET 
                    
                    
                    monto_final = '".$cierreCaja->getMontoFinal()."',
                    fecha_cierre = '".$cierreCaja->getFechaCierre()."',
                    total_ventas = '".$cierreCaja->getTotalVentas()."',
                    monto_total = '".$cierreCaja->getMontoTotal()."',
                    estado = 0
                WHERE id = '".$cierreCaja->getId()."'";
        $this->ejecutarSQL($sql);
    }

    public function cerrarCaja($id_usuario,$montoinial, $monto_final, $fecha_cierre) {
        // Obtener el total de ventas y monto total
        $total_ventas = $this->TotalVentas($id_usuario);
        
        $montoTotal = $montoinial + $monto_final;
    
        // Actualizar la tabla cierre_caja
        $sql = "UPDATE cierre_caja SET 
                    monto_final = '$monto_final', 
                    fecha_cierre = '$fecha_cierre', 
                    total_ventas = '$total_ventas', 
                    monto_total = '$montoTotal', 
                    estado = 0 
                WHERE id_usuario = '$id_usuario' AND estado = 1";
        $this->ejecutarSQL($sql);
    
        // Cambiar el estado de apertura de las ventas
        $sql = "UPDATE ventas SET apertura = 0,estado=0 WHERE id_usuario = '$id_usuario' AND estado = 1";
        $this->ejecutarSQL($sql);
    }
    
}
?>
