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
        $estado = $this->sesion->get('login')['estado'];
        $this->view('cuenta', [
            'js_especifico' => Utiles::printScript('cuenta'),
        ], ['estado' => $estado]);
    }

    public function tablaCuentas()
    {
        $this->isAjax();
        $this->sesionActivaAjax();

        $this->validarMetodoPeticion('GET');
        $estado = $this->sesion->get('login')['estado'];

        $empresa = $this->sesion->get('login')['id'];
        $periodo = $this->sesion->get('login')['periodo'];

        $datos = $this->catalogoDeCuentas($empresa, $periodo);

        /* $datos = $this->modelo->seleccionar('*', array(
        'empresa' => $empresa,
        )); */

        Flight::render('ajax/cuentas/tabla-cuentas', array(
            'datos' => $datos,
            'estado' => $estado
        ));

    }

    public function reporteCatalogo()
    {
        $this->sesionActiva();
        $empresa = $this->sesion->get('login')['id'];
        $nombre = $this->sesion->get('login')['nombre'];
        $periodo = $this->sesion->get('login')['periodo'];
        $datos = $this->catalogoDeCuentas($empresa, $periodo);
        Flight::render('pdf/catalogo', array(
            'datos' => $datos,
            'id' => $empresa,
            'empresa' => $nombre
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
        $periodo = $this->sesion->get('login')['periodo'];

        $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';

        $datos = null;
        $existe_cuenta = array(
            'codigo' => $codigo,
            'empresa' => $empresa,
            'periodo' => $periodo
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
                ], ['codigo' => $codigo, 'empresa' => $empresa, 'periodo' => $periodo]);

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

    /*public function arbol()
    {

        $cuentas = $this->catalogoDeCuentas($this->sesion->get('login')['id'], $this->sesion->get('login')['periodo']);

        Flight::render('arbol', [
            'datos' => $cuentas,
        ]);
    }*/

    public function datosGrafica()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        $login = $this->sesion->get('login');

        $consulta = $this->modelo->conexion()->query("select concat(cuenta.codigo, ' - ', cuenta.nombre) nombre, cuenta.saldo 
                                                            from cuenta inner join configuracion on configuracion.cuenta = cuenta.id 
                                                                            where cuenta.empresa = :empresa 
                                                                              and cuenta.periodo = :periodo 
                                                                              and configuracion.periodo = :periodo 
                                                                              and configuracion.descripcion in ('activo', 'pasivo', 'patrimonio')", array(
            ':empresa' => $login['id'],
            ':periodo' => $login['periodo']
        ))->fetchAll();


        $retorno = array(
            'data' => array(),
            'labels' => array()
        );

        if(count($consulta) > 0){
            for ($i=0; $i < count($consulta); $i++){

                array_push($retorno['data'], $consulta[$i]['saldo']);
                array_push($retorno['label'], $consulta[$i]['nombre']);
            }
        }

        Excepcion::json($retorno);

    }

    public function estructuraCuentas()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        $cuentas = $this->catalogoDeCuentas($this->sesion->get('login')['id'], $this->sesion->get('login')['periodo']);
        $arbol = array();

        foreach ($cuentas as $key => $cuenta) {
            if ($cuenta['nivel'] == 1) {
                $arbol[] = array(
                    'text' => $cuenta['codigo'] . ' - ' . $cuenta['nombre'],
                    'icon' => "fas fa-stream",
                    'codigo' => $cuenta['codigo']
                );
                continue;
            }

            ($this->search_in_array($this->obtenerCodigoPadre($cuenta['codigo']), $arbol, array(
                'text' => $cuenta['codigo'] . ' - ' . $cuenta['nombre'],
                'icon' => "fas fa-stream",
                'codigo' => $cuenta['codigo'],
                'nodes' => array()
            )));

        }
        $this->eliminarVacios($arbol);
        Excepcion::json($arbol);
    }

    public function guardar()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $login = $this->sesion->get('login');

        $resultado_validaciones = [];

        if (!isset($_POST['cuenta'])) {
            Excepcion::json(['error' => true]);
        }

        $cuenta_guardar = $_POST['cuenta'];

        $resultado_validaciones = $this->modelo->validarCampos($cuenta_guardar);

        if ($resultado_validaciones['error'] === true) {
            Excepcion::json($resultado_validaciones);
        }

        $cuenta_guardar = $this->ordenarDatosCuentaGuardar($cuenta_guardar);

        if (isset($cuenta_guardar['padre'])) {
            $padre = $this->modelo->seleccionar(array(
                'codigo', 'saldo'
            ), array(
                'id' => $cuenta_guardar['padre']
            ));


            if ($padre[0]['saldo'] != $this->saldoAcumulado($login['id'], $login['periodo'], $this->modelo, $padre[0]['codigo'])) {
                Excepcion::json([
                    'error' => true,
                    'mensaje' => 'La cuenta padre ya ha sido utilizada en una transacción de forma individual, no se puede utilizar como cuenta padre'
                ]);
            }
        }


        $resultado_guardar = $this->modelo->insertar($cuenta_guardar);

        if ($resultado_guardar !== null) {
            if (isset($cuenta_guardar['padre'])) {
                $this->modelo->actualizar([
                    'ultimo_nivel' => 0,
                ], array(
                    'id' => $cuenta_guardar['padre'],
                ));
            }

            Excepcion::json(['error' => false,
                'mensaje' => 'Cuenta Guardada',
            ]);
        }

        Excepcion::json(['error' => true, 'mensaje' => 'Error interno']);
    }

    public function editar()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $empresa = $this->sesion->get('login')['id'];

        if (!isset($_POST['cuenta'])) {
            Excepcion::json(['error' => true, 'mensaje' => 'Hubo un error interno']);
        }

        $cuenta_editar = $_POST['cuenta'];

        if ($cuenta_editar['id'] === '' || $cuenta_editar['nombre'] === ''
            || $cuenta_editar['tipo_saldo'] === '') {
            Excepcion::json(['error' => true, 'mensaje' => 'Hubo un error interno']);
        }

        $id = base64_decode($cuenta_editar['id']);
        unset($cuenta_editar['id']);

        $resultado = $this->modelo->actualizar($cuenta_editar, array(
            'id' => $id,
            'empresa' => $empresa,
        ));

        if ($resultado !== 0) {
            Excepcion::json(['error' => false,
                'mensaje' => 'Cuenta Editada',
            ]);
        } else {
            if ($this->modelo->error()[2] !== null) {
                Excepcion::json(['error' => true,
                    'mensaje' => 'Error al editar en la cuenta',
                ]);
            } else {

            }
            Excepcion::json(['error' => false,
                'mensaje' => 'Cuenta Editada',
            ]);

        }
    }

    public function eliminar()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        if (!isset($_POST['id'])) {
            Excepcion::json(
                ['error' => true, 'mensaje' => 'Error al procesar esta accion', 'icono' => 'warning']
            );
        }

        $id = base64_decode($_POST['id']);
        $login = $this->sesion->get('login');
        $cuenta = $this->modelo->seleccionar(array('codigo', 'padre', 'nivel'), array(
            'empresa' => $login['id'],
            'periodo' => $login['periodo'],
            'id' => $id
        ));


        $cuenta = $cuenta[0];

        var_dump($cuenta);
        $padre = $cuenta['padre'];

        $this->modelo->eliminar(array(
            'id' => $id
        ));

        if($cuenta['nivel']>1){
            $codigo_padre = $this->modelo->seleccionar(array('codigo'), array(
                'empresa' => $login['id'],
                'periodo' => $login['periodo'],
                'id' => $padre
            ));

            $codigo_padre = $codigo_padre[0]['codigo'];


            $cuenta_padre = $this->modelo->conexion()->query('select count(*) hijos from cuenta where codigo like :codigo and empresa = :empresa and periodo = :periodo and id != :padre',
                array(
                    ':codigo' => $codigo_padre . '%',
                    ':empresa' => $login['id'],
                    ':periodo' => $login['periodo'],
                    'padre' => $padre
                ))->fetchAll();

            var_dump($cuenta_padre);


            if ($cuenta_padre[0]['hijos'] == 0) {
                $this->modelo->actualizar(array(
                    'ultimo_nivel' => 1
                ), array(
                    'id' => $padre
                ));
            }
        }

        Excepcion::json(
            ['error' => false, 'mensaje' => 'Cuenta eliminada correctamente', 'icono' => 'success']
        );


    }

    public function inputSeleccionarCuenta()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        $empresa = $this->sesion->get('login')['id'];
        $periodo = $this->sesion->get('login')['periodo'];

        $datos = $this->modelo->seleccionar(array(
            'id', 'nombre', 'codigo', 'tipo_saldo',
        ), array(
            'empresa' => $empresa,
            'periodo' => $periodo,
            'ultimo_nivel' => 1,
        ));

        Flight::render('ajax/cuentas/input-select-cuenta', array(
            'datosBD' => $datos,
        ));
    }

    public function inputNiveles()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $empresa = $this->sesion->get('login')['id'];
        $periodo = $this->sesion->get('login')['periodo'];

        $periodo = isset($_POST['periodo']) ? base64_decode($_POST['periodo']) : $periodo;


        $datos = $this->modelo->conexion()->query('SELECT distinct nivel from cuenta inner
                    join empresa on empresa.id = cuenta.empresa
                        where empresa.id = :empresa and cuenta.periodo = :periodo', array(
            'empresa' => $empresa,
            'periodo' => $periodo
        ))->fetchAll();

        Flight::render('ajax/cuentas/input-niveles', array(
            'datosBD' => $datos,
        ));
    }

    public function inputNivelesBalanza()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        $empresa = $this->sesion->get('login')['id'];
        $periodo = $this->sesion->get('login')['periodo'];

        $periodo = isset($_POST['periodo']) ? base64_decode($_POST['periodo']) : $periodo;


        $datos = $this->modelo->conexion()->query('SELECT distinct nivel from cuenta inner
                    join empresa on empresa.id = cuenta.empresa
                        where empresa.id = :empresa and cuenta.periodo = :periodo', array(
            'empresa' => $empresa,
            'periodo' => $periodo
        ))->fetchAll();

        Flight::render('ajax/cuentas/input-niveles', array(
            'datosBD' => $datos,
        ));
    }


    public function buscarCuentaConfiguracion()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        $data = isset($_POST['data']) ? $_POST['data'] : array();

        $empresa = $this->sesion->get('login')['id'];
        $periodo = $this->sesion->get('login')['periodo'];

        $cuenta = $this->modelo->seleccionar(array(
            'id', 'nombre',
        ), array(
            'empresa' => $empresa,
            'codigo' => $data['codigo'],
            'periodo' => $periodo
        ));

        if (empty($cuenta)) {
            $data['cuenta'] = -1;
            $data['nombre_cuenta'] = '';
        } else {
            $cuenta = $cuenta[0];

            $data['cuenta'] = base64_encode($cuenta['id']);
            $data['nombre_cuenta'] = $cuenta['nombre'];
        }

        Flight::render('ajax/configuracion/configuracion-individual', array(
            'data' => $data,
        ));

    }

    /*Metodos privados*/

    public function search_in_array($srchvalue, &$array, $data)
    {
        if (is_array($array) && count($array) > 0) {
            $foundkey = array_search($srchvalue, $array);
            if ($foundkey === FALSE) {
                foreach ($array as $key => &$value) {
                    if (is_array($value) && count($value) > 0) {
                        $foundkey = $this->search_in_array($srchvalue, $value, $data);
                        if ($foundkey != FALSE)

                            return $foundkey;
                    }
                }
            } else
                $array['nodes'][] = $data;
            return $foundkey;
        }

    }

    public function eliminarVacios(&$arreglo)
    {
        foreach ($arreglo as $key => &$posicion) {
            if(isset($posicion['nodes'])){
                if (count($posicion['nodes']) > 0) {
                    $this->eliminarVacios($posicion['nodes']);
                } else {
                    unset($arreglo[$key]['nodes']);
                }
            }
        }
    }

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
            //1201R -> 12R
            /* if($tam_hijo>4 && $cuentaR>0){
            $padre.='R';
            } */

            if ($cuentaR > 0) {
                $tam_hijo--;
                if ($tam_hijo > 4) {
                    $padre .= 'R';
                }

            }

            return $padre;
        }

        return '';
    }

    private function ordenarDatosCuentaGuardar($datos)
    {

        var_dump($datos);
        $datos['empresa'] = $this->sesion->get('login')['id'];
        $datos['periodo'] = $this->sesion->get('login')['periodo'];
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

        var_dump($datos);

        return $datos;
    }

    private function catalogoDeCuentas($empresa, $periodo)
    {
        $arreglo = array();

        $nivel_maximo = $this->modelo->obtenerUno(['nivel'], [
            'empresa' => $empresa,
            'periodo' => $periodo,
            'ORDER' => [
                'nivel' => 'DESC',
            ],
        ]);

        $niveles = $this->modelo->seleccionar('*', [
            'empresa' => $empresa,
            'periodo' => $periodo,
            'nivel' => 1,
        ]);

        foreach ($niveles as $key => $nivel) {

            array_push($arreglo, $nivel);
            $this->subCuentas($arreglo, 2, $nivel['id'], $nivel_maximo, $empresa, $periodo);
        }

        return $arreglo;

    }

    private function subCuentas(&$arreglo, $nivel, $id, $nivel_maximo, $empresa, $periodo)
    {
        if ($nivel <= $nivel_maximo) {
            $sub_cuentas = $this->modelo->seleccionar('*', [
                'empresa' => $empresa,
                'nivel' => $nivel,
                'padre' => $id,
                'periodo' => $periodo,
                'ORDER' => array(
                    'codigo' => 'ASC',
                ),
            ]);


            foreach ($sub_cuentas as $key => $sub_cuenta) {
                array_push($arreglo, $sub_cuenta);
                $this->subCuentas($arreglo, $nivel + 1, $sub_cuenta['id'], $nivel_maximo, $empresa, $periodo);
            }
        }
    }

    private function saldoAcumulado($empresa, $periodo, CuentaModel $cuenta_model, $codigo)
    {
        $saldos = $cuenta_model->conexion()->query(
            'SELECT codigo, saldo, tipo_saldo FROM cuenta where codigo like :codigo and empresa = :empresa and periodo = :periodo'
            , array(
            'codigo' => '%' . $codigo . '%',
            'periodo' => $periodo,
            'empresa' => $empresa
        ))->fetchAll();

        $saldo = 0;

        var_dump($saldos);
        foreach ($saldos as $key => $cuenta) {
            if ($cuenta['codigo'] !== $codigo) {
                if ($cuenta['tipo_saldo'] === 'Deudor') {
                    $saldo += $cuenta['saldo'];
                } else {
                    $saldo -= $cuenta['saldo'];
                }
            }
        }

        return $saldo;

    }
}

