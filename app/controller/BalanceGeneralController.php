<?php
require_once './app/libs/Controller.php';
require_once './app/models/CuentaModel.php';

class BalanceGeneralController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {

        parent::__construct();
    }

    public function index()
    {
        $this->view('balance-general', ['js_especifico' => Utiles::printScript('balance-general')]);
    }

    public function forma($forma)
    {
        $this->sesionActiva();
        if(strlen($forma)==0){
            Exepcion::noEncontrado();
        }
        $forma = strtolower($forma);

        $formas = array('cuenta', 'reporte');

        if(!in_array($forma, $formas)){
            Exepcion::noEncontrado();
        }

        $this->view('balance-general', ['js_especifico' => Utiles::printScript('balance-general-'.$forma)], ['forma' => 'Forma de ' . ucfirst($forma)]);
    }

    public function balanceFormaReporte()
    {
        $this->sesionActiva();
        $this->view('balance-general', ['js_especifico' => Utiles::printScript('balance-general'),]);
    }

    public function formaCuenta(){
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        $conexion = new Conexion();
        $cuenta_model = new CuentaModel($conexion);

        $empresa = $this->sesion->get('login')['id'];
        $periodo = $this->sesion->get('login')['periodo'];

        $cuentas_configuracion = $cuenta_model->conexion()->select('cuenta', array(
            '[><]configuracion' => array('id' => 'cuenta'),
            '[><]periodo' => array('configuracion.periodo' => 'id'),
            '[><]empresa' => array('periodo.empresa' => 'id')
        ), array(
            'codigo', 'cuenta.nombre', 'titulo', 'descripcion', 'saldo', 'tipo_saldo', 'nivel', 'orden'
        ), array(
            'nivel' => array(1,2,3),
            'titulo' => array('clasificacion'),
            'descripcion' => array('activo', 'pasivo', 'patrimonio'),
            'empresa.id' => $empresa,
            'periodo.id' => $periodo
        ));


        foreach ($cuentas_configuracion as $key => $cuenta) {
            $sub_cuentas = $cuenta_model->seleccionar(array(
                'codigo', 'nombre', 'saldo', 'tipo_saldo', 'nivel', 'orden'
            ), array(
                'orden' => $cuenta['orden'],
                'nivel' => array(2,3),
                'empresa' => $empresa,
                'ORDER' => array(
                    'codigo' => 'ASC'
                )
            ));


            $cuentas_configuracion[$key]['subcuentas'] = $sub_cuentas;

        }
        

        Flight::render('ajax/balance-general/balance-cuenta', array(
            'datos' => $cuentas_configuracion
        ));

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
