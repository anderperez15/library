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
                    Bienvenido a la sección donde se encuentra el listado de las áreas creadas. Puedes eliminar un registro siempre y cuando no tenga usuarios registrados.
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 lead">
                    <ol class="breadcrumb">
                      <li><a href="adminsection.php">Nueva Área</a></li>
                      <li class="active">Listado de Áreas</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <h2 class="text-center all-tittles">lista de áreas</h2>
            <div class="div-table">
                <div class="div-table-row div-table-head">
                    <div class="div-table-cell">#</div>
                    <div class="div-table-cell">Nombre</div>
                    <div class="div-table-cell">Eliminar</div>
                </div>
            <?php 
                $checkSection= ejecutarSQL::consultar("SELECT * FROM seccion ORDER BY Nombre");
                $checktotal=mysqli_num_rows($checkSection);
                if($checktotal>0){
                    $p=1;
                    while($fila=mysqli_fetch_array($checkSection)){
                        $checkSectionTeacher= ejecutarSQL::consultar("SELECT * FROM docente WHERE CodigoSeccion='".$fila['CodigoSeccion']."'");
                        $checkSectionStudent= ejecutarSQL::consultar("SELECT * FROM estudiante WHERE CodigoSeccion='".$fila['CodigoSeccion']."'");
                        echo '<div class="div-table-row">
                            <div class="div-table-cell">'.$p.'</div>
                            <div class="div-table-cell">'.$fila['Nombre'].'</div>';
                            if(mysqli_num_rows($checkSectionTeacher)>0 || mysqli_num_rows($checkSectionStudent)>0){ 
                                echo '<div class="div-table-cell"><button class="btn btn-danger btn-xs" disabled="disabled"><i class="zmdi zmdi-delete"></i> &nbsp;&nbsp; Eliminar</button></div>';
                            }else{
                                echo '<form class="div-table-cell form_SRCB" action="../process/DeleteSection.php" method="post" data-type-form="delete" ><input value="'.$fila["CodigoSeccion"].'" type="hidden" name="primaryKey"><button type="submit" class="btn btn-danger btn-xs"><i class="zmdi zmdi-delete"></i> &nbsp;&nbsp; Eliminar</button></form>';  
                            }
                        echo '</div>';
                        $p++;
                        mysqli_free_result($checkSectionTeacher);
                        mysqli_free_result($checkSectionStudent);
                    }
                }else{
                    echo '<br><br><br><h3 class="text-center all-tittles">No hay áreas registradas en el sistema</h3><br><br>';
                }
                mysqli_free_result($checkSection);
            ?>
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
                    <?php include '../help/help-adminlistsection.php'; ?>
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