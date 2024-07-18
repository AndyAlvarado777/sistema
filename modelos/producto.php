<?php

class Producto {
    // Propiedades
    private $id;
    private $codigo;
    private $descripcion;
    private $precio_compra;
    private $precio_venta;
    private $cantidad;
    private $id_medida;
    private $id_categoria;
    private $foto;
    private $estado;
    private $id_proveedor;

    // Constructor
    public function __construct($id = "", $codigo = "", $descripcion = "", $precio_compra = "", $precio_venta = "", $cantidad = "", $id_medida = "", $id_categoria = "", $foto = "", $estado = "", $id_proveedor="") {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->descripcion = $descripcion;
        $this->precio_compra = $precio_compra;
        $this->precio_venta = $precio_venta;
        $this->cantidad = $cantidad;
        $this->id_medida = $id_medida;
        $this->id_categoria = $id_categoria;
        $this->foto = $foto;
        $this->estado = $estado;
        $this->id_proveedor = $id_proveedor;
    }

    // Getters y Setters

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getPrecioCompra() {
        return $this->precio_compra;
    }

    public function setPrecioCompra($precio_compra) {
        $this->precio_compra = $precio_compra;
    }

    public function getPrecioVenta() {
        return $this->precio_venta;
    }

    public function setPrecioVenta($precio_venta) {
        $this->precio_venta = $precio_venta;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function getIdMedida() {
        return $this->id_medida;
    }

    public function setIdMedida($id_medida) {
        $this->id_medida = $id_medida;
    }

    public function getIdCategoria() {
        return $this->id_categoria;
    }

    public function setIdCategoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getProveedor() {
        return $this->id_proveedor;
    }

    public function setProveedor($id_proveedor) {
        $this->id_proveedor = $id_proveedor;
    }
}

?>
