<?php

class Controller
{
    protected $sesion;

    public function __construct()
    {
        $this->sesion = new Session();
        /* $empresa = $this->sesion->get('login')['id']; */
        //$this->recursive_rmdir('temp/'.$empresa);
    }


    protected function eliminarCodigo()
    {
        unset($_SESSION['codigo']);
    }

    protected function viewOne($ruta, $variables = array())
    {
        Flight::render($ruta, $variables);
    }

    protected function view($main = '', $variables = array(), $variables_main = array())
    {
        Flight::render('template/navbar', array(), 'navbar');
        Flight::render('template/sidebar', array(), 'sidebar');
        if ($main !== '')
            Flight::render($main, $variables_main, 'main');
        Flight::render('template/footer', array(), 'footer');
        Flight::render('template/layout', $variables);
    }

    //validar el metodo correcto para el acceso
    protected function validarPeticion($request, $metodo)
    {
        if ($request !== $metodo) {
            Excepcion::generarExcepcion('Peticion no permitida');
        }
    }

    protected function isAjax()
    {
        if (!flight::request()->ajax) {
            Excepcion::generarExcepcion('No es una peticion ajax');
        }
    }

    protected function isNotAjax()
    {
        if (flight::request()->ajax) {
            Excepcion::generarExcepcion('Es peticion ajax');
        }
    }

    protected function sesionActiva()
    {
        $this->isNotAjax();

        $sesion = new Session();

        $url = trim(Flight::request()->url, '/');

        if ($sesion->get('login') === null && ($url === 'login') || ($url === 'login/registrar' || $url === 'login/recuperar')) {
            if($url !== 'login/recuperar'){
                $this->eliminarCodigo();
            }
            return '';
        }

        if ($sesion->get('login') === null) {
            $this->eliminarCodigo();
            Flight::redirect('/login', 200);
            exit();
        }

        if ($sesion->get('login') !== null && ($url === 'login') || ($url === 'login/registrar' || $url === 'login/recuperar')) {
            $this->eliminarCodigo();
            Flight::redirect('/', 200);
            exit();
        }

        return false;
    }

    protected function validarMetodoPeticion($metodo)
    {
        if (Flight::request()->method !== $metodo) {
            Excepcion::generarExcepcion('Error en la peticion');
        }
    }

    protected function sesionActivaAjax()
    {
        $sesion = new Session();
        if ($sesion->get('login') === null) {
            Excepcion::generarExcepcion('No ha iniciado sesion');
        }
    }

    public function recursive_rmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = array_diff(scandir($dir), array('..', '.'));
            foreach ($objects as $object) {
                $objectPath = $dir . "/" . $object;
                if (is_dir($objectPath)) {
                    $this->recursive_rmdir($objectPath);
                } else {
                    unlink($objectPath);
                }

            }
            rmdir($dir);
        }
    }

    public function validarPeriodo()
    {
        $periodo = $this->sesion->get('login')['periodo'];
        if ($periodo === null) {
            $this->view('sin-periodo', []);
            exit();
        }
    }

}
