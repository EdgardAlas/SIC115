<?php
require_once './app/libs/Controller.php';
require_once './app/models/PeriodoModel.php';
require_once './app/models/EmpresaModel.php';
require_once './app/models/ConfiguracionModel.php';
require_once './app/models/CuentaModel.php';
require_once './app/models/PartidaModel.php';
require_once './app/models/DetallePartidaModel.php';


class PeriodoController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        $this->modelo = new PeriodoModel($conexion);
        parent::__construct();
    }

    public function index()
    {
        $this->sesionActiva();
        $this->view('periodo', ['js_especifico' => Utiles::printScript('periodo'),]);
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

    public function listaPeriodos()
    {

        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        $sesion = $this->sesion->get('login');


        $periodo = $sesion['periodo'];
        $empresa = $sesion['id'];
        $anio = $sesion['anio'];
        $estado = $sesion['estado'];

        $periodo_objeto = array(
            'periodo' => $periodo,
            'empresa' => $empresa,
            'anio' => $anio,
            'estado' => $estado
        );

        $lista_periodos = $this->modelo->seleccionar(['estado', 'anio'], array(
            'empresa' => $empresa
        ));

        Flight::render('ajax/periodo/lista-periodos', array(
            'periodo' => $periodo_objeto,
            'periodos' => $lista_periodos
        ));
    }

    public function iniciarPeriodo()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $sesion = $this->sesion->get('login');
        $conexion = new Conexion();
        $anio = ($sesion['anio'] === null) ? date('Y') : $sesion['anio'] + 1;

        $ultimo_periodo = $this->modelo->ultimoPeriodo($sesion['id']);

        $periodo = array(
            'empresa' => $sesion['id'],
            'anio' => $anio
        );

        $resultado = $this->modelo->insertar($periodo);

        if ($resultado !== null) {
            $this->crearSesion($sesion['usuario']);
            $sesion = $this->sesion->get('login');
            /*
             * Aca se hara la copia de la configuracion y actualizacion de las cuentas de la configuracion
             * Crear la partida 1
             * */

            //si no es null entonce se hara la copia de la configuracion
            if ($ultimo_periodo !== null) {
                $configuracion_model = new ConfiguracioModel($conexion);
                $copia_configuracion = $this->copiarConfiguracion($ultimo_periodo, $resultado, $sesion, $conexion);
                $configuracion_model->insertar($copia_configuracion);
                $this->actualizarPeriodoCuentas($resultado, $sesion['id'], $conexion);

                //Partida inicial
                $this->partidaInicialSiguientePeriodo($sesion, $ultimo_periodo, $conexion);

            }

            Excepcion::json(['error' => false, 'mensaje' => 'Periodo creado con exito', 'icono' => 'success', 'error_' => $this->modelo->error()]);
        }

        Excepcion::json(['error' => true, 'mensaje' => 'Error al iniciar el periodo', 'icono' => 'warning', 'error_' => $this->modelo->error()]);

    }

    public function modalIniciarPeriodo()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        Flight::render('ajax/periodo/iniciar-periodo', array(
            'anio' => $this->sesion->get('login')['anio']
        ));
    }

    //metodos privados

    private function crearSesion($usuario)
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

    public function copiarConfiguracion($ultimo_periodo, $periodo, $login, $conexion)
    {

        $cuenta_model = new CuentaModel($conexion);
        $configuracion_model = new ConfiguracioModel($conexion);

        $configuraciones = $configuracion_model->seleccionar(array(
            'cuenta', 'periodo', 'titulo', 'descripcion'
        ), array(
            'periodo' => $ultimo_periodo
        ));

        /*
         * Cambiar el codigo de la cuenta
         * Cambiar el periodo
         * */


        foreach ($configuraciones as $key => $configuracion) {
            $padre_viejo = $cuenta_model->seleccionar(['codigo'], array(
                'id' => $configuracion['cuenta']
            ));

            $padre_nuevo = $cuenta_model->seleccionar(['id'], array(
                'codigo' => $padre_viejo[0]['codigo'],
                'empresa' => $login['id'],
                'periodo' => null
            ));

            $configuraciones[$key]['cuenta'] = $padre_nuevo[0]['id'];
            $configuraciones[$key]['periodo'] = $periodo;
        }

        return $configuraciones;

    }

    private function actualizarPeriodoCuentas($ultimo_periodo, $empresa, $conexion)
    {
        $cuenta_model = new CuentaModel($conexion);

        $cuenta_model->actualizar(array(
            'periodo' => $ultimo_periodo
        ), array(
            'empresa' => $empresa,
            'periodo' => null
        ));

    }

    public function test()
    {
        $conexion = new Conexion();
        $login = $this->sesion->get('login');
        $periodo_pasado = 21;
        $partida_model = new  PartidaModel($conexion);
        $detalle_partida_model = new DetallePartidaModel($conexion);
        $cuenta_model = new CuentaModel($conexion);


        $ultima_partida = $detalle_partida_model->conexion()->query(
            'select detalle_partida.monto, detalle_partida.movimiento, detalle_partida.cuenta 
		from detalle_partida 
			inner join partida on partida.id = detalle_partida.partida
			inner join periodo on periodo.id = partida.periodo
			inner join cuenta on cuenta.id = detalle_partida.cuenta
				where periodo.id = :periodo and detalle_partida.partida = (select partida.id from partida inner join periodo on periodo.id = partida.periodo inner join empresa on empresa.id = periodo.empresa
	where periodo.id = :periodo order by id desc limit 1))
            ', array(
                ':periodo' => $periodo_pasado,
            )
        )->fetchAll();


        $ultima_partida = Utiles::eliminarDuplicados($ultima_partida);
        Excepcion::json($ultima_partida);
    }

    public function partidaInicialSiguientePeriodo($login, $periodo_pasado, Conexion $conexion)
    {
        $partida_model = new  PartidaModel($conexion);
        $detalle_partida_model = new DetallePartidaModel($conexion);
        $cuenta_model = new CuentaModel($conexion);


        $ultima_partida = $detalle_partida_model->conexion()->query(
            'select detalle_partida.monto, detalle_partida.movimiento, detalle_partida.cuenta 
		from detalle_partida 
			inner join partida on partida.id = detalle_partida.partida
			inner join periodo on periodo.id = partida.periodo
			inner join cuenta on cuenta.id = detalle_partida.cuenta
				where periodo.id = :periodo and detalle_partida.partida = (select partida.id from partida 
				inner join periodo on periodo.id = partida.periodo inner join empresa on empresa.id = periodo.empresa
	where periodo.id = :periodo order by id desc limit 1) and monto > 0 order by movimiento
            ', array(
                ':periodo' => $periodo_pasado,
            )
        )->fetchAll();
        var_dump($login);
        var_dump($periodo_pasado);
        var_dump($partida_model->last());
        var_dump($partida_model->error());

        $ultima_partida = Utiles::eliminarDuplicados($ultima_partida);


        $partida_inicial = array(
            'numero' => 1,
            'descripcion' => 'Inicio de operaciones',
            'fecha' => date($login['anio'] . '-01-01'),
            'partida_cierre' => 0,
            'periodo' => $login['periodo']
        );


        $id_partida = $partida_model->insertar($partida_inicial);


        var_dump($ultima_partida);

        if ($id_partida !== null) {

            foreach ($ultima_partida as $key => $detalle) {

                $detalle['partida'] = $id_partida;

                /*
                 * partida, cuenta, monto, movimiento
                 * nos hace falta codigo y cuenta porque cuenta es la vieja
                 * */

                $cuenta_vieja = $cuenta_model->seleccionar(['codigo'], array(
                    'id' => $detalle['cuenta']
                ));

                $cuenta_nueva = $cuenta_model->seleccionar(['codigo', 'id', 'tipo_saldo'], array(
                    'codigo' => $cuenta_vieja[0]['codigo'],
                    'periodo' => $login['periodo']
                ));


                $detalle['cuenta'] = $cuenta_nueva[0]['id'];
                $detalle['codigo'] = $cuenta_nueva[0]['codigo'];
                $detalle['movimiento'] = ($detalle['movimiento'] === 'Cargo') ? 'Abono' : 'Cargo';

                $detalle['monto'] = $this->calcularMonto(
                    $detalle['monto'],
                    $cuenta_nueva[0]['tipo_saldo'],
                    $detalle['movimiento'],
                    $detalle['codigo']
                );

                /*
                 * hasta este  punto tenemos
                 * partida, cuenta, monto, movimiento y codigo
                 * */

                $codigo = ($detalle['codigo']);

                //Monto que se va a actualizar en las cuentas de mayor
                $monto_acumlado = $detalle['monto'];

                $detalle['monto'] = abs($detalle['monto']);

                unset($detalle['codigo']);

                var_dump($detalle);

                $detalle_partida_model->insertar($detalle);

                $cuentas_acumular = $cuenta_model->codigoSiguiente($codigo);

                $saldo_cueta_acumular = 0;

                foreach ($cuentas_acumular as $key_1 => $cuenta) {

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
                        'periodo' => $login['periodo']
                    ));

                    if ($es_R > 0) {
                        $monto_acumlado = $monto_acumlado < 0 ? (abs($monto_acumlado)) : -$monto_acumlado;
                    }
                }


            }


        }


    }

    private function calcularMonto($monto, $saldo, $movimiento, $codigo)
    {
        $saldocuenta = $monto;
        if (($saldo === 'Deudor' && substr($codigo, strlen($codigo) - 1) == 'R' && $movimiento === 'Cargo') ||
            ($saldo === 'Acreedor' && substr($codigo, strlen($codigo) - 1) == 'R' && $movimiento === 'Abono') ||
            ($saldo === 'Deudor' && substr($codigo, strlen($codigo) - 1) != 'R' && $movimiento === 'Abono') ||
            ($saldo === 'Acreedor' && substr($codigo, strlen($codigo) - 1) != 'R' && $movimiento === 'Cargo')) {
            $saldocuenta = -1 * $saldocuenta;
        }
        return $saldocuenta;
    }

    public function inputPeriodos()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        $login = $this->sesion->get('login');

        $periodos = $this->modelo->seleccionar(['id', 'anio'], array(
            'empresa' => $login['id']
        ));

        Flight::render('ajax/periodo/input-periodos', array(
            'periodos' => $periodos,
            'periodo_actual' => $login['periodo']
        ));


    }

}
