<?php

require './vendor/autoload.php';
require './app/config/constantes.php';
require './app/database/Conexion.php';
require './app/config/Excepcion.php';
require './app/libs/Session.php';
require './app/libs/Utiles.php';

Flight::register('conexion', 'Conexion');

Flight::set('flight.views.path', 'app/views');
