<?php 
require_once("controller/packages.php");  
$packages = new packagesController;
$dataToView['data'] = $packages->list();

?>  
<section>
    <label for="idPackages">Seleccione el Paquete de Viaje</label><span class="obligatorio">*</span>
    <span class="help-icon" data-tooltip="Puede seleccionar más de un paquete segun lo que ofrecera el viaje,  &#10;El precio del paquete y del viaje se mostraran como uno solo para el usuario.  &#10;Debe tener los paquetes de viaje añadidos previamente."><?php echo HELP_ICON; ?></span>
    <div class="errorMessage" id="errorMessageidPackages"></div>

        <div  class="vertical-scroll">

        <?php if(count($dataToView["data"]) > 0) { ?>

            <table id="packgesTableT"   class="custom-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Precio (<?php echo MONETARY_UNIT ?>)</th>
                        <th>Seleccionar</th>
                    </tr>
                </thead>
                <tbody>
                  
                        <?php foreach($dataToView["data"] as $data) { ?>
                            <tr>
                                <td><?php echo $data['title']; ?></td>
                                <td><?php echo $data['price']; ?></td>
                                <td>
                                    <div class="flex-items">
                                        <input class="radio-input" 
                                            type="checkbox" id="package<?php echo $data['idPackages']; ?>" 
                                            name="idPackages[]" title="Seleccione un paquete de viaje" 
                                            value="<?php echo $data['idPackages']; ?>">
                                    </div>
                                </td>
                        <?php } ?>
                    </tbody>
                </table>
                    <?php } else { ?>    
                            <p class="errorMessage">Actualmente No Hay Paquetes Disponibles.</p>      
            <?php } ?>
        </div>

</section>



