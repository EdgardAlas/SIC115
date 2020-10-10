<?php

error_reporting(E_ALL);

require './app/config/config.php';

date_default_timezone_set('America/El_Salvador');

Flight::map('notFound', function () {
    header("HTTP/1.0 404 Not Found");
    $url =  trim(Flight::request()->url,'/');
    Flight::render('error/404', 404);
});

 Flight::map('error', function (Exception $ex) {
    header("HTTP/1.0 500 Internal Server Error");
    
    /* echo $ex->getTraceAsString();
    echo '<br>';
    echo $ex->getMessage(); */
    var_dump($ex);
    
});  

Flight::route('/codigo', function(){
    function codigoSiguiente($codigo, $array = []) {    
        
        $existeR = (strpos($codigo, "R"));

        $codigoSinR = str_replace('R','',$codigo);

        array_push($array, $codigo);

        $size = strlen($codigoSinR);

        
        if($size===1){
            return $array;
        }if($size===2){
            return codigoSiguiente($codigo[0], $array);
        }else if($existeR>0 && $size-2 > 4){
            $cuenta = substr($codigoSinR, 0, $size-2).'R';
            return codigoSiguiente($cuenta,$array);
        }else if($size>2){
            $cuenta = substr($codigoSinR, 0, $size-2);
            return codigoSiguiente($cuenta,$array);
        }
    }

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
    
    $controlador = $controlador ? $controlador : 'Home';
    $nombreControlador = $controlador.'Controller';
    $nombreArchivoControlador = './app/controller/' . $nombreControlador . '.php';

    //se busca el archivo del controlador
    if (file_exists($nombreArchivoControlador)) {
        require_once $nombreArchivoControlador;
    }

    //se verifica si existe la clase del controlador
    if (!class_exists($nombreControlador)) {
        Exepcion::noEncontrado();
    }

    //se crea una instancia del controlador
    $objControlador = new $nombreControlador(Flight::conexion());

    //se busca el metodo especifico y se pasa el parametro si lo hay
    if (!$metodo) {
        $objControlador->index();
    } else {

        if (!method_exists($objControlador, $metodo)) {
            Exepcion::noEncontrado();
        }
        try {
            $objControlador->$metodo($id);
        } catch (Exception $e) {
//            Exepcion::generarExcepcion('');
            echo $e->getMessage();
        }
    }
});

Flight::start();
