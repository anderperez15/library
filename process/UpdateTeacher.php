<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$teachingDUI=consultasSQL::CleanStringText($_POST['teachingDUI']);
$teachingName=consultasSQL::CleanStringText($_POST['teachingName']);
$teachingSurname=consultasSQL::CleanStringText($_POST['teachingSurname']);
$teachingPhone=consultasSQL::CleanStringText($_POST['teachingPhone']);
$teachingSpecialty=consultasSQL::CleanStringText($_POST['teachingSpecialty']);
$teachingSection=consultasSQL::CleanStringText($_POST['teachingSection']);
$teachingTime=consultasSQL::CleanStringText($_POST['teachingTime']);
if(consultasSQL::UpdateSQL("docente", "CodigoSeccion='$teachingSection',Nombre='$teachingName',Apellido='$teachingSurname',Telefono='$teachingPhone',Especialidad='$teachingSpecialty',Jornada='$teachingTime'", "DUI='".$teachingDUI."'")){
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Usuario Especial Actualizado!", 
            text:"Los datos del usuario se actualizaron correctamente, recuerda que si cambiaste el área encargada los usuarios del área anterior no tendrán encargado y deberás asignarles uno.", 
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
            text:"No hemos podido actualizar los datos del usuario, por favor intenta nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}