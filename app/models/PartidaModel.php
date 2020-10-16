<?php

require_once './app/libs/Model.php';

class PartidaModel extends Model
{
    private $tabla;
    
    private $validaciones;

    public function __construct($conexion){
        $this->tabla = "Partida";

        parent::__construct($this->tabla, $conexion);
    }

    public function validarCampos($datos){
        return $this->_validarCampos($datos,$this->validaciones);
    }

    public function generarNumeroPartida($empresa, $periodo)
    {
        $numero = $this->conexion->query(
            'SELECT partida.numero from empresa inner join periodo 
                on periodo.empresa = empresa.id inner join partida 
                on partida.periodo = periodo.id 
                where empresa.id = :empresa 
                and periodo.id = :periodo order by numero desc limit 1', 
            [
                ':empresa' => $empresa,
                ':periodo' => $periodo
            ]
        )->fetchAll();
        
        $numero = (empty($numero)) ? 0 : $numero[0]['numero'];
        return $numero+1;
    }

    public function obtenerPartidas($cuentas, $condicion){
        foreach ($cuentas as $key => $cuenta) {
            $condicion['cuenta'] = $cuenta['codigo'];

            $partida = $this->obtenerPartidaPorCuenta($condicion);

            $cuentas[$key]['partidas'] = $partida;
        }

        return $cuentas;
    }

    private function obtenerPartidaPorCuenta($condicion){
        $partida = $this->conexion->query(
            'SELECT partida.numero, partida.fecha, partida.descripcion, cuenta.codigo, dp.movimiento, dp.monto 
                from partida
                    inner join detalle_partida dp on partida.id = dp.partida
                    inner join cuenta on cuenta.id = dp.cuenta 
                    inner join empresa on empresa.id = cuenta.empresa
                    inner join periodo on periodo.empresa = empresa.id
                        where periodo.id = :periodo and empresa.id = :empresa 
                        and cuenta.codigo like :cuenta
                        and partida.fecha between :fecha_inicial and :fecha_final', 
            [
                ':empresa' => $condicion['empresa'],
                ':periodo' => $condicion['periodo'],
                ':cuenta' => $condicion['cuenta'].'%',
                ':fecha_inicial' => $condicion['fecha_inicial'],
                ':fecha_final' => $condicion['fecha_final']
            ]
        )->fetchAll();
    
        
        return $partida;
    }

}
