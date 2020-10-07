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
        $this->validarMetodoPeticion('GET');
        $conexion = new Conexion();

        $cuenta_model = new CuentaModel($conexion);
        $detalle_partida_model = new DetallePartidaModel($conexion);
        $empresa = $this->sesion->get('login')['id'];
        $periodo = $this->sesion->get('login')['periodo'];

        $cuentas = $cuenta_model->seleccionar(array('nombre','id','codigo', 'saldo', 'tipo_saldo'), array(
            'empresa' => $empresa,
            'nivel' => 3,
            'ORDER' => array(
                'tipo_saldo' => 'DESC'
            )
        ));

        $cuentas = $detalle_partida_model->obtenerDebeHaber($cuentas, $periodo);

        Flight::render('ajax/balanza-comprobacion/tabla-balanza-comprobacion', array(
            'cuentas' => $cuentas
        ));
    }
}
