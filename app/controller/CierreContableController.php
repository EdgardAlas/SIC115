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
                'empresa' => $login['id']
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
        $sesion->set('login', $data);
    }

    public function calcularCierre()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $inventario_final = isset($_POST['inventario_final']) ? ($_POST['inventario_final'] === '' ? 0 : $_POST['inventario_final']) : 0;

        $login = $this->sesion->get('login');

        $configuracion_model = new ConfiguracioModel(new Conexion());
        $cuenta_model = new CuentaModel(new Conexion());
        $datos = $this->obtenerCuentasConfiguracion(['estado_resultados', 'cierre']);

        $partidas = $this->valoresEstadoResultados($datos, $inventario_final);

    }

    public function partidasCierre()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');
        $login = $this->sesion->get('login');
        $estado_resultados = isset($_POST['estado_resultados']) ? $_POST['estado_resultados'] : array();
        $cuentas = $this->obtenerCuentasConfiguracion(['estado_resultados', 'cierre', 'clasificacion']);
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
                        ));

                        if ($es_R > 0) {
                            $monto_acumlado = $monto_acumlado < 0 ? (abs($monto_acumlado)) : -$monto_acumlado;
                        }
                    }
                }

            }
        }
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

    private function obtenerCuentasConfiguracion($opciones)
    {

        $login = $this->sesion->get('login');

        $configuracion_model = new ConfiguracioModel(new Conexion());
        $cuenta_model = new CuentaModel(new Conexion());
        $datos = $configuracion_model->obtenerConfiguracion($login['id'], $login['periodo'], $opciones);
        foreach ($datos as $key => $dato) {
            $cuentas = $cuenta_model->conexion()->query(
                'SELECT id, codigo, nombre, saldo, tipo_saldo, ultimo_nivel from cuenta 
                        where empresa = :empresa and codigo LIKE :codigo AND orden = :orden ORDER BY :codigo', array(
                    ':empresa' => $login['id'],
                    ':codigo' => '%' . $dato['codigo'] . '%',
                    ':orden' => $dato['orden']
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
}
