<?php

require_once 'vehiculo.php';

class Coche extends Vehiculo {
    private int $numeroPuertas;

    public function __construct(string $marca, string $modelo, string $color, int $numeroPuertas) {
        parent::__construct($marca, $modelo, $color);
        $this->numeroPuertas = $numeroPuertas;
    }

    public function getNumeroPuertas(): int {
        return $this->numeroPuertas;
    }

    public function setNumeroPuertas(int $numeroPuertas): self {
        $this->numeroPuertas = $numeroPuertas;
        return $this;
    }

    public function obtenerInformacion(): string {
        return parent::obtenerInformacion() . ", Número de puertas: {$this->numeroPuertas}";
    }

    public function mover() {
        echo "El coche está avanzando.\n";
    }

    public function detener() {
        echo "El coche se ha detenido.\n";
    }
}