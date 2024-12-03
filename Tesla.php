<?php

require_once 'vehiculo.php';
require_once 'vehiculoElectrico.php';

class Tesla extends Coche implements VehiculoElectrico {
    private int $nivelBateria;

    public function __construct(string $marca, string $modelo, string $color, int $numeroPuertas, int $nivelBateria = 100) {
        parent::__construct($marca, $modelo, $color, $numeroPuertas);
        $this->nivelBateria = $nivelBateria;
    }

    public function cargarBateria() {
        $this->nivelBateria = 100;
        echo "La batería está completamente cargada.";
    }

    public function estadoBateria(): string {
        return "Nivel de batería: {$this->nivelBateria}%";
    }

    public function mover() {
        if ($this->nivelBateria > 0) {
            $this->nivelBateria -= 10;
            echo "El Tesla está avanzando.\n";
        } else {
            echo "La batería está descargada, por favor recargue.";
        }
    }
}