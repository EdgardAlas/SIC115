<?php
require_once './app/libs/Model.php';

class PeriodoModel extends Model
{
    private $tabla;
    private $validacion;

    public function __construct(Conexion $conexion)
    {
        $this->tabla = "periodo";
        
        parent::__construct($this->tabla, $conexion);
    }

    public function ultimoPeriodo($empresa)
    {
        $periodo = $this->conexion->get($this->tabla, 'id', array(
            'empresa' => $empresa,
            'ORDER' => array(
                'id' => 'DESC'
            )
        ));
        
        return $periodo;
    }

    public function estadoPeriodo($periodo, $empresa)
    {
        $estado = $this->conexion->get($this->tabla, 'estado', array(
            'id' => $periodo,
            'empresa' => $empresa,
            'ORDER' => array(
                'estado' => 'DESC'
            )
        ));
        return $estado;
    }

    public function ultimoAnio($empresa)
    {
        $periodo = $this->conexion->get($this->tabla, 'anio', array(
            'empresa' => $empresa,
            'ORDER' => array(
                'anio' => 'DESC'
            )
        ));
        
        return $periodo;
    }

    
}
