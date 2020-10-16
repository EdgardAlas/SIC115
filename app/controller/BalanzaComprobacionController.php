<?php
require_once './app/libs/Controller.php';
require_once './app/models/CuentaModel.php';
require_once './app/models/DetallePartidaModel.php';

class BalanzaComprobacionController extends Controller
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
        // $this->validarPeriodo();

        $this->view('balanza-comprobacion', [
            'js_especifico' => Utiles::printScript('balanza-comprobacion'),
        ]);

    }

    public function tablaBalanzaComprobacion()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');
        $conexion = new Conexion();

        $cuenta_model = new CuentaModel($conexion);
        $detalle_partida_model = new DetallePartidaModel($conexion);
        $empresa = $this->sesion->get('login')['id'];
        $periodo = $this->sesion->get('login')['periodo'];

        $condicion = array(
            'fecha_inicial' => date('Y-01-01'),
            'fecha_final' => date('Y-12-31'),
            'nivel' => 1,
            'periodo' => $periodo
        );
        

        if(isset($_POST['fecha_inicial'])){
            $condicion['fecha_inicial'] = $_POST['fecha_inicial'];
        }

        if(isset($_POST['fecha_final'])){
            $condicion['fecha_final'] = $_POST['fecha_final'];
        }

        if(isset($_POST['nivel'])){
            $condicion['nivel'] = $_POST['nivel'];
        }

        $cuentas = $cuenta_model->seleccionar(array('nombre','id','codigo', 'saldo', 'tipo_saldo'), array(
            'empresa' => $empresa,
            'nivel' => $condicion['nivel'],
            'ORDER' => array(
                'orden' => 'ASC'
            )
        ));


        $cuentas = $detalle_partida_model->obtenerDebeHaber($cuentas, $condicion);

        Flight::render('ajax/balanza-comprobacion/tabla-balanza-comprobacion', array(
            'cuentas' => $cuentas
        ));
    }

    
    public function reporteBalanzaComprobacion()
    {
        $this->sesionActiva();
        $this->validarMetodoPeticion('GET');
        $conexion = new Conexion();

        $cuenta_model = new CuentaModel($conexion);
        $detalle_partida_model = new DetallePartidaModel($conexion);
        $empresa = $this->sesion->get('login')['id'];
        $periodo = $this->sesion->get('login')['periodo'];

        $condicion = array(
            'fecha_inicial' => date('Y-01-01'),
            'fecha_final' => date('Y-12-31'),
            'nivel' => 1,
            'periodo' => $periodo
        );
        

        if(isset($_GET['fecha_inicial'])){
            $condicion['fecha_inicial'] = $_GET['fecha_inicial'];
        }

        if(isset($_GET['fecha_final'])){
            $condicion['fecha_final'] = $_GET['fecha_final'];
        }

        if(isset($_GET['nivel'])){
            $condicion['nivel'] = $_GET['nivel'];
        }

        $cuentas = $cuenta_model->seleccionar(array('nombre','id','codigo', 'saldo', 'tipo_saldo'), array(
            'empresa' => $empresa,
            'nivel' => $condicion['nivel'],
            'ORDER' => array(
                'orden' => 'ASC'
            )
        ));


        $cuentas = $detalle_partida_model->obtenerDebeHaber($cuentas, $condicion);

        Flight::render('pdf/balanza-comprobacion', array(
            'datos' => $cuentas,
            'emp' => $this->sesion->get('login')['nombre']
        ));
    }
}
