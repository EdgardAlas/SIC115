<?php
require_once './app/libs/Controller.php';
require_once './app/models/PartidaModel.php';
require_once './app/models/CuentaModel.php';
require_once './app/models/DetallePartidaModel.php';

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
        $test = $this->sesion->get('login');
        $test['periodo'] = null;

        $this->sesion->set('login', $test);

        $this->sesionActiva();
        $this->validarPeriodo();

        $this->view('libro-diario', [
            'js_especifico' => Utiles::printScript('libro-diario'),
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
        $detalle_partida_model = new DetallePartidaModel($conexion);

        if (!isset($_POST['partida'])) {
            Exepcion::generarExcepcion('No hay datos para guardar');
        }

        $empresa = $this->sesion->get('login')['id'];
        $periodo = $this->sesion->get('login')['periodo'];
        $numero = $partida_model->generarNumeroPartida($empresa, $periodo);

        $_POST['partida']['datos_partida']['numero'] = $numero;
        $_POST['partida']['datos_partida']['periodo'] = $periodo;

        $id_partida = $partida_model->insertar($_POST['partida']['datos_partida']);

        if ($id_partida !== null) {
            $detalles = isset(
                $_POST['partida']['detalle_partida'])
            ? $_POST['partida']['detalle_partida']
            : array();

            foreach ($detalles as $key => $detalle) {
                $detalle['partida'] = $id_partida;
                $detalle['cuenta'] = base64_decode($detalle['cuenta']);
                $codigo = ($detalle['codigo']);

                //Monto que se va a actualizar en las cuentas de mayor
                $monto_acumlado = $detalle['monto'];

                $detalle['monto'] = abs($detalle['monto']);

                unset($detalle['codigo']);

                var_dump($detalle);

                $detalle_partida_model->insertar($detalle);

                $cuentas_acumular = $cuenta_model->codigoSiguiente($codigo);

                var_dump($cuentas_acumular);

                foreach ($cuentas_acumular as $key => $cuenta) {
                    $cuenta_model->actualizar(array(
                        'saldo[+]' => $monto_acumlado,
                    ), array(
                        'codigo' => $cuenta,
                        'empresa' => $empresa,
                    ));
                }
            }
            Exepcion::json(['error' => false, 'mensaje' => 'Partida creada con exito']);
        }
        Exepcion::json(['error' => true, 'mensaje' => 'Error al crear la partida']);

    }

    public function tablaLibroDiario(){
        $this->isAjax();
        $this->sesionActivaAjax();
        //$this->validarMetodoPeticion('GET');

        $conexion = new Conexion();
        $detalle_partida_model = new DetallePartidaModel($conexion);

        $login = $this->sesion->get('login');

        $fecha_inicial = (isset($_POST['fecha_inicial'])) ? $_POST['fecha_inicial'] : date('Y-01-01');
        $fecha_final = (isset($_POST['fecha_final'])) ? $_POST['fecha_final'] : date('Y-12-31');
        $numero = (isset($_POST['numero'])) ? $_POST['numero'] : 0;
        

        $condicion = array(
            'empresa' => $login['id'],
            'periodo' => $login['periodo'],
            'fecha_inicial' => $fecha_inicial,
            'fecha_final' => $fecha_final,
            'numero' => $numero
        );

        $datos = $detalle_partida_model->obtenerLibroDiario($condicion);

        Flight::render('ajax/libro-diario/tabla-libro-diario', array(
            'datos' => $datos
        ));
    }

    public function test()
    {
        $conexion = new Conexion();
        $detalle_partida_model = new DetallePartidaModel($conexion);
        $data = $detalle_partida_model->obtenerLibroDiario();
        //Exepcion::json($this->eliminarDuplicados($data));
        echo array_count_values(array_column($data, 'numero'))[5];
    }

    /*  public function eliminarDuplicados($arreglo){
    foreach ($arreglo as $key => $value) {
    foreach ($value as $eliminar => $valor) {
    if(is_numeric($eliminar)){
    unset($arreglo[$key][$eliminar]);
    }
    }
    }
    return $arreglo;
    } */

    public function editar()
    {

    }

    public function eliminar()
    {

    }

    public function tablaDetalle()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        if (!isset($_POST['tabla_detalle'])) {
            $_POST['tabla_detalle'] = array();
        }

        $detalles = $_POST['tabla_detalle'];

        Flight::render('ajax/libro-diario/tabla-detalle-partida', array(
            'datos' => $_POST['tabla_detalle'],
        ));
    }

}
