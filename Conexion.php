<?php

use Medoo\Medoo;

class Conexion
{
    private $tipo;
    private $bd;
    private $server;
    private $usuario;
    private $contrasena;
    private $baseDeDatos;

    public function __construct()
    {
        $this->tipo = "mysql";
        $this->bd = "sic175";
        $this->server = "localhost";
        $this->usuario = "root";
        $this->contrasena = "";
        try {
            $this->conectar();
        } catch (\Throwable $th) {
            flight::error(new Exception('Error al conectar a la base de datos'));
            exit();
        }
    }

    private function conectar()
    {
        $this->baseDeDatos = new Medoo([
            'database_type' => $this->tipo,
            'database_name' => $this->bd,
            'server' => $this->server,
            'username' => $this->usuario,
            'password' => $this->contrasena,
        ]);
    }

    public function obtenerConexion()
    {
        return $this->baseDeDatos;
    }
}
