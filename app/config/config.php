<?php

require './vendor/autoload.php';
require './app/config/constantes.php';
require './app/database/Conexion.php';
require './app/config/Exepcion.php';
require './app/libs/Session.php';

Flight::register('conexion', 'Conexion');

Flight::set('flight.views.path', 'app/views');
