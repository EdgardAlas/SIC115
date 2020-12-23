<?php
require_once './app/libs/Controller.php';
require_once './app/models/BackupModel.php';

class BackupController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        $this->modelo = new BackupModel($conexion);
        parent::__construct();
    }

    public function index()
    {
        $this->viewOne('backup');
    }

    public function generarBackup(){
        $json = $this->modelo->generarJSON();


        $login = $this->sesion->get('login');
        $filename = 'backup_periodo_'.$login['anio'].'.sic115';

        header('Content-disposition: attachment; filename='.$filename);

        echo(base64_encode($json));
    }

    public function leer(){

        if(empty($_FILES)){
            Excepcion::json('No hay archivos');
        }

        $ext_permitidas = array('sic115');
        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $ext_permitidas)) {
            Excepcion::json('Extension no soportada');
        }




        $str = file_get_contents($_FILES["file"]["tmp_name"]);

        if(!Utiles::is_base64($str)){
            Excepcion::json('hay algun error en el archivo');
        }

        $json = json_decode(base64_decode($str));
        Excepcion::json($json);
    }

    public function guardar()
    {

    }

    public function editar()
    {

    }

    public function eliminar()
    {

    }

}
