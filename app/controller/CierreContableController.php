<?php
require_once './app/libs/Controller.php';
require_once './app/models/PeriodoModel.php';
require_once './app/models/CuentaModel.php';
require_once './app/models/EmpresaModel.php';
require_once './app/models/PartidaModel.php';
require_once './app/models/DetallePartidaModel.php';
require_once './app/models/ConfiguracionModel.php';

class CierreContableController extends Controller
{
    public function __construct($conexion)
    {
        parent::__construct();
    }

    public function index()
    {
        $this->sesionActiva();

        $estado = $this->sesion->get('login')['estado'];

        $this->sesion->set('partidas', null);
        $this->sesion->set('cuentas', null);

        if ($estado === 'CIERRE') {
            $this->view('cierre-contable', [
                'js_especifico' => Utiles::printScript('cierre-contable')
            ]);
            exit();
        }

        $this->view('iniciar-cierre', [
            'js_especifico' => Utiles::printScript('realizar-cierre')
        ]);

    }

    public function validarCierre()
    {
        if (!isset($_POST['cierre'])) {
            Excepcion::json([
                'error' => true,
                'mensaje' => 'Error al empezar con el cierre',
                'url' => null
            ]);
        }

        if ($_POST['cierre']) {

            $login = $this->sesion->get('login');
            $conexion = new Conexion();
            $periodo_model = new PeriodoModel($conexion);

            $periodo_model->actualizar(array(
                'estado' => 'CIERRE'
            ), array(
                'empresa' => $login['id'],
                'id' => $login['periodo']
            ));


            $this->actualizarPeriodActual($login['usuario']);

            Excepcion::json([
                'error' => false,
                'mensaje' => 'exito',
                'url' => '/cierre-contable'
            ]);
        }

        Excepcion::json([
            'error' => true,
            'mensaje' => 'Error al empezar con el cierre',
            'url' => null
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

    public function actualizarPeriodActual($usuario)
    {

        $sesion = new Session();
        $conexion = new Conexion();
        $periodoModel = new PeriodoModel($conexion);
        $empresaModel = new EmpresaModel($conexion);
        $data = $empresaModel->seleccionar(array('id', 'nombre', 'usuario'), array('usuario' => $usuario));

        $data = $data[0];

        $data['periodo'] = $periodoModel->ultimoPeriodo($data['id']);
        $data['anio'] = $periodoModel->ultimoAnio($data['id']);
        $data['estado'] = $periodoModel->estadoPeriodo($data['periodo'], $data['id']);
        if ($data['estado'] == 'CERRADO') {
            $data['periodo'] = null;
        }
        $sesion->set('login', $data);
    }

    public function calcularCierre()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $inventario_final = isset($_POST['inventario_final']) ? ($_POST['inventario_final'] === '' ? 0 : $_POST['inventario_final']) : 0;

        $login = $this->sesion->get('login');

//        $configuracion_model = new ConfiguracioModel(new Conexion());
//        $cuenta_model = new CuentaModel(new Conexion());
        $datos = $this->obtenerCuentasConfiguracion(['estado_resultados', 'cierre'], $login);
        //Excepcion::json($datos);

        $this->asignarSaldosEstadoResultados($login['periodo'], $login, $datos);

        $this->valoresEstadoResultados($datos, $inventario_final);

    }

    public function partidasCierre()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');
        $login = $this->sesion->get('login');
        $estado_resultados = isset($_POST['estado_resultados']) ? $_POST['estado_resultados'] : array();
        $cuentas = $this->obtenerCuentasConfiguracion(['estado_resultados', 'cierre', 'clasificacion'], $login);
        $partida_model = new PartidaModel(new Conexion());
        $partida = $partida_model->generarNumeroPartida($login['id'], $login['periodo']);


        Flight::render('ajax/cierre-contable/partidas-cierre', array(
            'estado_resultados' => $estado_resultados,
            'cuentas' => $cuentas,
            'partida' => $partida,
            'empresa' => $login
        ));
    }

    public function realizarCierre()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $login = $this->sesion->get('login');

        if ($this->sesion->get('partidas') === null) {
            Excepcion::json([
                'error' => true,
                'mensaje' => 'Falta calcular las partidas de cierre',
                'redireccion' => null
            ]);
        }

        $partidas_cierre = $this->sesion->get('partidas');

        $partidas_de_balance = $partidas_cierre[count($partidas_cierre) - 1];


        unset($partidas_cierre[count($partidas_cierre) - 1]);

        $conexion = new Conexion();
        $partida_model = new PartidaModel($conexion);
        $cuenta_model = new CuentaModel($conexion);
        $detalle_partida_model = new DetallePartidaModel($conexion);


        foreach ($partidas_cierre as $key => $partida) {
            $datos_partida = $partida['partida'];
            $detalle_partida = $partida['detalle_partida'];

            $id_partida = $partida_model->insertar($datos_partida);

            if ($id_partida !== null) {
                foreach ($detalle_partida as $key_2 => $detalle) {
                    foreach ($detalle as $key_3 => $detalle_individual) {
                        $detalle_posicion = $detalle_individual;
                        $detalle_posicion['partida'] = $id_partida;

                        $monto_acumlado = $detalle_posicion['monto'];

                        $codigo = $detalle_posicion['codigo'];

                        $detalle_posicion['monto'] = abs($detalle_posicion['monto']);

                        unset($detalle_posicion['codigo']);

                        $detalle_partida_model->insertar($detalle_posicion);

                        $cuentas_acumular = $cuenta_model->codigoSiguiente($codigo);

                        foreach ($cuentas_acumular as $key => $cuenta) {

                            $cuenta_base = $cuenta_model->seleccionar(
                                array('nombre', 'saldo', 'tipo_saldo'), array(
                                    'codigo' => $cuenta,
                                    'empresa' => $login['id'],
                                    'periodo' => $login['periodo']
                                )
                            );

                            $cuenta_base = $cuenta_base[0];

                            $es_R = strpos($cuenta, 'R');

                            if ($es_R > 0) {
                                $monto_acumlado = $monto_acumlado < 0 ? (abs($monto_acumlado)) : -$monto_acumlado;
                            }

                            $cuenta_model->actualizar(array(
                                'saldo[+]' => $monto_acumlado,
                            ), array(
                                'codigo' => $cuenta,
                                'empresa' => $login['id'],
                            ));

                            if ($es_R > 0) {
                                $monto_acumlado = $monto_acumlado < 0 ? (abs($monto_acumlado)) : -$monto_acumlado;
                            }
                        }
                    }

                }
            }


        }

        //liquidar cuentas de balance
        $this->liquidarBalance($partidas_de_balance, $cuenta_model, $partida_model, $detalle_partida_model, $login);

        //actualizar periodo

        $periodo_model = new PeriodoModel($conexion);

        $periodo_model->actualizar(array(
            'estado' => 'CERRADO'
        ), array(
            'empresa' => $login['id']
        ));

        $this->actualizarPeriodActual($login['usuario']);

        $this->copiarCuentasYConfiguracion($login['id'], $login['periodo']);

        Excepcion::json([
            'error' => false,
            'mensaje' => 'Cierre creado con exito',
            'redireccion' => '/periodo'
        ]);
    }

