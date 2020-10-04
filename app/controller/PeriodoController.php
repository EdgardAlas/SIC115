<?php
require_once './app/libs/Controller.php';
require_once './app/models/PeriodoModel.php';

class PeriodoController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        $this->modelo = new PeriodoModel($conexion);
        parent::__construct();
    }

    public function index()
    {
        $this->sesionActiva();
        $this->view('periodo', ['js_especifico' => Utiles::printScript('periodo'),]);
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

    public function listaPeriodos(){

        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        $sesion = $this->sesion->get('login');

        $periodo = $sesion['periodo'];
        $empresa = $sesion['id'];

        $lista_periodos = $this->modelo->seleccionar(['estado','anio'], array(
            'empresa' => $empresa
        ));

        Flight::render('ajax/periodo/lista-periodos', array(
            'periodo' => $periodo,
            'periodos' => $lista_periodos
        ));
    }

    //metodos privados

    
}
