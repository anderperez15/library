<?php
require './fpdf/fpdf.php';
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SelectMonth.php';
$selectInstitution=ejecutarSQL::consultar("SELECT * FROM institucion");
$dataInstitution=mysqli_fetch_array($selectInstitution);
class PDF extends FPDF{
}
$pdf=new PDF('L','mm',array(216,330));
$pdf->AddPage();
$pdf->SetFont("Helvetica","",20);
$pdf->SetMargins(25,20,25);
$pdf->Image('../assets/img/jg.png',40,20,20,20);
$pdf->Image('../assets/img/file.png',270,20,18,20);
$pdf->Ln(20);
$pdf->Cell (0,5,utf8_decode($dataInstitution['Nombre']),0,1,'C');
$pdf->Ln(5);
$pdf->SetFont("Helvetica","",14);
$pdf->Cell (0,5,utf8_decode('Inventario General de Carpetas | Archivo Central '),0,1,'C');
$pdf->Ln(12);
$SAC=ejecutarSQL::consultar("SELECT * FROM categoria ORDER BY CodigoCategoria ASC");
$CountTotal=0;
$CountTotalUnits=0;
while($DSAC=mysqli_fetch_array($SAC)){
    $SABC=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoCategoria='".$DSAC['CodigoCategoria']."' ORDER BY Titulo ASC");
    if(mysqli_num_rows($SABC)>=1){
        $pdf->SetFillColor(255,204,188);
        $pdf->SetFont("Helvetica","b",10);
        $pdf->Cell (0,6,utf8_decode($DSAC['CodigoCategoria'].' Categoría de '.$DSAC['Nombre']),1,0,'C',true);
        $pdf->Ln(6);
        $pdf->SetFillColor(179,229,252);
        $pdf->Cell (64,6,utf8_decode('CÓDIGO CARPETA'),1,0,'C',true);
        $pdf->Cell (100,6,utf8_decode('NOMBRE CARPETA'),1,0,'C',true);
        $pdf->Cell (65,6,utf8_decode('DIRECCIÓN'),1,0,'C',true);
        $pdf->Cell (35,6,utf8_decode('REFERENCIA'),1,0,'C',true);
        $pdf->Cell (16,6,utf8_decode('AÑO'),1,0,'C',true);
        $pdf->Ln(6);
        $pdf->SetFont("Times","",10);
        while($DSABC=mysqli_fetch_array($SABC)){
            $bookCode=$DSABC['CodigoInfraestructura'].'-'.$DSABC['CodigoCategoria'].'-'.$DSABC['CodigoCorrelativo'];
            $PriceT=$DSABC['Estimado']*$DSABC['Existencias'];
            $pdf->Cell (64,6,utf8_decode($bookCode),1,0,'C');
            $pdf->Cell (100,6,utf8_decode($DSABC['Titulo']),1,0,'C');
            $pdf->Cell (65,6,utf8_decode($DSABC['Autor']),1,0,'C');
            $pdf->Cell (35,6,utf8_decode($DSABC['Pais']),1,0,'C');
            $pdf->Cell (16,6,utf8_decode($DSABC['Year']),1,0,'C');
            $pdf->Ln(6);
            $CountTotal=$CountTotal+$PriceT;
            $CountTotalUnits=$CountTotalUnits+$DSABC['Existencias']-1;
        }
    }
    mysqli_free_result($SABC);
}
mysqli_free_result($SAC);
$pdf->SetFillColor(255,229,127);
$pdf->SetFont("Helvetica","b",10);
$pdf->Cell (82,6,utf8_decode(''),0,0);
$pdf->Cell (82,6,utf8_decode(''),0,0);
$pdf->Cell (116,6,utf8_decode('TOTAL CARPETAS:  '.$CountTotalUnits),1,0,'C',true);
$pdf->Output('Reporte_Inventario_General_'.$dataInstitution['Year'],'I');
mysqli_free_result($selectInstitution);