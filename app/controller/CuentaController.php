<?php
require_once './app/libs/Controller.php';
require_once './app/models/CuentaModel.php';

class CuentaController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        $this->modelo = new CuentaModel($conexion);
        parent::__construct();
    }

    public function index()
    {
        $this->sesionActiva();
        $this->view('cuenta', [
            'js_especifico' => Utiles::printScript('cuenta'),
        ]);
    }

    public function tablaCuentas()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        $empresa = $this->sesion->get('login')['id'];

        $datos = $this->modelo->seleccionar('*', array(
            'empresa' => $empresa,
        ));

        Flight::render('ajax/cuentas/tabla-cuentas', array(
            'datos' => $datos,
        ));
    }

    public function modalGuardar()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        Flight::render('ajax/cuentas/modal-guardar');
    }

    public function modalEditar($id)
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        if ($id === null) {
            exit(1);
        }

        $id = base64_decode($id);

        $empresa = $this->sesion->get('login')['id'];

        $cuenta = $this->modelo->seleccionar('*', array(
            'empresa' => $empresa,
            'id' => $id,
        ));

        Flight::render('ajax/cuentas/modal-editar', array(
            'cuenta' => $cuenta[0],
        ));
    }

    public function obtenerDatosCuentaPadre()
    {
        /*
        cuando haya un array dento de otro array es para
        respeterar la forma en que medoo devuelve un conjunto de datos
        un arreglo con los obtenos dentro de otro
        array(array('prueba' => 'asi));
         */

        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $empresa = $this->sesion->get('login')['id'];

        $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';

        $datos = null;
        $existe_cuenta = array(
            'codigo' => $codigo,
            'empresa' => $empresa,
        );

        if ($this->modelo->existe($existe_cuenta)) {
            $datos = array(array(
                'id' => -1, 'nombre' => 'Esta cuenta ya existe',
            ));
        } else {
            $codigo_auxiliar = $codigo;
            $codigo = $this->obtenerCodigoPadre($codigo);

            if (strlen($codigo) > 0) {
                $datos = $this->modelo->seleccionar([
                    'id', 'nombre',
                ], ['codigo' => $codigo, 'empresa' => $empresa]);

            } else if (strlen($codigo_auxiliar) === 1 || (strlen($codigo_auxiliar) == 2
                && strpos(strtoupper($codigo_auxiliar), 'R') > 0)) {
                $datos = array(array(
                    'id' => 0, 'nombre' => 'Cuenta de primer nivel',
                ));
            }
        }

        Flight::render('ajax/cuentas/input-encontrar-padre', array(
            'datosBD' => $datos,
        ));
    }

    public function guardar()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $resultado_validaciones = [];

        if (!isset($_POST['cuenta'])) {
            Exepcion::json(['error' => true]);
        }

        $cuenta_guardar = $_POST['cuenta'];

        $resultado_validaciones = $this->modelo->validarCampos($cuenta_guardar);

        if ($resultado_validaciones['error'] === true) {
            Exepcion::json($resultado_validaciones);
        }

        $cuenta_guardar = $this->ordenarDatosCuentaGuardar($cuenta_guardar);

        $resultado_guardar = $this->modelo->insertar($cuenta_guardar);

        if ($resultado_guardar !== null) {
            if (isset($cuenta_guardar['padre'])) {
                $this->modelo->actualizar([
                    'ultimo_nivel' => 0,
                ], array(
                    'id' => $cuenta_guardar['padre'],
                ));
            }

            Exepcion::json(['error' => false,
                'mensaje' => 'Cuenta Guardada',
            ]);
        }

        Exepcion::json(['error' => true]);
    }

    public function editar()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $empresa = $this->sesion->get('login')['id'];

        if (!isset($_POST['cuenta'])) {
            Exepcion::json(['error' => true, 'mensaje' => 'Hubo un error interno']);
        }

        $cuenta_editar = $_POST['cuenta'];

        if ($cuenta_editar['id'] === '' || $cuenta_editar['nombre'] === ''
            || $cuenta_editar['tipo_saldo'] === '') {
            Exepcion::json(['error' => true, 'mensaje' => 'Hubo un error interno']);
        }

        $id = base64_decode($cuenta_editar['id']);
        unset($cuenta_editar['id']);

        $resultado = $this->modelo->actualizar($cuenta_editar, array(
            'id' => $id,
            'empresa' => $empresa,
        ));

        if ($resultado !== 0) {
            Exepcion::json(['error' => false,
                'mensaje' => 'Cuenta Editada',
            ]);
        } else {
            if ($this->modelo->error()[2] !== null) {
                Exepcion::json(['error' => true,
                    'mensaje' => 'Error al editar en la cuenta',
                ]);
            }else{
                
            }
            Exepcion::json(['error' => false,
                'mensaje' => 'Cuenta Editada',
            ]);

        }
    }

    public function eliminar()
    {

    }

    /*Metodos privados*/

    private function obtenerCodigoPadre($codigo_hijo)
    {
        if (strlen($codigo_hijo) > 0) {
            $codigo_hijo = strtoupper($codigo_hijo);
            $codigo_guardar = str_replace('R', '', $codigo_hijo);
            $tam_hijo = strlen($codigo_hijo);
            $size = strlen($codigo_hijo);
            $padre = '';

            //se busca la R para corrroborar que sea cuenta R
            $cuentaR = (strpos($codigo_hijo, "R"));

            //cantidad de indices a eliminar
            $indices_eliminar = 0;

            //si es cuenta R entonces se especifica que indices se eliminar o no para dejar solo
            //el codigo de las cuentas a acumular saldos
            if ($cuentaR > 0) {
                $indices_eliminar = $size - 3;
            } else {
                $indices_eliminar = $size - 2;
            }

            //se hace la eliminacion de los ultimos 2 o 3 indices para dejar solo
            //las cuentas de mayor

            if ($size > 3) {
                $codigo_hijo = substr($codigo_hijo, 0, $indices_eliminar);
            } else if ($size == 3) {
                $codigo_hijo = substr($codigo_hijo, 0, $size - 2);
            } else if ($size == 2 && $cuentaR > 0) {
                $codigo_hijo = substr($codigo_hijo, 0, $size - 1);
            } else {
                $codigo_hijo = $codigo_hijo[0];
            }

            $size = strlen($codigo_hijo);

            //se comprueba que el codigo sea valido en cuanto a tamaño
            if (($size > 1 && $size % 2 !== 0 && $cuentaR === false)) {
                return '';
            }

            $mayores = array();

            //se recorrera el codigo
            if ($size > 1) {
                for ($i = 0; $i < $size; $i++) {
                    $padre .= $codigo_hijo[$i];

                }
            } else if ($size == 1 && strlen($codigo_guardar) == 2) {
                $padre .= $codigo_hijo[0];
            }
            
            if($tam_hijo>4 && $cuentaR>0){
                $padre.='R';
            }

            return $padre;
        }

        return '';
    }

    private function ordenarDatosCuentaGuardar($datos)
    {

        $datos['empresa'] = $this->sesion->get('login')['id'];

        $datos['codigo'] = strtoupper($datos['codigo']);
        $datos['padre'] = base64_decode($datos['padre']);

        $codigoR = $datos['codigo'];
        if (strpos($datos['codigo'], "R") !== false) {
            $codigoR = str_replace('R', '', $datos['codigo']);
        }

        $datos['orden'] = $datos['codigo'][0];

        if ($datos['padre'] == 0) {
            unset($datos['padre']);
        }

        $datos['nivel'] = 1;

        if (strlen($codigoR) > 1) {
            $datos['nivel'] = (strlen($codigoR) / 2) + 1;
        }

        return $datos;
    }
}
