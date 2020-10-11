<?php

$data = isset($datos) ? $datos : array();
$empresa = isset($emp) ? $emp : 'Sistema Contable';

use Fpdf\Fpdf;

class PDF extends FPDF
{

    public $empresa;

    public function __construct($empresa) {
        parent::__construct();
        $this->empresa = $empresa;
    }

    public function Header()
    {
        //$this->Image('../view/assets/images//logos/logoreportes.jpg',25,8,30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, $this->empresa, 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(80);
        $this->Cell(30, 10, utf8_decode('Libro Diario'), 0, 0, 'C');
        $this->Ln(15);
        $this->SetFillColor(21, 151, 168);
        $this->SetTextColor(255);
        $this->SetDrawColor(21, 151, 168); // color de linea
        $this->SetLineWidth(.1); // ancho de linea
        $this->SetFont('Arial', 'B', 11);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(25, 5, 'Fecha', 1, 0, 'C', 1);
        $this->Cell(100, 5, 'Cuenta', 1, 0, 'C', 1);
        $this->Cell(32.5, 5, 'Debe', 1, 0, 'C', 1);
        $this->Cell(32.5, 5, 'Haber', 1, 1, 'C', 1);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }

}

$pdf = new PDF($empresa);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetDrawColor(21, 151, 168);
$pdf->SetFont('courier', '', 9);
$pdf->SetFillColor(224, 235, 255); //
$pdf->SetTextColor(0);
$pdf->SetFont('');

$contador_detalle = 0;
$cantidad_detalle= 1;

foreach ($data as $key => $partida) {

    if($contador_detalle===0){
        $cantidad_detalle = array_count_values(array_column($data, 'numero'))[$partida['numero']];
    }

    $pdf->Cell(25, 5, $contador_detalle==0 ? Utiles::fechaSinFormato($partida['fecha']) : '', 'LRB', 0, 'L');
    $pdf->Cell(100, 5, $partida['movimiento']==='Cargo' ? $partida['cuenta'] : '    '.$partida['cuenta'], 'LRB', 0, 'L');
    $pdf->Cell(32.5, 5, ($partida['movimiento'] === 'Cargo' ? Utiles::monto($partida['monto']) : ''), 'LRB', 0, 'R');
    $pdf->Cell(32.5, 5, ($partida['movimiento'] === 'Abono' ? Utiles::monto($partida['monto']) : ''), 'LRB', 1, 'R');

    if($contador_detalle<$cantidad_detalle){
        $contador_detalle++;
    }

    if($contador_detalle===$cantidad_detalle){
        $pdf->SetFont('courier', 'B', 9);
        $pdf->Cell(25, 5, '', 'LRB', 0, 'L');
        $pdf->Cell(100, 5, $partida['descripcion'], 'LRB', 0, 'C');
        $pdf->Cell(32.5, 5, '', 'LRB', 0, 'L');
        $pdf->Cell(32.5, 5, '', 'LRB', 1, 'L');
        $pdf->SetFont('courier', 'B', 9);
        $pdf->Cell(25, 5, '', 'LRB', 0, 'L');
        $pdf->Cell(100, 5, '', 'LRB', 0, 'C');
        $pdf->Cell(32.5, 5, '', 'LRB', 0, 'L');
        $pdf->Cell(32.5, 5, '', 'LRB', 1, 'L');
        $contador_detalle = 0;
        $pdf->SetFont('courier', '', 9);
    }
}
$pdf->Cell(70, 6, '', 'T');
$pdf->Cell(40, 6, '', 'T');
$pdf->Cell(40, 6, '', 'T');
$pdf->Cell(40, 6, '', 'T');
$pdf->Ln();

/* $path = "temp/".$id;

if (!file_exists($path)) {
mkdir($path, 777, true);
} */

$path = "libro-mayor.pdf";

$pdf->Output($path, "D");

header("Content-type: application/pdf");
header('filename="' . basename($path) . '"');
readfile($path);