    public function liquidarBalance($partida, $cuenta_model, $partida_model, $detalle_partida_model, $login)
    {
        $datos_partida = $partida['partida'];
        $detalle_partida = $partida['detalle_partida'];

        $id_partida = $partida_model->insertar($datos_partida);

        if ($id_partida !== null) {
            foreach ($detalle_partida as $key_2 => $detalle) {

                foreach ($detalle as $key_3 => $detalle_individual) {
                    $detalle_posicion = $detalle_individual;
                    $detalle_posicion['partida'] = $id_partida;

                    $monto_acumlado = $detalle_posicion['monto'];


                    $codigo = $detalle_posicion['codigo'];

                    $cuenta_base = $cuenta_model->seleccionar(
                        array('nombre', 'saldo', 'tipo_saldo'), array(
                            'codigo' => $codigo,
                            'empresa' => $login['id'],
                            'periodo' => $login['periodo']
                        )
                    );


                    $cuenta_base = $cuenta_base[0];

                    $monto_acumlado = -$cuenta_base['saldo'];

                    if (substr($codigo, strlen($codigo) - 1) === 'R') {

                        $monto_acumlado = $cuenta_base['saldo'];

                    }

                    $detalle_posicion['monto'] = $cuenta_base['saldo'];

                    unset($detalle_posicion['codigo']);

                    $detalle_partida_model->insertar($detalle_posicion);

                    $cuentas_acumular = $cuenta_model->codigoSiguiente($codigo);

                    foreach ($cuentas_acumular as $key => $cuenta) {

//                        $cuenta_base = $cuenta_model->seleccionar(
//                            array('nombre', 'saldo', 'tipo_saldo'), array(
//                                'codigo' => $cuenta,
//                                'empresa' => $login['id'],
//                            )
//                        );
//
//                        $cuenta_base = $cuenta_base[0];

                        $es_R = strpos($cuenta, 'R');

                        if ($es_R > 0) {
                            $monto_acumlado = $monto_acumlado < 0 ? (abs($monto_acumlado)) : -$monto_acumlado;
                        }

                        $cuenta_model->actualizar(array(
                            'saldo[+]' => $monto_acumlado,
                        ), array(
                            'codigo' => $cuenta,
                            'empresa' => $login['id'],
                            'periodo' => $login['periodo']
                        ));

                        if ($es_R > 0) {
                            $monto_acumlado = $monto_acumlado < 0 ? (abs($monto_acumlado)) : -$monto_acumlado;
                        }
                    }
                }

            }
        }
    }

    public function balanceFormaReporte()
    {
        $this->sesionActiva();
        $this->validarMetodoPeticion('GET');

        $login = $this->sesion->get('login');

        $inventario_final = isset($_GET['inventario_final']) ? ($_GET['inventario_final'] === '' ? 0 : $_GET['inventario_final']) : 0;

        $periodo = isset($_GET['periodo']) ? $_GET['periodo'] : null;

        $periodo_pasado = isset($_GET['periodo_pasado']) ? $_GET['periodo_pasado'] : null;

        if ($periodo !== null) {
            $login['periodo'] = $periodo;
        }

        if ($periodo_pasado !== null) {
            $inventario_final = $this->inventarioFinalPeriodoPasado($login['id'], $login['periodo']);
        }


//        $configuracion_model = new ConfiguracioModel(new Conexion());
//        $cuenta_model = new CuentaModel(new Conexion());
        $datos = $this->obtenerCuentasConfiguracion(['estado_resultados', 'cierre'], $login);

        $cuentas_balance = $this->obtenerCuentasConfiguracionBalance(['clasificacion', 'cierre', 'estado_resultados'], $login);

        $this->asignarSaldosEstadoResultados($login['periodo'], $login, $datos);

        $partidas = $this->valoresEstadoResultadosParaBalance($datos, $inventario_final);

        $cuentas_balance_general = $this->asiganarSaldosBalance($cuentas_balance, $partidas, $login['periodo']);



        Flight::render('pdf/forma-reporte', array(
            'datos' => $cuentas_balance_general,
            'empresa' => $login['nombre']
        ));


    }

