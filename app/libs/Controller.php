<?php

class Controller
{

    protected function viewOne($ruta, $variables = array()){
        Flight::render($ruta, $variables);
    }

    protected function view($main = '', $variables = array()){
        Flight::render('template/header', array(), 'header');
        Flight::render('template/sidebar', array(), 'sidebar');
        ($main!=='') ? Flight::render($main, array(), 'main') : '';
        Flight::render('template/footer', array(), 'footer');
        Flight::render('template/layout', $variables);
    }
    
    //validar el metodo correcto para el acceso
    protected function validarPeticion($request,$metodo){
        if($request!==$metodo){
            Exepcion::generarExcepcion('Peticion no permitida');
        }
    }

    protected function isAjax(){
        if(!flight::request()->ajax){
            Exepcion::generarExcepcion('No es una peticion ajax');
        }
    }

    protected function isNotAjax(){
        if(flight::request()->ajax){
            Exepcion::generarExcepcion('Es peticion ajax');
        }
    }

    protected function sesionActiva(){
        $this->isNotAjax();

        $sesion = new Session();

        if($sesion->get('login')===null && Flight::request()->url==='/login'){
            return '';
        }

        if($sesion->get('login')===null){
            Flight::redirect('/login', 200);
            exit();
        }

        if($sesion->get('login')!==null && Flight::request()->url==='/login'){
            Flight::redirect('/', 200);
            exit();
        }

        return;
    }

    protected function sesionActivaAjax(){
        $sesion = new Session();
        if($sesion->get('login')===null){
            Exepcion::generarExcepcion('No ha iniciado sesion');
        }
    }
}
