<?php

require_once 'vehiculo.php';

class Concesionario {
    public function mostrarVehiculo(Vehiculo $vehiculo): string {
        return $vehiculo->obtenerInformacion();
    }
}