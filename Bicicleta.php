<?php

require_once 'vehiculo.php';

final class Bicicleta extends Vehiculo {
    public function __construct(string $marca, string $modelo, string $color = "Rojo") {
        parent::__construct($marca, $modelo, $color);
    }

    public function pedalear() {
        echo "La bicicleta está en movimiento gracias al pedaleo.\n";
    }

    public function mover() {
        echo "La bicicleta avanza al pedalear.\n";
    }

    public function detener() {
        echo "La bicicleta se ha detenido.\n";
    }

    public function obtenerInformacion(): string {
        return parent::obtenerInformacion();
    }
}