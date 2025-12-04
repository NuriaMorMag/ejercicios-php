<?php

// ---------------------------------------------------------
// 1. CLASE MODELO (Entidad)
// ---------------------------------------------------------
class Producto {
    public $id;
    public $nombre;
    public $precio;
    public $stock;

    // Método auxiliar para mostrar info
    public function info() {
        return "[ID: {$this->id}] {$this->nombre} - Precio: {$this->precio}$ (Stock: {$this->stock})";
    }
}
?>