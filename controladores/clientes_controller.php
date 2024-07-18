<?php
require_once("controladores/conexion.php");
 // Make sure this path is correct

class ClientesController extends conexion {
    public function listar() {
        $sql = "SELECT * FROM clientes";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()) { 
            $resultado[] = new Cliente(
                $fila["id"],
                $fila["dui"],
                $fila["nombre"],
                $fila["telefono"],
                $fila["direccion"],
                $fila["estado"]
            );
        }
        return $resultado;
    }

    public function existeCliente($dui) {
        $sql = "SELECT COUNT(*) as count FROM clientes WHERE dui = '".$dui."'";
        $rs = $this->ejecutarSQL($sql);
        if ($rs === false) {
            // Maneja el error en la ejecución de la consulta SQL
            throw new Exception("Error al ejecutar la consulta SQL");
        }
        $fila = $rs->fetch_assoc();
        return $fila['count'] > 0; // Devuelve true si existe, false en caso contrario
    }

    public function agregar($cliente) {
        $sql = "INSERT INTO clientes (dui, nombre, telefono, direccion)
                VALUES ('".$cliente->getDui()."', '".$cliente->getNombre()."', '".$cliente->getTelefono()."', '".$cliente->getDireccion()."')";
        $this->ejecutarSQL($sql);
    }

    public function eliminar($id) {
        $sql = "UPDATE clientes SET estado = 0 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }
    public function Activar($id) {
        $sql = "UPDATE clientes SET estado = 1 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM clientes WHERE id = $id";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return new Cliente(
            $fila["id"],
            $fila["dui"],
            $fila["nombre"],
            $fila["telefono"],
            $fila["direccion"],
            $fila["estado"]
        );
    }

    

    public function actualizar($cliente) {
        $sql = "UPDATE clientes SET 
                    
                    nombre = '".$cliente->getNombre()."', 
                    telefono = '".$cliente->getTelefono()."', 
                    direccion = '".$cliente->getDireccion()."' 
                WHERE id = '".$cliente->getId()."'";
        $this->ejecutarSQL($sql);
    }
    
}
?>
