<?php
require './fpdf/fpdf.php';
include '../library/configServer.php';
include '../library/consulSQL.php';
$selectInstitution=ejecutarSQL::consultar("SELECT * FROM institucion");
$dataInstitution=mysqli_fetch_array($selectInstitution);
class PDF extends FPDF{
}
$pdf=new PDF('P','mm','Letter');
$pdf->AddPage();
$pdf->SetFont("Helvetica","",20);
$pdf->SetMargins(25,20,25);
$pdf->Image('../assets/img/jg.png',25,16,20,20);
$pdf->Image('../assets/img/file.png',170,16,18,20);
$pdf->Ln(10);
$pdf->Cell (0,5,utf8_decode($dataInstitution['Nombre']),0,1,'C');
$pdf->Ln(5);
$pdf->SetFont("Helvetica","",14);
$pdf->Cell (0,5,utf8_decode('Reporte Inventario por Categorías | Archivo Central'),0,1,'C');
$pdf->Ln(2);
$pdf->Ln(20);
$pdf->SetFont("Helvetica","b",10);
$pdf->SetFillColor(255,204,188);
$pdf->Cell (40,6,utf8_decode('CATEGORÍA'),1,0,'C',true);
$pdf->Cell (40,6,utf8_decode('CÓDIGO CATEGORÍA'),1,0,'C',true);
$pdf->Cell (40,6,utf8_decode('TOTAL CARPETAS'),1,0,'C',true);
$pdf->Cell (40,6,utf8_decode('PORCENTAJE'),1,0,'C',true);
$pdf->Ln(6);
$pdf->SetFont("Helvetica","",10);
function Cporcent($NT,$CT,$DC){
    $Res=number_format($NT/$CT ,$DC)*100;
    return $Res;
}
$selBooks=ejecutarSQL::consultar("SELECT * FROM libro");
$totalAllBooks=0;
while($DAL=mysqli_fetch_array($selBooks)){ $totalAllBooks=$totalAllBooks+$DAL['Existencias']; }
$SelCat=ejecutarSQL::consultar("SELECT * FROM categoria ORDER BY CodigoCategoria ASC");
$bookCountP=0;
while($datCat=mysqli_fetch_array($SelCat)){
    $selBCat=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoCategoria='".$datCat['CodigoCategoria']."'");
    $totalCatBooks=0;
    while($DALC=mysqli_fetch_array($selBCat)){ $totalCatBooks=$totalCatBooks+$DALC['Existencias']; }
    $TotalBPorcent=Cporcent($totalCatBooks, $totalAllBooks, 2);
    $bookCountP=$bookCountP+$TotalBPorcent;
    $pdf->Cell (40,6,utf8_decode($datCat['Nombre']),1,0,'C');
    $pdf->Cell (40,6,utf8_decode($datCat['CodigoCategoria']),1,0,'C');
    $pdf->Cell (40,6,utf8_decode($totalCatBooks),1,0,'C');
    $pdf->Cell (40,6,utf8_decode($TotalBPorcent.'%'),1,0,'C');
    $pdf->Ln(6);
    mysqli_free_result($selBCat);
}
mysqli_free_result($SelCat);
$pdf->SetFillColor(179,229,252);
$pdf->SetFont("Helvetica","b",10);
$pdf->Cell (80,6,utf8_decode('TOTAL CARPETAS'),1,0,'C',true);
$pdf->Cell (40,6,utf8_decode($totalAllBooks),1,0,'C',true);
$pdf->Cell (40,6,utf8_decode($bookCountP.'%'),1,0,'C',true);
$pdf->Output('Libros_registrados_categorias_'.$dataInstitution['Year'],'I');
mysqli_free_result($selectInstitution);
mysqli_free_result($selBooks);