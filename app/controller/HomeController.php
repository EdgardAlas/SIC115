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

        $this->view('content_blank', [
            'js_especifico' => Utiles::printScript('home')
        ]);
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
