<?php
require_once './app/libs/Controller.php';
require_once './app/models/CuentaModel.php';

class CuentaController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        $this->modelo = new CuentaModel($conexion);
    }

    public function index()
    {
        $this->sesionActiva();
        $this->view('cuenta', [
            'js_especifico' => Utiles::printScript('cuenta')
        ]);
    }

    public function tablaCuentas(){
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        $datos = $this->modelo->listarCuentas();
        Flight::render('ajax/cuentas/tabla-cuentas', array(
            'datos' => $datos
        ));
    }

    public function modalGuardar(){
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        Flight::render('ajax/cuentas/modal-guardar');
    }

    public function modalEditar($id){
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        if($id===null)
            exit(1);

        $id = base64_decode($id);
        $sesion = new Session();
        $empresa = $sesion->get('login')['id'];

        $cuenta = $this->modelo->seleccionar('*', array(
            'empresa' => $empresa,
            'id' => $id
        ));

        Flight::render('ajax/cuentas/modal-editar', array(
            'cuenta' => $cuenta[0]
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

}
