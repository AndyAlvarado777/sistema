<?php
class User {
    public $id;
    public $usuario;
    public $nombre;
    public $clave;
    public $id_rol;
    public $id_caja;
    public $estado;

    // Constructor
    public function __construct($id = "", $usuario = "", $nombre = "", $clave = "", $id_rol = "", $id_caja = "", $estado = "") {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->id_rol = $id_rol;
        $this->id_caja = $id_caja;
        $this->estado = $estado;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getClave() {
        return $this->clave;
    }

    public function getIdRol() {
        return $this->id_rol;
    }

    public function getIdCaja() {
        return $this->id_caja;
    }

    public function getEstado() {
        return $this->estado;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }

    public function setIdRol($id_rol) {
        $this->id_rol = $id_rol;
    }

    public function setIdCaja($id_caja) {
        $this->id_caja = $id_caja;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
}
?>