    public function balanceFormaCuenta()
    {
        $this->sesionActiva();
        $this->validarMetodoPeticion('GET');

        $login = $this->sesion->get('login');

        $inventario_final = isset($_GET['inventario_final']) ? ($_GET['inventario_final'] === '' ? 0 : $_GET['inventario_final']) : 0;

        $periodo = isset($_GET['periodo']) ? $_GET['periodo'] : null;

        $periodo_pasado = isset($_GET['periodo_pasado']) ? $_GET['periodo_pasado'] : null;

        if ($periodo !== null) {
            $login['periodo'] = $periodo;
        }

        if ($periodo_pasado !== null) {
            $inventario_final = $this->inventarioFinalPeriodoPasado($login['id'], $login['periodo']);
        }


//        $configuracion_model = new ConfiguracioModel(new Conexion());
//        $cuenta_model = new CuentaModel(new Conexion());
        $datos = $this->obtenerCuentasConfiguracion(['estado_resultados', 'cierre'], $login);

        $cuentas_balance = $this->obtenerCuentasConfiguracionBalance(['clasificacion', 'cierre', 'estado_resultados'], $login);

        $this->asignarSaldosEstadoResultados($login['periodo'], $login, $datos);

        $partidas = $this->valoresEstadoResultadosParaBalance($datos, $inventario_final);

        $cuentas_balance_general = $this->asiganarSaldosBalance($cuentas_balance, $partidas, $login['periodo']);



        Flight::render('pdf/forma-cuenta', array(
            'datos' => $cuentas_balance_general,
            'empresa' => $login['nombre']
        ));


    }


    public function EstadoResultados()
    {
        $this->sesionActiva();
        $this->validarMetodoPeticion('GET');

        $login = $this->sesion->get('login');

        $inventario_final = isset($_GET['inventario_final']) ? ($_GET['inventario_final'] === '' ? 0 : $_GET['inventario_final']) : 0;

        $periodo = isset($_GET['periodo']) ? $_GET['periodo'] : null;

        $periodo_pasado = isset($_GET['periodo_pasado']) ? $_GET['periodo_pasado'] : null;

        if ($periodo !== null) {
            $login['periodo'] = $periodo;
        }

        if ($periodo_pasado !== null) {
            $inventario_final = $this->inventarioFinalPeriodoPasado($login['id'], $login['periodo']);
        }


//        $configuracion_model = new ConfiguracioModel(new Conexion());
//        $cuenta_model = new CuentaModel(new Conexion());
        $datos = $this->obtenerCuentasConfiguracion(['estado_resultados', 'cierre'], $login);


        $partidas = $this->valoresEstadoResultadosParaBalance($datos, $inventario_final);
        //echo $partidas;
        //Excepcion::json($partidas);
        $this->asignarSaldosEstadoResultados($login['periodo'], $login, $datos);


        //Excepcion::json($datos);

        Flight::render('pdf/estado-de-resultado', array(
            'partidas' => $datos,
            'empresa' => $login['nombre'],
            'inventario_final' => $inventario_final
        ));


    }

