<?php
require_once("controladores/conexion.php");

class ProveedoresController extends conexion {
    public function listar() {
        $sql = "SELECT * FROM proveedores";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()) { 
            $resultado[] = new Proveedor(
                $fila["id"],
                $fila["nombre"],
                $fila["ruc"],
                $fila["telefono"],
                $fila["direccion"],
                $fila["contacto"],
                $fila["email"],
                $fila["estado"]
            );
        }
        return $resultado;
    }

    public function mostrarProveedor(){
        $sql = "SELECT * FROM proveedores";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()){ 
            $resultado[] = $fila;
            
        }
        
        return $resultado;
    }

    public function agregar($proveedor) {
        $sql = "INSERT INTO proveedores (nombre, ruc, telefono, direccion, contacto, email)
                VALUES (
                    '".$proveedor->getNombre()."', 
                    '".$proveedor->getRuc()."', 
                    '".$proveedor->getTelefono()."', 
                    '".$proveedor->getDireccion()."', 
                    '".$proveedor->getContacto()."', 
                    '".$proveedor->getEmail()."'
                )";
        $this->ejecutarSQL($sql);
    }

    public function eliminar($id) {
        $sql = "UPDATE proveedores SET estado = 0 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function activar($id) {
        $sql = "UPDATE proveedores SET estado = 1 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM proveedores WHERE id = $id";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return new Proveedor(
            $fila["id"],
            $fila["nombre"],
            $fila["ruc"],
            $fila["telefono"],
            $fila["direccion"],
            $fila["contacto"],
            $fila["email"],
            $fila["estado"]
        );
    }

    public function existeProveedor($ruc, $nombre) {
        $sql = "SELECT COUNT(*) as total FROM proveedores WHERE ruc = '".$ruc."' OR nombre = '".$nombre."'";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return $fila['total'] > 0;
    }

    public function actualizar($proveedor) {
        $sql = "UPDATE proveedores SET 
                    nombre = '".$proveedor->getNombre()."', 
                    ruc = '".$proveedor->getRuc()."', 
                    telefono = '".$proveedor->getTelefono()."', 
                    direccion = '".$proveedor->getDireccion()."', 
                    contacto = '".$proveedor->getContacto()."', 
                    email = '".$proveedor->getEmail()."' 
                WHERE id = '".$proveedor->getId()."'";
        $this->ejecutarSQL($sql);
    }
}
?>
