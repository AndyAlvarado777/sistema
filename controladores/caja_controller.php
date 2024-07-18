<?php
require_once("controladores/conexion.php");

class Caja_controller extends conexion {
    public function listar() {
        $sql = "SELECT * FROM caja";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()) { 
            $resultado[] = new Caja(
                $fila["id"],
                $fila["caja"],
                $fila["estado"]
            );
        }
        return $resultado;
    }

    public function agregar($caja) {
        $sql = "INSERT INTO caja (caja)
                VALUES ('".$caja->getCaja()."')";
        $this->ejecutarSQL($sql);
    }

    public function eliminar($id) {
        $sql = "UPDATE caja SET estado = 0 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function activar($id) {
        $sql = "UPDATE caja SET estado = 1 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM caja WHERE id = $id";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return new Caja(
            $fila["id"],
            $fila["caja"],
            $fila["estado"]
        );
    }

    public function actualizar($caja) {
        $sql = "UPDATE caja SET 
                    caja = '".$caja->getCaja()."'
                WHERE id = '".$caja->getId()."'";
        $this->ejecutarSQL($sql);
    }
}
?>
