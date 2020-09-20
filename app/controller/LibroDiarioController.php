<?php
require_once './app/libs/Controller.php';
require_once './app/libs/Controller.php';



class LibroDiarioController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        /* $this->modelo = new HomeModel($conexion); */
    }

    public function index()
    {
        $this->sesionActiva();

        $this->view('libro-diario', [
            'js_especifico' => Utiles::printScript('libro-diario')
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

    public function tablaDetalle(){
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');
        

        if(!isset($_POST['tabla_detalle'])){
            $_POST['tabla_detalle'] = array();
        }

        $detalles = $_POST['tabla_detalle'];

        Flight::render('ajax/libro-diario/tabla-detalle-partida', array(
            'datos' => $_POST['tabla_detalle']
        ));
    }

}
