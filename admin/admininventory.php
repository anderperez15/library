<!--
 * Sistema Bibliotecario
 * Copyright 2016 Carlos Eduardo Alfaro Orellana.
 -->
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registrar Libro</title>
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
              <h1 class="all-tittles">Sistema Archivo <small>Añadir Carpeta</small></h1>
            </div>
        </div>
        <div class="container-fluid"  style="margin: 50px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="../assets/img/flat-book.png" alt="pdf" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Bienvenido a la sección para agregar nuevas carpetas al archivo, deberas llenar todos los campos para poder registrar la carpeta
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <form action="../process/AddBook.php" method="post" class="form_SRCB" data-type-form="save" autocomplete="off">
                <div class="container-flat-form">
                    <div class="title-flat-form title-flat-blue">Nueva Carpeta</div>
                    <div class="row">
                       <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                            <legend><strong>Información básica</strong></legend><br>
                            <div class="group-material">
                                <span>Categoría</span>
                                <select class="tooltips-general material-control" name="bookCategory" data-toggle="tooltip" data-placement="top" title="Elige la categoría de la carpeta">
                                    <option value="" disabled="" selected="">Selecciona una categoría</option>
                                    <?php
                                        $checkCategory= ejecutarSQL::consultar("SELECT * FROM categoria");
                                        while($fila=mysqli_fetch_array($checkCategory)){
                                            echo '<option value="'.$fila['CodigoCategoria'].'">'.$fila['Nombre'].'</option>'; 
                                        }
                                        mysqli_free_result($checkCategory);
                                    ?>
                                </select>
                            </div>
                            <div class="group-material">
                                <input type="text" class="tooltips-general material-control" placeholder="Escribe aquí el ID de la carpeta" name="bookCorrelative" pattern="[0-9]{1,20}" required="" maxlength="5" data-toggle="tooltip" data-placement="top" title="Escribe el ID de la carpeta, solamente números">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Id Carpeta</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="tooltips-general material-control" placeholder="Escribe aquí el título o nombre de la carpeta" name="bookName" required="" maxlength="70" data-toggle="tooltip" data-placement="top" title="Escribe el título o nombre de la carpeta">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombre de Carpeta</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="tooltips-general material-control" placeholder="Escribe aquí dirección inmueble asociado" name="bookAutor" required="" maxlength="100" data-toggle="tooltip" data-placement="top" title="Escribe dirección asociada a carpeta">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Dirección</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="tooltips-general material-control" placeholder="Escribe aquí Referencia Numérica" required="" name="bookCountry" maxlength="70" data-toggle="tooltip" data-placement="top" title="Escribe referencia numérica de la carpeta">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Referencia</label>
                            </div>
                            <legend><strong>Otros datos</strong></legend><br>
                            <div class="group-material">
                                <span>Proveedor</span>
                                <select class="tooltips-general material-control" name="bookProvider" data-toggle="tooltip" data-placement="top" title="Elige el proveedor de la carpeta">
                                    <option value="" disabled="" selected="">Selecciona un proveedor</option>
                                    <?php
                                        $checkProvider= ejecutarSQL::consultar("select * from proveedor");
                                        while($fila=mysqli_fetch_array($checkProvider)){
                                            echo '<option value="'.$fila['CodigoProveedor'].'">'.$fila['Nombre'].'</option>'; 
                                        }
                                        mysqli_free_result($checkProvider);
                                    ?>
                                </select>
                            </div>
                           <div class="group-material">
                               <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el año de ingreso de la carpeta" name="bookYear" required="" pattern="[0-9]{1,4}" maxlength="4" data-toggle="tooltip" data-placement="top" title="Solamente números, sin espacios">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Año</label>
                           </div>
						   <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el mes de ingreso de la Carpeta" name="bookEstimated" required="" pattern="[0-9]{1,4}" maxlength="4" data-toggle="tooltip" data-placement="top" title="Sólo números">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Ingreso</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el creador de la carpeta" name="bookEditorial" required="" maxlength="70" data-toggle="tooltip" data-placement="top" title="Persona de Archivo">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Creador</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el tomo correspondiente" name="bookEdition" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Tomo de la Carpeta">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Tomos</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general"  placeholder="Escribe aquí la cantidad de carpetas que registraras" name="bookCopies" required=" "pattern="[0-9]{1,7}" maxlength="7" data-toggle="tooltip" data-placement="top" title="¿Cuántas carpetas registraras?">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Número de Carpetas</label>
                            </div>
                            <legend><strong>Ubicación, Disponibilidad, Estado</strong></legend><br>
                            <div class="group-material">
                               <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí la ubicación de la carpeta" name="bookLocation" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="¿Dónde se ubicará la carpeta?">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Ubicación</label>
                            </div>
                            <div class="group-material">
                                <span>Disponibilidad</span>
                                <select class="tooltips-general material-control" name="bookOffice" data-toggle="tooltip" data-placement="top" title="Elige disponibilidad">
                                    <option value="" disabled="" selected="">Selecciona disponibilidad de la carpeta</option>
                                    <option value="1-1">Solo Contabilidad</option>
                                    <option value="1-2">Todos</option>
                                    <option value="1-3">Solo Gerencia y Gerencia Financiera</option>
                                    <option value="1-4">Confidencial</option>
                                    <option value="1-5">Otros</option>
                                </select>
                            </div>
                            <div class="group-material">
                                <span>Estado</span>
                                <select class="tooltips-general material-control" name="bookState" data-toggle="tooltip" data-placement="top" title="Elige el estado de la carpeta">
                                    <option value="" disabled="" selected="">Selecciona el estado de la carpeta</option>
                                    <option value="Buena">Buena</option>
                                    <option value="Deteriorada">Deteriorada</option>
                                </select>
                            </div>
                            <p class="text-center">
                                <button type="reset" class="btn btn-info" style="margin-right: 20px;"><i class="zmdi zmdi-roller"></i> &nbsp;&nbsp; Limpiar</button>
                                <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-floppy"></i> &nbsp;&nbsp; Guardar</button>
                            </p>
                       </div>
                   </div>
                </div>
            </form>
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
                    <?php include '../help/help-admininventory.php'; ?>
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