<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$codePersonal=consultasSQL::CleanStringText($_POST['code']);
$selectPersonal=ejecutarSQL::consultar("SELECT * FROM personal WHERE DUI='".$codePersonal."'");
$dataPersonal=mysqli_fetch_array($selectPersonal);
if(mysqli_num_rows($selectPersonal)>=1){
    echo '
    <legend><strong>Información del personal administrativo</strong></legend><br>
    <input type="hidden" value="'.$dataPersonal["DUI"].'" name="personalDUI" >
    <div class="group-material">
        <input type="text" class="material-control tooltips-general"  value="'.$dataPersonal["Nombre"].'" name="personalName" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe los nombres del usuario externo, solamente letras">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Nombres</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataPersonal["Apellido"].'" name="personalSurname" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe los apellidos del usuario externo, solamente letras">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Apellidos</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataPersonal["Telefono"].'" name="personalPhone" pattern="[0-9]{1,8}" required="" maxlength="8" data-toggle="tooltip" data-placement="top" title="Solamente números">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Teléfono</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataPersonal["Cargo"].'" name="personalPosition" required="" maxlength="30" data-toggle="tooltip" data-placement="top" title="Cargo del usuario externo">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Cargo</label>
    </div>
    ';
}else{
    echo '<div class="alert alert-danger text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Error!:</strong> Lo sentimos ha ocurrido un error.</div>';
}
mysqli_free_result($selectPersonal);