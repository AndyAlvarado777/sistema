<?php
class Cliente {
    public $id;
    public $dui;
    public $nombre;
    public $telefono;
    public $direccion;
    public $estado;

    public function __construct($id = "", $dui = "", $nombre = "", $telefono = "", $direccion = "", $estado = "") {
        $this->id = $id;
        $this->dui = $dui;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->estado = $estado;
    }

    public function setId($id) { $this->id = $id; }
    public function setDui($dui) { $this->dui = $dui; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }
    public function setDireccion($direccion) { $this->direccion = $direccion; }
    public function seEstado($estado) { $this->estado = $estado; }

    public function getId() { return $this->id; }
    public function getDui() { return $this->dui; }
    public function getNombre() { return $this->nombre; }
    public function getTelefono() { return $this->telefono; }
    public function getDireccion() { return $this->direccion; }
    public function getEstado() { return $this->estado; }
}
?>
