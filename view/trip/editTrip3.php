<?php 
require_once("controller/packages.php");  
$packages= new packagesController;
$row2['data'] = $packages->list();

$idpackString = $_GET['idpack'];
// Dividimos la cadena en un array de números
$idpackArray = explode('<br><br>', $idpackString);
?>  
<section>
    <label for="idPackages">Seleccione su Paquete de Viaje</label><span class="obligatorio">*</span>
    <span class="help-icon" data-tooltip="Puede seleccionar más de un paquete segun lo que ofrecera el viaje,  &#10;El precio del paquete y del viaje se mostraran como uno solo para el usuario.  &#10;Debe tener los paquetes de viaje añadidos previamente."><?php echo HELP_ICON; ?></span>
    <div class="errorMessage" id="errorMessageidPackages"></div>

        <div class="vertical-scroll">
            <table id="packgesTableT"  class="custom-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Precio (<?php echo MONETARY_UNIT ?>)</th>
                        <th>Seleccionar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($row2['data']) > 0) { ?>
                        <?php foreach($row2['data'] as $data) { ?>
                            <tr>
                                <td><?php echo $data['title']; ?></td>
                                <td><?php echo $data['price']; ?></td>
                                <td>
                                    <div class="flex-items">
                                    <input class="radio-input"
                                           type="checkbox" 
                                           id="package<?php echo htmlspecialchars($data['idPackages']); ?>" 
                                           name="idPackages[]" 
                                           title="Seleccione un paquete de viaje" 
                                           value="<?php echo htmlspecialchars($data['idPackages'], ENT_QUOTES, 'UTF-8'); ?>"
                                           <?php if (in_array($data['idPackages'], $idpackArray)) echo 'checked'; ?>>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="7">Actualmente No Hay Paquetes Disponibles.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
    </div>
</section>

