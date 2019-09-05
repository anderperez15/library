<div class="table-responsive">
    <table class="table table-hover table-bordered text-center">
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
			<tr><td><strong>Nombre de Carpeta</strong></td><td><?php echo $fila['Titulo']; ?></td></tr>
            <tr><td><strong>Dirección</strong></td><td><?php echo $fila['Autor']; ?></td></tr>
            <tr><td><strong>Código de Referencia</strong></td><td><?php echo $fila['Pais']; ?></td></tr>
            <tr><td><strong>Año</strong></td><td><?php echo $fila['Year']; ?></td></tr>
            <tr><td><strong>Creado por</strong></td><td><?php echo $fila['Editorial']; ?></td></tr>
        </tbody>
  </table>
</div>