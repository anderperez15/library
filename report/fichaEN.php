﻿<?php
require './fpdf/fpdf.php';
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SelectMonth.php';
$loanCode=consultasSQL::CleanStringText($_GET['loanCode']);
$selectInstitution=ejecutarSQL::consultar("SELECT * FROM institucion");
$dataInstitution=mysqli_fetch_array($selectInstitution);
$selectLoan=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoPrestamo='".$loanCode."'");
$dataLoan=mysqli_fetch_array($selectLoan);
$selectBook=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoLibro='".$dataLoan['CodigoLibro']."'");
$dataBook=mysqli_fetch_array($selectBook);
$selectUserKey=ejecutarSQL::consultar("SELECT * FROM prestamoestudiante WHERE CodigoPrestamo='".$loanCode."'");
$dataKey=mysqli_fetch_array($selectUserKey);
$selectUser=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE NIE='".$dataKey['NIE']."'");
$dataUser=mysqli_fetch_array($selectUser);
$selectRepresentative=ejecutarSQL::consultar("SELECT * FROM encargado WHERE DUI='".$dataUser['DUI']."'");
$dataRepresentative=mysqli_fetch_array($selectRepresentative);
$selectSection=ejecutarSQL::consultar("SELECT * FROM seccion WHERE CodigoSeccion='".$dataUser['CodigoSeccion']."'");
$dataSection=mysqli_fetch_array($selectSection);
$selectTeacher=ejecutarSQL::consultar("SELECT * FROM docente WHERE CodigoSeccion='".$dataUser['CodigoSeccion']."'");
$dataTeacher=mysqli_fetch_array($selectTeacher);
if($dataTeacher['Nombre']==""&&$dataTeacher['Apellido']==""){
    $nameTeacher="Sin asignar";
}else{
    $nameTeacher=$dataTeacher['Nombre'].' '.$dataTeacher['Apellido'];
}
if($dataLoan['FechaSalida']!=""){
    $SelectDayFS=date("d",strtotime($dataLoan['FechaSalida']));
    $SelectMonthFS=date("m",strtotime($dataLoan['FechaSalida']));
    $SelectYearFS=date("Y",strtotime($dataLoan['FechaSalida']));
    $SelectMontNameFS=CalMonth::CurrentMonth($SelectMonthFS);
    $SelectDateFS=$SelectDayFS.' de '.$SelectMontNameFS.' de '.$SelectYearFS;
    $SelectDayFE=date("d",strtotime($dataLoan['FechaEntrega']));
    $SelectMonthFE=date("m",strtotime($dataLoan['FechaEntrega']));
    $SelectYearFE=date("Y",strtotime($dataLoan['FechaEntrega']));
    $SelectMontNameFE=CalMonth::CurrentMonth($SelectMonthFE);
    $SelectDateFE=$SelectDayFE.' de '.$SelectMontNameFE.' de '.$SelectYearFE;
}else{
    $SelectDateFS="";
    $SelectDateFE="";
}   
class PDF extends FPDF{
}
$pdf=new PDF('P','mm','Letter');
$pdf->AddPage();
$pdf->SetFont("Times","",20);
$pdf->SetMargins(25,20,25);
$pdf->Image('../assets/img/slv.png',25,16,20,20);
$pdf->Image('../assets/img/ins.png',170,16,18,20);
$pdf->Ln(10);
$pdf->Cell (0,5,utf8_decode($dataInstitution['Nombre']),0,1,'C');
$pdf->Ln(5);
$pdf->SetFont("Times","b",17);
$pdf->Cell (0,5,utf8_decode('Solicitud de libros para estudiantes'),0,1,'C');
$pdf->Ln(20);
$pdf->SetFont("Times","b",12);
$pdf->Cell (17,5,utf8_decode('Nombre: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (140,5,utf8_decode($dataUser['Nombre'].' '.$dataUser['Apellido']),0);
$pdf->Ln(9);
$pdf->SetFont("Times","b",12);
$pdf->Cell (50,5,utf8_decode('Padre, madre o encargado: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (110,5,utf8_decode($dataRepresentative['Nombre']),0);
$pdf->Ln(9);
$pdf->SetFont("Times","b",12);
$pdf->Cell (29,5,utf8_decode('Tel. encargado: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (37,5,utf8_decode($dataRepresentative['Telefono']),0);
$pdf->SetFont("Times","b",12);
$pdf->Cell (23,5,utf8_decode('Parentesco: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (67,5,utf8_decode($dataUser['Parentesco']),0);
$pdf->Ln(9);
$pdf->SetFont("Times","b",12);
$pdf->Cell (29,5,utf8_decode('Año y Sección: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (127,5,utf8_decode($dataSection['Nombre']),0);
$pdf->Ln(15);
$pdf->SetFont("Times","b",12);
$pdf->Cell (45,5,utf8_decode('Coordinador de sección: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (110,5,utf8_decode($nameTeacher),0);
$pdf->Ln(9);
$pdf->SetFont("Times","b",12);
$pdf->Cell (35,5,utf8_decode('Nombre del Libro: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (120,5,utf8_decode($dataBook['Titulo']),0);
$pdf->Ln(9);
$pdf->SetFont("Times","b",12);
$pdf->Cell (31,5,utf8_decode('Autor del Libro: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (70,5,utf8_decode($dataBook['Autor']),0);
$pdf->SetFont("Times","b",12);
$pdf->Cell (16,5,utf8_decode('Código: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (50,5,utf8_decode($dataLoan['CorrelativoLibro']),0);
$pdf->Ln(15);
$pdf->SetFont("Times","b",12);
$pdf->Cell (35,5,utf8_decode('Fecha de solicitud: '),0);
$pdf->SetFont("Times","",11);
$pdf->Cell (45,5,utf8_decode($SelectDateFS),0);
$pdf->SetFont("Times","b",12);
$pdf->Cell (33,5,utf8_decode('Fecha de entrega: '),0);
$pdf->SetFont("Times","",11);
$pdf->Cell (45,5,utf8_decode($SelectDateFE),0);
$pdf->Ln(12);
$pdf->SetFont("Times","b",12);
$pdf->Cell (25,5,utf8_decode('N° de carnet: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (50,5,utf8_decode($dataUser['NIE']),0);
$pdf->SetFont("Times","b",12);
$pdf->Cell (6,5,utf8_decode('F:'),0);
$pdf->Cell (60,5,utf8_decode('_________________________'),0);
$pdf->Ln(15);
$pdf->SetFont("Times","",12);
$pdf->Cell (0,5,utf8_decode('Nota:  Joven estudiante para solicitar libros de biblioteca deberá presentar su propio'),0);
$pdf->Ln(7);
$pdf->Cell (0,5,utf8_decode('Documento de identificación (antes de extenderle su carnet de biblioteca, carnet de '),0);
$pdf->Ln(7);
$pdf->Cell (0,5,utf8_decode('menoridad, DUI, al extenderle su carnet de biblioteca, deberá presentar el de biblioteca'),0);
$pdf->Ln(7);
$pdf->Cell (0,5,utf8_decode('o el de estudiante), si el libro sufre daños deberá responder por ellos, asi mismo entre-'),0);
$pdf->Ln(7);
$pdf->Cell (0,5,utf8_decode('garlo en la fecha indicada.'),0);
$pdf->Ln(25);
$pdf->Cell (83,5,utf8_decode('___________________________'),0,0,'C');
$pdf->Cell (83,5,utf8_decode('___________________________'),0,0,'C');
$pdf->Ln(7);
$pdf->Cell (83,5,utf8_decode('Lic. Ernesto Abarca'),0,0,'C');
$pdf->Cell (83,5,utf8_decode('Lic. Rosa Mirna Mejía López'),0,0,'C');
$pdf->Ln(7);
$pdf->Cell (83,5,utf8_decode('Director Inst. Nac. de Sensuntepeque'),0,0,'C');
$pdf->Cell (83,5,utf8_decode('Bibliotecaria'),0,0,'C');
$pdf->Output('N-'.$loanCode,'I');
mysqli_free_result($selectLoan);
mysqli_free_result($selectBook);
mysqli_free_result($selectInstitution);
mysqli_free_result($selectUserKey);
mysqli_free_result($selectUser);
mysqli_free_result($selectRepresentative);
mysqli_free_result($selectSection);
mysqli_free_result($selectTeacher);