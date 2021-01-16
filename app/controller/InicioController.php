<?php
require_once './app/libs/Controller.php';
require_once './app/models/HomeModel.php';

class InicioController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        $this->modelo = new HomeModel($conexion);
        parent::__construct();
    }

    public function index()
    {
//        var_dump($this->sesion->get('login'));
        $this->sesionActiva();
        $this->view('inicio', [
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
