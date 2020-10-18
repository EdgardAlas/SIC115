<?php
require_once './app/libs/Controller.php';
require_once './app/models/ConfiguracionModel.php';

class ConfiguracionController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        $this->modelo = new ConfiguracioModel($conexion);
        parent::__construct();
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

    public function configuraciones(){
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        $empresa = $this->sesion->get('login')['id'];
        $periodo = $this->sesion->get('login')['periodo'];

        $datos = $this->modelo->conexion()->select('configuracion', array(
            '[><]cuenta' => array('cuenta' => 'id')
        ), array(
            'configuracion.titulo', 'configuracion.descripcion', 'cuenta.nombre', 'cuenta.id', 'cuenta.codigo'
        ), array(
            'cuenta.empresa' => $empresa,
            'configuracion.periodo' => $periodo
        ));
        

        Flight::render('ajax/configuracion/configuraciones', array(
            'datos' => $datos
        ));
    }
}