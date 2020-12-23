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
        $partidas = $partida_model->seleccionar('*', array(
            'periodo' => $periodos_id
        ));

        $partidas_id = array();

        foreach ($partidas as $key => $id) {
            $partidas_id[] = $id['id'];
        }

        $backup['partida'] = $partidas;

        /*
         * Detalle Partidas
         * */


        $detalle_partidas = $detalle_partida_model->seleccionar('*', array(
            'partida' => $partidas_id
        ));

        $backup['detalle_partida'] = $detalle_partidas;

        /*
         * Configuraciones
         * */

        $configuraciones = $configuracion_model->seleccionar('*', array(
            'periodo' => $periodos_id
        ));

        $backup['configuracion'] = $configuraciones;

        /*
         * Cuentas
         * */

        $cuentas = $cuenta_model->seleccionar('*', array(
            'periodo' => $periodos_id,
            'empresa' => $login['id']
        ));

        $backup['cuenta'] = $cuentas;

        return json_encode($backup);

    }

}
