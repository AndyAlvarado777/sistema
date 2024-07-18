<?php

class Venta {
    // Propiedades
    private $id;
    private $id_usuario;
    private $id_cliente;
    private $total;
    private $fecha;
    private $hora;
    private $estado;
    private $apertura;

    // Constructor
    public function __construct($id = "", $id_usuario = "", $id_cliente = "", $total= "", $fecha= "", $hora= "", $estado= "", $apertura= "") {
        $this->id = $id;
        $this->id_usuario = $id_usuario;
        $this->id_cliente = $id_cliente;
        $this->total = $total;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->estado = $estado;
        $this->apertura = $apertura;
    }

    // Getters y Setters

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

    public function getIdCliente() {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente) {
        $this->id_cliente = $id_cliente;
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

    public function getHora() {
        return $this->hora;
    }

    public function setHora($hora) {
        $this->hora = $hora;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getApertura() {
        return $this->apertura;
    }

    public function setApertura($apertura) {
        $this->apertura = $apertura;
    }
}

?>
