<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$codeTeacher=consultasSQL::CleanStringText($_POST['code']);
$selectTeacher=ejecutarSQL::consultar("SELECT * FROM docente WHERE DUI='".$codeTeacher."'");
$dataTeacher=mysqli_fetch_array($selectTeacher);
if(mysqli_num_rows($selectTeacher)>=1){
    echo '
    <legend><strong>Información del Usuario Especial</strong></legend><br>
    <input type="hidden" value="'.$dataTeacher["DUI"].'" name="teachingDUI" >
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataTeacher["Nombre"].'" name="teachingName" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe los nombres del usuario, solamente letras">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Nombres</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataTeacher["Apellido"].'" name="teachingSurname" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe los apellidos del usuario, solamente letras">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Apellidos</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataTeacher["Telefono"].'" name="teachingPhone" pattern="[0-9]{1,8}" required="" maxlength="8" data-toggle="tooltip" data-placement="top" title="Solamente números">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Teléfono</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataTeacher["Especialidad"].'" name="teachingSpecialty" required="" maxlength="40" data-toggle="tooltip" data-placement="top" title="Cargo del usuario">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Cargo</label>
    </div>
    <legend>Sede y Área encargada</legend>
    <div class="group-material">
        <select class="material-control tooltips-general" name="teachingSection" data-toggle="tooltip" data-placement="top" title="Elige el área del usuario">';
            $checkSectiont=ejecutarSQL::consultar("SELECT * FROM seccion WHERE CodigoSeccion='".$dataTeacher["CodigoSeccion"]."'");
            $dataSection=mysqli_fetch_array($checkSectiont);
            echo '<option value="'.$dataSection['CodigoSeccion'].'">'.$dataSection['Nombre'].'</option>';
            $checkSection=ejecutarSQL::consultar("SELECT * FROM seccion WHERE CodigoSeccion <> '".$dataTeacher["CodigoSeccion"]."' ORDER BY Nombre ASC");
            while($fila=mysqli_fetch_array($checkSection)){
                $checkSectionTeacher=ejecutarSQL::consultar("SELECT * FROM docente WHERE CodigoSeccion='".$fila['CodigoSeccion']."'");
                if(mysqli_num_rows($checkSectionTeacher)<=0){
                   echo '<option value="'.$fila['CodigoSeccion'].'">'.$fila['Nombre'].'</option>'; 
                } 
                mysqli_free_result($checkSectionTeacher);
            }
            mysqli_free_result($checkSection);
            mysqli_free_result($checkSectiont);
        echo '</select>
    </div>
    <div class="group-material">
        <select class="material-control tooltips-general" name="teachingTime" data-toggle="tooltip" data-placement="top" title="Elige la sede del usuario">';
            switch ($dataTeacher["Jornada"]){
                case 'Calle 76':
                    echo'<option value="Calle76">Calle 76</option><option value="Calle76">Calle 76</option>';
                break;
                case 'Calle 93':
                    echo'<option value="Calle93">Tarde</option><option value="Calle93">Calle 93</option>';
                break;
                default :
                    echo'<option value="Calle76">Calle 76</option><option value="Calle93">Calle 93</option>';
                break;
            }
        echo '</select>
    </div>';
}else{
    echo '<div class="alert alert-danger text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Error!:</strong> Lo sentimos ha ocurrido un error.</div>';
}
mysqli_free_result($selectTeacher);

