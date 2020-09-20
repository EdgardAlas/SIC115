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

        var_dump($numero);

        $numero = (empty($numero)) ? 0 : $numero[0]['numero'];
        return $numero+1;
    }

}
