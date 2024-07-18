<?php

class Medidas {

    public $id;
    public $nombre;
    public $nombreCorto;
    public $estado;

    public function __construct($id = "", $nombre = "", $nombreCorto = "", $estado = "") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->nombreCorto = $nombreCorto;
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getNombreCorto() {
        return $this->nombreCorto;
    }

    public function setNombreCorto($nombreCorto) {
        $this->nombreCorto = $nombreCorto;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
}

?>
