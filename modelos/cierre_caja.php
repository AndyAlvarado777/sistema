<?php

class CierreCaja {

    private $id;
    private $id_usuario;
    private $monto_inicial;
    private $monto_final;
    private $fecha_apertura;
    private $fecha_cierre;
    private $total_ventas;
    private $monto_total;
    private $estado;

    public function __construct($id = "", $id_usuario = "", $monto_inicial = "", $monto_final = "", $fecha_apertura = "", $fecha_cierre = "", $total_ventas = "", $monto_total = "", $estado = "") {
        $this->id = $id;
        $this->id_usuario = $id_usuario;
        $this->monto_inicial = $monto_inicial;
        $this->monto_final = $monto_final;
        $this->fecha_apertura = $fecha_apertura;
        $this->fecha_cierre = $fecha_cierre;
        $this->total_ventas = $total_ventas;
        $this->monto_total = $monto_total;
        $this->estado = $estado;
    }
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

    public function getMontoInicial() {
        return $this->monto_inicial;
    }

    public function setMontoInicial($monto_inicial) {
        $this->monto_inicial = $monto_inicial;
    }

    public function getMontoFinal() {
        return $this->monto_final;
    }

    public function setMontoFinal($monto_final) {
        $this->monto_final = $monto_final;
    }

    public function getFechaApertura() {
        return $this->fecha_apertura;
    }

    public function setFechaApertura($fecha_apertura) {
        $this->fecha_apertura = $fecha_apertura;
    }

    public function getFechaCierre() {
        return $this->fecha_cierre;
    }

    public function setFechaCierre($fecha_cierre) {
        $this->fecha_cierre = $fecha_cierre;
    }

    public function getTotalVentas() {
        return $this->total_ventas;
    }

    public function setTotalVentas($total_ventas) {
        $this->total_ventas = $total_ventas;
    }

    public function getMontoTotal() {
        return $this->monto_total;
    }

    public function setMontoTotal($monto_total) {
        $this->monto_total = $monto_total;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
}

?>