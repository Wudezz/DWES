<?php
require_once 'vehiculo.php';
require_once 'Coche.php';
require_once 'Moto.php';
require_once 'Camion.php';
require_once 'Bicicleta.php';
require_once 'Tesla.php';
require_once 'Concesionario.php';
require_once 'vehiculoElectrico.php';

$coche = new Coche("Golf", "GTI", "Azul", 4);
$moto = new Moto("Kawasaki", "Ninja", "Verde", 1000);
$camion = new Camion("Mercedes", "Actros", "Negro", 20.5);
$bicicleta = new Bicicleta("Orbea", "Alma", "Azul");
$tesla = new Tesla("Tesla", "Model S", "Blanco", 4, 75);

$concesionario = new Concesionario();

echo $concesionario->mostrarVehiculo($coche);
echo $concesionario->mostrarVehiculo($moto);
echo $concesionario->mostrarVehiculo($camion);
echo $concesionario->mostrarVehiculo($bicicleta);
echo $concesionario->mostrarVehiculo($tesla);