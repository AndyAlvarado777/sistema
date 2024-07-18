<?php

class Configuracion {
    private $id;
    private $ruc;
    private $nombre;
    private $telefono;
    private $direccion;
    private $mensaje;

    public function __construct($id = "", $ruc = "", $nombre = "", $telefono = "", $direccion = "", $mensaje = "") {
        $this->id = $id;
        $this->ruc = $ruc;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->mensaje = $mensaje;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getRuc() {
        return $this->ruc;
    }

    public function setRuc($ruc) {
        $this->ruc = $ruc;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }
}

?>