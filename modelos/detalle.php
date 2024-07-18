<?php

class Detalle {

    private $id;
    private $id_producto;
    private $id_usuario;
    private $precio;
    private $cantidad;
    private $sub_total;

    public function __construct($id = "", $id_producto = "", $id_usuario = "", $precio = "", $cantidad = "", $sub_total = "") {
        $this->id = $id;
        $this->id_producto = $id_producto;
        $this->id_usuario = $id_usuario;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
        $this->sub_total = $sub_total;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdProducto() {
        return $this->id_producto;
    }

    public function setIdProducto($id_producto) {
        $this->id_producto = $id_producto;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function getSubTotal() {
        return $this->sub_total;
    }

    public function setSubTotal($sub_total) {
        $this->sub_total = $sub_total;
    }
}

?>