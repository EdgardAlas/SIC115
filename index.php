<?php

error_reporting(E_ALL);

require './app/config/config.php';

date_default_timezone_set('America/El_Salvador');

Flight::map('notFound', function () {
    header("HTTP/1.0 404 Not Found");
    /* $url =  trim(Flight::request()->url,'/'); */
    Flight::render('error/404', 404);
});

Flight::map('error', function(Exception $ex){
    // Handle error
//    var_dump($ex);
    Flight::render('error/500', 500);
});

//MVC creditos: https://steemit.com/php/@kalangaum/easy-php-routing-management

Flight::route('/(@controlador(/@metodo(/@id)))', function ($controlador, $metodo, $id) {

    //si no hay un controlador se asigna el por defecto

    $partesControlador = explode('-', $controlador);
    $controlador = "";
    foreach ($partesControlador as $key => $parte) {
        $controlador .= ucfirst(strtolower($parte));
    }


    //Metodo
    $partesMetodo = explode('-', $metodo);
    $metodo = '';
    foreach ($partesMetodo as $key => $parte) {
        if($key!==1){
            $metodo .= ucfirst(strtolower($parte));
        }else{
            $metodo .= (strtolower($parte));
        }
    }
    
    $controlador = $controlador ? $controlador : 'Inicio';
    $nombreControlador = $controlador.'Controller';
    $nombreArchivoControlador = './app/controller/' . $nombreControlador . '.php';

    //se busca el archivo del controlador
    if (file_exists($nombreArchivoControlador)) {
        require_once $nombreArchivoControlador;
    }

    //se verifica si existe la clase del controlador
    if (!class_exists($nombreControlador)) {
        Excepcion::noEncontrado();
    }

    //se crea una instancia del controlador
    $objControlador = new $nombreControlador(new Conexion());

    //se busca el metodo especifico y se pasa el parametro si lo hay
    if (!$metodo) {
        $objControlador->index();
    } else {

        if (!method_exists($objControlador, $metodo)) {
            Excepcion::noEncontrado();
        }
        try {
            $objControlador->$metodo($id);
        } catch (Exception $e) {

            Excepcion::generarExcepcion('Error interno');

//            var_dump($_SESSION);
        }
    }
});

Flight::start();
