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

    public function guardar()
    {

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
