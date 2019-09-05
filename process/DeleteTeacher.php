<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$primaryKey=consultasSQL::CleanStringText($_POST['primaryKey']);
$selectTea=ejecutarSQL::consultar("SELECT * FROM docente WHERE DUI='".$primaryKey."'");
$dataTeacher=mysqli_fetch_array($selectTea);
$selectStudents=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE CodigoSeccion='".$dataTeacher['CodigoSeccion']."'");
if(mysqli_num_rows($selectStudents)<=0){
    $selectAllLoansT=ejecutarSQL::consultar("SELECT * FROM prestamodocente WHERE DUI='".$primaryKey."'");
    $totalP=0;
    while($rowA=mysqli_fetch_array($selectAllLoansT)){
        $seletLP=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoPrestamo='".$rowA['CodigoPrestamo']."' AND Estado='Prestamo'");
        if(mysqli_num_rows($seletLP)>0){ $totalP=$totalP+1; }
        mysqli_free_result($seletLP);
    }
    if($totalP<=0){
        $totalErrors=0;
        $selectAllLoansTe=ejecutarSQL::consultar("SELECT * FROM prestamodocente WHERE DUI='".$primaryKey."'");
        while($dataAllLoans=mysqli_fetch_array($selectAllLoansTe)){
            if(consultasSQL::DeleteSQL("prestamodocente", "CodigoPrestamo='".$dataAllLoans['CodigoPrestamo']."'")){
                if(consultasSQL::DeleteSQL("prestamo", "CodigoPrestamo='".$dataAllLoans['CodigoPrestamo']."'")){
                    
                }else{
                    $totalErrors=$totalErrors+1;
                }
            }else{
                $totalErrors=$totalErrors+1; 
            }   
        }
        if($totalErrors<=0){
            if(consultasSQL::DeleteSQL("bitacora", "CodigoUsuario='".$primaryKey."' AND Tipo='Docente'")){
                if(consultasSQL::DeleteSQL("docente", "DUI='".$primaryKey."'")){
                    echo '<script type="text/javascript">
                        swal({ 
                            title:"¡Usuario Especial eliminado!", 
                            text:"Todos los datos del usuario y préstamos asociados han sido eliminados del sistema exitosamente", 
                            type: "success", 
                            confirmButtonText: "Aceptar" 
                        },
                        function(isConfirm){  
                            if (isConfirm) {     
                               location.reload();
                            } else {    
                               location.reload();
                            } 
                        });
                    </script>';
                }else{
                    echo '<script type="text/javascript">
                        swal({ 
                            title:"¡Ocurrió un error inesperado!", 
                            text:"No hemos podido eliminar los datos del usuario, por favor intenta nuevamente", 
                            type: "error", 
                            confirmButtonText: "Aceptar" 
                        });
                    </script>';  
                }
            }else{
                echo '<script type="text/javascript">
                    swal({ 
                        title:"¡Ocurrió un error inesperado!", 
                        text:"No hemos podido eliminar los datos del usuario, por favor intenta nuevamente", 
                        type: "error", 
                        confirmButtonText: "Aceptar" 
                    });
                </script>';
            }
        }else{
           echo '<script type="text/javascript">
                swal({ 
                    title:"¡Ocurrió un error inesperado!", 
                    text:"No hemos podido eliminar los datos del usuario, por favor intenta nuevamente", 
                    type: "error", 
                    confirmButtonText: "Aceptar" 
                });
            </script>'; 
        }
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"El usuario tiene préstamos pendientes, no se pueden borrar los datos mientras no devuelva las carpetas", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>';
    }
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"No se pueden eliminar los datos del usuario porque en el área encargada existen usuarios generales registrados, no debe de haber ningún usuario en dicha área para poder eliminar los datos", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
mysqli_free_result($selectAllLoansT);
mysqli_free_result($selectAllLoansTe);
mysqli_free_result($selectTea);
mysqli_free_result($selectStudents);