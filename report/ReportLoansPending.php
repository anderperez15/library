<?php
require './fpdf/fpdf.php';
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SelectMonth.php';
$userType=consultasSQL::CleanStringText($_GET['user']);
if($userType=="Teacher"){ $tableUser="prestamodocente"; $userType="docentes"; $tableUser2="docente"; $key="DUI"; }
if($userType=="Student"){ $tableUser="prestamoestudiante"; $userType="estudiantes"; $tableUser2="estudiante"; $key="NIE"; }
if($userType=="Visitor"){ $tableUser="prestamovisitante"; $userType="visitantes"; }
if($userType=="Personal"){ $tableUser="prestamopersonal"; $userType="personal administrativo"; $tableUser2="personal"; $key="DUI"; }
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
$pdf->Cell (0,5,utf8_decode('CONTROL DE ARCHIVO '),0,1,'C');
$pdf->Ln(5);
$pdf->Cell (0,5,utf8_decode('DEVOLUCIONES PENDIENTES '),0,1,'C');
$pdf->Ln(12);
$pdf->SetFont("Helvetica","b",10);
$pdf->SetFillColor(255,204,188);
$pdf->Cell (8,6,utf8_decode('N'),1,0,'C',true);
$pdf->Cell (36,6,utf8_decode('CÓDIGO CARPETA'),1,0,'C',true);
$pdf->Cell (104,6,utf8_decode('NOMBRE CARPETA'),1,0,'C',true);
$pdf->Cell (64,6,utf8_decode('SOLICITANTE'),1,0,'C',true);
$pdf->Cell (35,6,utf8_decode('SOLICITUD'),1,0,'C',true);
$pdf->Cell (35,6,utf8_decode('ENTREGA'),1,0,'C',true);
$pdf->Ln(6);
$pdf->SetFont("Helvetica","",10);
$selALoansP=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE Estado='Prestamo' ORDER BY FechaSalida ASC");
$Countb=0;
while($DataALS=mysqli_fetch_array($selALoansP)){
    $selL=ejecutarSQL::consultar("SELECT * FROM ".$tableUser." WHERE CodigoPrestamo='".$DataALS['CodigoPrestamo']."'");
    if(mysqli_num_rows($selL)>0){
        $dataUSRL=mysqli_fetch_array($selL);
        $SelectDayFS=date("d",strtotime($DataALS['FechaSalida']));
        $SelectMonthFS=date("m",strtotime($DataALS['FechaSalida']));
        $SelectYearFS=date("Y",strtotime($DataALS['FechaSalida']));
        $SelectMontNameFS=CalMonth::CurrentMonth($SelectMonthFS);
        $SelectDateFS=$SelectDayFS.' '.$SelectMontNameFS.' '.$SelectYearFS;
        $SelectDayFE=date("d",strtotime($DataALS['FechaEntrega']));
        $SelectMonthFE=date("m",strtotime($DataALS['FechaEntrega']));
        $SelectYearFE=date("Y",strtotime($DataALS['FechaEntrega']));
        $SelectMontNameFE=CalMonth::CurrentMonth($SelectMonthFE);
        $SelectDateFE=$SelectDayFE.' '.$SelectMontNameFE.' '.$SelectYearFE;
        if($userType=="docentes" || $userType=="estudiantes" || $userType=="personal administrativo"){
            $selDUser=ejecutarSQL::consultar("SELECT * FROM ".$tableUser2." WHERE ".$key."='".$dataUSRL[$key]."'");
            $dataUS=mysqli_fetch_array($selDUser);
            $NameUser=$dataUS['Nombre'].' '.$dataUS['Apellido'];
        }else{
            $NameUser=$dataUSRL['Nombre'];
        }
        $selBo=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoLibro='".$DataALS['CodigoLibro']."'");
        $datB=mysqli_fetch_array($selBo);
        $Countb++;
        $pdf->Cell (8,6,utf8_decode($Countb),1,0,'C');
        $pdf->Cell (36,6,utf8_decode($DataALS['CorrelativoLibro']),1,0,'C');
        $pdf->Cell (104,6,utf8_decode($datB['Titulo']),1,0,'C');
        $pdf->Cell (64,6,utf8_decode($NameUser),1,0,'C');
        $pdf->Cell (35,6,utf8_decode($SelectDateFS),1,0,'C');
        $pdf->Cell (35,6,utf8_decode($SelectDateFE),1,0,'C');
        $pdf->Ln(6);
        mysqli_free_result($selDUser);
        mysqli_free_result($selBo);
    }
    mysqli_free_result($selL);
}
mysqli_free_result($selALoansP);
$pdf->Output('Devoluciones_pendientes_'.$userType.'_'.$dataInstitution['Year'],'I');
mysqli_free_result($selectInstitution);