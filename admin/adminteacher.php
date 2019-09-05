<!--
 * Sistema Bibliotecario
 * Copyright 2016 Carlos Eduardo Alfaro Orellana.
 -->
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Docentes</title>
    <?php
        session_start();
        $LinksRoute="../";
        include '../inc/links.php'; 
    ?>
    <script src="../js/SendForm.js"></script>
</head>
<body>
    <?php 
        include '../library/configServer.php';
        include '../library/consulSQL.php';
        include '../process/SecurityAdmin.php';
        include '../inc/NavLateral.php';
    ?>
    <div class="content-page-container full-reset custom-scroll-containers">
        <?php 
            include '../inc/NavUserInfo.php';
        ?>
        <div class="container">
            <div class="page-header">
              <h1 class="all-tittles">Sistema Archivo <small>Administración Usuarios</small></h1>
            </div>
        </div>
        <div class="conteiner-fluid">
            <ul class="nav nav-tabs nav-justified"  style="font-size: 17px;">
                <li role="presentation"><a href="adminuser.php">Administradores</a></li>
                <li role="presentation"  class="active"><a href="adminteacher.php">Usuarios Especiales</a></li>
                <li role="presentation"><a href="adminstudent.php">Usuarios Generales</a></li>
                <li role="presentation"><a href="adminpersonal.php">Personal administrativo</a></li>
            </ul>
        </div>
        <div class="container-fluid"  style="margin: 50px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="../assets/img/user02.png" alt="user" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Bienvenido a la sección para registrar nuevos usuarios especiales. Para registrarlo debes de llenar todos los campos del siguiente formulario, también puedes ver el listado de usuarios registrados
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 lead">
                    <ol class="breadcrumb">
                      <li class="active">Nuevo Usuario Especial</li>
                      <li><a href="adminlistteacher.php">Listado de Usuarios Especiales</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container-flat-form">
                <div class="title-flat-form title-flat-blue">Registrar un nuevo usuario especial</div>
                <form action="../process/AddTeacher.php" method="post" class="form_SRCB" data-type-form="save" autocomplete="off">
                    <div class="row">
                       <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                           <?php
                                $checkSection=ejecutarSQL::consultar("select * from seccion order by Nombre");
                                if(mysqli_num_rows($checkSection)<=0){
                                    echo '<br><div class="alert alert-danger text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Importante!:</strong> No puedes registrar usuarios especiales, primero debes de agregar secciones al sistema</div><br>';
                                } 
                            ?>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el ID del usuario especial" name="teachingDUI" pattern="[0-9-]{1,10}" required="" maxlength="10" data-toggle="tooltip" data-placement="top" title="Solamente números">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>ID Usuario</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí los nombres del usuario" name="teachingName" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe los nombres del usuario, solamente letras">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombres</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí los apellidos del usuario" name="teachingSurname" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe los apellidos del usuario, solamente letras">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Apellidos</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el número de extensión del usuario" name="teachingPhone" pattern="[0-9]{1,8}" required="" maxlength="8" data-toggle="tooltip" data-placement="top" title="Solamente números">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Extensión</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el cargo del usuario" name="teachingSpecialty" required="" maxlength="40" data-toggle="tooltip" data-placement="top" title="Cargo del Usuario">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Cargo</label>
                            </div>
                           <legend>Sede y Área encargada</legend>
                            <div class="group-material">
                                <span>Área encargada</span>
                                <select class="material-control tooltips-general" name="teachingSection" data-toggle="tooltip" data-placement="top" title="Elige el área a la que pertenece el usuario">
                                    <option value="" disabled="" selected="">Selecciona un área</option>
                                    <?php
                                        while($fila=mysqli_fetch_array($checkSection)){
                                            $checkSectionTeacher=ejecutarSQL::consultar("select * from docente where CodigoSeccion='".$fila['CodigoSeccion']."'");
                                            if(mysqli_num_rows($checkSectionTeacher)<=0){
                                               echo '<option value="'.$fila['CodigoSeccion'].'">'.$fila['Nombre'].'</option>'; 
                                            } 
                                            mysqli_free_result($checkSectionTeacher);
                                        }
                                        mysqli_free_result($checkSection);
                                    ?>
                                </select>
                            </div>
                            <div class="group-material">
                                <span>Sede</span>
                                <select class="material-control tooltips-general" name="teachingTime" data-toggle="tooltip" data-placement="top" title="Elige la sede del usuario">
                                    <option value="Calle76">Calle 76</option>
                                    <option value="Calle93">Calle 93</option>
                                </select>
                            </div>
                            <p class="text-center">
                                <button type="reset" class="btn btn-info" style="margin-right: 20px;"><i class="zmdi zmdi-roller"></i> &nbsp;&nbsp; Limpiar</button>
                                <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-floppy"></i> &nbsp;&nbsp; Guardar</button>
                            </p> 
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="msjFormSend"></div>
        <div class="modal fade" tabindex="-1" role="dialog" id="ModalHelp">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center all-tittles">ayuda del sistema</h4>
                </div>
                <div class="modal-body">
                    <?php include '../help/help-adminteacher.php'; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="zmdi zmdi-thumb-up"></i> &nbsp; De acuerdo</button>
                </div>
            </div>
          </div>
        </div>
        <?php include '../inc/footer.php'; ?>
    </div>
</body>
</html>