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
        $this->sesionActiva();

        $this->view('backup', [
            'js_especifico' => Utiles::printScript('backup'),
        ], []);
    }

    public function generarBackup(){
        $json = $this->modelo->generarJSON();


        $login = $this->sesion->get('login');
        $time = time();
        $filename = 'backup_periodo_'.$login['anio'].'_generado_'.date("d-m-Y (h:i:s a)", $time).'.sic115';

        header('Content-disposition: attachment; filename='.$filename);

        echo(base64_encode($json));
    }

    public function restaurar(){

        if(empty($_FILES)){
            Excepcion::json([
                'error' => true,
                'mensaje' => 'No hay archivos',
                'icono' => 'warning'
            ]);
        }

        $ext_permitidas = array('sic115');
        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $ext_permitidas)) {
            Excepcion::json([
                'error' => true,
                'mensaje' => 'Extensión no soportada',
                'icono' => 'warning'
            ]);
        }




        $str = file_get_contents($_FILES["file"]["tmp_name"]);

        if(!Utiles::is_base64($str)){
            Excepcion::json([
                'error' => true,
                'mensaje' => 'El archivo esta dañado',
                'icono' => 'warning'
            ]);
        }

        $json = json_decode(base64_decode($str), true);

        //Excepcion::json($json);
        Excepcion::json($this->modelo->restaurrBackup($json));


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
