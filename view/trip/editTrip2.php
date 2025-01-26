<?php 
// Este segmento es para elegir la Ruta en el Formulario de añadir viaje
require_once("model/route.php");
$route = new route;
$row = $route->getRoutesByStatus(1);
?>
<label for="idRoute">Seleccione una Ruta</label> <span class="obligatorio">*</span>
<span class="help-icon" data-tooltip="Solo puede seleccionar una Ruta por oferta de viaje. &#10;Debe tener la ruta de viaje añadida previamente."><?php echo HELP_ICON; ?></span>

<div class="errorMessage" id="errorMessageidRoute"></div>

<div class="vertical-scroll">
    <table id="routeTableT" class="custom-table" style="width:100%">
        <thead>
            <tr>
                <th>Lugar</th>
                <th class="menos">Parroquia</th>
                <th class="menos">Estado</th>
                <th>Seleccionar</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($row) > 0) {?>
                <?php foreach ($row as $data) { ?>
                    <tr>
                        <td><?php echo $data['place']; ?></td>
                        <td class="menos"><?php echo $data['parroquia']; ?></td>
                        <td class="menos"><?php echo $data['estado']; ?></td>
                        <td>
                        <div class="flex-items">
                            <input class="radio-input" type="radio" id="idRoute" name="idRoute" title="Seleccione una ruta de viaje" value="<?php echo $data['idRoute']; ?>" <?php if ($dataToView['data']['idRoute'] === $data['idRoute']) echo 'checked'; ?>>
                        </div>
                        </td>
                    </tr>
                <?php }?>
        </tbody>
    </table>
          <?php  } else { ?>        
                    <p  class="errorMessage">Actualmente No Hay Rutas Disponibles.</p>
            <?php } ?>
    
</div>
