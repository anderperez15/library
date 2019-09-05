<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$institutionCode=consultasSQL::CleanStringText($_POST['institutionCode']);
$institutionName=consultasSQL::CleanStringText($_POST['institutionName']);
$institutionDistrict=consultasSQL::CleanStringText($_POST['institutionDistrict']);
$institutionPhone=consultasSQL::CleanStringText($_POST['institutionPhone']);
$institutionYear=consultasSQL::CleanStringText($_POST['institutionYear']);
$checkInstitution=ejecutarSQL::consultar("SELECT * FROM institucion");
if(mysqli_num_rows($checkInstitution)<=0){
    if(consultasSQL::InsertSQL("institucion", "CodigoInfraestructura, Nombre, Distrito, Telefono, Year", "'$institutionCode','$institutionName','$institutionDistrict','$institutionPhone','$institutionYear'")){
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Archivo registrado!", 
                text:"Los datos del archivo se almacenaron correctamente", 
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
    }
    else{
        echo '<script type="text/javascript">
            swal({
              title:"¡Ocurrió un error inesperado!",
               text:"No se pudo registrar los datos del archivo, por favor intente nuevamente",
               type: "error",
               confirmButtonText: "Aceptar"
                   });
        </script>';
    }
}
else{
    echo '<script type="text/javascript">
        swal({
          title:"¡Ocurrió un error inesperado!",
           text:"Solo puedes registrar una vez los datos del archivo. Puedes actualizarlo o eliminar el registro, e intentar nuevamente",
           type: "error",
           confirmButtonText: "Aceptar"
               });
    </script>';
}
mysqli_free_result($checkInstitution);