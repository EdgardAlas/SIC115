<?php
require_once './app/libs/Controller.php';
require_once './app/models/EmpresaModel.php';
require_once './app/models/PeriodoModel.php';

use PHPMailer\PHPMailer\PHPMailer;

class LoginController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        $this->modelo = new EmpresaModel($conexion);
        parent::__construct();
    }

    public function index()
    {
        $this->sesionActiva();
        $this->viewOne('login', []);
    }

    public function recuperar()
    {
        $this->sesionActiva();
        //strtoupper(substr(md5(    uniqid(mt_rand(), true)) , 0, 8);
        $this->viewOne('recuperar', []);
    }

    public function enviarCorreo()
    {
        $this->isAjax();
        $this->validarMetodoPeticion('POST');

        $correo = '';
        $nueva = '';
        $validar = '';

        if (isset($_POST['correo'])) {
            $correo = $_POST['correo'];
        }

        if (isset($_POST['nueva'])) {
            $nueva = $_POST['nueva'];
        }

        if (isset($_POST['confirmar'])) {
            $validar = $_POST['confirmar'];
        }

        if (strlen($correo) === 0) {
            Excepcion::json(array(
                'error' => true,
                'mensaje' => 'No hay correo proporcionado',
                'icono' => 'warning',
                'campo' => 'correo'
            ));
        }

        if (strlen($nueva) < 8) {
            Excepcion::json(['error' => true, 'mensaje' => 'Minimo de 8 caracteres', 'icono' => 'warning', 'campo' => 'nueva']);
        }

        if (strlen($validar) < 8) {
            Excepcion::json(['error' => true, 'mensaje' => 'Minimo de 8 caracteres', 'icono' => 'warning', 'campo' => 'confirmar']);
        }

        if (strcmp($validar, $nueva) != 0) {
            Excepcion::json(['error' => true, 'mensaje' => 'Contraseña nueva no coincide', 'icono' => 'warning', 'campo' => 'nueva']);
        }

        $login = $this->sesion->get('login');

        //regrear

        $existe = $this->modelo->existe(array(
            'correo' => $correo
        ));

        if (!$existe) {
            Excepcion::json(['error' => true, 'mensaje' => 'Correo no registrado', 'icono' => 'warning']);
        }

        $codigo = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));

        $this->enviarCodigo($correo, $codigo);

        $this->sesion->set('codigo', $codigo);

        Excepcion::json(array(
            'error' => false
        ));

    }

    public function cambiarCredenciales()
    {
        $this->isAjax();
        $codigo_enviado = $this->sesion->get('codigo');

        $codigo = '';
        $correo = '';
        $nueva = '';
        $validar = '';

        if (isset($_POST['correo'])) {
            $correo = $_POST['correo'];
        }

        if (isset($_POST['codigo'])) {
            $codigo = $_POST['codigo'];
        }

        if (isset($_POST['nueva'])) {
            $nueva = $_POST['nueva'];
        }

        if (isset($_POST['confirmar'])) {
            $validar = $_POST['confirmar'];
        }

        if (strlen($correo) === 0) {
            Excepcion::json(array(
                'error' => true,
                'mensaje' => 'No hay correo proporcionado',
                'icono' => 'warning'
            ));
        }

        if (strlen($codigo) === 0) {
            Excepcion::json(array(
                'error' => true,
                'mensaje' => 'No hay codigo proporcionado',
                'icono' => 'warning'
            ));
        }

        if (strlen($nueva) < 8) {
            Excepcion::json(['error' => true, 'mensaje' => 'Minimo de 8 caracteres', 'icono' => 'warning', 'campo' => 'antigua']);
        }

        if (strlen($validar) < 8) {
            Excepcion::json(['error' => true, 'mensaje' => 'Minimo de 8 caracteres', 'icono' => 'warning', 'campo' => 'validar_contrasena']);
        }

        if (strcmp($validar, $nueva) != 0) {
            Excepcion::json(['error' => true, 'mensaje' => 'Contraseña nueva no coincide', 'icono' => 'warning', 'campo' => 'nueva']);
        }

        $existe = $this->modelo->existe(array(
            'correo' => $correo
        ));

        if (!$existe) {
            Excepcion::json(['error' => true, 'mensaje' => 'Correo no registrado', 'icono' => 'warning']);
        }

        if ($codigo_enviado !== $codigo) {
            Excepcion::json(['error' => true, 'mensaje' => 'Código incorrecto', 'icono' => 'warning']);
        }


        $rowCount = $this->modelo->actualizar(array(
            'contrasena' => $nueva
        ), array(
            'correo' => $correo
        ));

        if ($rowCount) {
            Excepcion::json(['error' => false, 'mensaje' => 'Contraseña cambiada con exito', 'icono' => 'success']);
        }

        Excepcion::json(['error' => true, 'mensaje' => 'Error a la hora de cambiar las credenciales', 'icono' => 'warning']);
    }

    public function iniciarSesion()
    {
        $resultado_validaciones = [];
        if (!isset($_POST['login'])) {
            Excepcion::json(['error' => true, 'tipo' => 'error_sesion']);
        }

        $resultado_validaciones = $this->modelo->validarCampos($_POST['login']);

        if ($resultado_validaciones['error'] === true) {
            Excepcion::json($resultado_validaciones);
        }

        $datos = $resultado_validaciones['datos'];



        $resultado = $this->modelo->existe($datos);

        if ($resultado) {
            $this->crearSesion($datos['usuario']);
            Excepcion::json(['error' => false, 'url' => '/']);
        }

        $usuario = $datos['usuario'];
        unset($datos['usuario']);
        $datos['correo'] = $usuario;

        $resultado = $this->modelo->existe($datos);

        if ($resultado) {
            $this->crearSesion($datos['correo']);
            Excepcion::json(['error' => false, 'url' => '/']);
        }


        Excepcion::json(['error' => true, 'tipo' => 'no_encontrado']);
    }

    public function cerrarSesion()
    {
        $sesion = new Session();
        $sesion->destroy();
        Flight::redirect('/login', 200);
    }

    public function registrar()
    {
        $this->sesionActiva();
        Flight::render('registrar', array());
    }

    public function validarEmpresa($empresa)
    {
        $this->isAjax();

        $existe = $this->modelo->existe(array(
            'nombre' => $empresa
        ));

        $resultado = array();

        if ($existe) {
            $resultado = array(
                'error' => true
            );
        } else {
            $resultado = array(
                'error' => false
            );
        }

        Excepcion::json($resultado);
    }

    public function validarUsuario($usuario)
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $existe = $this->modelo->existe(array(
            'usuario' => $usuario
        ));

        $resultado = array();

        if ($existe) {
            $resultado = array(
                'error' => true
            );
        } else {
            $resultado = array(
                'error' => false
            );
        }

        Excepcion::json($resultado);
    }

    public function validarUsuarioRegistro($usuario)
    {
        $this->isAjax();

        $existe = $this->modelo->existe(array(
            'usuario' => $usuario
        ));

        $resultado = array();

        if ($existe) {
            $resultado = array(
                'error' => true
            );
        } else {
            $resultado = array(
                'error' => false
            );
        }

        Excepcion::json($resultado);
    }

    public function validarCorreo($correo)
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $existe = $this->modelo->existe(array(
            'correo' => $correo
        ));

        $resultado = array();

        if ($existe) {
            $resultado = array(
                'error' => true
            );
        } else {
            $resultado = array(
                'error' => false
            );
        }

        Excepcion::json($resultado);
    }

    public function validarCorreoRegistro($correo)
    {
        $this->isAjax();
        $existe = $this->modelo->existe(array(
            'correo' => $correo
        ));

        $resultado = array();

        if ($existe) {
            $resultado = array(
                'error' => true
            );
        } else {
            $resultado = array(
                'error' => false
            );
        }

        Excepcion::json($resultado);
    }

    public function guardar()
    {
        $this->isAjax();

        $this->validarMetodoPeticion('POST');
        //lo que guardarias seria$_post pos ya xdxdxdxdxdxd :v aca hace falta un monton mas, en eta parte del backend asi como en cuenta
        $resultado_guardar = $this->modelo->insertar($_POST);

        if ($resultado_guardar !== null) {
            $this->crearSesion($_POST['usuario']);
            Excepcion::json(['mensaje' => 'Usuario creado con exito', 'redireccion' => '/']);
        }

        Excepcion::json(array(
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

    public function usuario()
    {
        $this->sesionActiva();

        $this->view('usuario', [
            'js_especifico' => Utiles::printScript('cambiar-datos')
        ], [
            'usuario' => $this->sesion->get('login')['usuario'],
            'correo' => $this->sesion->get('login')['correo']
        ]);
    }

    public function cambiarUsuario()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $usuario = '';

        if (isset($_POST['usuario'])) {
            $usuario = $_POST['usuario'];
        }

        if (strlen($usuario) < 8) {
            Excepcion::json(['error' => true, 'mensaje' => 'Minimo de 8 caracteres', 'icono' => 'warning']);
        }

        $login = $this->sesion->get('login');

        $rowCount = $this->modelo->actualizar(array(
            'usuario' => $usuario
        ), array(
            'id' => $login['id']
        ));


        //Excepcion::json($rowCount);


        if ($rowCount) {
            $this->crearSesion($usuario);
            Excepcion::json(['error' => false, 'mensaje' => 'Usuario modificado con exito', 'icono' => 'success', 'count' => $rowCount]);
        }

        Excepcion::json(['error' => true, 'mensaje' => 'Ocurrio un error al tratar de modificar', 'icono' => 'warning', 'count' => $rowCount, 'test' => $this->modelo->error(), 'usuario' => $usuario]);
    }

    public function cambiarCorreo()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $correo = '';

        if (isset($_POST['correo'])) {
            $correo = $_POST['correo'];
        }

        if (strlen($correo) === 0) {
            Excepcion::json(['error' => true, 'mensaje' => 'Correo vacio', 'icono' => 'warning']);
        }

        $login = $this->sesion->get('login');

        $rowCount = $this->modelo->actualizar(array(
            'correo' => $correo
        ), array(
            'id' => $login['id']
        ));


        //Excepcion::json($rowCount);


        if ($rowCount) {
            $this->crearSesion($correo);
            Excepcion::json(['error' => false, 'mensaje' => 'Correo modificado con exito', 'icono' => 'success', 'count' => $rowCount]);
        }

        Excepcion::json(['error' => true, 'mensaje' => 'Ocurrio un error al tratar de modificar', 'icono' => 'warning', 'count' => $rowCount, 'test' => $this->modelo->error(), 'usuario' => $usuario]);
    }


    public function cambiarContrasena()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $nueva = '';
        $antigua = '';
        $validar = '';

        if (isset($_POST['nueva'])) {
            $nueva = $_POST['nueva'];
        }

        if (isset($_POST['antigua'])) {
            $antigua = $_POST['antigua'];
        }

        if (isset($_POST['validar_contrasena'])) {
            $validar = $_POST['validar_contrasena'];
        }

        if (strlen($nueva) < 8) {
            Excepcion::json(['error' => true, 'mensaje' => 'Minimo de 8 caracteres', 'icono' => 'warning', 'campo' => 'nueva']);
        }

        if (strlen($antigua) < 8) {
            Excepcion::json(['error' => true, 'mensaje' => 'Minimo de 8 caracteres', 'icono' => 'warning', 'campo' => 'antigua']);
        }

        if (strlen($validar) < 8) {
            Excepcion::json(['error' => true, 'mensaje' => 'Minimo de 8 caracteres', 'icono' => 'warning', 'campo' => 'validar_contrasena']);
        }

        if (strcmp($validar, $nueva) != 0) {
            Excepcion::json(['error' => true, 'mensaje' => 'Contraseña nueva no coincide', 'icono' => 'warning', 'campo' => 'nueva']);
        }

        $login = $this->sesion->get('login');

        $existe_contra = $this->modelo->existe(array(
            'contrasena' => $antigua,
            'id' => $login['id']
        ));

        if (!$existe_contra)
            Excepcion::json(['error' => true, 'mensaje' => 'Contraseña antigua incorrecta', 'icono' => 'warning', 'campo' => 'antigua']);

        $existe_contra = $this->modelo->existe(array(
            'contrasena' => $nueva,
            'id' => $login['id']
        ));

        if ($existe_contra)
            Excepcion::json(['error' => true, 'mensaje' => 'No puede colocar la misma contraseña', 'icono' => 'warning', 'campo' => 'antigua']);

        $rowCount = $this->modelo->actualizar(array(
            'contrasena' => $nueva
        ), array(
            'id' => $login['id']
        ));

        //Excepcion::json($this->modelo->error());

        //Excepcion::json($rowCount);

        if ($rowCount > 0) {
            Excepcion::json(['error' => false, 'mensaje' => 'Contrasena modificada con exito', 'icono' => 'success', 'count' => $rowCount]);
        }

        Excepcion::json(['error' => true, 'mensaje' => 'Ocurrio un error al tratar de modificar', 'icono' => 'warning', 'count' => $rowCount]);
    }

    //metodos privados

    private function crearSesion($usuario)
    {

        $sesion = new Session();
        $data = $this->modelo->seleccionar(array('id', 'nombre', 'usuario', 'correo'), array('usuario' => $usuario));

        if(!isset($data[0])){
            $data = $this->modelo->seleccionar(array('id', 'nombre', 'usuario', 'correo'), array('correo' => $usuario));
        }

        $data = $data[0];

        $periodoModel = new PeriodoModel(new Conexion());
        $data['periodo'] = $periodoModel->ultimoPeriodo($data['id']);
        $data['anio'] = $periodoModel->ultimoAnio($data['id']);
        $data['estado'] = $periodoModel->estadoPeriodo($data['periodo'], $data['id']);
        if ($data['estado'] == 'CERRADO') {
            $data['periodo'] = null;
        }
        $sesion->set('login', $data);
    }

    private function enviarCodigo($correo, $codigo)
    {

        $email_user = "sic115.recovery@gmail.com";
        $email_password = "7C83&7\$P94Up#2\$Wevq3yQT%gk7n";
        $the_subject = "Recuperar credenciales";
        $address_to = $correo;
        $from_name = "SIC115";
        $phpmailer = new PHPMailer();

// ———- datos de la cuenta de Gmail ——————————-
        $phpmailer->Username = $email_user;
        $phpmailer->Password = $email_password;
//———————————————————————–
// $phpmailer->SMTPDebug = 1;
        $phpmailer->SMTPSecure = 'ssl';
        $phpmailer->Host = "smtp.gmail.com"; // GMail
        $phpmailer->Port = 465;
        $phpmailer->IsSMTP(); // use SMTP
        $phpmailer->SMTPAuth = true;

        $phpmailer->setFrom($phpmailer->Username, $from_name);
        $phpmailer->AddAddress($address_to); // recipients email


        $phpmailer->Subject = $the_subject;
        $phpmailer->Body .= "<h1 style='color:#3498db;'>Código de recuperación</h1>";
        $phpmailer->Body .= "<h2>$codigo</h2>";
        $phpmailer->Body .= "<p>Fecha: " . Utiles::fecha(date("Y-m-d")) . "</p>";
        $phpmailer->IsHTML(true);

        $phpmailer->Send();
    }


}
