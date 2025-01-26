
<label for="idTravelOffer">Seleccione Oferta de Viaje</label> <span class="obligatorio">*</span>
<span class="help-icon" data-tooltip="Solo puede seleccionar un viaje por bitácora. &#10;"><?php echo HELP_ICON; ?></span>
<div class="errorMessage" id="errorMessageidTravelOffer"></div>
<div class="bottom-data">
    <div class="vertical-scroll">
        
        <div class="errorMessage" id="errorMessageidTravelOffer"></div>
    
        <table id="tripTable" class="custom-table" style="width:100%">
            <thead>
                <tr>
                  
                    <th>Título</th>
                    <th>Destino</th>
                    
                  
                    <th>Fecha de salida</th>
                    <th>Seleccionar</th>
                    
                </tr>
            </thead>
          <tbody>
            <?php if (count($dataToView["data"]) > 0) 
                    { foreach ($dataToView["data"] as $data) { ?>
            <tr>
            
                
                <td><?php echo $data['titleTrip']; ?></td>
                <td><?php echo $data['place']; ?></td> 
                
                
                <td><?php echo date("d/m/Y", strtotime($data['departureDate']))?></td>
                <td>
                <div class="flex-items">
                            <input class="radio-input" 
                                type="radio" id="travelOffer<?php echo $data['idTraveloffer']; ?>" 
                                name="idTravelOffer" title="Seleccione una oferta de viaje" 
                                value="<?php echo $data['idTraveloffer']; ?>">
                            
                        </div>
                </td>
            </tr>
            <?php }} ?>
                
          </tbody>
        </table>
    </div>

</div>