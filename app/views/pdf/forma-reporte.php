<?php

require_once './app/models/CuentaModel.php';
$cuenta_model = new CuentaModel(new Conexion());
$sesion = $_SESSION['login'];

$data = isset($datos) ? $datos : array();
$empresa = isset($empresa) ? $empresa : 'Sistema Contable';

use Fpdf\Fpdf;

class PDF extends FPDF
{

    public $widths;
    public $aligns;
    public $empresa;
    public $anio;

    public function __construct($empresa, $anio)
    {
        parent::__construct();
        $this->empresa = $empresa;
        $this->anio = $anio;
    }

    public function Header()
    {
        //$this->Image('../view/assets/images//logos/logoreportes.jpg',25,8,30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, $this->empresa, 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(80);
        $this->Cell(30, 10, utf8_decode('Balance General al 31 de Diciembre de ' . $this->anio), 0, 0, 'C');
        $this->Ln(15);
        $this->SetFillColor(21, 151, 168);
        $this->SetTextColor(255);
        $this->SetDrawColor(255, 255, 255); // color de linea
        $this->SetLineWidth(.1); // ancho de linea
        $this->SetFont('Arial', 'B', 11);
        $this->SetFont('Arial', 'B', 11);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }

    public function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    public function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    public function Row($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }

        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    public function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }

    }

    public function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }

        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }

        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }

            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }

                } else {
                    $i = $sep + 1;
                }

                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }

        }
        return $nl;
    }
}

$pdf = new PDF($empresa, $sesion['anio']);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetDrawColor(255, 255, 255);
$pdf->SetFont('courier', '', 9);
$pdf->SetFillColor(255, 255, 255); //
$pdf->SetTextColor(0);
$pdf->SetFont('');


$pdf->SetWidths(array(150, 40));
$pdf->SetAligns(array('L', 'R'));

$activo = 0;
$pasivo = 0;
$patrimonio = 0;

$codigo_activo = $data[0]['orden'];
$codigo_pasivo = $data[1]['orden'];
$codigo_patrimonio = $data[2]['orden'];


$codigo = '';

$cuentas_activo = $data[0]['subcuentas'];
$cuentas_pasivo = $data[1]['subcuentas'];
$cuentas_patrimonio = $data[2]['subcuentas'];

$recorrido = 0;
$total_subcuenta = 0;

