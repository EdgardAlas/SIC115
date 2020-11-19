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
        $this->sesionActiva();
        $this->validarPeriodo();

        $this->view('libro-diario', [
            'js_especifico' => Utiles::printScript('libro-diario'),
        ], [
            'estado' => $this->sesion->get('login')['estado'],
            'anio' => $this->sesion->get('login')['anio']
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
            Excepcion::generarExcepcion('No hay datos para guardar');
        }

        $empresa = $this->sesion->get('login')['id'];
        $periodo = $this->sesion->get('login')['periodo'];
        $numero = $partida_model->generarNumeroPartida($empresa, $periodo);

        $_POST['partida']['datos_partida']['numero'] = $numero;
        $_POST['partida']['datos_partida']['periodo'] = $periodo;

        $id_partida = $partida_model->insertar($_POST['partida']['datos_partida']);

        $partida_exito = true;
        $reestablecer_saldos = array();
        $cuenta_reestablecer = '';

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

                $detalle_partida_model->insertar($detalle);

                $cuentas_acumular = $cuenta_model->codigoSiguiente($codigo);

                $saldo_cueta_acumular = 0;

                foreach ($cuentas_acumular as $key => $cuenta) {

                    $cuenta_base = $cuenta_model->seleccionar(
                        array('nombre', 'saldo', 'tipo_saldo'), array(
                            'codigo' => $cuenta,
                            'empresa' => $empresa,
                            'periodo' => $periodo
                        )
                    );

                    $cuenta_base = $cuenta_base[0];

                    $es_R = strpos($cuenta, 'R');

                    if ($es_R > 0) {
                        $monto_acumlado = $monto_acumlado < 0 ? (abs($monto_acumlado)) : -$monto_acumlado;
                    }

                    //validar los saldos
                    if ($monto_acumlado < $cuenta_base['saldo'] && $cuenta_base['saldo'] < abs($monto_acumlado)) {
                        $partida_exito = false;
                        $cuenta_reestablecer = $cuenta . ' - ' . $cuenta_base['nombre'];
                        break;
                    }

                    //por si falla

                    $reestablecer_saldos[] = array(
                        'codigo' => $cuenta,
                        'empresa' => $empresa,
                        'saldo' => $monto_acumlado < 0 ? (abs($monto_acumlado)) : -$monto_acumlado,
                    );

                    $cuenta_model->actualizar(array(
                        'saldo[+]' => $monto_acumlado,
                    ), array(
                        'codigo' => $cuenta,
                        'empresa' => $empresa,
                        'periodo' => $periodo
                    ));

                    if ($es_R > 0) {
                        $monto_acumlado = $monto_acumlado < 0 ? (abs($monto_acumlado)) : -$monto_acumlado;
                    }
                }

                if (!$partida_exito) {
                    break;
                }
            }

            if (!$partida_exito) {

                foreach ($reestablecer_saldos as $key => $cuentas) {
                    $cuenta_model->actualizar(
                        array(
                            'saldo[+]' => $cuentas['saldo'],
                        ), array(
                            'codigo' => $cuentas['codigo'],
                            'empresa' => $cuentas['empresa'],
                        )
                    );
                }

                //eliminar los registros que se crearon

                $detalle_partida_model->eliminar(array(
                    'partida' => $id_partida,
                ));

                $partida_model->eliminar(array(
                    'id' => $id_partida,
                ));

                Excepcion::json([
                    'error' => true,
                    'mensaje' => 'Saldo insuficiente en la cuenta ' . $cuenta_reestablecer
                ]);
            }

            Excepcion::json(['error' => false, 'mensaje' => 'Partida creada con exito']);
        }
        Excepcion::json(['error' => true, 'mensaje' => 'Error al crear la partida']);

    }

    public function tablaLibroDiario()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        //$this->validarMetodoPeticion('GET');

        $conexion = new Conexion();
        $detalle_partida_model = new DetallePartidaModel($conexion);

        $login = $this->sesion->get('login');

        $fecha_inicial = (isset($_POST['fecha_inicial']))
            ? $_POST['fecha_inicial']
            : date($login['anio'] . '-01-01');

        $fecha_final = (isset($_POST['fecha_final']))
            ? $_POST['fecha_final']
            : date($login['anio'] . '-12-31');

        $numero = (isset($_POST['numero']))
            ? $_POST['numero']
            : array('');

        $codigo = (isset($_POST['codigo'])
            ? base64_decode($_POST['codigo'])
            : null);

        $condicion = array(
            'empresa' => $login['id'],
            'periodo' => $login['periodo'],
            'fecha_inicial' => $fecha_inicial,
            'fecha_final' => $fecha_final,
            'numero' => $numero,
        );

        $datos = $detalle_partida_model->obtenerLibroDiario($condicion);

        Flight::render('ajax/libro-diario/tabla-libro-diario', array(
            'datos' => $datos,
            'codigo' => $codigo,
        ));
    }

    public function reporteLibroDiario()
    {
        $this->sesionActiva();
        $this->sesionActivaAjax();
        //$this->validarMetodoPeticion('GET');

        $conexion = new Conexion();
        $detalle_partida_model = new DetallePartidaModel($conexion);

        $login = $this->sesion->get('login');

        $fecha_inicial = (isset($_GET['fecha_inicial']))
            ? $_GET['fecha_inicial']
            : date($login['anio'] . '-01-01');

        $fecha_final = (isset($_GET['fecha_final']))
            ? $_GET['fecha_final']
            : date($login['anio'] . '-12-31');
        
        $numero = (isset($_GET['numero'])) ? explode(',', $_GET['numero']) : array('');

        $condicion = array(
            'empresa' => $login['id'],
            'periodo' => $login['periodo'],
            'fecha_inicial' => $fecha_inicial,
            'fecha_final' => $fecha_final,
            'numero' => $numero,
        );

        $datos = $detalle_partida_model->obtenerLibroDiario($condicion);

        Flight::render('pdf/libro-diario', array(
            'datos' => $datos,
            'emp' => $login['nombre'],
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
