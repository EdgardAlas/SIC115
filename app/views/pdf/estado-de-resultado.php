<?php

function saldoAcumulado($cuenta, $columna, $cuentas)
{
    $cuenta_auxiliar = Utiles::buscar($cuenta, $columna, $cuentas);

    return (isset($cuenta_auxiliar['subcuentas'])) ? acumularSaldos($cuenta_auxiliar['subcuentas']) : 0;
}

function acumularSaldos($cuentas)
{
    $saldo = 0;
    foreach ($cuentas as $key => $cuenta) {
        if ($cuenta['ultimo_nivel'])
            $saldo += $cuenta['saldo'];
    }
    return $saldo;
}

function imprimirFila($cuentas, $saldo = 0, PDF $pdf, $tipo = false){
    $cuentas = isset($cuentas['subcuentas']) ? $cuentas['subcuentas'] : array();

    foreach ($cuentas as $key => $cuenta){

        $pdf->Row(
           array(
               $cuenta['codigo'].' - '.$cuenta['nombre'],

               $tipo ? ($saldo <0 ? '('.Utiles::monto(($saldo === null) ? $cuenta['saldo'] : abs($saldo)).')':
                   Utiles::monto(($saldo === null) ? $cuenta['saldo'] : abs($saldo))): '',
               !$tipo ? ($saldo <0 ? '('.Utiles::monto(($saldo === null) ? $cuenta['saldo'] : abs($saldo)).')':
                   Utiles::monto(($saldo === null) ? $cuenta['saldo'] : abs($saldo))) : ''
           )
        );
    }
}

function imprimirUtilidad($cuentas, $saldo = 0, PDF $pdf, $tipo = false)
{
    $cuentas = isset($cuentas['subcuentas']) ? $cuentas['subcuentas'] : array();
    $pdf->SetFont('courier', 'B', 9);
    foreach ($cuentas as $key => $cuenta) {
        $pdf->Row(
            array(
                $cuenta['codigo'] . ' - ' . $cuenta['nombre'],

                $tipo ? ($saldo <0 ? '('.Utiles::monto(($saldo === null) ? $cuenta['saldo'] : abs($saldo)).')':
                    Utiles::monto(($saldo === null) ? $cuenta['saldo'] : abs($saldo))): '',
                !$tipo ? ($saldo <0 ? '('.Utiles::monto(($saldo === null) ? $cuenta['saldo'] : abs($saldo)).')':
                    Utiles::monto(($saldo === null) ? $cuenta['saldo'] : abs($saldo))) : ''


            )
        );
        $pdf->SetFont('courier', '', 9);
    }
}

function imprimirValor($titulo , $saldo = 0, PDF $pdf, $tipo = false){


        $pdf->Row(
            array(
                $titulo,
                $tipo ? ($saldo <0 ? '('.Utiles::monto(abs($saldo)).')':
                    Utiles::monto(abs($saldo))): '',
                !$tipo ? ($saldo <0 ? '('.Utiles::monto(abs($saldo)).')':
                    Utiles::monto(abs($saldo))) : ''
            )
        );

}

function imprimirTotal($titulo, $saldo, PDF $pdf, $tipo = false){
    $pdf->SetFont('courier', 'B', 9);


    $pdf->Row(array(
       $titulo,
        $tipo ? ($saldo <0 ? '('.Utiles::monto(abs($saldo)).')':
            Utiles::monto(abs($saldo))): '',
        !$tipo ? ($saldo <0 ? '('.Utiles::monto(abs($saldo)).')':
            Utiles::monto(abs($saldo))) : ''

    ));
    $pdf->SetFont('courier', '', 9);
}


$data = isset($partidas) ? $partidas : array();

$empresa = isset($empresa) ? $empresa : 'Sistema Contable';

