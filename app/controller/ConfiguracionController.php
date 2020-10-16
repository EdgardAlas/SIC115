<?php
require_once './app/libs/Controller.php';
/* require_once './app/models/HomeModel.php'; */

class ConfiguracionController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        /* $this->modelo = new HomeModel($conexion); */
    }

    public function index()
    {
        $this->sesionActiva();
        $this->view('configuracion', [
            'js_especifico' => Utiles::printScript('configuracion')
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
