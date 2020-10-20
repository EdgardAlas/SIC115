<?php
require_once './app/libs/Controller.php';
require_once './app/models/EmpresaModel.php';
require_once './app/models/PeriodoModel.php';

class LoginController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        $this->modelo = new EmpresaModel($conexion);
    }

    public function index()
    {
        $this->sesionActiva();
        $this->viewOne('login', []);
    }

    public function iniciarSesion()
    {
        $resultado_validaciones = [];
        if (!isset($_POST['login'])) {
            Exepcion::json(['error' => true, 'tipo' => 'error_sesion']);
        }

        $resultado_validaciones = $this->modelo->validarCampos($_POST['login']);

        if ($resultado_validaciones['error'] === true) {
            Exepcion::json($resultado_validaciones);
        }

        $datos = $resultado_validaciones['datos'];

        $resultado = $this->modelo->existe($datos);

        if ($resultado) {
            $this->crearSesion($datos['usuario']);
            Exepcion::json(['error' => false, 'url' => '/']);
        }
        Exepcion::json(['error' => true, 'tipo' => 'no_encontrado']);
    }

    public function cerrarSesion(){
        $sesion = new Session();
        $sesion->destroy();
        Flight::redirect('/login', 200);
    }

    public function registrar(){
        $this->sesionActiva();
        Flight::render('registrar', array());
    }

    public function validarEmpresa($empresa){
        $this->isAjax();

        $existe = $this->modelo->existe(array(
            'nombre' => $empresa
        ));

        $resultado  = array();

        if($existe){
            $resultado = array(
                'error' => true
            );
        }else{
            $resultado = array(
                'error' => false
            );
        }

        Exepcion::json($resultado);
    } 

    public function validarUsuario($usuario){
        $this->isAjax();

        $existe = $this->modelo->existe(array(
            'usuario' => $usuario
        ));

        $resultado  = array();

        if($existe){
            $resultado = array(
                'error' => true
            );
        }else{
            $resultado = array(
                'error' => false
            );
        }

        Exepcion::json($resultado);
    } 

    public function guardar(){
        $this->isAjax();
        
        $this->validarMetodoPeticion('POST');
        //lo que guardarias seria$_post pos ya xdxdxdxdxdxd :v aca hace falta un monton mas, en eta parte del backend asi como en cuenta
        $resultado_guardar = $this->modelo->insertar($_POST);

        if ($resultado_guardar !== null) {
            $this->crearSesion($_POST['usuario']);
            Exepcion::json(['mensaje' => 'Usuario creado con exito', 'redireccion' => '/']);
        }

        Exepcion::json(array(
            'error' => true,
            'redireccion' => null
        ));

    }

    public function editar()
    {

    }

    public function eliminar()
    {
        
    }

    //metodos privados

    private function crearSesion($usuario)
    {

        $sesion = new Session();
        $data = $this->modelo->seleccionar(array('id', 'nombre', 'usuario'), array('usuario' => $usuario));

        $data = $data[0];
        $periodoModel = new PeriodoModel(new Conexion());
        $data['user'] = $usuario;
        $data['periodo'] = $periodoModel->ultimoPeriodo($data['id']);
        $sesion->set('login', $data);
    }
}