$inventario_final = isset($inventario_final) ? $inventario_final: 0;
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
        $this->Cell(30, 10, utf8_decode('Estado de resultado'), 0, 0, 'C');
        $this->Ln(15);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(255);
        $this->SetDrawColor(255, 255, 255); // color de linea
        $this->SetLineWidth(.1); // ancho de linea
        $this->SetFont('Arial', 'B', 11);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(110, 5, 'Cuenta', 1, 0, 'C', 1);
        $this->Cell(40, 5, 'Parcial', 1, 0, 'C', 1);
        $this->Cell(40, 5, 'Saldo', 1, 1, 'C', 1);
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
$pdf->SetDrawColor(255, 255, 255);
$pdf->SetFont('courier', '', 9);
$pdf->SetFillColor(224, 235, 255); //
$pdf->SetTextColor(0);
$pdf->SetFont('');


$pdf->SetWidths(array(110, 40, 40));
$pdf->SetAligns(array('L', 'R', 'R'));


//Ventas netas
$ventas = saldoAcumulado('ventas', 'descripcion', $data);
$rebajas_ventas = saldoAcumulado('rebajas_ventas', 'descripcion', $data);
$devoluciones_ventas = saldoAcumulado('devoluciones_ventas', 'descripcion', $data);

$ventas_netas = $ventas - ($rebajas_ventas + $devoluciones_ventas);

$cuentas_venta = Utiles::buscar('ventas', 'descripcion', $data);

$cuentas_rv = Utiles::buscar('rebajas_ventas', 'descripcion', $data);

$cuentas_dv = Utiles::buscar('devoluciones_ventas', 'descripcion', $data);

imprimirFila($cuentas_venta, null, $pdf );
imprimirFila($cuentas_rv, null, $pdf);
imprimirFila($cuentas_dv, null, $pdf);
imprimirTotal('Ventas Netas', $ventas_netas, $pdf );


/*
 * FIN VENTAS NETAS
 */

/*
 * COSTO DE VENTA
*/

//compras
$compras = saldoAcumulado('compras', 'descripcion', $data);

//gastos sobre compras
$gastos_compras = saldoAcumulado('gastos_compras', 'descripcion', $data);

//compras totales

$compras_totales = $compras + $gastos_compras;

//rebajas y devoluciones sobre compras
$rebajas_compras = saldoAcumulado('rebajas_compras', 'descripcion', $data);

$devoluciones_compras = saldoAcumulado('devoluciones_compras', 'descripcion', $data);

//compras netas
$compras_netas = $compras_totales - ($rebajas_compras + $devoluciones_compras);

//inventario inicial

$inventario_inicial = saldoAcumulado('inventario', 'descripcion', $data);

//mercaderia disponible

$mercaderia_disponible = $compras_netas + $inventario_inicial;

//costo de venta
$costo_venta = $mercaderia_disponible - $inventario_final;

$cuentas_compras =  Utiles::buscar('compras', 'descripcion', $data);
$cuentas_gastos_compras =  Utiles::buscar('gastos_compras', 'descripcion', $data);

$cuentas_rc = Utiles::buscar('rebajas_compras', 'descripcion', $data);
$cuentas_dc = Utiles::buscar('devoluciones_compras', 'descripcion', $data);


imprimirFila($cuentas_compras, null, $pdf, true );
imprimirFila($cuentas_gastos_compras, null, $pdf, true );
imprimirTotal('Compras Totales', $compras_totales, $pdf, true );
imprimirFila($cuentas_rc, null, $pdf, true);
imprimirFila($cuentas_dc, null, $pdf,true);
imprimirTotal('Conpras Netas', $compras_netas, $pdf, true );
imprimirValor('Inventario Inicial', $inventario_inicial, $pdf, true);
imprimirTotal('Mercaderia Disponible', $mercaderia_disponible, $pdf,true );
imprimirValor('Inventario Final', $inventario_final, $pdf, true);
imprimirTotal('Costo de Ventas', $costo_venta, $pdf );
/*
 * FIN COSTO DE VENTA
 */

/*
 * UTILIDAD BRUTA
*/

//utilidad bruta

