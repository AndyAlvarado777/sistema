
<?php
require_once("controladores/conexion.php");
class Usuarios extends conexion{

    public function Validar($usuario){
        $sql = "SELECT * FROM usuarios WHERE usuario = '".$usuario."' ";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()){ 
            $resultado[] = new User(
            $fila["id"],
            $fila["usuario"],
            $fila["nombre"],
            $fila["clave"],
            $fila["id_rol"],
            $fila["id_caja"],
            $fila["estado"]);
            
        }
        
        return $resultado;
    }

    public function existeUsuario($dui) {
        $sql = "SELECT COUNT(*) as count FROM usuarios WHERE usuario = '".$dui."'";
        $rs = $this->ejecutarSQL($sql);
        if ($rs === false) {
            // Maneja el error en la ejecución de la consulta SQL
            throw new Exception("Error al ejecutar la consulta SQL");
        }
        $fila = $rs->fetch_assoc();
        return $fila['count'] > 0; // Devuelve true si existe, false en caso contrario
    }

    public function listar (){
        $sql = "SELECT u.*, c.id AS idcaja,c.caja FROM usuarios u INNER JOIN caja c WHERE u.id_caja = c.id ";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()){ 
            $resultado[] = new User(
            $fila["id"],
            $fila["usuario"],
            $fila["nombre"],
            $fila["clave"],
            $fila["id_rol"],
            $fila["id_caja"],
            $fila["estado"]);
            
        }
        
        return $resultado;
    }

    public function agregar($usuario){
        $hashedClave = password_hash($usuario->getClave(), PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (usuario, nombre, clave, id_rol, id_caja)
        VALUES ('".$usuario->getUsuario()."', '".$usuario->getNombre()."', '".$hashedClave."','".$usuario->getIdRol()."','".$usuario->getIdCaja()."')";
        $this->ejecutarSQL($sql);
    }

    public function mostrarCaja(){
        $sql = "SELECT * FROM caja";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()){ 
            $resultado[] = $fila;
            
        }
        
        return $resultado;
    }

    public function eliminar($id){ 
        
        
        $sql = "UPDATE usuarios SET estado = 0 WHERE id = '".$id."'";
            $this->ejecutarSQL($sql);
        
    }
    public function Activar($id) {
        $sql = "UPDATE usuarios SET estado = 1 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $rs = $this->ejecutarSQL($sql);
        $usuario = $rs->fetch_assoc();
        return $usuario;
    }
    
    public function actualizar($usuario) {
        $sql = "UPDATE usuarios SET 
                    usuario = '".$usuario->getUsuario()."', 
                    nombre = '".$usuario->getNombre()."', 
                    id_caja = '".$usuario->getIdCaja()."' 
                WHERE id = '".$usuario->getId()."'";
        $this->ejecutarSQL($sql);
    }

    public function actualizarClave($id, $nuevaClave) {
        $hashedClave = password_hash($nuevaClave, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET clave = '$hashedClave' WHERE id = $id";
        $this->ejecutarSQL($sql);
    }
    

    public function verificarClave($id, $clave) {
        $sql = "SELECT clave FROM usuarios WHERE id = $id";
        $rs = $this->ejecutarSQL($sql);
        $usuario = $rs->fetch_assoc();
        
        return password_verify($clave, $usuario['clave']);
    }

    public function actualizarContrasena($nuevaContrasena) {
        // Obtener el ID del usuario de la sesión (suponiendo que $_SESSION['usuario'][0] es el ID del usuario)
        $idUsuario = $_SESSION['usuario'][0];

        // Generar el hash para la nueva contraseña
        $hashNuevaContrasena = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

        // Construir la consulta SQL para actualizar la contraseña
        $sql = "UPDATE usuarios SET clave = '".$hashNuevaContrasena."' WHERE id = '".$idUsuario."'";

        // Ejecutar la consulta SQL utilizando el método ejecutarSQL de tu clase Usuarios
        $this->ejecutarSQL($sql);
    }
    
}



?>