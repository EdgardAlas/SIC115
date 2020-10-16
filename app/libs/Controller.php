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

    protected function viewOne($ruta, $variables = array())
    {
        Flight::render($ruta, $variables);
    }

    protected function view($main = '', $variables = array())
    {
        Flight::render('template/navbar', array(), 'navbar');
        Flight::render('template/sidebar', array(), 'sidebar');
        ($main !== '') ? Flight::render($main, array(), 'main') : '';
        Flight::render('template/footer', array(), 'footer');
        Flight::render('template/layout', $variables);
    }

    //validar el metodo correcto para el acceso
    protected function validarPeticion($request, $metodo)
    {
        if ($request !== $metodo) {
            Exepcion::generarExcepcion('Peticion no permitida');
        }
    }

    protected function isAjax()
    {
        if (!flight::request()->ajax) {
            Exepcion::generarExcepcion('No es una peticion ajax');
        }
    }

    protected function isNotAjax()
    {
        if (flight::request()->ajax) {
            Exepcion::generarExcepcion('Es peticion ajax');
        }
    }

    protected function sesionActiva()
    {
        $this->isNotAjax();
        
        $sesion = new Session();

        $url =  trim(Flight::request()->url,'/');

        if ($sesion->get('login') === null && $url === 'login') {
            return '';
        }

        if ($sesion->get('login') === null) {
            Flight::redirect('/login', 200);
            exit();
        }

        if ($sesion->get('login') !== null && $url === 'login') {
            Flight::redirect('/', 200);
            exit();
        }

        return;
    }

    protected function validarMetodoPeticion($metodo)
    {
        if (Flight::request()->method !== $metodo) {
            Exepcion::generarExcepcion('Error en la peticion');
        }
    }

    protected function sesionActivaAjax()
    {
        $sesion = new Session();
        if ($sesion->get('login') === null) {
            Exepcion::generarExcepcion('No ha iniciado sesion');
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

    public function validarPeriodo(){
        $periodo = $this->sesion->get('login')['periodo'];
        if($periodo===null){
            $this->view('sin-periodo', []);
            return;
        }
    } 

}
