<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$personalDUI=consultasSQL::CleanStringText($_POST['personalDUI']);
$personalName=consultasSQL::CleanStringText($_POST['personalName']);
$personalSurname=consultasSQL::CleanStringText($_POST['personalSurname']);
$personalPhone=consultasSQL::CleanStringText($_POST['personalPhone']);
$personalPosition=consultasSQL::CleanStringText($_POST['personalPosition']);
$checkDUI=ejecutarSQL::consultar("SELECT * FROM personal WHERE DUI='".$personalDUI."'");
if(mysqli_num_rows($checkDUI)<=0){
    if(consultasSQL::InsertSQL("personal", "DUI, Nombre, Apellido, Telefono, Cargo", "'$personalDUI','$personalName','$personalSurname','$personalPhone','$personalPosition'")){ 
        echo '<script type="text/javascript">
            swal({
               title:"¡Usuario Externo Registrado!",
               text:"Los datos del usuario externo se almacenaron exitosamente",
               type: "success",
               confirmButtonText: "Aceptar"
            });
            $(".form_SRCB")[0].reset();
        </script>';
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"No se pudo registrar usuario, por favor intenta nuevamente", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>'; 
    }
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"Este número de ID está asociado con otro usuario registrado en el sistema, verifícalo e intenta nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>'; 
}
mysqli_free_result($checkDUI);