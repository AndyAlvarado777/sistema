<?php

class Caja {

    private $id;
    private $caja;
    private $estado;

    public function __construct($id = "", $caja = "", $estado = "") {
        $this->id = $id;
        $this->caja = $caja;
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCaja() {
        return $this->caja;
    }

    public function setCaja($caja) {
        $this->caja = $caja;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
}

?>