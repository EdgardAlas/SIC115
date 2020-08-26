<?php

require_once './app/libs/Model.php';

class CuentaModel extends Model
{
    private $tabla;
    
    private $validaciones;

    public function __construct($conexion){
        $this->tabla = "cuenta";

        $this->validaciones = [
            "reglas" => [
                'usuario'    => 'required|alpha_numeric|max_len,100|min_len,6',
                'contrasena'    => 'required|max_len,100|min_len,8',
            ],
            "filtros" => [
                'usuario' => 'trim|sanitize_string',
                'contrasena' => 'trim'
            ]
        ];

        parent::__construct($this->tabla, $conexion);
    }

    public function validarCampos($datos){
        return $this->_validarCampos($datos,$this->validaciones);
    }

    public function listarCuentas($especificos = '*')
    {
        $datos = array();
        $lista =  $this->conexion->select($this->tabla, $especificos);
        return $lista;
    }

    public function obtenerCuenta($identificador)
    {
        return ($this->conexion->select(
            $this->tabla,
            '*',
            ['OR' => [
                "idcuenta" => $identificador,
                "codigo" => $identificador
            ]]
        ));
    }

    public function codigoSiguiente($codigo, $array = []) {    
        
        $codigoSinR = str_replace('R','',$codigo);
        array_push($array, $codigo);
        $size = strlen($codigoSinR);
        
        if($size===1){
            return $array;
        }if($size===2){
            return $this->codigoSiguiente($codigo[0], $array);
        }else if($size>2){
            $cuenta = substr($codigoSinR, 0, $size-2);
            return $this->codigoSiguiente($cuenta,$array);
        }
    }

}