foreach ($cuentas_activo as $key => $cuenta) {
    if ($codigo != $cuenta['codigo'][0] . $cuenta['codigo'][1]) {

        if ($recorrido > 0) {
            $pdf->SetFont('courier', 'B', 9);
            $pdf->Row(array(
                'Total Activo Corriente',
                Utiles::monto($total_subcuenta)
            ));
            $pdf->Row(array('', ''));
            $total_subcuenta = 0;
            $pdf->SetFont('courier', '', 9);
        }

        $codigo = $cuenta['codigo'][0] . $cuenta['codigo'][1];

        $cuenta_padre = $cuenta_model->seleccionar(['codigo', 'nombre'], array(
            'empresa' => $sesion['id'],
            'periodo' => $sesion['periodo'],
            'codigo' => $codigo
        ));

        $pdf->SetFont('courier', 'B', 9);


        $pdf->Row(array(
            $cuenta_padre[0]['codigo'] . ' - ' . $cuenta_padre[0]['nombre'],
            ''
        ));

        $pdf->SetFont('courier', '', 9);
    }

    if ($cuenta['saldo'] != 0) {
        $pdf->Row(array(
            $cuenta['codigo'] . ' - ' . $cuenta['nombre'],
            (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R' || $cuenta['saldo'] < 0) ? '(' . Utiles::monto(abs($cuenta['saldo'])) . ')'
                : Utiles::monto($cuenta['saldo'])
        ));
    }

    switch ($cuenta['orden']) {
        case $codigo_activo:

            if (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R') {
                $activo -= $cuenta['saldo'];
            } else {
                $activo += $cuenta['saldo'];
            }

            break;
        case $codigo_pasivo:

            if (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R') {
                $pasivo -= $cuenta['saldo'];
            } else {
                $pasivo += $cuenta['saldo'];
            }

            break;
        case $codigo_patrimonio:
            if (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R') {
                $patrimonio -= $cuenta['saldo'];
            } else {
                $patrimonio += $cuenta['saldo'];
            }

            break;
    }


    $recorrido++;

    if (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R') {
        $total_subcuenta -= $cuenta['saldo'];
    } else {
        $total_subcuenta += $cuenta['saldo'];
    }


}

$pdf->SetFont('courier', 'B', 9);
$pdf->Row(array(
    'Total Activo no Corriente',
    Utiles::monto($total_subcuenta)
));
$pdf->Row(array(

    '',
    ''
));
$pdf->SetFont('courier', 'BI', 9);
$pdf->Row(array(
    'Total Activo',
    Utiles::monto($activo)
));
$pdf->Row(array('', ''));
$pdf->SetFont('courier', '', 9);

$total_subcuenta = 0;

$recorrido = 0;
$codigo = '';

//PASIVO

foreach ($cuentas_pasivo as $key => $cuenta) {
    if ($codigo != $cuenta['codigo'][0] . $cuenta['codigo'][1]) {

        if ($recorrido > 0) {
            $pdf->SetFont('courier', 'B', 9);
            $pdf->Row(array(
                'Total Pasivo Corriente',
                Utiles::monto($total_subcuenta)
            ));
            $pdf->Row(array('', ''));
            $total_subcuenta = 0;
            $pdf->SetFont('courier', '', 9);
        }

        $codigo = $cuenta['codigo'][0] . $cuenta['codigo'][1];

        $cuenta_padre = $cuenta_model->seleccionar(['codigo', 'nombre'], array(
            'empresa' => $sesion['id'],
            'periodo' => $sesion['periodo'],
            'codigo' => $codigo
        ));

        $pdf->SetFont('courier', 'B', 9);


        $pdf->Row(array(
            $cuenta_padre[0]['codigo'] . ' - ' . $cuenta_padre[0]['nombre'],
            ''
        ));

        $pdf->SetFont('courier', '', 9);
    }

    if ($cuenta['saldo'] != 0) {
        $pdf->Row(array(
            $cuenta['codigo'] . ' - ' . $cuenta['nombre'],
            (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R' || $cuenta['saldo'] < 0) ? '(' . Utiles::monto(abs($cuenta['saldo'])) . ')'
                : Utiles::monto($cuenta['saldo'])
        ));
    }

    switch ($cuenta['orden']) {
        case $codigo_activo:

            if (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R') {
                $activo -= $cuenta['saldo'];
            } else {
                $activo += $cuenta['saldo'];
            }

            break;
        case $codigo_pasivo:

            if (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R') {
                $pasivo -= $cuenta['saldo'];
            } else {
                $pasivo += $cuenta['saldo'];
            }

            break;
        case $codigo_patrimonio:
            if (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R') {
                $patrimonio -= $cuenta['saldo'];
            } else {
                $patrimonio += $cuenta['saldo'];
            }

            break;
    }


    $recorrido++;

    if (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R') {
        $total_subcuenta -= $cuenta['saldo'];
    } else {
        $total_subcuenta += $cuenta['saldo'];
    }


}

$pdf->SetFont('courier', 'B', 9);
$pdf->Row(array(
    'Total Pasivo no Corriente',
    Utiles::monto($total_subcuenta)
));
$pdf->Row(array(
    'Total Pasivo',
    Utiles::monto($pasivo)
));
$pdf->Row(array('', ''));
$pdf->SetFont('courier', '', 9);

$total_subcuenta = 0;
$recorrido = 0;
$codigo = '';

//Patrimonio

$cuenta_padre = $cuenta_model->seleccionar(['codigo', 'nombre'], array(
    'empresa' => $sesion['id'],
    'periodo' => $sesion['periodo'],
    'codigo' => $codigo_patrimonio
));

$pdf->SetFont('courier', 'B', 9);
$pdf->Row(array(
    $cuenta_padre[0]['codigo'] . ' - ' . $cuenta_padre[0]['nombre'],
    ''
));
$total_subcuenta = 0;
$pdf->SetFont('courier', '', 9);

foreach ($cuentas_patrimonio as $key => $cuenta) {

    if ($cuenta['saldo'] != 0) {
        $pdf->Row(array(
            $cuenta['codigo'] . ' - ' . $cuenta['nombre'],
            (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R' || $cuenta['saldo'] < 0) ? '(' . Utiles::monto(abs($cuenta['saldo'])) . ')'
                : Utiles::monto($cuenta['saldo'])
        ));
    }

    switch ($cuenta['orden']) {
        case $codigo_activo:

            if (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R') {
                $activo -= $cuenta['saldo'];
            } else {
                $activo += $cuenta['saldo'];
            }

            break;
        case $codigo_pasivo:

            if (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R') {
                $pasivo -= $cuenta['saldo'];
            } else {
                $pasivo += $cuenta['saldo'];
            }

            break;
        case $codigo_patrimonio:
            if (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R') {
                $patrimonio -= $cuenta['saldo'];
            } else {
                $patrimonio += $cuenta['saldo'];
            }

            break;
    }


    $recorrido++;

    if (substr($cuenta['codigo'], strlen($cuenta['codigo']) - 1) === 'R') {
        $total_subcuenta -= $cuenta['saldo'];
    } else {
        $total_subcuenta += $cuenta['saldo'];
    }


}

$pdf->SetFont('courier', 'B', 9);
$pdf->Row(array(
    'Total patrimonio',
    Utiles::monto($total_subcuenta)
));
$pdf->Row(array(

    '',
    ''
));
$pdf->SetFont('courier', 'BI', 9);
$pdf->Row(array(
    'Total Pasivo + Patrimonio',
    Utiles::monto($pasivo + $patrimonio)
));
$pdf->Row(array('', ''));
$pdf->SetFont('courier', '', 9);

$total_subcuenta = 0;


/**/

$pdf->Ln();

/* $path = "temp/".$id;

if (!file_exists($path)) {
mkdir($path, 777, true);
} */

$path = "balance-general-forma-reporte.pdf";

$pdf->Output($path, "D");

header("Content-type: application/pdf");
header('filename="' . basename($path) . '"');
readfile($path);
