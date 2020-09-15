<?php

$data = isset($datos) ? $datos : array();
$id = isset($id) ? $id : 0;

use Fpdf\Fpdf;

class PDF extends FPDF
{

    public function Header()
    {
        //$this->Image('../view/assets/images//logos/logoreportes.jpg',25,8,30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, 'Sistema Contable', 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(80);
        $this->Cell(30, 10, utf8_decode('Listado de cuentas'), 0, 0, 'C');
        $this->Ln(15);
        $this->SetFillColor(21, 151, 168);
        $this->SetTextColor(255);
        $this->SetDrawColor(21, 151, 168); // color de linea
        $this->SetLineWidth(.1); // ancho de linea
        $this->SetFont('Arial', 'B', 11);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(70, 5, 'Codigo', 1, 0, 'C', 1);
        $this->Cell(120, 5, 'Cuenta', 1, 1, 'C', 1);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetDrawColor(21, 151, 168);
$pdf->SetFont('courier', '', 11);
$pdf->SetFillColor(224, 235, 255); //
$pdf->SetTextColor(0);
$pdf->SetFont('');
foreach ($data as $key => $cuenta) {
    $pdf->Cell(70, 5, $cuenta['codigo'], 'LRB', 0, 'L');
    $pdf->Cell(120, 5, utf8_decode($cuenta['nombre']), 'LRB', 1, 'L');
}
$pdf->Cell(70, 6, '', 'T');
$pdf->Cell(40, 6, '', 'T');
$pdf->Cell(40, 6, '', 'T');
$pdf->Cell(40, 6, '', 'T');
$pdf->Ln();

$path = "temp/".$id;

if (!file_exists($path)) {
    mkdir($path, 777, true);
}

$path .="/catalogo.pdf";

$pdf->Output($path, "F");

header("Content-type: application/pdf");
header('filename="' . basename($path) . '"');
readfile($path);

