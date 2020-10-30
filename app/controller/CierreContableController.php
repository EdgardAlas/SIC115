<?php
require_once './app/libs/Controller.php';
require_once './app/models/PeriodoModel.php';
require_once './app/models/CuentaModel.php';
require_once './app/models/EmpresaModel.php';
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

        $inventario_final = isset($_POST['inventario_final']) ? $_POST['inventario_final'] : -1;

        $login = $this->sesion->get('login');

        $configuracion_model = new ConfiguracioModel(new Conexion());
        $cuenta_model = new CuentaModel(new Conexion());
        $datos = $configuracion_model->obtenerConfiguracion($login['id'], $login['periodo']);
        foreach ($datos as $key => $dato) {
            $cuentas = $cuenta_model->conexion()->query(
                'SELECT id, codigo, nombre, saldo, tipo_saldo from cuenta 
                        where empresa = :empresa and codigo LIKE :codigo AND orden = :orden ORDER BY :codigo', array(
                    ':empresa' => $login['id'],
                    ':codigo' => '%'.$dato['codigo'].'%',
                    ':orden' => $dato['orden']
                )
            )->fetchAll();

            $datos[$key]['subcuentas'] = $cuentas;
        }
        Excepcion::json(($datos));

    }


}