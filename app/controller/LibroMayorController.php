<?php
require_once './app/libs/Controller.php';
require_once './app/models/CuentaModel.php';
require_once './app/models/PartidaModel.php';

class LibroMayorController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        parent::__construct();
    }

    public function index()
    {
        $this->sesionActiva();
        //$this->validarPeriodo();


        $this->view('libro-mayor', [
            'js_especifico' => Utiles::printScript('libro-mayor')
        ], [
            'anio' => $this->sesion->get('login')['anio']
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

    public function tablaLibroMayor()
    {
        $this->isAjax();
        $this->sesionActivaAjax();

        $conexion = new Conexion();
        $cuenta_model = new CuentaModel($conexion);
        $partida_model = new PartidaModel($conexion);


        $login = $this->sesion->get('login');

        $nivel = isset($_POST['nivel']) ? $_POST['nivel'] : 1;

        $fecha_inicial = (isset($_POST['fecha_inicial']))
            ? $_POST['fecha_inicial']
            : date($login['anio'] . '-01-01');

        $fecha_final = (isset($_POST['fecha_final']))
            ? $_POST['fecha_final']
            : date($login['anio'] . '-12-31');

        $login['periodo'] = isset($_POST['periodo']) ? base64_decode($_POST['periodo']) : $login['periodo'];

        $cuentas = $cuenta_model->seleccionar(array('nombre', 'id', 'codigo', 'tipo_saldo', 'periodo'), array(
            'empresa' => $login['id'],
            'nivel' => $nivel,
            'periodo' => $login['periodo'],
            'ORDER' => array(
                'orden' => 'ASC'
            )
        ));

        $condicion = array(
            'empresa' => $login['id'],
            'periodo' => $login['periodo'],
            'fecha_inicial' => $fecha_inicial,
            'fecha_final' => $fecha_final
        );


        if ($_POST['cuenta'][0] !== '') {

            $_POST['cuenta'] = array_map('trim', $_POST['cuenta']);
            $cuentas = $cuenta_model->seleccionar(array('nombre', 'id', 'codigo', 'tipo_saldo', 'periodo'), array(
                'empresa' => $login['id'],
                'codigo' => $_POST['cuenta'],
                'periodo' => $login['periodo']
            ));
        }



        $partidas = $partida_model->obtenerPartidas($cuentas, $condicion);


        Flight::render('ajax/libro-mayor/tabla-libro-mayor', array(
            'datosBD' => $partidas
        ));

    }


    public function reporteLibroMayor()
    {

        $this->sesionActiva();

        $conexion = new Conexion();
        $cuenta_model = new CuentaModel($conexion);
        $partida_model = new PartidaModel($conexion);


        $login = $this->sesion->get('login');

        $nivel = isset($_GET['nivel']) ? $_GET['nivel'] : 3;

        $fecha_inicial = (isset($_GET['fecha_inicial']))
            ? $_GET['fecha_inicial']
            : date($login['anio'] . '-01-01');

        $fecha_final = (isset($_GET['fecha_final']))
            ? $_GET['fecha_final']
            : date($login['anio'] . '-12-31');


        $login['periodo'] = isset($_GET['periodo']) ? base64_decode($_GET['periodo']) : $login['periodo'];

        $cuentas = $cuenta_model->seleccionar(array('nombre', 'id', 'codigo', 'tipo_saldo'), array(
            'empresa' => $login['id'],
            'nivel' => $nivel,
            'periodo' => $login['periodo'],
            'ORDER' => array(
                'orden' => 'ASC'
            )
        ));

        $condicion = array(
            'empresa' => $login['id'],
            'periodo' => $login['periodo'],
            'fecha_inicial' => $fecha_inicial,
            'fecha_final' => $fecha_final,

        );


        if (isset($_GET['cuenta'])) {
            if ($_GET['cuenta'] !== '') {
                $_GET['cuenta'] = array_map('trim', explode(',', $_GET['cuenta']));

                $cuentas = $cuenta_model->seleccionar(array('nombre', 'id', 'codigo', 'tipo_saldo'), array(
                    'empresa' => $login['id'],
                    'codigo' => $_GET['cuenta'],
                    'periodo' => $login['periodo']
                ));
            }
        }


        $partidas = $partida_model->obtenerPartidas($cuentas, $condicion);


        Flight::render('pdf/libro-mayor', array(
            'datosBD' => $partidas,
            'emp' => $login['nombre']
        ));

    }

}
