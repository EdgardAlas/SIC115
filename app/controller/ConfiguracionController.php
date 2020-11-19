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
        $this->validarPeriodo();

        $this->view('configuracion', [
            'js_especifico' => Utiles::printScript('configuracion')
        ]);
    }

    public function guardar()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $periodo = $this->sesion->get('login')['periodo'];

        //eliminar la configuracion antigua
        $this->modelo->eliminar(array(
            'periodo' => $periodo
        ));

        $configuraciones = isset($_POST['configuraciones']) ? $_POST['configuraciones'] : array();

        foreach ($configuraciones as $key => $configuracion) {
            $configuraciones[$key]['periodo'] = $periodo;
            $configuraciones[$key]['cuenta'] = base64_decode($configuracion['cuenta']);
        }


        $resultado_guardar = $this->modelo->insertar($configuraciones);

        if ($resultado_guardar !== null) {
            Excepcion::json(['error' => false, 'mensaje' => 'Configuración guardada', 'icono' => 'success']);
        }

        Excepcion::json([
            'error' => true,
            'mensaje' => 'Error al guardar configuración',
            'icono' => 'warning',
            'e' => $this->modelo->error()
        ]);

        /* Exepcion::json($configuraciones); */

    }

    public function editar()
    {

    }

    public function eliminar()
    {

    }

    public function configuraciones()
    {
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
