<?php
abstract class Vehiculo {
    protected string $marca;
    protected string $modelo;
    protected string $color;

    public function __construct(string $marca, string $modelo, string $color) {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->color = $color;
    }

    abstract public function mover();
    abstract public function detener();

    public function obtenerInformacion(): string {
        return "Marca: {$this->marca}, Modelo: {$this->modelo}, Color: {$this->color}";
    }

    public function __toString(): string {
        return $this->obtenerInformacion();
    }

    public function __get(string $name) {
        return $this->$name ?? "Propiedad no accesible o no definida.";
    }
}