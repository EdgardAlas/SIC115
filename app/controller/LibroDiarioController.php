<?php
require_once './app/libs/Controller.php';
require_once './app/models/PartidaModel.php';
require_once './app/models/CuentaModel.php';



class LibroDiarioController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        /* $this->modelo = new HomeModel($conexion); */
        parent::__construct();
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
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $conexion = new Conexion();

        $cuenta_model = new CuentaModel($conexion);
        $partida_model = new PartidaModel($conexion);

        if(!isset($_POST['partida'])){
            Exepcion::generarExcepcion('No hay datos para guardar');
        }

        $empresa = $this->sesion->get('login')['id'];
        $periodo = $this->sesion->get('login')['periodo'];
        $numero = $partida_model->generarNumeroPartida($empresa, $periodo);

        $_POST['partida']['datos_partida']['numero'] = $numero;
        $_POST['partida']['datos_partida']['periodo'] = $periodo;

        var_dump($_POST['partida']['datos_partida']['numero']);

    }

    public function editar()
    {

    }

    public function eliminar()
    {

    }

    public function tablaDetalle(){
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');
        

        if(!isset($_POST['tabla_detalle'])){
            $_POST['tabla_detalle'] = array();
        }

        $detalles = $_POST['tabla_detalle'];

        Flight::render('ajax/libro-diario/tabla-detalle-partida', array(
            'datos' => $_POST['tabla_detalle']
        ));
    }

}
