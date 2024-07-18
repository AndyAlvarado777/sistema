<?php
require_once("controladores/conexion.php");

class Categoria_controller extends conexion {
    public function listar() {
        $sql = "SELECT * FROM categorias";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()) { 
            $resultado[] = new Categorias(
                $fila["id"],
                $fila["nombre"],
                $fila["estado"]
            );
        }
        return $resultado;
    }

    public function agregar($cliente) {
        $sql = "INSERT INTO categorias (nombre)
                VALUES ('".$cliente->getNombre()."')";
        $this->ejecutarSQL($sql);
    }

    public function eliminar($id) {
        $sql = "UPDATE categorias SET estado = 0 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function activar($id) {
        $sql = "UPDATE categorias SET estado = 1 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM categorias WHERE id = $id";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return new Categorias(
            $fila["id"],
            $fila["nombre"],
            $fila["estado"]
        );
    }

    public function actualizar($cliente) {
        $sql = "UPDATE categorias SET 
                    nombre = '".$cliente->getNombre()."', 
                    estado = '".$cliente->getEstado()."'
                WHERE id = '".$cliente->getId()."'";
        $this->ejecutarSQL($sql);
    }
}
?>