$utilidad_bruta = $ventas_netas - $costo_venta;
imprimirTotal('Utilidad Bruta', $utilidad_bruta, $pdf );
/*
 * FIN UTILIDAD BRUTA
 */

/*
 * Utilidad de operacion
*/

//gastos de operacion
$gastos_operacion = saldoAcumulado('gastos_operacion', 'descripcion', $data);

//utlidad de operacion

$utilidad_operacion = $utilidad_bruta - $gastos_operacion;

$cuentas_gastos_operacion =  Utiles::buscar('gastos_operacion', 'descripcion', $data);


imprimirFila($cuentas_gastos_operacion, null, $pdf,true);


imprimirTotal('Gastos de Operacion', $gastos_operacion, $pdf );
imprimirTotal('Utilidad de Operacion', $utilidad_operacion, $pdf );

/*
* FIN UTILIDAD BRUTA
*/

/*
 * UTILIDAD ANTES DE IMPUESTOS y RESERVA
*/

//otros productos
$otros_productos = saldoAcumulado('otros_productos', 'descripcion', $data);

//otros gastos
$otros_gastos = saldoAcumulado('otros_gastos', 'descripcion', $data);
//utilidad antes de impuests y resera

$utilidad_antes_impuestos_reserva = $utilidad_operacion + $otros_productos - $otros_gastos;

$cuentas_otros_productos = Utiles::buscar('otros_productos', 'descripcion', $data);
$cuentas_otros_gastos = Utiles::buscar('otros_gastos', 'descripcion', $data);

imprimirFila($cuentas_otros_productos, null,$pdf,true);
imprimirTotal('Otros Productos', $otros_productos, $pdf );
imprimirFila($cuentas_otros_gastos, null,$pdf,true);
imprimirTotal('Otros Gastos', $otros_gastos, $pdf );
imprimirTotal('utilidad antes de Impuestos y Reserva', $utilidad_antes_impuestos_reserva, $pdf );

/*
 * FIN UTILIDAD ANTES DE IMPUESTOS y RESERVA
 */

/*
 *  UTILIDAD ANTES DE IMPUESTO
*/

//reserva legal
$reserva_legal = $utilidad_antes_impuestos_reserva * 0.07;

//utilidad antes de impuestos
$utilidad_antes_impuestos = $utilidad_antes_impuestos_reserva - $reserva_legal;

$cuentas_reserva_legal = Utiles::buscar('reserva_legal', 'descripcion', $data);
imprimirFila($cuentas_reserva_legal, $reserva_legal, $pdf);
imprimirTotal('Utilidad antes de Impuestos', $utilidad_antes_impuestos, $pdf);

/*
 * FIN UTILIDAD ANTES DE IMPUESTO
 */

/*
 *  UTILIDAD DEL EJERCICIO
*/

//impuesto sobre la renta
$impuesto_renta = $utilidad_antes_impuestos * ($ventas_netas > 150000 ? 0.3 : 0.25);

//utilidad antes de impuestos
$utilidad_perdida = $utilidad_antes_impuestos - $impuesto_renta;
$cuentas_impuesto_renta = Utiles::buscar('impuesto_renta', 'descripcion', $data);

imprimirFila($cuentas_impuesto_renta, $impuesto_renta, $pdf);
if ($utilidad_perdida <0){
    $cuentas_perdida = Utiles::buscar('perdida', 'descripcion', $data);
    imprimirUtilidad($cuentas_perdida, $utilidad_perdida,$pdf);
}else{
    $cuentas_utilidad = Utiles::buscar('utilidad', 'descripcion', $data);
    imprimirUtilidad($cuentas_utilidad, $utilidad_perdida,$pdf);
}


/**/

$pdf->Ln();

/* $path = "temp/".$id;

if (!file_exists($path)) {
mkdir($path, 777, true);
} */

$path = "estado-de-resultado.pdf";

$pdf->Output($path, "D");

header("Content-type: application/pdf");
header('filename="' . basename($path) . '"');
readfile($path);