    public function asignarSaldosEstadoResultados($periodo, $login, &$cuentas)
    {
        $conexion = new Conexion();
        $detalle_partida_model = new DetallePartidaModel($conexion);

        $iva_credito = $this->obtenerSubCuentas('iva_credito', $cuentas);
        $detalle_partida_model->asignarSaldosCalculados($iva_credito, $periodo);
        $indice = Utiles::posicionArreglo('iva_credito', 'descripcion', $cuentas);

        if ($indice !== false) {
            $cuentas[$indice]['subcuentas'] = $iva_credito;
        }

        $iva_debito = $this->obtenerSubCuentas('iva_debito', $cuentas);
        $detalle_partida_model->asignarSaldosCalculados($iva_debito, $periodo);
        $indice = Utiles::posicionArreglo('iva_debito', 'descripcion', $cuentas);

        if ($indice !== false) {
            $cuentas[$indice]['subcuentas'] = $iva_debito;
        }


        /*
                 * VENTAS NETAS
                */

        //ventas


        $ventas = $this->obtenerSubCuentas('ventas', $cuentas);

        $detalle_partida_model->asignarSaldosCalculados($ventas, $periodo, true);
        $indice = Utiles::posicionArreglo('ventas', 'descripcion', $cuentas);

        if ($indice !== false) {
            $cuentas[$indice]['subcuentas'] = $ventas;
        }


        //rebajas y devoluciones

        $rebajas_ventas = $this->obtenerSubCuentas('rebajas_ventas', $cuentas);
        $detalle_partida_model->asignarSaldosCalculados($rebajas_ventas, $periodo);
        $indice = Utiles::posicionArreglo('rebajas_ventas', 'descripcion', $cuentas);
        //Excepcion::json($cuentas);
        if ($indice !== false) {
            $cuentas[$indice]['subcuentas'] = $rebajas_ventas;
        }


        $devoluciones_ventas = $this->obtenerSubCuentas('devoluciones_ventas', $cuentas);
        $detalle_partida_model->asignarSaldosCalculados($devoluciones_ventas, $periodo);

        $indice = Utiles::posicionArreglo('devoluciones_ventas', 'descripcion', $cuentas);

        if ($indice !== false) {
            $cuentas[$indice]['subcuentas'] = $devoluciones_ventas;
        }

        /*
         * FIN VENTAS NETAS
        */

        /*
         * COSTO DE VENTA
        */

        //compras

        $compras = $this->obtenerSubCuentas('compras', $cuentas);
        $detalle_partida_model->asignarSaldosCalculados($compras, $periodo);

        $indice = Utiles::posicionArreglo('compras', 'descripcion', $cuentas);

        if ($indice !== false) {
            $cuentas[$indice]['subcuentas'] = $compras;
        }


        //gastos sobre compras
        $gastos_compras = $this->obtenerSubCuentas('gastos_compras', $cuentas);
        $detalle_partida_model->asignarSaldosCalculados($gastos_compras, $periodo);

        $indice = Utiles::posicionArreglo('gastos_compras', 'descripcion', $cuentas);

        if ($indice !== false) {
            $cuentas[$indice]['subcuentas'] = $gastos_compras;
        }


        //rebajas y devoluciones sobre compras

        $rebajas_compras = $this->obtenerSubCuentas('rebajas_compras', $cuentas);
        $detalle_partida_model->asignarSaldosCalculados($rebajas_compras, $periodo);

        $indice = Utiles::posicionArreglo('rebajas_compras', 'descripcion', $cuentas);

        if ($indice !== false) {
            $cuentas[$indice]['subcuentas'] = $rebajas_compras;
        }


        $devoluciones_compras = $this->obtenerSubCuentas('devoluciones_compras', $cuentas);
        $detalle_partida_model->asignarSaldosCalculados($devoluciones_compras, $periodo);

        $indice = Utiles::posicionArreglo('devoluciones_compras', 'descripcion', $cuentas);

        if ($indice !== false) {
            $cuentas[$indice]['subcuentas'] = $devoluciones_compras;
        }

        //inventario inicial

        $inventario_inicial = $this->obtenerSubCuentas('inventario', $cuentas);
        $detalle_partida_model->asignarSaldosCalculados($inventario_inicial, $periodo);

        $indice = Utiles::posicionArreglo('inventario', 'descripcion', $cuentas);

        if ($indice !== false) {
            $cuentas[$indice]['subcuentas'] = $inventario_inicial;
        }

        /*
         * FIN COSTO DE VENTA
        */

        /*
         * UTILIDAD BRUTA
        */

        //utilidad bruta

        /*
         * FIN UTILIDAD BRUTA
        */

        /*
         * Utilidad de operacion
        */

        //gastos de operacion

        $gastos_operacion = $this->obtenerSubCuentas('gastos_operacion', $cuentas);
        $detalle_partida_model->asignarSaldosCalculados($gastos_operacion, $periodo);

        $indice = Utiles::posicionArreglo('gastos_operacion', 'descripcion', $cuentas);

        if ($indice !== false) {
            $cuentas[$indice]['subcuentas'] = $gastos_operacion;
        }


        /*
         * FIN UTILIDAD BRUTA
        */

        /*
         * UTILIDAD ANTES DE IMPUESTOS y RESERVA
        */

        //otros productos

        $otros_productos = $this->obtenerSubCuentas('otros_productos', $cuentas);
        $detalle_partida_model->asignarSaldosCalculados($otros_productos, $periodo);

        $indice = Utiles::posicionArreglo('otros_productos', 'descripcion', $cuentas);

        if ($indice !== false) {
            $cuentas[$indice]['subcuentas'] = $otros_productos;
        }

        //otros gastos
        $otros_gastos = $this->obtenerSubCuentas('otros_gastos', $cuentas);
        $detalle_partida_model->asignarSaldosCalculados($otros_gastos, $periodo);

        $indice = Utiles::posicionArreglo('otros_gastos', 'descripcion', $cuentas);

        if ($indice !== false) {
            $cuentas[$indice]['subcuentas'] = $otros_gastos;
        }

        /*
         * FIN UTILIDAD ANTES DE IMPUESTOS y RESERVA
        */
    }


    private function asiganarSaldosBalance($cuentas, $estado_resultados, $periodo)
    {


        $activo = $this->obtenerSubCuentas('activo', $cuentas);
        $pasivo = $this->obtenerSubCuentas('pasivo', $cuentas);
        $patrimonio = $this->obtenerSubCuentas('patrimonio', $cuentas);


        $conexion = new Conexion();
        $detalle_partida_model = new DetallePartidaModel($conexion);

        $detalle_partida_model->asignarSaldosCalculados($activo, $periodo);
        $detalle_partida_model->asignarSaldosCalculados($pasivo, $periodo);
        $detalle_partida_model->asignarSaldosCalculados($patrimonio, $periodo);


        $inventario_final = $estado_resultados['inventario_final'];

        $codigo = $this->obtenerSubCuentas('inventario', $cuentas)[0]['codigo'];

        $this->asignarSaldo($activo, $inventario_final, $codigo, 'ASIGNAR');

        $reserva_legal = $estado_resultados['reserva_legal'];

        $codigo = $this->obtenerSubCuentas('reserva_legal', $cuentas)[0]['codigo'];
        $this->asignarSaldo($patrimonio, $reserva_legal, $codigo, 'ASIGNAR');

        $utilidad_perdida = $estado_resultados['utilidad_perdida'];

        if ($utilidad_perdida > 0) {
            $codigo = $this->obtenerSubCuentas('utilidad', $cuentas)[0]['codigo'];
            $this->asignarSaldo($patrimonio, $utilidad_perdida, $codigo, 'AUMENTAR');
        } else {
            $codigo = $this->obtenerSubCuentas('perdida', $cuentas)[0]['codigo'];
            $this->asignarSaldo($patrimonio, abs($utilidad_perdida), $codigo, 'AUMENTAR');
        }


        $impuesto_iva = $estado_resultados['impuesto_iva'];
        $codigo = $this->obtenerSubCuentas('impuesto_iva', $cuentas)[0]['codigo'];
        $this->asignarSaldo($pasivo, $impuesto_iva, $codigo, 'AUMENTAR');


        $iva_credito = $estado_resultados['iva_credito'];
        $codigo = $this->obtenerSubCuentas('iva_credito', $cuentas)[0]['codigo'];
        $this->asignarSaldo($activo, $iva_credito, $codigo, 'DISMINUIR');


        $iva_debito = $estado_resultados['iva_debito'];
        $codigo = $this->obtenerSubCuentas('iva_debito', $cuentas)[0]['codigo'];
        $this->asignarSaldo($pasivo, $iva_debito, $codigo, 'DISMINUIR');

        $impuesto_renta = $estado_resultados['impuesto_renta'];
        $codigo = $this->obtenerSubCuentas('impuesto_renta', $cuentas)[0]['codigo'];
        $this->asignarSaldo($pasivo, $impuesto_renta, $codigo, 'AUMENTAR');


        $cuentas[0]['subcuentas'] = $activo;
        $cuentas[1]['subcuentas'] = $pasivo;
        $cuentas[2]['subcuentas'] = $patrimonio;

        $balance = array_slice($cuentas, 0, 3);


        return $balance;


//        print_r(
//            [
//                $inventario_final, $reserva_legal, $utilidad_perdida, $impuesto_renta, $iva_debito, $iva_credito, $impuesto_renta, $impuesto_iva
//            ]
//        );


        /*
         * se necesita:
         * INVENTARIO FINAL, RESERVA LEGA, UTILIDAD O PERDIDA, IVA POR PAGAR, IMPUESTO POR PAGAR
        */

    }

