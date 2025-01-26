
<label for="images">Seleccione una o varias imagenes</label>
<span class="help-icon" data-tooltip="Seleccione una o varias imágenes que desea eliminar&#10;aprentando en cima de la imagen. Recuerde que debe &#10;mantener al menos una imagen seleccionada."><?php echo HELP_ICON; ?></span>

<div class="errorMessage" id="errorMessageidRoute"></div>

<div class="bottom-data">
    <div class="vertical-scroll">

        <h3>Imágenes Asociadas</h3>
        <div id="currentImages">
            <?php if (!empty($dataToView['data']['images'])) { ?>
                <?php foreach ($dataToView['data']['images'] as $image) { ?>
                    <div class="image-container" style="display: inline-block; margin: 10px; position: relative;">
                        <img src="<?php echo htmlspecialchars($image['imageUrl']); ?>" alt="Imagen" style="width:80px; height:120px; border-radius:4px;" class="image-checkbox" data-id="<?php echo htmlspecialchars($image['idImage']); ?>">
                        <input type="checkbox" name="UpdateImage[]" value="<?php echo htmlspecialchars($image['idImage']); ?>" class="image-checkbox-input" style="display:none;">
                        <span class="check-icon" style="display:none;">
                            <svg class="bx" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16"><path fill="currentColor" d="M2 5v10c0 .55.45 1 1 1h9c.55 0 1-.45 1-1V5zm3 9H4V7h1zm2 0H6V7h1zm2 0H8V7h1zm2 0h-1V7h1zm2.25-12H10V.75A.753.753 0 0 0 9.25 0h-3.5A.753.753 0 0 0 5 .75V2H1.75a.75.75 0 0 0-.75.75V4h13V2.75a.75.75 0 0 0-.75-.75M9 2H6v-.987h3z"/></svg>
                        </span> <!-- Icono de check -->
                        <div style="text-align: center; font-size: 12px; margin-top: 5px;">
                            ID: <?php echo htmlspecialchars($image['idImage']); ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No hay imágenes asociadas.</p>
            <?php } ?>
        </div>

        <!-- Campo para subir nuevas imágenes -->
        <label>Imágenes</label><span class="obligatorio">*</span><span class="help-icon" data-tooltip="Formato de imagen permitidas: .jfif, .jpeg, .jpg, .png"><?php echo HELP_ICON; ?></span>
        <label class="custom-file-upload" for="images">Examinar</label>
        <div class="errorMessage" id="errorMessageimage"></div>
        <input type="file" title="Seleccione una Imagen"
               name="images[]" id="images" multiple accept=".jfif,.jpg,.jpeg,.png">

        <p>Vista previa:</p>
        <div id="imagePreviewContainer">
            <!-- Las imágenes se mostrarán aquí -->
        </div>

    </div>
</div>


<script src="asset/js/scripts/weblogImage.js"></script>

