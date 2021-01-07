<?php

require_once './app/libs/Model.php';
require_once './app/models/DetallePartidaModel.php';
require_once './app/models/PartidaModel.php';
require_once './app/models/ConfiguracionModel.php';
require_once './app/models/CuentaModel.php';
require_once './app/models/PeriodoModel.php';
require_once './app/models/EmpresaModel.php';

class BackupModel
{

    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function generarJSON()
    {
        $conexion = $this->conexion;

        $sesion = new Session();
        $login = $sesion->get('login');

        $detalle_partida_model = new DetallePartidaModel($conexion);
        $partida_model = new PartidaModel($conexion);
        $configuracion_model = new ConfiguracioModel($conexion);
        $cuenta_model = new CuentaModel($conexion);
        $periodo_model = new PeriodoModel($conexion);

        $backup = array();

        $backup['empresa'] = $login['id'];


        /*
         * Periodos
         * */

        $periodos_restaurar = $periodo_model->seleccionar('*', array(
            'empresa' => $login['id'],
            'id[<=]' => $login['periodo']
        ));

        $backup['periodo'] = $periodos_restaurar;


        $periodos_id = array();

        foreach ($periodos_restaurar as $key => $id) {
            $periodos_id[] = $id['id'];
        }

        /*
         * Partidas
         * */
        $partidas = array();
        $partidas_id = array();

        if (!empty($periodos_restaurar)) {
            $partidas = $partida_model->seleccionar('*', array(
                'periodo' => $periodos_id
            ));

            foreach ($partidas as $key => $id) {
                $partidas_id[] = $id['id'];
            }
        }

        $backup['partida'] = $partidas;

        /*
         * Detalle Partidas
         * */

        $detalle_partidas = array();

        if (!empty($partidas_id)) {
            $detalle_partidas = $detalle_partida_model->seleccionar('*', array(
                'partida' => $partidas_id
            ));
        }

        $backup['detalle_partida'] = $detalle_partidas;

        /*
         * Configuraciones
         * */

        $configuraciones = array();

        if (!empty($periodos_id)) {
            $configuraciones = $configuracion_model->seleccionar('*', array(
                'periodo' => $periodos_id
            ));
        }

        $backup['configuracion'] = $configuraciones;

        /*
         * Cuentas
         * */

        $cuentas = $cuenta_model->seleccionar('*', array(
            'periodo' => $periodos_id,
            'empresa' => $login['id']
        ));

        if (empty($periodos_id)) {
            $cuentas = $cuenta_model->seleccionar('*', array(
                'periodo' => null,
                'empresa' => $login['id']
            ));
        }


        $backup['cuenta'] = $cuentas;

        return json_encode($backup);

    }

    public function restaurrBackup($backup)
    {

        /*
         * detalle_partida
         * partida
         * coniguracion
         * cuenta
         * periodo
         * */

        $conexion = $this->conexion;

        $sesion = new Session();
        $login = $sesion->get('login');

        $detalle_partida_model = new DetallePartidaModel($conexion);
        $partida_model = new PartidaModel($conexion);
        $configuracion_model = new ConfiguracioModel($conexion);
        $cuenta_model = new CuentaModel($conexion);
        $periodo_model = new PeriodoModel($conexion);

        if ($login['id'] != $backup['empresa']) {
            return array('error' => true, 'mensaje' => 'Este backup no corresponde a este usuario', 'icono' => 'warning');
        }

        $periodo_model->eliminar(array(
            'empresa' => $login['id']
        ));

        if (!empty($backup['periodo'])) {
            $periodo_model->insertar($backup['periodo']);
        }
        if (!empty($backup['cuenta'])) {

            $cuenta_model->eliminar(array(
                'empresa' => $login['id'],
                'periodo' => null
            ));
            $cuenta_model->insertar($backup['cuenta']);
        }
        if (!empty($backup['configuracion'])) {
            $configuracion_model->insertar($backup['configuracion']);
        }
        if (!empty($backup['partida'])) {
            $partida_model->insertar($backup['partida']);
        }
        if (!empty($backup['detalle_partida'])) {
            $detalle_partida_model->insertar($backup['detalle_partida']);
        }


        $this->crearSesion($login['usuario']);

        return array('error' => false, 'mensaje' => 'Backup restaurado con exito', 'icono' => 'success');

    }

    private function crearSesion($usuario)
    {

        $sesion = new Session();
        $conexion = new Conexion();
        $periodoModel = new PeriodoModel($conexion);
        $empresaModel = new EmpresaModel($conexion);
        $data = $empresaModel->seleccionar(array('id', 'nombre', 'usuario', 'correo'), array('usuario' => $usuario));

        if (!isset($data[0])) {
            $data = $empresaModel->seleccionar(array('id', 'nombre', 'usuario', 'correo'), array('correo' => $usuario));
        }

        $data = $data[0];

        $data['periodo'] = $periodoModel->ultimoPeriodo($data['id']);
        $data['anio'] = $periodoModel->ultimoAnio($data['id']);
        $data['estado'] = $periodoModel->estadoPeriodo($data['periodo'], $data['id']);
        $sesion->set('login', $data);
    }

}