    private function asignarSaldo(&$cuentas, $saldo = 0, $codigo, $tipo)
    {
        foreach ($cuentas as $key => $cuenta) {

            if ($cuenta['codigo'] === $codigo) {
                switch ($tipo) {
                    case'LIQUIDAR':
                        $cuentas[$key]['saldo'] = 0;
                        $cuentas[$key][3] = 0;
                        break;
                    case 'AUMENTAR':
                        $cuentas[$key]['saldo'] += $saldo;
                        $cuentas[$key][3] += $saldo;
                        break;
                    case 'DISMINUIR':
                        $cuentas[$key]['saldo'] -= $saldo;
                        $cuentas[$key][3] -= $saldo;
                        break;
                    case 'ASIGNAR':
                        $cuentas[$key]['saldo'] = $saldo;
                        $cuentas[$key][3] = $saldo;
                        break;
                }
            }
        }
    }

    private function obtenerSubCuentas($buscar, $cuentas)
    {
        $subcuentas = Utiles::buscar($buscar, 'descripcion', $cuentas);
        $subcuentas = isset($subcuentas['subcuentas']) ? $subcuentas['subcuentas'] : array();
        $array_auxiliar = array();

        foreach ($subcuentas as $key => $cuenta) {

            if ($cuenta['ultimo_nivel']) {
                array_push($array_auxiliar, $cuenta);
            }
        }

        return $array_auxiliar;
    }


    private function obtenerIndiceEspecifico($buscar, $indice, $cuentas)
    {
        $subcuentas = Utiles::buscar($buscar, $indice, $cuentas);
        return $subcuentas;
    }


