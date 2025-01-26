<?php 
require_once("model/address.php");
?> 
<label for="idRoute">Seleccione una Ruta</label> <span class="obligatorio">*</span>
<span class="help-icon" data-tooltip="Solo puede seleccionar una Ruta por oferta de viaje. &#10;Debe tener la ruta de viaje añadida previamente."><?php echo HELP_ICON; ?></span>
<div class="errorMessage" id="errorMessageidRoute"></div>

    <div class="vertical-scroll">
        <?php
        if (count($dataToView["data"]) > 0) { ?>
        <table id="routeTableT" class="custom-table" style="width:100%">
            <thead>
                <tr>
                    <th>Lugar</th>
                    <th>Parroquia</th>
                    <th>Estado</th>
                    <th>Seleccionar</th>
                </tr>
            </thead>
            <tbody>
                <?php
             
                    foreach ($dataToView["data"] as $data) {
                        $aux = $address->getDependence($data['idParroquia']);
                        $parroquia = $aux[0]['parroquia'] ?? '';
                        $estado = $aux[0]['estado'] ?? '';
                ?>
                <tr>
                    <td><?php echo $data['place']; ?></td>
                    <td><?php echo $parroquia; ?></td>
                    <td><?php echo $estado; ?></td>
                    
                    <td>
                    <div class="flex-items">
                        <input class="radio-input" type="radio" id="idRoute" name="idRoute" title="Seleccione una ruta de viaje" value="<?php echo $data['idRoute']; ?>">
                    </div>
                    </td>
                </tr>

             <?php } ?>
                           
             </tbody>
            </table>
            <?php
                } else { 
                ?>
                   <p class="errorMessage">Actualmente No Hay Rutas Disponibles.</p>
                
        <?php } ?>

</div>


