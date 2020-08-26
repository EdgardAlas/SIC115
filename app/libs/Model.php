<?php

class Model
{
    protected $conexion;
    private $tabla;

    protected function __construct($tabla, Conexion $conexion)
    {
        $this->conexion = $conexion->obtenerConexion();
        $this->tabla = $tabla;
    }

    protected function _validarCampos($datos, $validaciones = [])
    {
        $gump = new GUMP();

        $gump->validation_rules($validaciones['reglas']);
        $gump->filter_rules($validaciones['filtros']);

        $valid_data = $gump->run($datos);

        $retorno_json = [];

        if ($gump->errors()) {
            $retorno_json = [
                'error' => true, 
                'tipo' => 'validaciones', 
                'errores' => $gump->get_errors_array()
            ];
        } else {
            $retorno_json = [
                'error' => false,
                'datos' => $valid_data
            ];
        }

        return $retorno_json;
    }

    public function insertar($registro)
    {
        $this->conexion->insert($this->tabla, $registro);
        return $this->conexion->id();
    }

    public function actualizar($registro, $condicion = '')
    {
        return $this->conexion->update($this->tabla, $registro, $condicion)->rowCount();
    }

    public function eliminar($condicion = '')
    {
        return $this->conexion->delete($this->tabla, $condicion)->rowCount();
    }

    public function seleccionar($campos, $condicion = '')
    {
        return $this->conexion->select($this->tabla, $campos, $condicion);
    }

    public function existe($condicion = '')
    {
        return $this->conexion->has($this->tabla, $condicion);
    }

    public function last()
    {
        return $this->conexion->last();
    }

}