    private function valoresEstadoResultados($cuentas = array(), $inventario_final = 0)
    {

        $estado_resultados = array();

        /*
         * CALCULO IVA
        */
        $iva_credito = $this->saldoAcumulado('iva_credito', 'descripcion', $cuentas);
        $iva_debito = $this->saldoAcumulado('iva_debito', 'descripcion', $cuentas);
        $estado_resultados['iva_credito'] = $iva_credito;
        $estado_resultados['iva_debito'] = $iva_debito;

        // ejemplos
        // iva debito = 1, iva_credito = 0
        // iva debito = 1, iva_credito = 1
        // iva debito = 0, iva_credito = 1
        // iva debito = 0, iva_credito = 0

        if ($iva_debito == 0 && $iva_credito == 0) {
            $estado_resultados['impuesto_iva'] = 0;
            $estado_resultados['situacion_iva'] = 'no_hay';

        } else if ($iva_debito == $iva_credito) {
            $estado_resultados['impuesto_iva'] = 0;
            $estado_resultados['situacion_iva'] = 'liquidar_cuentas';

        } else if ($iva_debito > $iva_credito) {
            $estado_resultados['impuesto_iva'] = ($iva_debito - $iva_credito);
            $estado_resultados['situacion_iva'] = 'pagar';

        } else if ($iva_credito > $iva_debito && $iva_debito > 0) {
            $estado_resultados['impuesto_iva'] = 0;
            $estado_resultados['situacion_iva'] = 'liquidar_debito';

        } else if ($iva_debito == 0) {
            $estado_resultados['impuesto_iva'] = 0;
            $estado_resultados['situacion_iva'] = 'no_pagar';

        }


        /*
         * FIN CALCULO IVA
        */


        /*
         * VENTAS NETAS
        */

        //ventas

        $ventas = $this->saldoAcumulado('ventas', 'descripcion', $cuentas);

        //rebajas y devoluciones
        $rebajas_ventas = $this->saldoAcumulado('rebajas_ventas', 'descripcion', $cuentas);

        $devoluciones_ventas = $this->saldoAcumulado('devoluciones_ventas', 'descripcion', $cuentas);

        //ventas netas
        $ventas_netas = $ventas - ($rebajas_ventas + $devoluciones_ventas);

        $estado_resultados['ventas'] = $ventas;
        $estado_resultados['rebajas_ventas'] = $rebajas_ventas;
        $estado_resultados['devoluciones_ventas'] = $devoluciones_ventas;
        $estado_resultados['ventas_netas'] = $ventas_netas;


        /*
         * FIN VENTAS NETAS
        */

        /*
         * COSTO DE VENTA
        */

        //compras
        $compras = $this->saldoAcumulado('compras', 'descripcion', $cuentas);

        //gastos sobre compras
        $gastos_compras = $this->saldoAcumulado('gastos_compras', 'descripcion', $cuentas);

        //compras totales

        $compras_totales = $compras + $gastos_compras;

        //rebajas y devoluciones sobre compras
        $rebajas_compras = $this->saldoAcumulado('rebajas_compras', 'descripcion', $cuentas);

        $devoluciones_compras = $this->saldoAcumulado('devoluciones_compras', 'descripcion', $cuentas);

        //compras netas
        $compras_netas = $compras_totales - ($rebajas_compras + $devoluciones_compras);

        //inventario inicial

        $inventario_inicial = $this->saldoAcumulado('inventario', 'descripcion', $cuentas);

        //mercaderia disponible

        $mercaderia_disponible = $compras_netas + $inventario_inicial;

        //costo de venta
        $costo_venta = $mercaderia_disponible - $inventario_final;

        $estado_resultados['compras'] = $compras;
        $estado_resultados['gastos_compras'] = $gastos_compras;
        $estado_resultados['compras_totales'] = $compras_totales;
        $estado_resultados['rebajas_compras'] = $rebajas_compras;
        $estado_resultados['devoluciones_compras'] = $devoluciones_compras;
        $estado_resultados['compras_netas'] = $compras_netas;
        $estado_resultados['inventario_inicial'] = $inventario_inicial;
        $estado_resultados['mercaderia_disponible'] = $mercaderia_disponible;
        $estado_resultados['inventario_final'] = $inventario_final;
        $estado_resultados['costo_venta'] = $costo_venta;


        /*
         * FIN COSTO DE VENTA
        */

        /*
         * UTILIDAD BRUTA
        */

        //utilidad bruta

        $utilidad_bruta = $ventas_netas - $costo_venta;

        $estado_resultados['utilidad_bruta'] = $utilidad_bruta;

        /*
         * FIN UTILIDAD BRUTA
        */

        /*
         * Utilidad de operacion
        */

        //gastos de operacion
        $gastos_operacion = $this->saldoAcumulado('gastos_operacion', 'descripcion', $cuentas);

        //utlidad de operacion

        $utilidad_operacion = $utilidad_bruta - $gastos_operacion;

        $estado_resultados['gastos_operacion'] = $gastos_operacion;
        $estado_resultados['utilidad_operacion'] = $utilidad_operacion;

        /*
         * FIN UTILIDAD BRUTA
        */

        /*
         * UTILIDAD ANTES DE IMPUESTOS y RESERVA
        */

        //otros productos
        $otros_productos = $this->saldoAcumulado('otros_productos', 'descripcion', $cuentas);

        //otros gastos
        $otros_gastos = $this->saldoAcumulado('otros_gastos', 'descripcion', $cuentas);

        //utilidad antes de impuests y resera

        $utilidad_antes_impuestos_reserva = $utilidad_operacion + $otros_productos - $otros_gastos;

        $estado_resultados['otros_productos'] = $otros_productos;
        $estado_resultados['otros_gastos'] = $otros_gastos;
        $estado_resultados['utilidad_antes_impuestos_reserva'] = $utilidad_antes_impuestos_reserva;


        /*
         * FIN UTILIDAD ANTES DE IMPUESTOS y RESERVA
        */

        /*
         *  UTILIDAD ANTES DE IMPUESTO
        */

        //reserva legal
        $reserva_legal = $utilidad_antes_impuestos_reserva * 0.07;

        //utilidad antes de impuestos
        $utilidad_antes_impuestos = $utilidad_antes_impuestos_reserva - $reserva_legal;

        $estado_resultados['reserva_legal'] = $reserva_legal;
        $estado_resultados['utilidad_antes_impuestos'] = $utilidad_antes_impuestos;

        /*
         * FIN UTILIDAD ANTES DE IMPUESTO
        */

        /*
         *  UTILIDAD DEL EJERCICIO
        */

        //impuesto sobre la renta
        $impuesto_renta = $utilidad_antes_impuestos * ($ventas_netas > 150000 ? 0.3 : 0.25);

        //utilidad antes de impuestos
        $utilidad_perdida = $utilidad_antes_impuestos - $impuesto_renta;

        $estado_resultados['impuesto_renta'] = $impuesto_renta;
        $estado_resultados['utilidad_perdida'] = $utilidad_perdida;

        /*
         * UTLIDAD DEL EJERCICIO
        */


        /* ================================================= */


//        $iva_credito = $this->saldoAcumulado('iva_credito', 'descripcion', $cuentas);
//        $iva_debito = $this->saldoAcumulado('iva_debito', 'descripcion', $cuentas);
//
//        if($iva_credito>$iva_debito){
//
//        }


        Excepcion::json($estado_resultados);

    }

