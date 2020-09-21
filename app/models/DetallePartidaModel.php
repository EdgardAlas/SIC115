<?php

require_once './app/libs/Model.php';

class DetallePartidaModel extends Model
{
    private $tabla;
    
    private $validaciones;

    public function __construct($conexion){
        $this->tabla = "detalle_partida";

        parent::__construct($this->tabla, $conexion);
    }

    public function validarCampos($datos){
        return $this->_validarCampos($datos,$this->validaciones);
    }

    public function obtenerLibroDiario($condicion = array()){
        return $this->conexion()->query("
        SELECT 
        partida.fecha,
        partida.numero,
        partida.descripcion,
        CONCAT(cuenta.codigo,' - ', cuenta.nombre) cuenta,
        detalle.movimiento,
        detalle.monto
            from detalle_partida detalle 
            inner join partida on detalle.partida = partida.id
            inner join periodo on partida.periodo = periodo.id 
            inner join empresa on periodo.empresa = empresa.id
            inner join cuenta on detalle.cuenta = cuenta.id
                where periodo.id = :periodo and empresa.id = :empresa
                ", array(
                    ':periodo' => $condicion['periodo'],
                    ':empresa' => $condicion['empresa']
                ))->fetchAll();
    }
    

}
