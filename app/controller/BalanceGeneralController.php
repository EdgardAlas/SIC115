<?php
require_once './app/libs/Controller.php';

class BalanceGeneralController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        
        parent::__construct();
    }

    public function index()
    {
        $his->formaCuenta();
    }

    public function formaCuenta(){
        $this->sesionActiva();
        $this->view('balance-general', ['js_especifico' => Utiles::printScript('balance-general'),]);
    }

    public function formaReporte(){
        $this->sesionActiva();
        $this->view('balance-general', ['js_especifico' => Utiles::printScript('balance-general'),]);
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

    //metodos privados

    
}
