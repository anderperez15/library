<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$codeStudent=consultasSQL::CleanStringText($_POST['code']);
$selectStudent=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE NIE='".$codeStudent."'");
$dataStudent=mysqli_fetch_array($selectStudent);
if(mysqli_num_rows($selectStudent)>=1){
    echo '
    <legend><strong>Información del Usuario General</strong></legend><br>
    <input type="hidden" value="'.$dataStudent['NIE'].'" name="studentNIEOld">
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataStudent['NIE'].'" name="studentNIE" required="" maxlength="20" data-toggle="tooltip" data-placement="top" title="ID de usuario">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>NIE</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataStudent['Nombre'].'" name="studentName" required="" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Nombres del usuario">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Nombres</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataStudent['Apellido'].'" name="studentSurname" required="" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Apellidos del usuario">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Apellidos</label>
    </div>
    <div class="group-material">
        <span>Sección</span>
        <select class="material-control tooltips-general" name="studentSection" data-toggle="tooltip" data-placement="top" title="Elige el área a la que pertenece el usuario">';
            $checkTeacherSection=ejecutarSQL::consultar("SELECT * FROM docente WHERE CodigoSeccion <> '".$dataStudent['CodigoSeccion']."' ORDER BY Nombre ASC");
            $checkSectionStudent=ejecutarSQL::consultar("SELECT * FROM seccion WHERE CodigoSeccion='".$dataStudent['CodigoSeccion']."'");
            $dataSts=mysqli_fetch_array($checkSectionStudent);
            echo '<option value="'.$dataSts['CodigoSeccion'].'">'.$dataSts['Nombre'].'</option>';
            while($fila=mysqli_fetch_array($checkTeacherSection)){
                $checkStudentSection=ejecutarSQL::consultar("SELECT * FROM seccion WHERE CodigoSeccion='".$fila['CodigoSeccion']."' ORDER BY Nombre ASC");
                $row=mysqli_fetch_array($checkStudentSection);
                echo '<option value="'.$row['CodigoSeccion'].'">'.$row['Nombre'].'</option>';
                mysqli_free_result($checkStudentSection);
            }
            mysqli_free_result($checkTeacherSection);
            mysqli_free_result($checkSectionStudent);
        echo '</select>
    </div>
    <legend>Datos del Director de Área</legend>
    <br><br>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataStudent['Parentesco'].'" name="representativeRelationship" required="" pattern="[a-zA-ZéíóúáñÑ ]{1,30}" maxlength="30" data-toggle="tooltip" data-placement="top" title="Nombres">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Director</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general check-representative" value="'.$dataStudent['DUI'].'" name="representativeDUI" pattern="[0-9-]{1,10}" required="" maxlength="10" data-toggle="tooltip" data-placement="top" title="Solamente números">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>ID Director</label>
    </div>
    <div class="full-reset representative-resul"></div>
    <script>
        $(document).ready(function(){
            $(".check-representative").keyup(function(){
              $.ajax({
                url:"../process/check-representative.php?DUI="+$(this).val(),
                success:function(data){
                  $(".representative-resul").html(data);
                }
              });
            });
        });
    </script>';
}else{
    echo '<div class="alert alert-danger text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Error!:</strong> Lo sentimos ha ocurrido un error.</div>';
}
mysqli_free_result($selectStudent);