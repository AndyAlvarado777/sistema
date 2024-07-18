<?php

class detalle_permisos {

    private $id;
    private $id_usuario;
    private $id_permiso;

    public function __construct($id = "", $id_usuario = "", $id_permiso = "") {
        $this->id = $id;
        $this->id_usuario = $id_usuario;
        $this->id_permiso = $id_permiso;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function getIdPermiso() {
        return $this->id_permiso;
    }

    public function setIdPermiso($id_permiso) {
        $this->id_permiso = $id_permiso;
    }
}

?>