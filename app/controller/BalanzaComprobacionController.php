<?php
require_once './app/libs/Controller.php';

class BalanzaComprobacionController extends Controller{
    private $modelo;

public function __construct($conexion)
    {
        /* $this->modelo = new HomeModel($conexion); */
        parent::__construct();
    }

    public function index()
    {
        
        $this->sesionActiva();
        // $this->validarPeriodo();

        $this->view('balanza-comprobacion', [
            'js_especifico' => Utiles::printScript('balanza-comprobacion'),
        ]);
         
        

    }
   

    public function tablaBalanzaComprobacion(){
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');
         // $balanza_model = new BalanzaModel($conexion);
        Flight::render('ajax/balanza-comprobacion/tabla-balanza-comprobacion');    

    }

}
