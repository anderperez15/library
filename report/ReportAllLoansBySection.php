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
$pdf->SetFont("Helvetica","",12);
$pdf->Cell (0,5,utf8_decode('Control General de Préstamos por Áreas | Archivo Central'),0,1,'C');
$pdf->Ln(5);
$pdf->Ln(20);
$pdf->SetFont("Helvetica","b",10);
$pdf->SetFillColor(255,204,188);
$pdf->Cell (90,6,utf8_decode('ÁREA'),1,0,'C',true);
$pdf->Cell (40,6,utf8_decode('N° DE PRÉSTAMOS'),1,0,'C',true);
$pdf->Cell (40,6,utf8_decode('PORCENTAJE'),1,0,'C',true);
$pdf->Ln(6);
$pdf->SetFont("Helvetica","",10);
function Cporcent($NT,$CT,$DC){
    $Res=number_format($NT/$CT ,$DC)*100;
    return $Res;
}
$selectallLoans=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE Estado='Entregado'");
$totalLoansStudents=0;
while($filaD=mysqli_fetch_array($selectallLoans)){
    $SelectYear=date("Y",strtotime($filaD['FechaSalida']));
    if($dataInstitution['Year']==$SelectYear){
        $checkingUser1=ejecutarSQL::consultar("SELECT * FROM prestamoestudiante WHERE CodigoPrestamo='".$filaD['CodigoPrestamo']."'");
        if(mysqli_num_rows($checkingUser1)>=1){
            $totalLoansStudents++;
        }
        mysqli_free_result($checkingUser1);
    }
}
$selectAllSections=ejecutarSQL::consultar("SELECT * FROM seccion ORDER BY Nombre ASC");
$CounterSectPorcent=0;
while($DataSect=mysqli_fetch_array($selectAllSections)){
    $selectST=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE CodigoSeccion='".$DataSect['CodigoSeccion']."'");
    $CounterSect=0;
    while($DataST=mysqli_fetch_array($selectST)){
        $selectLS=ejecutarSQL::consultar("SELECT * FROM prestamoestudiante WHERE NIE='".$DataST['NIE']."'");
        while($DataLS=mysqli_fetch_array($selectLS)){
            $selectAL=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoPrestamo='".$DataLS['CodigoPrestamo']."' AND Estado='Entregado'");
            while($DataAL=mysqli_fetch_array($selectAL)){
                $SY=date("Y",strtotime($DataAL['FechaSalida']));
                if($dataInstitution['Year']==$SY){ $CounterSect++; }
            }
            mysqli_free_result($selectAL);
        }
        mysqli_free_result($selectLS);
    }
    mysqli_free_result($selectST);
    $TotalPorcent=Cporcent($CounterSect, $totalLoansStudents, 3);
    $pdf->Cell (90,6,utf8_decode($DataSect['Nombre']),1,0,'C');
    $pdf->Cell (40,6,utf8_decode($CounterSect),1,0,'C');
    $pdf->Cell (40,6,utf8_decode($TotalPorcent.'%'),1,0,'C');
    $pdf->Ln(6);
    $CounterSectPorcent=$CounterSectPorcent+$TotalPorcent;
}
mysqli_free_result($selectAllSections);
$pdf->SetFillColor(179,229,252);
$pdf->SetFont("Helvetica","b",10);
$pdf->Cell (90,6,utf8_decode('TOTAL'),1,0,'C',true);
$pdf->Cell (40,6,utf8_decode($totalLoansStudents),1,0,'C',true);
$pdf->Cell (40,6,utf8_decode($CounterSectPorcent.'%'),1,0,'C',true);
$pdf->Output('Prestamos_entregados_Secciones_'.$dataInstitution['Year'],'I');
mysqli_free_result($selectInstitution);