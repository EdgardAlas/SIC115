<?php

require_once './app/libs/Model.php';

class HomeModel extends Model
{
    private $tabla;
    
    private $validaciones;

    public function __construct($conexion){
        $this->tabla = "cuenta";

        $this->validaciones = [
            "reglas" => [
                'username'    => 'required|alpha_numeric|max_len,100|min_len,6',
                'password'    => 'required|max_len,100|min_len,6',
            ],
            "filtros" => [
                'username' => 'trim|sanitize_string',
                'password' => 'trim'
            ]
        ];

        parent::__construct($this->tabla, $conexion);
    }

    public function validarCampos($datos){
        return $this->_validarCampos($datos,$this->validaciones);
    }

}
