<!--
 * Sistema Bibliotecario
 * Copyright 2016 Carlos Eduardo Alfaro Orellana.
 -->
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Secciones</title>
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
              <h1 class="all-tittles">Sistema Archivo <small>Administración Archivo</small></h1>
            </div>
        </div>
        <div class="container-fluid">
            <ul class="nav nav-tabs nav-justified"  style="font-size: 17px;">
              <li role="presentation"><a href="admininstitution.php">Archivo</a></li>
              <li role="presentation"><a href="adminprovider.php">Proveedores</a></li>
              <li role="presentation"><a href="admincategory.php">Categorías</a></li>
              <li role="presentation"  class="active"><a href="adminsection.php">Áreas</a></li>
            </ul>
        </div>
        <div class="container-fluid"  style="margin: 50px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="../assets/img/section.png" alt="user" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Bienvenido a la sección para registrar nuevas áreas al sistema, debes de escoger los datos en el siguiente formulario para hacer un registro
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 lead">
                    <ol class="breadcrumb">
                      <li class="active">Nueva Área</li>
                      <li><a href="adminlistsection.php">Listado de Áreas</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container-flat-form">
                <div class="title-flat-form title-flat-blue">Agregar una nueva área</div>
                <form action="../process/AddSection.php" method="post" class="form_SRCB" data-type-form="save">
                    <div class="row">
                       <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                            <div class="group-material">
                                <span>Sede Principal</span>
                                <select class="material-control tooltips-general" name="sectionGrade" data-toggle="tooltip" data-placement="top" title="Elige la sede">
                                    <option value="" disabled="" selected="">Selecciona una opción</option>
                                    <option value="Calle76 | ">Calle 76</option>
                                    <option value="Calle93 | ">Calle 93</option>
                                    <option value="Otra | ">Otra</option>
                                </select>
                            </div>
                            <div class="group-material">
                                <span>Área</span>
                                <select class="material-control tooltips-general" name="sectionSpecialty" data-toggle="tooltip" data-placement="top" title="Elige el área">
                                    <option value="" disabled="" selected="">Selecciona una opción</option>
                                    <option value="Administrativo | ">Administrativo</option>
                                    <option value="Banca Inmobiliaria | ">Banca Inmobiliaria</option>
                                    <option value="Comercial | ">Comercial</option>
                                    <option value="Desarrollo | ">Desarrollo</option>
                                    <option value="Gerencia | ">Gerencia</option>
                                    <option value="MMI | ">MMI</option>
									<option value="Operaciones | ">Operaciones</option>
									<option value="Proyectos Especiales | ">Proyectos Especiales</option>
                                </select>
                            </div>
                            <div class="group-material">
                                <span>Tipo</span>
                                <select class="material-control tooltips-general" name="sectionSection" data-toggle="tooltip" data-placement="top" title="Elige el tipo">
                                    <option value="" disabled="" selected="">Selecciona una opción</option>
                                    <option value="Administrativo">Administrativo</option>
                                    <option value="Banca">Banca</option>
                                    <option value="Bogoapts">Bogoapts</option>
									<option value="Gerencia">Gerencia</option>
									<option value="Juridico">Juridico</option>
									<option value="NAI Gaviria">NAI Gaviria</option>
									<option value="Operaciones">Operaciones</option>
									<option value="Proyectos Especiales">Proyectos Especiales</option>
									<option value="Reparaciones">Reparaciones</option>
									<option value="Residencial">Residencial</option>
									<option value="Servicio al Cliente">Servicio al Cliente</option>
									<option value="Ventas">Ventas</option>
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
                    <?php include '../help/help-adminsection.php'; ?>
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