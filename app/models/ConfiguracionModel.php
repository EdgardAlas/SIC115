<?php

require_once './app/libs/Model.php';

class ConfiguracioModel extends Model
{
    private $tabla;

    private $validaciones;

    public function __construct($conexion)
    {
        $this->tabla = "configuracion";


        parent::__construct($this->tabla, $conexion);
    }

    public function validarCampos($datos)
    {
        return $this->_validarCampos($datos, $this->validaciones);
    }

    public function obtenerConfiguracion($empresa, $periodo, $titulos){
        $datos = $this->conexion->select('configuracion', array(
            '[><]cuenta' => array('cuenta' => 'id')
        ), array(
            'configuracion.titulo', 'configuracion.descripcion', 'cuenta.codigo', 'cuenta.orden'
        ), array(
            'cuenta.empresa' => $empresa,
            'configuracion.periodo' => $periodo,
            'titulo' => $titulos
        ));

        return $datos;
    }

}
