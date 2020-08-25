<?php

error_reporting(E_ALL);

require './app/config/config.php';

Flight::map('notFound', function () {
    header("HTTP/1.0 404 Not Found");
    echo 'No encontrado';
});

Flight::map('error', function (Exception $ex) {
    /* header("HTTP/1.0 500 Internal Server Error");
    Flight::render('error/500'); */
    echo $ex->getMessage();
});  

//MVC creditos: https://steemit.com/php/@kalangaum/easy-php-routing-management

Flight::route('/(@controlador(/@metodo(/@id)))', function ($controlador, $metodo, $id) {

    //si no hay un controlador se asigna el por defecto
    
    $partesControlador = explode('-', $controlador);
    $controlador = "";
    foreach ($partesControlador as $key => $parte) {
        $controlador .= ucfirst(strtolower($parte));
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
        } catch (\Throwable $th) {
            Exepcion::generarExcepcion('');
        }
    }
});

Flight::start();
