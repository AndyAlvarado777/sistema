<?php

class Permisos {

    private $id;
    private $permiso;

    public function __construct($id = null, $nombre = null, $url = null, $icono = null, $permiso = null) {
        $this->id = $id;
        $this->permiso = $permiso;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPermiso() {
        return $this->permiso;
    }

    public function setPermiso($permiso) {
        $this->permiso = $permiso;
    }
}

?>
