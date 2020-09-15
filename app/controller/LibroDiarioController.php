<?php
require_once './app/libs/Controller.php';
require_once './app/libs/Controller.php';



class LibroDiarioController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        /* $this->modelo = new HomeModel($conexion); */
    }

    public function index()
    {
        $this->sesionActiva();

        $this->view('libro-diario', [
            'js_especifico' => Utiles::printScript('libro-diario')
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
