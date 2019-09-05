<p class="lead">
    Puedes actualizar los datos de las carpetas o eliminarlos si no se encuentran préstamos pendientes, reservaciones asociados a el o se han dado de baja.
</p>
<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th colspan="2" class="text-center lead success"><strong>Datos de la carpeta</strong></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Categoría</strong></td>
                <td>
                    <?php
                        $nameCateg=ejecutarSQL::consultar("SELECT * FROM categoria WHERE CodigoCategoria='".$fila['CodigoCategoria']."'");
                        $nC=mysqli_fetch_array($nameCateg);
                        echo $nC['Nombre'];
                        mysqli_free_result($nameCateg);
                    ?>
                </td>
            </tr>
            <tr><td><strong>Id Carpeta</strong></td><td><?php echo $fila['CodigoCorrelativo']; ?></td></tr>
            <tr><td><strong>Nombre Carpeta</strong></td><td><?php echo $fila['Titulo']; ?></td></tr>
            <tr><td><strong>Dirección</strong></td><td><?php echo $fila['Autor']; ?></td></tr>
            <tr><td><strong>Código Referencia</strong></td><td><?php echo $fila['Pais']; ?></td></tr>
            <tr>
                <td><strong>Proveedor</strong></td>
                <td>
                    <?php
                        $nameProv=ejecutarSQL::consultar("SELECT * FROM proveedor WHERE CodigoProveedor='".$fila['CodigoProveedor']."'");
                        $nP=mysqli_fetch_array($nameProv);
                        echo $nP['Nombre']; 
                        mysqli_free_result($nameProv);
                    ?>
                </td>
            </tr>
            <tr><td><strong>Año</strong></td><td><?php echo $fila['Year']; ?></td></tr>
			<tr><td><strong>Mes de Ingreso</strong></td><td><?php echo $fila['Estimado']; ?></td></tr>
            <tr><td><strong>Creador</strong></td><td><?php echo $fila['Editorial']; ?></td></tr>
            <tr><td><strong>Número de Tomos</strong></td><td><?php echo $fila['Edicion']; ?></td></tr>
            <tr><td><strong>Número de Carpetas</strong></td><td><?php echo $fila['Existencias']; ?></td></tr>
            <tr><td><strong>En prestamo</strong></td><td><?php echo $fila['Prestado']; ?></td></tr>
            <tr><td><strong>Ubicación</strong></td><td><?php echo $fila['Ubicacion']; ?></td></tr>
            <tr>
                <td><strong>Disponibilidad</strong></td>
                <td>
                    <?php
                    switch ($fila['Cargo']){
                        case "1-1":
                            echo 'Solo Contabilidad';
                            break;
                        case "1-2":
                            echo 'Todos';
                            break;
                        case "1-3":
                            echo 'Solo Gerencia y Gerencia Financiera';
                            break;
                        case "1-4":
                            echo 'Confidencial';
                            break;
                        case "1-5":
                            echo 'Otros';
                            break;
                        default : echo 'Error al recuperar el cargo';
                    }
                    ?>
                </td>
            </tr>
            <tr><td><strong>Estado</strong></td><td><?php echo $fila['Estado']; ?></td></tr>
        </tbody>
  </table>
</div>
<div class="container-fluid">
    <div class="container-flat-form">
        <div class="title-flat-form title-flat-blue">Gestión de carpeta</div>
        <div class="row">
            <div class="col-xs-6">
                <h2 class="text-center all-tittles"><i class="zmdi zmdi-refresh"></i> &nbsp; actualizar datos</h2>
                <p class="text-center">
                    <?php 
                        $checkLoanBook=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoLibro='".$fila['CodigoLibro']."' AND Estado='Prestamo'");
                        $checkLoanBook1=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoLibro='".$fila['CodigoLibro']."' AND Estado='Reservacion'");
                        if(mysqli_num_rows($checkLoanBook)<=0 && mysqli_num_rows($checkLoanBook1)<=0){
                            echo '<button class="btn btn-success btn-update" data-code="'.$codeBook.'" data-url="./process/SelectDataBook.php"><i class="zmdi zmdi-refresh"></i> &nbsp;&nbsp; Actualizar datos de carpeta</button>';
                        }else{
                            echo '<button disabled="disabled" class="btn btn-success"><i class="zmdi zmdi-refresh"></i> &nbsp;&nbsp; Actualizar datos de carpeta</button>';
                        }
                        mysqli_free_result($checkLoanBook);
                        mysqli_free_result($checkLoanBook1);
                    ?>
                </p>
            </div>
            <div class="col-xs-6">
                <h2 class="text-center all-tittles"><i class="zmdi zmdi-delete"></i> &nbsp; eliminar datos</h2>
                <?php 
                    $checkLoanBook2=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoLibro='".$fila['CodigoLibro']."'");
                        if(mysqli_num_rows($checkLoanBook2)<=0){
                            echo '<form action="process/DeleteBook.php" method="post" class="form_SRCB" data-type-form="delete"><input value="'.$fila["CodigoLibro"].'" type="hidden" name="primaryKey"><p class="text-center"><button type="submit" class="btn btn-danger"><i class="zmdi zmdi-delete"></i> &nbsp;&nbsp; Eliminar Carpeta</button></p></form>';
                        }else{
                            echo '<p class="text-center"><button disabled="disabled" class="btn btn-danger"><i class="zmdi zmdi-delete"></i> &nbsp;&nbsp; Eliminar Carpeta</button></p>';
                        }
                    mysqli_free_result($checkLoanBook2);
                ?>
            </div>
        </div>
    </div>
</div>   