<?php

class DetalleCompra {
    private $id;
    private $id_compra;
    private $id_producto;
    private $cantidad;
    private $precio;
    private $subtotal;

    public function __construct($id_compra, $id_producto, $cantidad, $precio, $subtotal) {
        $this->id_compra = $id_compra;
        $this->id_producto = $id_producto;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
        $this->subtotal = $subtotal;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getIdCompra(){
        return $this->id_compra;
    }

    public function getIdProducto() {
        return $this->id_producto;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setIdCompra($id_compra) {
        $this->id_compra = $id_compra;
    }

    public function setIdProducto($id_producto) {
        $this->id_producto = $id_producto;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }
}


?>