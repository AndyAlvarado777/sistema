<?php
require_once("controladores/conexion.php");
require_once("modelos/Configuracion.php"); // Asegúrate de incluir el archivo del modelo Configuracion

class ConfiguracionController extends conexion {
    public function listar() {
        $sql = "SELECT * FROM configuracion";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Configuracion(
                $fila["id"],
                $fila["ruc"],
                $fila["nombre"],
                $fila["telefono"],
                $fila["direccion"],
                $fila["mensaje"]
            );
        }
        return $resultado;
    }

    public function agregar($configuracion) {
        $sql = "INSERT INTO configuracion (ruc, nombre, telefono, direccion, mensaje)
                VALUES ('".$configuracion->getRuc()."', '".$configuracion->getNombre()."', '".$configuracion->getTelefono()."', '".$configuracion->getDireccion()."', '".$configuracion->getMensaje()."')";
        $this->ejecutarSQL($sql);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM configuracion WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM configuracion WHERE id = $id";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return $fila;  // Ajustado para devolver una matriz asociativa en lugar de un objeto
    }

    public function nombreEmpresa() {
        $sql = "SELECT nombre FROM configuracion ";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return $fila;  // Ajustado para devolver una matriz asociativa en lugar de un objeto
    }

    public function nombreEmpresa2() {
        $sqlTotalVentas = "SELECT * FROM configuracion";
        $rsTotalVentas = $this->ejecutarSQL($sqlTotalVentas);
        $filaTotalVentas = $rsTotalVentas->fetch_assoc();
        return $filaTotalVentas['nombre'];
    }

    public function actualizar($configuracion) {
        $sql = "UPDATE configuracion SET 
                    ruc = '".$configuracion->getRuc()."', 
                    nombre = '".$configuracion->getNombre()."', 
                    telefono = '".$configuracion->getTelefono()."', 
                    direccion = '".$configuracion->getDireccion()."', 
                    mensaje = '".$configuracion->getMensaje()."'
                WHERE id = '".$configuracion->getId()."'";
        $this->ejecutarSQL($sql);
    }
}
?>
