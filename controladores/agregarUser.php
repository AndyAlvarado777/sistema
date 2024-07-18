<?php

require_once('controladores/usuarios_controller.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $clave = $_POST['clave'];
    $id_caja = $_POST['caja'];
    $id_rol = 1; // Asignar un rol por defecto
    $estado = 1; // Estado activo por defecto

    $usuarioObj = new Usuarios();
    
    $usuarioObj->agregar(new User($usuario, $nombre, $clave, $id_rol, $id_caja, $estado));

    echo "Usuario agregado correctamente";
}
?>

