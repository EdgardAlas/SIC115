<?php
require_once './app/libs/Controller.php';

class CierreContableController extends Controller
{
    public function __construct($conexion)
    {

    }

    public function index()
    {
        $this->sesionActiva();
        $this->view('cierre-contable', [
            'js_especifico' => Utiles::printScript('cierre-contable')
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