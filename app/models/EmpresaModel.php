<?php

require_once './app/libs/Model.php';

class EmpresaModel extends Model
{
    private $tabla;
    
    private $validaciones;

    public function __construct($conexion){
        $this->tabla = "empresa";

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

}
