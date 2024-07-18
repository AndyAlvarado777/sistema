<?php
class Proveedor {
    public $id;
    public $nombre;
    public $ruc;
    public $telefono;
    public $direccion;
    public $contacto;
    public $email;
    public $estado;

    public function __construct($id = "", $nombre = "", $ruc = "", $telefono = "", $direccion = "", $contacto = "", $email = "", $estado = 1) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->ruc = $ruc;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->contacto = $contacto;
        $this->email = $email;
        $this->estado = $estado;
    }

    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setRuc($ruc) { $this->ruc = $ruc; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }
    public function setDireccion($direccion) { $this->direccion = $direccion; }
    public function setContacto($contacto) { $this->contacto = $contacto; }
    public function setEmail($email) { $this->email = $email; }
    public function setEstado($estado) { $this->estado = $estado; }

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getRuc() { return $this->ruc; }
    public function getTelefono() { return $this->telefono; }
    public function getDireccion() { return $this->direccion; }
    public function getContacto() { return $this->contacto; }
    public function getEmail() { return $this->email; }
    public function getEstado() { return $this->estado; }
}
?>
