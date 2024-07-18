<?php

class Compra {
  private $id;
  private $total;
  private $fecha;
  private $estado;

  public function __construct($id = "", $total = "", $fecha = "", $estado = "") {
    $this->id = $id;
    $this->total = $total;
    $this->fecha = $fecha;
    $this->estado = $estado;
}
  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getTotal() {
    return $this->total;
  }

  public function setTotal($total) {
    $this->total = $total;
  }

  public function getFecha() {
    return $this->fecha;
  }

  public function setFecha($fecha) {
    $this->fecha = $fecha;
  }

  public function getEstado() {
    return $this->estado;
  }

  public function setEstado($estado) {
    $this->estado = $estado;
  }
}
?>