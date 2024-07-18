<?php
require_once("controladores/conexion.php");

class MedidasController extends conexion {
    public function listar() {
        $sql = "SELECT * FROM medidas";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Medidas(
                $fila["id"],
                $fila["nombre"],
                $fila["nombre_corto"],
                $fila["estado"]
            );
        }
        return $resultado;
    }

    public function agregar($sistemaMedida) {
        $sql = "INSERT INTO medidas (nombre, nombre_corto)
                VALUES ('".$sistemaMedida->getNombre()."', '".$sistemaMedida->getNombreCorto()."')";
        $this->ejecutarSQL($sql);
    }

    public function eliminar($id) {
        $sql = "UPDATE medidas SET estado = 0 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function activar($id) {
        $sql = "UPDATE medidas SET estado = 1 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM medidas WHERE id = $id";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return new Medidas(
            $fila["id"],
            $fila["nombre"],
            $fila["nombre_corto"],
            $fila["estado"]
        );
    }

    public function actualizar($sistemaMedida) {
        $sql = "UPDATE medidas SET 
                    nombre = '".$sistemaMedida->getNombre()."', 
                    nombre_corto = '".$sistemaMedida->getNombreCorto()."'
                WHERE id = '".$sistemaMedida->getId()."'";
        $this->ejecutarSQL($sql);
    }
}
?>
