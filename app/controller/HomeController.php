<?php
require_once './app/libs/Controller.php';
require_once './app/models/HomeModel.php';
use PHPMailer\PHPMailer\PHPMailer;

class HomeController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        $this->modelo = new HomeModel($conexion);
        parent::__construct();
    }

    public function index()
    {
        $this->sesionActiva();
        $this->view('inicio', [
            'js_especifico' => Utiles::printScript('home')
        ]);
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

    public function correo(){

        $email_user = "sic115.recovery@gmail.com";
        $email_password = "7C83&7\$P94Up#2\$Wevq3yQT%gk7n";
        $the_subject = "Phpmailer prueba by Evilnapsis.com";
        $address_to = "mahexis407@ailiking.com";
        $from_name = "Evilnapsis";
        $phpmailer = new PHPMailer();

// ———- datos de la cuenta de Gmail ——————————-
        $phpmailer->Username = $email_user;
        $phpmailer->Password = $email_password;
//———————————————————————–
// $phpmailer->SMTPDebug = 1;
        $phpmailer->SMTPSecure = 'ssl';
        $phpmailer->Host = "smtp.gmail.com"; // GMail
        $phpmailer->Port = 465;
        $phpmailer->IsSMTP(); // use SMTP
        $phpmailer->SMTPAuth = true;

        $phpmailer->setFrom($phpmailer->Username,$from_name);
        $phpmailer->AddAddress($address_to); // recipients email

        $phpmailer->Subject = $the_subject;
        $phpmailer->Body .="<h1 style='color:#3498db;'>Hola Mundo!</h1>";
        $phpmailer->Body .= "<p>Mensaje personalizado</p>";
        $phpmailer->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p>";
        $phpmailer->IsHTML(true);

        $phpmailer->Send();
    }
}
