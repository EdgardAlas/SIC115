<?php
require_once './app/libs/Controller.php';
require_once './app/models/HomeModel.php';

class HomeController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        $this->modelo = new HomeModel($conexion);
    }

    public function index()
    {

        $datos = [
            'username' => 'y'
        ];

        print_r($this->modelo->validarCampos($datos));

        $this->viewOne('Home', array(
            'inicio' => 'Peraza'
        ));
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
