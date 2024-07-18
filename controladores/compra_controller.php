<?php
require_once("controladores/conexion.php");

class CompraController extends conexion {
    public function listar() {
        $sql = "SELECT * FROM compras";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Compra(
                $fila["id"],
                $fila["total"],
                $fila["fecha"],
                $fila["estado"]
            );
        }
        return $resultado;
    }

    public function agregar($compra) {
        $sql = "INSERT INTO compras (total, fecha, estado)
                VALUES ('".$compra->getTotal()."', '".$compra->getFecha()."', '".$compra->getEstado()."')";
        $this->ejecutarSQL($sql);
    }

    

    public function eliminar($id) {
        $sql = "UPDATE compras SET estado = 0 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function activar($id) {
        $sql = "UPDATE compras SET estado = 1 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function obtenerPorId($id) {
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
}
?>