    private function valoresEstadoResultadosParaBalance($cuentas = array(), $inventario_final = 0)
    {

        $estado_resultados = array();

        /*
         * CALCULO IVA
        */
        $iva_credito = $this->saldoAcumulado('iva_credito', 'descripcion', $cuentas);
        $iva_debito = $this->saldoAcumulado('iva_debito', 'descripcion', $cuentas);
        $estado_resultados['iva_credito'] = $iva_credito;
        $estado_resultados['iva_debito'] = $iva_debito;

        // ejemplos
        // iva debito = 1, iva_credito = 0
        // iva debito = 1, iva_credito = 1
        // iva debito = 0, iva_credito = 1
        // iva debito = 0, iva_credito = 0

        if ($iva_debito == 0 && $iva_credito == 0) {
            $estado_resultados['impuesto_iva'] = 0;
            $estado_resultados['situacion_iva'] = 'no_hay';

        } else if ($iva_debito == $iva_credito) {
            $estado_resultados['impuesto_iva'] = 0;
            $estado_resultados['situacion_iva'] = 'liquidar_cuentas';

        } else if ($iva_debito > $iva_credito) {
            $estado_resultados['impuesto_iva'] = ($iva_debito - $iva_credito);
            $estado_resultados['situacion_iva'] = 'pagar';

        } else if ($iva_credito > $iva_debito && $iva_debito > 0) {
            $estado_resultados['impuesto_iva'] = 0;
            $estado_resultados['situacion_iva'] = 'liquidar_debito';

        } else if ($iva_debito == 0) {
            $estado_resultados['impuesto_iva'] = 0;
            $estado_resultados['situacion_iva'] = 'no_pagar';

        }


        /*
         * FIN CALCULO IVA
        */


        /*
         * VENTAS NETAS
        */

        //ventas

        $ventas = $this->saldoAcumulado('ventas', 'descripcion', $cuentas);

        //rebajas y devoluciones
        $rebajas_ventas = $this->saldoAcumulado('rebajas_ventas', 'descripcion', $cuentas);

        $devoluciones_ventas = $this->saldoAcumulado('devoluciones_ventas', 'descripcion', $cuentas);

        //ventas netas
        $ventas_netas = $ventas - ($rebajas_ventas + $devoluciones_ventas);

        $estado_resultados['ventas'] = $ventas;
        $estado_resultados['rebajas_ventas'] = $rebajas_ventas;
        $estado_resultados['devoluciones_ventas'] = $devoluciones_ventas;
        $estado_resultados['ventas_netas'] = $ventas_netas;


        /*
         * FIN VENTAS NETAS
        */

        /*
         * COSTO DE VENTA
        */

        //compras
        $compras = $this->saldoAcumulado('compras', 'descripcion', $cuentas);

        //gastos sobre compras
        $gastos_compras = $this->saldoAcumulado('gastos_compras', 'descripcion', $cuentas);

        //compras totales

        $compras_totales = $compras + $gastos_compras;

        //rebajas y devoluciones sobre compras
        $rebajas_compras = $this->saldoAcumulado('rebajas_compras', 'descripcion', $cuentas);

        $devoluciones_compras = $this->saldoAcumulado('devoluciones_compras', 'descripcion', $cuentas);

        //compras netas
        $compras_netas = $compras_totales - ($rebajas_compras + $devoluciones_compras);

        //inventario inicial

        $inventario_inicial = $this->saldoAcumulado('inventario', 'descripcion', $cuentas);

        //mercaderia disponible

        $mercaderia_disponible = $compras_netas + $inventario_inicial;

        //costo de venta
        $costo_venta = $mercaderia_disponible - $inventario_final;

        $estado_resultados['compras'] = $compras;
        $estado_resultados['gastos_compras'] = $gastos_compras;
        $estado_resultados['compras_totales'] = $compras_totales;
        $estado_resultados['rebajas_compras'] = $rebajas_compras;
        $estado_resultados['devoluciones_compras'] = $devoluciones_compras;
        $estado_resultados['compras_netas'] = $compras_netas;
        $estado_resultados['inventario_inicial'] = $inventario_inicial;
        $estado_resultados['mercaderia_disponible'] = $mercaderia_disponible;
        $estado_resultados['inventario_final'] = $inventario_final;
        $estado_resultados['costo_venta'] = $costo_venta;


        /*
         * FIN COSTO DE VENTA
        */

        /*
         * UTILIDAD BRUTA
        */

        //utilidad bruta

        $utilidad_bruta = $ventas_netas - $costo_venta;

        $estado_resultados['utilidad_bruta'] = $utilidad_bruta;

        /*
         * FIN UTILIDAD BRUTA
        */

        /*
         * Utilidad de operacion
        */

        //gastos de operacion
        $gastos_operacion = $this->saldoAcumulado('gastos_operacion', 'descripcion', $cuentas);

        //utlidad de operacion

        $utilidad_operacion = $utilidad_bruta - $gastos_operacion;

        $estado_resultados['gastos_operacion'] = $gastos_operacion;
        $estado_resultados['utilidad_operacion'] = $utilidad_operacion;

        /*
         * FIN UTILIDAD BRUTA
        */

        /*
         * UTILIDAD ANTES DE IMPUESTOS y RESERVA
        */

        //otros productos
        $otros_productos = $this->saldoAcumulado('otros_productos', 'descripcion', $cuentas);

        //otros gastos
        $otros_gastos = $this->saldoAcumulado('otros_gastos', 'descripcion', $cuentas);

        //utilidad antes de impuests y resera

        $utilidad_antes_impuestos_reserva = $utilidad_operacion + $otros_productos - $otros_gastos;

        $estado_resultados['otros_productos'] = $otros_productos;
        $estado_resultados['otros_gastos'] = $otros_gastos;
        $estado_resultados['utilidad_antes_impuestos_reserva'] = $utilidad_antes_impuestos_reserva;


        /*
         * FIN UTILIDAD ANTES DE IMPUESTOS y RESERVA
        */

        /*
         *  UTILIDAD ANTES DE IMPUESTO
        */

        //reserva legal
        $reserva_legal = $utilidad_antes_impuestos_reserva * 0.07;

        //utilidad antes de impuestos
        $utilidad_antes_impuestos = $utilidad_antes_impuestos_reserva - $reserva_legal;

        $estado_resultados['reserva_legal'] = $reserva_legal;
        $estado_resultados['utilidad_antes_impuestos'] = $utilidad_antes_impuestos;

        /*
         * FIN UTILIDAD ANTES DE IMPUESTO
        */

        /*
         *  UTILIDAD DEL EJERCICIO
        */

        //impuesto sobre la renta
        $impuesto_renta = $utilidad_antes_impuestos * ($ventas_netas > 150000 ? 0.3 : 0.25);

        //utilidad antes de impuestos
        $utilidad_perdida = $utilidad_antes_impuestos - $impuesto_renta;

        $estado_resultados['impuesto_renta'] = $impuesto_renta;
        $estado_resultados['utilidad_perdida'] = $utilidad_perdida;

        /*
         * UTLIDAD DEL EJERCICIO
        */


        /* ================================================= */


//        $iva_credito = $this->saldoAcumulado('iva_credito', 'descripcion', $cuentas);
//        $iva_debito = $this->saldoAcumulado('iva_debito', 'descripcion', $cuentas);
//
//        if($iva_credito>$iva_debito){
//
//        }


        return $estado_resultados;

    }

