<?php
require_once './app/libs/Controller.php';

class LoginController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        //$this->modelo = new HomeModel($conexion);
    }

    public function index()
    {

        $this->viewOne('login', []);
    }

    public function guardar()
    {

    }

    public function editar()
    {

    }

    public function eliminar()
    {

    }

}
