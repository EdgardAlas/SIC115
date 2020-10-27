<?php
require_once './app/libs/Controller.php';
require_once './app/models/PeriodoModel.php';
require_once './app/models/EmpresaModel.php';

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

        $anio = ($sesion['anio'] === null) ? date('Y') : $sesion['anio'] + 1;

        $periodo = array(
            'empresa' => $sesion['id'],
            'anio' => $anio
        );

        $resultado = $this->modelo->insertar($periodo);

        if ($resultado !== null) {
            $this->crearSesion($sesion['usuario']);
            Excepcion::json(['error' => false, 'mensaje' => 'Periodo creado con exito', 'icono' => 'success']);
        }

        Excepcion::json(['error' => true, 'mensaje' => 'Error al iniciar el periodo', 'icono' => 'warning']);

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

}
