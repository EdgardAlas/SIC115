<?php

$data = isset($datos) ? $datos : array();
$empresa = isset($emp) ? $emp : 'Sistema Contable';

use Fpdf\Fpdf;

class PDF extends FPDF
{

    public $widths;
    public $aligns;
    public $empresa;

    public function __construct($empresa)
    {
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

$pdf = new PDF($empresa);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetDrawColor(21, 151, 168);
$pdf->SetFont('courier', '', 9);
$pdf->SetFillColor(224, 235, 255); //
$pdf->SetTextColor(0);
$pdf->SetFont('');

$contador_detalle = 0;
$cantidad_detalle = 1;

$pdf->SetWidths(array(25,100,32.5,32.5));
$pdf->SetAligns(array('L', 'L', 'R', 'R'));

foreach ($data as $key => $partida) {

    if ($contador_detalle === 0) {
        $cantidad_detalle = array_count_values(array_column($data, 'numero'))[$partida['numero']];
    }
    $pdf->Row(array(
        $contador_detalle == 0 ? Utiles::fechaSinFormato($partida['fecha']) : '',
        $partida['movimiento'] === 'Cargo' ? iconv('UTF-8', 'cp1252', $partida['cuenta']) : '    ' . iconv('UTF-8', 'cp1252', $partida['cuenta']),
        ($partida['movimiento'] === 'Cargo' ? Utiles::monto($partida['monto']) : ''),
        ($partida['movimiento'] === 'Abono' ? Utiles::monto($partida['monto']) : '')
    ));
    

    if ($contador_detalle < $cantidad_detalle) {
        $contador_detalle++;
    }

    if ($contador_detalle === $cantidad_detalle) {
        $pdf->SetFont('courier', 'B', 9);
        $pdf->SetAligns(array('L', 'C', 'R', 'R'));
        $pdf->Row(array(
            '',iconv('UTF-8', 'cp1252', $partida['descripcion']),'',''
        ));
        $pdf->Row(array(
            '','','',''
        ));
        $contador_detalle = 0;
        $pdf->SetFont('courier', '', 9);
        $pdf->SetAligns(array('L', 'L', 'R', 'R'));
    }
}

$pdf->Ln();

/* $path = "temp/".$id;

if (!file_exists($path)) {
mkdir($path, 777, true);
} */

$path = "libro-diario.pdf";

$pdf->Output($path, "D");

header("Content-type: application/pdf");
header('filename="' . basename($path) . '"');
readfile($path);
