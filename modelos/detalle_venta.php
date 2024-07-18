<?php

class DetalleVenta {

    private $id;
    private $idVenta;
    private $idProducto;
    private $cantidad;
    private $precio;
    private $subTotal;

    public function __construct($idVenta, $idProducto, $cantidad, $precio, $subTotal) {
       
        $this->idVenta = $idVenta;
        $this->idProducto = $idProducto;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
        $this->subTotal = $subTotal;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdVenta() {
        return $this->idVenta;
    }

    public function setIdVenta($idVenta) {
        $this->idVenta = $idVenta;
    }

    public function getIdProducto() {
        return $this->idProducto;
    }

    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getSubTotal() {
        return $this->subTotal;
    }

    public function setSubTotal($subTotal) {
        $this->subTotal = $subTotal;
    }
}

?>