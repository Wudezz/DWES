<?php

require_once 'vehiculo.php';

class Camion extends Vehiculo {
    private float $capacidadCarga;

    public function __construct(string $marca, string $modelo, string $color, float $capacidadCarga) {
        parent::__construct($marca, $modelo, $color);
        $this->capacidadCarga = $capacidadCarga;
    }

    public function getCapacidadCarga(): float {
        return $this->capacidadCarga;
    }

    public function setCapacidadCarga(float $capacidadCarga): self {
        $this->capacidadCarga = $capacidadCarga;
        return $this;
    }

    public function obtenerInformacion(): string {
        return parent::obtenerInformacion() . ", Capacidad de carga: {$this->capacidadCarga} toneladas";
    }

    public function mover() {
        echo "El camión está avanzando.\n";
    }

    public function detener() {
        echo "El camión se ha detenido.\n";
    }
}