    private function saldoAcumulado($cuenta, $columna, $cuentas)
    {
        $cuenta_auxiliar = Utiles::buscar($cuenta, $columna, $cuentas);

        return (isset($cuenta_auxiliar['subcuentas'])) ? $this->acumularSaldos($cuenta_auxiliar['subcuentas']) : 0;
    }

    private function acumularSaldos($cuentas)
    {
        $saldo = 0;
        foreach ($cuentas as $key => $cuenta) {
            if ($cuenta['ultimo_nivel'])
                $saldo += $cuenta['saldo'];
        }
        return $saldo;
    }

    private function obtenerCuentasConfiguracion($opciones, $login)
    {

        $configuracion_model = new ConfiguracioModel(new Conexion());
        $cuenta_model = new CuentaModel(new Conexion());
        $datos = $configuracion_model->obtenerConfiguracion($login['id'], $login['periodo'], $opciones);

        foreach ($datos as $key => $dato) {


            if(Utiles::endsWith($dato['codigo'],'R')){
                $dato['codigo'] = substr($dato['codigo'], 0, -1);
                $dato['codigo'] = $dato['codigo'].'%R';

            }else{
                $dato['codigo'] = $dato['codigo'] . '%';
            }

            $cuentas = $cuenta_model->conexion()->query(
                'SELECT id, codigo, nombre, saldo, tipo_saldo, ultimo_nivel, nivel, orden from cuenta 
                        where empresa = :empresa and codigo LIKE :codigo  and periodo = :periodo and cuenta.periodo = :periodo ORDER BY tipo_saldo', array(
                    ':empresa' => $login['id'],
                    ':periodo' => $login['periodo'],
                    ':codigo' => $dato['codigo'],
                )
            )->fetchAll();

            $datos[$key]['subcuentas'] = $cuentas;
        }
        return $datos;
    }

    private function obtenerCuentasConfiguracionBalance($opciones, $login)
    {

        $configuracion_model = new ConfiguracioModel(new Conexion());
        $cuenta_model = new CuentaModel(new Conexion());
        $datos = $configuracion_model->obtenerConfiguracion($login['id'], $login['periodo'], $opciones);

        foreach ($datos as $key => $dato) {
            $cuentas = $cuenta_model->conexion()->query(
                'SELECT id, codigo, nombre, saldo, tipo_saldo, ultimo_nivel, nivel, orden from cuenta 
                        where empresa = :empresa and codigo LIKE :codigo  and periodo = :periodo and cuenta.periodo = :periodo ORDER BY codigo', array(
                    ':empresa' => $login['id'],
                    ':periodo' => $login['periodo'],
                    ':codigo' => $dato['codigo'] . '%',
                )
            )->fetchAll();

            $datos[$key]['subcuentas'] = $cuentas;
        }
        return $datos;
    }

    private function buscarSubCuentas($valor, $columna, $arreglo)
    {
        $cuenta_auxiliar = Utiles::buscar($valor, $columna, $arreglo);
        return (isset($cuenta_auxiliar['orden'])) ? $cuenta_auxiliar['orden'] : -1;
    }

    private function copiarCuentasYConfiguracion($empresa, $periodo)
    {
        $conexion = new Conexion();

        $cuenta_model = new CuentaModel($conexion);

        $copias_cuentas = $cuenta_model->seleccionar(
            '*', array(
                'periodo' => $periodo,
                'empresa' => $empresa
            )
        );

        foreach ($copias_cuentas as $key => $cuenta) {
            unset($copias_cuentas[$key]['id']);
            unset($copias_cuentas[$key]['periodo']);
        }


        $cuenta_model->insertar($copias_cuentas);
        $this->actualizarPadres($cuenta_model, $empresa);
    }

    private function actualizarPadres(CuentaModel $modelo, $empresa)
    {
        $cuentas = $modelo->seleccionar(
            ['id', 'padre'], array(
                'empresa' => $empresa,
                'periodo' => null
            )
        );

        foreach ($cuentas as $key => $cuenta) {
            if ($cuenta['padre'] != null) {
                $padre_viejo = $modelo->seleccionar(['codigo'], array(
                    'empresa' => $empresa,
                    'id' => $cuenta['padre']
                ));

                $padre_nuevo = $modelo->seleccionar(['id'], array(
                    'empresa' => $empresa,
                    'codigo' => $padre_viejo[0]['codigo'],
                    'periodo' => null
                ));

                $modelo->actualizar([
                    'padre' => $padre_nuevo[0]['id']
                ], array(
                    'id' => $cuenta['id']
                ));

            }
        }

    }

//$empresa, $periodo
    private function inventarioFinalPeriodoPasado($empresa, $periodo)
    {
        $consulta = "select monto from detalle_partida inner join partida on partida.id = detalle_partida.partida
                        inner join periodo on periodo.id = partida.periodo inner join empresa on 
                        empresa.id = periodo.empresa inner join cuenta on cuenta.id = detalle_partida.cuenta
                        where empresa.id = :empresa and periodo.id = :periodo and cuenta.periodo = :periodo 
                        and partida.partida_cierre = 1 and partida.descripcion like '%inventario final%' limit 1";
        $conexion = new Conexion();
        $query = $conexion->obtenerConexion()->query($consulta, array(
            ':empresa' => $empresa,
            ':periodo' => $periodo
        ))->fetchAll();

        if (!empty($query)) {
            return $query[0]['monto'];
        }
        return 0;

    }

}
